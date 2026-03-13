<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class CTABanner extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $cta_banner = new FieldsBuilder('cta_banner');
        $cta_banner
        ->addTab('content')
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
                ->addText('custom_classes')
                ->addText('custom_styles')
                ->addText('background_image_positioning');

        return $cta_banner;
    }
}
