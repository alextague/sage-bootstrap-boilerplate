<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class LogoGrid extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $logo_grid = new FieldsBuilder('logo_grid');
        $logo_grid->addText('title', [
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
        ->endRepeater();

        return $logo_grid;
    }
}
