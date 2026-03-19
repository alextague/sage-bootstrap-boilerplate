<?php
/**
 * Admin Documentation Page
 *
 * Centralized documentation for content editors.
 * Displays all available page builder modules with descriptions,
 * usage guidelines, and general site documentation.
 */

namespace App;

/**
 * Register the Documentation admin pages
 */
add_action('admin_menu', function () {
    // Parent menu page (Module Reference)
    add_menu_page(
        'Documentation',                  // Page title
        'Documentation',                  // Menu title
        'edit_pages',                     // Capability
        'site-documentation',             // Menu slug
        __NAMESPACE__ . '\\render_module_documentation_page',  // Callback
        'dashicons-book-alt',             // Icon
        2                                 // Position (directly after Dashboard)
    );

    // Module Reference submenu (same as parent)
    add_submenu_page(
        'site-documentation',             // Parent slug
        'Module Reference',               // Page title
        'Module Reference',               // Menu title
        'edit_pages',                     // Capability
        'site-documentation',             // Menu slug (same as parent)
        __NAMESPACE__ . '\\render_module_documentation_page'  // Callback
    );

    // Site Settings submenu
    add_submenu_page(
        'site-documentation',             // Parent slug
        'Site Settings',                  // Page title
        'Site Settings',                  // Menu title
        'edit_pages',                     // Capability
        'site-settings-docs',             // Menu slug
        __NAMESPACE__ . '\\render_site_settings_documentation_page'  // Callback
    );
});

/**
 * Enqueue admin styles for documentation
 */
add_action('admin_enqueue_scripts', function ($hook) {
    $css_file = get_template_directory() . '/resources/css/admin/acf-module-docs.css';

    // Load on documentation pages
    if ($hook === 'toplevel_page_site-documentation' || $hook === 'documentation_page_site-settings-docs') {
        if (file_exists($css_file)) {
            wp_enqueue_style(
                'module-docs',
                get_template_directory_uri() . '/resources/css/admin/acf-module-docs.css',
                [],
                filemtime($css_file)
            );
        }
    }

    // Also load on post edit pages (for ACF field group documentation)
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        if (file_exists($css_file)) {
            wp_enqueue_style(
                'acf-module-help',
                get_template_directory_uri() . '/resources/css/admin/acf-module-docs.css',
                ['acf-input'],
                filemtime($css_file)
            );
        }
    }
});

/**
 * Render the Module Documentation page
 */
