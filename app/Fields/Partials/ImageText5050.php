<?php

namespace App\Fields\Partials;

use App\Fields\Traits\ModuleDocumentation;
use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ImageText5050 extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $image_text_50_50 = new FieldsBuilder('image_text_50_50');

        $usageGuide = $this->formatUsageGuide([
            'Style Options' => [
                '<strong>Option 1:</strong> Standard split layout with optional eyebrow text, title, WYSIWYG copy, and a button. Supports toggling image left or right.',
                '<strong>Option 2:</strong> Styled to match blog post card designs. Includes title and copy only (no eyebrow or button).',
            ],
            'Image Side' => 'Toggle between <strong>Left</strong> (image on left, text on right) and <strong>Right</strong> (image on right, text on left). Alternate sides when stacking multiple instances for visual rhythm.',
            'Eyebrow Text' => 'Option 1 only. A short label (1–3 words) displayed above the title in uppercase styling. Use for categorization or section labeling.',
            'Button' => 'Option 1 only. Add an optional call-to-action link below the copy. Use action-oriented text ("Learn More", "View Project", "Get Started").',
            'Copy' => 'Supports WYSIWYG formatting in both options. Keep copy moderate in length — the 50/50 layout works best when neither column overwhelms the other.',
        ]);

        $bestPractices = $this->formatBestPracticesList(
            [
                'Alternate image sides when stacking multiple instances on the same page',
                'Use high-quality, appropriately cropped images',
                'Keep copy concise — the split layout works best with moderate text',
                'Use eyebrow text for categorization (1–3 words)',
                'Use clear, action-oriented button labels',
                'Test the stacked mobile layout to ensure proper content order',
            ],
            [
                'Don\'t place the same image side on multiple consecutive instances',
                'Avoid very long copy that overwhelms the image column',
                'Don\'t use small or low-resolution images — they scale to 50% viewport width',
            ]
        );

        $image_text_50_50
        ->addTab('content')
            ->addFields($this->addModuleHelp(
                'Image & Text 50/50',
                'A two-column split-screen layout with an image on one side and text content on the other, with two style variations.',
                'Use to pair a visual with descriptive copy — for services, team bios, features, or any content that benefits from an image alongside text.',
                'Select a style, toggle the image side (left or right), upload an image, then fill in the title and copy. For Option 1, add optional eyebrow text and a button.'
            ))
            ->addSelect('style_option', [
                'label' => 'Select Module Style',
                'instructions' => '<strong>Option 1:</strong> Simple image and text layout with options to switch layout sides and optional elements.<br/>
                    <strong>Option 2:</strong> Styled to look the blog post cards.',
                'choices' => [
                    "option_1" => "Option 1",
                    "option_2" => "Option 2",
                ],
                'default_value' => ["option_1"],
                'ui' => 1,
                'ajax' => 1,
                'return_format' => 'value',
            ])

            ->addTrueFalse('image_side', [
                'ui' => 1,
                'ui_on_text' => 'Left',
                'ui_off_text' => 'Right',
            ])

            ->addImage('image')

            ->addText('eyebrow_text')
                ->conditional('style_option', '==', 'option_1')

            ->addText('title')

            ->addWysiwyg('copy')

            ->addLink('button')
                ->conditional('style_option', '==', 'option_1')

        ->addTab('settings')
            ->addText('ID')
            ->addText('custom_classes', [
                'instructions' => $this->getSpacingInstructions(),
            ])
            ->addText('custom_styles')
            ->addFields($this->addHelpTab(
                'image-text-50-50',
                $usageGuide,
                $bestPractices
            ));

        return $image_text_50_50;
    }
}
