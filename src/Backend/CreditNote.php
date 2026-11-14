<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Backend;

use Contao\StringUtil;

/**
 * The condition of the free licence, the same in every free extension of the
 * family: first block of the form (legend "Licence"), the condition, then the
 * credit as text with link and as HTML for the source code of the legal
 * notice. The link carries rel="nofollow": the credit is a condition of the
 * licence, not an editorial link.
 */
final class CreditNote
{
    public const URL = 'https://neo-digital.at';
    private const NAME = 'NEO Digital';

    /** The note from the texts of a back-end table: <prefix>text, example_label, html_label, example. */
    public static function forTable(string $table, string $prefix = 'licence_'): string
    {
        $lang = $GLOBALS['TL_LANG'][$table] ?? [];

        return self::render(
            (string) ($lang[$prefix.'text'] ?? ''),
            (string) ($lang[$prefix.'example_label'] ?? ''),
            (string) ($lang[$prefix.'html_label'] ?? ''),
            (string) ($lang[$prefix.'example'] ?? ''),
        );
    }

    public static function render(string $text, string $textLabel, string $htmlLabel, string $example): string
    {
        $html = self::html($example);
        $box = 'margin:0 0 10px;padding:8px 10px;border:1px solid var(--border, #ddd);border-radius:4px;user-select:all';

        return sprintf(
            '<div class="widget clr"><p class="tl_info" style="margin:0 0 10px">%s</p><p style="margin:0 0 4px">%s</p><p style="%s">%s</p><p style="margin:0 0 4px">%s</p><pre style="white-space:pre-wrap;%s">%s</pre></div>',
            StringUtil::specialchars($text),
            StringUtil::specialchars($textLabel),
            $box,
            str_replace(' rel="nofollow"', ' rel="nofollow noopener" target="_blank" style="text-decoration:underline"', $html),
            StringUtil::specialchars($htmlLabel),
            $box,
            StringUtil::specialchars($html),
        );
    }

    /** The credit with "NEO Digital" as link (appended when the text does not name it). */
    public static function html(string $example): string
    {
        $escaped = StringUtil::specialchars($example);
        $link = '<a href="'.self::URL.'" rel="nofollow">'.self::NAME.'</a>';

        return str_contains($example, self::NAME)
            ? (string) preg_replace('/'.preg_quote(self::NAME, '/').'/', $link, $escaped, 1)
            : $escaped.' – '.$link;
    }
}
