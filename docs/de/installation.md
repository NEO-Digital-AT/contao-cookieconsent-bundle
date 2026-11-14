---
titel: Installation
kurzfassung: Voraussetzungen, Installation von NEO Cookie Consent mit dem Contao Manager oder Composer, öffentliche Dateien, Backend-Sprachen, Aktualisieren und Entfernen.
zielgruppe: betrieb
sprache: de
stand: 2026-11-12
---

# Installation

## Voraussetzungen

| Was | Wofür |
| --- | --- |
| Contao 5.3 bis 6.0 (`contao/core-bundle ^5.3 \|\| ^6.0`) | alles |
| PHP 8.2 bis 8.5, soweit die Contao-Fassung sie unterstützt (Contao 5.7 braucht 8.3, Contao 6.0 braucht 8.4), mit `ctype` und `mbstring` | alles |
| `neo-digital/contao-basic-bundle` | wird automatisch mitinstalliert; es stellt die Menügruppe im Backend. Die Erweiterung braucht von dort weder Lizenz- noch Zugangsschlüssel. |
| Der Contao-Cron (Web-Cron oder der Befehl `contao:cron`) | der tägliche Scan und das Löschen alter Einträge des Nachweises |
| Ein funktionierender Mailversand von Contao und eine Administrator-E-Mail-Adresse in den Systemeinstellungen | die E-Mail des Scans |
| Der Server kann die Seiten der Website unter ihrer öffentlichen Adresse öffnen | der Scan |

## Installation mit dem Contao Manager

1. Den Contao Manager öffnen.
2. Nach `neo-digital/contao-cookieconsent-bundle` suchen.
3. Auf **Hinzufügen** und danach auf **Änderungen anwenden** klicken.
4. Wenn der Contao Manager fragt, die Datenbank aktualisieren und alle
   vorgeschlagenen Änderungen ausführen.

## Installation mit Composer

```bash
composer require neo-digital/contao-cookieconsent-bundle
php vendor/bin/contao-console contao:migrate
```

`contao:migrate` legt die Tabellen der Erweiterung an. Composer kopiert Skript
und Stylesheet des Hinweises nach `public/bundles/neocookieconsent/`; falls das
nicht geschehen ist:

```bash
php vendor/bin/contao-console assets:install
```

## Nach der Installation

Das Backend zeigt das Modul **NEO Digital › Cookie-Hinweis**. Der Hinweis ist
eingeschaltet, erscheint aber erst, wenn mindestens ein aktiver Dienst eine
Einwilligung braucht. Ein Modul im Seitenlayout ist nicht nötig. Weiter mit
[Einrichtung](setup.md).

## Backend-Sprachen

Backend, Hinweis, Platzhalter und Cookie-Liste gibt es auf Englisch, Deutsch,
Französisch, Niederländisch, Italienisch, Polnisch, Tschechisch, Ungarisch,
Slowenisch, Kroatisch und Spanisch. Seiten in anderen Sprachen bekommen
Englisch, außer es gibt eigene Texte für die Sprache (siehe
[Bedienungsanleitung](usage.md#texte-je-sprache)). Ungarisch und Kroatisch
bietet Contao als Backend-Sprache erst an, wenn sie in `config/config.yaml`
freigeschaltet sind:

```yaml
contao:
    intl:
        enabled_locales: ['+hu', '+hr']
```

## Aktualisieren

1. Das Paket mit dem Contao Manager aktualisieren oder mit
   `composer update neo-digital/contao-cookieconsent-bundle`.
2. Die Datenbank aktualisieren (`contao:migrate`).
3. `CHANGELOG.md` der neuen Fassung lesen. Braucht eine Fassung neue Rechte
   oder einen Schritt nach dem Aktualisieren, steht es dort.
4. Wer Templates der Erweiterung überschreibt, vergleicht sie mit den neuen
   Fassungen in `vendor/neo-digital/contao-cookieconsent-bundle/contao/templates/`.

## Entfernen

1. Die Insert-Tags `{{cookie_consent::…}}` und die Inhaltselemente
   *Cookie-Liste* aus der Website entfernen. Ohne die Erweiterung werden sie
   nicht mehr aufgelöst.
2. Das Paket mit dem Contao Manager entfernen oder mit
   `composer remove neo-digital/contao-cookieconsent-bundle`.
3. Die Datenbank aktualisieren. Contao bietet dann an, die Tabellen der
   Erweiterung zu löschen: Dienste, Einstellungen, Texte, Scan-Ergebnisse und
   den Nachweis der Einwilligungen. Muss der Nachweis aufbewahrt werden, vorher
   die Tabelle `tl_neo_cookieconsent_log` sichern; eine Ausfuhr hat die
   Erweiterung nicht.

Ohne die Erweiterung wird kein Dienst mehr zurückgehalten. Dienste, die eine
Einwilligung brauchen, vor dem Entfernen aus der Website nehmen oder den
Hinweis ersetzen.
