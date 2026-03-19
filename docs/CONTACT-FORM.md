# Contact Form Module

## Overview
The Contact Form module embeds a Contact Form 7 form within a styled full-width layout that supports an optional background image. It is the standard way to place a contact or inquiry form on any page.

## Features
- **CF7 Integration**: Select any Contact Form 7 form via ACF CF7 field
- **Background Image**: Optional decorative background behind or beside the form
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/ContactForm.php`
2. **Blade Template**: `resources/views/modules/contact-form.blade.php`
3. **SCSS Styles**: `resources/css/modules/_contact-form.scss`

### Files Modified
- `app/Fields/Builder.php` — Registered the `contact_form` layout
- `resources/css/app.scss` — Imports `_contact-form.scss`

## Prerequisites
**Contact Form 7** plugin must be installed and activated. Create and configure your form in CF7 before adding this module to a page.

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Form** (ACF CF7 Field) — Dropdown to select any published CF7 form
- **Background Image** (Image, returns ID) — Optional section background image

### Settings Tab
- **HTML ID** (Text) — Optional anchor link target (e.g., `contact`)
- **Custom CSS Classes** (Text) — Spacing and layout utilities
- **Custom Inline Styles** (Text) — Inline CSS overrides
- **Help Tab** — Detailed usage guide and best practices

## How It Works

### Data Flow
ACF CF7 field selection → CF7 shortcode output in Blade → CF7 renders form HTML + AJAX submission

### Background Image
When provided, the background image is used as a CSS background or within a dedicated image column, depending on the Blade template's layout implementation.

## Styling Details
- Form styling in `_contact-form.scss`
- CF7 form classes are safelisted in `postcss.config.js` to prevent PurgeCSS from stripping them
- Gravity Forms fallback classes (`gform_*`, `gfield_*`) are also safelisted

## Usage Instructions

### Adding the Module to a Page
1. Ensure **Contact Form 7** is installed and you have a form created
2. Add the **Contact Form** module in the Page Builder
3. Select the desired form from the **Form** dropdown
4. Optionally upload a **Background Image**
5. Set an **HTML ID** (e.g., `contact`) if you need a page anchor link

### Best Practices
- Always test the form submission after placing it on a page
- Configure CF7 mail settings before going live
- Use the **Custom CSS Classes** field to control spacing (e.g., `sage-py-100`)
- Add a confirmation message in CF7 settings so users know their submission was received

## Troubleshooting
- **Form not appearing**: Ensure CF7 plugin is active and a form has been selected
- **CF7 styles stripped**: CF7 classes should be safelisted in `postcss.config.js` — verify `gform_*` and CF7 classes are present
- **AJAX not working**: Ensure CF7 scripts are enqueued (not dequeued in theme setup)

## Related Modules
- **Contact Info** — For displaying address, phone, email without a form
- **Text** — For simple informational sections near the contact form

## Design Reference
Add a screenshot to `resources/images/admin/module-screenshots/contact-form.png`
