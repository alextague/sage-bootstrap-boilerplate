<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Traits\ModuleDocumentation;

class Carousel extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     *
     * @return \StoutLogic\AcfBuilder\FieldsBuilder
     */
    public function fields()
    {
        $carousel = new FieldsBuilder('carousel');

        // Define documentation content
        $usageGuide = $this->formatUsageGuide([
            'Title' => 'Optional heading above the carousel.',
            'Variation Options' => [
                '<strong>Logos:</strong> Displays logos in a continuous scrolling carousel (great for partners, sponsors, clients)',
                '<strong>Gallery Images:</strong> Displays full-color images in a slideshow with navigation arrows and optional CTA button',
            ],
            'Button' => 'Only available for Gallery Images variation - add an optional call-to-action button below the carousel.',
            'Images' => [
                'Upload multiple images using the gallery field',
                '<strong>Logos variation:</strong> Use transparent PNG logos on white background, consistent sizing recommended',
                '<strong>Gallery variation:</strong> Use high-quality images (1200x800px minimum), landscape orientation works best',
                'Minimum 3-4 images recommended for smooth carousel effect',
            ],
        ]);

        $bestPractices = $this->formatBestPracticesList(
            [
                'Use Logos variation for partner/sponsor showcases',
                'Use Gallery variation for photo highlights, testimonial imagery, or event galleries',
                'Aim for 4-8 images for optimal carousel experience',
                'Keep logo sizes consistent for professional appearance',
                'Use high-resolution images that look good at large sizes',
                'Gallery images should have similar aspect ratios for consistent display',
            ],
            [
                'Avoid mixing logo and full-color images in the same carousel',
                'Don\'t use fewer than 3 images - static display may be better',
                'Avoid low-resolution or pixelated logos',
                'Gallery images with wildly different aspect ratios may not display well',
            ]
        );

        // Custom help tab with multiple screenshots
        $template_uri = get_template_directory_uri();
        $customHelpTab = new FieldsBuilder('help_tab_wrapper');

        $customHelpTab->addTab('help', [
            'placement' => 'left',
        ])
        ->addMessage('design_reference', 'message', [
            'label' => '🎨 Carousel Variations',
            'message' => "
                <div class=\"acf-module-help-detail\">
                    <h4>Logos Variation</h4>
                    <p>Continuous scrolling carousel of logos - perfect for partners, sponsors, or clients.</p>
                    <img src=\"{$template_uri}/resources/images/admin/module-screenshots/carousel-logos.png?v=" . time() . "\" alt=\"Logos Carousel\" style=\"max-width:100%; height:auto; border:1px solid #ddd; border-radius:4px; margin:10px 0 20px 0;\">

                    <h4>Gallery Images Variation</h4>
                    <p>Slideshow carousel with navigation arrows and optional CTA button.</p>
                    <img src=\"{$template_uri}/resources/images/admin/module-screenshots/carousel-gallery-images.png?v=" . time() . "\" alt=\"Gallery Carousel\" style=\"max-width:100%; height:auto; border:1px solid #ddd; border-radius:4px; margin:10px 0;\">
                </div>
            ",
            'esc_html' => 0,
        ])
        ->addMessage('usage_guide', 'message', [
            'label' => '📋 Detailed Usage Guide',
            'message' => "
                <div class=\"acf-module-help-detail\">
                    {$usageGuide}
                </div>
            ",
            'esc_html' => 0,
        ])
        ->addMessage('best_practices', 'message', [
            'label' => '💡 Best Practices',
            'message' => "
                <div class=\"acf-module-help-detail\">
                    {$bestPractices}
                </div>
            ",
            'esc_html' => 0,
        ]);

        $carousel
            ->addTab('content')
                ->addFields($this->addModuleHelp(
                    'Carousel',
                    'Auto-scrolling image carousel with two variations: continuous logo display or navigable gallery slideshow.',
                    'Use Logos variation for partner/sponsor showcases. Use Gallery variation for photo highlights, event galleries, or visual storytelling.',
                    'Add a title, select variation (Logos or Gallery), upload images, and optionally add a button for Gallery variation.'
                ))
                ->addText('title')
                ->addSelect('variation', [
                    'label' => 'Variation',
                    'choices' => [
                        'logos' => 'Logos',
                        'gallery' => 'Gallery Images',
                    ],
                    'default_value' => 'logos',
                ])
                ->addLink('button', [
                    'label' => 'Button (Optional)',
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'variation',
                                'operator' => '==',
                                'value' => 'gallery',
                            ],
                        ],
                    ],
                ])
                ->addGallery('logos', [
                    'label' => 'Images',
                    'min' => 1,
                ])
            ->addTab('settings')
                ->addText('ID')
                ->addText('custom_classes', [
                    'instructions' => $this->getSpacingInstructions(),
                ])
                ->addText('custom_styles')
            ->addFields($customHelpTab);

        return $carousel;
    }
}
