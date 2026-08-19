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
	'AGM_PAGE_LANG_NAME'    => 'Türkçe',
	'AGM_PAGE_LANG_CODE'    => 'TR',
	'AGM_PAGE_CHOOSE'       => 'Dil',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Site bakımda',
	'AGM_PAGE_SUBTITLE'     => 'Siteyi geliştirmek için çalışıyoruz',
	'AGM_PAGE_DESCRIPTION'  => 'Site planlı bakım nedeniyle geçici olarak kullanılamıyor. Kısa süre içinde geri döneceğiz.',
	'AGM_PAGE_FOOTER'       => 'Yakında görüşmek üzere!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Tüm üyelerimize duyurulur: {START} ile {END} arasında forumda olağanüstü bakım yapılacaktır. Sabrınız için teşekkür ederiz.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Acil durumlar için bize ulaşın:',
	'AGM_PAGE_ADMIN_ASK'    => 'Yönetici misiniz?',
	'AGM_PAGE_ADMIN_BTN'    => 'Yönetim paneline git',
	'AGM_PAGE_REMAINING'    => 'Kalan süre',
	'AGM_PAGE_START'        => 'Bakımın başlangıcı',
	'AGM_PAGE_END'          => 'Tahmini bitiş',
	'AGM_PAGE_PROGRESS'     => 'Bakımın ilerleyişi',
	'AGM_PAGE_ENDED'        => 'Bakım bitti, foruma dönülüyor...',
	'AGM_PAGE_PREVIEW'      => 'Önizleme',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'g',
	'AGM_PAGE_U_H'          => 'sa',
	'AGM_PAGE_U_M'          => 'dk',
	'AGM_PAGE_U_S'          => 'sn',
));
