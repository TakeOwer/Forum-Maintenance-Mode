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
	'AGM_PAGE_LANG_NAME'    => '中文',
	'AGM_PAGE_LANG_CODE'    => 'ZH',
	'AGM_PAGE_CHOOSE'       => '语言',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => '网站维护中',
	'AGM_PAGE_SUBTITLE'     => '我们正在改进网站',
	'AGM_PAGE_DESCRIPTION'  => '因计划维护，网站暂时无法访问。我们很快就会恢复。',
	'AGM_PAGE_FOOTER'       => '我们很快回来！',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => '谨此通知各位会员：论坛将于 {START} 至 {END} 进行临时维护。感谢您的耐心等待。',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => '紧急事项请联系我们：',
	'AGM_PAGE_ADMIN_ASK'    => '您是管理员吗？',
	'AGM_PAGE_ADMIN_BTN'    => '进入管理面板',
	'AGM_PAGE_REMAINING'    => '剩余时间',
	'AGM_PAGE_START'        => '维护开始',
	'AGM_PAGE_END'          => '预计结束',
	'AGM_PAGE_PROGRESS'     => '维护进度',
	'AGM_PAGE_ENDED'        => '维护已结束，正在返回论坛…',
	'AGM_PAGE_PREVIEW'      => '预览',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => '天',
	'AGM_PAGE_U_H'          => '时',
	'AGM_PAGE_U_M'          => '分',
	'AGM_PAGE_U_S'          => '秒',
));
