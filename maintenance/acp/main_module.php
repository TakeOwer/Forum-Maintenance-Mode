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

class main_module
{
	/** @var string */
	public $u_action;

	/** @var string */
	public $tpl_name;

	/** @var string */
	public $page_title;

	public function main($id, $mode)
	{
		global $phpbb_container, $request, $template, $user;

		/** @var \phpbb\config\config $config */
		$config = $phpbb_container->get('config');
		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');
		/** @var \phpbb\controller\helper $controller_helper */
		$controller_helper = $phpbb_container->get('controller.helper');
		/** @var \salvocortesiano\maintenance\core\helper $agm */
		$agm = $phpbb_container->get('salvocortesiano.maintenance.helper');

		$language->add_lang('acp_maintenance', 'salvocortesiano/maintenance');

		$this->tpl_name = 'acp_agm_settings';
		$this->page_title = $language->lang('ACP_AGM_SETTINGS');

		$form_key = 'agm_settings';
		add_form_key($form_key);

		$errors = array();

		if ($request->is_set_post('submit') || $request->is_set_post('agm_toggle'))
		{
			if (!check_form_key($form_key))
			{
				$errors[] = $language->lang('FORM_INVALID');
			}

			// Reopen the board when it was left closed outside maintenance
			if (empty($errors) && $request->is_set_post('agm_reopen'))
			{
				$config->set('board_disable', 0);
				$config->set('agm_prev_board_disable', 0);
				$config->set('agm_board_governed', 0);

				trigger_error($language->lang('AGM_BOARD_REOPENED') . adm_back_link($this->u_action));
			}

			// Quick on/off button
			if (empty($errors) && $request->is_set_post('agm_toggle'))
			{
				if ($agm->is_enabled())
				{
					$agm->deactivate();
					$message = $language->lang('AGM_DEACTIVATED');
				}
				else
				{
					$agm->activate();
					$message = $language->lang('AGM_ACTIVATED');
				}

				trigger_error($message . adm_back_link($this->u_action));
			}

			if (empty($errors))
			{
				// The browser posts real timestamps (agm_ts_mode = 1) so the times
				// mean what the admin saw on screen, whatever timezone the
				// account is set to. Text parsing is only the no-JS fallback.
				if ($request->variable('agm_ts_mode', 0))
				{
					$start = (int) $request->variable('agm_start_ts', 0);
					$end   = (int) $request->variable('agm_end_ts', 0);
				}
				else
				{
					$start = $this->to_timestamp($request->variable('agm_start', '', true), $user);
					$end   = $this->to_timestamp($request->variable('agm_end', '', true), $user);
				}

				if ($start === false)
				{
					$errors[] = $language->lang('AGM_ERR_START');
					$start = 0;
				}

				if ($end === false)
				{
					$errors[] = $language->lang('AGM_ERR_END');
					$end = 0;
				}

				if ($start && $end && $end <= $start)
				{
					$errors[] = $language->lang('AGM_ERR_RANGE');
				}

				$email = trim($request->variable('agm_contact_email', '', true));

				if ($email !== '' && !preg_match('/^[^@\s]+@[^@\s]+\.[^@\s]+$/', $email))
				{
					$errors[] = $language->lang('AGM_ERR_EMAIL');
				}
			}

			if (empty($errors))
			{
				$config->set('agm_sync_board_disable', (int) $request->variable('agm_sync_board_disable', 0));
				$config->set('agm_show_to_admins', (int) $request->variable('agm_show_to_admins', 0));

				$was_enabled = $agm->is_enabled();
				$now_enabled = (bool) $request->variable('agm_enabled', 0);

				if ($now_enabled && !$was_enabled)
				{
					$agm->activate();
				}
				else if (!$now_enabled && $was_enabled)
				{
					$agm->deactivate();
				}
				else
				{
					$config->set('agm_enabled', $now_enabled ? 1 : 0);
				}

				$config->set('agm_notice', (int) $request->variable('agm_notice', 0));
				$config->set('agm_notice_days', max(0, min(365, (int) $request->variable('agm_notice_days', 0))));
				$config->set('agm_use_schedule', (int) $request->variable('agm_use_schedule', 0));
				$config->set('agm_auto_off', (int) $request->variable('agm_auto_off', 0));
				$config->set('agm_start', (int) $start);
				$config->set('agm_end', (int) $end);

				$config->set('agm_contact_email', $request->variable('agm_contact_email', '', true));
				$config->set('agm_contact_phone', $request->variable('agm_contact_phone', '', true));
				$config->set('agm_logo_url', $request->variable('agm_logo_url', '', true));
				$default_lang = $request->variable('agm_default_lang', 'it');
				$config->set('agm_default_lang', in_array($default_lang, \salvocortesiano\maintenance\core\helper::LANGS, true) ? $default_lang : 'it');

				$config->set('agm_particles', (int) $request->variable('agm_particles', 0));
				$config->set('agm_show_gear', (int) $request->variable('agm_show_gear', 0));
				$config->set('agm_spin_gear', (int) $request->variable('agm_spin_gear', 0));
				$config->set('agm_countdown', (int) $request->variable('agm_countdown', 0));
				$config->set('agm_show_dates', (int) $request->variable('agm_show_dates', 0));
				$config->set('agm_progress_bar', (int) $request->variable('agm_progress_bar', 0));
				$config->set('agm_lang_switcher', (int) $request->variable('agm_lang_switcher', 0));
				$config->set('agm_show_admin_link', (int) $request->variable('agm_show_admin_link', 0));
				$config->set('agm_refresh', max(0, min(3600, (int) $request->variable('agm_refresh', 30))));

				foreach (array('agm_color_bg_start', 'agm_color_bg_end', 'agm_color_topbar', 'agm_color_accent', 'agm_color_text', 'agm_color_muted', 'agm_color_card', 'agm_color_cd_from', 'agm_color_cd_to', 'agm_color_prog_a', 'agm_color_prog_b') as $key)
				{
					$value = trim($request->variable($key, ''));

					if (preg_match('/^#[0-9a-fA-F]{3,8}$/', $value))
					{
						$config->set($key, $value);
					}
				}

				$messages = array();

				foreach (\salvocortesiano\maintenance\core\helper::default_messages() as $iso => $fields)
				{
					foreach ($fields as $field => $default)
					{
						$messages[$iso][$field] = $request->variable('agm_' . $iso . '_' . $field, $default, true);
					}
				}

				$agm->set_messages($messages);

				trigger_error($language->lang('AGM_SETTINGS_SAVED') . adm_back_link($this->u_action));
			}
		}

		$notice_preview = $agm->get_notice();
		$colors = $agm->get_colors();
		$messages = $agm->get_messages();
		$start = $agm->get_start();
		$end = $agm->get_end();

		// One editable block per language, so the page can speak them all
		$names = \salvocortesiano\maintenance\core\helper::lang_names();

		foreach (\salvocortesiano\maintenance\core\helper::LANGS as $iso)
		{
			$template->assign_block_vars('agm_message', array(
				'ISO'         => $iso,
				'NAME'        => $names[$iso]['name'],
				'CODE'        => $names[$iso]['code'],
				'TITLE'       => $messages[$iso]['title'],
				'SUBTITLE'    => $messages[$iso]['subtitle'],
				'DESCRIPTION' => $messages[$iso]['description'],
				'FOOTER'      => $messages[$iso]['footer'],
				'NOTICE'      => $messages[$iso]['notice'],
				'S_DEFAULT'   => ($iso === (string) $config['agm_default_lang']),
			));

			$template->assign_block_vars('agm_lang_option', array(
				'ISO'        => $iso,
				'NAME'       => $names[$iso]['name'],
				'S_SELECTED' => ($iso === (string) $config['agm_default_lang']),
			));
		}

		$template->assign_vars(array(
			'S_ERROR'	=> (bool) count($errors),
			'ERROR_MSG'	=> implode('<br />', $errors),
			'U_ACTION'	=> $this->u_action,
			'U_AGM_PREVIEW' => $controller_helper->route('salvocortesiano_maintenance_preview'),

			'AGM_IS_ENABLED'	=> $agm->is_enabled(),
			'AGM_IS_ACTIVE'		=> $agm->is_active(),
			'AGM_NOTICE_ON'		=> !empty($config['agm_notice']),
			'AGM_NOTICE_DAYS'	=> (int) $config['agm_notice_days'],
			'AGM_NOTICE_PREVIEW' => isset($notice_preview['text']) ? $notice_preview['text'] : '',
			'AGM_USE_SCHEDULE'	=> !empty($config['agm_use_schedule']),
			'AGM_AUTO_OFF'		=> !empty($config['agm_auto_off']),
			'AGM_SYNC_BOARD'	=> !empty($config['agm_sync_board_disable']),
			'AGM_SHOW_TO_ADMINS' => !empty($config['agm_show_to_admins']),
			'AGM_BOARD_DISABLED' => !empty($config['board_disable']),
			'AGM_BOARD_STUCK'	=> (!empty($config['board_disable']) && !$agm->is_active()),

			'AGM_START_TS'		=> $start,
			'AGM_END_TS'		=> $end,
			'AGM_START'			=> $this->to_input($start, $user),
			'AGM_END'			=> $this->to_input($end, $user),
			'AGM_START_HUMAN'	=> $start ? $user->format_date($start) : $language->lang('AGM_NOT_AVAILABLE'),
			'AGM_END_HUMAN'		=> $end ? $user->format_date($end) : $language->lang('AGM_NOT_AVAILABLE'),
			'AGM_DURATION'		=> ($start && $end && $end > $start) ? $this->format_duration($end - $start, $language) : $language->lang('AGM_NOT_AVAILABLE'),

			'AGM_CONTACT_EMAIL'	=> $config['agm_contact_email'],
			'AGM_CONTACT_PHONE'	=> $config['agm_contact_phone'],
			'AGM_LOGO_URL'		=> $config['agm_logo_url'],
			'AGM_DEFAULT_LANG'	=> $config['agm_default_lang'],

			'AGM_PARTICLES'		=> !empty($config['agm_particles']),
			'AGM_SHOW_GEAR'		=> !empty($config['agm_show_gear']),
			'AGM_SPIN_GEAR'		=> !empty($config['agm_spin_gear']),
			'AGM_COUNTDOWN'		=> !empty($config['agm_countdown']),
			'AGM_SHOW_DATES'	=> !empty($config['agm_show_dates']),
			'AGM_PROGRESS_BAR'	=> !empty($config['agm_progress_bar']),
			'AGM_LANG_SWITCHER'	=> !empty($config['agm_lang_switcher']),
			'AGM_SHOW_ADMIN_LINK' => !empty($config['agm_show_admin_link']),
			'AGM_REFRESH'		=> (int) $config['agm_refresh'],

			'AGM_C_BG_START'	=> $colors['agm_color_bg_start'],
			'AGM_C_BG_END'		=> $colors['agm_color_bg_end'],
			'AGM_C_TOPBAR'		=> $colors['agm_color_topbar'],
			'AGM_C_ACCENT'		=> $colors['agm_color_accent'],
			'AGM_C_TEXT'		=> $colors['agm_color_text'],
			'AGM_C_MUTED'		=> $colors['agm_color_muted'],
			'AGM_C_CARD'		=> $colors['agm_color_card'],
			'AGM_C_CD_FROM'		=> $colors['agm_color_cd_from'],
			'AGM_C_CD_TO'		=> $colors['agm_color_cd_to'],
			'AGM_C_PROG_A'		=> $colors['agm_color_prog_a'],
			'AGM_C_PROG_B'		=> $colors['agm_color_prog_b'],

			// The browser colour picker only understands #rrggbb, so the
			// six-digit part and the alpha byte are passed separately. Doing it
			// here means the swatches are already right without any JavaScript.
			'AGM_C_CD_FROM_RGB'	=> $this->rgb_part($colors['agm_color_cd_from']),
			'AGM_C_CD_TO_RGB'	=> $this->rgb_part($colors['agm_color_cd_to']),
			'AGM_C_CARD_RGB'	=> $this->rgb_part($colors['agm_color_card']),
			'AGM_C_CD_FROM_A'	=> $this->alpha_part($colors['agm_color_cd_from']),
			'AGM_C_CD_TO_A'		=> $this->alpha_part($colors['agm_color_cd_to']),
			'AGM_C_CARD_A'		=> $this->alpha_part($colors['agm_color_card']),

			'AGM_LAST_ON'		=> !empty($config['agm_last_on']) ? $user->format_date((int) $config['agm_last_on']) : $language->lang('AGM_NOT_AVAILABLE'),
			'AGM_LAST_OFF'		=> !empty($config['agm_last_off']) ? $user->format_date((int) $config['agm_last_off']) : $language->lang('AGM_NOT_AVAILABLE'),
			'AGM_TOTAL_ON'		=> (int) $config['agm_total_activations'],
		));
	}