function render_module_documentation_page()
{
    $modules = get_module_documentation_data();
    $template_uri = get_template_directory_uri();
    ?>
    <div class="wrap module-docs-wrap">
        <h1>📚 Module Reference</h1>
        <p class="description">
            Complete reference guide for page builder modules.
            Click on any module to expand details, view examples, and learn best practices.
        </p>

        <!-- Spacing Utility Classes Reference -->
        <div class="notice notice-info" style="margin-top: 20px; padding: 15px; background: #f0f6fc; border-left: 4px solid #2271b1;">
            <h3 style="margin-top: 0;">📐 Custom Spacing Classes</h3>
            <p style="margin-bottom: 10px;">All modules include a <strong>Custom Classes</strong> field in the Settings tab. Use these spacing utility classes to control margins and padding:</p>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">
                <div>
                    <h4 style="margin: 0 0 8px 0;">Pattern:</h4>
                    <code style="background: #fff; padding: 8px 12px; display: inline-block; border-radius: 3px; border: 1px solid #ddd;">sage-[property]-[size]</code>
                    <h4 style="margin: 15px 0 8px 0;">Properties:</h4>
                    <ul style="margin: 5px 0 0 20px; line-height: 1.8;">
                        <li><strong>m</strong> = margin, <strong>p</strong> = padding</li>
                        <li><strong>t</strong> = top, <strong>b</strong> = bottom, <strong>l</strong> = left, <strong>r</strong> = right</li>
                        <li><strong>x</strong> = left+right, <strong>y</strong> = top+bottom</li>
                    </ul>
                </div>
                <div>
                    <h4 style="margin: 0 0 8px 0;">Examples:</h4>
                    <ul style="margin: 5px 0 0 20px; line-height: 1.8;">
                        <li><code>sage-mb-50</code> — 50px bottom margin</li>
                        <li><code>sage-py-100</code> — 100px top & bottom padding</li>
                        <li><code>sage-mt-20</code> — 20px top margin</li>
                        <li><code>sage-mb-md-60</code> — 60px bottom margin on tablet+</li>
                    </ul>
                    <h4 style="margin: 15px 0 8px 0;">Size Range:</h4>
                    <p style="margin: 0;">0–220 in 5px increments</p>
                </div>
            </div>
        </div>

        <!-- Module Cards -->
        <div style="margin-top: 30px; max-width: 1200px;">
            <?php foreach ($modules as $module) : ?>
            <div class="module-doc-card" style="background: #fff; border: 1px solid #ccd0d4; border-radius: 4px; margin-bottom: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <details>
                    <summary style="cursor: pointer; padding: 20px 25px; display: flex; align-items: center; gap: 20px; list-style: none; user-select: none;">
                        <div style="flex: 1; min-width: 0;">
                            <h2 style="margin: 0 0 5px 0; font-size: 18px; font-weight: 600;">
                                <?php echo esc_html($module['name']); ?>
                            </h2>
                            <p style="margin: 0; color: #666; font-size: 14px;">
                                <?php echo esc_html($module['description']); ?>
                            </p>
                        </div>
                        <?php if (!empty($module['screenshot']) && file_exists(get_template_directory() . '/resources/images/admin/module-screenshots/' . basename($module['screenshot']))) : ?>
                        <div style="flex-shrink: 0; width: 200px;">
                            <img src="<?php echo esc_url($module['screenshot']); ?>"
                                 alt="<?php echo esc_attr($module['name']); ?>"
                                 style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 3px;">
                        </div>
                        <?php endif; ?>
                        <span style="flex-shrink: 0; color: #0073aa; font-size: 20px;">▼</span>
                    </summary>

                    <div style="padding: 0 25px 25px; border-top: 1px solid #f0f0f1;">

                        <!-- Screenshots -->
                        <?php
                        $screenshots = array_filter([
                            $module['screenshot'] ?? '',
                            $module['screenshot2'] ?? '',
                            $module['screenshot3'] ?? '',
                        ]);
                        if (count($screenshots) > 1) : ?>
                        <div style="margin-top: 20px;">
                            <h3 style="margin: 0 0 15px 0; font-size: 16px;">Layout Variations</h3>
                            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <?php foreach ($screenshots as $screenshot) : ?>
                                <img src="<?php echo esc_url($screenshot); ?>"
                                     alt="<?php echo esc_attr($module['name']); ?>"
                                     style="max-width: 30%; height: auto; border: 1px solid #ddd; border-radius: 3px;">
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Module Detail Grid -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 20px;">
                            <div>
                                <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #0073aa;">📋 When to Use</h3>
                                <p style="margin: 0; line-height: 1.6; color: #444; font-size: 14px;">
                                    <?php echo wp_kses_post($module['when_to_use']); ?>
                                </p>
                            </div>
                            <div>
                                <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #0073aa;">🛠️ How to Use</h3>
                                <p style="margin: 0; line-height: 1.6; color: #444; font-size: 14px;">
                                    <?php echo wp_kses_post($module['how_to_use']); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Best Practices -->
                        <?php if (!empty($module['best_practices'])) : ?>
                        <div style="margin-top: 20px;">
                            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #0073aa;">💡 Best Practices</h3>
                            <ul style="margin: 0; padding-left: 20px; line-height: 1.8; font-size: 14px; color: #444;">
                                <?php foreach ($module['best_practices'] as $practice) : ?>
                                <li><?php echo wp_kses_post($practice); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Developer Docs Link -->
                        <div style="margin-top: 20px; padding: 12px 15px; background: #f6f7f7; border-radius: 3px; font-size: 13px; color: #666;">
                            📄 Developer reference: <code>docs/<?php echo strtoupper(str_replace('_', '-', $module['slug'])); ?>.md</code>
                            &nbsp;|&nbsp;
                            🔧 Field group: <code>app/Fields/Partials/<?php
                                $class = str_replace('_', '', ucwords($module['slug'], '_'));
                                // Handle special cases
                                $class = str_replace('5050', '5050', $class);
                                echo esc_html($class);
                            ?>.php</code>
                        </div>
                    </div>
                </details>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

/**
 * Render the Site Settings Documentation page
 */
function render_site_settings_documentation_page()
{
    ?>
    <div class="wrap module-docs-wrap">
        <h1>⚙️ Site Settings Documentation</h1>
        <p class="description">
            Complete guide to managing global site settings including branding, contact information, and archive defaults.
        </p>

        <div style="margin-top: 30px; max-width: 1200px;">
            <!-- Theme Settings -->
            <div class="module-doc-card" style="background: #fff; border: 1px solid #ccd0d4; border-radius: 4px; padding: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px;">
                <h2 style="margin: 0 0 15px 0; font-size: 22px; display: flex; align-items: center; gap: 10px;">
                    🎨 Theme Settings
                    <a href="<?php echo esc_url(admin_url('admin.php?page=theme-general-settings')); ?>"
                       class="button button-primary"
                       style="margin-left: auto; font-size: 13px;">
                        Edit Settings
                    </a>
                </h2>
                <p style="margin: 0 0 20px 0; color: #666; font-size: 14px;">
                    Control site-wide branding, contact information, and archive defaults from one centralized location.
                </p>

                <div style="background: #f6f7f7; border-radius: 4px; padding: 20px; margin-bottom: 20px;">
                    <p style="margin: 0; color: #2c3338; font-weight: 600;">📍 Location:</p>
                    <p style="margin: 5px 0 0 0;">
                        WordPress Admin → <strong>Theme Settings</strong>
                    </p>
                </div>

                <!-- Branding Tab -->
                <details style="margin-bottom: 15px;" open>
                    <summary style="cursor: pointer; font-weight: 600; padding: 12px; background: #f0f0f1; border-radius: 3px; font-size: 16px;">
                        🏷️ Branding
                    </summary>
                    <div style="padding: 20px 15px;">
                        <table class="widefat" style="border: 1px solid #c3c4c7;">
                            <thead>
                                <tr>
                                    <th style="width: 180px; background: #f6f7f7; padding: 10px;">Field</th>
                                    <th style="background: #f6f7f7; padding: 10px;">Description</th>
                                    <th style="width: 200px; background: #f6f7f7; padding: 10px;">Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px; font-weight: 600;">Header Logo</td>
                                    <td style="padding: 10px;">Logo displayed in the site header navigation. Recommended size: 200×80px. PNG with transparency or SVG preferred.</td>
                                    <td style="padding: 10px;">Appears on all pages in the header</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; font-weight: 600;">Footer Logo</td>
                                    <td style="padding: 10px;">Logo displayed in the site footer. Can be the same or different from the header logo. Recommended size: 200×80px.</td>
                                    <td style="padding: 10px;">Appears on all pages in the footer</td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="margin-top: 15px; padding: 12px; background: #d1ecf1; border-left: 4px solid #0c5460; border-radius: 3px;">
                            <strong>💡 Best Practice:</strong> Use SVG format for logos when possible — crisp at any size. If SVG isn't available, use transparent PNG at 2× intended display size for retina screens.
                        </div>
                    </div>
                </details>

                <!-- Archive Tab -->
                <details style="margin-bottom: 15px;">
                    <summary style="cursor: pointer; font-weight: 600; padding: 12px; background: #f0f0f1; border-radius: 3px; font-size: 16px;">
                        📚 Archive Defaults
                    </summary>
                    <div style="padding: 20px 15px;">
                        <table class="widefat" style="border: 1px solid #c3c4c7;">
                            <thead>
                                <tr>
                                    <th style="width: 180px; background: #f6f7f7; padding: 10px;">Field</th>
                                    <th style="background: #f6f7f7; padding: 10px;">Description</th>
                                    <th style="width: 200px; background: #f6f7f7; padding: 10px;">Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px; font-weight: 600;">Archive Title</td>
                                    <td style="padding: 10px;">Default title text for archive pages (category, tag, date, custom post type archives). Applied as the fallback header title when no post-type-specific override exists.</td>
                                    <td style="padding: 10px;" rowspan="2">Displayed on archive and listing pages as the header content</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; font-weight: 600;">Archive Header Image</td>
                                    <td style="padding: 10px;">Default background image for archive page headers. Recommended size: 1920×500px. Can be overridden per post type via Headers field groups.</td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="margin-top: 15px; padding: 12px; background: #d1ecf1; border-left: 4px solid #0c5460; border-radius: 3px;">
                            <strong>💡 Tip:</strong> These settings serve as fallback defaults. Individual post type archives (e.g., Blog, custom CPTs) can override these with their own header settings configured in the Headers field group.
                        </div>
                    </div>
                </details>

                <!-- Contact Info Tab -->
                <details style="margin-bottom: 15px;">
                    <summary style="cursor: pointer; font-weight: 600; padding: 12px; background: #f0f0f1; border-radius: 3px; font-size: 16px;">
                        📧 Contact Info
                    </summary>
                    <div style="padding: 20px 15px;">
                        <table class="widefat" style="border: 1px solid #c3c4c7;">
                            <thead>
                                <tr>
                                    <th style="width: 180px; background: #f6f7f7; padding: 10px;">Field</th>
                                    <th style="background: #f6f7f7; padding: 10px;">Description</th>
                                    <th style="width: 200px; background: #f6f7f7; padding: 10px;">Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px; font-weight: 600;">Address 1</td>
                                    <td style="padding: 10px;">Primary street address line (e.g., "123 Main Street").</td>
                                    <td style="padding: 10px;" rowspan="5">These values are available via <code>get_field('address_1', 'options')</code> etc. Display location depends on how the theme's footer/header templates reference them.</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; font-weight: 600;">Address 2</td>
                                    <td style="padding: 10px;">Secondary address line for suite or unit numbers (optional).</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; font-weight: 600;">City</td>
                                    <td style="padding: 10px;">City name.</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; font-weight: 600;">State</td>
                                    <td style="padding: 10px;">State abbreviation (e.g., "CA", "NY").</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; font-weight: 600;">ZIP</td>
                                    <td style="padding: 10px;">ZIP or postal code.</td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="margin-top: 15px; padding: 12px; background: #fff3cd; border-left: 4px solid #856404; border-radius: 3px;">
                            <strong>⚠️ Note:</strong> Changes to contact information update site-wide wherever these option fields are referenced in templates. Verify accuracy before saving.
                        </div>
                    </div>
                </details>

            </div>
        </div>
    </div>
    <?php
}

/**
 * Get module documentation data
 * Modules listed in alphabetical order by display name
 */
function get_module_documentation_data()
{
    $template_uri = get_template_directory_uri();

    return [
        [
            'name' => 'Accordion',
            'slug' => 'accordion',
            'description' => 'Collapsible panels for organizing content into expandable sections.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/accordion.png',
            'when_to_use' => 'Use for FAQs, program requirements, eligibility criteria, or any content users want to scan and selectively read.',
            'how_to_use' => 'Add accordion items using the repeater — each item needs a title (the clickable header) and content (the expanded body). In Settings, configure whether the first panel opens by default and whether multiple panels can be open at once.',
            'best_practices' => [
                'Keep accordion titles concise and descriptive (5–10 words)',
                'Use for FAQs, requirements, or any content users want to skim',
                'Aim for 3–8 accordion items for optimal usability',
                'Place most frequently accessed content in the first panels',
                'Use consistent formatting within accordion content',
                'Don\'t hide critical information that all users need to see',
                'Avoid very long content — lengthy items may be better as separate pages',
            ],
        ],
        [
            'name' => 'Card Grid',
            'slug' => 'card_grid',
            'description' => 'A responsive grid of visual cards with background images and call-to-action links.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/card-grid.png',
            'when_to_use' => 'Use to showcase services, team highlights, portfolio items, or any content that benefits from a visual card format with clickable links.',
            'how_to_use' => 'Toggle the background color (White or Blue), optionally add a title and intro copy, then use the Cards repeater to add each card — each needs a link (text + URL) and a background image.',
            'best_practices' => [
                'Use high-quality images with consistent aspect ratios across all cards',
                'Keep link text short and action-oriented (2–4 words)',
                'Aim for 3–6 cards per grid for the best visual balance',
                'Group related content — services, features, team members',
                'Test on mobile to ensure images and text display well',
                'Don\'t mix portrait and landscape images in the same grid',
                'Avoid more than 8–10 cards — consider splitting into sections',
            ],
        ],
        [
            'name' => 'Carousel',
            'slug' => 'carousel',
            'description' => 'Auto-scrolling image carousel with two variations: continuous logo display or navigable gallery slideshow.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/carousel-logos.png',
            'screenshot2' => $template_uri . '/resources/images/admin/module-screenshots/carousel-gallery-images.png',
            'when_to_use' => 'Use the Logos variation for partner/sponsor showcases. Use the Gallery variation for photo highlights, event galleries, or visual storytelling.',
            'how_to_use' => 'Add an optional title, select a variation (Logos or Gallery Images), upload images in the gallery field, and optionally add a button for the Gallery variation.',
            'best_practices' => [
                'Use Logos variation for partner, sponsor, or client brand showcases',
                'Use Gallery variation for photo highlights, portfolios, or event galleries',
                'Keep logo sizes consistent for a professional appearance',
                'Use high-resolution images (1200×800px minimum) for Gallery',
                'Aim for 4–8 images for a smooth looping experience',
                'Gallery images should share similar aspect ratios',
                'Don\'t use fewer than 3 images — static display may be better',
            ],
        ],
        [
            'name' => 'Contact Form',
            'slug' => 'contact_form',
            'description' => 'Embeds a Contact Form 7 form with an optional background image in a styled full-width layout.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/contact-form.png',
            'when_to_use' => 'Use on contact pages or landing pages to collect user inquiries. Requires Contact Form 7 to be installed and a form configured before use.',
            'how_to_use' => 'Select a Contact Form 7 form from the dropdown and optionally upload a background image. Ensure CF7 mail settings and confirmation messages are configured before going live.',
            'best_practices' => [
                'Always test form submission after placing it on a page',
                'Configure CF7 mail settings and confirmation messages before launch',
                'Set an HTML ID (e.g., "contact") so CTAs can link directly to the form',
                'Keep forms short — ask only for essential information',
                'Use Custom Classes for spacing control (e.g., sage-py-100)',
                'Don\'t place the module without first creating a CF7 form',
                'Avoid placing multiple contact forms on the same page',
            ],
        ],
        [
            'name' => 'Contact Info',
            'slug' => 'contact_info',
            'description' => 'Displays business contact details — name, website, email, phone, and Google Maps link — alongside a section title and body copy.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/contact-info.png',
            'when_to_use' => 'Use on contact pages or location sections where providing direct contact details alongside an introduction is needed.',
            'how_to_use' => 'Fill in the contact fields that apply (all are optional — leave blank to hide), then add a title and copy for context. Email and phone are automatically wrapped in clickable links.',
            'best_practices' => [
                'Provide the most critical contact method for your business',
                'Test email and phone links on a mobile device after publishing',
                'Use the Google Link field to make the address directly clickable on maps',
                'Keep copy concise — this module is for quick reference',
                'Verify all links and contact details are current before publishing',
                'Don\'t enter addresses in copy text — use the dedicated fields',
                'Avoid long explanatory copy — use the Text module for that',
            ],
        ],
        [
            'name' => 'CTA Banner',
            'slug' => 'cta_banner',
            'description' => 'Full-width call-to-action banner with four style variations supporting background video or image and flexible content layouts.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/cta-banner.png',
            'when_to_use' => 'Use to drive user action at strategic points throughout a page. Choose the style option that best matches the surrounding design context.',
            'how_to_use' => 'Select a style option (1–4), fill in the content fields shown for that style (title, copy, button, eyebrow text as applicable), and choose a video or image background.',
            'best_practices' => [
                'Keep titles short and action-oriented (3–8 words)',
                'Use action verbs in button text ("Apply Now", "Get Started", "Learn More")',
                'Use high-quality, high-contrast background images or videos',
                'Choose a style that complements the surrounding page sections',
                'Test video backgrounds on mobile — they fall back to images',
                'Don\'t place multiple CTA Banners consecutively on the same page',
                'Avoid vague button text like "Click Here" or "Submit"',
                'Don\'t use backgrounds that make text difficult to read',
            ],
        ],
        [
            'name' => 'Freeform Content',
            'slug' => 'freeform_content',
            'description' => 'A flexible WYSIWYG content area with full editor capabilities and media upload for maximum editorial freedom.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/freeform-content.png',
            'when_to_use' => 'Use when you need complete control over formatting, want to insert images within text, or have complex content that structured modules can\'t accommodate. Ideal for importing content or when other modules are too restrictive.',
            'how_to_use' => 'Add content in the WYSIWYG editor with full formatting options. Insert images and media using the Add Media button. Choose text size (Regular or Small) in the Settings tab.',
            'best_practices' => [
                'Use when you need complete editorial control without layout restrictions',
                'Ideal for complex content with mixed media, tables, or custom formatting',
                'Optimize images before uploading (compress for web)',
                'Use Regular text size for primary content — it\'s more readable',
                'Keep content manageable — split very long content into multiple modules',
                'Test embedded media (videos, iframes) for responsive behavior',
                'Don\'t upload large unoptimized images through the editor',
                'Avoid Small text size for primary content',
            ],
        ],
        [
            'name' => 'Image & Text 50/50',
            'slug' => 'image_text_50_50',
            'description' => 'Split-screen layout with an image on one side and text content on the other — with two style variations and image side toggle.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/image-text-50-50.png',
            'when_to_use' => 'Use to pair a visual with descriptive copy for services, team bios, features, or any content that benefits from an image alongside text.',
            'how_to_use' => 'Select a style (Option 1 for standard, Option 2 for blog-card style), toggle the image side (left or right), upload an image, then add title and copy. For Option 1, also add optional eyebrow text and a button.',
            'best_practices' => [
                'Alternate image sides when stacking multiple instances for visual rhythm',
                'Use high-quality, appropriately cropped images',
                'Keep copy concise — the 50/50 layout works best with moderate text',
                'Use eyebrow text for categorization or labeling (1–3 words)',
                'Use clear, action-oriented button labels',
                'Don\'t use the same image side for multiple consecutive instances',
                'Avoid very long copy that overwhelms the image column',
                'Don\'t use small or low-resolution images — they scale to 50% viewport width',
            ],
        ],
        [
            'name' => 'Logo Grid',
            'slug' => 'logo_grid',
            'description' => 'A responsive grid of partner, sponsor, or client logos with optional title, intro copy, and per-logo links.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/logo-grid.png',
            'when_to_use' => 'Use to showcase partners, sponsors, clients, or affiliations. Works well as a trust-building section on home pages, about pages, or event pages.',
            'how_to_use' => 'Optionally add a title and copy above the grid, then use the Logos repeater to add each logo. For each logo, upload the image and optionally add a link URL. Logos without a URL display without a link.',
            'best_practices' => [
                'Use consistent logo file formats (all SVG or all transparent PNG)',
                'Keep the logo count reasonable — 4–12 logos is typical',
                'Add a title and copy to provide context for what the logos represent',
                'Test external links to confirm they point to the correct pages',
                'Ensure logos are legible at the grid\'s displayed size',
                'Don\'t mix transparent and non-transparent logos in the same grid',
                'Avoid logos with wildly different aspect ratios',
            ],
        ],
        [
            'name' => 'Text',
            'slug' => 'text',
            'description' => 'Flexible text content module with three layout variations: 1 Column Centered, 1 Column Left Aligned, or 2 Columns side-by-side.',
            'screenshot' => $template_uri . '/resources/images/admin/module-screenshots/text.png',
            'when_to_use' => 'One of the most commonly used modules. Use for body copy, section introductions, and any text-heavy content. Choose the layout that fits the design context.',
            'how_to_use' => 'Enter a title, choose a title size (Regular or Larger), and add copy in the WYSIWYG editor. In the Settings tab, select the column layout. For Left Aligned, an optional Eyebrow field appears.',
            'best_practices' => [
                'Keep titles concise (3–10 words)',
                'Use the Larger title size sparingly (1–2 per page maximum)',
                'Eyebrow text should be 1–3 words (category or label)',
                'Centered layout works best for short impactful statements',
                'Left Aligned works best for longer copy and labeled sections',
                '2 Columns works well for Q&A or breaking up content monotony',
                'Break very long copy across multiple Text modules',
                'Don\'t use Larger title size for every Text module on a page',
            ],
        ],
    ];
}
