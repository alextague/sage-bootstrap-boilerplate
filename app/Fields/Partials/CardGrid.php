<?php

namespace App\Fields\Partials;

use App\Fields\Traits\ModuleDocumentation;
use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class CardGrid extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $card_grid = new FieldsBuilder('card_grid');

        $usageGuide = $this->formatUsageGuide([
            'Background Color' => 'Toggle between White (default) or Blue background for the module section. Blue creates stronger visual contrast against white page backgrounds.',
            'Title & Copy' => 'Optional heading and introductory text for the card grid. Leave blank if the cards are self-explanatory.',
            'Cards Repeater' => [
                'Each card includes a <strong>Link</strong> field (button text and URL) and a <strong>Background Image</strong> displayed as the card\'s visual backdrop.',
                'Add as many cards as needed — the grid adjusts responsively.',
                'Aim for 3–6 cards for the best visual balance.',
            ],
        ]);

        $bestPractices = $this->formatBestPracticesList(
            [
                'Use high-quality images with consistent aspect ratios across all cards',
                'Keep link text short and action-oriented (2–4 words)',
                'Group related items — services, team highlights, portfolio pieces',
                'Aim for 3–6 cards per grid for the best visual balance',
                'Test on mobile to ensure images and text display well',
            ],
            [
                'Don\'t mix portrait and landscape images in the same grid',
                'Avoid 8+ cards — consider splitting into multiple sections',
                'Don\'t use vague link text like "Click Here"',
            ]
        );

        $card_grid
        ->addTab('content')
            ->addFields($this->addModuleHelp(
                'Card Grid',
                'A responsive grid of visual cards with background images and call-to-action links.',
                'Use to showcase services, team highlights, portfolio items, or any content that benefits from a visual card format.',
                'Toggle the background color, add an optional title and copy, then build cards using the repeater — each card needs a link and a background image.'
            ))
            ->addTrueFalse('background_color', [
                'label' => 'Background Color',
                'ui' => 1,
                'ui_on_text' => 'Blue',
                'ui_off_text' => 'White',
            ])
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addTextarea('copy', [
                'label' => 'Copy',
            ])
            ->addRepeater('cards', [
                'label' => 'Cards',
            ])
            ->addLink('link', [
                'label' => 'Link',
            ])
            ->addImage('background_image', [
                'label' => 'Background Image',
                'return_format' => 'id',
                'preview_size' => 'medium',
            ])
            ->endRepeater()
        ->addTab('settings')
            ->addText('ID')
            ->addText('custom_classes', [
                'instructions' => $this->getSpacingInstructions(),
            ])
            ->addText('custom_styles')
            ->addFields($this->addHelpTab(
                'card-grid',
                $usageGuide,
                $bestPractices
            ));

        return $card_grid;
    }
}
