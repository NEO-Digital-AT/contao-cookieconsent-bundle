<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['New service', 'Add a service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Edit', 'Edit the service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Copy', 'Copy the service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['On/off', 'Switch the service on or off.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Delete', 'Delete the service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Details', 'Show the details.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Settings', 'Banner, blocking, proof of consent and scan.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Texts', 'Texts of the banner per language.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Scan results', 'What the check of the pages found.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Proof of consent', 'Choices of the visitors, without IP address.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Service';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Information for visitors';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Addresses and websites';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Activation';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Template', 'Known service from the catalogue: fills in provider, purpose, cookies, third country and privacy link. Leave empty for an own service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Name', 'The name of the service in the banner, e.g. "Google Analytics".'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Category', 'Under which category visitors allow the service. "Necessary" is never blocked.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Necessary',
    'functional' => 'Functional',
    'statistics' => 'Statistics',
    'marketing' => 'Marketing',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Loading', 'Who loads the service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'The page loads it, the banner blocks it until consent',
    'extension' => 'The banner loads it after consent',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['ID', 'The ID of the service from your account with the provider.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'The ID from your account with the provider, e.g. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Address of your own server', 'For self-hosted services such as Matomo the address with https://, e.g. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domains for cross-domain measurement', 'Optional. Further domains of yours that visitors move on to, e.g. app.example.com, one per line. Links to them carry the measurement over, so that a visit across these domains counts as one.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Please enter domain names only, one per line, e.g. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Own code', 'HTML or script added to the page head after consent. Administrators only.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Provider', 'Company and place of the provider. Empty = from the template.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Purpose', 'What the service does, in one sentence for visitors. Empty = from the template, in the language of the page.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Transfer to a third country', 'Whether data can go to countries outside the EU.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'USA',
    'world' => 'Countries outside the EU (including the USA)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'none';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'From the template: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Privacy policy of the provider', 'Link for visitors. Empty = from the template.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Cookies', 'Name and storage period per row.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Name and storage period per row. Empty = from the template: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'none according to the template';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Addresses', 'Own services only: domains whose scripts and embedded content are blocked until consent, e.g. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Websites', 'Show only on these websites. Nothing selected = on all.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Active', 'Only active services appear in the banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Languages';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Name (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Purpose (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'For websites in several languages: name and purpose per language. Empty = name and purpose above, or the text of the template in that language.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Own service';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'found by the scan on %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Found by the scan on %s on %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'ID missing';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'This ID does not have the form the service uses, e.g. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Please enter the address of your own server with https://.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'The cookie banner is switched off. Switch it on under "Settings".';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'No privacy policy page is chosen. Please choose it under "Settings"; the banner links to it.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Unknown addresses from the scan: %s. Please check them under "Scan results".';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'The service was added and is active.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'The service is listed already. Please check that it is active and in the right category.';
