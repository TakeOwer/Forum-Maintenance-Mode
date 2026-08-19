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
	'AGM_PAGE_LANG_NAME'    => 'Português',
	'AGM_PAGE_LANG_CODE'    => 'PT',
	'AGM_PAGE_CHOOSE'       => 'Idioma',

	// The four texts an administrator can override from the settings panel
	'AGM_PAGE_TITLE'        => 'Site em manutenção',
	'AGM_PAGE_SUBTITLE'     => 'Estamos a trabalhar para melhorar o site',
	'AGM_PAGE_DESCRIPTION'  => 'O site está temporariamente indisponível por manutenção programada. Voltaremos a estar online em breve.',
	'AGM_PAGE_FOOTER'       => 'Voltamos em breve!',

	// Advance notice shown across the board before maintenance starts.
	// {START}, {END} and {SITENAME} are replaced with the real values.
	'AGM_PAGE_NOTICE'       => 'Informamos todos os utilizadores de que de {START} a {END} decorrerá uma manutenção extraordinária do fórum. Obrigado pela paciência.',

	// Fixed labels of the page
	'AGM_PAGE_CONTACT'      => 'Para assuntos urgentes, contacte-nos:',
	'AGM_PAGE_ADMIN_ASK'    => 'É administrador?',
	'AGM_PAGE_ADMIN_BTN'    => 'Ir para o painel de administração',
	'AGM_PAGE_REMAINING'    => 'Tempo restante',
	'AGM_PAGE_START'        => 'Início da manutenção',
	'AGM_PAGE_END'          => 'Fim estimado',
	'AGM_PAGE_PROGRESS'     => 'Progresso da manutenção',
	'AGM_PAGE_ENDED'        => 'A manutenção terminou, a regressar ao fórum...',
	'AGM_PAGE_PREVIEW'      => 'Pré-visualização',

	// Countdown units, keep them as short as possible
	'AGM_PAGE_U_D'          => 'd',
	'AGM_PAGE_U_H'          => 'h',
	'AGM_PAGE_U_M'          => 'm',
	'AGM_PAGE_U_S'          => 's',
));
