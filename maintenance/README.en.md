# Forum Maintenance Mode

A phpBB 3.3 extension that replaces the board with a full-screen maintenance page,
configurable from the ACP.

*Leggi questo file in [italiano](README.md).*

| | |
|---|---|
| **Author** | Salvo Cortesiano |
| **Copyright** | (c) 2026-08-11 20:00 CEST Salvo Cortesiano |
| **Forum** | https://netshadows.de/ombra/ |
| **License** | GNU General Public License, version 2 (GPL-2.0) |
| **Version** | 2.0.0 |

## Installation

1. Copy the `salvocortesiano/maintenance` folder into your board's `ext/` directory:
   `forum/ext/salvocortesiano/maintenance/`
2. ACP → **Customise** → **Manage extensions** → **Enable** on *Forum Maintenance Mode*.
3. ACP → **Extensions** → **Maintenance mode** → *Maintenance settings*.

Requirements: phpBB 3.3.0+ and PHP 7.1.3+.

## What you can configure

The name shown at the top of the page and in the browser title is the **Site name** set in
ACP → General → Board settings: the extension reads it from there, so there is nothing to retype
here. When no logo is set, the badge beside the name shows its initials.

| Section | Contents |
|---|---|
| Current status | status, phpBB board status, start time, estimated duration, on/off, preview |
| Maintenance mode | **Enabled / Disabled** radio, disable the phpBB board, show the page to admins, schedule, automatic switch-off |
| Maintenance period | **start** and **end** date and time (native browser picker), shortcuts |
| Page options | gear, gear rotation, particles, countdown, start/end cards, progress bar, IT/EN switch, admin button, refresh, logo |
| Colour palette | background gradient, top bar, accent, text, secondary text, cards, countdown card gradient, progress bar, reset button |
| Contacts | email and phone shown in the card |
| Messages IT / EN | title, subtitle, description and closing line for each language |
| Activation log | last activation, last deactivation, total activations |

## Languages

The maintenance page speaks **18 languages**: Italian, English, French, German, Spanish,
Portuguese, Dutch, Polish, Russian, Turkish, Greek, Czech, Romanian, Swedish, Hungarian, Arabic,
Japanese and Simplified Chinese.

Every visitor sees it in the language of their account and can change it with the switch at the
top, which carries one button per language. If their language is not among these, the default
chosen in the panel is used.

The administration panel is translated into the same 18 languages, and the page texts are editable
for each of them under *Page messages*: every language has its own collapsible block, already
filled in with the bundled translation.

To add more, see [TRANSLATING.md](TRANSLATING.md).

The page translations live in **language files**, one per folder:
`language/<code>/maintenance_page.php`. The extension reads the folders it finds, so adding a
language means dropping the translated file in place — no code change. Anyone who wants to
contribute sends you that file and you put it where it belongs.

On the page itself visitors pick their language from a **drop down** listing the full names.

## The countdown card

It appears when maintenance has an **end date** and the countdown is switched on. It contains:

- **Time Remaining** in compact form: `5m 35s`, `2h 14m 08s`, `3d 05h 20m`
- **Maintenance start** and **Estimated end**, shown in the visitor's own timezone
- **Maintenance progress**, a bar filling from start to end (a start date is required too)

The countdown is anchored to the server clock, so it stays correct even when the visitor's own
computer clock is wrong. On reaching zero the visitor is taken back to the board index: with the
automatic switch-off enabled, the board is already online again by then.

## Colour palette

Every colour has its own clickable swatch. The three fields that accept transparency — the two
countdown card gradient stops and the card background — also have an **Opacity** slider: the
swatch picks the colour, the slider the transparency, and the text field is rebuilt in 8-digit
hex form. The **Default colours** button puts all eleven fields back to their original values;
remember to save to apply.

## Advance notice for all users

With the **Show a notice to all users?** checkbox ticked, a banner appears at the top of every
board page *before* maintenance starts, for example:

> All users and releasers are advised that the board will undergo extraordinary maintenance from
> 13/08/2026 06:00 to 13/08/2026 08:00. Thank you for your patience.

The dates come from the **Maintenance period** fields in the ACP and are shown in the reader's own
timezone. The wording is editable in Italian and English under Messages, with the `{START}`,
`{END}` and `{SITENAME}` placeholders.

The dates and times in the notice are shown in the **reader's own timezone**, derived from the
exact moment saved in the ACP: the time you type in the panel is the one users see, with no shift
caused by your account's timezone setting.

The notice needs the schedule with a start and an end date, and disappears by itself once
maintenance begins, since from then on visitors get the full-screen page. **Days in advance** lets
you show it only in the last days before the work; 0 means always. When the notice is live, the
ACP shows the exact text users are reading.

## Keeping phpBB's "Disable board" in step

The **Also disable the phpBB board** option (on by default) sets *Disable board* in
ACP → General → Board settings to Yes while maintenance is running, and restores the previous
value when it ends. That is a second line of defence: should the extension ever miss a page,
phpBB's own block takes over.

While maintenance is running the extension neutralises phpBB's own block (using the
`SKIP_CHECK_DISABLED` constant phpBB itself provides), otherwise visitors would get the plain
"The board is temporarily unavailable" notice instead of the custom page: in phpBB's `user::setup()`
that check fires right after the event the extension hooks into.

Should the board ever stay closed with no maintenance running, the panel flags it in red and offers
the **Reopen the board now** button.

## Access during maintenance

- Administrators (`a_`) and founders always see the board. So if you test while signed in as the
  founder you will see the normal front page: that is intended, not a fault. To check the result
  use the preview, a private window, or turn on **Show the page to administrators too**.
- The **Can browse the board during maintenance** user permission (`u_agm_bypass`) lets you
  authorise other groups, global moderators for instance.
- `ucp.php?mode=login` stays reachable, so you can sign in and then open the ACP.
- The page answers with **HTTP 503** and `Retry-After`, which is the correct behaviour for
  search engines.

## The admin panel button

phpBB answers with a 401 error when `adm/index.php` is opened without the session id: that is why
the ACP cannot be reached by typing the URL by hand. The button on the maintenance page carries
it, exactly like the link at the bottom of the board's pages. Visitors who have not signed in are
taken to the login form instead.

## Responsive layout

The layout is a single fluid column. Below 600 px the two start/end cards stack, the contacts go
vertical, typography and gear scale down, and the top bar truncates the board name rather than
wrapping it. Headings and the remaining time use `clamp()`, so they scale with the screen width
without jumps.

## Preview

Two ways, both restricted to administrators:

- **Open preview in a new tab** → opens `app.php/maintenance/preview`
- **Preview here** → shows the page in an iframe inside the ACP

The preview works even when maintenance is switched off.

## Notes for anyone editing the code

The page layout lives in `styles/all/template/maintenance_page.html`. To change it without
touching the extension, copy the file to
`styles/<your_style>/template/ext/salvocortesiano/maintenance/maintenance_page.html`.

Mind one phpBB trap: its template lexer rewrites curly braces in template files, so a quantifier
such as `{6}` inside a JavaScript regular expression gets transformed and quietly stops matching.
That is why the colour parsing in this extension is done character by character, with no regular
expressions.

## Uninstalling

ACP → Manage extensions → *Disable* (keeps the data) or *Delete data*
(removes the settings, the ACP module and the permission).

## License

GNU General Public License, version 2 (GPL-2.0)

Copyright (c) 2026-08-11 20:00 CEST Salvo Cortesiano — https://netshadows.de/ombra/
