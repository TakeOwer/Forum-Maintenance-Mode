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
	'AGM_PAGE_LANG_NAME'    => 'Русский',
	'AGM_PAGE_LANG_CODE'    => 'RU',
	'AGM_PAGE_CHOOSE'       => 'Язык',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Сайт на обслуживании',
	'AGM_PAGE_SUBTITLE'     => 'Мы работаем над улучшением сайта',
	'AGM_PAGE_DESCRIPTION'  => 'Сайт временно недоступен из-за планового обслуживания. Мы скоро вернёмся.',
	'AGM_PAGE_FOOTER'       => 'Скоро вернёмся!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Уведомляем всех пользователей, что с {START} по {END} будет проводиться внеплановое обслуживание форума. Спасибо за терпение.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'По срочным вопросам пишите нам:',
	'AGM_PAGE_ADMIN_ASK'    => 'Вы администратор?',
	'AGM_PAGE_ADMIN_BTN'    => 'Перейти в панель управления',
	'AGM_PAGE_REMAINING'    => 'Осталось времени',
	'AGM_PAGE_START'        => 'Начало обслуживания',
	'AGM_PAGE_END'          => 'Ожидаемое окончание',
	'AGM_PAGE_PROGRESS'     => 'Ход обслуживания',
	'AGM_PAGE_ENDED'        => 'Обслуживание завершено, возвращаемся на форум...',
	'AGM_PAGE_PREVIEW'      => 'Предпросмотр',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'д',
	'AGM_PAGE_U_H'          => 'ч',
	'AGM_PAGE_U_M'          => 'м',
	'AGM_PAGE_U_S'          => 'с',
));
