<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Modifica', 'Modifica le impostazioni.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licenza';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Banner';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blocco';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Prova del consenso';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Scansione';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Versione';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'Questa estensione è gratuita. Condizione: le note legali di ogni sito su cui è in uso pubblicamente la citano con un link a https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Testo da copiare (con link):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Oppure in HTML per il codice sorgente delle note legali:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Banner dei cookie: NEO Cookie Consent di NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Mostra il banner', 'Mostra il banner su tutte le pagine e blocca i servizi fino al consenso.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Comparsa', 'Quando compare il banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Subito al caricamento della pagina',
    'scroll' => 'Dopo il primo scorrimento, clic, movimento del mouse o pressione del tasto Tab',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Posizione', 'Dove viene mostrato il banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Barra in basso',
    'top' => 'Barra in alto',
    'center' => 'Centro dello schermo',
    'left' => 'Pannello laterale a sinistra',
    'right' => 'Pannello laterale a destra',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Oscura lo sfondo', 'Sovrappone alla pagina uno strato semitrasparente finché il banner è aperto. La pagina è quindi utilizzabile solo dopo una scelta.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Pulsante per riaprire', 'Un piccolo pulsante con cui i visitatori modificano la loro scelta. Senza pulsante il sito web ha bisogno di un link, ad es. l’insert tag {{cookie_consent::settings}} nel piè di pagina. Se nello stesso angolo ci sono pulsanti di altre estensioni (accessibilità, chat), vengono disposti insieme come impostato nel layout di pagina: un pulsante impostazioni con menu, impilati o uno accanto all’altro.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'In basso a sinistra',
    'right' => 'In basso a destra',
    'none' => 'Nessun pulsante',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Informativa sulla privacy', 'Pagina a cui rimanda il banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Note legali', 'Pagina a cui rimanda il banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Blocca gli script', 'Script e caratteri dei servizi noti nelle pagine vengono eseguiti solo dopo il consenso.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Blocca i contenuti incorporati', 'Video, mappe e post mostrano un segnaposto con «Carica contenuto» fino al consenso.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Comunica la scelta ai servizi Google. Nessun servizio Google viene caricato prima del consenso.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Salva i consensi', 'Salva per ogni scelta un ID di consenso casuale, l’ora, la versione e la selezione, senza indirizzo IP. Questo consente di dimostrare un consenso.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Conserva per', 'Le voci vengono poi eliminate.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 anno',
    730 => '2 anni',
    1095 => '3 anni',
    1825 => '5 anni',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Controlla ogni giorno', 'Legge le pagine pubblicate, aggiunge i servizi del catalogo trovati e segnala gli indirizzi sconosciuti.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Pagine per controllo', 'Numero massimo di pagine lette, prima le pagine iniziali.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Segnala a', 'Indirizzo e-mail per le segnalazioni di nuovi servizi. Vuoto = indirizzo dell’amministratore di sistema.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Controlla ora';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Visualizza i risultati della scansione';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Non ancora controllato.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Ultimo controllo il %s: %s pagine lette, %s servizi e indirizzi trovati, %s aggiunti.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = '%s pagine lette, %s servizi e indirizzi trovati.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Nuovi nel banner, bloccati fino al consenso: %s. Verificare l’informativa sulla privacy.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Indirizzi sconosciuti, da verificare: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Impossibile leggere: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Versione %s, ultima modifica il %s. Quando un servizio cambia, il consenso viene richiesto di nuovo a tutti i visitatori.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Vale solo finché il banner qui sopra è attivo: senza banner non viene mostrato né bloccato nulla.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Vale solo finché i consensi vengono salvati (qui sopra).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Ha effetto solo quando tra i servizi c’è un servizio Google (p. es. Google Analytics, Google Tag Manager, Google Ads).';
