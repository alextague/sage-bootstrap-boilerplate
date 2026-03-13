<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class HomepageHeader extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $homepageHeader = new FieldsBuilder('homepage_header');

        $homepageHeader
        ->addText('home_title', [
            'label' => 'Title',
            'conditional_logic' => [
                "field" => "header_type",
                "operator" => "==",
                "value" => "homepage"
            ]
        ])
        ->addTextarea('copy', [
            'conditional_logic' => [
                "field" => "header_type",
                "operator" => "==",
                "value" => "homepage"
            ]
        ])
        ->addText('homepage_featured_image_positioning', [
            'label' => 'Featured Image Position',
            'instructions' => 'CSS object-position values (e.g., "50% 0", "center top", "left center")',
            'default_value' => '50% 50%',
            'conditional_logic' => [
                "field" => "header_type",
                "operator" => "==",
                "value" => "homepage"
            ]
        ]);

        return $homepageHeader;
    }
}
