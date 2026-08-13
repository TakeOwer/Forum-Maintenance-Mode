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

class add_notice extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['agm_notice']);
	}

	public static function depends_on()
	{
		return array('\salvocortesiano\maintenance\migrations\add_board_sync');
	}

	/**
	 * The notice text itself needs no migration: get_messages() starts from the
	 * built-in defaults and only overrides the fields the admin has actually
	 * saved, so the new text appears on its own while customised messages are
	 * left untouched.
	 */
	public function update_data()
	{
		return array(
			array('config.update', array('agm_version', '1.5.4')),

			// Advance notice shown on every board page before maintenance
			array('config.add', array('agm_notice', 0)),
			array('config.add', array('agm_notice_days', 0)),

			// Ownership flag for phpBB's "Disable board" switch. Without it a
			// second activation would record "already closed" as the value to
			// restore, leaving the board shut behind phpBB's own notice.
			array('config.add', array('agm_board_governed', 0)),
		);
	}
}
