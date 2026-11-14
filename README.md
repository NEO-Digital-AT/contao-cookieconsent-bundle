# NEO Cookie Consent for Contao 5

A cookie banner for Contao 5 that asks visitors for consent before services of other providers run, and holds them back until then. Services are kept in the back end; templates for 47 common services fill in provider, purpose, cookies and the privacy link. A daily scan reads the pages, adds services it recognises and reports unknown addresses.

Free to use with a credit in the legal notice — see [License](#license).

*Deutsche Fassung weiter unten: [Deutsch](#neo-cookie-consent-für-contao-5-deutsch).*

## Features

- Services in the back end with templates for 47 common services (statistics, marketing, embedded content, fonts, chats, spam protection) and own services with own code or with the addresses to block.
- Two ways of loading: the banner loads a service after consent (only its ID is needed), or the page loads it and the banner holds it back (scripts, web fonts, iframes).
- Banner on every page without a module in the page layout: three equal buttons, a switch per category, placeholders with "Load content" for embedded content.
- Visitors are asked again on their own when the services change; withdrawal deletes the cookies of the category.
- Google Consent Mode v2 (basic mode), proof of consent without IP address, cookie list for the privacy policy as insert tag or content element.
- Bar at the bottom or the top, dialog in the centre or side panel, optionally modal.
- Daily scan with a report by e-mail.
- Eleven languages, own texts per language, design through CSS variables, WCAG 2.1 AA in the default design.
- The button to reopen shares its corner with the buttons of other extensions (accessibility, chat): one settings button with a menu, or stacked, as set in the page layout (buttons at the edge of the screen of NEO Basic).

## Requirements

- Contao 5.3 to 6.0 with PHP 8.2 to 8.5, as far as the Contao version supports it (Contao 5.7 needs PHP 8.3, Contao 6.0 PHP 8.4).
- `neo-digital/contao-basic-bundle`, installed automatically; the extension needs no key from it.
- The Contao cron and a working mailer for the daily scan.

## Installation

### Contao Manager

1. Search for `neo-digital/contao-cookieconsent-bundle`.
2. Click **Add** and then **Apply changes**.
3. Run the database update.

### Composer

```bash
composer require neo-digital/contao-cookieconsent-bundle
php vendor/bin/contao-console contao:migrate
```

Then open **NEO Digital › Cookie consent › Settings** in the back end: [Setup](docs/en/setup.md).

## Documentation

The full documentation comes with the extension: [docs/en/README.md](docs/en/README.md).

- [Installation](docs/en/installation.md) – requirements, updating, removing
- [Setup](docs/en/setup.md) – settings, first scan, cookie list, link in the footer, several websites
- [Permissions](docs/en/permissions.md) – what editors need
- [User manual](docs/en/usage.md) – services, scan results, texts, proof of consent, what visitors see
- [Customising](docs/en/customising.md) – CSS variables, templates, interface in the browser
- [Privacy](docs/en/privacy.md) – what is stored, what belongs in the privacy policy
- [Troubleshooting](docs/en/troubleshooting.md)

## Development

The unit tests (PHPUnit 10.5 or 11) cover the catalogue, the blocking, the banner and the cookie list, the proof of consent, the scan of a page, the back-end decisions and the migrations; the database is SQLite in memory with the tables of the DCA files.

```bash
composer install
composer test
```

The CI workflow `.github/workflows/tests.yml` runs the tests on PHP 8.2 to 8.5 (PHP 8.2 with Contao 5.3 and PHPUnit 10.5). To test against an existing Contao installation instead, point `NEO_TEST_AUTOLOAD` to its `vendor/autoload.php`.

## License

Free of charge on any number of websites, on the condition that the legal notice of every website on which the extension runs publicly names it with a link, as shown in the box **Licence** of the settings. Leaving out the credit needs a permission, given on request. The version available at the time of the order (for free use: of the download) for the then current Contao long-term support version works with it until its end of life; there is no entitlement to versions for later long-term support versions. Support by separate agreement. Full terms: [LICENSE](LICENSE). The extension is a tool; whether a website meets the legal requirements is the responsibility of its operator.

---

# NEO Cookie Consent für Contao 5 (Deutsch)

Ein Cookie-Hinweis für Contao 5, der Besucher um Einwilligung bittet, bevor Dienste anderer Anbieter laufen, und sie bis dahin zurückhält. Die Dienste werden im Backend gepflegt; Vorlagen für 47 gängige Dienste füllen Anbieter, Zweck, Cookies und Datenschutz-Link aus. Ein täglicher Scan liest die Seiten, ergänzt erkannte Dienste und meldet unbekannte Adressen.

Kostenlos mit Nennung im Impressum, siehe [Lizenz](#lizenz).

## Funktionen

- Dienste im Backend mit Vorlagen für 47 gängige Dienste (Statistik, Marketing, eingebettete Inhalte, Schriften, Chats, Spam-Schutz) und eigene Dienste mit eigenem Code oder mit den Adressen, die blockiert werden.
- Zwei Arten zu laden: Der Hinweis lädt einen Dienst nach der Einwilligung (nötig ist nur seine Kennung), oder die Seite lädt ihn und der Hinweis hält ihn zurück (Skripte, Webschriften, iframes).
- Hinweis auf jeder Seite ohne Modul im Seitenlayout: drei gleichwertige Knöpfe, ein Schalter je Kategorie, Platzhalter mit „Inhalt laden“ für eingebettete Inhalte.
- Besucher werden von selbst neu gefragt, wenn sich die Dienste ändern; ein Widerruf löscht die Cookies der Kategorie.
- Google Consent Mode v2 (Basic-Variante), Nachweis der Einwilligung ohne IP-Adresse, Cookie-Liste für die Datenschutzerklärung als Insert-Tag oder Inhaltselement.
- Zeile unten oder oben, Dialog in der Mitte oder Seitenleiste, auf Wunsch modal.
- Täglicher Scan mit Meldung per E-Mail.
- Elf Sprachen, eigene Texte je Sprache, Gestaltung über CSS-Variablen, WCAG 2.1 AA im Grunddesign.
- Der Knopf zum Wiederöffnen teilt sich seine Ecke mit den Knöpfen anderer Erweiterungen (Barrierefreiheit, Chat): eine Einstellungs-Schaltfläche mit Menü oder gestapelt, wie im Seitenlayout eingestellt (Schaltflächen am Bildschirmrand von NEO Basic).

## Voraussetzungen

- Contao 5.3 bis 6.0 mit PHP 8.2 bis 8.5, soweit die Contao-Fassung sie unterstützt (Contao 5.7 braucht PHP 8.3, Contao 6.0 PHP 8.4).
- `neo-digital/contao-basic-bundle`, wird automatisch mitinstalliert; die Erweiterung braucht von dort keinen Schlüssel.
- Der Contao-Cron und ein funktionierender Mailversand für den täglichen Scan.

## Installation

### Contao Manager

1. Nach `neo-digital/contao-cookieconsent-bundle` suchen.
2. Auf **Hinzufügen** und danach auf **Änderungen anwenden** klicken.
3. Die Datenbank aktualisieren.

### Composer

```bash
composer require neo-digital/contao-cookieconsent-bundle
php vendor/bin/contao-console contao:migrate
```

Danach im Backend **NEO Digital › Cookie-Hinweis › Einstellungen** öffnen: [Einrichtung](docs/de/setup.md).

## Dokumentation

Die vollständige Dokumentation liegt der Erweiterung bei: [docs/de/README.md](docs/de/README.md).

- [Installation](docs/de/installation.md) – Voraussetzungen, Aktualisieren, Entfernen
- [Einrichtung](docs/de/setup.md) – Einstellungen, erster Scan, Cookie-Liste, Link in der Fußzeile, mehrere Websites
- [Rechte](docs/de/permissions.md) – was Redakteure brauchen
- [Bedienungsanleitung](docs/de/usage.md) – Dienste, Scan-Ergebnisse, Texte, Nachweis, was Besucher sehen
- [Anpassen](docs/de/customising.md) – CSS-Variablen, Templates, Schnittstelle im Browser
- [Datenschutz](docs/de/privacy.md) – was gespeichert wird, was in die Datenschutzerklärung gehört
- [Fehlersuche](docs/de/troubleshooting.md)

## Entwicklung

Die Unit-Tests (PHPUnit 10.5 oder 11) prüfen den Katalog, das Blockieren, den Hinweis und die Cookie-Liste, den Nachweis der Einwilligung, den Scan einer Seite, die Entscheidungen im Backend und die Migrationen; die Datenbank ist SQLite im Arbeitsspeicher mit den Tabellen aus den DCA-Dateien.

```bash
composer install
composer test
```

Der CI-Ablauf `.github/workflows/tests.yml` führt die Tests unter PHP 8.2 bis 8.5 aus (PHP 8.2 mit Contao 5.3 und PHPUnit 10.5). Gegen eine bestehende Contao-Installation testen: `NEO_TEST_AUTOLOAD` auf deren `vendor/autoload.php` setzen.

## Lizenz

Kostenlos auf beliebig vielen Websites, unter der Bedingung, dass das Impressum jeder Website, auf der die Erweiterung öffentlich läuft, sie mit einem Link nennt, wie im Kasten **Lizenz** der Einstellungen gezeigt. Ohne Nennung nur mit einer Erlaubnis, die es auf Anfrage gibt. Die bei der Bestellung (bei unentgeltlicher Nutzung: beim Herunterladen) für die dann aktuelle Long-Term-Support-Version von Contao bereitstehende Fassung funktioniert mit dieser bis zu deren End of Life; ein Anspruch auf Fassungen für spätere Long-Term-Support-Versionen besteht nicht. Support nach gesonderter Vereinbarung. Vollständige Bedingungen: [LICENSE](LICENSE). Die Erweiterung ist ein Hilfsmittel; ob eine Website die rechtlichen Vorgaben erfüllt, verantwortet ihr Betreiber.
