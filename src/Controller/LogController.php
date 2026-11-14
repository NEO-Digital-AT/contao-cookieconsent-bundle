<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Controller;

use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\Settings;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;

/**
 * Proof of consent: the consent script reports every choice. Stored are a
 * random consent ID, time, version, website, action and the chosen categories
 * and services; no IP address, no browser details. Same origin only, at most
 * 30 requests per minute per address (the address is only hashed for the
 * limit and not stored).
 */
final class LogController
{
    public const TABLE = 'tl_neo_cookieconsent_log';
    private const ACTIONS = ['accept', 'necessary', 'save', 'embed'];

    private readonly RateLimiterFactory $limiter;

    public function __construct(
        private readonly Connection $db,
        private readonly Settings $settings,
        CacheItemPoolInterface $cache,
    ) {
        $this->limiter = new RateLimiterFactory(['id' => 'neo_cookieconsent_log', 'policy' => 'sliding_window', 'limit' => 30, 'interval' => '1 minute'], new CacheStorage($cache));
    }

    public function __invoke(Request $request): Response
    {
        if (!$this->settings->flag('log')) {
            return new JsonResponse(['ok' => false], 404);
        }

        $origin = (string) $request->headers->get('Origin', '');

        if ('' !== $origin && parse_url($origin, PHP_URL_HOST) !== $request->getHost()) {
            return new JsonResponse(['ok' => false], 403);
        }

        if (!$this->limiter->create(hash('sha256', (string) $request->getClientIp()))->consume(1)->isAccepted()) {
            return new JsonResponse(['ok' => false], 429);
        }

        $data = json_decode((string) $request->getContent(), true);

        if (!\is_array($data)) {
            return new JsonResponse(['ok' => false], 400);
        }

        $id = (string) ($data['id'] ?? '');
        $action = (string) ($data['action'] ?? '');

        if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/', $id) || !\in_array($action, self::ACTIONS, true)) {
            return new JsonResponse(['ok' => false], 400);
        }

        $cats = array_values(array_intersect(ServiceCatalog::CATEGORIES, array_map('strval', (array) ($data['cats'] ?? []))));
        $svc = array_values(array_filter(array_map('strval', (array) ($data['svc'] ?? [])), static fn (string $k): bool => 1 === preg_match('/^[a-z0-9-]{1,40}$/', $k)));

        $this->db->insert(self::TABLE, [
            'tstamp' => time(),
            'consent_id' => $id,
            'version' => max(0, (int) ($data['v'] ?? 0)),
            'root' => max(0, (int) ($data['root'] ?? 0)),
            'action' => $action,
            'categories' => implode(',', $cats),
            'services' => mb_substr(implode(',', \array_slice($svc, 0, 40)), 0, 1024),
        ]);

        return new JsonResponse(['ok' => true]);
    }
}
