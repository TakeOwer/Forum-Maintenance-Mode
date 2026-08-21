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

class add_countdown_card extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['agm_progress_bar']);
	}

	public static function depends_on()
	{
		return array('\salvocortesiano\maintenance\migrations\install_maintenance');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('agm_version', '1.1.0')),

			// Countdown card blocks
			array('config.add', array('agm_show_dates', 1)),
			array('config.add', array('agm_progress_bar', 1)),

			// Countdown card colours
			array('config.add', array('agm_color_cd_from', '#2b3f8fcc')),
			array('config.add', array('agm_color_cd_to', '#5b3a8fcc')),
			array('config.add', array('agm_color_prog_a', '#60a5fa')),
			array('config.add', array('agm_color_prog_b', '#c084fc')),
		);
	}
}
