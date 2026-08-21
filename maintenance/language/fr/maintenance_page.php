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
	'AGM_PAGE_LANG_NAME'    => 'Français',
	'AGM_PAGE_LANG_CODE'    => 'FR',
	'AGM_PAGE_CHOOSE'       => 'Langue',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Site en maintenance',
	'AGM_PAGE_SUBTITLE'     => 'Nous travaillons à améliorer le site',
	'AGM_PAGE_DESCRIPTION'  => 'Le site est momentanément indisponible pour une maintenance programmée. Nous serons de retour très bientôt.',
	'AGM_PAGE_FOOTER'       => 'À très bientôt en ligne !',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Tous les membres sont informés qu\'une maintenance exceptionnelle du forum aura lieu du {START} au {END}. Merci de votre patience.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Pour toute urgence, contactez-nous :',
	'AGM_PAGE_ADMIN_ASK'    => 'Vous êtes administrateur ?',
	'AGM_PAGE_ADMIN_BTN'    => 'Accéder au panneau d\'administration',
	'AGM_PAGE_REMAINING'    => 'Temps restant',
	'AGM_PAGE_START'        => 'Début de la maintenance',
	'AGM_PAGE_END'          => 'Fin estimée',
	'AGM_PAGE_PROGRESS'     => 'Progression de la maintenance',
	'AGM_PAGE_ENDED'        => 'La maintenance est terminée, retour au forum...',
	'AGM_PAGE_PREVIEW'      => 'Aperçu',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'Maintenance ACTIVE : les membres voient la page de maintenance. Vous voyez le forum normal parce que vous êtes administrateur. Pour la voir comme eux, ouvrez le forum dans une fenêtre privée, ou activez « Montrer la page aux administrateurs également » dans le panneau.',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'j',
	'AGM_PAGE_U_H'          => 'h',
	'AGM_PAGE_U_M'          => 'm',
	'AGM_PAGE_U_S'          => 's',
));
