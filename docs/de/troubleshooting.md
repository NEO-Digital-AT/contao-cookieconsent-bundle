---
titel: Fehlersuche
kurzfassung: Häufige Probleme mit NEO Cookie Consent – Hinweis fehlt, Dienste nicht blockiert oder doppelt geladen, Fehler im Scan, fehlende Rechte – mit Ursache und Lösung.
zielgruppe: betrieb
sprache: de
stand: 2026-11-14
---

# Fehlersuche

Hinweise über der Liste der Dienste nennen die häufigsten Lücken. Ein
fehlgeschlagener täglicher Scan steht in der Protokolldatei der Installation
(`var/logs/`) als „Cookie consent scan failed: …“; eine E-Mail, die nicht
versendet werden konnte, als „Cookie consent scan: the mail could not be sent:
…“. Fehlende Menüeinträge oder Felder sind fast immer fehlende Rechte; siehe
[Rechte](permissions.md).

## Hinweis

| Was man sieht | Warum | Was zu tun ist |
| --- | --- | --- |
| Der Hinweis erscheint nicht | **Hinweis zeigen** ist aus („Der Cookie-Hinweis ist ausgeschaltet.“); oder kein aktiver Dienst dieser Website hat eine andere Kategorie als *Notwendig* | In den **Einstellungen** einschalten; Dienste anlegen oder aktivieren. |
| Der Hinweis erscheint erst nach dem Scrollen | **Erscheint** steht auf *Erst nach dem ersten Scrollen, Klick, Bewegen der Maus oder Tabulator* | So vorgesehen; sonst *Sofort beim Laden der Seite* wählen. |
| Der Hinweis erscheint nach jeder Änderung neu | Ein Dienst kam hinzu, wurde entfernt oder in dem geändert, was Besucher lesen; die Version ist gestiegen | So vorgesehen ([Bedienungsanleitung](usage.md#wann-besucher-neu-gefragt-werden)). |
| Nach einer Änderung der Cookies erscheint der Hinweis nicht neu | Cookies und Datenschutz-Link gehören nicht zur Version | So vorgesehen. |
| Besucher können die Einstellungen nicht wieder öffnen | **Knopf zum Wiederöffnen** steht auf *Kein Knopf*, und es gibt keinen Link | `{{cookie_consent::settings}}` in die Fußzeile setzen. |
| Der Knopf zum Wiederöffnen fehlt, in seiner Ecke sitzt ein Zahnrad | Knöpfe anderer Erweiterungen teilen sich die Ecke; das Seitenlayout ordnet sie als *Eine Einstellungs-Schaltfläche mit Menü* an | Gewollt; **Cookie-Einstellungen** im Menü öffnet die Einstellungen. Eine andere Anordnung im Seitenlayout (**Schaltflächen am Bildschirmrand**) einstellen, eine andere Ecke hier. |
| Der Knopf zum Wiederöffnen liegt über einem anderen Knopf | Beide sitzen in einer Ecke, und einem überschriebenen Template fehlen die `data-neo-dock`-Attribute, oder NEO Basic ist älter als die Schaltflächen am Bildschirmrand | Die Attribute übernehmen ([Anpassen](customising.md#templates)); NEO Basic aktualisieren. |
| Keine Links zu Datenschutzerklärung oder Impressum im Hinweis | Keine Seite in den **Einstellungen** (oder im Textdatensatz der Sprache) gewählt | Die Seiten wählen. |
| Der Hinweis ist auf einer Seite in einer anderen Sprache englisch | Für diese Sprache gibt es keine mitgelieferten Texte und keinen eigenen Textdatensatz | Unter **Texte** einen Datensatz für die Sprache anlegen. |
| Knöpfe des Hinweises tun nichts, seit ein Template überschrieben wurde | Dem eigenen Template fehlen `data-ncc-*`-Attribute | Mit dem Template der Erweiterung vergleichen ([Anpassen](customising.md#templates)). |
| Eine Kategorie fehlt in den Einstellungen | Sie hat auf dieser Website keinen aktiven Dienst | So vorgesehen. |
| Ein KI-Chat sagt, er sei nicht verfügbar, oder sein Einwilligungs-Knopf tut nichts | Kein aktiver Dienst in der Einwilligungs-Kategorie des Chats, also fragt der Hinweis nie danach | Den Dienst *KI-Chat-Assistent* in dieser Kategorie anlegen; der Link an **Einwilligungs-Kategorie** im Formular des Assistenten erledigt das. |

## Blockieren und Laden

| Was man sieht | Warum | Was zu tun ist |
| --- | --- | --- |
| Ein Dienst lädt vor der Einwilligung | **Skripte blockieren** oder **Eingebettete Inhalte blockieren** ist aus; oder der Dienst steht nicht im Katalog und hat keinen eigenen Dienst mit **Adressen**; oder er trägt `data-ncc-ignore`; oder er steht unter *Notwendig* | Blockieren einschalten; einen eigenen Dienst mit der Domain unter **Adressen** anlegen; die Kategorie prüfen. Die Scan-Ergebnisse markieren solche Dienste mit „lädt ohne Einwilligung“. |
| Ein Dienst lädt doppelt | **Laden** steht auf *Der Hinweis lädt ihn nach der Einwilligung*, und sein Code steht noch im Seitenlayout oder einem Template | Den Code entfernen oder **Laden** auf *Die Seite lädt ihn, der Hinweis blockiert ihn bis zur Einwilligung* stellen. |
| Ein Dienst lädt nie, auch nach der Einwilligung nicht | *Der Hinweis lädt ihn* ohne gültige Kennung („Kennung fehlt“ in der Liste) | Die Kennung in der Form eintragen, die der Hilfetext zeigt. |
| „Diese Kennung hat nicht die Form des Dienstes, z. B. …“ | Die Kennung wurde mit Tippfehler oder aus einem anderen Produkt kopiert | Die Kennung aus dem Konto beim Anbieter kopieren. |
| „Bitte die Adresse des eigenen Servers mit https:// angeben.“ | Matomo mit *Der Hinweis lädt ihn* braucht die Adresse des Matomo-Servers | Mit `https://` eintragen. |
| Nach der Einwilligung fehlt eine Webschrift, oder eine Google-Fonts-Adresse lädt nur ihre erste Schrift | Vor 1.0.0 hat der Hinweis die Adresse eines zurückgehaltenen Stylesheets doppelt kodiert (aus `&amp;` wurde `&amp;amp;`), dadurch ging alles nach dem ersten `&` verloren | Die Erweiterung aktualisieren; die Adresse bleibt jetzt, wie die Seite sie hat. |
| Ein Video zeigt einen Platzhalter, obwohl die Kategorie erlaubt ist | Der Besucher hat den Dienst in einem anderen Browser erlaubt, oder die Wahl gehört zu einer älteren Version | So vorgesehen: Die Wahl gilt je Browser und Version. |
| Nach dem Widerruf lädt die Seite neu | So vorgesehen: Die Cookies der Kategorie werden gelöscht, die Seite lädt ohne die Dienste neu | – |
| Google-Tags melden keine Einwilligung | **Google Consent Mode v2** ist aus, oder keine Google-Vorlage steht unter den Diensten (das Feld ist dann ausgegraut) | Einschalten; die Google-Dienste aus ihren Vorlagen anlegen. |
| Skript und Stylesheet fehlen auf einer Seite ohne Seitenlayout | Sie kommen dort als eigene Dateien aus `bundles/neocookieconsent/` | `assets:install` ausführen, wenn der Ordner fehlt. |

## Scan

| Was man sieht | Warum | Was zu tun ist |
| --- | --- | --- |
| „Nicht lesbar: …“ mit Adresse und Status | Der Server kann seine eigenen Seiten unter ihrer öffentlichen Adresse nicht öffnen (Firewall, Passwortschutz des Webservers, Namensauflösung im Server) | Die Seiten vom Server aus erreichbar machen oder die Dienste von Hand prüfen. |
| Der Scan liest `localhost` | Der Cron läuft auf der Kommandozeile ohne die Adresse der Website, und der Startpunkt hat keinen **Domainnamen** | Die Adresse setzen ([Einrichtung](setup.md#scan-auf-der-kommandozeile)). |
| Der Scan findet auf geschützten Seiten keinen Dienst | Der Scan liest nur veröffentlichte, ungeschützte Seiten innerhalb von **Anzeigen ab** und **Anzeigen bis** | Diese Seiten von Hand prüfen. |
| Keine E-Mail nach dem Scan | Es wurde nichts Neues gefunden; oder keine Adresse unter **Meldung an** und keine Administrator-E-Mail-Adresse; oder der Mailversand von Contao ist nicht eingerichtet | Adresse und Mailversand prüfen; siehe Protokolldatei. |
| Ein vom Scan ergänzter Dienst hat keine Kennung | Der Scan hat den Dienst gefunden, aber nicht seine Kennung | Die Kennung eintragen, wenn der Hinweis den Dienst laden soll. |
| Eine Adresse kommt immer wieder als unbekannt | Sie ist noch nicht entschieden | **Als Dienst anlegen** oder den Status auf **ignoriert** setzen. |

## Backend

| Was man sieht | Warum | Was zu tun ist |
| --- | --- | --- |
| Kein Menüeintrag **Cookie-Hinweis** | Dem Benutzer fehlt das Backend-Modul | **Backend-Module** → **Cookie-Hinweis** erlauben. |
| Contao verweigert ein Formular oder eine Liste | Kein erlaubtes Feld der Tabelle, oder (ab Contao 5.7) kein Tabellenrecht | Felder und Tabellenrechte erlauben ([Rechte](permissions.md)). |
| Kein Feld **Eigener Code** | Nur Administratoren sehen es | So vorgesehen; **Adressen** nutzen oder einen Administrator fragen. |
| Kein Feld **Laden** bei einer Vorlage | Die Erweiterung kann diesen Dienst nicht selbst laden; die Seite lädt ihn | So vorgesehen. |
| Kein Abschnitt **Sprachen** bei einem Dienst | Die Installation hat nur eine Sprache | So vorgesehen. |
| **Google Consent Mode v2** oder **Aufbewahren** ist ausgegraut | Kein Google-Dienst ist eingetragen, oder **Einwilligungen speichern** ist aus | So vorgesehen; der Grund steht am Feld. |
