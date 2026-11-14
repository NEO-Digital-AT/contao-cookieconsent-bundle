---
title: Setup
summary: Setting up NEO Cookie Consent in the order you need it – settings, first scan, services, cookie list in the privacy policy, link in the footer, several websites and languages, scan on the command line.
audience: operations
language: en
updated: 2026-11-14
---

# Setup

The module **NEO Digital › Cookie consent** opens with the list of services.
Above the list are the buttons **Settings**, **Texts**, **Scan results** and
**Proof of consent**. The banner needs no module in the page layout: the
extension adds it to every page of the front end.

## 1. Settings

Click **Settings**. The form opens directly; there is one record of settings
for the whole installation.

### Licence

The box **Licence** at the top states the condition of the free licence: the
legal notice of every website on which the extension runs publicly names it
with a link. The box has the credit as text with link ("Cookie banner: NEO
Cookie Consent by NEO Digital") and as HTML to copy into the source code of
the legal notice; the link carries `rel="nofollow"`. The full terms are in the
file `LICENSE` of the package.

### Banner

| Field | Preset | Meaning |
| --- | --- | --- |
| **Show the banner** | on | Shows the banner on all pages and blocks services until consent. Off: nothing is shown and nothing is blocked; all other fields of the banner, blocking and proof of consent are greyed out with the reason at the field. |
| **Appears** | Immediately when the page loads | Or: After the first scroll, click, mouse movement or Tab key. Visitors then see the page first. |
| **Position** | Bar at the bottom | Bar at the top, Centre of the screen, Side panel left, Side panel right |
| **Dim the background** | off | A translucent layer over the page while the banner is open. The page can then be used only after a choice (the banner is modal). |
| **Button to reopen** | Bottom left | Bottom right, or No button. Without the button the website needs a link, e.g. `{{cookie_consent::settings}}` in the footer (step 5). Buttons of other extensions in the same corner are arranged with it as set in the page layout ([User manual](usage.md#together-with-other-buttons-in-the-same-corner)). |
| **Privacy policy** | – | The page the banner links to. Until a page is chosen, the list of services shows a note. |
| **Legal notice** | – | The page the banner links to. |

### Blocking

| Field | Preset | Meaning |
| --- | --- | --- |
| **Block scripts** | on | Scripts and stylesheets of web fonts of known services in the pages run only after consent. |
| **Block embedded content** | on | Videos, maps and posts of known services show a placeholder with "Load content" until consent. |
| **Google Consent Mode v2** | on | Reports the choice to Google services (basic mode: no Google service loads before consent). Greyed out until one of the Google templates (Google Analytics 4, Google Tag Manager, Google Ads, Google AdSense) is among the active services. |

"Known services" are the 47 templates of the catalogue and your own services
with **Addresses** (see [User manual](usage.md#own-service-without-a-template)).

### Proof of consent

| Field | Preset | Meaning |
| --- | --- | --- |
| **Store consents** | on | Stores one entry per choice: random consent ID, time, version and choice, without IP address. |
| **Keep for** | 3 years | 1, 2, 3 or 5 years. Older entries are deleted by the daily cron. |

### Scan

| Field | Preset | Meaning |
| --- | --- | --- |
| **Check daily** | on | The daily cron reads the published pages, adds services of the catalogue it finds and reports unknown addresses. |
| **Pages per check** | 25 | 10, 25, 50 or 100 pages. The first page of each website comes first, then the most recently changed pages. |
| **Report to** | empty | E-mail address for reports about new services. Empty: the administrator e-mail address of the system settings (shown as placeholder). |

Below the scan fields, a line shows the last check ("Last checked on …: …
pages read, … services and addresses found, … added."), with the button
**Check now** and the link **View scan results**.

### Version

A line shows the current version of the consent ("Version 3, last changed on
…"). The version goes up on its own when a visitor would read something else
about the services; every visitor is then asked again (see
[User manual](usage.md#when-visitors-are-asked-again)).

Save the settings.

## 2. First scan

1. In the settings, click **Check now**. The extension saves the form and
   reads the pages.
2. The confirmation names the number of pages and findings, e.g. "25 pages
   read, 4 services and addresses found." Services that were added are named:
   "New in the banner, blocked until consent: …". Unknown addresses are named
   as well.
3. Open the list of services and check every added service: category, ID and,
   for services that the banner should load itself, **Loading** (see
   [User manual](usage.md#services)).
4. Open **Scan results** and decide on every unknown address (see
   [User manual](usage.md#scan-results)).

The scan opens the pages from the server under their public address. Pages
that could not be read are listed: "Could not be read: …".

## 3. Add the remaining services

Add every service the website uses that the scan did not find, e.g. a service
that only loads after a click. Use **New service** and a template where one
exists; see [User manual](usage.md#adding-a-service-from-a-template).

## 4. Cookie list in the privacy policy

The privacy policy names every service with provider, purpose, cookies and
third country. Two ways, same output:

- the insert tag `{{cookie_consent::table}}` in a text of the privacy policy;
- the content element **Cookie list** (group *NEO Digital*) in the article
  of the privacy policy.

Both show one table per category with service, provider, purpose, cookies with
storage period, third country and the link to the provider's privacy policy,
in the language of the page, followed by a link that opens the cookie
settings. The tables always show what the banner shows. Check them after every
change of the services.

## 5. Link in the footer

| Insert tag | Output |
| --- | --- |
| `{{cookie_consent::settings}}` | A link that opens the cookie settings, labelled with the text **Cookie settings** of the language |
| `{{cookie_consent::settings::Own label}}` | The same link with your own label |
| `{{cookie_consent::id}}` | The consent ID of the visitor (filled in by the browser) |

Put the link into the footer when **Button to reopen** is *No button*.

## 6. Check

Open the website in a private browser window. The banner appears with the
categories that have services. Click **Settings**: every category shows its
services. Choose **Necessary only** and check with the developer tools of the
browser that no script of a statistics or marketing service loaded.

## Several websites and languages

- **Services per website.** Every service has the field **Websites** (section
  *Addresses and websites*): nothing ticked means all websites of the
  installation. The scan sets the websites on which it found a service when
  the installation has more than one root page.
- **Texts per language.** Every website gets the texts in the language of its
  root page. For own texts, create a record per language under **Texts** (see
  [User manual](usage.md#texts-per-language)). A language record can also set
  its own pages for privacy policy and legal notice; empty means the pages of
  the settings, in the language of the page: when the pages of the languages
  are linked (terminal42/contao-changelanguage, *Main language page*), the
  banner links the linked page of the website the visitor is on by itself.
- **Measurement across your domains.** Google Analytics 4 and Google Ads have
  the field **Domains for cross-domain measurement** (one domain per line,
  e.g. `app.example.com`). Links to these domains carry the measurement over,
  so a visit across them counts as one. Only domain names are accepted.
- **Names and purposes per language.** With more than one language in the
  installation, the form of a service shows the section **Languages** with
  name and purpose per language.
- The settings (banner, blocking, proof of consent, scan) apply to all
  websites.

## Scan on the command line

The scan runs with Contao's daily cron. When the cron runs on the command line
(`contao:cron`), Symfony does not know the address of the website and the
links the scan reads point to `localhost`. Set the address in
`config/config.yaml`:

```yaml
parameters:
    router.request_context.host: 'www.example.com'
    router.request_context.scheme: 'https'
```

Root pages with a **Domain name** are opened under that domain in any case.
