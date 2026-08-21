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
	'AGM_PAGE_LANG_NAME'    => 'العربية',
	'AGM_PAGE_LANG_CODE'    => 'AR',
	'AGM_PAGE_CHOOSE'       => 'اللغة',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'الموقع قيد الصيانة',
	'AGM_PAGE_SUBTITLE'     => 'نعمل على تحسين الموقع',
	'AGM_PAGE_DESCRIPTION'  => 'الموقع غير متاح مؤقتاً بسبب صيانة مجدولة. سنعود قريباً.',
	'AGM_PAGE_FOOTER'       => 'سنعود قريباً!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'نُعلم جميع الأعضاء بأنه ستُجرى صيانة استثنائية للمنتدى من {START} إلى {END}. شكراً لصبركم.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'للأمور العاجلة تواصلوا معنا:',
	'AGM_PAGE_ADMIN_ASK'    => 'هل أنت مدير؟',
	'AGM_PAGE_ADMIN_BTN'    => 'الانتقال إلى لوحة الإدارة',
	'AGM_PAGE_REMAINING'    => 'الوقت المتبقي',
	'AGM_PAGE_START'        => 'بداية الصيانة',
	'AGM_PAGE_END'          => 'النهاية المتوقعة',
	'AGM_PAGE_PROGRESS'     => 'تقدّم الصيانة',
	'AGM_PAGE_ENDED'        => 'انتهت الصيانة، جارٍ العودة إلى المنتدى...',
	'AGM_PAGE_PREVIEW'      => 'معاينة',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'الصيانة جارية: الأعضاء يرون صفحة الصيانة. أنت ترى المنتدى كالمعتاد لأنك مدير. لرؤيتها كما يرونها افتح المنتدى في نافذة خاصة، أو فعّل «إظهار الصفحة للمديرين أيضاً» في اللوحة.',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'ي',
	'AGM_PAGE_U_H'          => 'س',
	'AGM_PAGE_U_M'          => 'د',
	'AGM_PAGE_U_S'          => 'ث',
));
