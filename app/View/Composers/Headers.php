<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Headers extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
       'partials.page-header',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'header_type' => get_field('header_type'),
        ];
    }
}
