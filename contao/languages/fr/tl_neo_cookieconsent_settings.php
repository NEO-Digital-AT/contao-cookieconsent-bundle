<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Modifier', 'Modifier les paramètres.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licence';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Bandeau';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Blocage';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Preuve du consentement';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Analyse';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Version';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'Cette extension est gratuite. Condition : les mentions légales de chaque site sur lequel elle fonctionne publiquement la citent avec un lien vers https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Texte à copier (avec lien) :';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'Ou en HTML pour le code source des mentions légales :';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Bandeau cookies : NEO Cookie Consent de NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Afficher le bandeau', 'Affiche le bandeau sur toutes les pages et bloque les services jusqu’au consentement.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Apparition', 'Quand le bandeau apparaît.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Dès le chargement de la page',
    'scroll' => 'Après le premier défilement, clic, mouvement de la souris ou appui sur la touche Tab',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Position', 'Où le bandeau s’affiche.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Barre en bas',
    'top' => 'Barre en haut',
    'center' => 'Centre de l’écran',
    'left' => 'Panneau latéral gauche',
    'right' => 'Panneau latéral droit',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Assombrir l’arrière-plan', 'Place un voile semi-transparent sur la page tant que le bandeau est ouvert. La page n’est alors utilisable qu’après un choix.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Bouton de réouverture', 'Un petit bouton avec lequel les visiteurs modifient leur choix. Sans ce bouton, le site a besoin d’un lien, par ex. l’insert tag {{cookie_consent::settings}} dans le pied de page. Si des boutons d’autres extensions (accessibilité, chat) se trouvent dans le même coin, ils sont disposés ensemble comme réglé dans la mise en page : un bouton de paramètres avec un menu, empilés ou côte à côte.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'En bas à gauche',
    'right' => 'En bas à droite',
    'none' => 'Pas de bouton',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Politique de confidentialité', 'Page vers laquelle renvoie le bandeau.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Mentions légales', 'Page vers laquelle renvoie le bandeau.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Bloquer les scripts', 'Les scripts et les polices des services connus dans les pages ne s’exécutent qu’après le consentement.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Bloquer les contenus intégrés', 'Les vidéos, cartes et publications affichent un espace réservé avec « Charger le contenu » jusqu’au consentement.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Transmet le choix aux services Google. Aucun service Google ne se charge avant le consentement.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Enregistrer les consentements', 'Enregistre pour chaque choix un identifiant de consentement aléatoire, l’heure, la version et la sélection, sans adresse IP. Cela permet de prouver un consentement.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Conserver pendant', 'Les entrées sont ensuite supprimées.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 an',
    730 => '2 ans',
    1095 => '3 ans',
    1825 => '5 ans',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Vérifier chaque jour', 'Lit les pages publiées, ajoute les services du catalogue trouvés et signale les adresses inconnues.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Pages par vérification', 'Nombre maximal de pages lues, en commençant par les pages d’accueil.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Signaler à', 'Adresse e-mail pour les signalements de nouveaux services. Vide = adresse de l’administrateur système.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Vérifier maintenant';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Voir les résultats de l’analyse';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Pas encore vérifié.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Dernière vérification le %s : %s pages lues, %s services et adresses trouvés, %s ajoutés.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = '%s pages lues, %s services et adresses trouvés.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Nouveaux dans le bandeau, bloqués jusqu’au consentement : %s. Veuillez vérifier la politique de confidentialité.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Adresses inconnues, à vérifier : %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'Lecture impossible : %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Version %s, dernière modification le %s. Lorsqu’un service change, le consentement de tous les visiteurs est à nouveau demandé.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Ne s’applique que tant que la bannière est activée ci-dessus : sans bannière, rien n’est affiché ni bloqué.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Ne s’applique que tant que les consentements sont enregistrés (ci-dessus).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Ne prend effet qu’une fois qu’un service Google (p. ex. Google Analytics, Google Tag Manager, Google Ads) figure parmi les services.';
