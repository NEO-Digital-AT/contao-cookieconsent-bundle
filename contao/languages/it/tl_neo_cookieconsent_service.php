<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Nuovo servizio', 'Aggiungi un servizio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Modifica', 'Modifica il servizio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Copia', 'Copia il servizio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Attiva/disattiva', 'Attiva o disattiva il servizio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Elimina', 'Elimina il servizio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Dettagli', 'Mostra i dettagli.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Impostazioni', 'Banner, blocco, prova del consenso e scansione.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Testi', 'Testi del banner per lingua.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Risultati della scansione', 'Ciò che il controllo delle pagine ha trovato.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Prova del consenso', 'Scelte dei visitatori, senza indirizzo IP.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Servizio';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Informazioni per i visitatori';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Indirizzi e siti web';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Attivazione';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Modello', 'Servizio noto dal catalogo: compila fornitore, finalità, cookie, paese terzo e link all’informativa sulla privacy. Lasciare vuoto per un servizio proprio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Nome', 'Il nome del servizio nel banner, ad es. «Google Analytics».'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Categoria', 'La categoria con cui i visitatori consentono il servizio. La categoria «Necessari» non viene mai bloccata.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Necessari',
    'functional' => 'Funzionali',
    'statistics' => 'Statistiche',
    'marketing' => 'Marketing',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Caricamento', 'Chi carica il servizio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'Lo carica la pagina, il banner lo blocca fino al consenso',
    'extension' => 'Lo carica il banner dopo il consenso',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['ID', 'L’ID del servizio dal proprio account presso il fornitore.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'L’ID dal proprio account presso il fornitore, ad es. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Indirizzo del proprio server', 'Per i servizi ospitati in proprio come Matomo, l’indirizzo con https://, ad es. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domini per la misurazione tra domini', 'Facoltativo. Altri Suoi domini verso cui passano i visitatori, ad es. app.example.com, uno per riga. I link verso di essi portano con sé la misurazione, così una visita su questi domini conta come una sola.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Inserisca solo nomi di dominio, uno per riga, ad es. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Codice proprio', 'HTML o script aggiunto all’intestazione della pagina dopo il consenso. Solo per amministratori.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Fornitore', 'Azienda e sede del fornitore. Vuoto = dal modello.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Finalità', 'Cosa fa il servizio, in una frase per i visitatori. Vuoto = dal modello, nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Trasferimento in un paese terzo', 'Se i dati possono essere trasferiti in paesi al di fuori dell’UE.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'Stati Uniti',
    'world' => 'Paesi al di fuori dell’UE (compresi gli Stati Uniti)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'nessuno';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'Dal modello: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Informativa sulla privacy del fornitore', 'Link per i visitatori. Vuoto = dal modello.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Cookie', 'Nome e durata di conservazione, uno per riga.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Nome e durata di conservazione, uno per riga. Vuoto = dal modello: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'nessuno secondo il modello';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Indirizzi', 'Solo per servizi propri: domini i cui script e contenuti incorporati vengono bloccati fino al consenso, ad es. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Siti web', 'Mostra solo su questi siti web. Nessuna selezione = su tutti.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Attivo', 'Solo i servizi attivi compaiono nel banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Lingue';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Nome (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Finalità (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Per siti in più lingue: nome e finalità per lingua. Vuoto = nome e finalità sopra, oppure il testo del modello in quella lingua.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Servizio proprio';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'trovato dalla scansione del %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Trovato dalla scansione del %s su %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'ID mancante';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Questo ID non ha il formato usato dal servizio, ad es. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Inserire l’indirizzo del proprio server con https://.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'Il banner dei cookie è disattivato. Attivarlo in «Impostazioni».';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'Non è stata scelta alcuna pagina per l’informativa sulla privacy. Sceglierla in «Impostazioni»; il banner vi rimanda.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Indirizzi sconosciuti dalla scansione: %s. Verificarli in «Risultati della scansione».';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'Il servizio è stato aggiunto ed è attivo.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'Il servizio è già presente. Verifichi che sia attivo e nella categoria giusta.';
