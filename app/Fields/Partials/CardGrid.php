<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class CardGrid extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $card_grid = new FieldsBuilder('card_grid');
        $card_grid->addTrueFalse('background_color', [
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
        ->endGroup();

        return $card_grid;
    }
}
