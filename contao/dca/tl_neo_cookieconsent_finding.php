<?php

declare(strict_types=1);

use Contao\DataContainer;
use Contao\DC_Table;
use Neo\CookieconsentBundle\Backend\FindingCallbacks;

/*
 * tl_neo_cookieconsent_finding — what the scan found in the pages: services of
 * the catalogue (added to the services automatically) and scripts or iframes
 * of other hosts. An unknown host can be turned into a service ("Add as
 * service") or ignored; an ignored finding is never added again.
 */
$GLOBALS['TL_DCA']['tl_neo_cookieconsent_finding'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'closed' => true,
        'notEditable' => false,
        'notCopyable' => true,
        'onload_callback' => [[FindingCallbacks::class, 'notes']],
        'sql' => ['keys' => ['id' => 'primary', 'finding_key' => 'unique']],
    ],

    'list' => [
        'sorting' => [
            'mode' => DataContainer::MODE_SORTED,
            'fields' => ['status', 'last_seen'],
            'flag' => DataContainer::SORT_ASC,
            'panelLayout' => 'filter;search,limit',
        ],
        'label' => [
            'fields' => ['finding_key', 'pages', 'last_seen'],
            'showColumns' => true,
            'label_callback' => [FindingCallbacks::class, 'label'],
        ],
        'global_operations' => [
            // The class draws Contao's back icon; an own icon would show a second arrow.
            'back_to_services' => ['href' => 'table=tl_neo_cookieconsent_service', 'class' => 'header_back', 'primary' => true],
            'scan' => ['href' => 'key=scan', 'icon' => 'sync.svg', 'class' => 'header_scan', 'primary' => true],
        ],
        'operations' => [
            'adopt' => ['href' => 'key=adopt', 'icon' => 'new.svg', 'button_callback' => [FindingCallbacks::class, 'adoptButton']],
            'edit' => ['href' => 'act=edit', 'icon' => 'edit.svg'],
            'delete' => ['href' => 'act=delete', 'icon' => 'delete.svg', 'attributes' => 'onclick="Backend.getScrollOffset()"'],
        ],
    ],

    'palettes' => [
        'default' => '{finding_legend},details,status',
    ],

    'fields' => [
        'id' => ['sql' => 'int(10) unsigned NOT NULL auto_increment'],
        'tstamp' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'finding_key' => ['search' => true, 'sql' => "varchar(160) NOT NULL default ''"],
        'template' => ['sql' => "varchar(40) NOT NULL default ''"],
        'host' => ['search' => true, 'sql' => "varchar(160) NOT NULL default ''"],
        'tracking_id' => ['sql' => "varchar(128) NOT NULL default ''"],
        'url' => ['sql' => "varchar(1024) NOT NULL default ''"],
        'pages' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'unblocked' => ['sql' => "char(1) NOT NULL default ''"],
        'first_seen' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'last_seen' => ['flag' => DataContainer::SORT_DAY_DESC, 'sql' => 'int(10) unsigned NOT NULL default 0'],
        'details' => ['input_field_callback' => [FindingCallbacks::class, 'details']],
        'status' => [
            'inputType' => 'select',
            'filter' => true,
            'options' => ['new', 'added', 'listed', 'unknown', 'ignored'],
            'reference' => &$GLOBALS['TL_LANG']['tl_neo_cookieconsent_finding']['status_options'],
            'eval' => ['tl_class' => 'w50'],
            'sql' => "varchar(8) NOT NULL default 'new'",
        ],
    ],
];
