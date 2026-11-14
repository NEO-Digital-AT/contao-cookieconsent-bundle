<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Új szolgáltatás', 'Szolgáltatás hozzáadása.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Szerkesztés', 'A szolgáltatás szerkesztése.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Másolás', 'A szolgáltatás másolása.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Be/ki', 'A szolgáltatás be- vagy kikapcsolása.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Törlés', 'A szolgáltatás törlése.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Részletek', 'A részletek megjelenítése.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Beállítások', 'Banner, blokkolás, hozzájárulás igazolása és vizsgálat.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Szövegek', 'A banner szövegei nyelvenként.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Vizsgálati eredmények', 'Amit az oldalak ellenőrzése talált.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Hozzájárulás igazolása', 'A látogatók választásai, IP-cím nélkül.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Szolgáltatás';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Információk a látogatóknak';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Címek és weboldalak';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Aktiválás';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Sablon', 'Ismert szolgáltatás a katalógusból: kitölti a szolgáltatót, a célt, a sütiket, a harmadik országot és az adatvédelmi hivatkozást. Saját szolgáltatáshoz hagyja üresen.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Név', 'A szolgáltatás neve a bannerben, pl. „Google Analytics”.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Kategória', 'Melyik kategóriában engedélyezik a látogatók a szolgáltatást. A „Szükséges” kategória soha nincs blokkolva.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Szükséges',
    'functional' => 'Funkcionális',
    'statistics' => 'Statisztika',
    'marketing' => 'Marketing',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Betöltés', 'Ki tölti be a szolgáltatást.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'Az oldal tölti be, a banner a hozzájárulásig blokkolja',
    'extension' => 'A banner tölti be a hozzájárulás után',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['Azonosító', 'A szolgáltatás azonosítója a szolgáltatónál vezetett fiókjából.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'Az azonosító a szolgáltatónál vezetett fiókjából, pl. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Saját szerver címe', 'Saját üzemeltetésű szolgáltatásoknál, például a Matomo esetében a cím https:// előtaggal, pl. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domainek a domainek közötti méréshez', 'Nem kötelező. Az Ön további domainjei, ahová a látogatók továbblépnek, pl. app.example.com, soronként egy. Az ezekre mutató linkek továbbviszik a mérést, így az ezeken a domaineken átívelő látogatás egynek számít.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Kérjük, csak domainneveket adjon meg, soronként egyet, pl. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Saját kód', 'HTML vagy szkript, amely a hozzájárulás után bekerül az oldal fejlécébe. Csak rendszergazdáknak.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Szolgáltató', 'A szolgáltató cége és székhelye. Üres = a sablonból.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Cél', 'Mit csinál a szolgáltatás, egy mondatban a látogatóknak. Üres = a sablonból, az oldal nyelvén.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Továbbítás harmadik országba', 'Kerülhetnek-e adatok EU-n kívüli országokba.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'USA',
    'world' => 'EU-n kívüli országok (az USA-t is beleértve)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'nincs';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'A sablonból: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['A szolgáltató adatvédelmi tájékoztatója', 'Hivatkozás a látogatóknak. Üres = a sablonból.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Sütik', 'Név és tárolási idő, soronként egy.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Név és tárolási idő, soronként egy. Üres = a sablonból: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'a sablon szerint nincs';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Címek', 'Csak saját szolgáltatásoknál: azok a domainek, amelyek szkriptjei és beágyazott tartalmai a hozzájárulásig blokkolva vannak, pl. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Weboldalak', 'Csak ezeken a weboldalakon jelenjen meg. Nincs kiválasztás = mindegyiken.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Aktív', 'Csak az aktív szolgáltatások jelennek meg a bannerben.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Nyelvek';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Név (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Cél (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Többnyelvű weboldalakhoz: név és cél nyelvenként. Üres = a fenti név és cél, vagy a sablon szövege az adott nyelven.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Saját szolgáltatás';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'a vizsgálat találta (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'A vizsgálat találta (%s), itt: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'Hiányzó azonosító';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Ez az azonosító nem a szolgáltatás által használt formátumú, pl. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Kérjük, adja meg a saját szerver címét https:// előtaggal.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'A sütibanner ki van kapcsolva. A „Beállítások” alatt kapcsolhatja be.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'Nincs kiválasztva oldal az adatvédelmi tájékoztatóhoz. Kérjük, válassza ki a „Beállítások” alatt; a banner erre hivatkozik.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Ismeretlen címek a vizsgálatból: %s. Kérjük, ellenőrizze őket a „Vizsgálati eredmények” alatt.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'A szolgáltatás felvéve, és aktív.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'A szolgáltatás már szerepel a listában. Kérjük, ellenőrizze, hogy aktív-e és a megfelelő kategóriában van-e.';
