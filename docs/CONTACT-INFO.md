# Contact Info Module

## Overview
The Contact Info module displays a business's direct contact details — name, website, email, phone, and Google Maps link — alongside an optional title and WYSIWYG copy. It is intended for contact pages and location sections where direct contact information needs to be paired with introductory or explanatory text.

## Features
- **Contact Details**: Business name, website, email, phone, Google Maps link
- **Title + WYSIWYG Copy**: Paired introductory text for context
- **All Fields Optional**: Show only the fields that are relevant
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/ContactInfo.php`
2. **Blade Template**: `resources/views/modules/contact-info.blade.php`
3. **SCSS Styles**: `resources/css/modules/_contact-info.scss`

### Files Modified
- `app/Fields/Builder.php` — Registered the `contact_info` layout
- `resources/css/app.scss` — Imports `_contact-info.scss`

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Business Name** (Text) — The business or organization name
- **Website** (Link) — Website URL with display text
- **Email** (Text) — Contact email address
- **Phone Number** (Text) — Contact phone number
- **Google Link** (Link) — Google Maps listing link
- **Title** (Text) — Section heading
- **Copy** (WYSIWYG) — Introductory or explanatory text

### Settings Tab
- **HTML ID** (Text) — Optional anchor link target
- **Custom CSS Classes** (Text) — Spacing and layout utilities
- **Custom Inline Styles** (Text) — Inline CSS overrides
- **Help Tab** — Detailed usage guide and best practices

## How It Works

### Data Flow
ACF fields → Blade template → conditionally rendered contact detail elements

### Conditional Rendering
Each contact field is conditionally rendered in Blade — if a field is empty, its corresponding element is not output. This allows flexible use of the module with only relevant fields displayed.

## Styling Details
- Contact details styled in `_contact-info.scss`
- Icons (if used) via utility classes or Font Awesome
- Two-column layout: contact details on one side, title + copy on the other
- Responsive: stacks vertically on mobile

## Usage Instructions

### Adding the Module to a Page
1. Add the **Contact Info** module in the Page Builder
2. Fill in the contact detail fields (all are optional — leave blank to hide)
3. Add a **Title** and **Copy** for introductory context
4. Configure spacing in the **Settings** tab via **Custom CSS Classes**
5. Optionally set an **HTML ID** for anchor links (e.g., `contact-info`)

### Field Notes
- **Website**: Use the Link field so you can control both the URL and displayed text
- **Email**: Enter the raw email address — the Blade template wraps it in `<a href="mailto:...">` 
- **Phone Number**: Enter in a readable format (e.g., `(555) 123-4567`) — the Blade template wraps it in `<a href="tel:...">`
- **Google Link**: Use the "Share" option in Google Maps and copy the link

### Best Practices
- Always provide the most critical contact method for your business
- Test email and phone links on mobile
- Keep copy concise — this module is for quick reference, not long explanations

## Related Modules
- **Contact Form** — For adding a form alongside contact info
- **Text** — For longer explanatory text sections

## Design Reference
Add a screenshot to `resources/images/admin/module-screenshots/contact-info.png`
