<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Uredi', 'Uredi nastavitve.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licenca';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Pasica';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blokiranje';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Dokazilo o soglasju';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Pregled';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Različica';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'Ta razširitev je brezplačna. Pogoj: pravno obvestilo vsakega spletnega mesta, na katerem javno deluje, jo navaja s povezavo na https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Besedilo za kopiranje (s povezavo):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Ali kot HTML za izvorno kodo pravnega obvestila:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Pasica za piškotke: NEO Cookie Consent podjetja NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Prikaži pasico', 'Prikaže pasico na vseh straneh in do soglasja blokira storitve.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Prikaz', 'Kdaj se pasica prikaže.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Takoj ob nalaganju strani',
    'scroll' => 'Šele po prvem drsenju, kliku, premiku miške ali pritisku tipke Tab',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Položaj', 'Kje je pasica prikazana.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Vrstica spodaj',
    'top' => 'Vrstica zgoraj',
    'center' => 'Sredina zaslona',
    'left' => 'Stranska plošča levo',
    'right' => 'Stranska plošča desno',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Zatemni ozadje', 'Dokler je pasica odprta, prekrije stran s prosojno plastjo. Stran je tedaj mogoče uporabljati šele po izbiri.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Gumb za ponovno odpiranje', 'Majhen gumb, s katerim obiskovalci spremenijo svojo izbiro. Brez njega spletno mesto potrebuje povezavo, npr. insert tag {{cookie_consent::settings}} v nogi. Če so v istem kotu gumbi drugih razširitev (dostopnost, klepet), so razporejeni skupaj, kot je nastavljeno v postavitvi strani: en gumb za nastavitve z menijem, drug nad drugim ali drug ob drugem.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'Spodaj levo',
    'right' => 'Spodaj desno',
    'none' => 'Brez gumba',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Politika zasebnosti', 'Stran, na katero se poveže pasica.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Pravno obvestilo', 'Stran, na katero se poveže pasica.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Blokiraj skripte', 'Skripte in pisave znanih storitev na straneh se zaženejo šele po soglasju.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Blokiraj vdelano vsebino', 'Videoposnetki, zemljevidi in objave do soglasja prikazujejo nadomestni element z gumbom „Naloži vsebino“.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Sporoči izbiro storitvam Google. Pred soglasjem se ne naloži nobena storitev Google.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Shranjuj soglasja', 'Za vsako izbiro shrani naključni ID soglasja, čas, različico in izbiro, brez naslova IP. S tem je mogoče dokazati soglasje.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Hrani', 'Nato se vnosi izbrišejo.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 leto',
    730 => '2 leti',
    1095 => '3 leta',
    1825 => '5 let',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Preverjaj dnevno', 'Prebere objavljene strani, doda najdene storitve iz kataloga in sporoči neznane naslove.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Strani na preverjanje', 'Prebere se največ toliko strani, najprej začetne strani.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Obvestila na', 'E-poštni naslov za obvestila o novih storitvah. Prazno = naslov sistemskega skrbnika.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Preveri zdaj';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Ogled rezultatov pregleda';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Še ni preverjeno.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Zadnje preverjanje dne %s. Prebrane strani: %s, najdene storitve in naslovi: %s, na novo dodano: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = 'Prebrane strani: %s, najdene storitve in naslovi: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Novo v pasici, do soglasja blokirano: %s. Preverite politiko zasebnosti.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Neznani naslovi, preverite jih: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Ni bilo mogoče prebrati: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Različica %s, nazadnje spremenjeno dne %s. Ko se storitev spremeni, vse obiskovalce ponovno vprašamo za soglasje.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Velja le, dokler je pasica zgoraj vklopljena: brez pasice se nič ne prikaže in nič ne blokira.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Velja le, dokler se privolitve shranjujejo (zgoraj).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Začne veljati šele, ko je med storitvami storitev Google (npr. Google Analytics, Google Tag Manager, Google Ads).';
