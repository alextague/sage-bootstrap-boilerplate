# Image & Text 50/50 Module

## Overview
The Image & Text 50/50 module creates a two-column split-screen layout with an image on one side and text content on the other. It supports two style variations and allows toggling which side the image appears on.

## Features
- **Two Style Variations**: Standard (Option 1) or blog-card-styled (Option 2)
- **Image Side Toggle**: Place image on the left or right
- **Eyebrow Text**: Optional label above the title (Option 1 only)
- **CTA Button**: Optional call-to-action link (Option 1 only)
- **Responsive**: Stacks vertically on mobile
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/ImageText5050.php`
2. **Blade Template**: `resources/views/modules/image-text-50-50.blade.php`
3. **SCSS Styles**: `resources/css/modules/_image-text-50-50.scss`

### Files Modified
- `app/Fields/Builder.php` — Registered the `image_text_50_50` layout
- `resources/css/app.scss` — Imports `_image-text-50-50.scss`

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Select Module Style** (Select) — Drives field visibility:
  - **Option 1**: Simple image + text with optional eyebrow and button
  - **Option 2**: Styled to match blog post cards (title and copy only)
- **Image Side** (True/False toggle) — `Left` (on) or `Right` (off)
- **Image** (Image, returns ID) — The section image
- **Eyebrow Text** (Text, Option 1 only) — Short uppercase label above the title
- **Title** (Text, all options) — Section heading
- **Copy** (WYSIWYG, all options) — Body text
- **Button** (Link, Option 1 only) — Optional CTA link

### Settings Tab
- **HTML ID** (Text) — Optional anchor link target
- **Custom CSS Classes** (Text) — Spacing and layout utilities
- **Custom Inline Styles** (Text) — Inline CSS overrides
- **Help Tab** — Detailed usage guide and best practices

## How It Works

### Data Flow
ACF fields → Blade template → Bootstrap column order classes control image side

### Image Side Toggle
The `image_side` field controls the Bootstrap column order. When `Left`, the image column comes first in the markup (and visually). When `Right`, CSS `order` classes swap the visual order on desktop while maintaining logical markup order.

### Style Variations
- **Option 1**: Full-featured — eyebrow, title, WYSIWYG, button, image side control
- **Option 2**: Matches the styled appearance of blog post cards — title and copy only, fixed visual treatment

## Styling Details
- Each column is 12/24 columns (exactly 50%) on desktop
- On mobile/tablet, columns stack with image first, text below
- Option 2 styling matches `_card.scss` or similar blog card styles
- SCSS handles image sizing, text column padding, and eyebrow text treatment

## Usage Instructions

### Adding the Module to a Page
1. Add an **Image & Text 50/50** module in the Page Builder
2. Select the **Style** (Option 1 or 2)
3. Toggle **Image Side** (Left or Right)
4. Upload or select an **Image**
5. For Option 1: optionally add **Eyebrow Text** and a **Button**
6. Add a **Title** and **Copy** content
7. Configure spacing in the **Settings** tab

### Stacking Multiple Instances
When placing multiple Image & Text 50/50 modules in sequence:
- Alternate **Image Side** between Left and Right to create visual rhythm
- Ensure consistent image sizes across all instances for a polished look

### Best Practices
- Alternate image sides when stacking multiple instances on the same page
- Use high-quality, appropriately cropped images
- Keep copy concise — the 50/50 layout works best with moderate text lengths
- Use eyebrow text for categorization or labeling (1–3 words)
- Ensure buttons have clear, action-oriented labels

## Troubleshooting
- **Fields not showing**: Check the **Select Module Style** dropdown — fields are conditional on this value
- **Image order on mobile**: On mobile, both styles stack with image first regardless of the toggle setting

## Related Modules
- **Card Grid** — For multiple visual cards in a grid layout
- **Freeform Content** — For images embedded within flowing text

## Design Reference
Add screenshots to:
- `resources/images/admin/module-screenshots/image-text-50-50.png` (Option 1)
- `resources/images/admin/module-screenshots/image-text-50-50-option-2.png` (Option 2)
