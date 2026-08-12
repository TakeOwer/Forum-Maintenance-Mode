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

class add_board_sync extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['agm_sync_board_disable']);
	}

	public static function depends_on()
	{
		return array('\salvocortesiano\maintenance\migrations\add_countdown_card');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('agm_version', '1.2.0')),

			// Mirror the switch onto phpBB's own "Disable board" setting
			array('config.add', array('agm_sync_board_disable', 1)),
			array('config.add', array('agm_prev_board_disable', 0)),

			// Let administrators see the maintenance page while testing
			array('config.add', array('agm_show_to_admins', 0)),
		);
	}
}
