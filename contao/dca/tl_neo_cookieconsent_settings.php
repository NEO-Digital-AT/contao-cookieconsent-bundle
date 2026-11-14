<?php

declare(strict_types=1);

use Contao\DataContainer;
use Contao\DC_Table;
use Neo\CookieconsentBundle\Backend\SettingsCallbacks;

/*
 * tl_neo_cookieconsent_settings — the one settings record: banner, blocking,
 * proof of consent and scan. The list is skipped; the button "Settings" above
 * the services opens the form directly, the list leads back to the services. The first block names the condition
 * of the free licence (a mention in the legal notice) with a text to copy.
 */
$GLOBALS['TL_DCA']['tl_neo_cookieconsent_settings'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => true,
        'notCreatable' => true,
        'notCopyable' => true,
        'notDeletable' => true,
        // One record, named like its button in the breadcrumb (BreadcrumbListener of the Basic bundle).
        'neoSingleRecord' => true,
        'onload_callback' => [
            [SettingsCallbacks::class, 'openRecord'],
            // Settings without effect because of another one: disabled, the reason at the field.
            [SettingsCallbacks::class, 'lock'],
        ],
        'onsubmit_callback' => [[SettingsCallbacks::class, 'submit']],
        'sql' => ['keys' => ['id' => 'primary']],
    ],

    'list' => [
        'sorting' => ['mode' => DataContainer::MODE_UNSORTED],
        'label' => ['fields' => ['id'], 'format' => '%s'],
        'operations' => [
            'edit' => ['href' => 'act=edit', 'icon' => 'edit.svg'],
        ],
    ],

    'palettes' => [
        'default' => '{licence_legend},licence_note;'
            .'{banner_legend},active,show_on,position,overlay,reopen,privacy_page,imprint_page;'
            .'{blocking_legend},block_scripts,block_embeds,consent_mode;'
            .'{proof_legend},log,log_days;'
            .'{scan_legend},scan,scan_limit,scan_mail,scan_now;'
            .'{version_legend},version_info',
    ],

    'fields' => [
        'id' => ['sql' => 'int(10) unsigned NOT NULL auto_increment'],
        'tstamp' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'licence_note' => ['input_field_callback' => [SettingsCallbacks::class, 'licenceNote']],
        'active' => [
            'inputType' => 'checkbox',
            // submitOnChange: other settings depend on it (SettingsCallbacks::lock()).
            'eval' => ['submitOnChange' => true, 'tl_class' => 'w50 m12'],
            'sql' => "char(1) NOT NULL default '1'",
        ],
        'show_on' => [
            'inputType' => 'select',
            'options' => ['immediately', 'scroll'],
            'reference' => &$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'],
            'eval' => ['tl_class' => 'w50 clr'],
            'sql' => "varchar(16) NOT NULL default 'immediately'",
        ],
        'position' => [
            'inputType' => 'select',
            'options' => ['bottom', 'top', 'center', 'left', 'right'],
            'reference' => &$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'],
            'eval' => ['tl_class' => 'w50'],
            'sql' => "varchar(8) NOT NULL default 'bottom'",
        ],
        'overlay' => [
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50 m12'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'reopen' => [
            'inputType' => 'select',
            'options' => ['left', 'right', 'none'],
            'reference' => &$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'],
            'eval' => ['tl_class' => 'w50'],
            'sql' => "varchar(8) NOT NULL default 'left'",
        ],
        'privacy_page' => [
            'inputType' => 'pageTree',
            'eval' => ['fieldType' => 'radio', 'tl_class' => 'w50 clr'],
            'sql' => 'int(10) unsigned NOT NULL default 0',
        ],
        'imprint_page' => [
            'inputType' => 'pageTree',
            'eval' => ['fieldType' => 'radio', 'tl_class' => 'w50'],
            'sql' => 'int(10) unsigned NOT NULL default 0',
        ],
        'block_scripts' => [
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default '1'",
        ],
        'block_embeds' => [
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default '1'",
        ],
        'consent_mode' => [
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50 clr'],
            'sql' => "char(1) NOT NULL default '1'",
        ],
        'log' => [
            'inputType' => 'checkbox',
            // submitOnChange: other settings depend on it (SettingsCallbacks::lock()).
            'eval' => ['submitOnChange' => true, 'tl_class' => 'w50 m12'],
            'sql' => "char(1) NOT NULL default '1'",
        ],
        'log_days' => [
            'inputType' => 'select',
            'options' => [365, 730, 1095, 1825],
            'reference' => &$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'],
            'eval' => ['tl_class' => 'w50'],
            'sql' => 'smallint(5) unsigned NOT NULL default 1095',
        ],
        'scan' => [
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50 m12'],
            'sql' => "char(1) NOT NULL default '1'",
        ],
        'scan_limit' => [
            'inputType' => 'select',
            'options' => [10, 25, 50, 100],
            'eval' => ['tl_class' => 'w50'],
            'sql' => 'smallint(5) unsigned NOT NULL default 25',
        ],
        'scan_mail' => [
            'inputType' => 'text',
            'eval' => ['rgxp' => 'email', 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50 clr'],
            'load_callback' => [[SettingsCallbacks::class, 'mailPlaceholder']],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'scan_now' => ['input_field_callback' => [SettingsCallbacks::class, 'scanNow']],
        'version_info' => ['input_field_callback' => [SettingsCallbacks::class, 'versionInfo']],
        'version' => ['sql' => 'int(10) unsigned NOT NULL default 1'],
        'version_hash' => ['sql' => "varchar(64) NOT NULL default ''"],
        'version_at' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'last_scan' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'last_scan_note' => ['sql' => 'text NULL'],
    ],
];
