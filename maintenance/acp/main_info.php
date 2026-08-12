<?php
/**
 * Forum Maintenance Mode - phpBB extension
 *
 * @author     Salvo Cortesiano
 * @copyright  (c) 2026-08-11 20:00 CEST Salvo Cortesiano
 * @link       https://netshadows.de/ombra/
 * @license    GNU General Public License, version 2 (GPL-2.0)
 */

namespace salvocortesiano\maintenance\acp;

class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\salvocortesiano\maintenance\acp\main_module',
			'title'		=> 'ACP_AGM_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_AGM_SETTINGS',
					'auth'	=> 'ext_salvocortesiano/maintenance && acl_a_board',
					'cat'	=> array('ACP_AGM_TITLE'),
				),
			),
		);
	}
}
