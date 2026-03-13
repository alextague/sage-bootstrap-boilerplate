<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class StandardHeader extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.headers.standard-header'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        if (is_home() || is_post_type_archive()) {
            return [
                'is_archive' => true,
                'standard_title' => get_field('archive_title', 'option'),
                'image_id' => get_field('archive_header_image', 'option'),
                'featured_image_positioning' => get_field('archive_image_positioning', 'option'),
            ];
        } elseif (is_single()) {
            return [
                'is_archive' => false,
                'standard_title' => get_field('archive_title', 'option'),
                'post_id' => get_the_ID(),
                'featured_image_positioning' => get_field('post_featured_image_positioning'),
            ];
        } elseif (is_404()) {
            return [
                'is_archive' => false,
                'standard_title' => 'Page Not Found',
                'post_id' => null,
                'featured_image_positioning' => null,
            ];
        } else {
            return [
                'is_archive' => false,
                'standard_title' => get_field('standard_title') ?: get_the_title(),
                'post_id' => get_the_ID(),
                'featured_image_positioning' => get_field('standard_featured_image_positioning'),
            ];
        }
    }
}
