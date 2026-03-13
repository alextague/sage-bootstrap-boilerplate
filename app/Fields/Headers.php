<?php

namespace App\Fields;

use App\Fields\Partials\StandardHeader;
use App\Fields\Partials\HomepageHeader;
use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Headers extends Field
{
    /**
     * The field group.
     *
     * @return array
     */
    public function fields()
    {
        $headers = new FieldsBuilder('headers', [
            'hide_on_screen' =>
            [
                'the_content',
                'comments',
                'format',
            ]
        ]);

        $headers
            ->setLocation('post_type', '==', 'page')
            ->and('page_type', '!=', 'posts_page');

        $headers->addSelect('header_type', [
            'label' => 'Header Type',
            'choices' => [
                "homepage" => "Homepage",
                "standard" => "Standard Page",
            ],
            'default_value' => 'standard',
        ])
        ->addFields($this->get(HomepageHeader::class))
        ->addFields($this->get(StandardHeader::class));

        return $headers->build();
    }
}
