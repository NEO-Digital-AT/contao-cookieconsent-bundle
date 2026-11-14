<?php

declare(strict_types=1);

use Contao\DataContainer;
use Contao\DC_Table;
use Neo\CookieconsentBundle\Backend\TextCallbacks;
use Neo\CookieconsentBundle\Consent\Texts;

/*
 * tl_neo_cookieconsent_text — own texts of the banner per language. Every
 * empty field shows its default (eleven languages shipped) and uses it. In the
 * text of the first layer, {services} lists the categories with their services
 * and {transfer} adds the sentence about transfers to third countries.
 */
$GLOBALS['TL_DCA']['tl_neo_cookieconsent_text'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => true,
        'onload_callback' => [[TextCallbacks::class, 'placeholders']],
        'sql' => ['keys' => ['id' => 'primary', 'language' => 'index']],
    ],

    'list' => [
        'sorting' => [
            'mode' => DataContainer::MODE_SORTED,
            'fields' => ['language'],
            'flag' => DataContainer::SORT_ASC,
            'disableGrouping' => true,
            'panelLayout' => 'search,limit',
        ],
        'label' => [
            'fields' => ['language', 'banner_title'],
            'format' => '<strong>%s</strong> %s',
            'label_callback' => [TextCallbacks::class, 'label'],
        ],
        'global_operations' => [
            // The class draws Contao's back icon; an own icon would show a second arrow.
            'back_to_services' => ['href' => 'table=tl_neo_cookieconsent_service', 'class' => 'header_back', 'primary' => true],
        ],
        'operations' => [
            'edit' => ['href' => 'act=edit', 'icon' => 'edit.svg'],
            'delete' => ['href' => 'act=delete', 'icon' => 'delete.svg', 'attributes' => 'onclick="Backend.getScrollOffset()"'],
            'show' => ['href' => 'act=show', 'icon' => 'show.svg'],
        ],
    ],

    'palettes' => [
        'default' => '{language_legend},language;'
            .'{banner_legend},banner_title,banner_text;'
            .'{settings_legend},settings_title,settings_text,services_toggle,consent_id;'
            .'{buttons_legend},btn_accept,btn_necessary,btn_settings,btn_save,btn_back,reopen;'
            .'{categories_legend},cat_necessary,cat_necessary_desc,cat_functional,cat_functional_desc,cat_statistics,cat_statistics_desc,cat_marketing,cat_marketing_desc;'
            .'{embed_legend},embed_text,embed_load,embed_always;'
            .'{links_legend},privacy_page,imprint_page,link_privacy,link_imprint',
    ],

    'fields' => [
        'id' => ['sql' => 'int(10) unsigned NOT NULL auto_increment'],
        'tstamp' => ['sql' => 'int(10) unsigned NOT NULL default 0'],
        'language' => [
            'inputType' => 'select',
            'options_callback' => [TextCallbacks::class, 'languages'],
            'eval' => ['mandatory' => true, 'unique' => true, 'chosen' => true, 'submitOnChange' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(8) NOT NULL default ''",
        ],
        // Pages of this language; empty = the pages of the settings.
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
    ],
];

// One text field per key; long texts as text areas.
foreach (Texts::KEYS as $key) {
    $long = \in_array($key, ['banner_text', 'settings_text', 'embed_text'], true) || str_ends_with($key, '_desc');
    $GLOBALS['TL_DCA']['tl_neo_cookieconsent_text']['fields'][$key] = [
        'inputType' => $long ? 'textarea' : 'text',
        'search' => 'banner_title' === $key,
        'eval' => $long ? ['rows' => 3, 'maxlength' => 2000, 'tl_class' => 'clr'] : ['maxlength' => 255, 'tl_class' => 'w50'],
        'sql' => $long ? 'text NULL' : "varchar(255) NOT NULL default ''",
    ];
}
