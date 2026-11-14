<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Backend;

use Contao\Backend;
use Contao\Message;
use Contao\System;
use Neo\CookieconsentBundle\Scan\ScanResult;
use Neo\CookieconsentBundle\Scan\Scanner;

/** key=scan: runs the scan now and returns to the scan results. */
final class ScanOperation
{
    public function __construct(private readonly Scanner $scanner)
    {
    }

    public function __invoke(): void
    {
        self::report($this->scanner->run());
        Backend::redirect(Backend::addToUrl('table=tl_neo_cookieconsent_finding', true, ['key', 'act', 'id']));
    }

    public static function report(ScanResult $result): void
    {
        System::loadLanguageFile('tl_neo_cookieconsent_settings');
        $lang = $GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings'];

        Message::addConfirmation(sprintf($lang['scan_done'] ?? '%s %s', System::getFormattedNumber($result->pages, 0), System::getFormattedNumber($result->found, 0)));

        if ([] !== $result->added) {
            Message::addInfo(sprintf($lang['scan_added'] ?? '%s', implode(', ', $result->added)));
        }

        if ([] !== $result->unknown) {
            Message::addInfo(sprintf($lang['scan_unknown'] ?? '%s', implode(', ', $result->unknown)));
        }

        if ([] !== $result->errors) {
            Message::addError(sprintf($lang['scan_errors'] ?? '%s', implode('; ', \array_slice($result->errors, 0, 5))));
        }
    }
}
