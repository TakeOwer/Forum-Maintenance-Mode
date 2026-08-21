<?php
/**
 * Forum Maintenance Mode - phpBB extension
 *
 * @author     Salvo Cortesiano
 * @copyright  (c) 2026-08-11 20:00 CEST Salvo Cortesiano
 * @link       https://netshadows.de/ombra/
 * @license    GNU General Public License, version 2 (GPL-2.0)
 *
 * Texts of the maintenance page, the ones your visitors read.
 *
 * To add a language: copy this file into language/<code>/ next to the phpBB
 * language pack of the same name, translate the values, done. The page finds
 * it on its own and adds it to the chooser: no code to touch.
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	// Shown in the language chooser at the top of the page
	'AGM_PAGE_LANG_NAME'    => 'Español',
	'AGM_PAGE_LANG_CODE'    => 'ES',
	'AGM_PAGE_CHOOSE'       => 'Idioma',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Sitio en mantenimiento',
	'AGM_PAGE_SUBTITLE'     => 'Estamos trabajando para mejorar el sitio',
	'AGM_PAGE_DESCRIPTION'  => 'El sitio no está disponible temporalmente por mantenimiento programado. Volveremos a estar en línea muy pronto.',
	'AGM_PAGE_FOOTER'       => '¡Volveremos pronto!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Se informa a todos los usuarios de que del {START} al {END} se realizará un mantenimiento extraordinario del foro. Gracias por la paciencia.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Para asuntos urgentes, contáctanos:',
	'AGM_PAGE_ADMIN_ASK'    => '¿Eres administrador?',
	'AGM_PAGE_ADMIN_BTN'    => 'Ir al panel de administración',
	'AGM_PAGE_REMAINING'    => 'Tiempo restante',
	'AGM_PAGE_START'        => 'Inicio del mantenimiento',
	'AGM_PAGE_END'          => 'Fin estimado',
	'AGM_PAGE_PROGRESS'     => 'Progreso del mantenimiento',
	'AGM_PAGE_ENDED'        => 'El mantenimiento ha terminado, volvemos al foro...',
	'AGM_PAGE_PREVIEW'      => 'Vista previa',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'Mantenimiento ACTIVO: los usuarios están viendo la página de mantenimiento. Tú ves el foro normal porque eres administrador. Para verla como ellos, abre el foro en una ventana privada o activa «Mostrar la página también a los administradores» en el panel.',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'd',
	'AGM_PAGE_U_H'          => 'h',
	'AGM_PAGE_U_M'          => 'm',
	'AGM_PAGE_U_S'          => 's',
));
