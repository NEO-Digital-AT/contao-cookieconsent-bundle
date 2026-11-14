<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Nova storitev', 'Dodaj storitev.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Uredi', 'Uredi storitev.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Kopiraj', 'Kopiraj storitev.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Vklop/izklop', 'Vklopi ali izklopi storitev.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Izbriši', 'Izbriši storitev.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Podrobnosti', 'Prikaži podrobnosti.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Nastavitve', 'Pasica, blokiranje, dokazilo o soglasju in pregled.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Besedila', 'Besedila pasice po jezikih.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Rezultati pregleda', 'Kaj je našlo preverjanje strani.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Dokazilo o soglasju', 'Izbire obiskovalcev, brez naslova IP.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Storitev';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Podatki za obiskovalce';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Naslovi in spletna mesta';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Aktivacija';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Predloga', 'Znana storitev iz kataloga: izpolni ponudnika, namen, piškotke, tretjo državo in povezavo do politike zasebnosti. Za lastno storitev pustite prazno.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Ime', 'Ime storitve v pasici, npr. „Google Analytics“.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Kategorija', 'V kateri kategoriji obiskovalci dovolijo storitev. Kategorija „Nujni“ ni nikoli blokirana.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Nujni',
    'functional' => 'Funkcionalni',
    'statistics' => 'Statistični',
    'marketing' => 'Trženjski',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Nalaganje', 'Kdo naloži storitev.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'Naloži jo stran, pasica jo do soglasja blokira',
    'extension' => 'Pasica jo naloži po soglasju',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['ID', 'ID storitve iz vašega računa pri ponudniku.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'ID iz vašega računa pri ponudniku, npr. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Naslov lastnega strežnika', 'Pri storitvah na lastnem strežniku, kot je Matomo, naslov s https://, npr. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domene za merjenje med domenami', 'Neobvezno. Vaše druge domene, na katere obiskovalci preidejo, npr. app.example.com, ena na vrstico. Povezave nanje prenesejo merjenje, tako da obisk na teh domenah šteje kot eden.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Vnesite samo imena domen, eno na vrstico, npr. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Lastna koda', 'HTML ali skripta, ki se po soglasju doda v glavo strani. Samo za skrbnike.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Ponudnik', 'Podjetje in sedež ponudnika. Prazno = iz predloge.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Namen', 'Kaj storitev počne, v enem stavku za obiskovalce. Prazno = iz predloge, v jeziku strani.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Prenos v tretjo državo', 'Ali se podatki lahko prenesejo v države zunaj EU.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'ZDA',
    'world' => 'Države zunaj EU (vključno z ZDA)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'brez';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'Iz predloge: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Politika zasebnosti ponudnika', 'Povezava za obiskovalce. Prazno = iz predloge.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Piškotki', 'Ime in čas hrambe, vsak piškotek v svoji vrstici.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Ime in čas hrambe, vsak piškotek v svoji vrstici. Prazno = iz predloge: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'po predlogi nobenih';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Naslovi', 'Samo pri lastnih storitvah: domene, katerih skripte in vdelana vsebina so do soglasja blokirane, npr. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Spletna mesta', 'Prikaži samo na teh spletnih mestih. Nič izbrano = na vseh.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Aktivno', 'V pasici so prikazane samo aktivne storitve.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Jeziki';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Ime (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Namen (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Za spletna mesta v več jezikih: ime in namen za vsak jezik. Prazno = ime in namen zgoraj ali besedilo predloge v tem jeziku.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Lastna storitev';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'najdeno s pregledom dne %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Najdeno s pregledom dne %s na strani %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'Manjka ID';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Ta ID nima oblike, ki jo uporablja storitev, npr. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Vnesite naslov lastnega strežnika s https://.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'Pasica za piškotke je izklopljena. Vklopite jo pod „Nastavitve“.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'Stran s politiko zasebnosti ni izbrana. Izberite jo pod „Nastavitve“; pasica se poveže nanjo.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Neznani naslovi iz pregleda: %s. Preverite jih pod „Rezultati pregleda“.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'Storitev je dodana in je aktivna.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'Storitev je že na seznamu. Preverite, ali je aktivna in v pravi kategoriji.';
