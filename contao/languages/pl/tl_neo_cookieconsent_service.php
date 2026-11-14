<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Nowa usługa', 'Dodaj usługę.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Edytuj', 'Edytuj usługę.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Kopiuj', 'Kopiuj usługę.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Włącz/wyłącz', 'Włącz lub wyłącz usługę.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Usuń', 'Usuń usługę.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Szczegóły', 'Pokaż szczegóły.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Ustawienia', 'Baner, blokowanie, dowód zgody i skanowanie.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Teksty', 'Teksty banera dla poszczególnych języków.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Wyniki skanowania', 'Co wykryła kontrola stron.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Dowód zgody', 'Wybory odwiedzających, bez adresu IP.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Usługa';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Informacje dla odwiedzających';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Adresy i strony internetowe';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Aktywacja';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Szablon', 'Znana usługa z katalogu: uzupełnia dostawcę, cel, pliki cookie, państwo trzecie i link do polityki prywatności. Pozostaw puste dla własnej usługi.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Nazwa', 'Nazwa usługi w banerze, np. „Google Analytics”.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Kategoria', 'W jakiej kategorii odwiedzający zezwalają na usługę. Kategoria „Niezbędne” nigdy nie jest blokowana.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Niezbędne',
    'functional' => 'Funkcjonalne',
    'statistics' => 'Statystyczne',
    'marketing' => 'Marketingowe',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Wczytywanie', 'Kto wczytuje usługę.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'Wczytuje ją strona, baner blokuje ją do czasu wyrażenia zgody',
    'extension' => 'Baner wczytuje ją po wyrażeniu zgody',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['Identyfikator', 'Identyfikator usługi z Twojego konta u dostawcy.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'Identyfikator z Twojego konta u dostawcy, np. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Adres własnego serwera', 'W przypadku usług hostowanych samodzielnie, takich jak Matomo, adres z https://, np. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domeny do pomiaru między domenami', 'Opcjonalnie. Inne Państwa domeny, na które przechodzą odwiedzający, np. app.example.com, jedna w wierszu. Linki do nich przenoszą pomiar, dzięki czemu wizyta na tych domenach liczy się jako jedna.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Proszę wpisać tylko nazwy domen, jedną w wierszu, np. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Własny kod', 'HTML lub skrypt dodawany do nagłówka strony po wyrażeniu zgody. Tylko dla administratorów.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Dostawca', 'Firma i siedziba dostawcy. Puste = z szablonu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Cel', 'Co robi usługa, w jednym zdaniu dla odwiedzających. Puste = z szablonu, w języku strony.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Przekazywanie do państwa trzeciego', 'Czy dane mogą trafiać do krajów spoza UE.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'USA',
    'world' => 'Kraje spoza UE (w tym USA)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'brak';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'Z szablonu: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Polityka prywatności dostawcy', 'Link dla odwiedzających. Puste = z szablonu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Pliki cookie', 'Nazwa i okres przechowywania, jeden plik w każdym wierszu.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Nazwa i okres przechowywania, jeden plik w każdym wierszu. Puste = z szablonu: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'brak według szablonu';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Adresy', 'Tylko dla własnych usług: domeny, których skrypty i osadzone treści są blokowane do czasu wyrażenia zgody, np. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Strony internetowe', 'Pokazuj tylko na tych stronach internetowych. Brak wyboru = na wszystkich.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Aktywna', 'Tylko aktywne usługi pojawiają się w banerze.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Języki';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Nazwa (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Cel (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Dla stron w kilku językach: nazwa i cel dla każdego języka. Puste = nazwa i cel powyżej albo tekst szablonu w tym języku.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Własna usługa';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'wykryto podczas skanowania z dnia %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Wykryto podczas skanowania z dnia %s na stronie %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'Brak identyfikatora';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Ten identyfikator nie ma formatu używanego przez usługę, np. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Podaj adres własnego serwera z https://.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'Baner cookie jest wyłączony. Włącz go w sekcji „Ustawienia”.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'Nie wybrano strony z polityką prywatności. Wybierz ją w sekcji „Ustawienia”; baner zawiera do niej link.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Nieznane adresy ze skanowania: %s. Sprawdź je w sekcji „Wyniki skanowania”.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'Usługa została dodana i jest aktywna.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'Usługa jest już na liście. Proszę sprawdzić, czy jest aktywna i w odpowiedniej kategorii.';
