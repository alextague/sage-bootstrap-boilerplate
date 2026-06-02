<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class BioGrid extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $bio_grid = new FieldsBuilder('bio_grid');
        $bio_grid->addText('title', [
            'label' => 'Title',
        ])
        ->addRelationship('bios', [
            'label' => 'Bios',
            'post_type' => ['bios'],
            'filters' => [
                0 => 'search',
            ],
            'return_format' => 'id',
        ]);

        return $bio_grid;
    }
}
