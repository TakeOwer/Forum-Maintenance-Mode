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
	'AGM_PAGE_LANG_NAME'    => 'Ελληνικά',
	'AGM_PAGE_LANG_CODE'    => 'EL',
	'AGM_PAGE_CHOOSE'       => 'Γλώσσα',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Ο ιστότοπος συντηρείται',
	'AGM_PAGE_SUBTITLE'     => 'Εργαζόμαστε για τη βελτίωση του ιστότοπου',
	'AGM_PAGE_DESCRIPTION'  => 'Ο ιστότοπος δεν είναι προσωρινά διαθέσιμος λόγω προγραμματισμένης συντήρησης. Επιστρέφουμε σύντομα.',
	'AGM_PAGE_FOOTER'       => 'Τα λέμε σύντομα!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Ενημερώνονται όλα τα μέλη ότι από {START} έως {END} θα γίνει έκτακτη συντήρηση του φόρουμ. Ευχαριστούμε για την υπομονή σας.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Για επείγοντα θέματα επικοινωνήστε μαζί μας:',
	'AGM_PAGE_ADMIN_ASK'    => 'Είστε διαχειριστής;',
	'AGM_PAGE_ADMIN_BTN'    => 'Μετάβαση στον πίνακα διαχείρισης',
	'AGM_PAGE_REMAINING'    => 'Χρόνος που απομένει',
	'AGM_PAGE_START'        => 'Έναρξη συντήρησης',
	'AGM_PAGE_END'          => 'Εκτιμώμενη λήξη',
	'AGM_PAGE_PROGRESS'     => 'Πρόοδος συντήρησης',
	'AGM_PAGE_ENDED'        => 'Η συντήρηση ολοκληρώθηκε, επιστροφή στο φόρουμ...',
	'AGM_PAGE_PREVIEW'      => 'Προεπισκόπηση',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'η',
	'AGM_PAGE_U_H'          => 'ώ',
	'AGM_PAGE_U_M'          => 'λ',
	'AGM_PAGE_U_S'          => 'δ',
));