	/**
	 * '#rrggbbaa' -> '#rrggbb' for the browser colour picker.
	 */
	protected function rgb_part($value)
	{
		return preg_match('/^#([0-9a-fA-F]{6})/', (string) $value, $m) ? '#' . $m[1] : '#000000';
	}

	/**
	 * '#rrggbbaa' -> 0-255 alpha; fully opaque when no alpha is present.
	 */
	protected function alpha_part($value)
	{
		return preg_match('/^#[0-9a-fA-F]{6}([0-9a-fA-F]{2})$/', (string) $value, $m) ? hexdec($m[1]) : 255;
	}

	/**
	 * datetime-local value -> UNIX timestamp in the admin timezone.
	 *
	 * @return int|false 0 when empty, false when malformed
	 */
	protected function to_timestamp($value, \phpbb\user $user)
	{
		$value = trim($value);

		if ($value === '')
		{
			return 0;
		}

		$value = str_replace(' ', 'T', $value);

		if (strlen($value) === 19)
		{
			$value = substr($value, 0, 16);
		}

		$timezone = ($user->timezone instanceof \DateTimeZone) ? $user->timezone : new \DateTimeZone('UTC');
		$date = \DateTime::createFromFormat('Y-m-d\TH:i', $value, $timezone);

		if ($date === false)
		{
			return false;
		}

		return $date->getTimestamp();
	}

