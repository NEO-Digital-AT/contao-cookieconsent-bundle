<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Backend;

use Contao\Backend;
use Contao\Message;
use Contao\System;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Cache\PageCacheTags;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceFactory;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

/**
 * key=add_service&template=<key>[&category=<category>]&rt=<request token>: lists
 * a service of the catalogue and opens it, for a link of another extension.
 * The AI chat links here when its consent category has no service, because
 * visitors could never consent to it otherwise. A template that is listed
 * already (published or not) is opened instead of being added twice. The
 * request token makes sure the link came from the back end itself.
 */
final class AddServiceOperation
{
    private const CATEGORIES = ['functional', 'statistics', 'marketing'];

    public function __construct(
        private readonly ServiceCatalog $catalog,
        private readonly ServiceFactory $factory,
        private readonly Connection $db,
        private readonly RequestInput $input,
        private readonly UrlGeneratorInterface $router,
        private readonly PageCacheTags $cacheTags,
    ) {
    }

    public function __invoke(): void
    {
        System::loadLanguageFile(ServiceRepository::TABLE);
        $lang = $GLOBALS['TL_LANG'][ServiceRepository::TABLE];
        $container = System::getContainer();
        $tokens = $container->get('contao.csrf.token_manager');
        $template = $this->catalog->get((string) $this->input->query('template'));
        // The token values differ on every call (Symfony randomises them): checked, not compared.
        $token = new CsrfToken((string) $container->getParameter('contao.csrf_token_name'), (string) $this->input->query('rt'));

        if (null === $template || !$tokens->isTokenValid($token)) {
            Backend::redirect($this->router->generate('contao_backend', ['do' => 'neo_cookieconsent']));
        }

        $existing = $this->db->fetchOne('SELECT id FROM '.ServiceRepository::TABLE.' WHERE template = ? AND tstamp > 0 ORDER BY id LIMIT 1', [$template->key]);

        if (false !== $existing) {
            Message::addInfo($lang['add_exists'] ?? '');
            $this->open((int) $existing, $tokens->getDefaultTokenValue());
        }

        $category = (string) $this->input->query('category');
        $id = $this->factory->create(
            $template,
            \in_array($category, self::CATEGORIES, true) ? $category : $template->category,
            [],
            (string) ($GLOBALS['TL_LANGUAGE'] ?? 'en'),
        );

        // Cached pages must ask for the new service.
        $this->cacheTags->invalidate(['contao.db.'.ServiceRepository::TABLE]);
        Message::addConfirmation($lang['add_done'] ?? '');
        $this->open($id, $tokens->getDefaultTokenValue());
    }

    private function open(int $id, string $token): never
    {
        Backend::redirect($this->router->generate('contao_backend', ['do' => 'neo_cookieconsent', 'act' => 'edit', 'id' => $id, 'rt' => $token]));
    }
}
