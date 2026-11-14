<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Szerkesztés', 'A beállítások szerkesztése.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licenc';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Banner';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blokkolás';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Hozzájárulás igazolása';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Vizsgálat';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Verzió';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'Ez a bővítmény ingyenes. Feltétel: minden olyan weboldal impresszuma, amelyen nyilvánosan fut, megnevezi egy https://neo-digital.at címre mutató hivatkozással.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Másolható szöveg (hivatkozással):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Vagy HTML-ként az impresszum forráskódjához:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Sütibanner: NEO Cookie Consent, készítette: NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Banner megjelenítése', 'Minden oldalon megjeleníti a bannert, és a hozzájárulásig blokkolja a szolgáltatásokat.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Megjelenés', 'Mikor jelenik meg a banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Azonnal az oldal betöltésekor',
    'scroll' => 'Csak az első görgetés, kattintás, egérmozgatás vagy Tab billentyű után',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Elhelyezés', 'Hol jelenik meg a banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Sáv alul',
    'top' => 'Sáv felül',
    'center' => 'A képernyő közepén',
    'left' => 'Oldalsáv bal oldalon',
    'right' => 'Oldalsáv jobb oldalon',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Háttér elsötétítése', 'Áttetsző réteget helyez az oldalra, amíg a banner nyitva van. Az oldal ekkor csak a választás után használható.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Újranyitó gomb', 'Kis gomb, amellyel a látogatók módosíthatják választásukat. Nélküle a weboldalnak hivatkozásra van szüksége, pl. a {{cookie_consent::settings}} insert tagre a láblécben. Ha ugyanabban a sarokban más bővítmények gombjai is vannak (akadálymentesség, chat), az oldalelrendezés beállítása szerint együtt jelennek meg: egy beállítások gomb menüvel, egymás fölött vagy egymás mellett.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'Bal alul',
    'right' => 'Jobb alul',
    'none' => 'Nincs gomb',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Adatvédelmi tájékoztató', 'Az oldal, amelyre a banner hivatkozik.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Impresszum', 'Az oldal, amelyre a banner hivatkozik.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Szkriptek blokkolása', 'Az ismert szolgáltatások szkriptjei és betűtípusai az oldalakon csak a hozzájárulás után futnak.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Beágyazott tartalmak blokkolása', 'A videók, térképek és bejegyzések a hozzájárulásig helyőrzőt mutatnak „Tartalom betöltése” gombbal.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Továbbítja a választást a Google-szolgáltatásoknak. A hozzájárulás előtt egyetlen Google-szolgáltatás sem töltődik be.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Hozzájárulások tárolása', 'Minden választáshoz eltárol egy véletlenszerű hozzájárulási azonosítót, az időpontot, a verziót és a választást, IP-cím nélkül. Ezzel igazolható a hozzájárulás.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Megőrzés', 'Ezután a bejegyzések törlődnek.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 év',
    730 => '2 év',
    1095 => '3 év',
    1825 => '5 év',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Napi ellenőrzés', 'Beolvassa a közzétett oldalakat, felveszi a talált katalógusbeli szolgáltatásokat, és jelenti az ismeretlen címeket.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Oldalak ellenőrzésenként', 'Legfeljebb ennyi oldalt olvas be, elsőként a kezdőoldalakat.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Értesítés címe', 'E-mail-cím az új szolgáltatásokról szóló értesítésekhez. Üres = a rendszergazda címe.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Ellenőrzés most';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Vizsgálati eredmények megtekintése';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Még nem volt ellenőrzés.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Utolsó ellenőrzés: %s. Beolvasott oldalak: %s, talált szolgáltatások és címek: %s, újonnan felvéve: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = 'Beolvasott oldalak: %s, talált szolgáltatások és címek: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Új a bannerben, a hozzájárulásig blokkolva: %s. Kérjük, ellenőrizze az adatvédelmi tájékoztatót.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Ismeretlen címek, kérjük, ellenőrizze: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Nem olvasható: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Verzió: %s, utolsó módosítás: %s. Ha egy szolgáltatás megváltozik, minden látogatótól újra hozzájárulást kérünk.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Csak akkor érvényes, ha a fenti szalag be van kapcsolva: szalag nélkül semmi sem jelenik meg és semmi sincs letiltva.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Csak akkor érvényes, ha a hozzájárulásokat tároljuk (fent).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Csak akkor lép életbe, ha a szolgáltatások között van Google-szolgáltatás (pl. Google Analytics, Google Tag Manager, Google Ads).';
