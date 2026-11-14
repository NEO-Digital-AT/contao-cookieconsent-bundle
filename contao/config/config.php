<?php

declare(strict_types=1);

use Neo\CookieconsentBundle\Backend\AddServiceOperation;
use Neo\CookieconsentBundle\Backend\FindingCallbacks;
use Neo\CookieconsentBundle\Backend\ScanOperation;

/*
 * Cookie consent in the menu group of the Basic bundle: the list of services
 * with buttons for the settings (one record), the texts per language, the
 * scan results and the proof of consent. "key=scan" runs the scan now,
 * "key=adopt" turns a scan result into a service, "key=add_service" lists
 * a service of the catalogue from a link of another extension.
 */
$GLOBALS['BE_MOD']['neo']['neo_cookieconsent'] = [
    'tables' => [
        'tl_neo_cookieconsent_service',
        'tl_neo_cookieconsent_settings',
        'tl_neo_cookieconsent_text',
        'tl_neo_cookieconsent_finding',
        'tl_neo_cookieconsent_log',
    ],
    'scan' => [ScanOperation::class, '__invoke'],
    'adopt' => [FindingCallbacks::class, 'adopt'],
    // A service of the catalogue from a link of another extension (the AI chat), see AddServiceOperation.
    'add_service' => [AddServiceOperation::class, '__invoke'],
];
