<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Neuer Dienst', 'Einen Dienst anlegen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Bearbeiten', 'Dienst bearbeiten.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Kopieren', 'Dienst kopieren.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Ein/aus', 'Dienst ein- oder ausschalten.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Löschen', 'Dienst löschen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Details', 'Details anzeigen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Einstellungen', 'Hinweis, Blockieren, Nachweis und Scan einstellen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Texte', 'Texte des Hinweises je Sprache.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Scan-Ergebnisse', 'Was die Prüfung der Seiten gefunden hat.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Nachweis', 'Einwilligungen der Besucher, ohne IP-Adresse.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Dienst';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Angaben für Besucher';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Adressen und Websites';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Aktivierung';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Vorlage', 'Bekannter Dienst aus dem Katalog: füllt Anbieter, Zweck, Cookies, Drittland und Datenschutz-Link. Leer lassen für einen eigenen Dienst.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Name', 'So heißt der Dienst im Hinweis, z. B. „Google Analytics“.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Kategorie', 'Unter welcher Kategorie Besucher den Dienst erlauben. „Notwendig“ wird nie blockiert.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Notwendig',
    'functional' => 'Funktional',
    'statistics' => 'Statistik',
    'marketing' => 'Marketing',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Laden', 'Wer den Dienst lädt.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'Die Seite lädt ihn, der Hinweis blockiert ihn bis zur Einwilligung',
    'extension' => 'Der Hinweis lädt ihn nach der Einwilligung',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['Kennung', 'Die Kennung des Dienstes aus dem Konto beim Anbieter.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'Die Kennung aus dem Konto beim Anbieter, z. B. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Adresse des eigenen Servers', 'Bei selbst betriebenen Diensten wie Matomo die Adresse mit https://, z. B. https://statistik.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domains für domainübergreifende Messung', 'Optional. Weitere eigene Domains, zu denen Besucher wechseln, z. B. app.example.com, eine je Zeile. Links dorthin nehmen die Messung mit, sodass ein Besuch über diese Domains als einer zählt.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Bitte nur Domainnamen eintragen, einen je Zeile, z. B. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Eigener Code', 'HTML oder Skript, das nach der Einwilligung in den Seitenkopf eingefügt wird. Nur für Administratoren.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Anbieter', 'Firma und Ort des Anbieters. Leer = aus der Vorlage.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Zweck', 'Was der Dienst tut, in einem Satz für Besucher. Leer = aus der Vorlage, in der Sprache der Seite.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Übermittlung in ein Drittland', 'Ob Daten in Länder außerhalb der EU gehen können.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'USA',
    'world' => 'Länder außerhalb der EU (auch USA)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'keine';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'Aus der Vorlage: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Datenschutzerklärung des Anbieters', 'Link für Besucher. Leer = aus der Vorlage.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Cookies', 'Name und Speicherdauer je Zeile.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Name und Speicherdauer je Zeile. Leer = aus der Vorlage: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'laut Vorlage keine';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Adressen', 'Nur bei eigenen Diensten: Domains, deren Skripte und eingebettete Inhalte bis zur Einwilligung blockiert werden, z. B. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Websites', 'Nur auf diesen Websites zeigen. Keine Auswahl = auf allen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Aktiv', 'Nur aktive Dienste stehen im Hinweis.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Sprachen';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Name (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Zweck (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Für Websites in mehreren Sprachen: Name und Zweck je Sprache. Leer = Name und Zweck von oben bzw. der Text der Vorlage in dieser Sprache.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Eigener Dienst';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'vom Scan gefunden am %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Vom Scan gefunden am %s auf %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'Kennung fehlt';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Diese Kennung hat nicht die Form des Dienstes, z. B. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Bitte die Adresse des eigenen Servers mit https:// angeben.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'Der Cookie-Hinweis ist ausgeschaltet. Einschalten unter „Einstellungen“.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'Es ist keine Seite für die Datenschutzerklärung gewählt. Bitte unter „Einstellungen“ wählen; der Hinweis verlinkt sie.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Unbekannte Adressen aus dem Scan: %s. Bitte unter „Scan-Ergebnisse“ prüfen.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'Der Dienst wurde angelegt und ist aktiv.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'Der Dienst ist bereits angelegt. Bitte prüfen Sie, ob er aktiv ist und in der richtigen Kategorie steht.';
