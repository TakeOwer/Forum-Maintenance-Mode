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
	'AGM_PAGE_LANG_NAME'    => 'Čeština',
	'AGM_PAGE_LANG_CODE'    => 'CS',
	'AGM_PAGE_CHOOSE'       => 'Jazyk',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Probíhá údržba',
	'AGM_PAGE_SUBTITLE'     => 'Pracujeme na vylepšení stránek',
	'AGM_PAGE_DESCRIPTION'  => 'Stránky jsou dočasně nedostupné kvůli plánované údržbě. Brzy budeme zpět.',
	'AGM_PAGE_FOOTER'       => 'Brzy jsme zpět!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Upozorňujeme všechny uživatele, že od {START} do {END} proběhne mimořádná údržba fóra. Děkujeme za trpělivost.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'V naléhavých případech nás kontaktujte:',
	'AGM_PAGE_ADMIN_ASK'    => 'Jste správce?',
	'AGM_PAGE_ADMIN_BTN'    => 'Přejít do administrace',
	'AGM_PAGE_REMAINING'    => 'Zbývající čas',
	'AGM_PAGE_START'        => 'Začátek údržby',
	'AGM_PAGE_END'          => 'Předpokládaný konec',
	'AGM_PAGE_PROGRESS'     => 'Průběh údržby',
	'AGM_PAGE_ENDED'        => 'Údržba skončila, vracíme se na fórum...',
	'AGM_PAGE_PREVIEW'      => 'Náhled',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'd',
	'AGM_PAGE_U_H'          => 'h',
	'AGM_PAGE_U_M'          => 'm',
	'AGM_PAGE_U_S'          => 's',
));
