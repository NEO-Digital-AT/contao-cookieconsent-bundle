<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['edit'] = ['Editar', 'Editar la configuración.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_legend'] = 'Licencia';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['banner_legend'] = 'Banner';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['blocking_legend'] = 'Bloqueo';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['proof_legend'] = 'Prueba del consentimiento';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_legend'] = 'Análisis';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_legend'] = 'Versión';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_text'] = 'Esta extensión es gratuita. Condición: el aviso legal de cada sitio web en el que funcione públicamente la menciona con un enlace a https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example_label'] = 'Texto para copiar (con enlace):';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_html_label'] = 'O en HTML para el código fuente del aviso legal:';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['licence_example'] = 'Banner de cookies: NEO Cookie Consent de NEO Digital';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['active'] = ['Mostrar el banner', 'Muestra el banner en todas las páginas y bloquea los servicios hasta el consentimiento.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on'] = ['Aparece', 'Cuándo aparece el banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['show_on_options'] = [
    'immediately' => 'Inmediatamente al cargar la página',
    'scroll' => 'Tras el primer desplazamiento, clic, movimiento del ratón o pulsación de la tecla Tab',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position'] = ['Posición', 'Dónde se muestra el banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['position_options'] = [
    'bottom' => 'Barra inferior',
    'top' => 'Barra superior',
    'center' => 'Centro de la pantalla',
    'left' => 'Panel lateral izquierdo',
    'right' => 'Panel lateral derecho',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['overlay'] = ['Oscurecer el fondo', 'Coloca una capa semitransparente sobre la página mientras el banner está abierto. La página solo puede usarse después de elegir.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen'] = ['Botón para volver a abrir', 'Un pequeño botón con el que los visitantes cambian su elección. Sin él, el sitio web necesita un enlace, p. ej. el insert tag {{cookie_consent::settings}} en el pie de página. Si en la misma esquina hay botones de otras extensiones (accesibilidad, chat), se ordenan juntos según el diseño de página: un botón de configuración con menú, apilados o uno al lado del otro.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['reopen_options'] = [
    'left' => 'Abajo a la izquierda',
    'right' => 'Abajo a la derecha',
    'none' => 'Sin botón',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['privacy_page'] = ['Política de privacidad', 'Página a la que enlaza el banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['imprint_page'] = ['Aviso legal', 'Página a la que enlaza el banner.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_scripts'] = ['Bloquear scripts', 'Los scripts y las fuentes de servicios conocidos en las páginas solo se ejecutan tras el consentimiento.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['block_embeds'] = ['Bloquear contenidos integrados', 'Los vídeos, mapas y publicaciones muestran un marcador de posición con «Cargar contenido» hasta el consentimiento.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['consent_mode'] = ['Google Consent Mode v2', 'Comunica la elección a los servicios de Google. Ningún servicio de Google se carga antes del consentimiento.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log'] = ['Guardar consentimientos', 'Guarda para cada elección un ID de consentimiento aleatorio, la hora, la versión y la selección, sin dirección IP. Así se puede demostrar un consentimiento.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days'] = ['Conservar durante', 'Después, las entradas se eliminan.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['log_days_options'] = [
    365 => '1 año',
    730 => '2 años',
    1095 => '3 años',
    1825 => '5 años',
];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan'] = ['Comprobar a diario', 'Lee las páginas publicadas, añade los servicios del catálogo que encuentra e informa de las direcciones desconocidas.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_limit'] = ['Páginas por comprobación', 'Se leen como máximo estas páginas, primero las páginas de inicio.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_mail'] = ['Notificar a', 'Dirección de correo electrónico para avisos sobre nuevos servicios. Vacío = dirección del administrador del sistema.'];
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_button'] = 'Comprobar ahora';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_results'] = 'Ver los resultados del análisis';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_never'] = 'Aún no comprobado.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_last'] = 'Última comprobación el %s: %s páginas leídas, %s servicios y direcciones encontrados, %s añadidos.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_done'] = '%s páginas leídas, %s servicios y direcciones encontrados.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_added'] = 'Nuevos en el banner, bloqueados hasta el consentimiento: %s. Compruebe la política de privacidad.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_unknown'] = 'Direcciones desconocidas, compruébelas: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['scan_errors'] = 'No se han podido leer: %s';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['version_text'] = 'Versión %s, último cambio el %s. Cuando cambia un servicio, se vuelve a preguntar a todos los visitantes.';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_active'] = 'Solo tiene efecto mientras el banner de arriba esté activado: sin banner no se muestra ni se bloquea nada.';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_log'] = 'Solo tiene efecto mientras se guarden los consentimientos (arriba).';
$GLOBALS['TL_LANG']['tl_neo_cookieconsent_settings']['locked_consent_mode'] = 'Solo tiene efecto cuando entre los servicios figura un servicio de Google (p. ej. Google Analytics, Google Tag Manager, Google Ads).';
