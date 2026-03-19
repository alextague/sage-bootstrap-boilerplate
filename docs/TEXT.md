# Text Module

## Overview
The Text module is a flexible text content block with three layout variations: centered single column, left-aligned single column (with optional eyebrow text), and two-column side-by-side. It is one of the most commonly used modules for body copy, section introductions, and any text-heavy content.

## Features
- **Three Layout Variations**: Centered, left-aligned, and two-column
- **Title & WYSIWYG Copy**: Rich text with basic formatting options
- **Title Size Control**: Regular or Larger title styling
- **Eyebrow Text**: Optional label above title (left-aligned layout only)
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/Text.php`
2. **Blade Template**: `resources/views/modules/text.blade.php`
3. **SCSS Styles**: `resources/css/modules/_text.scss`

### Files Modified
- `app/Fields/Builder.php` — Registered the `text` layout
- `resources/css/app.scss` — Imports `_text.scss`

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Title** (Text) — Section heading
- **Title Size** (Select) — `Regular` (default h2 styling) or `Larger` (h1 styling)
- **Copy** (WYSIWYG, basic toolbar, no media upload) — Body text

### Settings Tab
- **Columns** (Select) — Layout variation:
  - `1 Column Centered` (default)
  - `1 Column Left Aligned`
  - `2 Columns`
- **Eyebrow** (Text, conditional: Left Aligned only) — Short uppercase label above the title
- **HTML ID** (Text) — Optional anchor link target
- **Custom CSS Classes** (Text) — Spacing and layout utilities
- **Custom Inline Styles** (Text) — Inline CSS overrides
- **Help Tab** — Detailed usage guide and best practices

## How It Works

### Data Flow
ACF fields → `text.blade.php` → layout class applied based on `columns` value → Bootstrap column structure

### Layout Column Widths
- **1 Column Centered**: `col-24 col-md-18 offset-md-3` (18/24 centered)
- **1 Column Left Aligned**: `col-24 col-md-16` (left-aligned with eyebrow option)
- **2 Columns**: Title `col-24 col-md-7`, Copy `col-24 col-md-10 offset-md-1`

### Title Size
- `Regular` → `sage-h2` class (standard 48px styling)
- `Larger` → `sage-h1` class (64px, use sparingly)
- HTML element is always `<h3>` for SEO hierarchy; visual styling is applied via utility classes

## Styling Details
- No dedicated SCSS overrides for typography — all handled via utility classes
- The eyebrow text renders in uppercase with letter-spacing via `.text-uppercase .sage-ls-60` or similar
- Two-column layout uses flexbox alignment utilities from Bootstrap

## Usage Instructions

### Adding the Module to a Page
1. Add a **Text** module in the Page Builder
2. Enter a **Title** and select **Title Size** (Regular or Larger)
3. Add **Copy** using the WYSIWYG editor
4. In **Settings**, select the **Columns** layout variation
5. For Left Aligned: optionally add an **Eyebrow** label
6. Optionally set an **HTML ID** for anchor links

### Layout Selection Guide
| Use | Layout |
|---|---|
| Impactful statements, formal messaging | 1 Column Centered |
| Longer text, labeled sections, casual tone | 1 Column Left Aligned |
| Comparisons, Q&A, breaking monotony | 2 Columns |

### Best Practices
- Keep titles concise (3–10 words)
- Use Larger title size sparingly (1–2 per page maximum)
- Eyebrow text should be 1–3 words (category or label)
- Two-column layout adds visual variety to content-heavy pages
- Break very long copy across multiple Text modules

## Related Modules
- **Freeform Content** — For images within text or complex mixed-media content
- **Accordion** — For long content that benefits from expand/collapse behavior

## Design Reference
Add screenshots to:
- `resources/images/admin/module-screenshots/text.png` (Centered)
- `resources/images/admin/module-screenshots/text-left-aligned.png` (Left Aligned)
- `resources/images/admin/module-screenshots/text-2-columns.png` (2 Columns)
