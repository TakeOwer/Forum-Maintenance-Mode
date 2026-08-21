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
	'AGM_PAGE_LANG_NAME'    => 'Română',
	'AGM_PAGE_LANG_CODE'    => 'RO',
	'AGM_PAGE_CHOOSE'       => 'Limbă',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Site în mentenanță',
	'AGM_PAGE_SUBTITLE'     => 'Lucrăm la îmbunătățirea site-ului',
	'AGM_PAGE_DESCRIPTION'  => 'Site-ul este temporar indisponibil din cauza unei mentenanțe programate. Revenim în curând.',
	'AGM_PAGE_FOOTER'       => 'Revenim în curând!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Îi informăm pe toți utilizatorii că între {START} și {END} va avea loc o mentenanță extraordinară a forumului. Vă mulțumim pentru răbdare.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Pentru urgențe, contactați-ne:',
	'AGM_PAGE_ADMIN_ASK'    => 'Sunteți administrator?',
	'AGM_PAGE_ADMIN_BTN'    => 'Mergi la panoul de administrare',
	'AGM_PAGE_REMAINING'    => 'Timp rămas',
	'AGM_PAGE_START'        => 'Începutul mentenanței',
	'AGM_PAGE_END'          => 'Sfârșit estimat',
	'AGM_PAGE_PROGRESS'     => 'Progresul mentenanței',
	'AGM_PAGE_ENDED'        => 'Mentenanța s-a încheiat, revenim pe forum...',
	'AGM_PAGE_PREVIEW'      => 'Previzualizare',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'Mentenanța este ACTIVĂ: utilizatorii văd pagina de mentenanță. Dumneavoastră vedeți forumul obișnuit pentru că sunteți administrator. Ca să o vedeți ca ei, deschideți forumul într-o fereastră privată sau activați „Arată pagina și administratorilor” în panou.',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'z',
	'AGM_PAGE_U_H'          => 'h',
	'AGM_PAGE_U_M'          => 'm',
	'AGM_PAGE_U_S'          => 's',
));
