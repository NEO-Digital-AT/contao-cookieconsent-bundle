# Changelog

All notable changes to this extension are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/); versions follow
[Semantic Versioning](https://semver.org/).

## [1.0.0] - 2026-11-13

Initial release. Runs on Contao 5.3 to 6.0 with PHP 8.2 to 8.5, as far as the Contao version supports it (Contao 5.7 needs PHP 8.3, Contao 6.0 PHP 8.4).

### Added
- Services in the back end with templates for 47 common services (statistics, marketing, embedded content, fonts, chats, spam protection) and own services with own code or with the addresses to block.
- Two ways of loading: the banner loads a service after consent (only its ID is needed), or the page loads it and the banner holds it back (scripts, web fonts, iframes).
- Banner on every page without a module in the page layout: three equal buttons, a switch per category, placeholders with "Load content" for embedded content.
- Visitors are asked again when the services change; withdrawal deletes the cookies of the category.
- Google Consent Mode v2 (basic mode), proof of consent without IP address, cookie list for the privacy policy as insert tag or content element; links to the privacy policy and the legal notice in the language of the page.
- Bar at the bottom or the top, dialog in the centre or side panel, optionally modal; daily scan with a report by e-mail.
- Eleven languages, own texts per language, design through CSS variables, WCAG 2.1 AA in the default design; documentation in English and German; unit tests.
- The button to reopen takes part in the **buttons at the edge of the screen** of NEO Basic (`data-neo-dock` attributes): with buttons of other extensions in the same corner (accessibility panel, chat) it becomes an entry of one settings button with a menu, or is stacked with them, as set in the page layout. Websites that override `cookieconsent/banner.html.twig` take over the `data-neo-dock*` attributes of the button to reopen; without them the button keeps its own place. With a NEO Basic that does not have the buttons at the edge of the screen yet, nothing changes.

After installing: update the database, then add the services under **NEO Digital › Cookie consent**.
