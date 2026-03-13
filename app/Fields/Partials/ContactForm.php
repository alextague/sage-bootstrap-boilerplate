<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ContactForm extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $contact_form = new FieldsBuilder('contact_form');
        $contact_form
            ->addField('form', 'acf_cf7')

            ->addImage('background_image');

        return $contact_form;
    }
}
