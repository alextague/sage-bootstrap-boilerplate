<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class HomeHeader extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.headers.home-header'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'home_title' => get_field('home_title'),
            'copy' => get_field('copy'),
            'featured_image_positioning' => get_field('homepage_featured_image_positioning'),
            'post_id' => get_the_ID(),
        ];
    }
}
