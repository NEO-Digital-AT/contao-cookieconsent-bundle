<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['new'] = ['Nuevo servicio', 'Añadir un servicio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['edit'] = ['Editar', 'Editar el servicio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['copy'] = ['Copiar', 'Copiar el servicio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['toggle'] = ['Activar/desactivar', 'Activar o desactivar el servicio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['delete'] = ['Eliminar', 'Eliminar el servicio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['show'] = ['Detalles', 'Mostrar los detalles.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['settings'] = ['Configuración', 'Banner, bloqueo, prueba del consentimiento y análisis.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['texts'] = ['Textos', 'Textos del banner por idioma.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['findings'] = ['Resultados del análisis', 'Lo que ha encontrado la comprobación de las páginas.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['log'] = ['Prueba del consentimiento', 'Elecciones de los visitantes, sin dirección IP.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['service_legend'] = 'Servicio';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['details_legend'] = 'Información para los visitantes';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['scope_legend'] = 'Direcciones y sitios web';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['publish_legend'] = 'Activación';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['template'] = ['Plantilla', 'Servicio conocido del catálogo: rellena proveedor, finalidad, cookies, tercer país y enlace a la política de privacidad. Dejar vacío para un servicio propio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['title'] = ['Nombre', 'El nombre del servicio en el banner, p. ej. «Google Analytics».'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category'] = ['Categoría', 'En qué categoría permiten los visitantes el servicio. La categoría «Necesarias» nunca se bloquea.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['category_options'] = [
    'necessary' => 'Necesarias',
    'functional' => 'Funcionales',
    'statistics' => 'Estadísticas',
    'marketing' => 'Marketing',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading'] = ['Carga', 'Quién carga el servicio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['loading_options'] = [
    'page' => 'Lo carga la página, el banner lo bloquea hasta el consentimiento',
    'extension' => 'Lo carga el banner tras el consentimiento',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id'] = ['ID', 'El ID del servicio de su cuenta con el proveedor.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_id_help'] = 'El ID de su cuenta con el proveedor, p. ej. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tracking_url'] = ['Dirección de su propio servidor', 'Para servicios alojados en su propio servidor, como Matomo, la dirección con https://, p. ej. https://stats.example.com/.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_domains'] = ['Dominios para la medición entre dominios', 'Opcional. Otros dominios suyos a los que pasan los visitantes, p. ej. app.example.com, uno por línea. Los enlaces a ellos llevan la medición consigo, de modo que una visita entre estos dominios cuenta como una sola.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['linker_invalid'] = 'Introduzca solo nombres de dominio, uno por línea, p. ej. app.example.com.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['code'] = ['Código propio', 'HTML o script que se añade a la cabecera de la página tras el consentimiento. Solo para administradores.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['provider'] = ['Proveedor', 'Empresa y sede del proveedor. Vacío = de la plantilla.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['purpose'] = ['Finalidad', 'Qué hace el servicio, en una frase para los visitantes. Vacío = de la plantilla, en el idioma de la página.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer'] = ['Transferencia a un tercer país', 'Si los datos pueden ir a países fuera de la UE.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_options'] = [
    'us' => 'EE. UU.',
    'world' => 'Países fuera de la UE (incluido EE. UU.)',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['transfer_none'] = 'ninguna';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['from_template'] = 'De la plantilla: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['privacy_url'] = ['Política de privacidad del proveedor', 'Enlace para los visitantes. Vacío = de la plantilla.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies'] = ['Cookies', 'Nombre y plazo de conservación, una cookie por línea.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_template'] = 'Nombre y plazo de conservación, una cookie por línea. Vacío = de la plantilla: %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['cookies_none'] = 'ninguna según la plantilla';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['hosts'] = ['Direcciones', 'Solo para servicios propios: dominios cuyos scripts y contenidos integrados se bloquean hasta el consentimiento, p. ej. widget.example.com.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['roots'] = ['Sitios web', 'Mostrar solo en estos sitios web. Ninguna selección = en todos.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['published'] = ['Activo', 'Solo los servicios activos aparecen en el banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['languages_legend'] = 'Idiomas';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_title'] = 'Nombre (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_purpose'] = 'Finalidad (%s)';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['tr_help'] = 'Para sitios web en varios idiomas: nombre y finalidad por idioma. Vacío = nombre y finalidad de arriba, o el texto de la plantilla en ese idioma.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['own_service'] = 'Servicio propio';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_by_scan'] = 'encontrado por el análisis del %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['found_text'] = 'Encontrado por el análisis del %s en %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_missing'] = 'Falta el ID';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['id_invalid'] = 'Este ID no tiene el formato que usa el servicio, p. ej. %s.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['url_required'] = 'Introduzca la dirección de su propio servidor con https://.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_inactive'] = 'El banner de cookies está desactivado. Actívelo en «Configuración».';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_privacy'] = 'No se ha elegido ninguna página de política de privacidad. Elíjala en «Configuración»; el banner enlaza a ella.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['note_unknown'] = 'Direcciones desconocidas del análisis: %s. Compruébelas en «Resultados del análisis».';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_done'] = 'El servicio se ha añadido y está activo.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_service']['add_exists'] = 'El servicio ya figura en la lista. Compruebe que está activo y en la categoría correcta.';
