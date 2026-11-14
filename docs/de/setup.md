---
titel: Einrichtung
kurzfassung: NEO Cookie Consent in der Reihenfolge einrichten, in der man es braucht – Einstellungen, erster Scan, Dienste, Cookie-Liste in der Datenschutzerklärung, Link in der Fußzeile, mehrere Websites und Sprachen, Scan auf der Kommandozeile.
zielgruppe: betrieb
sprache: de
stand: 2026-11-14
---

# Einrichtung

Das Modul **NEO Digital › Cookie-Hinweis** öffnet mit der Liste der Dienste.
Über der Liste stehen die Schaltflächen **Einstellungen**, **Texte**,
**Scan-Ergebnisse** und **Nachweis**. Der Hinweis braucht kein Modul im
Seitenlayout: Die Erweiterung fügt ihn in jede Seite des Frontends ein.

## 1. Einstellungen

Auf **Einstellungen** klicken. Das Formular öffnet sich direkt; es gibt einen
Datensatz mit Einstellungen für die ganze Installation.

### Lizenz

Der Kasten **Lizenz** oben nennt die Bedingung der kostenlosen Lizenz: Im
Impressum jeder Website, auf der die Erweiterung öffentlich läuft, wird sie mit
einem Link genannt. Der Kasten enthält den Hinweis als Text mit Link
(„Cookie-Hinweis: NEO Cookie Consent von NEO Digital“) und als HTML zum
Kopieren in den Quelltext des Impressums; der Link trägt `rel="nofollow"`. Die
vollständigen Bedingungen stehen in der Datei `LICENSE` des Pakets.

### Hinweis

