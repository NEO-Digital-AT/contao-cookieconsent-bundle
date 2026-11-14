<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Backend;

use Contao\Backend;
use Contao\BackendUser;
use Contao\Config;
use Contao\CoreBundle\Intl\Locales;
use Contao\DataContainer;
use Contao\Date;
use Contao\Message;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Catalog\ServiceTemplate;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Scan\Scanner;
use Symfony\Bundle\SecurityBundle\Security;

/** Callbacks of the services (tl_neo_cookieconsent_service). */
final class ServiceCallbacks
{
    private const TABLE = 'tl_neo_cookieconsent_service';

    public function __construct(
        private readonly ServiceCatalog $catalog,
        private readonly Settings $settings,
        private readonly Texts $texts,
        private readonly Connection $db,
        private readonly Security $security,
        private readonly Locales $locales,
        private readonly RequestInput $input,
    ) {
    }

    /** Notes above the list: banner switched off, no privacy page, unknown hosts from the scan. */
    public function notes(): void
    {
        if ('' !== (string) $this->input->query('act')) {
            return;
        }

        $lang = $GLOBALS['TL_LANG'][self::TABLE];

        if (!$this->settings->flag('active')) {
            Message::addError($lang['note_inactive'] ?? '');
        }

        if ((int) $this->settings->get('privacy_page') <= 0) {
            Message::addInfo($lang['note_privacy'] ?? '');
        }

        $unknown = (int) $this->db->fetchOne('SELECT COUNT(*) FROM '.Scanner::FINDINGS." WHERE status IN ('unknown', 'new') AND template = ''");

        if ($unknown > 0) {
            Message::addInfo(sprintf($lang['note_unknown'] ?? '%s', $unknown));
        }
    }

    /**
     * Fields as the record needs them: with a template its values show as
     * placeholders, the ID field only when the extension loads the service,
     * own code only for administrators and only without a template.
     */
    public function palette(DataContainer|null $dc = null): void
    {
        if (null === $dc || !$dc->id || 'edit' !== $this->input->query('act')) {
            return;
        }

        if (\count($this->siteLanguages()) < 2) {
            $GLOBALS['TL_DCA'][self::TABLE]['palettes']['default'] = str_replace('{languages_legend},translation_fields;', '', $GLOBALS['TL_DCA'][self::TABLE]['palettes']['default']);
        }

        $row = $this->db->fetchAssociative('SELECT template, loading FROM '.self::TABLE.' WHERE id = ?', [(int) $dc->id]);

        if (false === $row) {
            return;
        }

        $dca = &$GLOBALS['TL_DCA'][self::TABLE];
        $lang = &$GLOBALS['TL_LANG'][self::TABLE];
        $template = $this->catalog->get((string) ($this->input->post('template') ?? $row['template']));
        $user = $this->security->getUser();
        $admin = $user instanceof BackendUser && $user->isAdmin;

        if (null === $template) {
            $dca['subpalettes']['loading_extension'] = $admin ? 'code' : '';

            return;
        }

        // The hosts of a template are known.
        $dca['palettes']['default'] = str_replace('hosts,', '', $dca['palettes']['default']);

        if ($template->canLoad()) {
            $dca['subpalettes']['loading_extension'] = 'tracking_id'.($template->needsUrl ? ',tracking_url' : '').($template->linker ? ',linker_domains' : '');
            $dca['fields']['tracking_id']['eval']['placeholder'] = $template->idExample;
            $dca['fields']['tracking_id']['label'] = [$lang['tracking_id'][0] ?? '', sprintf($lang['tracking_id_help'] ?? '%s', $template->idExample)];
        } else {
            // The extension cannot load it: the page does, the extension holds it back.
            $dca['palettes']['default'] = str_replace(',loading;', ';', $dca['palettes']['default']);
        }

        $language = $GLOBALS['TL_LANGUAGE'] ?? 'en';
        $dca['fields']['provider']['eval']['placeholder'] = '@self' === $template->provider ? $this->texts->trans('provider.self', $language) : $template->provider;
        $dca['fields']['privacy_url']['eval']['placeholder'] = $template->privacyUrl;
        $dca['fields']['purpose']['eval']['placeholder'] = $this->texts->trans('purpose.'.$template->purpose, $language);
        $dca['fields']['transfer']['eval']['blankOptionLabel'] = sprintf($lang['from_template'] ?? '%s', '' !== $template->transfer ? ($lang['transfer_options'][$template->transfer] ?? $template->transfer) : ($lang['transfer_none'] ?? '-'));

        $cookies = [];

        foreach ($template->cookies as $name => $duration) {
            $cookies[] = $name.' ('.$this->texts->duration($duration, $language).')';
        }

        $dca['fields']['cookies']['label'] = [
            $lang['cookies'][0] ?? '',
            sprintf($lang['cookies_template'] ?? '%s', [] !== $cookies ? implode(', ', $cookies) : ($lang['cookies_none'] ?? '-')),
        ];
    }

