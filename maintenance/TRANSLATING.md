# Adding a language to Forum Maintenance Mode

Author: Salvo Cortesiano — https://netshadows.de/ombra/
Copyright (c) 2026-08-11 20:00 CEST — GPL-2.0

The extension speaks 18 languages. There are **two separate places** a language lives, and knowing
which one you are touching saves a lot of confusion:

| Where | Who reads it | How to add a language |
|---|---|---|
| **The settings panel** | Administrators, inside the ACP | Drop three files in a folder — no code |
| **The maintenance page** | Your visitors, during maintenance | Drop one file in a folder — no code |

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

This is the page your visitors see. Since version 2.0 it needs **no code at all**: the extension
looks inside its own `language/` directory and offers every folder that carries a
`maintenance_page.php` file.

### 1. Copy the file

```
ext/salvocortesiano/maintenance/language/en/maintenance_page.php
   →  ext/salvocortesiano/maintenance/language/fi/maintenance_page.php
```

Name the folder like the phpBB language pack, so visitors using that pack get the page in their own
language without touching anything.

### 2. Translate the values

Twenty strings. The first three decide how the language appears in the chooser:

```php
'AGM_PAGE_LANG_NAME'  => 'Suomi',      // shown in the drop down
'AGM_PAGE_LANG_CODE'  => 'FI',         // short label
'AGM_PAGE_CHOOSE'     => 'Kieli',      // the word "Language" in that language
```

Then the four texts an administrator can override, the advance notice, the fixed labels of the page
and the four countdown units. Keep `AGM_PAGE_U_D`, `U_H`, `U_M` and `U_S` very short: they appear as
`2h 14m 08s`.

### 3. Nothing else

Purge the cache and open the preview. The language is in the drop down, and it is also listed in the
settings panel where its texts can be overridden. Removing the folder removes the language just as
cleanly.

That is the whole contribution: **one file, one folder**. Anyone can send you theirs and you drop it
in place.

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
