<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Backend;

use Contao\Config;
use Contao\DataContainer;
use Contao\Date;
use Contao\System;

/** List of the proof of consent (tl_neo_cookieconsent_log). */
final class LogCallbacks
{
    /**
     * @param array<string, mixed> $row
     * @param list<string>         $args
     *
     * @return list<string>
     */
    public function label(array $row, string $label, DataContainer $dc, array $args): array
    {
        System::loadLanguageFile('tl_neo_cookieconsent_service');
        $lang = $GLOBALS['TL_LANG']['tl_neo_cookieconsent_log'];
        $cats = $GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] ?? [];

        $args[0] = Date::parse(Config::get('datimFormat'), (int) $row['tstamp']);
        $args[2] = $lang['action_options'][(string) $row['action']] ?? (string) $row['action'];
        $chosen = array_filter(explode(',', (string) $row['categories']));
        $args[3] = [] !== $chosen ? implode(', ', array_map(static fn (string $c): string => $cats[$c] ?? $c, $chosen)) : ($lang['only_necessary'] ?? '-');

        if ('' !== (string) $row['services']) {
            $args[3] .= ' + '.str_replace(',', ', ', (string) $row['services']);
        }

        return $args;
    }
}
