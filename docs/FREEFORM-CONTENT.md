# Freeform Content Module

## Overview
The Freeform Content module provides a single, full-featured WYSIWYG editor with media upload support. It gives content editors complete control over formatting, images within text, and complex content structures — making it the most flexible text module available.

## Features
- **Full WYSIWYG Editor**: All WordPress editor formatting options
- **Media Upload**: Insert images, videos, and files directly in content
- **Text Size Option**: Regular (20px) or Small (16px) body text
- **Centered Layout**: 18/24 column width on desktop with responsive stacking
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/FreeformContent.php`
2. **Blade Template**: `resources/views/modules/freeform-content.blade.php`
3. **SCSS Styles**: `resources/css/modules/_freeform-content.scss`

### Files Modified
- `app/Fields/Builder.php` — Registered the `freeform_content` layout
- `resources/css/app.scss` — Imports `_freeform-content.scss`

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Content** (WYSIWYG, full toolbar, media upload enabled) — The freeform content area

### Settings Tab
- **Text Size** (Select) — `Regular` (default, 20px) or `Small` (16px)
- **HTML ID** (Text) — Optional anchor link target
- **Custom CSS Classes** (Text) — Spacing and layout utilities
- **Custom Inline Styles** (Text) — Inline CSS overrides
- **Help Tab** — Detailed usage guide and best practices

## How It Works

### Data Flow
ACF WYSIWYG → `{!! $module->content !!}` in Blade → WordPress post content filters applied

### Layout
Content renders in a centered 18-column container (`col-24 col-lg-18 offset-lg-3`) on large screens. On mobile and tablet, it stacks to full container width.

### Text Size
The `text_size` setting adds a modifier class to the content wrapper, which adjusts `font-size` via SCSS.

## Styling Details
- Images embedded via the WYSIWYG editor receive `box-shadow` styling via `_freeform-content.scss`
- Text size variants styled via `.text-size-regular` and `.text-size-small` modifier classes
- Typography inherits from global `_typography.scss`

## Usage Instructions

### Adding the Module to a Page
1. Add a **Freeform Content** module in the Page Builder
2. Use the **Content** WYSIWYG editor with full formatting capabilities
3. Insert images via the **Add Media** button
4. In **Settings**, choose **Text Size** (Regular or Small)
5. Optionally add an **HTML ID** for anchor links

### When to Use vs. Text Module
| Use Freeform Content | Use Text Module |
|---|---|
| Images embedded within text flow | Simple title + body copy |
| Complex mixed-media content | Predefined layout variations needed |
| Importing content from elsewhere | Eyebrow text or 2-column layout |
| Tables, custom HTML needed | Consistent layout constraints preferred |

### Best Practices
- Optimize images before uploading (compress to <300KB for typical web use)
- Use Regular text size for primary content — it's more readable
- Keep content manageable — split very long content into multiple modules
- Test media embeds (videos, iframes) to ensure responsive behavior

## Related Modules
- **Text** — For simpler text layouts with predefined column structures
- **Image & Text 50/50** — For side-by-side image and text layouts

## Design Reference
Add a screenshot to `resources/images/admin/module-screenshots/freeform-content.png`
