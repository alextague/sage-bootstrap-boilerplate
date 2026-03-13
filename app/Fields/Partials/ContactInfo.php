<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ContactInfo extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $contact_info = new FieldsBuilder('contact_info');
        $contact_info->addText('business_name', [
            'label' => 'Business Name',
        ])
        ->addLink('website', [
            'label' => 'Website',
        ])
        ->addText('email', [
            'label' => 'Email',
        ])
        ->addText('phone_number', [
            'label' => 'Phone Number',
        ])
        ->addLink('google_link', [
            'label' => 'Google Link',
        ])
        ->addText('title', [
            'label' => 'Title'
        ])
        ->addWysiwyg('copy', [
            'label' => 'Copy'
        ]);

        return $contact_info;
    }
}
