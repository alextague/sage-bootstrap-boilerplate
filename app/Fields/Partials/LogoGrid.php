<?php

namespace App\Fields\Partials;

use App\Fields\Traits\ModuleDocumentation;
use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class LogoGrid extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $logo_grid = new FieldsBuilder('logo_grid');

        $usageGuide = $this->formatUsageGuide([
            'Title & Copy' => 'Optional heading and introductory text above the logo grid. Use to set context (e.g., "Our Partners", "Proud Sponsors").',
            'Logos Repeater' => [
                'Each entry includes a <strong>URL</strong> (optional — the logo links to this when provided) and a <strong>Logo</strong> image.',
                'Leave the URL blank to display a logo without a link.',
                'Logos with links open in a new tab automatically.',
            ],
            'Logo Image Guidelines' => [
                'Use transparent PNG or SVG files for best results.',
                'Ensure logos have a similar aspect ratio for a consistent grid.',
                'Logos are constrained by CSS — no need to pre-size exactly.',
            ],
        ]);

        $bestPractices = $this->formatBestPracticesList(
            [
                'Use consistent logo file formats (all SVG or all transparent PNG)',
                'Keep logo count reasonable — 4–12 logos is typical',
                'Add a title and copy to provide context for the logos displayed',
                'Test external links to confirm they point to the correct pages',
                'Ensure logos are legible at the grid\'s displayed size',
            ],
            [
                'Don\'t mix transparent and non-transparent logos in the same grid',
                'Avoid logos with wildly different aspect ratios — they create an uneven grid',
                'Don\'t link to homepage URLs — link to the relevant org\'s own site',
            ]
        );

        $logo_grid
        ->addTab('content')
            ->addFields($this->addModuleHelp(
                'Logo Grid',
                'A responsive grid of partner, sponsor, or client logos with optional links.',
                'Use to showcase partners, sponsors, clients, or affiliations. Works well as a trust-building section on home pages, about pages, or event pages.',
                'Add an optional title and copy above the grid, then use the repeater to add each logo with an optional link URL.'
            ))
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addTextarea('copy', [
                'label' => 'Copy',
            ])
            ->addRepeater('logos', [
                'label' => 'Logos',
            ])
            ->addUrl('url', [
                'label' => 'URL',
            ])
            ->addImage('logo', [
                'label' => 'Logo',
                'return_format' => 'id',
                'preview_size' => 'medium',
            ])
            ->endRepeater()
        ->addTab('settings')
            ->addText('ID')
            ->addText('custom_classes', [
                'instructions' => $this->getSpacingInstructions(),
            ])
            ->addText('custom_styles')
            ->addFields($this->addHelpTab(
                'logo-grid',
                $usageGuide,
                $bestPractices
            ));

        return $logo_grid;
    }
}
