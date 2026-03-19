# Carousel Module

## Overview
The Carousel module provides an auto-scrolling image carousel powered by Splide.js. It supports two variations: a continuous logo carousel (ideal for partner/sponsor showcases) and a navigable gallery slideshow with optional CTA button.

## Features
- **Two Variations**: Logos (continuous scroll) or Gallery Images (navigable slideshow)
- **Optional Title**: Heading above the carousel
- **Optional CTA Button**: Available in Gallery variation
- **Splide.js Powered**: Lightweight, accessible slider with loop support
- **Responsive**: Adapts across all screen sizes
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/Carousel.php`
2. **Blade Template**: `resources/views/modules/carousel.blade.php`
3. **JavaScript**: `resources/js/modules/carousel.js`
4. **SCSS Styles**: `resources/css/modules/_carousel.scss` (imported via JS)
5. **Tests**: `tests/js/modules/carousel.test.js`

### Files Modified
- `app/Fields/Builder.php` — Registered the `carousel` layout

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Title** (Text) — Optional heading above the carousel
- **Variation** (Select) — `Logos` or `Gallery Images`
- **Button** (Link, conditional on Gallery) — Optional CTA below the carousel
- **Images** (Gallery, min 1) — The carousel images

### Settings Tab
- **HTML ID** (Text) — Optional anchor link target
- **Custom CSS Classes** (Text) — Spacing and layout utilities
- **Custom Inline Styles** (Text) — Inline CSS overrides
- **Help Tab** — Design reference with screenshots + usage guide

## How It Works

### Data Flow
ACF Gallery → Blade → Splide.js initialization based on `variation` value

### Splide Configuration
- **Logos**: Continuous auto-scroll, `type: 'loop'`, multiple per-page, no arrows
- **Gallery**: Navigable slideshow, `type: 'loop'`, arrows and pagination dots

### JavaScript Module Loading
Loaded when the body has class `carousel-js`. Initializes Splide on `.splide` elements and applies variation-specific options.

## Styling Details
- Carousel SCSS imported via `carousel.js` for code-split lazy loading
- Logo images displayed with `object-fit: contain` on white background
- Gallery images displayed with `object-fit: cover` at fixed aspect ratio

## JavaScript Integration

### Running Tests
```bash
npm run test:js
```

## Usage Instructions

### Adding the Module to a Page
1. Add a **Carousel** module in the Page Builder
2. Optionally add a **Title**
3. Select **Variation**: Logos or Gallery Images
4. If Gallery: optionally add a **Button** (text + URL)
5. Upload images in the **Images** gallery field
6. Minimum 3–4 images recommended for smooth looping

### Image Guidelines
- **Logos**: Transparent PNG on white, consistent dimensions
- **Gallery**: High-quality landscape images (1200×800px minimum)
- Minimum 3 images for smooth loop; aim for 4–8

### Best Practices
- Use Logos for partner/sponsor/client showcases
- Use Gallery for photo highlights, event galleries, visual storytelling
- Keep logo sizes consistent for a professional appearance
- Gallery images should share similar aspect ratios

## Related Modules
- **Logo Grid** — Static grid of logos without carousel animation
- **Card Grid** — Cards in a static grid, not a slider

## Design Reference
Add screenshots to:
- `resources/images/admin/module-screenshots/carousel-logos.png`
- `resources/images/admin/module-screenshots/carousel-gallery-images.png`
