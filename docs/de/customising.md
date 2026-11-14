---
titel: Anpassen
kurzfassung: Den Cookie-Hinweis von NEO Cookie Consent an die Gestaltung der Website anpassen – CSS-Variablen, Templates, wie Skript und Stylesheet geladen werden, die Schnittstelle im Browser für Entwickler.
zielgruppe: betrieb
sprache: de
stand: 2026-11-14
---

# Anpassen

Der Hinweis kommt im neutralen Grunddesign. Angepasst wird in der Website,
nicht in der Erweiterung: mit CSS-Variablen, mit überschriebenen Templates und
mit den Texten im Backend ([Bedienungsanleitung](usage.md#texte-je-sprache)).

## CSS-Variablen

Die Variablen in einem Stylesheet der Website setzen, z. B.:

```css
:root {
    --ncc-accent: #0b5cad;
    --ncc-radius: 4px;
}
```

Die Vorgaben stehen auf `:where(:root)` und haben keine Spezifität; die Werte
der Website gelten also unabhängig von der Reihenfolge der Stylesheets.

| Variable | Vorgabe | Wofür |
| --- | --- | --- |
| `--ncc-font`, `--ncc-font-size` | `inherit`, `15px` | Schrift von Hinweis und Platzhaltern |
| `--ncc-bg`, `--ncc-text`, `--ncc-muted`, `--ncc-line` | `#ffffff`, `#1f2328`, `#57606a`, `#d0d7de` | Hintergrund, Text, Nebentext, Linien |
| `--ncc-accent`, `--ncc-accent-text` | `#1f5fad`, `#ffffff` | Knöpfe und Links |
| `--ncc-ghost-bg`, `--ncc-ghost-text`, `--ncc-ghost-border` | `transparent`, `#1f2328`, `#8c959f` | Knöpfe **Einstellungen** und **Zurück** |
| `--ncc-switch-off`, `--ncc-switch-on`, `--ncc-focus` | `#8c959f`, `#1f5fad`, `#1f5fad` | Schalter, Fokusrahmen |
| `--ncc-radius`, `--ncc-radius-button`, `--ncc-shadow` | `8px`, `6px`, `0 8px 28px rgba(0, 0, 0, 0.18)` | Form |
| `--ncc-max-width`, `--ncc-center-width`, `--ncc-drawer-width`, `--ncc-drawer-radius` | `1100px`, `560px`, `420px`, `0` | Breite der Zeilen, des Dialogs in der Mitte und der Seitenleisten |
| `--ncc-offset`, `--ncc-z`, `--ncc-overlay` | `16px`, `2147483000`, `rgba(0, 0, 0, 0.45)` | Abstand zum Rand, Stapelreihenfolge, abgedunkelter Hintergrund |
| `--ncc-table-line`, `--ncc-table-head-bg` | `#d0d7de`, `#f6f8fa` | Linien und Kopfzeile der Cookie-Liste |
| `--ncc-reopen-size`, `--ncc-reopen-bg`, `--ncc-reopen-text` | `44px`, `#ffffff`, `#1f2328` | Knopf zum Wiederöffnen |
| `--ncc-embed-bg`, `--ncc-embed-text` | `#f6f8fa`, `#1f2328` | Platzhalter eingebetteter Inhalte |

Die Vorgaben erfüllen WCAG 2.1 AA. Kontraste eigener Farben prüfen: Text
mindestens 4,5:1, Bedienelemente mindestens 3:1.

## Templates

Ein Template mit seinem Pfad in den Ordner `templates/` der Website kopieren und
dort ändern:

| Template | Was es ausgibt |
| --- | --- |
| `cookieconsent/banner.html.twig` | Erste und zweite Ebene, Knopf zum Wiederöffnen |
| `cookieconsent/embed.html.twig` | Platzhalter eingebetteter Inhalte |
| `cookieconsent/head.html.twig` | Erstes Skript im Seitenkopf: die Wahl aus dem Browser und, bei Google-Diensten, die Vorgaben des Google Consent Mode |
| `cookieconsent/table.html.twig` | Tabellen der Cookie-Liste |
| `content_element/neo_cookieconsent_list.html.twig` | Inhaltselement *Cookie-Liste* |

Jedes `data-ncc-*`-Attribut behalten: Das Skript findet die Elemente daran. Die
Reihenfolge der Knöpfe im Markup gleich der Reihenfolge am Bildschirm lassen,
damit die Tastaturreihenfolge passt. Nach einem Update der Erweiterung
überschriebene Templates mit den neuen Fassungen vergleichen.

Der Knopf zum Wiederöffnen trägt außerdem die Attribute der Schaltflächen am
Bildschirmrand von NEO Basic: `data-neo-dock="cookies"`, `data-neo-dock-launcher`,
`data-neo-dock-corner` (`bottom-left` oder `bottom-right`), `data-neo-dock-order`
(`30`), `data-neo-dock-label` (der Text **Knopf zum Wiederöffnen**) und
`data-neo-dock-icon` an seinem Symbol. In einem überschriebenen Template
behalten: Ohne sie behält der Knopf seinen eigenen Platz und wird nicht mit den
Knöpfen anderer Erweiterungen in seiner Ecke angeordnet. Sein Abstand zu den
Rändern addiert `--neo-dock-x` und `--neo-dock-y`, die NEO Basic in einem
Stapel setzt; das Aussehen der Einstellungs-Schaltfläche und ihres Menüs kommt
aus den `--neo-dock-*`-Variablen von NEO Basic.

## Wie Skript und Stylesheet geladen werden

Auf Seiten mit Seitenlayout gehen `consent.js` und `consent.css` wie die
Dateien des Layouts an Contao. Mit **Skripte zusammenfassen** im Layout werden
sie Teil seiner zusammengefassten Skript- und Stildatei. Andere Seiten
bekommen sie als eigene Dateien aus `bundles/neocookieconsent/`.

Skript und Stylesheet kommen nur dazu, wenn die Seite sie braucht: wenn ein
aktiver Dienst der Website eine Einwilligung braucht oder auf der Seite etwas
blockiert wurde.

## Für Entwickler: Schnittstelle im Browser

Ein kleines Skript ganz oben im Seitenkopf richtet `window.cookieConsent` ein,
bevor irgendein anderes Skript läuft. Skripte anderer Erweiterungen können
fragen, bevor die Seite fertig ist.

```js
window.cookieConsent.allows('statistics');                 // true/false
window.cookieConsent.allowsService('youtube', 'functional'); // einzeln oder über die Kategorie erlaubt
window.cookieConsent.open();                                // öffnet die Einstellungen
window.cookieConsent.categories;                            // was der Hinweis abfragt, z. B. ['functional', 'statistics']
window.addEventListener('cookie-consent:change', (e) => {
    // e.detail.cats: Kategorien, e.detail.svc: einzeln erlaubte Dienste, e.detail.action
});
```

| Attribut | Wirkung |
| --- | --- |
| `data-ncc-open` | Ein Klick auf das Element öffnet die Einstellungen |
| `data-ncc-id` | Das Element zeigt die Einwilligungs-ID des Besuchers |
| `data-ncc-ignore` | An einem `script`, `link` oder `iframe`: wird nie blockiert |

Die Kategorien heißen `necessary`, `functional`, `statistics` und
`marketing`. Die Schlüssel der Dienste sind die Schlüssel der Vorlagen (z. B.
`ga4`, `youtube`). `categories` nennt nur die Kategorien, in denen ein Dienst
steht: Ein Skript, das eine andere Kategorie braucht, erkennt daran, dass der
Besucher nie danach gefragt wird, und kann das sagen, statt zu warten (der
KI-Chat-Assistent derselben Reihe tut das).

Ein Link einer anderen Erweiterung im Backend kann einen Dienst aus dem
Katalog anlegen lassen:
`contao?do=neo_cookieconsent&key=add_service&template=<schlüssel>&category=<kategorie>&rt=<request-token>`
legt ihn aktiv an und öffnet ihn; ist die Vorlage schon angelegt, öffnet er
diese. Ohne gültiges Request-Token wird nichts angelegt.
