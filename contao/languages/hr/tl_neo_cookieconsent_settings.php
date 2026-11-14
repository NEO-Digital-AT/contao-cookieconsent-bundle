<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Uredi', 'Uredi postavke.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licencija';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Banner';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blokiranje';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Dokaz privole';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Skeniranje';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Verzija';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'Ovo proširenje je besplatno. Uvjet: impresum svakog web-mjesta na kojem javno radi navodi ga s poveznicom na https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Tekst za kopiranje (s poveznicom):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Ili kao HTML za izvorni kod impresuma:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Banner za kolačiće: NEO Cookie Consent tvrtke NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Prikaži banner', 'Prikazuje banner na svim stranicama i blokira usluge do davanja privole.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Pojavljuje se', 'Kada se banner pojavljuje.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Odmah pri učitavanju stranice',
    'scroll' => 'Tek nakon prvog pomicanja stranice, klika, pomaka miša ili pritiska tipke Tab',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Položaj', 'Gdje se banner prikazuje.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Traka na dnu',
    'top' => 'Traka na vrhu',
    'center' => 'Sredina zaslona',
    'left' => 'Bočna ploča lijevo',
    'right' => 'Bočna ploča desno',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Zatamni pozadinu', 'Dok je banner otvoren, preko stranice postavlja poluprozirni sloj. Stranica se tada može koristiti tek nakon odabira.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Gumb za ponovno otvaranje', 'Mali gumb kojim posjetitelji mijenjaju svoj odabir. Bez njega web-stranici je potrebna poveznica, npr. insert tag {{cookie_consent::settings}} u podnožju. Ako su u istom kutu gumbi drugih proširenja (pristupačnost, chat), raspoređuju se zajedno kako je postavljeno u izgledu stranice: jedan gumb postavki s izbornikom, jedan iznad drugoga ili jedan pokraj drugoga.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'Dolje lijevo',
    'right' => 'Dolje desno',
    'none' => 'Bez gumba',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Pravila privatnosti', 'Stranica na koju vodi banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Impresum', 'Stranica na koju vodi banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Blokiraj skripte', 'Skripte i fontovi poznatih usluga na stranicama pokreću se tek nakon davanja privole.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Blokiraj ugrađene sadržaje', 'Videozapisi, karte i objave do davanja privole prikazuju rezervirano mjesto s gumbom „Učitaj sadržaj“.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Prenosi odabir uslugama tvrtke Google. Prije davanja privole ne učitava se nijedna usluga tvrtke Google.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Spremaj privole', 'Za svaki odabir sprema nasumični ID privole, vrijeme, verziju i odabir, bez IP adrese. Time se može dokazati privola.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Čuvaj', 'Nakon toga unosi se brišu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 godina',
    730 => '2 godine',
    1095 => '3 godine',
    1825 => '5 godina',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Provjeravaj svakodnevno', 'Čita objavljene stranice, dodaje pronađene usluge iz kataloga i prijavljuje nepoznate adrese.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Stranica po provjeri', 'Čita se najviše toliko stranica, najprije početne stranice.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Obavijesti na', 'Adresa e-pošte za obavijesti o novim uslugama. Prazno = adresa administratora sustava.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Provjeri sada';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Prikaži rezultate skeniranja';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Još nije provjereno.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Posljednja provjera dana %s. Pročitane stranice: %s, pronađene usluge i adrese: %s, novo dodano: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = 'Pročitane stranice: %s, pronađene usluge i adrese: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Novo u banneru, blokirano do davanja privole: %s. Provjerite pravila privatnosti.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Nepoznate adrese, provjerite ih: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Nije moguće pročitati: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Verzija %s, posljednja promjena dana %s. Kada se neka usluga promijeni, svi se posjetitelji ponovno pitaju za privolu.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Vrijedi samo dok je traka iznad uključena: bez trake ništa se ne prikazuje i ništa se ne blokira.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Vrijedi samo dok se privole spremaju (iznad).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Počinje vrijediti tek kad je među uslugama Google usluga (npr. Google Analytics, Google Tag Manager, Google Ads).';
