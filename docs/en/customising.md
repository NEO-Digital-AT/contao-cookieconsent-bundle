---
title: Customising
summary: Adapting the cookie banner of NEO Cookie Consent to the design of the website – CSS variables, templates, how script and stylesheet are loaded, the interface in the browser for developers.
audience: operations
language: en
updated: 2026-11-14
---

# Customising

The banner comes in a neutral design. It is adapted in the website, not in the
extension: with CSS variables, with overridden templates and with the texts in
the back end ([User manual](usage.md#texts-per-language)).

## CSS variables

Set the variables in a stylesheet of the website, e.g.:

```css
:root {
    --ncc-accent: #0b5cad;
    --ncc-radius: 4px;
}
```

The defaults sit on `:where(:root)` and have no specificity, so the values of
the website apply whatever the order of the stylesheets.

| Variable | Default | Use |
| --- | --- | --- |
| `--ncc-font`, `--ncc-font-size` | `inherit`, `15px` | font of the banner and placeholders |
| `--ncc-bg`, `--ncc-text`, `--ncc-muted`, `--ncc-line` | `#ffffff`, `#1f2328`, `#57606a`, `#d0d7de` | background, text, secondary text, lines |
| `--ncc-accent`, `--ncc-accent-text` | `#1f5fad`, `#ffffff` | buttons and links |
| `--ncc-ghost-bg`, `--ncc-ghost-text`, `--ncc-ghost-border` | `transparent`, `#1f2328`, `#8c959f` | buttons **Settings** and **Back** |
| `--ncc-switch-off`, `--ncc-switch-on`, `--ncc-focus` | `#8c959f`, `#1f5fad`, `#1f5fad` | switches, focus ring |
| `--ncc-radius`, `--ncc-radius-button`, `--ncc-shadow` | `8px`, `6px`, `0 8px 28px rgba(0, 0, 0, 0.18)` | shape |
| `--ncc-max-width`, `--ncc-center-width`, `--ncc-drawer-width`, `--ncc-drawer-radius` | `1100px`, `560px`, `420px`, `0` | width of the bars, of the dialog in the centre and of the side panels |
| `--ncc-offset`, `--ncc-z`, `--ncc-overlay` | `16px`, `2147483000`, `rgba(0, 0, 0, 0.45)` | distance from the edge, stacking order, dimmed background |
| `--ncc-table-line`, `--ncc-table-head-bg` | `#d0d7de`, `#f6f8fa` | lines and heading row of the cookie list |
| `--ncc-reopen-size`, `--ncc-reopen-bg`, `--ncc-reopen-text` | `44px`, `#ffffff`, `#1f2328` | button to reopen |
| `--ncc-embed-bg`, `--ncc-embed-text` | `#f6f8fa`, `#1f2328` | placeholders of embedded content |

The defaults meet WCAG 2.1 AA. Check the contrast of own colours: text at least
4.5:1, controls at least 3:1.

## Templates

Copy a template into the folder `templates/` of the website, keeping the path,
and change it there:

| Template | What it renders |
| --- | --- |
| `cookieconsent/banner.html.twig` | First and second layer, button to reopen |
| `cookieconsent/embed.html.twig` | Placeholder of embedded content |
| `cookieconsent/head.html.twig` | First script in the page head: the choice from the browser and, with Google services, the defaults of Google Consent Mode |
| `cookieconsent/table.html.twig` | Tables of the cookie list |
| `content_element/neo_cookieconsent_list.html.twig` | Content element *Cookie list* |

Keep every `data-ncc-*` attribute: the script finds the elements by them.
Keep the order of the buttons in the markup equal to the order on screen, so
that the keyboard order matches. After an update of the extension, compare
overridden templates with the new versions.

The button to reopen also carries the attributes of the buttons at the edge
of the screen of NEO Basic: `data-neo-dock="cookies"`, `data-neo-dock-launcher`,
`data-neo-dock-corner` (`bottom-left` or `bottom-right`), `data-neo-dock-order`
(`30`), `data-neo-dock-label` (the text **Button to reopen**) and
`data-neo-dock-icon` on its icon. Keep them in an overridden template: without
them the button keeps its own place and is not arranged with the buttons of
other extensions in its corner. Its distance from the edges adds
`--neo-dock-x` and `--neo-dock-y`, which NEO Basic sets in a stack; the look
of the settings button and its menu comes from the `--neo-dock-*` variables
of NEO Basic.

## How script and stylesheet are loaded

On pages with a page layout, `consent.js` and `consent.css` are handed to
Contao like the files of the layout. With **Combine scripts** in the layout
they become part of its combined script file and style file. Other pages get
them as separate files from `bundles/neocookieconsent/`.

Script and stylesheet are only added when the page needs them: when an active
service of the website needs consent, or when something on the page was
blocked.

## For developers: interface in the browser

A small script at the top of the page head sets up `window.cookieConsent`
before any other script runs. Scripts of other extensions can ask before the
page is complete.

```js
window.cookieConsent.allows('statistics');                 // true/false
window.cookieConsent.allowsService('youtube', 'functional'); // allowed one by one or by category
window.cookieConsent.open();                                // opens the settings
window.cookieConsent.categories;                            // what the banner asks for, e.g. ['functional', 'statistics']
window.addEventListener('cookie-consent:change', (e) => {
    // e.detail.cats: categories, e.detail.svc: services allowed one by one, e.detail.action
});
```

| Attribute | Effect |
| --- | --- |
| `data-ncc-open` | A click on the element opens the settings |
| `data-ncc-id` | The element shows the consent ID of the visitor |
| `data-ncc-ignore` | On a `script`, `link` or `iframe`: never blocked |

The categories are `necessary`, `functional`, `statistics` and `marketing`.
The service keys are the keys of the templates (e.g. `ga4`, `youtube`).
`categories` names only the categories that have a service: a script that
needs another category can tell that the visitor will never be asked for it,
and say so instead of waiting (the AI chat assistant of the same family does
this).

A back-end link of another extension can have a service of the catalogue
added: `contao?do=neo_cookieconsent&key=add_service&template=<key>&category=<category>&rt=<request token>`
adds it, active, and opens it; a template that is listed already is opened
instead. Without a valid request token nothing is added.
