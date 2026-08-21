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
	'AGM_PAGE_LANG_NAME'    => 'Italiano',
	'AGM_PAGE_LANG_CODE'    => 'IT',
	'AGM_PAGE_CHOOSE'       => 'Lingua',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Sito in Manutenzione',
	'AGM_PAGE_SUBTITLE'     => 'Stiamo lavorando per migliorare il sito',
	'AGM_PAGE_DESCRIPTION'  => 'Il sito è temporaneamente non disponibile per manutenzione programmata. Torneremo presto online.',
	'AGM_PAGE_FOOTER'       => 'Torneremo presto online!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Si avvisa tutti gli utenti ed i releaser che dal {START} al {END} vi sarà un intervento di manutenzione straordinaria del forum. Grazie per la pazienza.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Per informazioni urgenti, contattaci:',
	'AGM_PAGE_ADMIN_ASK'    => 'Sei un amministratore?',
	'AGM_PAGE_ADMIN_BTN'    => 'Accedi al Pannello Admin',
	'AGM_PAGE_REMAINING'    => 'Tempo Rimanente',
	'AGM_PAGE_START'        => 'Inizio Manutenzione',
	'AGM_PAGE_END'          => 'Fine Stimata',
	'AGM_PAGE_PROGRESS'     => 'Progresso Manutenzione',
	'AGM_PAGE_ENDED'        => 'Manutenzione terminata, torniamo al forum...',
	'AGM_PAGE_PREVIEW'      => 'Anteprima',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'Manutenzione ATTIVA: gli utenti stanno vedendo la pagina di manutenzione. Tu vedi il forum normale perché sei amministratore. Per vederla come la vedono loro apri il forum in una finestra anonima, oppure attiva "Mostra la pagina anche agli amministratori" nel pannello.',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'g',
	'AGM_PAGE_U_H'          => 'h',
	'AGM_PAGE_U_M'          => 'm',
	'AGM_PAGE_U_S'          => 's',
));
