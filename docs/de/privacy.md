---
titel: Datenschutz
kurzfassung: Was NEO Cookie Consent im Browser und in der Datenbank speichert, wie lange, was der Scan liest, welche Daten die Website verlassen und was in die Datenschutzerklärung gehört.
zielgruppe: betrieb
sprache: de
stand: 2026-11-12
---

# Datenschutz

Die Erweiterung selbst sendet nichts an andere Anbieter. Dienste anderer
Anbieter laden erst nach der Einwilligung; bis dahin werden ihre Skripte und
eingebetteten Inhalte zurückgehalten.

## Was gespeichert wird

| Was | Wo | Wie lange |
| --- | --- | --- |
| Die Wahl des Besuchers: Version, Kategorien, einzeln erlaubte Dienste, eine zufällige Einwilligungs-ID, Zeitpunkt der Wahl | Browser des Besuchers (`localStorage`, Schlüssel `ncc-consent`); kein Cookie | bis der Besucher sie löscht; eine neue Version fragt neu und ersetzt sie |
| Nachweis der Einwilligung: zufällige Einwilligungs-ID, Zeit, Version, Website, Aktion, erlaubte Kategorien und Dienste; keine IP-Adresse, keine Browserdaten | Datenbank der Website (Tabelle `tl_neo_cookieconsent_log`) | wie unter **Aufbewahren** eingestellt (1, 2, 3 oder 5 Jahre; Vorgabe 3 Jahre), dann löscht der tägliche Cron sie; nichts gespeichert, solange **Einwilligungen speichern** aus ist |
| Dienste, Einstellungen und Texte | Datenbank der Website | bis zur Änderung; frühere Fassungen hält Contao in seinem Versionsverlauf |
| Scan-Ergebnisse: gefundene Dienste und Adressen, die Seite, auf der sie gefunden wurden, erstes und letztes Mal | Datenbank der Website (Tabelle `tl_neo_cookieconsent_finding`) | bis zum Löschen unter **Scan-Ergebnisse** |

Die Einwilligungs-ID entsteht im Browser und bestimmt keine Person. Ein
Besucher kann sie nennen, um seine Wahl nachzuweisen; sie steht in den
Cookie-Einstellungen und bei `{{cookie_consent::id}}`.

## Was Browser und Server verlässt

- **Nachweis.** Der Browser schickt jede Wahl an die Website selbst (Adresse
  `/api/cookieconsent/log`), nur von derselben Herkunft. Um diese Adresse auf
  30 Anfragen je Minute zu begrenzen, nutzt der Server für eine Minute einen
  Hash der IP-Adresse; die IP-Adresse wird nicht gespeichert.
- **Scan.** Der Scan öffnet die eigenen Seiten der Website vom Server aus, wie
  ein Besucher. Andere Websites öffnet er nicht. Seine E-Mail geht an die
  Adresse unter **Meldung an** (oder die Administrator-Adresse) und nennt die
  gefundenen Dienste und Adressen.
- **Nach der Einwilligung.** Erst dann laden die Dienste anderer Anbieter, mit
  den Daten, die jeder von ihnen erhebt. Die Platzhalter eingebetteter Inhalte
  sagen das („Beim Laden werden Daten wie Ihre IP-Adresse an … übermittelt.“).

## Datenschutzerklärung

Die Cookie-Liste (`{{cookie_consent::table}}` oder das Inhaltselement
**Cookie-Liste**) in die Datenschutzerklärung setzen. Sie nennt jeden aktiven
Dienst mit Anbieter, Zweck, Cookies samt Speicherdauer und Übermittlung in ein
Drittland und führt die Wahl des Besuchers selbst unter *Notwendig*. Dazu
sollte die Datenschutzerklärung beschreiben:

- dass die Website vor dem Laden von Diensten anderer Anbieter um Einwilligung
  bittet und die Wahl im Browser speichert;
- den Nachweis der Einwilligung: welche Daten, wie lange (der Wert unter
  **Aufbewahren**), ohne IP-Adresse;
- wie Besucher ihre Einwilligung ändern oder widerrufen (Knopf zum
  Wiederöffnen, Link `{{cookie_consent::settings}}`).

Die Liste nach jeder Änderung der Dienste prüfen. Die Erweiterung ist ein
Hilfsmittel; ob die Website die rechtlichen Vorgaben erfüllt, verantwortet ihr
Betreiber.
