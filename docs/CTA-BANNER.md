# CTA Banner Module

## Overview
The CTA Banner module is a full-width, visually impactful call-to-action banner with four layout style variations and support for video or image backgrounds. It is designed to drive user action at strategic points throughout a page.

## Features
- **Four Style Variations**: Flexible content layouts for different design contexts
- **Video or Image Background**: Options 1 and 2 support both; Options 3 and 4 use images
- **Background Accent Images**: Decorative overlay accents for Options 1 and 3
- **Eyebrow Text**: Available in Options 2 and 4
- **Script Text**: Stylized italic text for Option 3
- **CTA Button**: Available in Options 1, 2, and 4
- **Custom Column Classes**: Fine-tune inner column layout
- **Background Image Positioning**: CSS `object-position` control
- **Custom ID/Classes/Styles**: Standard module customization support

## Module Structure

### Files Created
1. **ACF Field Partial**: `app/Fields/Partials/CTABanner.php`
2. **Blade Template**: `resources/views/modules/cta-banner.blade.php`
3. **SCSS Styles**: `resources/css/modules/_cta-banner.scss`

### Files Modified
- `app/Fields/Builder.php` — Registered the `cta_banner` layout
- `resources/css/app.scss` — Imports `_cta-banner.scss`

## ACF Field Structure

### Content Tab
- **Module Help** (Message) — In-editor guidance for content editors
- **Select Banner Style** (Select, conditional source) — Drives field visibility for all other content fields
  - **Option 1**: Centered title, copy, and button on video or image background
  - **Option 2**: Two-column layout: eyebrow + title (left), copy (right), button spanning bottom
  - **Option 3**: Centered script accent text + title on image background
  - **Option 4**: Centered icon, eyebrow, title, copy, and button on image background
- **Icon** (Image, Option 4 only) — Icon displayed above eyebrow text
- **Eyebrow Text** (Text, Options 2 & 4) — Short label above the title
- **Title** (Text, all options) — Main heading text
- **Copy** (Textarea, Options 1, 2 & 4) — Body text
- **Script Text** (Text, Option 3 only) — Italicized accent text
- **Button** (Link, Options 1, 2 & 4) — CTA button
- **Background Accent Left / Right** (Image, Options 1 & 3) — Decorative overlay images
- **Video or Image Background** (True/False toggle, Options 1 & 2) — Switches between video and image
- **Upload Video** (File, when Video selected) — MP4 video file
- **Background Image** (Image, when Image selected or Options 3 & 4) — Section background

### Settings Tab
- **HTML ID** (Text) — Optional anchor link target
- **Column Classes** (Text) — CSS classes applied to the inner content column
- **Custom CSS Classes** (Text) — Spacing/layout classes on the module wrapper
- **Custom Inline Styles** (Text) — Inline CSS on the module wrapper
- **Background Image Positioning** (Text) — CSS `object-position` value (e.g., `center top`)
- **Help Tab** — Detailed usage guide and best practices

## How It Works

### Style Option Field Visibility
All content fields use ACF conditional logic driven by `style_option`. Only fields relevant to the selected option are shown — this prevents editors from filling in fields that won't be used.

### Video Backgrounds
When `video_or_image` is `0` (Video), a `<video>` element is rendered with autoplay, muted, and loop attributes. Falls back gracefully on mobile devices.

### Background Accents
Accent images are absolutely positioned decorative layers on top of the background, below the content. They add visual texture without requiring image editing.

## Styling Details
- Background video/image handled via CSS `object-fit: cover`
- Background image positioning controlled by `background_image_positioning` field value
- Content column uses Bootstrap grid classes from `column_classes` field
- Module wrapper spacing controlled via `custom_classes`

## Usage Instructions

### Adding the Module to a Page
1. Add a **CTA Banner** module in the Page Builder
2. Select a **Style** (Option 1–4)
3. Fill in the content fields shown for your selected style
4. For Options 1 & 2: toggle **Video or Image Background** and upload accordingly
5. For Options 3 & 4: upload a **Background Image**
6. Optionally add **Background Accent** images for decorative detail
7. Add a **Button** with action-oriented text and URL (where available)

### Best Practices
- Keep titles short and action-oriented (3–8 words)
- Use high-contrast background images or videos
- Use action verbs in button text ("Apply Now", "Get Started", "Learn More")
- Test video backgrounds on mobile — they fall back to the poster/image
- Avoid placing multiple CTA Banners consecutively on the same page

## Troubleshooting
- **Correct fields not showing**: Check that the **Select Banner Style** dropdown is set to the correct option — fields are conditional on this value
- **Video not playing on mobile**: This is expected browser behavior (autoplay restrictions); ensure a background image fallback is set

## Related Modules
- **Text** — For standalone text without a visual background
- **Freeform Content** — For maximum editorial flexibility

## Design Reference
Add a screenshot to `resources/images/admin/module-screenshots/cta-banner.png`
