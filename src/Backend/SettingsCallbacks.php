<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Backend;

use Contao\Backend;
use Contao\Config;
use Contao\DataContainer;
use Contao\Date;
use Contao\StringUtil;
use Contao\System;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\VersionKeeper;
use Neo\CookieconsentBundle\Scan\Scanner;

/** Callbacks of the settings record (tl_neo_cookieconsent_settings). */
final class SettingsCallbacks
{
    private const TABLE = 'tl_neo_cookieconsent_settings';

    public function __construct(
        private readonly Settings $settings,
        private readonly VersionKeeper $version,
        private readonly Scanner $scanner,
        private readonly ServiceRepository $services,
        private readonly RequestInput $input,
    ) {
    }

    /**
     * Settings without effect are disabled, with the reason at the field (FieldLock); the
     * stored values stay. "Show the banner" and "Store consents" reload the form.
     */
    public function lock(): void
    {
        $lang = $GLOBALS['TL_LANG'][self::TABLE] ?? [];

        if (!$this->settings->flag('active')) {
            foreach (['show_on', 'position', 'overlay', 'reopen', 'privacy_page', 'imprint_page', 'block_scripts', 'block_embeds', 'consent_mode', 'log', 'log_days'] as $field) {
                FieldLock::lock(self::TABLE, $field, $lang['locked_active'] ?? '');
            }

            return;
        }

        if (!$this->settings->flag('log')) {
            FieldLock::lock(self::TABLE, 'log_days', $lang['locked_log'] ?? '');
        }

        $google = array_filter($this->services->forRoot(0), static fn ($service): bool => (bool) $service->template?->google);

        if ([] === $google) {
            FieldLock::lock(self::TABLE, 'consent_mode', $lang['locked_consent_mode'] ?? '');
        }
    }

    /**
     * One record only. The button "Settings" opens the form without an id; the id of the record is
     * added. The list is no page of its own: Contao's "Go back" and the breadcrumb lead to it, so it
     * goes on to the services, the start of the module.
     */
    public function openRecord(): void
    {
        $act = (string) $this->input->query('act');

        if ('' === $act && '' === (string) $this->input->query('key')) {
            Backend::redirect(Backend::addToUrl('', true, ['table', 'id']));
        }

        if ('edit' === $act && '' === (string) $this->input->query('id')) {
            Backend::redirect(Backend::addToUrl('id='.$this->settings->ensureRow()));
        }
    }

    /** "Scan now" in the form. */
    public function submit(DataContainer $dc): void
    {
        if ('1' !== $this->input->post('ncc_scan_now') || 'auto' === $this->input->post('SUBMIT_TYPE')) {
            return;
        }

        ScanOperation::report($this->scanner->run());
    }

    /** The condition of the free licence, with an example (and its HTML) for the legal notice. */
    public function licenceNote(): string
    {
        return CreditNote::forTable(self::TABLE);
    }

    /** Shows the address the mail goes to when the field stays empty. */
    public function mailPlaceholder(mixed $value): mixed
    {
        $admin = trim((string) Config::get('adminEmail'));

        if ('' !== $admin) {
            $GLOBALS['TL_DCA'][self::TABLE]['fields']['scan_mail']['eval']['placeholder'] = $admin;
        }

        return $value;
    }

    public function scanNow(): string
    {
        $lang = $GLOBALS['TL_LANG'][self::TABLE];
        $note = json_decode((string) $this->settings->get('last_scan_note'), true);
        $state = (int) $this->settings->get('last_scan') > 0 && \is_array($note)
            ? sprintf(
                $lang['scan_last'] ?? '%s %s %s %s',
                Date::parse(Config::get('datimFormat'), (int) $this->settings->get('last_scan')),
                System::getFormattedNumber((int) ($note['pages'] ?? 0), 0),
                System::getFormattedNumber((int) ($note['found'] ?? 0), 0),
                System::getFormattedNumber(\count((array) ($note['added'] ?? [])), 0),
            )
            : ($lang['scan_never'] ?? '');

        // The button first, its result right below it (data-neo-action, Basic's actions.js), then the last scan.
        return sprintf(
            '<div class="widget clr"><p style="margin:8px 0"><button type="submit" name="ncc_scan_now" value="1" class="tl_submit" data-neo-action>%s</button> <a href="%s">%s</a></p><p class="tl_help tl_tip" style="margin:6px 0">%s</p></div>',
            StringUtil::specialchars($lang['scan_button'] ?? 'Scan'),
            StringUtil::specialchars(Backend::addToUrl('table=tl_neo_cookieconsent_finding', true, ['act', 'id'])),
            StringUtil::specialchars($lang['scan_results'] ?? ''),
            StringUtil::specialchars($state),
        );
    }

    public function versionInfo(): string
    {
        $lang = $GLOBALS['TL_LANG'][self::TABLE];
        $version = $this->version->current();

        return sprintf(
            '<div class="widget clr"><p class="tl_help tl_tip" style="margin:6px 0">%s</p></div>',
            StringUtil::specialchars(sprintf($lang['version_text'] ?? '%s %s', $version, Date::parse(Config::get('datimFormat'), (int) $this->settings->get('version_at') ?: time()))),
        );
    }
}
