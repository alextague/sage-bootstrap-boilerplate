<?php

namespace App\Fields\Partials;

use App\Fields\Traits\ModuleDocumentation;
use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ContactInfo extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $contact_info = new FieldsBuilder('contact_info');

        $usageGuide = $this->formatUsageGuide([
            'Contact Fields' => [
                'All contact fields are optional — only fill in the ones relevant to your business.',
                '<strong>Email:</strong> Enter the raw address — it will be wrapped in a mailto: link automatically.',
                '<strong>Phone Number:</strong> Enter in a readable format (e.g., (555) 123-4567) — it will be wrapped in a tel: link automatically.',
                '<strong>Google Link:</strong> Use the "Share" option in Google Maps to get the correct shareable URL.',
                '<strong>Website:</strong> Use the Link field to control both the URL and displayed link text.',
            ],
            'Title & Copy' => 'Add a section heading and WYSIWYG body copy to introduce or provide context for the contact details displayed.',
        ]);

        $bestPractices = $this->formatBestPracticesList(
            [
                'Provide the most critical contact method for your business',
                'Test email and phone links on a mobile device after publishing',
                'Use the Google Link field to make your address directly clickable on maps',
                'Keep copy concise — this module is for quick reference',
                'Verify all links and contact details are current before publishing',
            ],
            [
                'Don\'t enter email addresses in plain text — use the Email field for proper link wrapping',
                'Avoid long explanatory copy — use the Text or Freeform Content module for that',
            ]
        );

        $contact_info
        ->addTab('content')
            ->addFields($this->addModuleHelp(
                'Contact Info',
                'Displays business contact details — name, website, email, phone, and Google Maps link — alongside a section title and body copy.',
                'Use on contact pages or location sections where providing direct contact details alongside an introduction is needed.',
                'Fill in the contact fields that apply to your business (all are optional), then add a title and copy for context.'
            ))
            ->addText('business_name', [
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
            ])
        ->addTab('settings')
            ->addText('ID')
            ->addText('custom_classes', [
                'instructions' => $this->getSpacingInstructions(),
            ])
            ->addText('custom_styles')
            ->addFields($this->addHelpTab(
                'contact-info',
                $usageGuide,
                $bestPractices
            ));

        return $contact_info;
    }
}
