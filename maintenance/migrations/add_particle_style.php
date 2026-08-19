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

class add_particle_style extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['agm_particle_style']);
	}

	public static function depends_on()
	{
		return array('\salvocortesiano\maintenance\migrations\add_notice');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('agm_version', '2.1.0')),

			// Which background effect the page draws: drifting flakes as
			// before, twinkling stars, or both together.
			array('config.add', array('agm_particle_style', 'snow')),
		);
	}
}
