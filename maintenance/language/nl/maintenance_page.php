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
	'AGM_PAGE_LANG_NAME'    => 'Nederlands',
	'AGM_PAGE_LANG_CODE'    => 'NL',
	'AGM_PAGE_CHOOSE'       => 'Taal',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Site in onderhoud',
	'AGM_PAGE_SUBTITLE'     => 'We werken aan verbeteringen van de site',
	'AGM_PAGE_DESCRIPTION'  => 'De site is tijdelijk niet bereikbaar wegens gepland onderhoud. We zijn snel weer online.',
	'AGM_PAGE_FOOTER'       => 'Tot snel weer online!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Alle leden worden erop gewezen dat er van {START} tot {END} buitengewoon onderhoud aan het forum plaatsvindt. Dank voor het geduld.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Voor dringende zaken kunt u ons bereiken:',
	'AGM_PAGE_ADMIN_ASK'    => 'Bent u beheerder?',
	'AGM_PAGE_ADMIN_BTN'    => 'Naar het beheerpaneel',
	'AGM_PAGE_REMAINING'    => 'Resterende tijd',
	'AGM_PAGE_START'        => 'Begin van het onderhoud',
	'AGM_PAGE_END'          => 'Verwacht einde',
	'AGM_PAGE_PROGRESS'     => 'Voortgang van het onderhoud',
	'AGM_PAGE_ENDED'        => 'Het onderhoud is klaar, terug naar het forum...',
	'AGM_PAGE_PREVIEW'      => 'Voorbeeld',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'd',
	'AGM_PAGE_U_H'          => 'u',
	'AGM_PAGE_U_M'          => 'm',
	'AGM_PAGE_U_S'          => 's',
));
