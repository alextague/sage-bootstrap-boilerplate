# Accordion Module

## Overview
The Accordion module displays content in collapsible, expandable panels. It's ideal for FAQs, program details, eligibility requirements, or any content where users want to scan headings and selectively read details.

## Features
- **Collapsible Panels**: Click-to-expand sections powered by Bootstrap Collapse
- **Configurable Defaults**: Optionally expand the first panel on page load
- **Exclusive Open Mode**: Option to close other panels when a new one opens
- **Background Styles**: No background or light gray background
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/Accordion.php`
2. **Blade Template**: `resources/views/modules/accordion.blade.php`
3. **SCSS Styles**: `resources/css/modules/_accordion.scss`
4. **JavaScript**: `resources/js/modules/accordion.js`
5. **Tests**: `tests/js/modules/accordion.test.js`

### Files Modified
- `app/Fields/Builder.php` — Registered the `accordion` layout

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Accordion Items** (Repeater, Required)
  - **Accordion Title** (Text, Required) — The clickable header for each panel
  - **Content** (WYSIWYG, Required) — Rich text content revealed on expand

### Settings Tab
- **Expand First Panel by Default** (True/False) — Opens first item on page load
- **Allow Multiple Panels Open** (True/False) — When off, opening one panel closes others
- **Background Style** (Select) — `No Background` or `Light Gray Background`
- **HTML ID** (Text) — Optional anchor link target
- **Custom CSS Classes** (Text) — Spacing and layout utilities
- **Custom Inline Styles** (Text) — Inline CSS overrides
- **Help Tab** — Detailed usage guide and best practices

## How It Works

### Data Flow
ACF Repeater → Blade loop → Bootstrap Collapse component → JS initialization

### Bootstrap Collapse
Each accordion item renders as a Bootstrap Collapse panel. The `expand_first_panel` field controls the `show` class on the first `.accordion-collapse` element. The `allow_multiple_open` field toggles whether `data-bs-parent` is set on collapse targets (restricts to one open panel when set).

## Styling Details
- Light gray background option: `background-color: #f5f5f5`
- Vertical padding applied via `custom_classes` spacing utilities
- Panel headers styled with standard Bootstrap accordion CSS overrides in `_accordion.scss`

## JavaScript Integration

### Module Loading
Loaded when the body has class `accordion-js`. Handles any dynamic initialization beyond Bootstrap's default behavior.

### Running Tests
```bash
npm run test:js
```

## Usage Instructions

### Adding the Module to a Page
1. In the Page Builder, add an **Accordion** module
2. In the **Content** tab, add accordion items via the repeater
3. Enter a concise **Title** for each item (the clickable header)
4. Add **Content** using the WYSIWYG editor (supports text, images, lists, links)
5. In the **Settings** tab, configure expansion behavior and background style
6. Optionally set an **HTML ID** for anchor links (e.g., `faq`)

### Best Practices
- Keep titles concise and descriptive (5–10 words)
- Use for FAQs, eligibility info, or any content users want to scan
- Aim for 3–8 items for optimal usability
- Place the most frequently accessed content in early panels

## Related Modules
- **Text** — For straightforward body copy without expand/collapse
- **Freeform Content** — For maximum editorial flexibility

## Design Reference
Add a screenshot to `resources/images/admin/module-screenshots/accordion.png`
