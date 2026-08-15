# Adding a language to Forum Maintenance Mode

Author: Salvo Cortesiano — https://netshadows.de/ombra/
Copyright (c) 2026-08-11 20:00 CEST — GPL-2.0

The extension speaks 18 languages. There are **two separate places** a language lives, and knowing
which one you are touching saves a lot of confusion:

| Where | Who reads it | How to add a language |
|---|---|---|
| **The settings panel** | Administrators, inside the ACP | Drop three files in a folder — no code |
| **The maintenance page** | Your visitors, during maintenance | Add an entry in `core/helper.php` |

---

## Contents

- [Languages already included](#languages-already-included)
- [Part 1 — Translating the settings panel](#part-1--translating-the-settings-panel)
- [Part 2 — Adding a language to the maintenance page](#part-2--adding-a-language-to-the-maintenance-page)
- [How the page picks a language](#how-the-page-picks-a-language)
- [Rules that matter](#rules-that-matter)
- [Checking your work](#checking-your-work)
- [Sharing it back](#sharing-it-back)

---

## Languages already included

Italian, English, French, German, Spanish, Portuguese, Dutch, Polish, Russian, Turkish, Greek,
Czech, Romanian, Swedish, Hungarian, Arabic, Japanese and Simplified Chinese.

Each one has both parts done: the panel is translated, and the maintenance page shows a button for
it in the switch at the top.

---

## Part 1 — Translating the settings panel

This part needs no programming.

### 1. Name the folder like the phpBB pack

phpBB pairs them by folder name. If the board's pack is `language/fi/`, your folder is `fi`.

### 2. Copy English and translate the values

```
ext/salvocortesiano/maintenance/language/en/  →  .../language/fi/
```

Three files, 120 strings in total:

| File | Holds |
|---|---|
| `acp_maintenance.php` | 117 strings: labels, hints, buttons and errors of the panel |
| `info_acp_maintenance.php` | 2 strings: the names of the ACP menu entries |
| `permissions_agm.php` | 1 string: the permission name |

Change only what is after `=>`; the key on the left is how the code finds the text.

```php
'AGM_TURN_ON'    => 'Kytke huoltotila päälle',
```

### 3. Save as UTF-8 without BOM, then purge the cache

**ACP → General → Purge the cache**, set your account to that language, and open the panel.

---

## Part 2 — Adding a language to the maintenance page

This is the page your visitors see, with the switch at the top. It does **not** read the files from
Part 1: its wording is built into `core/helper.php` so the page can be rendered before phpBB has
loaded anything else. Adding a language means editing one file, in three places.

### 1. Add the code to the list

```php
const LANGS = array('it', 'en', 'fr', /* ... */, 'zh_cmn_hans', 'fi');
```

The order of this list is the order of the buttons on the page.

### 2. Add the name and the button label

In `lang_names()`:

```php
'fi' => array('code' => 'FI', 'name' => 'Suomi'),
```

`code` is the two letters on the button, `name` the tooltip and the label used in the panel.

### 3. Add the two sets of text

In `default_messages()`, the four texts the administrator can override plus the advance notice:

```php
'fi' => array(
    'title'       => 'Sivusto on huollossa',
    'subtitle'    => 'Teemme parannuksia sivustoon',
    'description' => 'Sivusto ei ole hetkeen käytettävissä suunnitellun huollon vuoksi.',
    'footer'      => 'Palaamme pian!',
    'notice'      => 'Foorumilla tehdään ylimääräinen huolto {START} – {END}. Kiitos kärsivällisyydestä.',
),
```

In `ui_strings()`, the fixed labels of the page:

```php
'fi' => array(
    'contact'      => 'Kiireellisissä asioissa ota yhteyttä:',
    'admin_ask'    => 'Oletko ylläpitäjä?',
    'admin_btn'    => 'Siirry hallintapaneeliin',
    'remaining'    => 'Aikaa jäljellä',
    'start_label'  => 'Huollon alku',
    'end_label'    => 'Arvioitu loppu',
    'progress'     => 'Huollon eteneminen',
    'ended'        => 'Huolto on ohi, palataan foorumille...',
    'u_d'          => 'pv',
    'u_h'          => 't',
    'u_m'          => 'min',
    'u_s'          => 's',
    'preview'      => 'Esikatselu',
    'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page.',
),
```

Every key must be present. `u_d`, `u_h`, `u_m` and `u_s` are the single letters in the countdown
(`2h 14m 08s`), so keep them very short.

`admin_banner` is only seen by administrators; leaving the English text there is fine.

### 4. That is all

The button appears by itself: the switch is built from `LANGS`, so there is nothing to edit in the
template. Purge the cache and open the preview from the panel.

---

## How the page picks a language

For each visitor, in this order:

1. **What they clicked.** The switch adds `?agm_lang=fi`, and that wins.
2. **Their phpBB language.** The pack name is matched whole first (`zh_cmn_hans`), then by its first
   two letters, so `pt_br` lands on `pt` and `de_x_sie` on `de`.
3. **The default** chosen in the panel, when their language is not among the supported ones.
4. **English**, if even that default is missing.

The choice is remembered in the browser, so a visitor who switches to Finnish keeps seeing Finnish
while the maintenance lasts.

---

## Rules that matter

**Escape the apostrophes.** Strings are in single quotes, so an apostrophe inside needs a backslash:

```php
'AGM_NOTICE_DAYS_EXPLAIN'  => 'Ne montre l\'avis que dans ce nombre de jours.',
```

Forgetting this is the commonest way to take a board down: PHP stops with a parse error.

**Leave the placeholders alone.** `{START}`, `{END}` and `{SITENAME}` are replaced at runtime with
the real dates and the board name. Translate around them, never inside the braces.

**Leave the colour examples alone.** `#2b3f8fcc` and `#16255180` are sample values.

**Keep labels short.** Buttons and table headings sit in narrow columns.

**Never rename a key.** A renamed key shows up as raw `AGM_SOMETHING` on screen.

---

## Checking your work

- [ ] Folder named exactly like the phpBB pack (Part 1)
- [ ] Every key from the English files present, none renamed
- [ ] Apostrophes escaped as `\'`
- [ ] `{START}`, `{END}` and `{SITENAME}` intact
- [ ] Files saved as UTF-8 with no byte order mark
- [ ] For Part 2: the code appears in `LANGS`, in `lang_names()`, in `default_messages()` and in
      `ui_strings()` — all four, with the same spelling
- [ ] Cache purged, panel and preview both checked

To compare key lists where PHP is available:

```bash
php -r 'include "en/acp_maintenance.php"; $a=array_keys($lang); $lang=[];
        include "fi/acp_maintenance.php"; $b=array_keys($lang);
        print_r(array_diff($a,$b));'
```

An empty result means nothing is missing.

---

## Sharing it back

Translations are welcome, whole or partial: phpBB falls back to English for anything absent, so a
half finished pack still works. Send the folder, or the four snippets from Part 2, to
[netshadows.de/ombra](https://netshadows.de/ombra/) and it can travel with the extension, credited
to you.
