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
	'AGM_PAGE_LANG_NAME'    => 'Polski',
	'AGM_PAGE_LANG_CODE'    => 'PL',
	'AGM_PAGE_CHOOSE'       => 'Język',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Trwa konserwacja',
	'AGM_PAGE_SUBTITLE'     => 'Pracujemy nad ulepszeniem serwisu',
	'AGM_PAGE_DESCRIPTION'  => 'Serwis jest chwilowo niedostępny z powodu zaplanowanej konserwacji. Wkrótce wrócimy.',
	'AGM_PAGE_FOOTER'       => 'Wkrótce wracamy!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Informujemy wszystkich użytkowników, że od {START} do {END} odbędzie się nadzwyczajna konserwacja forum. Dziękujemy za cierpliwość.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'W pilnych sprawach prosimy o kontakt:',
	'AGM_PAGE_ADMIN_ASK'    => 'Jesteś administratorem?',
	'AGM_PAGE_ADMIN_BTN'    => 'Przejdź do panelu administracyjnego',
	'AGM_PAGE_REMAINING'    => 'Pozostały czas',
	'AGM_PAGE_START'        => 'Początek konserwacji',
	'AGM_PAGE_END'          => 'Przewidywany koniec',
	'AGM_PAGE_PROGRESS'     => 'Postęp konserwacji',
	'AGM_PAGE_ENDED'        => 'Konserwacja zakończona, wracamy na forum...',
	'AGM_PAGE_PREVIEW'      => 'Podgląd',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'Konserwacja TRWA: użytkownicy widzą stronę konserwacji. Ty widzisz zwykłe forum, bo jesteś administratorem. Aby zobaczyć to samo co oni, otwórz forum w oknie prywatnym albo włącz „Pokaż stronę także administratorom” w panelu.',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'd',
	'AGM_PAGE_U_H'          => 'godz',
	'AGM_PAGE_U_M'          => 'm',
	'AGM_PAGE_U_S'          => 's',
));
