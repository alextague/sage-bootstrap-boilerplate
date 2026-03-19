# Logo Grid Module

## Overview
The Logo Grid module displays a responsive grid of partner, sponsor, or client logos with optional linking. An optional title and copy section can be added above the grid for context.

## Features
- **Logo Repeater**: Add unlimited logos with optional URLs
- **Optional Title & Copy**: Contextual heading and text above the grid
- **Responsive Grid**: Logos reflow across screen sizes
- **Accessible Links**: Each logo can link to an external or internal URL
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/LogoGrid.php`
2. **Blade Template**: `resources/views/modules/logo-grid.blade.php`
3. **SCSS Styles**: `resources/css/modules/_logo-grid.scss`

### Files Modified
- `app/Fields/Builder.php` — Registered the `logo_grid` layout
- `resources/css/app.scss` — Imports `_logo-grid.scss`

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Title** (Text) — Optional section heading
- **Copy** (Textarea) — Optional introductory text below the title
- **Logos** (Repeater)
  - **URL** (URL) — Optional link for the logo (leave blank for no link)
  - **Logo** (Image, returns ID) — The logo image

### Settings Tab
- **HTML ID** (Text) — Optional anchor link target
- **Custom CSS Classes** (Text) — Spacing and layout utilities
- **Custom Inline Styles** (Text) — Inline CSS overrides
- **Help Tab** — Detailed usage guide and best practices

## How It Works

### Data Flow
ACF Repeater → Blade loop → grid of `<img>` elements, conditionally wrapped in `<a>` tags when a URL is provided

### Rendering Logic
In Blade, if a logo's `url` field is not empty, the `<img>` is wrapped in an `<a href="..." target="_blank" rel="noopener noreferrer">`. If empty, the image renders unwrapped.

## Styling Details
- Logos displayed with `object-fit: contain` so they don't crop
- Consistent height enforced via CSS to align logos of different sizes
- Grid uses Bootstrap responsive columns: e.g., `col-6 col-md-4 col-lg-3`
- Logo images sized proportionally within a fixed-height container

## Usage Instructions

### Adding the Module to a Page
1. Add a **Logo Grid** module in the Page Builder
2. Optionally add a **Title** and **Copy** above the logos
3. In the **Logos** repeater, add each logo:
   - **URL**: The destination URL (optional — leave blank for no link)
   - **Logo**: Upload or select the logo image
4. Configure spacing in the **Settings** tab via **Custom CSS Classes**

### Logo Image Guidelines
- Use transparent PNG or SVG files when possible
- Ensure all logos have a similar aspect ratio for the cleanest grid
- Recommended maximum width: 300px per logo source file
- Logos will be constrained by CSS — no need to pre-size exactly

### Best Practices
- Use consistent logo formats (all SVG or all PNG)
- Add URLs only for logos with public-facing websites
- Keep the number of logos reasonable (4–12 is typical)
- Use the title and copy to set context (e.g., "Our Partners", "Proud Sponsors")
- Ensure all linked URLs open to appropriate official pages

## Troubleshooting
- **Logos showing at wrong size**: Check `_logo-grid.scss` for the container height constraint
- **External link not opening in new tab**: Confirm the URL field has a full `https://` URL

## Related Modules
- **Carousel** — For logos in a scrolling carousel (Logos variation)
- **Card Grid** — For content cards with background images

## Design Reference
Add a screenshot to `resources/images/admin/module-screenshots/logo-grid.png`
