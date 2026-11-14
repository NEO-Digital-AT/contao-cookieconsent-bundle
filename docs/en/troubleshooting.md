---
title: Troubleshooting
summary: Common problems with NEO Cookie Consent – banner missing, services not blocked or loading twice, scan errors, missing permissions – with cause and solution.
audience: operations
language: en
updated: 2026-11-14
---

# Troubleshooting

Notes above the list of services name the most common gaps. A failed daily
scan is written to the log file of the installation (`var/logs/`) as "Cookie
consent scan failed: …"; an e-mail that could not be sent as "Cookie consent
scan: the mail could not be sent: …". Missing menu entries or fields are nearly
always missing permissions; see [Permissions](permissions.md).

## Banner

| What you see | Why | What to do |
| --- | --- | --- |
| The banner does not appear | **Show the banner** is off ("The cookie banner is switched off."); or no active service of this website has a category other than *Necessary* | Switch it on in **Settings**; add or activate the services. |
| The banner appears only after scrolling | **Appears** is set to *After the first scroll, click, mouse movement or Tab key* | Intended; choose *Immediately when the page loads* otherwise. |
| The banner appears again after every change | A service was added, removed or changed in what visitors read; the version went up | Intended ([User manual](usage.md#when-visitors-are-asked-again)). |
| The banner does not appear again after a change of the cookies | Cookies and the privacy link are not part of the version | Intended. |
| Visitors cannot reopen the settings | **Button to reopen** is *No button* and no link exists | Add `{{cookie_consent::settings}}` to the footer. |
| The button to reopen is missing, a cogwheel sits in its corner | Buttons of other extensions share the corner; the page layout arranges them as *One settings button with a menu* | Intended; **Cookie settings** in the menu opens the settings. Another arrangement is set in the page layout (**Buttons at the edge of the screen**), another corner here. |
| The button to reopen lies on top of another button | Both sit in one corner, and an overridden template lacks the `data-neo-dock` attributes, or NEO Basic is older than the buttons at the edge of the screen | Take the attributes over ([Customising](customising.md#templates)); update NEO Basic. |
| No links to privacy policy or legal notice in the banner | No page chosen in **Settings** (or in the text record of the language) | Choose the pages. |
| The banner is in English on a page in another language | No default texts for this language and no own text record | Create a text record for the language under **Texts**. |
| Buttons of the banner do nothing after a template was overridden | The own template lacks `data-ncc-*` attributes | Compare it with the template of the extension ([Customising](customising.md#templates)). |
| A category is missing in the settings | It has no active service on this website | Intended. |
| An AI chat says it is not available, or its consent button does nothing | No active service in the chat's consent category, so the banner never asks for it | Add the service *AI chat assistant* in that category; the link at **Consent category** in the assistant's form does it. |

## Blocking and loading

| What you see | Why | What to do |
| --- | --- | --- |
| A service loads before consent | **Block scripts** or **Block embedded content** is off; or the service is not in the catalogue and has no own service with **Addresses**; or it carries `data-ncc-ignore`; or it is listed under *Necessary* | Switch blocking on; add an own service with the domain under **Addresses**; check the category. Scan results mark such services "loads without consent". |
| A service loads twice | **Loading** is *The banner loads it after consent* and its code is still in the page layout or a template | Remove the code, or set **Loading** to *The page loads it, the banner blocks it until consent*. |
| A service never loads, even after consent | *The banner loads it* without a valid ID ("ID missing" in the list) | Enter the ID in the form the help text shows. |
| "This ID does not have the form the service uses, e.g. …" | The ID was copied with a typo or from another product | Copy the ID from the account with the provider. |
| "Please enter the address of your own server with https://." | Matomo with *The banner loads it* needs the address of the Matomo server | Enter it with `https://`. |
| After consent a web font is missing, or a Google Fonts address loads only its first font | Before 1.0.0 the banner encoded the address of a held-back stylesheet twice (`&amp;` became `&amp;amp;`), so everything after the first `&` was lost | Update the extension; the address is now kept as the page has it. |
| A video shows a placeholder although the category is allowed | The visitor allowed the service in another browser, or the choice belongs to an older version | Intended: the choice is stored per browser and version. |
| After withdrawing, the page reloads | Intended: cookies of the category are deleted and the page is reloaded without the services | – |
| Google tags report no consent | **Google Consent Mode v2** is off, or no Google template is among the services (the field is then greyed out) | Switch it on; list the Google services from their templates. |
| Script and stylesheet are missing on a page without page layout | They come as separate files from `bundles/neocookieconsent/` | Run `assets:install` if the folder is missing. |

## Scan

| What you see | Why | What to do |
| --- | --- | --- |
| "Could not be read: …" with an address and a status | The server cannot open its own pages under their public address (firewall, basic authentication, DNS inside the server) | Make the pages reachable from the server, or check the services by hand. |
| The scan reads `localhost` | The cron runs on the command line without the address of the website, and the root page has no **Domain name** | Set the address ([Setup](setup.md#scan-on-the-command-line)). |
| The scan finds no service on protected pages | The scan reads only published, unprotected pages within their **Show from** and **Show until** | Check those pages by hand. |
| No e-mail after the scan | Nothing new was found; or no address under **Report to** and no administrator e-mail address; or the mailer of Contao is not set up | Check the address and the mailer; see the log file. |
| A service added by the scan has no ID | The scan found the service but not its ID | Enter the ID if the banner should load the service. |
| An address keeps coming back as unknown | It is not decided yet | **Add as service**, or set the status to **ignored**. |

## Back end

| What you see | Why | What to do |
| --- | --- | --- |
| No menu entry **Cookie consent** | The user lacks the back-end module | Grant **Back end modules** → **Cookie consent**. |
| Contao refuses to open a form or a list | No allowed field of the table, or (Contao 5.7 and later) no table permission | Grant the fields and table permissions ([Permissions](permissions.md)). |
| No field **Own code** | Only administrators see it | Intended; use **Addresses**, or ask an administrator. |
| No field **Loading** with a template | The extension cannot load this service itself; the page loads it | Intended. |
| No section **Languages** in a service | The installation has only one language | Intended. |
| **Google Consent Mode v2** or **Keep for** is greyed out | No Google service is listed, or **Store consents** is off | Intended; the reason is at the field. |
