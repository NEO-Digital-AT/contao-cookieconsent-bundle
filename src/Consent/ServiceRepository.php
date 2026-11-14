<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Consent;

use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;

/**
 * The services of the back end (tl_neo_cookieconsent_service), resolved
 * against their templates.
 */
final class ServiceRepository
{
    public const TABLE = 'tl_neo_cookieconsent_service';

    /** @var list<array<string, mixed>>|null */
    private array|null $rows = null;

    public function __construct(
        private readonly Connection $db,
        private readonly ServiceCatalog $catalog,
    ) {
    }

    /**
     * Published services for a website (root page); 0 = all websites.
     *
     * @return list<Service>
     */
    public function forRoot(int $root): array
    {
        $services = [];

        foreach ($this->rows() as $row) {
            $roots = array_map('intval', StringUtil::deserialize($row['roots'] ?? null, true));

            if ($root > 0 && [] !== $roots && !\in_array($root, $roots, true)) {
                continue;
            }

            $services[] = $this->resolve($row);
        }

        return $services;
    }

    /**
     * Template keys and categories of the listed services, for the blocking:
     * a template the back end lists under "necessary" is never blocked.
     *
     * @return array<string, string> template key => category
     */
    public function templateCategories(int $root): array
    {
        $map = [];

        foreach ($this->forRoot($root) as $service) {
            if (null !== $service->template) {
                $map[$service->template->key] = $service->category;
            }
        }

        return $map;
    }

    /** Fingerprint of everything a visitor reads about the services (VersionKeeper). */
    public function fingerprint(): string
    {
        $parts = [];

        foreach ($this->rows() as $row) {
            $parts[] = implode('|', [
                $row['template'], $row['category'], $row['title'], $row['provider'], $row['purpose'],
                $row['transfer'], (string) ($row['roots'] ?? ''), (string) ($row['translations'] ?? ''),
            ]);
        }

        sort($parts);

        return hash('sha256', implode("\n", $parts));
    }

    /** Whether a template is listed already (published or not). */
    public function hasTemplate(string $key): bool
    {
        return false !== $this->db->fetchOne('SELECT id FROM '.self::TABLE.' WHERE template = ? AND tstamp > 0', [$key]);
    }

    public function reset(): void
    {
        $this->rows = null;
    }

    /** @param array<string, mixed> $row */
    public function resolve(array $row): Service
    {
        $template = $this->catalog->get((string) $row['template']);
        $cookies = [];

        foreach (StringUtil::deserialize($row['cookies'] ?? null, true) as $pair) {
            if (\is_array($pair) && '' !== trim((string) ($pair['key'] ?? ''))) {
                $cookies[trim((string) $pair['key'])] = trim((string) ($pair['value'] ?? ''));
            }
        }

        if ([] === $cookies && null !== $template) {
            $cookies = $template->cookies;
        }

        $loader = '';

        if ('extension' === (string) $row['loading']) {
            $loader = null !== $template
                ? $template->loaderFor(trim((string) $row['tracking_id']), trim((string) $row['tracking_url']), array_map('strval', StringUtil::deserialize($row['linker_domains'] ?? null, true)))
                : (string) $row['code'];
        }

        $hosts = [];

        foreach (StringUtil::deserialize($row['hosts'] ?? null, true) as $host) {
            $host = strtolower(trim((string) $host));
            $host = preg_replace('#^https?://#', '', $host) ?? '';
            $host = explode('/', $host)[0];

            if (preg_match('#^[a-z0-9.-]+\.[a-z]{2,}$#', $host)) {
                $hosts[] = $host;
            }
        }

        $translations = [];

        foreach (StringUtil::deserialize($row['translations'] ?? null, true) as $language => $texts) {
            if (\is_array($texts) && preg_match('/^[a-z]{2}$/', (string) $language)) {
                $translations[(string) $language] = ['title' => trim((string) ($texts['title'] ?? '')), 'purpose' => trim((string) ($texts['purpose'] ?? ''))];
            }
        }

        return new Service(
            (int) $row['id'],
            null !== $template ? $template->key : 'c'.(int) $row['id'],
            trim((string) $row['title']) ?: ($template?->name ?? ''),
            (string) $row['category'] ?: ($template?->category ?? 'functional'),
            trim((string) $row['provider']) ?: ($template?->provider ?? ''),
            trim((string) $row['purpose']),
            $template?->purpose ?? '',
            (string) $row['transfer'] ?: ($template?->transfer ?? ''),
            trim((string) $row['privacy_url']) ?: ($template?->privacyUrl ?? ''),
            $cookies,
            $loader,
            $hosts,
            $template,
            $translations,
        );
    }

    /** @return list<array<string, mixed>> */
    private function rows(): array
    {
        if (null === $this->rows) {
            try {
                $this->rows = $this->db->fetchAllAssociative('SELECT * FROM '.self::TABLE." WHERE published = '1' AND tstamp > 0 ORDER BY sorting, title");
            } catch (\Throwable) {
                $this->rows = [];
            }
        }

        return $this->rows;
    }
}
