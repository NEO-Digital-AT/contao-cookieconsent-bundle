<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Edit', 'Edit the settings.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licence';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Banner';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blocking';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Proof of consent';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Scan';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Version';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'This extension is free. Condition: the legal notice of every website on which it runs publicly names it with a link to https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Text to copy (with link):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Or as HTML for the source code of the legal notice:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Cookie banner: NEO Cookie Consent by NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Show the banner', 'Shows the banner on all pages and blocks services until consent.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Appears', 'When the banner appears.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Immediately when the page loads',
    'scroll' => 'After the first scroll, click, mouse movement or Tab key',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Position', 'Where the banner is shown.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Bar at the bottom',
    'top' => 'Bar at the top',
    'center' => 'Centre of the screen',
    'left' => 'Side panel left',
    'right' => 'Side panel right',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Dim the background', 'Puts a translucent layer over the page while the banner is open. The page can then be used only after a choice.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Button to reopen', 'A small button with which visitors change their choice. Without it the website needs a link, e.g. the insert tag {{cookie_consent::settings}} in the footer. When buttons of other extensions (accessibility, chat) sit in the same corner, they are arranged together as set in the page layout: one settings button with a menu, stacked or side by side.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'Bottom left',
    'right' => 'Bottom right',
    'none' => 'No button',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Privacy policy', 'Page the banner links to.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Legal notice', 'Page the banner links to.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Block scripts', 'Scripts and fonts of known services in the pages run only after consent.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Block embedded content', 'Videos, maps and posts show a placeholder with "Load content" until consent.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Reports the choice to Google services. No Google service loads before consent.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Store consents', 'Stores a random consent ID, time, version and choice for each choice, without IP address. This proves a consent.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Keep for', 'The entries are deleted afterwards.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 year',
    730 => '2 years',
    1095 => '3 years',
    1825 => '5 years',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Check daily', 'Reads the published pages, adds services of the catalogue it finds and reports unknown addresses.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Pages per check', 'At most this many pages are read, the start pages first.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Report to', 'E-mail address for reports about new services. Empty = address of the system administrator.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Check now';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'View scan results';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Not checked yet.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Last checked on %s: %s pages read, %s services and addresses found, %s added.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = '%s pages read, %s services and addresses found.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'New in the banner, blocked until consent: %s. Please check the privacy policy.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Unknown addresses, please check: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Could not be read: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Version %s, last changed on %s. When a service changes, all visitors are asked again.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Only while the banner is switched on above: without the banner nothing is shown or blocked.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Only while consents are stored (above).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Takes effect once a Google service (e.g. Google Analytics, Google Tag Manager, Google Ads) is listed under the services.';
