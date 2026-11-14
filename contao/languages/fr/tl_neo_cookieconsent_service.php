<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Nouveau service', 'Ajouter un service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Modifier', 'Modifier le service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Copier', 'Copier le service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Activer/désactiver', 'Activer ou désactiver le service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Supprimer', 'Supprimer le service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Détails', 'Afficher les détails.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Paramètres', 'Bandeau, blocage, preuve du consentement et analyse.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Textes', 'Textes du bandeau par langue.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Résultats de l’analyse', 'Ce que la vérification des pages a trouvé.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Preuve du consentement', 'Choix des visiteurs, sans adresse IP.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Service';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Informations pour les visiteurs';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Adresses et sites';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Activation';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Modèle', 'Service connu du catalogue : renseigne le fournisseur, la finalité, les cookies, le pays tiers et le lien vers la politique de confidentialité. Laisser vide pour un service propre.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Nom', 'Le nom du service dans le bandeau, par ex. « Google Analytics ».'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Catégorie', 'Catégorie sous laquelle les visiteurs autorisent le service. La catégorie « Nécessaires » n’est jamais bloquée.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Nécessaires',
    'functional' => 'Fonctionnels',
    'statistics' => 'Statistiques',
    'marketing' => 'Marketing',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Chargement', 'Qui charge le service.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'La page le charge, le bandeau le bloque jusqu’au consentement',
    'extension' => 'Le bandeau le charge après le consentement',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['Identifiant', 'L’identifiant du service provenant de votre compte chez le fournisseur.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'L’identifiant provenant de votre compte chez le fournisseur, par ex. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Adresse de votre propre serveur', 'Pour les services auto-hébergés comme Matomo, l’adresse avec https://, par ex. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Domaines pour la mesure inter-domaines', 'Facultatif. Vos autres domaines vers lesquels les visiteurs se rendent, p. ex. app.example.com, un par ligne. Les liens vers ces domaines transmettent la mesure, de sorte qu’une visite sur ces domaines compte comme une seule.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Veuillez saisir uniquement des noms de domaine, un par ligne, p. ex. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Code personnalisé', 'HTML ou script ajouté à l’en-tête de la page après le consentement. Réservé aux administrateurs.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Fournisseur', 'Société et lieu du fournisseur. Vide = repris du modèle.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Finalité', 'Ce que fait le service, en une phrase pour les visiteurs. Vide = repris du modèle, dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Transfert vers un pays tiers', 'Indique si des données peuvent être transférées vers des pays hors de l’UE.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'États-Unis',
    'world' => 'Pays hors de l’UE (y compris les États-Unis)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'aucun';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'Repris du modèle : %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Politique de confidentialité du fournisseur', 'Lien pour les visiteurs. Vide = repris du modèle.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Cookies', 'Nom et durée de conservation, un cookie par ligne.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Nom et durée de conservation, un cookie par ligne. Vide = repris du modèle : %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'aucun selon le modèle';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Adresses', 'Services propres uniquement : domaines dont les scripts et les contenus intégrés sont bloqués jusqu’au consentement, par ex. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Sites', 'Afficher uniquement sur ces sites. Aucune sélection = sur tous.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Actif', 'Seuls les services actifs apparaissent dans le bandeau.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Langues';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Nom (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Finalité (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Pour les sites en plusieurs langues : nom et finalité par langue. Vide = nom et finalité ci-dessus, ou le texte du modèle dans cette langue.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Service propre';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'détecté par l’analyse du %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Détecté par l’analyse du %s sur %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'Identifiant manquant';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Cet identifiant n’a pas la forme utilisée par le service, par ex. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Veuillez saisir l’adresse de votre propre serveur avec https://.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'Le bandeau cookies est désactivé. Activez-le sous « Paramètres ».';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'Aucune page de politique de confidentialité n’est sélectionnée. Veuillez la choisir sous « Paramètres » ; le bandeau y renvoie.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Adresses inconnues issues de l’analyse : %s. Veuillez les vérifier sous « Résultats de l’analyse ».';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'Le service a été ajouté et il est actif.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'Le service existe déjà. Veuillez vérifier qu’il est actif et dans la bonne catégorie.';
