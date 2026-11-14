<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Backend;

use Contao\CoreBundle\Intl\Locales;
use Contao\DataContainer;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Consent\Texts;

/** Callbacks of the texts per language (tl_neo_cookieconsent_text). */
final class TextCallbacks
{
    private const TABLE = 'tl_neo_cookieconsent_text';

    public function __construct(
        private readonly Texts $texts,
        private readonly Locales $locales,
        private readonly Connection $db,
        private readonly RequestInput $input,
    ) {
    }

    /**
     * Languages of the websites first, then every language Contao knows.
     *
     * @return array<string, string>
     */
    public function languages(DataContainer|null $dc = null): array
    {
        $all = [];

        foreach ($this->locales->getLanguages() as $id => $name) {
            $code = Texts::primary((string) $id);
            $all[$code] ??= $name;
        }

        $options = [];

        foreach ($this->db->fetchFirstColumn("SELECT DISTINCT language FROM tl_page WHERE type = 'root'") as $language) {
            $code = Texts::primary((string) $language);
            $options[$code] = $all[$code] ?? strtoupper($code);
        }

        $stored = Texts::primary((string) ($dc?->value ?? ''));

        if ('' !== $stored && !isset($options[$stored])) {
            $options[$stored] = $all[$stored] ?? strtoupper($stored);
        }

        return $options + $all;
    }

    /** Every empty field shows the default text of the language of the record. */
    public function placeholders(DataContainer|null $dc = null): void
    {
        if (null === $dc || !$dc->id || 'edit' !== $this->input->query('act')) {
            return;
        }

        $language = (string) ($this->input->post('language') ?: $this->db->fetchOne('SELECT language FROM '.self::TABLE.' WHERE id = ?', [(int) $dc->id]));
        $language = '' !== $language ? $language : (string) ($GLOBALS['TL_LANGUAGE'] ?? 'en');

        foreach (Texts::KEYS as $key) {
            $GLOBALS['TL_DCA'][self::TABLE]['fields'][$key]['eval']['placeholder'] = $this->texts->default($key, $language);
        }
    }

    /** @param array<string, mixed> $row */
    public function label(array $row, string $label): string
    {
        $names = $this->languages();
        $title = trim((string) $row['banner_title']);

        return sprintf(
            '<strong>%s</strong> <span style="color:#6a6a6a;padding-left:6px">%s</span>',
            StringUtil::specialchars($names[(string) $row['language']] ?? (string) $row['language']),
            StringUtil::specialchars('' !== $title ? $title : ($GLOBALS['TL_LANG'][self::TABLE]['defaults_only'] ?? '')),
        );
    }
}