	/**
	 * UNIX timestamp -> datetime-local value in the admin timezone.
	 */
	protected function to_input($timestamp, \phpbb\user $user)
	{
		if (empty($timestamp))
		{
			return '';
		}

		$timezone = ($user->timezone instanceof \DateTimeZone) ? $user->timezone : new \DateTimeZone('UTC');
		$date = new \DateTime('@' . (int) $timestamp);
		$date->setTimezone($timezone);

		return $date->format('Y-m-d\TH:i');
	}

	/**
	 * Seconds -> "2 d 4 h 30 min".
	 */
	protected function format_duration($seconds, \phpbb\language\language $language)
	{
		$days = (int) floor($seconds / 86400);
		$hours = (int) floor($seconds % 86400 / 3600);
		$minutes = (int) floor($seconds % 3600 / 60);

		$parts = array();

		if ($days)
		{
			$parts[] = $days . ' ' . $language->lang('AGM_UNIT_DAYS');
		}

		if ($hours)
		{
			$parts[] = $hours . ' ' . $language->lang('AGM_UNIT_HOURS');
		}

		if ($minutes || empty($parts))
		{
			$parts[] = $minutes . ' ' . $language->lang('AGM_UNIT_MINUTES');
		}

		return implode(' ', $parts);
	}
}
