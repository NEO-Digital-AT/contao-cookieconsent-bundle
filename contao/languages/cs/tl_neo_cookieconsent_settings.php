<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Upravit', 'Upravit nastavení.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licence';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Lišta';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blokování';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Doklad o souhlasu';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Skenování';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Verze';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'Toto rozšíření je zdarma. Podmínka: právní upozornění každého webu, na kterém veřejně běží, jej uvádí s odkazem na https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Text ke zkopírování (s odkazem):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Nebo jako HTML pro zdrojový kód právního upozornění:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Cookie lišta: NEO Cookie Consent od NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Zobrazit lištu', 'Zobrazí lištu na všech stránkách a až do udělení souhlasu blokuje služby.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Zobrazení', 'Kdy se lišta zobrazí.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Ihned při načtení stránky',
    'scroll' => 'Až po prvním posunutí stránky, kliknutí, pohybu myši nebo stisku klávesy Tab',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Umístění', 'Kde se lišta zobrazuje.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Pruh dole',
    'top' => 'Pruh nahoře',
    'center' => 'Střed obrazovky',
    'left' => 'Boční panel vlevo',
    'right' => 'Boční panel vpravo',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Ztmavit pozadí', 'Překryje stránku poloprůhlednou vrstvou, dokud je lišta otevřená. Stránku pak lze používat až po provedení volby.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Tlačítko pro opětovné otevření', 'Malé tlačítko, kterým návštěvníci mění svou volbu. Bez něj web potřebuje odkaz, např. insert tag {{cookie_consent::settings}} v patičce. Pokud jsou ve stejném rohu tlačítka jiných rozšíření (přístupnost, chat), uspořádají se společně podle nastavení v rozvržení stránky: jedno tlačítko nastavení s nabídkou, nad sebou nebo vedle sebe.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'Vlevo dole',
    'right' => 'Vpravo dole',
    'none' => 'Bez tlačítka',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Zásady ochrany osobních údajů', 'Stránka, na kterou lišta odkazuje.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Právní upozornění', 'Stránka, na kterou lišta odkazuje.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Blokovat skripty', 'Skripty a písma známých služeb ve stránkách se spustí až po udělení souhlasu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Blokovat vložený obsah', 'Videa, mapy a příspěvky zobrazují až do udělení souhlasu zástupný prvek s tlačítkem „Načíst obsah“.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Předává volbu službám Google. Před udělením souhlasu se nenačte žádná služba Google.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Ukládat souhlasy', 'Ke každé volbě uloží náhodné ID souhlasu, čas, verzi a výběr, bez IP adresy. Tím lze souhlas prokázat.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Uchovávat', 'Poté se záznamy smažou.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 rok',
    730 => '2 roky',
    1095 => '3 roky',
    1825 => '5 let',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Kontrolovat denně', 'Načte zveřejněné stránky, doplní nalezené služby z katalogu a ohlásí neznámé adresy.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Stránek na kontrolu', 'Načte se nejvýše tolik stránek, nejprve úvodní stránky.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Hlásit na', 'E-mailová adresa pro hlášení o nových službách. Prázdné = adresa správce systému.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Zkontrolovat nyní';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Zobrazit výsledky skenování';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Zatím nekontrolováno.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Naposledy zkontrolováno dne %s. Načtené stránky: %s, nalezené služby a adresy: %s, nově doplněné: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = 'Načtené stránky: %s, nalezené služby a adresy: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Nově v liště, až do udělení souhlasu blokováno: %s. Zkontrolujte prosím zásady ochrany osobních údajů.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Neznámé adresy, zkontrolujte je prosím: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Nelze načíst: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Verze %s, naposledy změněno dne %s. Když se některá služba změní, budou všichni návštěvníci znovu požádáni o souhlas.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Platí jen, dokud je banner výše zapnutý: bez banneru se nic nezobrazí ani nezablokuje.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Platí jen, dokud se souhlasy ukládají (výše).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Začne platit, jakmile je mezi službami služba Google (např. Google Analytics, Google Tag Manager, Google Ads).';
