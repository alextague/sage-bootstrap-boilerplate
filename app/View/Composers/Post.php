<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.headers.header-single',
        'partials.content',
        'partials.content-*',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        return [
            'title'                      => $this->title(),
            'post_id'                    => get_the_ID(),
            'category'                   => $this->category(),
            'featured_image_positioning' => get_field('post_featured_image_positioning'),
            'previous_post'              => get_previous_post(),
            'next_post'                  => get_next_post(),
        ];
    }

    /**
     * Returns the Yoast primary category for the post, falling back to the first category.
     *
     * @return string|null
     */
    public function category()
    {
        $categories = get_the_category();
        if (empty($categories)) {
            return null;
        }

        $primary_term_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true);
        if ($primary_term_id) {
            $primary_term = get_term($primary_term_id, 'category');
            if ($primary_term && ! is_wp_error($primary_term)) {
                return $primary_term->name;
            }
        }

        return $categories[0]->name;
    }

    /**
     * Returns the post title.
     *
     * @return string
     */
    public function title()
    {
        if ($this->view->name() !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'sage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }
}
