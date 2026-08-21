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
	'AGM_PAGE_LANG_NAME'    => '日本語',
	'AGM_PAGE_LANG_CODE'    => 'JA',
	'AGM_PAGE_CHOOSE'       => '言語',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'ただいまメンテナンス中です',
	'AGM_PAGE_SUBTITLE'     => 'サイトの改善作業を行っています',
	'AGM_PAGE_DESCRIPTION'  => '計画メンテナンスのため、一時的にご利用いただけません。まもなく再開します。',
	'AGM_PAGE_FOOTER'       => 'まもなく再開します。',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => '{START} から {END} まで、フォーラムの臨時メンテナンスを実施します。ご不便をおかけしますがご了承ください。',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'お急ぎの場合はこちらまで：',
	'AGM_PAGE_ADMIN_ASK'    => '管理者の方ですか？',
	'AGM_PAGE_ADMIN_BTN'    => '管理パネルへ',
	'AGM_PAGE_REMAINING'    => '残り時間',
	'AGM_PAGE_START'        => 'メンテナンス開始',
	'AGM_PAGE_END'          => '終了予定',
	'AGM_PAGE_PROGRESS'     => 'メンテナンスの進捗',
	'AGM_PAGE_ENDED'        => 'メンテナンスが終了しました。フォーラムに戻ります...',
	'AGM_PAGE_PREVIEW'      => 'プレビュー',

	// Shown to administrators, who keep browsing while maintenance runs
	'AGM_PAGE_ADMIN_BANNER' => 'メンテナンス実施中：利用者にはメンテナンスページが表示されています。あなたは管理者なので通常のフォーラムが見えています。同じ画面を見るには、プライベートウィンドウで開くか、パネルで「管理者にもページを表示する」を有効にしてください。',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => '日',
	'AGM_PAGE_U_H'          => '時間',
	'AGM_PAGE_U_M'          => '分',
	'AGM_PAGE_U_S'          => '秒',
));
