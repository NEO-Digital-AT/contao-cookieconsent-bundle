---
title: Privacy
summary: What NEO Cookie Consent stores in the browser and in the database, for how long, what the scan reads, which data leaves the website, and what belongs in the privacy policy.
audience: operations
language: en
updated: 2026-11-12
---

# Privacy

The extension itself sends nothing to other providers. Services of other
providers load only after consent; until then their scripts and embedded
content are held back.

## What is stored

| What | Where | How long |
| --- | --- | --- |
| The choice of the visitor: version, categories, services allowed one by one, a random consent ID, time of the choice | the visitor's browser (`localStorage`, key `ncc-consent`); no cookie | until the visitor deletes it; a new version asks again and replaces it |
| Proof of consent: random consent ID, time, version, website, action, allowed categories and services; no IP address, no browser details | database of the website (table `tl_neo_cookieconsent_log`) | as set under **Keep for** (1, 2, 3 or 5 years; preset 3 years), then deleted by the daily cron; nothing stored while **Store consents** is off |
| Services, settings and texts | database of the website | until changed; Contao keeps earlier versions in its version history |
| Scan results: services and addresses found, the page they were found on, first and last time | database of the website (table `tl_neo_cookieconsent_finding`) | until deleted in **Scan results** |

The consent ID is created in the browser and does not identify a person. A
visitor can name it to prove the choice; it is shown in the cookie settings
and with `{{cookie_consent::id}}`.

## What leaves the browser and the server

- **Proof of consent.** The browser sends every choice to the website itself
  (address `/api/cookieconsent/log`), same origin only. To limit this address
  to 30 requests per minute, the server uses a hash of the IP address for one
  minute; the IP address is not stored.
- **Scan.** The scan opens the website's own pages from the server, as a
  visitor would. It does not open other websites. Its e-mail goes to the
  address under **Report to** (or the administrator address) and names the
  services and addresses found.
- **After consent.** Only then do the services of other providers load, with
  the data each of them collects. The placeholders of embedded content say so
  ("Loading it sends data such as your IP address to …").

## Privacy policy

Put the cookie list (`{{cookie_consent::table}}` or the content element
**Cookie list**) into the privacy policy. It names every active service with
provider, purpose, cookies with storage period and transfer to a third country,
and lists the visitor's choice itself under *Necessary*. In addition, the
privacy policy should describe:

- that the website asks for consent before services of other providers load,
  and stores the choice in the browser;
- the proof of consent: which data, for how long (the value of **Keep for**),
  without IP address;
- how visitors change or withdraw their consent (button to reopen, link
  `{{cookie_consent::settings}}`).

Check the list after every change of the services. The extension is a tool;
whether the website meets the legal requirements is the responsibility of its
operator.
