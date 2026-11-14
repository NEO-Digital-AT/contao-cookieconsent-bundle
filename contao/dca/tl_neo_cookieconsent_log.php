<?php

declare(strict_types=1);

use Contao\DataContainer;
use Contao\DC_Table;
use Neo\CookieconsentBundle\Backend\LogCallbacks;

/*
 * tl_neo_cookieconsent_log — proof of consent: one entry per choice of a
 * visitor (random consent ID, time, version, website, action, categories and
 * services). No IP address, no browser details. Read only; deleted after the
 * period set in the settings.
 */
$GLOBALS['TL_DCA']['tl_neo_cookieconsent_log'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'closed' => true,
        'notEditable' => true,
        'notCopyable' => true,
        'notDeletable' => true,
        'sql' => ['keys' => ['id' => 'primary', 'consent_id' => 'index', 'tstamp' => 'index']],
    ],

    'list' => [
        'sorting' => [
            'mode' => DataContainer::MODE_SORTED,
            'fields' => ['tstamp'],
            'flag' => DataContainer::SORT_DAY_DESC,
            'panelLayout' => 'filter;search,limit',
        ],
        'label' => [
            'fields' => ['tstamp', 'consent_id', 'action', 'categories', 'version'],
            'showColumns' => true,
            'label_callback' => [LogCallbacks::class, 'label'],
        ],
        'global_operations' => [
            // The class draws Contao's back icon; an own icon would show a second arrow.
            'back_to_services' => ['href' => 'table=tl_neo_cookieconsent_service', 'class' => 'header_back', 'primary' => true],
        ],
        'operations' => [
            'show' => ['href' => 'act=show', 'icon' => 'show.svg'],
        ],
    ],

    'fields' => [
        'id' => ['sql' => 'int(10) unsigned NOT NULL auto_increment'],
        'tstamp' => ['flag' => DataContainer::SORT_DAY_DESC, 'sql' => 'int(10) unsigned NOT NULL default 0'],
        'consent_id' => ['search' => true, 'sql' => "varchar(36) NOT NULL default ''"],
        'version' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'root' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'action' => [
            'filter' => true,
            'reference' => &$GLOBALS['TL_LANG']['tl_neo_cookieconsent_log']['action_options'],
            'sql' => "varchar(16) NOT NULL default ''",
        ],
        'categories' => ['sql' => "varchar(64) NOT NULL default ''"],
        'services' => ['sql' => "varchar(1024) NOT NULL default ''"],
    ],
];
