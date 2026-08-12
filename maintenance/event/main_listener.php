<?php
/**
 * Forum Maintenance Mode - phpBB extension
 *
 * @author     Salvo Cortesiano
 * @copyright  (c) 2026-08-11 20:00 CEST Salvo Cortesiano
 * @link       https://netshadows.de/ombra/
 * @license    GNU General Public License, version 2 (GPL-2.0)
 */

namespace salvocortesiano\maintenance\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var \salvocortesiano\maintenance\core\helper */
	protected $helper;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var bool */
	protected $done = false;

	public function __construct(\salvocortesiano\maintenance\core\helper $helper, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\request\request $request)
	{
		$this->helper = $helper;
		$this->user = $user;
		$this->auth = $auth;
		$this->request = $request;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.user_setup_after'	=> 'check_maintenance',
			'core.page_header'		=> 'check_maintenance',
			'core.permissions'		=> 'add_permission',
		);
	}

	/**
	 * Make the bypass permission selectable in the ACP.
	 */
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_agm_bypass'] = array('lang' => 'ACL_U_AGM_BYPASS', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	/**
	 * Show the maintenance page to everyone but administrators.
	 */
	public function check_maintenance()
	{
		// Two events are subscribed so the page also shows on boards where the
		// first one is unavailable; only the first run may render.
		if ($this->done)
		{
			return;
		}

		$this->done = true;

		// Never interfere with the ACP, the installer or the CLI/cron.
		// ADMIN_START matters: adm/index.php only defines IN_ADMIN later on,
		// after user setup, so checking IN_ADMIN alone would lock out the ACP.
		if (defined('ADMIN_START') || defined('IN_ADMIN') || defined('IN_INSTALL') || defined('IN_CRON') || defined('IN_CHECK_BAN') || PHP_SAPI === 'cli')
		{
			return;
		}

		$active = $this->helper->is_active();

		// phpBB's own board switch follows the real state, otherwise visitors
		// would get the plain "board disabled" notice instead of our page.
		$this->helper->sync_board_disable($active);

		if (!$active)
		{
			return;
		}

		// Administrators and founders keep access unless the admin asked to be
		// shown the page too. The ACP stays reachable either way.
		if (!$this->helper->show_to_admins() && ($this->auth->acl_get('a_') || (isset($this->user->data['user_type']) && (int) $this->user->data['user_type'] === USER_FOUNDER)))
		{
			return;
		}

		// Users allowed to bypass maintenance through a custom permission
		if ($this->auth->acl_get('u_agm_bypass'))
		{
			return;
		}

		// Keep the login form reachable so an admin can sign in
		$page_name = isset($this->user->page['page_name']) ? $this->user->page['page_name'] : '';
		$mode      = $this->request->variable('mode', '');

		if (strpos($page_name, 'ucp.') === 0 && in_array($mode, array('login', 'logout'), true))
		{
			return;
		}

		$this->helper->render_and_exit();
	}
}
