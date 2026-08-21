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
	'AGM_PAGE_LANG_NAME'    => 'Magyar',
	'AGM_PAGE_LANG_CODE'    => 'HU',
	'AGM_PAGE_CHOOSE'       => 'Nyelv',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Karbantartás folyik',
	'AGM_PAGE_SUBTITLE'     => 'Az oldal fejlesztésén dolgozunk',
	'AGM_PAGE_DESCRIPTION'  => 'Az oldal tervezett karbantartás miatt átmenetileg nem érhető el. Hamarosan visszatérünk.',
	'AGM_PAGE_FOOTER'       => 'Hamarosan visszatérünk!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Tájékoztatjuk a felhasználókat, hogy {START} és {END} között rendkívüli karbantartás lesz a fórumon. Köszönjük a türelmet.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Sürgős ügyben keressen minket:',
	'AGM_PAGE_ADMIN_ASK'    => 'Ön adminisztrátor?',
	'AGM_PAGE_ADMIN_BTN'    => 'Ugrás az adminisztrációhoz',
	'AGM_PAGE_REMAINING'    => 'Hátralévő idő',
	'AGM_PAGE_START'        => 'A karbantartás kezdete',
	'AGM_PAGE_END'          => 'Várható befejezés',
	'AGM_PAGE_PROGRESS'     => 'A karbantartás állása',
	'AGM_PAGE_ENDED'        => 'A karbantartás véget ért, visszatérünk a fórumra...',
	'AGM_PAGE_PREVIEW'      => 'Előnézet',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'A karbantartás FUT: a felhasználók a karbantartási oldalt látják. Ön a szokásos fórumot látja, mert adminisztrátor. Ha úgy szeretné látni, ahogy ők, nyissa meg a fórumot privát ablakban, vagy kapcsolja be a panelen az „Oldal megjelenítése az adminisztrátoroknak is” lehetőséget.',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'n',
	'AGM_PAGE_U_H'          => 'ó',
	'AGM_PAGE_U_M'          => 'p',
	'AGM_PAGE_U_S'          => 'mp',
));