    /** @return array<string, array<string, string>> */
    public function templateOptions(): array
    {
        $labels = $GLOBALS['TL_LANG'][self::TABLE]['category_options'] ?? [];
        $options = [];

        foreach ($this->catalog->grouped() as $category => $names) {
            foreach ($names as $key => $name) {
                $names[$key] = $this->templateName($key, $name);
            }

            $options[$labels[$category] ?? $category] = $names;
        }

        return $options;
    }

    /** Choosing a template fills name, category and how the service loads. */
    public function applyTemplate(mixed $value, DataContainer $dc): string
    {
        $template = $this->catalog->get((string) $value);
        $before = (string) $this->db->fetchOne('SELECT template FROM '.self::TABLE.' WHERE id = ?', [(int) $dc->id]);

        if (null !== $template && $before !== $template->key) {
            if ('' === trim((string) $this->input->post('title'))) {
                $this->input->setPost('title', 'ai-chat' === $template->key ? $this->texts->trans('name.ai-chat', $GLOBALS['TL_LANGUAGE'] ?? 'en') : $template->name);
            }

            $this->input->setPost('category', $template->category);
            $this->input->setPost('loading', $template->canLoad() ? 'extension' : 'page');
        }

        return (string) $value;
    }

    /** The ID must have the form the service uses; the extension builds its code from it. */
    public function checkId(mixed $value, DataContainer $dc): string
    {
        $value = trim((string) $value);
        $template = $this->catalog->get((string) ($this->input->post('template') ?? ($dc->getCurrentRecord() ?? [])['template'] ?? ''));

        if (null === $template || !$template->canLoad() || 'extension' !== (string) ($this->input->post('loading') ?? ($dc->getCurrentRecord() ?? [])['loading'] ?? '')) {
            return $value;
        }

        $lang = $GLOBALS['TL_LANG'][self::TABLE];

        if ('' === $value || !$template->validId($value)) {
            throw new \RuntimeException(sprintf($lang['id_invalid'] ?? '%s', $template->idExample));
        }

        if ($template->needsUrl && !preg_match('#^https://#', trim((string) $this->input->post('tracking_url')))) {
            throw new \RuntimeException($lang['url_required'] ?? '');
        }

        return $value;
    }

    /**
     * Domains for cross-domain measurement: each line must be a domain name
     * (scheme and path are removed); empty lines are dropped.
     */
    public function checkLinkerDomains(mixed $value): string|null
    {
        $lines = array_values(array_filter(
            array_map(static fn ($line): string => trim((string) $line), StringUtil::deserialize($value, true)),
            static fn (string $line): bool => '' !== $line,
        ));

        if ([] === $lines) {
            return null;
        }

        $valid = ServiceTemplate::validDomains($lines);

        if (\count($valid) < \count(array_unique(array_map('strtolower', $lines)))) {
            throw new \RuntimeException($GLOBALS['TL_LANG'][self::TABLE]['linker_invalid'] ?? '');
        }

        return serialize($valid);
    }

    /** @return array<int, string> */
    public function rootOptions(): array
    {
        $options = [];

        foreach ($this->db->fetchAllAssociative("SELECT id, title, dns, language FROM tl_page WHERE type = 'root' ORDER BY sorting") as $root) {
            $options[(int) $root['id']] = trim($root['title'].' '.('' !== $root['dns'] ? '('.$root['dns'].')' : '['.$root['language'].']'));
        }

        return $options;
    }

    /** @param array<string, mixed> $row */
    public function label(array $row, string $label): string
    {
        $lang = $GLOBALS['TL_LANG'][self::TABLE];
        $template = $this->catalog->get((string) $row['template']);
        $notes = [];

        $notes[] = null !== $template ? $this->templateName($template->key, $template->name) : ($lang['own_service'] ?? '');
        $notes[] = $lang['loading_options'][(string) $row['loading']] ?? '';

        if ('' !== (string) $row['tracking_id']) {
            $notes[] = (string) $row['tracking_id'];
        }

        if ('scan' === (string) $row['source']) {
            $notes[] = sprintf($lang['found_by_scan'] ?? '%s', Date::parse(Config::get('dateFormat'), (int) $row['found_at']));
        }

        $warning = '';

        if ('extension' === (string) $row['loading'] && null !== $template && $template->canLoad() && !$template->validId((string) $row['tracking_id'])) {
            $warning = ' <span style="color:#c33">'.StringUtil::specialchars($lang['id_missing'] ?? '').'</span>';
        }

        return sprintf(
            '<strong>%s</strong> <span style="color:#6a6a6a;padding-left:6px">%s</span>%s',
            StringUtil::specialchars((string) $row['title']),
            StringUtil::specialchars(implode(' · ', array_filter($notes))),
            $warning,
        );
    }

