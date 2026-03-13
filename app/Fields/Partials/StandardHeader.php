<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class StandardHeader extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $standardHeader = new FieldsBuilder('standard_header');

        $standardHeader->addText('standard_title', [
            'conditional_logic' => [
                "field" => "header_type",
                "operator" => "==",
                "value" => "standard"
            ]
        ])
        ->addText('standard_featured_image_positioning', [
            'label' => 'Featured Image Position',
            'instructions' => 'CSS object-position values (e.g., "50% 0", "center top", "left center")',
            'default_value' => '50% 50%',
            'conditional_logic' => [
                "field" => "header_type",
                "operator" => "==",
                "value" => "standard"
            ]
        ]);

        return $standardHeader;
    }
}