| Feld | Vorgabe | Bedeutung |
| --- | --- | --- |
| **Hinweis zeigen** | an | Zeigt den Hinweis auf allen Seiten und blockiert Dienste bis zur Einwilligung. Aus: Nichts wird angezeigt und nichts blockiert; alle übrigen Felder von Hinweis, Blockieren und Nachweis sind ausgegraut, mit dem Grund am Feld. |
| **Erscheint** | Sofort beim Laden der Seite | Oder: Erst nach dem ersten Scrollen, Klick, Bewegen der Maus oder Tabulator. Besucher sehen dann zuerst die Seite. |
| **Lage** | Zeile unten | Zeile oben, Mitte des Bildschirms, Seitenleiste links, Seitenleiste rechts |
| **Hintergrund abdunkeln** | aus | Eine halbdurchsichtige Fläche über der Seite, solange der Hinweis offen ist. Die Seite ist dann erst nach der Wahl bedienbar (der Hinweis ist modal). |
| **Knopf zum Wiederöffnen** | Unten links | Unten rechts oder Kein Knopf. Ohne Knopf braucht die Website einen Link, z. B. `{{cookie_consent::settings}}` in der Fußzeile (Schritt 5). Knöpfe anderer Erweiterungen in derselben Ecke werden mit ihm so angeordnet, wie es im Seitenlayout eingestellt ist ([Bedienungsanleitung](usage.md#zusammen-mit-anderen-knöpfen-in-derselben-ecke)). |
| **Datenschutzerklärung** | – | Die Seite, die der Hinweis verlinkt. Solange keine gewählt ist, zeigt die Liste der Dienste einen Hinweis. |
| **Impressum** | – | Die Seite, die der Hinweis verlinkt. |

### Blockieren

| Feld | Vorgabe | Bedeutung |
| --- | --- | --- |
| **Skripte blockieren** | an | Skripte und Stylesheets von Webschriften bekannter Dienste in den Seiten laufen erst nach der Einwilligung. |
| **Eingebettete Inhalte blockieren** | an | Videos, Karten und Beiträge bekannter Dienste zeigen bis zur Einwilligung einen Platzhalter mit „Inhalt laden“. |
| **Google Consent Mode v2** | an | Meldet die Wahl an Google-Dienste (Basic-Variante: Vor der Einwilligung lädt kein Google-Dienst). Ausgegraut, bis eine der Google-Vorlagen (Google Analytics 4, Google Tag Manager, Google Ads, Google AdSense) unter den aktiven Diensten steht. |

„Bekannte Dienste“ sind die 47 Vorlagen des Katalogs und eigene Dienste mit
**Adressen** (siehe
[Bedienungsanleitung](usage.md#eigener-dienst-ohne-vorlage)).

### Nachweis der Einwilligung

| Feld | Vorgabe | Bedeutung |
| --- | --- | --- |
| **Einwilligungen speichern** | an | Speichert je Wahl einen Eintrag: zufällige Einwilligungs-ID, Zeit, Version und Auswahl, ohne IP-Adresse. |
| **Aufbewahren** | 3 Jahre | 1, 2, 3 oder 5 Jahre. Ältere Einträge löscht der tägliche Cron. |

### Scan

| Feld | Vorgabe | Bedeutung |
| --- | --- | --- |
| **Täglich prüfen** | an | Der tägliche Cron liest die veröffentlichten Seiten, ergänzt gefundene Dienste aus dem Katalog und meldet unbekannte Adressen. |
| **Seiten je Prüfung** | 25 | 10, 25, 50 oder 100 Seiten. Zuerst die erste Seite jeder Website, dann die zuletzt geänderten Seiten. |
| **Meldung an** | leer | E-Mail-Adresse für Meldungen über neue Dienste. Leer: die Administrator-E-Mail-Adresse der Systemeinstellungen (als Platzhalter angezeigt). |

Unter den Feldern des Scans zeigt eine Zeile die letzte Prüfung („Zuletzt
geprüft am …: … Seiten gelesen, … Dienste und Adressen gefunden, … neu
ergänzt.“), dazu die Schaltfläche **Jetzt prüfen** und den Link
**Scan-Ergebnisse ansehen**.

### Version

Eine Zeile zeigt die aktuelle Version der Einwilligung („Version 3, zuletzt
geändert am …“). Die Version steigt von selbst, wenn ein Besucher über die
Dienste etwas anderes lesen würde; dann werden alle Besucher neu gefragt (siehe
[Bedienungsanleitung](usage.md#wann-besucher-neu-gefragt-werden)).

Die Einstellungen speichern.

## 2. Erster Scan

1. In den Einstellungen auf **Jetzt prüfen** klicken. Die Erweiterung
   speichert das Formular und liest die Seiten.
2. Die Bestätigung nennt die Zahl der Seiten und Funde, z. B. „25 Seiten
   gelesen, 4 Dienste und Adressen gefunden.“ Ergänzte Dienste werden genannt:
   „Neu im Hinweis, bis zur Einwilligung blockiert: …“. Unbekannte Adressen
   ebenso.
3. Die Liste der Dienste öffnen und jeden ergänzten Dienst prüfen: Kategorie,
   Kennung und, bei Diensten, die der Hinweis selbst laden soll, **Laden**
   (siehe [Bedienungsanleitung](usage.md#dienste)).
4. **Scan-Ergebnisse** öffnen und über jede unbekannte Adresse entscheiden
   (siehe [Bedienungsanleitung](usage.md#scan-ergebnisse)).

Der Scan öffnet die Seiten vom Server aus unter ihrer öffentlichen Adresse.
Seiten, die er nicht lesen konnte, werden genannt: „Nicht lesbar: …“.

## 3. Übrige Dienste ergänzen

Jeden Dienst ergänzen, den die Website nutzt und den der Scan nicht gefunden
hat, z. B. einen Dienst, der erst nach einem Klick lädt. Dafür **Neuer Dienst**
und, wo es eine gibt, eine Vorlage nutzen; siehe
[Bedienungsanleitung](usage.md#dienst-aus-einer-vorlage-anlegen).

## 4. Cookie-Liste in der Datenschutzerklärung

Die Datenschutzerklärung nennt jeden Dienst mit Anbieter, Zweck, Cookies und
Drittland. Zwei Wege, dieselbe Ausgabe:

- das Insert-Tag `{{cookie_consent::table}}` in einem Text der
  Datenschutzerklärung;
- das Inhaltselement **Cookie-Liste** (Gruppe *NEO Digital*) im Artikel der
  Datenschutzerklärung.

Beide zeigen je Kategorie eine Tabelle mit Dienst, Anbieter, Zweck, Cookies
samt Speicherdauer, Drittland und dem Link zur Datenschutzerklärung des
Anbieters, in der Sprache der Seite, darunter einen Link, der die
Cookie-Einstellungen öffnet. Die Tabellen zeigen immer, was der Hinweis zeigt.
Nach jeder Änderung der Dienste prüfen.

## 5. Link in der Fußzeile

| Insert-Tag | Ausgabe |
| --- | --- |
| `{{cookie_consent::settings}}` | Ein Link, der die Cookie-Einstellungen öffnet, beschriftet mit dem Text **Cookie-Einstellungen** der Sprache |
| `{{cookie_consent::settings::Eigene Beschriftung}}` | Derselbe Link mit eigener Beschriftung |
| `{{cookie_consent::id}}` | Die Einwilligungs-ID des Besuchers (setzt der Browser ein) |

Den Link in die Fußzeile setzen, wenn **Knopf zum Wiederöffnen** auf *Kein
Knopf* steht.

## 6. Prüfen

Die Website in einem privaten Browserfenster öffnen. Der Hinweis erscheint mit
den Kategorien, die Dienste haben. Auf **Einstellungen** klicken: Jede
Kategorie zeigt ihre Dienste. **Nur notwendige** wählen und mit den
Entwicklerwerkzeugen des Browsers prüfen, dass kein Skript eines Statistik-
oder Marketingdienstes geladen wurde.

## Mehrere Websites und Sprachen

- **Dienste je Website.** Jeder Dienst hat das Feld **Websites** (Abschnitt
  *Adressen und Websites*): keine Auswahl heißt alle Websites der
  Installation. Hat die Installation mehr als einen Startpunkt, setzt der Scan
  die Websites, auf denen er einen Dienst gefunden hat.
- **Texte je Sprache.** Jede Website bekommt die Texte in der Sprache ihres
  Startpunkts. Für eigene Texte unter **Texte** je Sprache einen Datensatz
  anlegen (siehe [Bedienungsanleitung](usage.md#texte-je-sprache)). Ein
  Sprachdatensatz kann auch eigene Seiten für Datenschutzerklärung und
  Impressum setzen; leer heißt die Seiten aus den Einstellungen, und zwar in
  der Sprache der Seite: Sind die Seiten der Sprachen verknüpft
  (terminal42/contao-changelanguage, *Hauptsprachseite*), verlinkt der Hinweis
  von selbst die verknüpfte Seite der Website, auf der der Besucher ist.
- **Messung über eigene Domains.** Google Analytics 4 und Google Ads haben das
  Feld **Domains für domainübergreifende Messung** (eine Domain je Zeile,
  z. B. `app.example.com`). Links auf diese Domains nehmen die Messung mit,
  ein Besuch über mehrere davon zählt als einer. Nur Domainnamen sind erlaubt.
- **Name und Zweck je Sprache.** Hat die Installation mehr als eine Sprache,
  zeigt das Formular eines Dienstes den Abschnitt **Sprachen** mit Name und
  Zweck je Sprache.
- Die Einstellungen (Hinweis, Blockieren, Nachweis, Scan) gelten für alle
  Websites.

## Scan auf der Kommandozeile

Der Scan läuft mit dem täglichen Cron von Contao. Läuft der Cron auf der
Kommandozeile (`contao:cron`), kennt Symfony die Adresse der Website nicht, und
die Links, die der Scan liest, zeigen auf `localhost`. Die Adresse in
`config/config.yaml` setzen:

```yaml
parameters:
    router.request_context.host: 'www.example.com'
    router.request_context.scheme: 'https'
```

Startpunkte mit **Domainname** werden ohnehin unter dieser Domain geöffnet.
