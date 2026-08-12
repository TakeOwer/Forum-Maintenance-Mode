<?php
/**
 * Forum Maintenance Mode - phpBB extension
 *
 * @author     Salvo Cortesiano
 * @copyright  (c) 2026-08-11 20:00 CEST Salvo Cortesiano
 * @link       https://netshadows.de/ombra/
 * @license    GNU General Public License, version 2 (GPL-2.0)
 */

namespace salvocortesiano\maintenance\migrations;

class install_maintenance extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['agm_version']);
	}

	/**
	 * No core dependency: this migration only adds config entries, an ACP
	 * module and a permission, all available on any phpBB 3.3 board.
	 */
	public static function depends_on()
	{
		return array();
	}

	public function update_data()
	{
		$messages = \salvocortesiano\maintenance\core\helper::default_messages();

		return array(
			// Version marker
			array('config.add', array('agm_version', '1.0.0')),

			// Switch and schedule
			array('config.add', array('agm_enabled', 0)),
			array('config.add', array('agm_use_schedule', 0)),
			array('config.add', array('agm_auto_off', 1)),
			array('config.add', array('agm_start', 0)),
			array('config.add', array('agm_end', 0)),

			// Contacts and branding
			array('config.add', array('agm_contact_email', '')),
			array('config.add', array('agm_contact_phone', '')),
			array('config.add', array('agm_logo_url', '')),
			array('config.add', array('agm_default_lang', 'it')),

			// Page features
			array('config.add', array('agm_particles', 1)),
			array('config.add', array('agm_show_gear', 1)),
			array('config.add', array('agm_spin_gear', 1)),
			array('config.add', array('agm_countdown', 1)),
			array('config.add', array('agm_lang_switcher', 1)),
			array('config.add', array('agm_show_admin_link', 1)),
			array('config.add', array('agm_refresh', 30)),

			// Colour palette
			array('config.add', array('agm_color_bg_start', '#0f1c3f')),
			array('config.add', array('agm_color_bg_end', '#1d4ed8')),
			array('config.add', array('agm_color_topbar', '#0b1120')),
			array('config.add', array('agm_color_accent', '#3b82f6')),
			array('config.add', array('agm_color_text', '#f8fafc')),
			array('config.add', array('agm_color_muted', '#c7d2fe')),
			array('config.add', array('agm_color_card', '#16255180')),

			// Activation log
			array('config.add', array('agm_last_on', 0)),
			array('config.add', array('agm_last_off', 0)),
			array('config.add', array('agm_total_activations', 0)),

			// Editable texts
			array('config_text.add', array('agm_messages', json_encode($messages))),

			// Bypass permission (administrators already bypass by ACL check)
			array('permission.add', array('u_agm_bypass', true)),

			// ACP module
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_AGM_TITLE')),
			array('module.add', array('acp', 'ACP_AGM_TITLE', array(
				'module_basename'	=> '\salvocortesiano\maintenance\acp\main_module',
				'modes'				=> array('settings'),
			))),
		);
	}
}
