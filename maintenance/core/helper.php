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
	const LANGS = array('it', 'en');

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
	public static function default_messages()
	{
		return array(
			'it' => array(
				'title'       => 'Sito in Manutenzione',
				'subtitle'    => 'Stiamo lavorando per migliorare il sito',
				'description' => 'Il sito è temporaneamente non disponibile per manutenzione programmata. Torneremo presto online.',
				'footer'      => 'Torneremo presto online!',
			),
			'en' => array(
				'title'       => 'Site under maintenance',
				'subtitle'    => 'We are working to improve the site',
				'description' => 'The site is temporarily unavailable due to scheduled maintenance. We will be back online shortly.',
				'footer'      => 'We will be back online soon!',
			),
		);
	}

	/**
	 * Fixed interface strings of the maintenance page, per language.
	 */
	public static function ui_strings()
	{
		return array(
			'it' => array(
				'contact'     => 'Per informazioni urgenti, contattaci:',
				'admin_ask'   => 'Sei un amministratore?',
				'admin_btn'   => 'Accedi al Pannello Admin',
				'remaining'   => 'Tempo Rimanente',
				'start_label' => 'Inizio Manutenzione',
				'end_label'   => 'Fine Stimata',
				'progress'    => 'Progresso Manutenzione',
				'ended'       => 'Manutenzione terminata, torniamo al forum...',
				'u_d'         => 'g',
				'u_h'         => 'h',
				'u_m'         => 'm',
				'u_s'         => 's',
				'preview'     => 'Anteprima',
			),
			'en' => array(
				'contact'     => 'For urgent enquiries, contact us:',
				'admin_ask'   => 'Are you an administrator?',
				'admin_btn'   => 'Go to the Admin Panel',
				'remaining'   => 'Time Remaining',
				'start_label' => 'Maintenance start',
				'end_label'   => 'Estimated end',
				'progress'    => 'Maintenance progress',
				'ended'       => 'Maintenance is over, taking you back to the board...',
				'u_d'         => 'd',
				'u_h'         => 'h',
				'u_m'         => 'm',
				'u_s'         => 's',
				'preview'     => 'Preview',
			),
		);
	}

	/**
	 * Admin editable texts merged with the defaults.
	 */
	public function get_messages()
	{
		$stored = json_decode((string) $this->config_text->get('agm_messages'), true);
		$stored = is_array($stored) ? $stored : array();

		$messages = self::default_messages();

		foreach ($messages as $lang => $fields)
		{
			foreach ($fields as $key => $value)
			{
				if (isset($stored[$lang][$key]) && $stored[$lang][$key] !== '')
				{
					$messages[$lang][$key] = (string) $stored[$lang][$key];
				}
			}
		}

		return $messages;
	}

	/**
	 * Store the admin editable texts.
	 */
	public function set_messages(array $messages)
	{
		$clean = array();

		foreach (self::default_messages() as $lang => $fields)
		{
			foreach ($fields as $key => $default)
			{
				$clean[$lang][$key] = isset($messages[$lang][$key]) ? (string) $messages[$lang][$key] : $default;
			}
		}

		$this->config_text->set('agm_messages', json_encode($clean));
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

		// Mirror the switch onto phpBB's own "Disable board" setting
		if (!empty($this->config['agm_sync_board_disable']))
		{
			$this->config->set('agm_prev_board_disable', (int) $this->config['board_disable']);
			$this->config->set('board_disable', 1);
		}
	}

	public function deactivate()
	{
		$this->config->set('agm_enabled', 0);
		$this->config->set('agm_last_off', time());

		if (!empty($this->config['agm_sync_board_disable']))
		{
			$this->config->set('board_disable', (int) $this->config['agm_prev_board_disable']);
		}
	}

	/**
	 * Keep phpBB's own "Disable board" setting in step with whether the
	 * maintenance page is actually showing, not just with the switch: a
	 * scheduled window that has not started yet must leave the board open.
	 */
	public function sync_board_disable($active)
	{
		if (empty($this->config['agm_sync_board_disable']))
		{
			return;
		}

		$wanted = $active ? 1 : (int) $this->config['agm_prev_board_disable'];

		if ((int) $this->config['board_disable'] !== $wanted)
		{
			$this->config->set('board_disable', $wanted);
		}
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
		$requested = strtolower($this->request->variable('agm_lang', ''));

		if (in_array($requested, self::LANGS, true))
		{
			return $requested;
		}

		$iso = isset($this->user->lang_name) ? strtolower(substr((string) $this->user->lang_name, 0, 2)) : 'en';

		return in_array($iso, self::LANGS, true) ? $iso : (string) ($this->config['agm_default_lang'] ?: 'it');
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

		$messages = $this->get_messages();
		$ui       = self::ui_strings();
		$colors   = $this->get_colors();
		$lang     = $this->current_lang();

		$payload = array();

		foreach (self::LANGS as $iso)
		{
			$payload[$iso] = array_merge($messages[$iso], $ui[$iso]);
		}

		$board_url = generate_board_url();
		$start     = $this->get_start();
		$end       = $this->get_end();

		$this->template->assign_vars(array(
			'AGM_PREVIEW'       => (bool) $preview,
			'AGM_LANG'          => $lang,
			'AGM_MESSAGES_JSON' => json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE),

			'AGM_SITENAME'      => $this->config['sitename'],
			'AGM_INITIALS'      => $this->initials((string) $this->config['sitename']),
			'AGM_LOGO_URL'      => trim((string) $this->config['agm_logo_url']),

			'AGM_TITLE'         => $payload[$lang]['title'],
			'AGM_SUBTITLE'      => $payload[$lang]['subtitle'],
			'AGM_DESCRIPTION'   => $payload[$lang]['description'],
			'AGM_FOOTER_TEXT'   => $payload[$lang]['footer'],
			'AGM_CONTACT_LABEL' => $payload[$lang]['contact'],
			'AGM_ADMIN_ASK'     => $payload[$lang]['admin_ask'],
			'AGM_ADMIN_BTN'     => $payload[$lang]['admin_btn'],
			'AGM_PREVIEW_LABEL' => $payload[$lang]['preview'],
			'AGM_L_REMAINING'   => $payload[$lang]['remaining'],
			'AGM_L_START'       => $payload[$lang]['start_label'],
			'AGM_L_END'         => $payload[$lang]['end_label'],
			'AGM_L_PROGRESS'    => $payload[$lang]['progress'],

			'AGM_EMAIL'         => trim((string) $this->config['agm_contact_email']),
			'AGM_PHONE'         => trim((string) $this->config['agm_contact_phone']),
			'AGM_SHOW_CONTACT'  => (trim((string) $this->config['agm_contact_email']) !== '' || trim((string) $this->config['agm_contact_phone']) !== ''),

			'AGM_SHOW_PARTICLES' => !empty($this->config['agm_particles']),
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
