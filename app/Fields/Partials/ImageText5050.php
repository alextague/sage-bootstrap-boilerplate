<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ImageText5050 extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $image_text_50_50 = new FieldsBuilder('image_text_50_50');

        $image_text_50_50
        ->addTab('settings')
            ->addTrueFalse('image_side', [
                'ui' => 1,
                'ui_on_text' => 'Left',
                'ui_off_text' => 'Right',
            ])

        ->addTab('content')
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

            ->addImage('image')

            ->addText('eyebrow_text')
                ->conditional('style_option', '==', 'option_1')

            ->addText('title')

            ->addWysiwyg('copy')

            ->addLink('button')
                ->conditional('style_option', '==', 'option_1');

        return $image_text_50_50;
    }
}
