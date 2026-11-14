<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Nová služba', 'Přidat službu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Upravit', 'Upravit službu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Kopírovat', 'Kopírovat službu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Zapnout/vypnout', 'Zapnout nebo vypnout službu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Smazat', 'Smazat službu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Podrobnosti', 'Zobrazit podrobnosti.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Nastavení', 'Lišta, blokování, doklad o souhlasu a skenování.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Texty', 'Texty lišty pro jednotlivé jazyky.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Výsledky skenování', 'Co našla kontrola stránek.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Doklad o souhlasu', 'Volby návštěvníků, bez IP adresy.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Služba';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Informace pro návštěvníky';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Adresy a weby';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Aktivace';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Šablona', 'Známá služba z katalogu: vyplní poskytovatele, účel, cookies, třetí zemi a odkaz na zásady ochrany osobních údajů. Pro vlastní službu ponechte prázdné.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Název', 'Název služby v liště, např. „Google Analytics“.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Kategorie', 'V rámci které kategorie návštěvníci službu povolují. Kategorie „Nezbytné“ se nikdy neblokuje.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Nezbytné',
    'functional' => 'Funkční',
    'statistics' => 'Statistické',
    'marketing' => 'Marketingové',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Načítání', 'Kdo službu načítá.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'Načítá ji stránka, lišta ji až do udělení souhlasu blokuje',
    'extension' => 'Lišta ji načte po udělení souhlasu',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['ID', 'ID služby z vašeho účtu u poskytovatele.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'ID z vašeho účtu u poskytovatele, např. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Adresa vlastního serveru', 'U služeb provozovaných na vlastním serveru, jako je Matomo, adresa s https://, např. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domény pro měření napříč doménami', 'Nepovinné. Další Vaše domény, na které návštěvníci přecházejí, např. app.example.com, jedna na řádek. Odkazy na ně přenesou měření, takže návštěva napříč těmito doménami se počítá jako jedna.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Zadejte prosím pouze názvy domén, jeden na řádek, např. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Vlastní kód', 'HTML nebo skript, který se po udělení souhlasu vloží do hlavičky stránky. Pouze pro administrátory.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Poskytovatel', 'Firma a sídlo poskytovatele. Prázdné = ze šablony.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Účel', 'Co služba dělá, jednou větou pro návštěvníky. Prázdné = ze šablony, v jazyce stránky.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Předávání do třetí země', 'Zda mohou údaje směřovat do zemí mimo EU.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'USA',
    'world' => 'Země mimo EU (včetně USA)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'žádné';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'Ze šablony: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Zásady ochrany osobních údajů poskytovatele', 'Odkaz pro návštěvníky. Prázdné = ze šablony.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Cookies', 'Název a doba uložení, na každém řádku jedna cookie.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Název a doba uložení, na každém řádku jedna cookie. Prázdné = ze šablony: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'podle šablony žádné';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Adresy', 'Pouze u vlastních služeb: domény, jejichž skripty a vložený obsah se až do udělení souhlasu blokují, např. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Weby', 'Zobrazovat jen na těchto webech. Nic nevybráno = na všech.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Aktivní', 'V liště se zobrazují jen aktivní služby.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Jazyky';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Název (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Účel (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Pro weby ve více jazycích: název a účel pro každý jazyk. Prázdné = název a účel výše, nebo text šablony v daném jazyce.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Vlastní služba';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'nalezeno skenováním dne %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Nalezeno skenováním dne %s na stránce %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'Chybí ID';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Toto ID nemá tvar, který služba používá, např. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Zadejte prosím adresu vlastního serveru s https://.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'Cookie lišta je vypnutá. Zapněte ji v části „Nastavení“.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'Není vybrána stránka se zásadami ochrany osobních údajů. Vyberte ji prosím v části „Nastavení“; lišta na ni odkazuje.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Neznámé adresy ze skenování: %s. Zkontrolujte je prosím v části „Výsledky skenování“.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'Služba byla přidána a je aktivní.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'Služba už je v seznamu. Zkontrolujte prosím, zda je aktivní a ve správné kategorii.';
