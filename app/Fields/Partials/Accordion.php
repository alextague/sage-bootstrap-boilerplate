<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Traits\ModuleDocumentation;

class Accordion extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     *
     * @return \StoutLogic\AcfBuilder\FieldsBuilder
     */
    public function fields()
    {
        $accordion = new FieldsBuilder('accordion');

        // Define documentation content
        $usageGuide = $this->formatUsageGuide([
            'Accordion Items' => [
                'Add multiple collapsible sections using the repeater',
                '<strong>Title:</strong> The clickable header text for each panel',
                '<strong>Content:</strong> Rich text content that expands when clicked (supports text, images, lists)',
            ],
            'Expand First Panel by Default' => 'When enabled, the first accordion item will be open when the page loads.',
            'Allow Multiple Panels Open' => 'When disabled, opening a panel automatically closes any other open panels (recommended for cleaner UX).',
            'Background Style' => [
                '<strong>No Background:</strong> Accordion displays on page background',
                '<strong>Light Gray Background:</strong> Adds subtle gray background to entire accordion section',
            ],
        ]);

        $bestPractices = $this->formatBestPracticesList(
            [
                'Keep accordion titles concise and descriptive (5-10 words)',
                'Use accordions for FAQ sections or content that users want to skim',
                'Aim for 3-8 accordion items for optimal usability',
                'Place most important or frequently accessed content in first panels',
                'Use consistent formatting within accordion content',
            ],
            [
                'Avoid nesting accordions within accordions',
                'Don\'t hide critical information that all users need to see',
                'Very long content may be better suited to a separate page',
            ]
        );

        $accordion
            ->addTab('content')
                ->addFields($this->addModuleHelp(
                    'Accordion',
                    'Collapsible panels for organizing content into expandable sections.',
                    'Best for FAQs, program requirements, location eligibility info, or any content users want to scan and selectively read.',
                    'Add accordion items with titles and content. Configure expansion behavior in Settings tab.'
                ))
                ->addRepeater('accordion_items', [
                    'button_label' => 'Add Accordion Item',
                    'layout' => 'block',
                ])
                    ->addText('title', [
                        'label' => 'Accordion Title',
                        'required' => 1,
                    ])
                    ->addWysiwyg('content', [
                        'label' => 'Content',
                        'media_upload' => 1,
                        'required' => 1,
                    ])
                ->endRepeater()
            ->addTab('settings')
                ->addTrueFalse('expand_first_panel', [
                    'label' => 'Expand First Panel by Default',
                    'default_value' => 0,
                    'ui' => 1,
                ])
                ->addTrueFalse('allow_multiple_open', [
                    'label' => 'Allow Multiple Panels Open',
                    'message' => 'When disabled, opening one panel will close others',
                    'default_value' => 0,
                    'ui' => 1,
                ])
                ->addSelect('background_style', [
                    'label' => 'Background Style',
                    'choices' => [
                        'none' => 'No Background',
                        'light-gray' => 'Light Gray Background',
                    ],
                    'default_value' => 'none',
                ])
                ->addText('ID', [
                    'label' => 'ID',
                    'instructions' => 'HTML ID attribute for anchor links',
                ])
                ->addText('custom_classes', [
                    'label' => 'Custom Classes',
                    'instructions' => $this->getSpacingInstructions(),
                ])
                ->addText('custom_styles', [
                    'label' => 'Custom Styles',
                    'instructions' => 'Inline CSS styles',
                ])
            ->addFields($this->addHelpTab(
                'accordion',
                $usageGuide,
                $bestPractices
            ));

        return $accordion;
    }
}
