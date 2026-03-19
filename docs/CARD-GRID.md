# Card Grid Module

## Overview
The Card Grid module displays a responsive grid of visual cards, each featuring a background image and a call-to-action link. An optional header section (title + copy) can be added above the grid. The module supports a blue or white background color toggle.

## Features
- **Visual Cards**: Background-image cards with clickable links
- **Background Color Toggle**: Blue or White module background
- **Optional Header**: Title and copy above the grid
- **Repeater-Based**: Add unlimited cards
- **Responsive Grid**: Cards reflow across all screen sizes
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/CardGrid.php`
2. **Blade Template**: `resources/views/modules/card-grid.blade.php`
3. **SCSS Styles**: `resources/css/modules/_card-grid.scss`

### Files Modified
- `app/Fields/Builder.php` — Registered the `card_grid` layout
- `resources/css/app.scss` — Imports `_card-grid.scss`

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Background Color** (True/False) — `Blue` (on) or `White` (off, default)
- **Title** (Text) — Optional section heading
- **Copy** (Textarea) — Optional introductory text below the title
- **Cards** (Repeater)
  - **Link** (Link) — Button text and destination URL
  - **Background Image** (Image, returns ID) — Card's visual background

### Settings Tab
- **HTML ID** (Text) — Optional anchor link target
- **Custom CSS Classes** (Text) — Spacing and layout utilities
- **Custom Inline Styles** (Text) — Inline CSS overrides
- **Help Tab** — Detailed usage guide and best practices

## How It Works

### Data Flow
ACF Repeater → Blade loop → CSS background-image cards with link overlays

### Card Layout
Each card renders as a div with a CSS `background-image` (processed via `<x-acf-image>` component). A full-card anchor link overlays the image. The card grid uses Bootstrap's responsive column system.

## Styling Details
- Background color controlled by the `background_color` toggle
- Card images are set via inline `style="background-image: url(...)"` 
- SCSS in `_card-grid.scss` handles card height, overlay hover effects, and grid gaps

## Usage Instructions

### Adding the Module to a Page
1. In the Page Builder, add a **Card Grid** module
2. Toggle **Background Color** (White or Blue)
3. Optionally add a **Title** and **Copy** above the cards
4. In the **Cards** repeater, add each card:
   - **Link**: Enter the button label and destination URL
   - **Background Image**: Upload or select a high-quality image
5. Configure spacing in the **Settings** tab via **Custom CSS Classes**

### Best Practices
- Use consistent image aspect ratios (e.g., all landscape or all square)
- Keep link text action-oriented and brief (2–4 words)
- Aim for 3–6 cards per grid for the best visual balance
- Group related content — services, highlights, portfolio pieces
- Test images at mobile sizes to ensure they're recognizable

## Common Customizations
- Adjust grid columns using `col-md-*` in `custom_classes`
- Add `sage-py-100` or similar spacing utilities in `custom_classes`

## Troubleshooting
- **Images not showing**: Ensure the image field has a valid attachment ID (not a URL)
- **Odd number of cards**: The last card may span a full row — use even numbers for clean grids

## Related Modules
- **Logo Grid** — For logo/partner displays without card styling
- **Image & Text 50/50** — For paired image + body copy layouts

## Design Reference
Add a screenshot to `resources/images/admin/module-screenshots/card-grid.png`