    public function foundInfo(DataContainer $dc): string
    {
        $row = $this->db->fetchAssociative('SELECT source, found_at, found_url FROM '.self::TABLE.' WHERE id = ?', [(int) $dc->id]);

        if (false === $row || 'scan' !== $row['source']) {
            return '';
        }

        return sprintf(
            '<div class="widget clr"><p class="tl_help tl_tip" style="margin:6px 0">%s</p></div>',
            StringUtil::specialchars(sprintf($GLOBALS['TL_LANG'][self::TABLE]['found_text'] ?? '%s %s', Date::parse(Config::get('datimFormat'), (int) $row['found_at']), (string) $row['found_url'])),
        );
    }

    /** Names of the catalogue are proper names; only the AI chat has a translated one. */
    private function templateName(string $key, string $name): string
    {
        return 'ai-chat' === $key ? $this->texts->trans('name.ai-chat', $GLOBALS['TL_LANGUAGE'] ?? 'en') : $name;
    }

    /**
     * Name and purpose per language of the websites. Empty = the name and
     * purpose above, or the text of the template in that language.
     */
    public function translationFields(DataContainer $dc): string
    {
        $languages = $this->siteLanguages();

        if (\count($languages) < 2) {
            return '';
        }

        $lang = $GLOBALS['TL_LANG'][self::TABLE];
        $row = $this->db->fetchAssociative('SELECT title, purpose, template, translations FROM '.self::TABLE.' WHERE id = ?', [(int) $dc->id]) ?: [];
        $stored = StringUtil::deserialize($row['translations'] ?? null, true);
        $template = $this->catalog->get((string) ($row['template'] ?? ''));
        $html = '';

        foreach ($languages as $code => $name) {
            $title = (string) ($stored[$code]['title'] ?? '');
            $purpose = (string) ($stored[$code]['purpose'] ?? '');
            $titleHint = null !== $template && 'ai-chat' === $template->key ? $this->texts->trans('name.ai-chat', $code) : (string) ($row['title'] ?? '');
            $purposeHint = trim((string) ($row['purpose'] ?? '')) ?: (null !== $template ? $this->texts->trans('purpose.'.$template->purpose, $code) : '');

            $html .= sprintf(
                '<div class="w50 clr widget"><h3><label for="ncc_tr_%1$s_title">%2$s</label></h3><input type="text" name="ncc_tr[%1$s][title]" id="ncc_tr_%1$s_title" class="tl_text" maxlength="128" value="%3$s" placeholder="%4$s"></div>'
                .'<div class="clr widget"><h3><label for="ncc_tr_%1$s_purpose">%5$s</label></h3><textarea name="ncc_tr[%1$s][purpose]" id="ncc_tr_%1$s_purpose" class="tl_textarea" rows="1" cols="80" maxlength="1000" data-controller="contao--textarea-autogrow" placeholder="%6$s">%7$s</textarea></div>',
                $code,
                StringUtil::specialchars(sprintf($lang['tr_title'] ?? '%s', $name)),
                StringUtil::specialchars($title),
                StringUtil::specialchars($titleHint),
                StringUtil::specialchars(sprintf($lang['tr_purpose'] ?? '%s', $name)),
                StringUtil::specialchars($purposeHint),
                StringUtil::specialchars($purpose),
            );
        }

        return sprintf('<div class="clr"><p class="tl_help tl_tip" style="margin:6px 0 0">%s</p>%s</div>', StringUtil::specialchars($lang['tr_help'] ?? ''), $html);
    }

    /** onsubmit: stores the names and purposes per language of the form above. */
    public function saveTranslations(DataContainer $dc): void
    {
        $posted = $this->input->post('ncc_tr');

        if (!\is_array($posted)) {
            return;
        }

        $languages = $this->siteLanguages();
        $translations = [];

        foreach ($posted as $code => $texts) {
            if (!isset($languages[(string) $code]) || !\is_array($texts)) {
                continue;
            }

            $title = mb_substr(trim(strip_tags(html_entity_decode((string) ($texts['title'] ?? ''), ENT_QUOTES))), 0, 128);
            $purpose = mb_substr(trim(strip_tags(html_entity_decode((string) ($texts['purpose'] ?? ''), ENT_QUOTES))), 0, 1000);

            if ('' !== $title || '' !== $purpose) {
                $translations[(string) $code] = ['title' => $title, 'purpose' => $purpose];
            }
        }

        $this->db->update(self::TABLE, ['translations' => [] === $translations ? null : serialize($translations)], ['id' => (int) $dc->id]);
    }

    /**
     * Languages of the websites (root pages), primary codes with their names.
     *
     * @return array<string, string>
     */
    private function siteLanguages(): array
    {
        $names = $this->locales->getLanguages();
        $languages = [];

        foreach ($this->db->fetchFirstColumn("SELECT DISTINCT language FROM tl_page WHERE type = 'root' ORDER BY language") as $language) {
            $code = Texts::primary((string) $language);
            $languages[$code] ??= (string) ($names[$code] ?? strtoupper($code));
        }

        return $languages;
    }

    public static function backToList(): string
    {
        return Backend::addToUrl('table='.self::TABLE, true, ['act', 'id', 'key']);
    }
}
