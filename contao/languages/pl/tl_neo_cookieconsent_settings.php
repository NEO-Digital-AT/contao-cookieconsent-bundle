<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Edytuj', 'Edytuj ustawienia.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licencja';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Baner';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blokowanie';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Dowód zgody';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Skanowanie';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Wersja';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'To rozszerzenie jest bezpłatne. Warunek: nota prawna każdej strony, na której działa publicznie, wymienia je z linkiem do https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Tekst do skopiowania (z linkiem):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Albo jako HTML do kodu źródłowego noty prawnej:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Baner cookie: NEO Cookie Consent firmy NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Pokazuj baner', 'Pokazuje baner na wszystkich stronach i blokuje usługi do czasu wyrażenia zgody.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Pojawia się', 'Kiedy pojawia się baner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Od razu po wczytaniu strony',
    'scroll' => 'Po pierwszym przewinięciu, kliknięciu, ruchu myszy lub naciśnięciu klawisza Tab',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Położenie', 'Gdzie wyświetlany jest baner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Pasek na dole',
    'top' => 'Pasek na górze',
    'center' => 'Środek ekranu',
    'left' => 'Panel boczny po lewej',
    'right' => 'Panel boczny po prawej',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Przyciemnij tło', 'Nakłada na stronę półprzezroczystą warstwę, dopóki baner jest otwarty. Ze strony można wtedy korzystać dopiero po dokonaniu wyboru.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Przycisk ponownego otwarcia', 'Mały przycisk, za pomocą którego odwiedzający zmieniają swój wybór. Bez niego strona potrzebuje linku, np. insert tagu {{cookie_consent::settings}} w stopce. Jeśli w tym samym rogu są przyciski innych rozszerzeń (dostępność, czat), są one ułożone razem zgodnie z ustawieniem w układzie strony: jeden przycisk ustawień z menu, jeden nad drugim lub obok siebie.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'Lewy dolny róg',
    'right' => 'Prawy dolny róg',
    'none' => 'Bez przycisku',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Polityka prywatności', 'Strona, do której prowadzi link w banerze.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Nota prawna', 'Strona, do której prowadzi link w banerze.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Blokuj skrypty', 'Skrypty i czcionki znanych usług na stronach działają dopiero po wyrażeniu zgody.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Blokuj osadzone treści', 'Filmy, mapy i posty do czasu wyrażenia zgody pokazują symbol zastępczy z przyciskiem „Wczytaj treść”.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Przekazuje wybór usługom Google. Przed wyrażeniem zgody żadna usługa Google nie jest wczytywana.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Zapisuj zgody', 'Dla każdego wyboru zapisuje losowy identyfikator zgody, czas, wersję i wybór, bez adresu IP. Pozwala to udowodnić wyrażenie zgody.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Przechowuj przez', 'Następnie wpisy są usuwane.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 rok',
    730 => '2 lata',
    1095 => '3 lata',
    1825 => '5 lat',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Sprawdzaj codziennie', 'Odczytuje opublikowane strony, dodaje znalezione usługi z katalogu i zgłasza nieznane adresy.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Stron na kontrolę', 'Odczytywanych jest najwyżej tyle stron, najpierw strony startowe.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Powiadomienia na adres', 'Adres e-mail do powiadomień o nowych usługach. Puste = adres administratora systemu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Sprawdź teraz';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Pokaż wyniki skanowania';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Jeszcze nie sprawdzono.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Ostatnia kontrola: %s. Odczytane strony: %s, znalezione usługi i adresy: %s, nowo dodane: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = 'Odczytane strony: %s, znalezione usługi i adresy: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Nowe w banerze, zablokowane do czasu wyrażenia zgody: %s. Sprawdź politykę prywatności.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Nieznane adresy do sprawdzenia: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Nie udało się odczytać: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Wersja %s, ostatnia zmiana: %s. Gdy usługa się zmieni, wszyscy odwiedzający zostaną ponownie poproszeni o zgodę.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Działa tylko, dopóki baner powyżej jest włączony: bez banera nic nie jest wyświetlane ani blokowane.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Działa tylko, dopóki zgody są zapisywane (powyżej).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Działa dopiero, gdy wśród usług jest usługa Google (np. Google Analytics, Google Tag Manager, Google Ads).';
