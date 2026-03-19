<?php

namespace App\Fields\Partials;

use App\Fields\Traits\ModuleDocumentation;
use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ContactForm extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $contact_form = new FieldsBuilder('contact_form');

        $usageGuide = $this->formatUsageGuide([
            'Form Selection' => 'Choose any Contact Form 7 form from the dropdown. Create and configure your form in the CF7 plugin settings before adding this module.',
            'Background Image' => 'Optional decorative image displayed behind or alongside the form. Use a high-quality image that doesn\'t compete visually with the form fields.',
            'Prerequisites' => 'The <strong>Contact Form 7</strong> plugin must be installed and activated. Configure form fields, mail settings, and confirmation messages in CF7 before using this module.',
        ]);

        $bestPractices = $this->formatBestPracticesList(
            [
                'Test form submission after placing it on a page',
                'Configure CF7 mail settings and confirmation messages before going live',
                'Set an HTML ID (e.g., "contact") for anchor links from CTAs',
                'Use the Custom Classes field to control vertical spacing',
                'Keep forms short — ask only for essential information',
            ],
            [
                'Don\'t add the module without first creating a CF7 form',
                'Avoid placing multiple contact forms on the same page',
                'Don\'t use background images that are too busy — they distract from the form',
            ]
        );

        $contact_form
            ->addTab('content')
                ->addFields($this->addModuleHelp(
                    'Contact Form',
                    'Embeds a Contact Form 7 form with an optional background image in a styled full-width layout.',
                    'Use on contact pages or landing pages to collect user inquiries. Requires Contact Form 7 to be installed and configured.',
                    'Select a Contact Form 7 form from the dropdown, then optionally upload a background image for visual interest.'
                ))
                ->addField('form', 'acf_cf7')
                ->addImage('background_image')
            ->addTab('settings')
                ->addText('ID')
                ->addText('custom_classes', [
                    'instructions' => $this->getSpacingInstructions(),
                ])
                ->addText('custom_styles')
                ->addFields($this->addHelpTab(
                    'contact-form',
                    $usageGuide,
                    $bestPractices
                ));

        return $contact_form;
    }
}
