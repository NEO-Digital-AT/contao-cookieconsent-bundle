<?php

declare(strict_types=1);

use Contao\DataContainer;
use Contao\DC_Table;
use Neo\CookieconsentBundle\Backend\ServiceCallbacks;

/*
 * tl_neo_cookieconsent_service — the services the banner asks consent for.
 * A template of the catalogue fills provider, purpose, cookies, transfer and
 * the privacy link; the extension loads a service itself (with its ID or own
 * code) or the page loads it and the extension only holds it back until
 * consent. The daily scan adds services it finds (source "scan").
 */
$GLOBALS['TL_DCA']['tl_neo_cookieconsent_service'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => true,
        'onload_callback' => [
            [ServiceCallbacks::class, 'notes'],
            [ServiceCallbacks::class, 'palette'],
        ],
        'onsubmit_callback' => [[ServiceCallbacks::class, 'saveTranslations']],
        'sql' => ['keys' => ['id' => 'primary', 'template' => 'index']],
    ],

    'list' => [
        'sorting' => [
            'mode' => DataContainer::MODE_SORTED,
            'fields' => ['category', 'title'],
            'flag' => DataContainer::SORT_ASC,
            'panelLayout' => 'filter;search,limit',
        ],
        'label' => [
            'fields' => ['title', 'category'],
            'format' => '%s',
            'label_callback' => [ServiceCallbacks::class, 'label'],
        ],
        'global_operations' => [
            'settings' => ['href' => 'table=tl_neo_cookieconsent_settings&act=edit', 'icon' => 'settings.svg', 'class' => 'header_settings', 'primary' => true],
            'texts' => ['href' => 'table=tl_neo_cookieconsent_text', 'icon' => 'article.svg', 'class' => 'header_texts', 'primary' => true],
            'findings' => ['href' => 'table=tl_neo_cookieconsent_finding', 'icon' => 'magnify.svg', 'class' => 'header_findings', 'primary' => true],
            'log' => ['href' => 'table=tl_neo_cookieconsent_log', 'icon' => 'diff.svg', 'class' => 'header_log', 'primary' => true],
        ],
        'operations' => [
            'edit' => ['href' => 'act=edit', 'icon' => 'edit.svg'],
            'copy' => ['href' => 'act=copy', 'icon' => 'copy.svg'],
            'toggle' => ['href' => 'act=toggle&amp;field=published', 'icon' => 'visible.svg'],
            'delete' => ['href' => 'act=delete', 'icon' => 'delete.svg', 'attributes' => 'onclick="Backend.getScrollOffset()"'],
            'show' => ['href' => 'act=show', 'icon' => 'show.svg'],
        ],
    ],

    'palettes' => [
        '__selector__' => ['loading'],
        // ServiceCallbacks::palette() leaves out what the chosen template fills in.
        'default' => '{service_legend},template,title,category,loading;'
            .'{details_legend},provider,purpose,transfer,privacy_url,cookies;'
            // Name and purpose per language of the websites (only with more than one language).
            .'{languages_legend},translation_fields;'
            .'{scope_legend:hide},hosts,roots;'
            .'{publish_legend},published,found_info',
    ],

    'subpalettes' => [
        'loading_extension' => 'tracking_id,tracking_url,code',
    ],

    'fields' => [
        'id' => ['sql' => 'int(10) unsigned NOT NULL auto_increment'],
        'tstamp' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'sorting' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'template' => [
            'inputType' => 'select',
            'filter' => true,
            'options_callback' => [ServiceCallbacks::class, 'templateOptions'],
            'eval' => ['includeBlankOption' => true, 'chosen' => true, 'submitOnChange' => true, 'tl_class' => 'w50'],
            'save_callback' => [[ServiceCallbacks::class, 'applyTemplate']],
            'sql' => "varchar(40) NOT NULL default ''",
        ],
        'title' => [
            'inputType' => 'text',
            'search' => true,
            'eval' => ['mandatory' => true, 'maxlength' => 128, 'tl_class' => 'w50'],
            'sql' => "varchar(128) NOT NULL default ''",
        ],
        'category' => [
            'inputType' => 'select',
            'filter' => true,
            'options' => ['necessary', 'functional', 'statistics', 'marketing'],
            'reference' => &$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'],
            'eval' => ['mandatory' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(16) NOT NULL default 'functional'",
        ],
        'loading' => [
            'inputType' => 'select',
            'filter' => true,
            'options' => ['page', 'extension'],
            'reference' => &$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'],
            'eval' => ['submitOnChange' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(16) NOT NULL default 'page'",
        ],
        'tracking_id' => [
            'inputType' => 'text',
            'eval' => ['maxlength' => 128, 'decodeEntities' => true, 'tl_class' => 'w50 clr'],
            'save_callback' => [[ServiceCallbacks::class, 'checkId']],
            'sql' => "varchar(128) NOT NULL default ''",
        ],
        // Google tag only: further domains of the same owner for cross-domain measurement.
        'linker_domains' => [
            'inputType' => 'listWizard',
            'eval' => ['decodeEntities' => true, 'tl_class' => 'clr'],
            'save_callback' => [[ServiceCallbacks::class, 'checkLinkerDomains']],
            'sql' => 'blob NULL',
        ],
        'tracking_url' => [
            'inputType' => 'text',
            'eval' => ['rgxp' => 'url', 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'code' => [
            'inputType' => 'textarea',
            'eval' => ['allowHtml' => true, 'preserveTags' => true, 'decodeEntities' => true, 'class' => 'monospace', 'rte' => 'ace|html', 'tl_class' => 'clr'],
            'sql' => 'text NULL',
        ],
        'provider' => [
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'transfer' => [
            'inputType' => 'select',
            'options' => ['us', 'world'],
            'reference' => &$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'],
            'eval' => ['includeBlankOption' => true, 'blankOptionLabel' => '-', 'tl_class' => 'w50'],
            'sql' => "varchar(8) NOT NULL default ''",
        ],
        'purpose' => [
            'inputType' => 'textarea',
            'eval' => ['maxlength' => 1000, 'rows' => 3, 'tl_class' => 'clr'],
            'sql' => 'text NULL',
        ],
        'privacy_url' => [
            'inputType' => 'text',
            'eval' => ['rgxp' => 'url', 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'cookies' => [
            'inputType' => 'keyValueWizard',
            'eval' => ['tl_class' => 'clr'],
            'sql' => 'blob NULL',
        ],
        'hosts' => [
            'inputType' => 'listWizard',
            'eval' => ['tl_class' => 'clr'],
            'sql' => 'blob NULL',
        ],
        'roots' => [
            'inputType' => 'checkbox',
            'options_callback' => [ServiceCallbacks::class, 'rootOptions'],
            'eval' => ['multiple' => true, 'tl_class' => 'clr'],
            'sql' => 'blob NULL',
        ],
        'published' => [
            'inputType' => 'checkbox',
            'toggle' => true,
            'filter' => true,
            'eval' => ['tl_class' => 'w50 m12'],
            'sql' => "char(1) NOT NULL default '1'",
        ],
        'found_info' => ['input_field_callback' => [ServiceCallbacks::class, 'foundInfo']],
        'translation_fields' => ['input_field_callback' => [ServiceCallbacks::class, 'translationFields']],
        // Name and purpose per language (serialized: language => [title, purpose]).
        'translations' => ['sql' => 'blob NULL'],
        'source' => ['sql' => "varchar(8) NOT NULL default ''"],
        'found_at' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'found_url' => ['sql' => "varchar(1024) NOT NULL default ''"],
    ],
];
