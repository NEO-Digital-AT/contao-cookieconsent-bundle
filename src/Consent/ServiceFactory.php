<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Consent;

use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Catalog\ServiceTemplate;

/**
 * Lists a service of the catalogue in the back end, published: used by the
 * scan for what it finds and by the operation "add_service", with which
 * another extension (an AI chat that asks for consent itself) has its service
 * added from a link.
 */
final class ServiceFactory
{
    public function __construct(
        private readonly Connection $db,
        private readonly Texts $texts,
    ) {
    }

    /**
     * @param list<int>            $roots    websites it applies to; [] = all websites
     * @param array<string, mixed> $columns  further columns (source, found_at, tracking_id …)
     *
     * @return int ID of the new service
     */
    public function create(ServiceTemplate $template, string $category, array $roots, string $language, array $columns = []): int
    {
        $translations = [];

        // The only template without a proper name: its name in every language of the websites.
        if ('ai-chat' === $template->key) {
            foreach ($this->db->fetchFirstColumn("SELECT DISTINCT language FROM tl_page WHERE type = 'root'") as $code) {
                $code = Texts::primary((string) $code);
                $translations[$code] = ['title' => $this->texts->trans('name.ai-chat', $code), 'purpose' => ''];
            }
        }

        $this->db->insert(ServiceRepository::TABLE, $columns + [
            'tstamp' => time(),
            'sorting' => 128 + (int) $this->db->fetchOne('SELECT MAX(sorting) FROM '.ServiceRepository::TABLE),
            'published' => '1',
            'title' => $this->name($template, $language),
            'template' => $template->key,
            'loading' => 'page',
            'category' => $category,
            'roots' => [] === $roots ? null : serialize(array_map('strval', $roots)),
            'translations' => \count($translations) > 1 ? serialize($translations) : null,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function name(ServiceTemplate $template, string $language): string
    {
        return 'ai-chat' === $template->key ? $this->texts->trans('name.ai-chat', $language) : $template->name;
    }
}
