# Documentation images

The images in `docs/<lang>/bilder/` are screenshots of the banner and of the
back end of a test installation, marked with the NEO annotation layer (frames
and numbers). `capture.cjs` takes them again, for example after a change to
the banner. This folder is not part of the Composer package
(`.gitattributes`: `export-ignore`).

## What the test installation needs

- Contao 5.7 with this bundle and Basic; one root page with a neutral start
  page.
- A few active services of different categories, for example *AI chat
  assistant* (Functional) and *Matomo* (Statistics), and the privacy policy
  and legal notice chosen in **Settings**, so that the banner shows its links.
- An administrator (`NCC_ADMIN_USER`).
- Node.js with Playwright and its Chromium, and the plugin `neo-doku` of
  `NEO-Claude-Plugins` (`annotate.js`) next to this repository, or its path
  in `NCC_ANNOTATE`.

## Taking the images

```bash
NCC_ADMIN_PASSWORD=… node tools/docs-images/capture.cjs en
NCC_ADMIN_PASSWORD=… node tools/docs-images/capture.cjs de
```

The script sets the back-end language of the administrator and the language
of the first root page to the language of the images and restores both at
the end. Each image of the front end is taken by a new visitor, without a
stored choice. Do not run two captures at the same time.

| Variable | Default | Meaning |
| --- | --- | --- |
| `NCC_BASE` | `http://127.0.0.1:8000` | Address of the test installation |
| `NCC_ADMIN_USER`, `NCC_ADMIN_PASSWORD` | `admin`, – | Administrator |
| `NCC_MYSQL` | `mysql contao` | Command for the database of the test installation |
| `NCC_ANNOTATE` | `../NEO-Claude-Plugins/plugins/neo-doku/scripts/annotate.js` | Annotation layer |

| Image | Shows |
| --- | --- |
| `banner.png` | The first layer: text with the categories and services (1), the three buttons (2), the links (3) |
| `settings-layer.png` | The second layer: switch of a category (1), its services (2), the buttons (3) |
| `services.png` | The services in the back end: *New* (1), *Settings* (2), *Texts* (3), *Scan results* (4), *Proof of consent* (5) |
| `settings-menu.png` | The settings button of the buttons at the edge of the screen (NEO Basic) with its menu: the settings button (1) and the entry *Cookie settings* (2). Not taken by `capture.cjs`: it needs a second button in the corner of the button to reopen (e.g. NEO Accessibility) and NEO Basic; taken on the test page of the dock test of NEO Basic (`tests/e2e/` there) |

Check every image after taking it: frames on the right element, no real
names, addresses or IDs.
