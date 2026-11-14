<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Nieuwe dienst', 'Een dienst toevoegen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Bewerken', 'De dienst bewerken.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Kopiëren', 'De dienst kopiëren.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Aan/uit', 'De dienst in- of uitschakelen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Verwijderen', 'De dienst verwijderen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Details', 'De details tonen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Instellingen', 'Banner, blokkeren, bewijs van toestemming en scan.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Teksten', 'Teksten van de banner per taal.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Scanresultaten', 'Wat de controle van de pagina’s heeft gevonden.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Bewijs van toestemming', 'Keuzes van de bezoekers, zonder IP-adres.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Dienst';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Informatie voor bezoekers';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Adressen en websites';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Activering';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Sjabloon', 'Bekende dienst uit de catalogus: vult aanbieder, doel, cookies, derde land en privacylink in. Leeg laten voor een eigen dienst.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Naam', 'De naam van de dienst in de banner, bijv. “Google Analytics”.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Categorie', 'Onder welke categorie bezoekers de dienst toestaan. “Noodzakelijk” wordt nooit geblokkeerd.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Noodzakelijk',
    'functional' => 'Functioneel',
    'statistics' => 'Statistieken',
    'marketing' => 'Marketing',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Laden', 'Wie de dienst laadt.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'De pagina laadt de dienst, de banner blokkeert hem tot er toestemming is',
    'extension' => 'De banner laadt de dienst na toestemming',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['ID', 'De ID van de dienst uit uw account bij de aanbieder.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'De ID uit uw account bij de aanbieder, bijv. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Adres van uw eigen server', 'Bij zelf gehoste diensten zoals Matomo het adres met https://, bijv. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domeinen voor meting over domeinen heen', 'Optioneel. Uw andere domeinen waar bezoekers naartoe gaan, bijv. app.example.com, één per regel. Links daarheen nemen de meting mee, zodat een bezoek over deze domeinen als één telt.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Voer alleen domeinnamen in, één per regel, bijv. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Eigen code', 'HTML of script dat na toestemming aan de paginakop wordt toegevoegd. Alleen voor beheerders.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Aanbieder', 'Bedrijf en plaats van de aanbieder. Leeg = uit het sjabloon.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Doel', 'Wat de dienst doet, in één zin voor bezoekers. Leeg = uit het sjabloon, in de taal van de pagina.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Doorgifte naar een derde land', 'Of gegevens naar landen buiten de EU kunnen gaan.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'VS',
    'world' => 'Landen buiten de EU (inclusief de VS)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'geen';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'Uit het sjabloon: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Privacyverklaring van de aanbieder', 'Link voor bezoekers. Leeg = uit het sjabloon.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Cookies', 'Naam en bewaartermijn per regel.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Naam en bewaartermijn per regel. Leeg = uit het sjabloon: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'geen volgens het sjabloon';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Adressen', 'Alleen voor eigen diensten: domeinen waarvan scripts en ingesloten inhoud tot de toestemming worden geblokkeerd, bijv. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Websites', 'Alleen op deze websites tonen. Niets geselecteerd = op alle.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Actief', 'Alleen actieve diensten verschijnen in de banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Talen';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Naam (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Doel (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Voor websites in meerdere talen: naam en doel per taal. Leeg = naam en doel hierboven, of de tekst van het sjabloon in die taal.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Eigen dienst';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'gevonden door de scan van %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Gevonden door de scan van %s op %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'ID ontbreekt';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Deze ID heeft niet de vorm die de dienst gebruikt, bijv. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Voer het adres van uw eigen server in met https://.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'De cookiebanner is uitgeschakeld. Schakel hem in onder “Instellingen”.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'Er is geen pagina voor de privacyverklaring gekozen. Kies deze onder “Instellingen”; de banner linkt ernaar.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Onbekende adressen uit de scan: %s. Controleer ze onder “Scanresultaten”.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'De dienst is toegevoegd en is actief.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'De dienst staat al in de lijst. Controleer of hij actief is en in de juiste categorie staat.';
