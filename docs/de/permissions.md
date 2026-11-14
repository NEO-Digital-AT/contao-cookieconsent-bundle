---
titel: Rechte
kurzfassung: Welche Contao-Rechte eine Benutzergruppe für Dienste, Einstellungen, Texte, Scan-Ergebnisse, Nachweis und das Inhaltselement von NEO Cookie Consent braucht.
zielgruppe: betrieb
sprache: de
stand: 2026-11-12
---

# Rechte

Administratoren können alles ohne weitere Einstellung. Für andere Benutzer
werden alle Rechte im Backend unter **Benutzergruppen** (oder **Benutzer**)
gesetzt, mit den Bezeichnungen, die Contao dort zeigt. Die Erweiterung hat
keine eigenen Schalter.

## Je Funktion

Alle Teile der Erweiterung sind ein Backend-Modul, **Cookie-Hinweis**, mit fünf
Tabellen.

| Funktion | Contao-Recht | Einstellung |
| --- | --- | --- |
| Modul öffnen (Liste der Dienste, Schaltflächen darüber) | **Backend-Module** | *NEO Digital*: **Cookie-Hinweis** |
| Dienste anlegen, ändern, schalten, kopieren und löschen | **Erlaubte Felder**, Tabelle `tl_neo_cookieconsent_service` | die Felder unten |
| | **Tabellenrechte** (ab Contao 5.7), `tl_neo_cookieconsent_service` | Anlegen, Bearbeiten, Löschen nach Bedarf |
| Einstellungen ändern, **Jetzt prüfen** in den Einstellungen | **Erlaubte Felder**, Tabelle `tl_neo_cookieconsent_settings` | die Felder unten |
| | **Tabellenrechte** (ab Contao 5.7), `tl_neo_cookieconsent_settings` | Bearbeiten |
| Texte je Sprache | **Erlaubte Felder**, Tabelle `tl_neo_cookieconsent_text` | alle Felder |
| | **Tabellenrechte** (ab Contao 5.7), `tl_neo_cookieconsent_text` | Anlegen, Bearbeiten, Löschen nach Bedarf |
| Scan-Ergebnisse: Status ändern, löschen | **Erlaubte Felder**, Tabelle `tl_neo_cookieconsent_finding` | Status `[status]` |
| | **Tabellenrechte** (ab Contao 5.7), `tl_neo_cookieconsent_finding` | Bearbeiten, Löschen |
| Scan-Ergebnisse: **Jetzt prüfen**, **Als Dienst anlegen** | **Backend-Module** | **Cookie-Hinweis** (kein weiteres Recht) |
| Nachweis: Liste und Details | **Backend-Module** | **Cookie-Hinweis** (die Einträge lassen sich nicht ändern) |
| Inhaltselement **Cookie-Liste** | **Inhaltselemente** | **Cookie-Liste** |
| | Contaos Rechte für Artikel und Inhaltselemente | wie bei jedem Inhaltselement |
| Insert-Tags `{{cookie_consent::…}}` | — | keine; sie wirken in jedem Text |
| **Eigener Code** eines Dienstes | — | **nur Administratoren**; allen anderen fehlt das Feld |

Ohne **Eigenen Code** legen Redakteure eigene Dienste mit **Adressen** an (die
Seite lädt sie, der Hinweis blockiert sie).

Wie bei Contaos eigenen Rechten bekommt ein Benutzer die Rechte des Benutzers,
die der Gruppen oder beide, je nach **Rechtevererbung**.

## Die Felder

Unter **Erlaubte Felder** führt Contao die Felder unter dem Tabellennamen,
jedes mit seiner Bezeichnung und dem Feldnamen in eckigen Klammern. Ein nicht
erlaubtes Feld fehlt im Formular.

| Tabelle | Felder |
| --- | --- |
| `tl_neo_cookieconsent_service` | Vorlage `[template]`, Name `[title]`, Kategorie `[category]`, Laden `[loading]`, Kennung `[tracking_id]`, Adresse des eigenen Servers `[tracking_url]`, Anbieter `[provider]`, Zweck `[purpose]`, Übermittlung in ein Drittland `[transfer]`, Datenschutzerklärung des Anbieters `[privacy_url]`, Cookies `[cookies]`, Adressen `[hosts]`, Websites `[roots]`, Aktiv `[published]` (auch für **Ein/aus** nötig) |
| `tl_neo_cookieconsent_settings` | Hinweis zeigen `[active]`, Erscheint `[show_on]`, Lage `[position]`, Hintergrund abdunkeln `[overlay]`, Knopf zum Wiederöffnen `[reopen]`, Datenschutzerklärung `[privacy_page]`, Impressum `[imprint_page]`, Skripte blockieren `[block_scripts]`, Eingebettete Inhalte blockieren `[block_embeds]`, Google Consent Mode v2 `[consent_mode]`, Einwilligungen speichern `[log]`, Aufbewahren `[log_days]`, Täglich prüfen `[scan]`, Seiten je Prüfung `[scan_limit]`, Meldung an `[scan_mail]` |
| `tl_neo_cookieconsent_text` | Sprache `[language]` und jedes Textfeld; Datenschutzerklärung dieser Sprache `[privacy_page]`, Impressum dieser Sprache `[imprint_page]` |
| `tl_neo_cookieconsent_finding` | Status `[status]` |

**Name** `[title]` und **Kategorie** `[category]` eines Dienstes und
**Sprache** `[language]` eines Textes sind Pflichtfelder: sie erlauben, sonst
lassen sich diese Formulare nicht speichern. Der Abschnitt **Sprachen** eines
Dienstes braucht kein Feldrecht.

## Beispielgruppe „Redaktion: Cookie-Hinweis“

Für Redakteure, die Dienste und Texte pflegen, ohne die Einstellungen:

1. **Backend-Module**: **Cookie-Hinweis**.
2. **Erlaubte Felder** → `tl_neo_cookieconsent_service`: alle Felder der
   Liste; `tl_neo_cookieconsent_text`: alle Felder;
   `tl_neo_cookieconsent_finding`: Status.
3. **Tabellenrechte** (ab Contao 5.7):
   `tl_neo_cookieconsent_service` → Anlegen, Bearbeiten, Löschen;
   `tl_neo_cookieconsent_text` → Anlegen, Bearbeiten;
   `tl_neo_cookieconsent_finding` → Bearbeiten.
4. Auf Wunsch **Inhaltselemente**: **Cookie-Liste**.
5. Speichern.

Ohne Felder von `tl_neo_cookieconsent_settings` und ohne deren Tabellenrecht
kann die Gruppe die Einstellungen nicht ändern. Dann mit einem Testbenutzer
anmelden, einen Dienst aus einer Vorlage anlegen und ihn aus- und wieder
einschalten.

## Mehrere Websites in einer Installation

Eine Trennung je Website gibt es nicht. Wer das Modul öffnen darf, sieht und
ändert Dienste, Texte und Einstellungen aller Websites und sieht den Nachweis
aller Websites. Dienste werden mit dem Feld **Websites** auf Websites
beschränkt.
