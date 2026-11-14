<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Consent;

use Doctrine\DBAL\Connection;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Texts for visitors in the language of the page: the record of that language
 * in the back end (tl_neo_cookieconsent_text), empty fields filled with the
 * defaults of the translations (eleven languages, English otherwise).
 */
final class Texts
{
    public const TABLE = 'tl_neo_cookieconsent_text';
    public const DOMAIN = 'neo_cookieconsent';

    /** Fields of a language record, in the order of the form. */
    public const KEYS = [
        'banner_title', 'banner_text', 'settings_title', 'settings_text',
        'btn_accept', 'btn_necessary', 'btn_settings', 'btn_save', 'btn_back',
        'cat_necessary', 'cat_necessary_desc', 'cat_functional', 'cat_functional_desc',
        'cat_statistics', 'cat_statistics_desc', 'cat_marketing', 'cat_marketing_desc',
        'embed_text', 'embed_load', 'embed_always', 'reopen', 'link_privacy', 'link_imprint',
        'services_toggle', 'consent_id',
    ];

    public const LANGUAGES = ['en', 'de', 'fr', 'nl', 'it', 'pl', 'cs', 'hu', 'sl', 'hr', 'es'];

    /** @var array<string, array<string, string>> */
    private array $cache = [];

    public function __construct(
        private readonly Connection $db,
        private readonly TranslatorInterface $translator,
    ) {
    }

    /** @return array<string, string> */
    public function forLanguage(string $language): array
    {
        $language = self::primary($language);

        if (isset($this->cache[$language])) {
            return $this->cache[$language];
        }

        try {
            $row = $this->db->fetchAssociative('SELECT * FROM '.self::TABLE.' WHERE language = ? AND tstamp > 0 ORDER BY id LIMIT 1', [$language]);
        } catch (\Throwable) {
            $row = false;
        }

        $texts = [];

        foreach (self::KEYS as $key) {
            $own = \is_array($row) ? trim((string) ($row[$key] ?? '')) : '';
            $texts[$key] = '' !== $own ? $own : $this->default($key, $language);
        }

        return $this->cache[$language] = $texts;
    }

    /**
     * Pages of the privacy policy and the legal notice chosen for a language
     * (0 = use the pages of the settings).
     *
     * @return array{privacy: int, imprint: int}
     */
    public function pages(string $language): array
    {
        try {
            $row = $this->db->fetchAssociative('SELECT privacy_page, imprint_page FROM '.self::TABLE.' WHERE language = ? AND tstamp > 0 ORDER BY id LIMIT 1', [self::primary($language)]);
        } catch (\Throwable) {
            $row = false;
        }

        return ['privacy' => (int) ($row['privacy_page'] ?? 0), 'imprint' => (int) ($row['imprint_page'] ?? 0)];
    }

    public function default(string $key, string $language): string
    {
        return $this->trans('text.'.$key, $language);
    }

    /** A text of the translations (purpose.*, duration.*, transfer.*, provider.*, list.*). */
    public function trans(string $id, string $language): string
    {
        $locale = \in_array(self::primary($language), self::LANGUAGES, true) ? self::primary($language) : 'en';
        $text = $this->translator->trans($id, [], self::DOMAIN, $locale);

        return $text !== $id ? $text : $this->translator->trans($id, [], self::DOMAIN, 'en');
    }

    /** Duration of a cookie: a code of the catalogue in words, anything else as entered. */
    public function duration(string $value, string $language): string
    {
        if (preg_match('/^(session|local|15min|30min|1d|30d|90d|6m|13m|1y|2y)$/', $value)) {
            return $this->trans('duration.'.$value, $language);
        }

        return $value;
    }

    public static function primary(string $language): string
    {
        return strtolower(substr(str_replace('_', '-', $language), 0, 2)) ?: 'en';
    }
}
