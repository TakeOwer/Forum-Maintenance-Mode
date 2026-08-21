<?php
/**
 * Forum Maintenance Mode - phpBB extension
 *
 * @author     Salvo Cortesiano
 * @copyright  (c) 2026-08-11 20:00 CEST Salvo Cortesiano
 * @link       https://netshadows.de/ombra/
 * @license    GNU General Public License, version 2 (GPL-2.0)
 */

namespace salvocortesiano\maintenance\core;

class helper
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $adm_path;

	/** Supported front-end languages of the maintenance page */

	public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\path_helper $path_helper, $root_path, $php_ext, $adm_path)
	{
		$this->config = $config;
		$this->config_text = $config_text;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->auth = $auth;
		$this->request = $request;
		$this->path_helper = $path_helper;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->adm_path = $adm_path;
	}

	/**
	 * Default admin editable texts, per language.
	 */
	/** @var array cache of the language files read during this request */
	protected static $lang_cache = array();

	/**
	 * Languages the page can speak.
	 *
	 * Found by looking for a maintenance_page file inside each folder of the
	 * extension's language directory, so dropping in a translated folder is
	 * enough: there is nothing to declare in the code.
	 *
	 * @return array iso => array('code' => 'FR', 'name' => 'Français')
	 */
	public function available_languages()
	{
		if (isset(self::$lang_cache['__list__']))
		{
			return self::$lang_cache['__list__'];
		}

		$dir = $this->lang_path();
		$found = array();

		if (is_dir($dir))
		{
			foreach ((array) scandir($dir) as $entry)
			{
				if ($entry === '.' || $entry === '..' || !is_dir($dir . $entry))
				{
					continue;
				}

				$strings = $this->page_strings($entry);

				if (empty($strings['AGM_PAGE_TITLE']))
				{
					continue;
				}

				$found[$entry] = array(
					'code' => !empty($strings['AGM_PAGE_LANG_CODE']) ? $strings['AGM_PAGE_LANG_CODE'] : strtoupper(substr($entry, 0, 2)),
					'name' => !empty($strings['AGM_PAGE_LANG_NAME']) ? $strings['AGM_PAGE_LANG_NAME'] : $entry,
				);
			}
		}

		// Italian and English first, the rest by name: a stable order in the
		// chooser whatever the file system hands back.
		uksort($found, function ($a, $b) use ($found) {
			$rank = array('it' => 0, 'en' => 1);
			$ra = isset($rank[$a]) ? $rank[$a] : 2;
			$rb = isset($rank[$b]) ? $rank[$b] : 2;

			return ($ra !== $rb) ? $ra - $rb : strcasecmp($found[$a]['name'], $found[$b]['name']);
		});

		self::$lang_cache['__list__'] = $found;

		return $found;
	}

	/**
	 * Where the language folders of this extension live.
	 */
	protected function lang_path()
	{
		return $this->root_path . 'ext/salvocortesiano/maintenance/language/';
	}

	/**
	 * Read one language file of the page.
	 *
	 * phpBB only loads the language of the current user, while this page has to
	 * render in whichever language the visitor picks, so the file is read
	 * directly. The name is taken from the directory listing, never from user
	 * input, so it cannot be used to reach elsewhere on the disk.
	 *
	 * @return array empty when the language has no file
	 */
	public function page_strings($iso)
	{
		$iso = (string) $iso;

		if (isset(self::$lang_cache[$iso]))
		{
			return self::$lang_cache[$iso];
		}

		self::$lang_cache[$iso] = array();

		if ($iso === '' || !preg_match('/^[a-z0-9_]+$/', $iso))
		{
			return array();
		}

		$file = $this->lang_path() . $iso . '/maintenance_page.' . $this->php_ext;

		if (!file_exists($file))
		{
			return array();
		}

		$lang = array();
		include $file;

		self::$lang_cache[$iso] = is_array($lang) ? $lang : array();

		return self::$lang_cache[$iso];
	}

	/**
	 * The five texts an administrator may override, per language.
	 */
	public static function overridable()
	{
		return array(
			'title'       => 'AGM_PAGE_TITLE',
			'subtitle'    => 'AGM_PAGE_SUBTITLE',
			'description' => 'AGM_PAGE_DESCRIPTION',
			'footer'      => 'AGM_PAGE_FOOTER',
			'notice'      => 'AGM_PAGE_NOTICE',
		);
	}

	/**
	 * Everything the page needs in one language: the file's own wording, with
	 * the administrator's overrides applied on top where they are not empty.
	 *
	 * @return array keyed by AGM_PAGE_* as the templates expect
	 */
	public function page_texts($iso)
	{
		$strings = $this->page_strings($iso);

		if (empty($strings))
		{
			return array();
		}

		$overrides = $this->get_overrides();

		foreach (self::overridable() as $field => $key)
		{
			if (isset($overrides[$iso][$field]) && trim((string) $overrides[$iso][$field]) !== '')
			{
				$strings[$key] = (string) $overrides[$iso][$field];
			}
		}

		return $strings;
	}

	/**
	 * The administrator's overrides, as stored.
	 */
	public function get_overrides()
	{
		$stored = json_decode((string) $this->config_text->get('agm_messages'), true);
		$stored = is_array($stored) ? $stored : array();

		return $this->drop_foreign_overrides($stored);
	}

	/**
	 * Throw away an override that is word for word another language's text.
	 *
	 * Nobody deliberately files the Italian sentence as the English one; when
	 * that is what the stored data says, it came from an earlier fault, and
	 * honouring it would keep showing the wrong language for good. The shipped
	 * translation is used instead, and a real customisation, which by
	 * definition differs from every shipped text, is left untouched.
	 */
	protected function drop_foreign_overrides(array $stored)
	{
		if (empty($stored))
		{
			return $stored;
		}

		foreach ($stored as $iso => $fields)
		{
			if (!is_array($fields))
			{
				unset($stored[$iso]);
				continue;
			}

			foreach (self::overridable() as $field => $key)
			{
				if (!isset($fields[$field]))
				{
					continue;
				}

				$value = trim((string) $fields[$field]);

				foreach (array_keys($this->available_languages()) as $other)
				{
					if ($other === $iso)
					{
						continue;
					}

					$foreign = $this->page_strings($other);

					if (isset($foreign[$key]) && $value === trim((string) $foreign[$key]))
					{
						unset($stored[$iso][$field]);
						break;
					}
				}
			}

			if (empty($stored[$iso]))
			{
				unset($stored[$iso]);
			}
		}

		return $stored;
	}

	/**
	 * Save the overrides for one language, leaving the others untouched.
	 *
	 * A field left empty means "use the translation from the language file",
	 * so clearing a box restores the shipped wording instead of blanking the
	 * page.
	 */
	public function set_overrides($iso, array $fields)
	{
		$stored = $this->get_overrides();
		$shipped = $this->page_strings($iso);
		$clean = array();

		foreach (self::overridable() as $field => $key)
		{
			$value = isset($fields[$field]) ? trim((string) $fields[$field]) : '';

			// Nothing to store when the box is empty, and nothing to store when
			// it still holds exactly what the language file says: keeping that
			// would freeze today's wording and ignore a future translation.
			if ($value === '' || (isset($shipped[$key]) && $value === trim((string) $shipped[$key])))
			{
				continue;
			}

			$clean[$field] = $value;
		}

		if (empty($clean))
		{
			unset($stored[$iso]);
		}
		else
		{
			$stored[$iso] = $clean;
		}

		$this->config_text->set('agm_messages', json_encode($stored));
	}

	/**
	 * Colour palette, with fallbacks matching the default theme.
	 */
	public function get_colors()
	{
		$defaults = array(
			'agm_color_bg_start' => '#0f1c3f',
			'agm_color_bg_end'   => '#1d4ed8',
			'agm_color_topbar'   => '#0b1120',
			'agm_color_accent'   => '#3b82f6',
			'agm_color_text'     => '#f8fafc',
			'agm_color_muted'    => '#c7d2fe',
			'agm_color_card'     => '#16255180',
			'agm_color_cd_from'  => '#2b3f8fcc',
			'agm_color_cd_to'    => '#5b3a8fcc',
			'agm_color_prog_a'   => '#60a5fa',
			'agm_color_prog_b'   => '#c084fc',
		);

		$colors = array();

		foreach ($defaults as $key => $default)
		{
			$value = isset($this->config[$key]) ? trim((string) $this->config[$key]) : '';
			$colors[$key] = preg_match('/^#[0-9a-fA-F]{3,8}$/', $value) ? $value : $default;
		}

		return $colors;
	}

	/**
	 * Maintenance switch (the ACP radio button).
	 */
	public function is_enabled()
	{
		return !empty($this->config['agm_enabled']);
	}

	public function get_start()
	{
		return (int) (isset($this->config['agm_start']) ? $this->config['agm_start'] : 0);
	}

	public function get_end()
	{
		return (int) (isset($this->config['agm_end']) ? $this->config['agm_end'] : 0);
	}

	/**
	 * Should the advance notice be shown right now?
	 *
	 * It only makes sense with a schedule: the switch must be on, a start and
	 * an end date must be set, and the window must not have begun yet. Once
	 * maintenance is running the visitor sees the full page instead.
	 *
	 * @return array empty when nothing should be shown
	 */
	public function get_notice()
	{
		if (empty($this->config['agm_notice']) || !$this->is_enabled() || empty($this->config['agm_use_schedule']))
		{
			return array();
		}

		$start = $this->get_start();
		$end   = $this->get_end();
		$now   = time();

		if (!$start || !$end || $now >= $start)
		{
			return array();
		}

		// Optional lead time: show it only in the days before the window
		$days = (int) $this->config['agm_notice_days'];

		if ($days > 0 && $start - $now > $days * 86400)
		{
			return array();
		}

		$lang  = $this->current_lang();
		$texts = $this->page_texts($lang);
		$template = isset($texts['AGM_PAGE_NOTICE']) ? $texts['AGM_PAGE_NOTICE'] : '';

		if (trim($template) === '')
		{
			return array();
		}

		return array(
			'template' => str_replace('{SITENAME}', (string) $this->config['sitename'], $template),
			'start'    => $start,
			'end'      => $end,
		);
	}

	/**
	 * Put the advance notice on the current page.
	 *
	 * The text is split around the {START} and {END} placeholders and passed as
	 * template blocks. Each date carries its UNIX timestamp so the browser can
	 * print it in the reader's own timezone, exactly like the countdown card
	 * does: formatting it here would use the account timezone instead, which is
	 * what made the times look shifted.
	 */
	public function assign_notice()
	{
		$notice = $this->get_notice();

		if (empty($notice))
		{
			return;
		}

		$parts = preg_split('/(\{START\}|\{END\})/', $notice['template'], -1, PREG_SPLIT_DELIM_CAPTURE);

		foreach ($parts as $part)
		{
			if ($part === '')
			{
				continue;
			}

			if ($part === '{START}' || $part === '{END}')
			{
				$stamp = ($part === '{START}') ? $notice['start'] : $notice['end'];

				$this->template->assign_block_vars('agm_notice_part', array(
					'TEXT' => $this->user->format_date($stamp, 'd/m/Y H:i'),
					'TS'   => $stamp,
				));
			}
			else
			{
				$this->template->assign_block_vars('agm_notice_part', array(
					'TEXT' => $part,
					'TS'   => 0,
				));
			}
		}

		$this->template->assign_var('S_AGM_NOTICE', true);
	}

	/**
	 * Tell an administrator why they are looking at the ordinary board while
	 * maintenance is running.
	 *
	 * phpBB shows its own red "board disabled" line to admins, which reads like
	 * a fault; this says plainly that the extension is working and that other
	 * visitors are getting the maintenance page.
	 */
	public function assign_admin_banner()
	{
		if (!$this->is_active() || $this->show_to_admins())
		{
			return;
		}

		if (!$this->auth->acl_get('a_') && (!isset($this->user->data['user_type']) || (int) $this->user->data['user_type'] !== USER_FOUNDER))
		{
			return;
		}

		// Read straight from our own language file: relying on phpBB to load an
		// ACP file while a board page is being built left the raw key on screen.
		$texts = $this->page_texts($this->current_lang());

		if (empty($texts['AGM_PAGE_ADMIN_BANNER']))
		{
			return;
		}

		$this->template->assign_vars(array(
			'S_AGM_ADMIN_BANNER' => true,
			'AGM_ADMIN_BANNER'   => $texts['AGM_PAGE_ADMIN_BANNER'],
		));
	}

	/**
	 * Is the maintenance page to be shown right now?
	 *
	 * The switch must be on and, when a schedule is set, the current time must
	 * fall inside the window. Once the end date has passed the switch is turned
	 * off automatically.
	 */
	public function is_active()
	{
		if (!$this->is_enabled())
		{
			return false;
		}

		if (empty($this->config['agm_use_schedule']))
		{
			return true;
		}

		$now   = time();
		$start = $this->get_start();
		$end   = $this->get_end();

		if ($start && $now < $start)
		{
			return false;
		}

		if ($end && $now > $end)
		{
			if (!empty($this->config['agm_auto_off']))
			{
				$this->deactivate();
			}

			return false;
		}

		return true;
	}

	/**
	 * Turn maintenance on and write the activation log.
	 */
	public function activate()
	{
		$this->config->set('agm_enabled', 1);
		$this->config->set('agm_last_on', time());
		$this->config->increment('agm_total_activations', 1);

		// Do not touch phpBB's switch here: sync_board_disable() follows the
		// real state, so a window scheduled for later leaves the board open.
		$this->sync_board_disable($this->is_active());
	}

	public function deactivate()
	{
		$this->config->set('agm_enabled', 0);
		$this->config->set('agm_last_off', time());

		$this->sync_board_disable(false);
	}

	/**
	 * Keep phpBB's own "Disable board" setting in step with whether the
	 * maintenance page is actually showing.
	 *
	 * A "governed" flag records whether the board was closed by us. The
	 * previous value is captured only when we take control and is given back
	 * only when we release it. Without that flag, closing the board twice in a
	 * row would record "already closed" as the value to restore, and the board
	 * would stay shut for good behind phpBB's own notice.
	 */
	public function sync_board_disable($active)
	{
		if (empty($this->config['agm_sync_board_disable']))
		{
			return;
		}

		$governed = !empty($this->config['agm_board_governed']);
		$current  = (int) $this->config['board_disable'];

		if ($active)
		{
			if (!$governed)
			{
				// Taking control: remember how the admin had left it
				$this->config->set('agm_prev_board_disable', $current);
				$this->config->set('agm_board_governed', 1);
			}

			if ($current !== 1)
			{
				$this->config->set('board_disable', 1);
			}

			return;
		}

		if (!$governed)
		{
			// Not ours to restore, leave the admin's own setting alone
			return;
		}

		$previous = (int) $this->config['agm_prev_board_disable'];

		if ($current !== $previous)
		{
			$this->config->set('board_disable', $previous);
		}

		$this->config->set('agm_board_governed', 0);
	}

	/**
	 * Should administrators see the maintenance page as well?
	 * The ACP always stays reachable either way.
	 */
	public function show_to_admins()
	{
		return !empty($this->config['agm_show_to_admins']);
	}

	/**
	 * Turn maintenance off and write the activation log.
	 */
	/**
	 * Language used for the first paint of the maintenance page.
	 */
	public function current_lang()
	{
		$available = array_keys($this->available_languages());

		if (empty($available))
		{
			return 'en';
		}

		$requested = strtolower($this->request->variable('agm_lang', ''));

		if (in_array($requested, $available, true))
		{
			return $requested;
		}

		$board = strtolower((string) (isset($this->user->lang_name) ? $this->user->lang_name : ''));

		// The board pack may be named exactly like ours (zh_cmn_hans) or be a
		// regional variant of it (pt_br, de_x_sie): try the whole name, then
		// the part before the underscore.
		if ($board !== '')
		{
			if (in_array($board, $available, true))
			{
				return $board;
			}

			$short = substr($board, 0, 2);

			if (in_array($short, $available, true))
			{
				return $short;
			}
		}

		$fallback = (string) $this->config['agm_default_lang'];

		if (in_array($fallback, $available, true))
		{
			return $fallback;
		}

		return in_array('en', $available, true) ? 'en' : $available[0];
	}

	/**
	 * Build the full HTML of the maintenance page.
	 *
	 * @param bool $preview     true when rendered from the ACP preview
	 * @param bool $init_style  true when the template engine still needs a style
	 * @return string
	 */
	public function render($preview = false, $init_style = false)
	{
		if ($init_style)
		{
			$this->template->set_style();
		}

		$colors    = $this->get_colors();
		$available = $this->available_languages();
		$lang      = $this->current_lang();

		// Every language travels with the page, so the chooser can switch
		// without another request to the server.
		$payload = array();

		foreach (array_keys($available) as $iso)
		{
			$payload[$iso] = $this->page_texts($iso);
		}

		$texts = isset($payload[$lang]) ? $payload[$lang] : reset($payload);

		$board_url = generate_board_url();
		$start     = $this->get_start();
		$end       = $this->get_end();

		$this->template->assign_vars(array(
			'AGM_PREVIEW'       => (bool) $preview,
			'AGM_LANG'          => $lang,
			'AGM_MESSAGES_JSON' => json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE),

			'AGM_SITENAME'      => $this->config['sitename'],
			'AGM_INITIALS'      => $this->initials((string) $this->config['sitename']),
			//'AGM_LOGO_URL'      => trim((string) $this->config['agm_logo_url']),
			'AGM_LOGO_URL'      => $this->logo_url($board_url),

			'AGM_TITLE'         => $texts['AGM_PAGE_TITLE'],
			'AGM_SUBTITLE'      => $texts['AGM_PAGE_SUBTITLE'],
			'AGM_DESCRIPTION'   => $texts['AGM_PAGE_DESCRIPTION'],
			'AGM_FOOTER_TEXT'   => $texts['AGM_PAGE_FOOTER'],
			'AGM_CONTACT_LABEL' => $texts['AGM_PAGE_CONTACT'],
			'AGM_ADMIN_ASK'     => $texts['AGM_PAGE_ADMIN_ASK'],
			'AGM_ADMIN_BTN'     => $texts['AGM_PAGE_ADMIN_BTN'],
			'AGM_PREVIEW_LABEL' => $texts['AGM_PAGE_PREVIEW'],
			'AGM_L_REMAINING'   => $texts['AGM_PAGE_REMAINING'],
			'AGM_L_START'       => $texts['AGM_PAGE_START'],
			'AGM_L_END'         => $texts['AGM_PAGE_END'],
			'AGM_L_PROGRESS'    => $texts['AGM_PAGE_PROGRESS'],

			'AGM_EMAIL'         => trim((string) $this->config['agm_contact_email']),
			'AGM_PHONE'         => trim((string) $this->config['agm_contact_phone']),
			'AGM_SHOW_CONTACT'  => (trim((string) $this->config['agm_contact_email']) !== '' || trim((string) $this->config['agm_contact_phone']) !== ''),

			'AGM_SHOW_PARTICLES' => !empty($this->config['agm_particles']),
			'AGM_PARTICLE_STYLE' => in_array((string) $this->config['agm_particle_style'], array('snow', 'stars', 'both'), true)
				? (string) $this->config['agm_particle_style']
				: 'snow',
			'AGM_SHOW_GEAR'      => !empty($this->config['agm_show_gear']),
			'AGM_SPIN_GEAR'      => !empty($this->config['agm_spin_gear']),
			'AGM_SHOW_COUNTDOWN' => (!empty($this->config['agm_countdown']) && $end > 0),
			'AGM_SHOW_LANGS'     => !empty($this->config['agm_lang_switcher']),
			'AGM_SHOW_ADMIN'     => !empty($this->config['agm_show_admin_link']),
			'AGM_AUTO_REFRESH'   => (int) $this->config['agm_refresh'],

			'AGM_SHOW_DATES'     => (!empty($this->config['agm_show_dates']) && ($start > 0 || $end > 0)),
			'AGM_SHOW_PROGRESS'  => (!empty($this->config['agm_progress_bar']) && $start > 0 && $end > $start),

			'AGM_START_TS'       => $start,
			'AGM_END_TS'         => $end,
			'AGM_NOW_TS'         => time(),
			'AGM_START_HUMAN'    => $start ? $this->user->format_date($start, 'd/m/Y H:i') : '—',
			'AGM_END_HUMAN'      => $end ? $this->user->format_date($end, 'd/m/Y H:i') : '—',

			'U_AGM_INDEX'        => append_sid($board_url . '/index.' . $this->php_ext),

			// phpBB refuses a bare adm/index.php with a 401: its own footer link
			// carries the session id, so this one has to as well. Visitors who
			// are not signed in go to the login form instead.
			'U_AGM_ADMIN'        => $this->auth->acl_get('a_') && !empty($this->user->data['is_registered'])
				? append_sid($board_url . '/' . $this->adm_path . 'index.' . $this->php_ext, false, true, $this->user->session_id)
				: append_sid($board_url . '/ucp.' . $this->php_ext, 'mode=login'),

			'AGM_C_BG_START'     => $colors['agm_color_bg_start'],
			'AGM_C_BG_END'       => $colors['agm_color_bg_end'],
			'AGM_C_TOPBAR'       => $colors['agm_color_topbar'],
			'AGM_C_ACCENT'       => $colors['agm_color_accent'],
			'AGM_C_TEXT'         => $colors['agm_color_text'],
			'AGM_C_MUTED'        => $colors['agm_color_muted'],
			'AGM_C_CARD'         => $colors['agm_color_card'],
			'AGM_C_CD_FROM'      => $colors['agm_color_cd_from'],
			'AGM_C_CD_TO'        => $colors['agm_color_cd_to'],
			'AGM_C_PROG_A'       => $colors['agm_color_prog_a'],
			'AGM_C_PROG_B'       => $colors['agm_color_prog_b'],
		));

		// One entry per language in the chooser, the current one selected
		foreach ($available as $iso => $info)
		{
			$this->template->assign_block_vars('agm_language', array(
				'ISO'      => $iso,
				'CODE'     => $info['code'],
				'NAME'     => $info['name'],
				'S_ACTIVE' => ($iso === $lang),
			));
		}

		$this->template->assign_var('AGM_CHOOSE_LABEL', isset($texts['AGM_PAGE_CHOOSE']) ? $texts['AGM_PAGE_CHOOSE'] : 'Language');

		$this->template->set_filenames(array(
			'agm_body' => '@salvocortesiano_maintenance/maintenance_page.html',
		));

		return $this->template->assign_display('agm_body');
	}

	/**
	 * Send the maintenance page and stop the request.
	 */
	public function render_and_exit()
	{
		$html = $this->render(false, true);

		if (!headers_sent())
		{
			header('HTTP/1.1 503 Service Unavailable');
			header('Status: 503 Service Unavailable');
			header('Content-Type: text/html; charset=UTF-8');
			header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
			header('Pragma: no-cache');
			header('Expires: 0');

			$end = $this->get_end();

			if ($end > time())
			{
				header('Retry-After: ' . ($end - time()));
			}
		}

		echo $html;

		garbage_collection();
		exit_handler();
	}

	/**
	 * Absolute URL of the logo.
	 *
	 * A relative path such as "images/logo.png" would be resolved against
	 * app.php/maintenance/preview when the page is previewed, which points
	 * nowhere. Anchoring it to the board URL makes it work from any address.
	 * Spaces and other unsafe characters in the file name are encoded too.
	 */
	public function logo_url($board_url)
	{
		$logo = trim((string) $this->config['agm_logo_url']);

		if ($logo === '')
		{
			return '';
		}

		// Already absolute, or protocol relative: leave it alone
		if (preg_match('#^(https?:)?//#i', $logo) || strpos($logo, 'data:') === 0)
		{
			return $logo;
		}

		$logo = ltrim($logo, '/');
		$parts = explode('/', $logo);

		foreach ($parts as $i => $part)
		{
			$parts[$i] = rawurlencode($part);
		}

		return $board_url . '/' . implode('/', $parts);
	}

	/**
	 * Absolute address of the logo, for the small preview in the panel.
	 */
	public function logo_preview()
	{
		return $this->logo_url(generate_board_url());
	}

	/**
	 * Up to two initials used by the logo badge.
	 */
	protected function initials($name)
	{
		$parts = preg_split('/\s+/', trim($name), -1, PREG_SPLIT_NO_EMPTY);

		if (empty($parts))
		{
			return 'AG';
		}

		$out = utf8_substr($parts[0], 0, 1);

		if (isset($parts[1]))
		{
			$out .= utf8_substr($parts[1], 0, 1);
		}

		return utf8_strtoupper($out);
	}
}
