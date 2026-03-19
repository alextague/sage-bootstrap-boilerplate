<?php

namespace App\Fields\Partials;

use App\Fields\Traits\ModuleDocumentation;
use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class CTABanner extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $cta_banner = new FieldsBuilder('cta_banner');

        $usageGuide = $this->formatUsageGuide([
            'Style Options' => [
                '<strong>Option 1:</strong> Centered single-column with title, copy, and button on a video or image background.',
                '<strong>Option 2:</strong> Two-column layout with eyebrow + title on the left, copy on the right, and a button spanning the bottom.',
                '<strong>Option 3:</strong> Centered script accent text + title on an image background (no button).',
                '<strong>Option 4:</strong> Centered layout with icon, eyebrow, title, copy, and button on an image background.',
            ],
            'Background' => 'Options 1 and 2 support both video and image backgrounds. Toggle the "Video or Image Background" switch to choose. Options 3 and 4 use image backgrounds only.',
            'Background Accents' => 'Options 1 and 3 support left and right decorative accent images layered over the background for visual texture.',
            'Eyebrow Text' => 'Available in Options 2 and 4. A short label (1–3 words) displayed above the title in uppercase styling.',
            'Script Text' => 'Option 3 only. An italicized script-style text displayed alongside the main title for decorative emphasis.',
            'Button' => 'Available in Options 1, 2, and 4. Add a call-to-action link with action-oriented text (e.g., "Apply Now", "Learn More", "Get Started").',
            'Column Classes' => 'In Settings, add CSS classes to the inner content column for fine-tuned layout adjustments.',
            'Background Image Positioning' => 'In Settings, enter a CSS object-position value (e.g., "center top", "left center") to control which part of the background image is in focus.',
        ]);

        $bestPractices = $this->formatBestPracticesList(
            [
                'Keep titles short and action-oriented (3–8 words)',
                'Use high-quality, high-contrast background images or videos',
                'Choose a style that complements the surrounding page sections',
                'Use action verbs in button text ("Apply Now", "Get Started", "Learn More")',
                'Test video backgrounds on mobile — they fall back to images on mobile devices',
                'Use background accents sparingly for decorative detail',
            ],
            [
                'Don\'t place multiple CTA Banners consecutively on the same page',
                'Avoid vague button text like "Click Here" or "Submit"',
                'Don\'t use low-contrast backgrounds that make text unreadable',
                'Avoid very long titles — they lose visual impact',
            ]
        );

        $cta_banner
        ->addTab('content')
            ->addFields($this->addModuleHelp(
                'CTA Banner',
                'A full-width call-to-action banner with four style variations, supporting background video or image and flexible content layouts.',
                'Use to drive user action at strategic points on the page. Choose a style option to match the surrounding design context.',
                'Select a style option, fill in the relevant content fields for that style, then choose a video or image background.'
            ))
            ->addSelect('style_option', [
                'label' => 'Select Banner Style',
                'instructions' => '<strong>Option 1:</strong> Background video or image with an inner content area of centered title, copy, and CTA button in one centered column.<br/>
                    <strong>Option 2:</strong> Video or image background with 2 columns of text, eyebrow text and title on the left and copy on the right with the CTA button spanning the bottom.<br/>
                    <strong>Option 3:</strong> Background image with title and script accent center aligned in 1 column.<br/>
                    <strong>Option 4:</strong> Background image with an icon, eyebrow text, title, copy, and CTA button center aligned in 1 column.',
                'choices' => [
                    "option_1" => "Option 1",
                    "option_2" => "Option 2",
                    "option_3" => "Option 3",
                    "option_4" => "Option 4",
                ],
                'default_value' => ["option_1"],
                'ui' => 1,
                'ajax' => 1,
                'return_format' => 'value',
            ])

            ->addImage('icon', [
                'label' => 'Icon',
            ])
                ->conditional('style_option', '==', 'option_4')

            ->addText('eyebrow_text', [
                'label' => 'Eyebrow Text',
            ])
                ->conditional('style_option', '==', 'option_2')
                    ->or('style_option', '==', 'option_4')

            ->addText('title', [
                'label' => 'Title',
            ])

            ->addTextarea('copy', [
                'label' => 'Copy',
                'new_lines' => 'wpautop'
            ])
                ->conditional('style_option', '==', 'option_1')
                    ->or('style_option', '==', 'option_2')
                    ->or('style_option', '==', 'option_4')

            ->addText('script_text', [
                'label' => 'Script Text',
            ])
                ->conditional('style_option', '==', 'option_3')

            ->addLink('button')
                ->conditional('style_option', '==', 'option_1')
                    ->or('style_option', '==', 'option_2')
                    ->or('style_option', '==', 'option_4')

            ->addImage('background_accent_left', [
                'label' => 'Background Accent Left',
                'return_format' => 'url',
                'wrapper' => [
                    'width' => '50%',
                ],
            ])
                ->conditional('style_option', '==', 'option_1')
                    ->or('style_option', '==', 'option_3')

            ->addImage('background_accent_right', [
                'label' => 'Background Accent Right',
                'return_format' => 'url',
                'wrapper' => [
                    'width' => '50%',
                ],
            ])
                ->conditional('style_option', '==', 'option_1')
                    ->or('style_option', '==', 'option_3')

            ->addTrueFalse('video_or_image', [
                'label' => 'Video or Image Background',
                'wrapper' => [
                    'width' => '50%',
                ],
                'ui' => 1,
                'ui_on_text' => 'Image Background',
                'ui_off_text' => 'Video Background',
            ])
                ->conditional('style_option', '==', 'option_1')
                    ->or('style_option', '==', 'option_2')

            ->addFile('background_video', [
                'label' => 'Upload Video',
                'wrapper' => [
                    'width' => '50%',
                ],
            ])
                ->conditional('video_or_image', '==', '0')

            ->addImage('background_image', [
                'label' => 'Background Image',
                'wrapper' => [
                    'width' => '50%',
                ],
            ])
                ->conditional('video_or_image', '==', '1')
                    ->or('style_option', '==', 'option_3')
                    ->or('style_option', '==', 'option_4')

            ->addTab('settings')
                ->addText('ID')
                ->addText('column_classes')
                ->addText('custom_classes', [
                    'instructions' => $this->getSpacingInstructions(),
                ])
                ->addText('custom_styles')
                ->addText('background_image_positioning')
                ->addFields($this->addHelpTab(
                    'cta-banner',
                    $usageGuide,
                    $bestPractices
                ));

        return $cta_banner;
    }
}
