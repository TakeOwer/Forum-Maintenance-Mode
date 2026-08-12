<?php
/**
 * Forum Maintenance Mode - phpBB extension
 *
 * @author     Salvo Cortesiano
 * @copyright  (c) 2026-08-11 20:00 CEST Salvo Cortesiano
 * @link       https://netshadows.de/ombra/
 * @license    GNU General Public License, version 2 (GPL-2.0)
 */

namespace salvocortesiano\maintenance\controller;

use Symfony\Component\HttpFoundation\Response;

class main
{
	/** @var \salvocortesiano\maintenance\core\helper */
	protected $helper;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\language\language */
	protected $language;

	public function __construct(\salvocortesiano\maintenance\core\helper $helper, \phpbb\auth\auth $auth, \phpbb\language\language $language)
	{
		$this->helper = $helper;
		$this->auth = $auth;
		$this->language = $language;
	}

	/**
	 * Full-page preview of the maintenance screen, administrators only.
	 *
	 * @return Response
	 */
	public function preview()
	{
		if (!$this->auth->acl_get('a_'))
		{
			throw new \phpbb\exception\http_exception(403, 'NOT_AUTHORISED');
		}

		return new Response($this->helper->render(true), 200);
	}
}
