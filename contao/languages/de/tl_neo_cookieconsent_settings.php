<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Bearbeiten', 'Einstellungen bearbeiten.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Lizenz';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Hinweis';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blockieren';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Nachweis der Einwilligung';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Scan';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Version';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'Diese Erweiterung ist kostenlos. Bedingung: Im Impressum jeder Website, auf der sie öffentlich läuft, wird sie mit einem Link auf https://neo-digital.at genannt.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Text zum Kopieren (mit Link):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Oder als HTML für den Quelltext des Impressums:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Cookie-Hinweis: NEO Cookie Consent von NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Hinweis zeigen', 'Zeigt den Hinweis auf allen Seiten und blockiert Dienste bis zur Einwilligung.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Erscheint', 'Wann der Hinweis erscheint.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Sofort beim Laden der Seite',
    'scroll' => 'Erst nach dem ersten Scrollen, Klick, Bewegen der Maus oder Tabulator',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Lage', 'Wo der Hinweis steht.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Zeile unten',
    'top' => 'Zeile oben',
    'center' => 'Mitte des Bildschirms',
    'left' => 'Seitenleiste links',
    'right' => 'Seitenleiste rechts',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Hintergrund abdunkeln', 'Legt eine halbdurchsichtige Fläche über die Seite, solange der Hinweis offen ist. Die Seite ist dann erst nach der Wahl bedienbar.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Knopf zum Wiederöffnen', 'Kleiner Knopf, mit dem Besucher ihre Wahl ändern. Ohne Knopf braucht die Website einen Link, z. B. das Insert-Tag {{cookie_consent::settings}} in der Fußzeile. Sitzen Knöpfe anderer Erweiterungen (Barrierefreiheit, Chat) in derselben Ecke, werden sie gemeinsam so angeordnet, wie es im Seitenlayout eingestellt ist: eine Einstellungs-Schaltfläche mit Menü, übereinander oder nebeneinander.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'Unten links',
    'right' => 'Unten rechts',
    'none' => 'Kein Knopf',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Datenschutzerklärung', 'Seite, die der Hinweis verlinkt.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Impressum', 'Seite, die der Hinweis verlinkt.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Skripte blockieren', 'Skripte und Schriften bekannter Dienste in den Seiten laufen erst nach der Einwilligung.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Eingebettete Inhalte blockieren', 'Videos, Karten und Beiträge zeigen bis zur Einwilligung einen Platzhalter mit „Inhalt laden“.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Meldet die Wahl an Google-Dienste. Vor der Einwilligung lädt kein Google-Dienst.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Einwilligungen speichern', 'Speichert je Wahl eine zufällige Einwilligungs-ID, Zeit, Version und Auswahl, ohne IP-Adresse. Damit lässt sich eine Einwilligung nachweisen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Aufbewahren', 'Danach werden die Einträge gelöscht.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 Jahr',
    730 => '2 Jahre',
    1095 => '3 Jahre',
    1825 => '5 Jahre',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Täglich prüfen', 'Liest die veröffentlichten Seiten, ergänzt gefundene Dienste aus dem Katalog und meldet unbekannte Adressen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Seiten je Prüfung', 'Höchstens so viele Seiten werden gelesen, zuerst die Startseiten.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Meldung an', 'E-Mail-Adresse für Meldungen über neue Dienste. Leer = Adresse des Systemadministrators.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Jetzt prüfen';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Scan-Ergebnisse ansehen';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Noch nicht geprüft.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Zuletzt geprüft am %s: %s Seiten gelesen, %s Dienste und Adressen gefunden, %s neu ergänzt.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = '%s Seiten gelesen, %s Dienste und Adressen gefunden.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Neu im Hinweis, bis zur Einwilligung blockiert: %s. Bitte die Datenschutzerklärung prüfen.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Unbekannte Adressen, bitte prüfen: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Nicht lesbar: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Version %s, zuletzt geändert am %s. Ändert sich ein Dienst, werden alle Besucher neu gefragt.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Wirkt nur, solange das Banner oben eingeschaltet ist: Ohne Banner wird nichts angezeigt und nichts blockiert.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Wirkt nur, solange Einwilligungen gespeichert werden (oben).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Wirkt erst, wenn ein Google-Dienst (z. B. Google Analytics, Google Tag Manager, Google Ads) unter den Diensten steht.';
