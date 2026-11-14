<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Backend;

use Contao\Backend;
use Contao\Config;
use Contao\CoreBundle\DataContainer\DataContainerOperation;
use Contao\DataContainer;
use Contao\Date;
use Contao\Message;
use Contao\StringUtil;
use Contao\System;
use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Scan\Scanner;

/** Callbacks of the scan results (tl_neo_cookieconsent_finding). */
final class FindingCallbacks
{
    private const TABLE = 'tl_neo_cookieconsent_finding';

    public function __construct(
        private readonly ServiceCatalog $catalog,
        private readonly Settings $settings,
        private readonly Connection $db,
        private readonly Texts $texts,
        private readonly RequestInput $input,
    ) {
    }

    /** The last scan above the list. */
    public function notes(): void
    {
        if ('' !== (string) $this->input->query('act')) {
            return;
        }

        $lang = $GLOBALS['TL_LANG'][self::TABLE];

        if ((int) $this->settings->get('last_scan') <= 0) {
            Message::addInfo($lang['never'] ?? '');

            return;
        }

        $note = json_decode((string) $this->settings->get('last_scan_note'), true);
        Message::addInfo(sprintf(
            $lang['last'] ?? '%s %s',
            Date::parse(Config::get('datimFormat'), (int) $this->settings->get('last_scan')),
            System::getFormattedNumber((int) ($note['pages'] ?? 0), 0),
        ));
    }

    /**
     * @param array<string, mixed> $row
     * @param list<string>         $args
     *
     * @return list<string>
     */
    public function label(array $row, string $label, DataContainer $dc, array $args): array
    {
        $lang = $GLOBALS['TL_LANG'][self::TABLE];
        $template = $this->catalog->get((string) $row['template']);
        $name = null !== $template ? $this->name($template->key, $template->name) : (string) $row['host'];
        $warning = '1' === (string) $row['unblocked'] && !\in_array((string) $row['status'], ['ignored', 'added', 'listed'], true)
            ? ' <span style="color:#c33;padding-left:6px">'.StringUtil::specialchars($lang['unblocked'] ?? '').'</span>'
            : '';

        $args[0] = sprintf('<strong>%s</strong>%s', StringUtil::specialchars($name), $warning);
        $args[1] = System::getFormattedNumber((int) $row['pages'], 0);
        $args[2] = Date::parse(Config::get('datimFormat'), (int) $row['last_seen']);

        return $args;
    }

    public function details(DataContainer $dc): string
    {
        $row = $this->db->fetchAssociative('SELECT * FROM '.self::TABLE.' WHERE id = ?', [(int) $dc->id]);

        if (false === $row) {
            return '';
        }

        $lang = $GLOBALS['TL_LANG'][self::TABLE];
        $template = $this->catalog->get((string) $row['template']);
        $lines = [
            [$lang['col_service'] ?? '', null !== $template ? $this->name($template->key, $template->name) : (string) $row['host']],
            [$lang['col_id'] ?? '', (string) $row['tracking_id'] ?: '-'],
            [$lang['col_page'] ?? '', (string) $row['url']],
            [$lang['col_pages'] ?? '', System::getFormattedNumber((int) $row['pages'], 0)],
            [$lang['col_first'] ?? '', Date::parse(Config::get('datimFormat'), (int) $row['first_seen'])],
            [$lang['col_last'] ?? '', Date::parse(Config::get('datimFormat'), (int) $row['last_seen'])],
        ];

        $html = '';

        foreach ($lines as [$k, $v]) {
            $html .= sprintf('<tr><th style="text-align:left;padding:4px 12px 4px 0">%s</th><td style="padding:4px 0;overflow-wrap:anywhere">%s</td></tr>', StringUtil::specialchars($k), StringUtil::specialchars($v));
        }

        $warning = '1' === (string) $row['unblocked'] ? sprintf('<p class="tl_error">%s</p>', StringUtil::specialchars($lang['unblocked_help'] ?? '')) : '';

        return sprintf('<div class="widget clr">%s<table>%s</table></div>', $warning, $html);
    }

    private function name(string $key, string $name): string
    {
        return 'ai-chat' === $key ? $this->texts->trans('name.ai-chat', $GLOBALS['TL_LANGUAGE'] ?? 'en') : $name;
    }

    /** "Add as service" only for hosts the catalogue does not know. */
    public function adoptButton(DataContainerOperation $operation): void
    {
        $row = $operation->getRecord();

        if (null === $row || '' !== (string) $row['template'] || \in_array((string) $row['status'], ['listed', 'added', 'ignored'], true)) {
            $operation->setHtml(''); // hide() exists from Contao 5.6 on
        }
    }

    /** key=adopt: a service for an unknown host, held back until consent; opens it for editing. */
    public function adopt(): void
    {
        $row = $this->db->fetchAssociative('SELECT * FROM '.self::TABLE.' WHERE id = ?', [(int) $this->input->query('id')]);

        if (false === $row || '' === (string) $row['host']) {
            Backend::redirect(Backend::addToUrl('', true, ['key', 'id']));
        }

        $this->db->insert(ServiceRepository::TABLE, [
            'tstamp' => time(),
            'sorting' => 128 + (int) $this->db->fetchOne('SELECT MAX(sorting) FROM '.ServiceRepository::TABLE),
            'published' => '',
            'title' => (string) $row['host'],
            'loading' => 'page',
            'category' => 'marketing',
            'hosts' => serialize([(string) $row['host']]),
            'source' => 'scan',
            'found_at' => (int) $row['first_seen'],
            'found_url' => (string) $row['url'],
        ]);
        $id = (int) $this->db->lastInsertId();
        $this->db->update(self::TABLE, ['status' => 'listed'], ['id' => (int) $row['id']]);

        Message::addInfo($GLOBALS['TL_LANG'][self::TABLE]['adopted'] ?? '');
        Backend::redirect(Backend::addToUrl('table='.ServiceRepository::TABLE.'&act=edit&id='.$id, true, ['key', 'id', 'table', 'act']));
    }
}
