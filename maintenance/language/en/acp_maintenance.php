<?php
/**
 * Forum Maintenance Mode - phpBB extension
 *
 * @author     Salvo Cortesiano
 * @copyright  (c) 2026-08-11 20:00 CEST Salvo Cortesiano
 * @link       https://netshadows.de/ombra/
 * @license    GNU General Public License, version 2 (GPL-2.0)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_AGM_SETTINGS_EXPLAIN'	=> 'While maintenance is on, visitors see a full-screen page instead of the board. Administrators keep full access.',

	'AGM_CURRENT_STATUS'		=> 'Current status',
	'AGM_STATUS'				=> 'Status',
	'AGM_STATUS_ACTIVE'			=> 'Active',
	'AGM_STATUS_INACTIVE'		=> 'Inactive',
	'AGM_STATUS_WAITING'		=> 'Maintenance is enabled but not running yet: the schedule starts it at the start date. Visitors see the normal board.',
	'AGM_STATUS_SHOWING'		=> 'Visitors are seeing the maintenance page.',
	'AGM_START_TIME'			=> 'Start time',
	'AGM_ESTIMATED_DURATION'	=> 'Estimated duration',
	'AGM_NOT_AVAILABLE'			=> 'Not available',
	'AGM_TURN_ON'				=> 'Turn maintenance on',
	'AGM_TURN_OFF'				=> 'Turn maintenance off',
	'AGM_PREVIEW'				=> 'Open preview in a new tab',
	'AGM_PREVIEW_INLINE'		=> 'Preview here',

	'AGM_REOPEN_BOARD'			=> 'Reopen the board now',
	'AGM_BOARD_REOPENED'		=> 'The board has been reopened.',
	'AGM_BOARD_STUCK_WARN'		=> 'Warning: maintenance is not running, yet the board is disabled in General → Board settings. Visitors get phpBB\'s plain notice instead of the maintenance page. Use the "Reopen the board now" button to put it back online.',
	'AGM_PAGE_CHECK'			=> 'What the page will show',
	'AGM_PAGE_CHECK_EXPLAIN'	=> 'Each block appears only when its condition is met. Anything in red will not appear, neither in the preview nor to visitors.',
	'AGM_CHECK_COUNTDOWN'		=> 'Countdown: needs the checkbox and an end date',
	'AGM_CHECK_DATES'			=> 'Start and end cards: need the checkbox and at least one of the two dates',
	'AGM_CHECK_PROGRESS'		=> 'Progress bar: needs the checkbox and both dates, with the end after the start',
	'AGM_CHECK_CONTACT'			=> 'Contacts box: needs at least one of email and phone',
	'AGM_ADMIN_BANNER'			=> 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
	'AGM_MODE'					=> 'Maintenance mode',
	'AGM_ENABLED'				=> 'Maintenance',
	'AGM_ENABLED_EXPLAIN'		=> 'Turn the maintenance page on or off.',
	'AGM_ENABLED_ON'			=> 'Enabled',
	'AGM_ENABLED_OFF'			=> 'Disabled',
	'AGM_USE_SCHEDULE'			=> 'Use the schedule',
	'AGM_USE_SCHEDULE_EXPLAIN'	=> 'When ticked, the page only shows between the start and end dates below.',
	'AGM_AUTO_OFF'				=> 'Turn off automatically at the end date',
	'AGM_AUTO_OFF_EXPLAIN'		=> 'Switches maintenance off on the first visit after the end date passes.',

	'AGM_SYNC_BOARD'			=> 'Also disable the phpBB board',
	'AGM_SYNC_BOARD_EXPLAIN'	=> 'Sets Disable board in General → Board settings to Yes when maintenance starts, and restores it when maintenance ends.',
	'AGM_SHOW_TO_ADMINS'		=> 'Show the page to administrators too',
	'AGM_SHOW_TO_ADMINS_EXPLAIN' => 'Handy to check the result without logging out. The ACP always stays reachable.',
	'AGM_BOARD_DISABLE_STATE'	=> 'phpBB board',
	'AGM_BOARD_OFF'				=> 'Disabled',
	'AGM_BOARD_ON'				=> 'Enabled',

	'AGM_NOTICE'				=> 'Show a notice to all users?',
	'AGM_NOTICE_EXPLAIN'		=> 'Displays a banner at the top of every board page before maintenance starts. Requires the schedule with a start and an end date.',
	'AGM_NOTICE_DAYS'			=> 'Days in advance',
	'AGM_NOTICE_DAYS_EXPLAIN'	=> 'Only show the notice within this many days of the start. Use 0 to always show it.',
	'AGM_NOTICE_DAYS_UNIT'		=> 'days (0 = always)',
	'AGM_NOTICE_NOW'			=> 'Notice currently visible',
	'AGM_NOTICE_NOW_EXPLAIN'	=> 'This is exactly what users are seeing on the board right now.',
	'AGM_M_NOTICE'				=> 'Advance notice text',
	'AGM_M_NOTICE_EXPLAIN'		=> 'Placeholders: {START} start date and time, {END} end date and time, {SITENAME} board name.',

	'AGM_PERIOD'				=> 'Maintenance period',
	'AGM_DATE_START'			=> 'Start date and time',
	'AGM_DATE_START_EXPLAIN'	=> 'Uses your account timezone. Leave empty for no start limit.',
	'AGM_DATE_END'				=> 'End date and time',
	'AGM_DATE_END_EXPLAIN'		=> 'Also used as the countdown target. Leave empty for no end limit.',
	'AGM_TOOLS'					=> 'Shortcuts',
	'AGM_SET_NOW'				=> 'Set current time',
	'AGM_PLUS_ONE_HOUR'			=> 'End = start + 1 hour',
	'AGM_CLEAR_DATES'			=> 'Clear dates',

	'AGM_APPEARANCE'			=> 'Page options',
	'AGM_SHOW_GEAR'				=> 'Show the gear icon',
	'AGM_SHOW_GEAR_EXPLAIN'		=> 'Displays the gear above the title.',
	'AGM_SPIN_GEAR'				=> 'Rotate the gear',
	'AGM_SPIN_GEAR_EXPLAIN'		=> 'Ignored for visitors who ask for reduced motion.',
	'AGM_PARTICLES'				=> 'Falling particles',
	'AGM_PARTICLES_EXPLAIN'		=> 'Animated background dots drifting down the page.',
	'AGM_PARTICLE_STYLE'	=> 'Background effect',
	'AGM_PARTICLE_STYLE_EXPLAIN'	=> 'With the particles on, choose what to draw: drifting flakes, twinkling stars, or both together.',
	'AGM_PARTICLE_SNOW'	=> 'Drifting flakes',
	'AGM_PARTICLE_STARS'	=> 'Twinkling stars',
	'AGM_PARTICLE_BOTH'	=> 'Flakes and stars',
	'AGM_COUNTDOWN'				=> 'Show the countdown',
	'AGM_COUNTDOWN_EXPLAIN'		=> 'Counts down to the end date. Needs an end date to appear.',
	'AGM_LANG_SWITCHER'			=> 'Show the language switch',
	'AGM_LANG_SWITCHER_EXPLAIN'	=> 'Shows a button for each of the 18 languages at the top, so visitors read the page in their own.',
	'AGM_ADMIN_LINK'			=> 'Show the admin panel button',
	'AGM_ADMIN_LINK_EXPLAIN'	=> 'Adds a link to the ACP at the bottom of the page.',
	'AGM_DEFAULT_LANG'			=> 'Default language',
	'AGM_DEFAULT_LANG_EXPLAIN'	=> 'Used when the visitor language is not among the available ones.',
	'AGM_REFRESH'				=> 'Automatic refresh',
	'AGM_REFRESH_EXPLAIN'		=> 'Reloads the page at this interval. Use 0 to disable.',
	'AGM_SECONDS'				=> 'seconds',
	'AGM_LOGO_URL'				=> 'Logo URL',
	'AGM_LOGO_URL_EXPLAIN'		=> 'Optional. When empty the board name initials are shown instead.',

	'AGM_SHOW_DATES'			=> 'Show start and end inside the card',
	'AGM_SHOW_DATES_EXPLAIN'	=> 'The two cards below the remaining time.',
	'AGM_PROGRESS_BAR'			=> 'Show the progress bar',
	'AGM_PROGRESS_BAR_EXPLAIN'	=> 'Fills up from start to end. Both dates are required.',
	'AGM_C_CD_FROM'				=> 'Countdown card, gradient start',
	'AGM_C_CD_EXPLAIN'			=> 'An 8-digit hex makes it translucent, e.g. #2b3f8fcc.',
	'AGM_C_CD_TO'				=> 'Countdown card, gradient end',
	'AGM_C_PROG_A'				=> 'Progress bar, start colour',
	'AGM_C_PROG_B'				=> 'Progress bar, end colour',

	'AGM_LOGO_UPLOAD'	=> 'Upload a logo',
	'AGM_LOGO_UPLOAD_EXPLAIN'	=> 'Pick a PNG or JPEG file from your computer: it is stored in images/ and the field above is filled in for you. 2 MB at most.',
	'AGM_LOGO_UPLOAD_BTN'	=> 'Upload',
	'AGM_LOGO_UPLOADED'	=> 'The logo has been uploaded.',
	'AGM_ERR_UPLOAD_NONE'	=> 'Choose a file to upload first.',
	'AGM_ERR_UPLOAD_TYPE'	=> 'Only PNG or JPEG images are accepted.',
	'AGM_ERR_UPLOAD_SIZE'	=> 'The file is too large: the limit is 2 MB.',
	'AGM_ERR_UPLOAD_DIR'	=> 'The folder %s does not exist or is not writable. Create it and give it write permission.',
	'AGM_ERR_UPLOAD_MOVE'	=> 'The uploaded file could not be saved into %s. Check the write permissions.',
	'AGM_LOGO_DELETE_BTN'	=> 'Delete Image',
	'AGM_LOGO_DELETED'	=> 'The logo has been deleted.',
	'AGM_LOGO_DELETE_CONFIRM'	=> 'Do you really want to delete the file %s from the server? This cannot be undone.',
	'AGM_ERR_DELETE'	=> 'The file could not be deleted. Check the permissions, or remove it over FTP.',
	'AGM_ERR_DELETE_NONE'	=> 'There is no image to delete.',
	'AGM_PALETTE'				=> 'Colour palette',
	'AGM_C_BG_START'			=> 'Background gradient, start',
	'AGM_C_BG_END'				=> 'Background gradient, end',
	'AGM_C_TOPBAR'				=> 'Top bar',
	'AGM_C_ACCENT'				=> 'Accent (buttons and links)',
	'AGM_C_TEXT'				=> 'Main text',
	'AGM_C_MUTED'				=> 'Secondary text',
	'AGM_C_CARD'				=> 'Card background',
	'AGM_C_CARD_EXPLAIN'		=> 'Accepts 8-digit hex for transparency, e.g. #16255180.',

	'AGM_OPACITY'				=> 'Opacity',
	'AGM_RESET_COLORS'			=> 'Restore the colours',
	'AGM_RESET_COLORS_EXPLAIN'	=> 'Puts every palette field back to its original colour. Remember to save to apply.',
	'AGM_RESET_COLORS_BTN'		=> 'Default colours',

	'AGM_CONTACTS'				=> 'Contacts',
	'AGM_CONTACT_EMAIL'			=> 'Contact email',
	'AGM_CONTACT_PHONE'			=> 'Contact phone',

	'AGM_MESSAGES'				=> 'Page messages',
	'AGM_MESSAGES_EXPLAIN'		=> 'The texts visitors read come from the extension language files. Here you can override them with your own wording, one language at a time.',
	'AGM_EDIT_LANG'				=> 'Language to edit',
	'AGM_EDIT_LANG_EXPLAIN'		=> 'Pick a language and press Load to see its texts. The fields start from the translation in the language file: empty one to go back to the shipped wording.',
	'AGM_LOAD_LANG'				=> 'Load',
	'AGM_RESET_TEXTS_BTN'	=> 'Restore the shipped texts',
	'AGM_TEXTS_RESET'	=> 'The texts of this language are back to the ones in the language file.',
	'AGM_EDITING_NOW'	=> 'You are editing the texts of:',
	'AGM_M_TITLE'				=> 'Title',
	'AGM_M_SUBTITLE'			=> 'Subtitle',
	'AGM_M_DESCRIPTION'			=> 'Description',
	'AGM_M_FOOTER'				=> 'Closing line',

	'AGM_LOG'					=> 'Activation log',
	'AGM_LAST_ON'				=> 'Last activation',
	'AGM_LAST_OFF'				=> 'Last deactivation',
	'AGM_TOTAL_ON'				=> 'Total activations',

	'AGM_SETTINGS_SAVED'		=> 'Maintenance settings saved.',
	'AGM_ACTIVATED'				=> 'Maintenance mode is now on.',
	'AGM_DEACTIVATED'			=> 'Maintenance mode is now off.',
	'AGM_ERR_START'				=> 'The start date is not a valid date and time.',
	'AGM_ERR_END'				=> 'The end date is not a valid date and time.',
	'AGM_ERR_RANGE'				=> 'The end date must come after the start date.',
	'AGM_ERR_EMAIL'				=> 'The contact email address is not valid.',

	'AGM_UNIT_DAYS'				=> 'd',
	'AGM_UNIT_HOURS'			=> 'h',
	'AGM_UNIT_MINUTES'			=> 'min',

	'ACL_U_AGM_BYPASS'			=> 'Can browse the board during maintenance',
));
