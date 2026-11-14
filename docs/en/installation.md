---
title: Installation
summary: Requirements, installing NEO Cookie Consent with the Contao Manager or Composer, public files, back-end languages, updating and removing.
audience: operations
language: en
updated: 2026-11-12
---

# Installation

## Requirements

| What | Needed for |
| --- | --- |
| Contao 5.3 to 6.0 (`contao/core-bundle ^5.3 \|\| ^6.0`) | everything |
| PHP 8.2 to 8.5, as far as the Contao version supports it (Contao 5.7 needs 8.3, Contao 6.0 needs 8.4), with `ctype` and `mbstring` | everything |
| `neo-digital/contao-basic-bundle` | installed automatically; it provides the menu group of the back end. The extension needs no licence key and no access key from it. |
| The Contao cron (web cron or the command `contao:cron`) | the daily scan and the deletion of old entries of the proof of consent |
| A working mailer of Contao and an administrator e-mail address in the system settings | the e-mail of the scan |
| The server can open the pages of the website under their public address | the scan |

## Installing with the Contao Manager

1. Open the Contao Manager.
2. Search for `neo-digital/contao-cookieconsent-bundle`.
3. Click **Add** and then **Apply changes**.
4. When the Contao Manager asks, run the database update and apply all changes
   it proposes.

## Installing with Composer

```bash
composer require neo-digital/contao-cookieconsent-bundle
php vendor/bin/contao-console contao:migrate
```

`contao:migrate` creates the tables of the extension. Composer copies the
script and the stylesheet of the banner to
`public/bundles/neocookieconsent/`; if that did not happen, run:

```bash
php vendor/bin/contao-console assets:install
```

## After the installation

The back end shows the module **NEO Digital › Cookie consent**. The banner is
switched on, but it appears only once at least one active service needs
consent. No module in the page layout is needed. Continue with
[Setup](setup.md).

## Back-end languages

Back end, banner, placeholders and cookie list are available in English,
German, French, Dutch, Italian, Polish, Czech, Hungarian, Slovenian, Croatian
and Spanish. Pages in other languages get English, unless own texts exist for
the language (see [User manual](usage.md#texts-per-language)). Contao offers
Hungarian and Croatian as back-end languages only once they are enabled in
`config/config.yaml`:

```yaml
contao:
    intl:
        enabled_locales: ['+hu', '+hr']
```

## Updating

1. Update the package with the Contao Manager or with
   `composer update neo-digital/contao-cookieconsent-bundle`.
2. Run the database update (`contao:migrate`).
3. Read `CHANGELOG.md` of the new version. When a version needs new
   permissions or a step after the update, the changelog says so.
4. If you override templates of the extension, compare them with the new
   versions in `vendor/neo-digital/contao-cookieconsent-bundle/contao/templates/`.

## Removing

1. Remove the insert tags `{{cookie_consent::…}}` and the content elements
   *Cookie list* from the website. Without the extension they are not
   resolved any more.
2. Remove the package with the Contao Manager or with
   `composer remove neo-digital/contao-cookieconsent-bundle`.
3. Run the database update. Contao then offers to delete the tables of the
   extension: services, settings, texts, scan results and the proof of
   consent. If you have to keep the proof of consent, back up the table
   `tl_neo_cookieconsent_log` first; the extension has no export.

Without the extension, no service is held back any more. Remove services that
need consent from the website before removing the extension, or replace the
banner.
