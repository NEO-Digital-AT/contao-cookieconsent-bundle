<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Nova usluga', 'Dodaj uslugu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Uredi', 'Uredi uslugu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Kopiraj', 'Kopiraj uslugu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Uključi/isključi', 'Uključi ili isključi uslugu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Izbriši', 'Izbriši uslugu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Pojedinosti', 'Prikaži pojedinosti.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Postavke', 'Banner, blokiranje, dokaz privole i skeniranje.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Tekstovi', 'Tekstovi bannera po jeziku.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Rezultati skeniranja', 'Što je pronašla provjera stranica.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Dokaz privole', 'Odabiri posjetitelja, bez IP adrese.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Usluga';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Podaci za posjetitelje';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Adrese i web-stranice';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Aktivacija';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Predložak', 'Poznata usluga iz kataloga: popunjava pružatelja, svrhu, kolačiće, treću zemlju i poveznicu na pravila privatnosti. Ostavite prazno za vlastitu uslugu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Naziv', 'Naziv usluge u banneru, npr. „Google Analytics“.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Kategorija', 'U kojoj kategoriji posjetitelji dopuštaju uslugu. Kategorija „Nužni“ nikad se ne blokira.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Nužni',
    'functional' => 'Funkcionalni',
    'statistics' => 'Statistički',
    'marketing' => 'Marketinški',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Učitavanje', 'Tko učitava uslugu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'Učitava je stranica, banner je blokira do davanja privole',
    'extension' => 'Banner je učitava nakon davanja privole',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['ID', 'ID usluge iz vašeg računa kod pružatelja.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'ID iz vašeg računa kod pružatelja, npr. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Adresa vlastitog poslužitelja', 'Za usluge na vlastitom poslužitelju, kao što je Matomo, adresa s https://, npr. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domene za mjerenje među domenama', 'Neobavezno. Vaše druge domene na koje posjetitelji prelaze, npr. app.example.com, jedna po retku. Poveznice na njih prenose mjerenje, pa se posjet na tim domenama broji kao jedan.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Unesite samo nazive domena, jedan po retku, npr. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Vlastiti kod', 'HTML ili skripta koja se nakon davanja privole dodaje u zaglavlje stranice. Samo za administratore.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Pružatelj', 'Tvrtka i sjedište pružatelja. Prazno = iz predloška.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Svrha', 'Što usluga radi, jednom rečenicom za posjetitelje. Prazno = iz predloška, na jeziku stranice.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Prijenos u treću zemlju', 'Mogu li podaci ići u zemlje izvan EU-a.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'SAD',
    'world' => 'Zemlje izvan EU-a (uključujući SAD)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'nema';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'Iz predloška: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Pravila privatnosti pružatelja', 'Poveznica za posjetitelje. Prazno = iz predloška.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Kolačići', 'Naziv i razdoblje pohrane, po jedan kolačić u svakom retku.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Naziv i razdoblje pohrane, po jedan kolačić u svakom retku. Prazno = iz predloška: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'prema predlošku nema';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Adrese', 'Samo za vlastite usluge: domene čije se skripte i ugrađeni sadržaji blokiraju do davanja privole, npr. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Web-stranice', 'Prikaži samo na ovim web-stranicama. Ništa odabrano = na svima.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Aktivno', 'U banneru se prikazuju samo aktivne usluge.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Jezici';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Naziv (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Svrha (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Za web-mjesta na više jezika: naziv i svrha po jeziku. Prazno = naziv i svrha gore ili tekst predloška na tom jeziku.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Vlastita usluga';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'pronađeno skeniranjem dana %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Pronađeno skeniranjem dana %s na stranici %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'Nedostaje ID';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Ovaj ID nema oblik koji usluga koristi, npr. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Unesite adresu vlastitog poslužitelja s https://.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'Banner za kolačiće je isključen. Uključite ga pod „Postavke“.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'Nije odabrana stranica s pravilima privatnosti. Odaberite je pod „Postavke“; banner vodi na nju.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Nepoznate adrese iz skeniranja: %s. Provjerite ih pod „Rezultati skeniranja“.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'Usluga je dodana i aktivna je.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'Usluga je već na popisu. Provjerite je li aktivna i u ispravnoj kategoriji.';
