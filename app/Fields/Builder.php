<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\CardGrid;
use App\Fields\Partials\LogoGrid;
use App\Fields\Partials\ImageText5050;
use App\Fields\Partials\CTABanner;
use App\Fields\Partials\ContactInfo;
use App\Fields\Partials\ContactForm;
use App\Fields\Partials\Accordion;
use App\Fields\Partials\Carousel;

class Builder extends Field
{
    /**
     * The field group.
     *
     * @return array
     */
    public function fields()
    {
        $builder = new FieldsBuilder('page_builder', [
            'hide_on_screen' =>
            [
                'the_content',
                'comments',
                'format',
            ]
        ]);

        $builder
            ->setLocation('post_type', '==', 'page')
            ->and('page_type', '!=', 'posts_page');

        $builder
            ->addFlexibleContent('page_builder', [
                'button_label' => 'Add Module',
            ])
                ->addLayout('card_grid')
                    ->addFields($this->get(CardGrid::class))
                ->addLayout('accordion')
                    ->addFields($this->get(Accordion::class))
                ->addLayout('carousel')
                    ->addFields($this->get(Carousel::class))
                ->addLayout('contact_form')
                    ->addFields($this->get(ContactForm::class))
                ->addLayout('contact_info')
                    ->addFields($this->get(ContactInfo::class))
                ->addLayout('cta_banner')
                    ->addFields($this->get(CTABanner::class))
                ->addLayout('image_text_50_50')
                    ->addFields($this->get(ImageText5050::class))
                ->addLayout('logo_grid')
                    ->addFields($this->get(LogoGrid::class));

        return $builder->build();
    }
}
