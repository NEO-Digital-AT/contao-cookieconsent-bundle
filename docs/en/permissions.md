---
title: Permissions
summary: Which Contao permissions a user group needs for the services, settings, texts, scan results, proof of consent and the content element of NEO Cookie Consent.
audience: operations
language: en
updated: 2026-11-12
---

# Permissions

Administrators can do everything without any further setting. For other users,
all permissions are set in the back end under **User groups** (or **Users**),
with the names Contao shows there. The extension has no switches of its own.

## Per function

All parts of the extension are one back-end module, **Cookie consent**, with
five tables.

| Function | Contao permission | Setting |
| --- | --- | --- |
| Opening the module (list of services, buttons above it) | **Back end modules** | *NEO Digital*: **Cookie consent** |
| Adding, changing, switching, copying and deleting services | **Allowed fields**, table `tl_neo_cookieconsent_service` | the fields below |
| | **Table permissions** (Contao 5.7 and later), `tl_neo_cookieconsent_service` | Create, Update, Delete as needed |
| Changing the settings, **Check now** in the settings | **Allowed fields**, table `tl_neo_cookieconsent_settings` | the fields below |
| | **Table permissions** (Contao 5.7 and later), `tl_neo_cookieconsent_settings` | Update |
| Texts per language | **Allowed fields**, table `tl_neo_cookieconsent_text` | all fields |
| | **Table permissions** (Contao 5.7 and later), `tl_neo_cookieconsent_text` | Create, Update, Delete as needed |
| Scan results: changing the status, deleting | **Allowed fields**, table `tl_neo_cookieconsent_finding` | Status `[status]` |
| | **Table permissions** (Contao 5.7 and later), `tl_neo_cookieconsent_finding` | Update, Delete |
| Scan results: **Check now**, **Add as service** | **Back end modules** | **Cookie consent** (no further permission) |
| Proof of consent: list and details | **Back end modules** | **Cookie consent** (the entries cannot be changed) |
| Content element **Cookie list** | **Content elements** | **Cookie list** |
| | Contao's permissions for articles and content elements | as for every content element |
| Insert tags `{{cookie_consent::…}}` | — | none; they work in every text |
| **Own code** of a service | — | **administrators only**; the field is missing for every other user |

Without **Own code**, editors add own services with **Addresses** (the page
loads them, the banner blocks them).

As with Contao's own permissions, a user gets the permissions of the user, those
of the groups, or both, depending on **Permission inheritance**.

## The fields

Under **Allowed fields**, Contao lists the fields under the table name, each
with its label and the field name in square brackets. A field that is not
allowed is missing in the form.

| Table | Fields |
| --- | --- |
| `tl_neo_cookieconsent_service` | Template `[template]`, Name `[title]`, Category `[category]`, Loading `[loading]`, ID `[tracking_id]`, Address of your own server `[tracking_url]`, Provider `[provider]`, Purpose `[purpose]`, Transfer to a third country `[transfer]`, Privacy policy of the provider `[privacy_url]`, Cookies `[cookies]`, Addresses `[hosts]`, Websites `[roots]`, Active `[published]` (also needed for **On/off**) |
| `tl_neo_cookieconsent_settings` | Show the banner `[active]`, Appears `[show_on]`, Position `[position]`, Dim the background `[overlay]`, Button to reopen `[reopen]`, Privacy policy `[privacy_page]`, Legal notice `[imprint_page]`, Block scripts `[block_scripts]`, Block embedded content `[block_embeds]`, Google Consent Mode v2 `[consent_mode]`, Store consents `[log]`, Keep for `[log_days]`, Check daily `[scan]`, Pages per check `[scan_limit]`, Report to `[scan_mail]` |
| `tl_neo_cookieconsent_text` | Language `[language]` and every text field; Privacy policy of this language `[privacy_page]`, Legal notice of this language `[imprint_page]` |
| `tl_neo_cookieconsent_finding` | Status `[status]` |

**Name** `[title]` and **Category** `[category]` of a service and
**Language** `[language]` of a text are required fields: allow them, otherwise
these forms cannot be saved. The section **Languages** of a service needs no
field permission.

## Example group "Editors: cookie banner"

For editors who keep the services and texts current, without the settings:

1. **Back end modules**: **Cookie consent**.
2. **Allowed fields** → `tl_neo_cookieconsent_service`: all fields of the
   list; `tl_neo_cookieconsent_text`: all fields;
   `tl_neo_cookieconsent_finding`: Status.
3. **Table permissions** (Contao 5.7 and later):
   `tl_neo_cookieconsent_service` → Create, Update, Delete;
   `tl_neo_cookieconsent_text` → Create, Update;
   `tl_neo_cookieconsent_finding` → Update.
4. Optionally **Content elements**: **Cookie list**.
5. Save.

Without fields of `tl_neo_cookieconsent_settings` and without its table
permission, the group cannot change the settings. Then log in with a test
user, add a service from a template and switch it off and on again.

## Several websites in one installation

There is no separation per website. Whoever may open the module sees and
changes the services, texts and settings of all websites, and the proof of
consent of all websites. Services are limited to websites with the field
**Websites**.
