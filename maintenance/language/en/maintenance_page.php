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
	'AGM_PAGE_LANG_NAME'    => 'English',
	'AGM_PAGE_LANG_CODE'    => 'EN',
	'AGM_PAGE_CHOOSE'       => 'Language',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Site under maintenance',
	'AGM_PAGE_SUBTITLE'     => 'We are working to improve the site',
	'AGM_PAGE_DESCRIPTION'  => 'The site is temporarily unavailable due to scheduled maintenance. We will be back online shortly.',
	'AGM_PAGE_FOOTER'       => 'We will be back online soon!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'All users and releasers are advised that the board will undergo extraordinary maintenance from {START} to {END}. Thank you for your patience.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'For urgent enquiries, contact us:',
	'AGM_PAGE_ADMIN_ASK'    => 'Are you an administrator?',
	'AGM_PAGE_ADMIN_BTN'    => 'Go to the Admin Panel',
	'AGM_PAGE_REMAINING'    => 'Time Remaining',
	'AGM_PAGE_START'        => 'Maintenance start',
	'AGM_PAGE_END'          => 'Estimated end',
	'AGM_PAGE_PROGRESS'     => 'Maintenance progress',
	'AGM_PAGE_ENDED'        => 'Maintenance is over, taking you back to the board...',
	'AGM_PAGE_PREVIEW'      => 'Preview',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'd',
	'AGM_PAGE_U_H'          => 'h',
	'AGM_PAGE_U_M'          => 'm',
	'AGM_PAGE_U_S'          => 's',
));
