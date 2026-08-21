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
	'AGM_PAGE_LANG_NAME'    => 'Deutsch',
	'AGM_PAGE_LANG_CODE'    => 'DE',
	'AGM_PAGE_CHOOSE'       => 'Sprache',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Wartungsarbeiten',
	'AGM_PAGE_SUBTITLE'     => 'Wir arbeiten an Verbesserungen der Seite',
	'AGM_PAGE_DESCRIPTION'  => 'Die Seite ist wegen geplanter Wartungsarbeiten vorübergehend nicht erreichbar. Wir sind bald wieder online.',
	'AGM_PAGE_FOOTER'       => 'Wir sind bald wieder da!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Alle Mitglieder werden darauf hingewiesen, dass vom {START} bis zum {END} außerplanmäßige Wartungsarbeiten am Forum stattfinden. Vielen Dank für Ihre Geduld.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Bei dringenden Fragen erreichen Sie uns hier:',
	'AGM_PAGE_ADMIN_ASK'    => 'Sind Sie Administrator?',
	'AGM_PAGE_ADMIN_BTN'    => 'Zum Administrationsbereich',
	'AGM_PAGE_REMAINING'    => 'Verbleibende Zeit',
	'AGM_PAGE_START'        => 'Beginn der Wartung',
	'AGM_PAGE_END'          => 'Voraussichtliches Ende',
	'AGM_PAGE_PROGRESS'     => 'Fortschritt der Wartung',
	'AGM_PAGE_ENDED'        => 'Die Wartung ist beendet, zurück zum Forum...',
	'AGM_PAGE_PREVIEW'      => 'Vorschau',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'Wartung LÄUFT: Die Mitglieder sehen die Wartungsseite. Sie sehen das normale Forum, weil Sie Administrator sind. Um es wie sie zu sehen, öffnen Sie das Forum in einem privaten Fenster oder aktivieren Sie „Seite auch Administratoren zeigen“ im Panel.',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'T',
	'AGM_PAGE_U_H'          => 'Std',
	'AGM_PAGE_U_M'          => 'Min',
	'AGM_PAGE_U_S'          => 'Sek',
));
