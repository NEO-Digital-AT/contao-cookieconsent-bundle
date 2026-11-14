<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Bewerken', 'De instellingen bewerken.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licentie';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Banner';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blokkeren';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Bewijs van toestemming';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Scan';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Versie';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'Deze extensie is gratis. Voorwaarde: de juridische informatie van elke website waarop zij openbaar draait, noemt haar met een link naar https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Tekst om te kopiëren (met link):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Of als HTML voor de broncode van de juridische informatie:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Cookiebanner: NEO Cookie Consent van NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Banner tonen', 'Toont de banner op alle pagina’s en blokkeert diensten tot er toestemming is.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Verschijnt', 'Wanneer de banner verschijnt.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Direct bij het laden van de pagina',
    'scroll' => 'Na het eerste scrollen, de eerste klik, muisbeweging of de eerste Tab-toets',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Positie', 'Waar de banner wordt getoond.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Balk onderaan',
    'top' => 'Balk bovenaan',
    'center' => 'Midden van het scherm',
    'left' => 'Zijpaneel links',
    'right' => 'Zijpaneel rechts',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Achtergrond dimmen', 'Legt een halfdoorzichtige laag over de pagina zolang de banner open is. De pagina is dan pas na een keuze te gebruiken.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Knop om opnieuw te openen', 'Een kleine knop waarmee bezoekers hun keuze wijzigen. Zonder knop heeft de website een link nodig, bijv. de insert-tag {{cookie_consent::settings}} in de footer. Staan er knoppen van andere extensies (toegankelijkheid, chat) in dezelfde hoek, dan worden ze samen geordend zoals ingesteld in de pagina-layout: één instellingenknop met een menu, boven elkaar of naast elkaar.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'Linksonder',
    'right' => 'Rechtsonder',
    'none' => 'Geen knop',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Privacyverklaring', 'Pagina waarnaar de banner linkt.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Colofon', 'Pagina waarnaar de banner linkt.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Scripts blokkeren', 'Scripts en lettertypen van bekende diensten in de pagina’s worden pas na toestemming uitgevoerd.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Ingesloten inhoud blokkeren', 'Video’s, kaarten en berichten tonen tot de toestemming een plaatshouder met “Inhoud laden”.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Geeft de keuze door aan Google-diensten. Vóór de toestemming laadt geen enkele Google-dienst.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Toestemmingen opslaan', 'Slaat per keuze een willekeurige toestemmings-ID, tijdstip, versie en selectie op, zonder IP-adres. Daarmee kan een toestemming worden aangetoond.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Bewaren', 'Daarna worden de vermeldingen verwijderd.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 jaar',
    730 => '2 jaar',
    1095 => '3 jaar',
    1825 => '5 jaar',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Dagelijks controleren', 'Leest de gepubliceerde pagina’s, voegt gevonden diensten uit de catalogus toe en meldt onbekende adressen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Pagina’s per controle', 'Er worden hoogstens zoveel pagina’s gelezen, de startpagina’s eerst.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Melden aan', 'E-mailadres voor meldingen over nieuwe diensten. Leeg = adres van de systeembeheerder.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Nu controleren';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Scanresultaten bekijken';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Nog niet gecontroleerd.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Laatst gecontroleerd op %s: %s pagina’s gelezen, %s diensten en adressen gevonden, %s toegevoegd.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = '%s pagina’s gelezen, %s diensten en adressen gevonden.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Nieuw in de banner, geblokkeerd tot er toestemming is: %s. Controleer de privacyverklaring.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Onbekende adressen, graag controleren: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Kon niet worden gelezen: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Versie %s, laatst gewijzigd op %s. Als een dienst verandert, wordt alle bezoekers opnieuw om toestemming gevraagd.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Werkt alleen zolang de banner hierboven aan staat: zonder banner wordt niets getoond en niets geblokkeerd.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Werkt alleen zolang toestemmingen worden opgeslagen (hierboven).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Werkt pas zodra een Google-dienst (bijv. Google Analytics, Google Tag Manager, Google Ads) bij de diensten staat.';
