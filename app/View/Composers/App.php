<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'siteName' => $this->siteName(),
        ];
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }

    public static function title()
    {
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
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }


    //------------------------------------------------//
    //-------- PARENT/CHILD WP_NAV_MENU ARRAY --------//
    //------------------------------------------------//
    // Creates multidimensional array of wp_nav_menu
    // Good for building navigation, dropdown menus, etc etc

    public static function buildTree(array &$elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as &$element) {
            if ($element->menu_item_parent == $parentId) {

                $children = buildTree( $elements, $element->ID );
                if ($children) {
                    $element->children = $children;
                }

                $branch[$element->ID] = $element;
                unset($element);

            }
        }
        return $branch;

    }


    //------------------------------------------------//
    //------------- GET YOAST META BY ID -------------//
    //------------------------------------------------//
    // Gets Yoast meta by ID
    // Good for post sharing social media icons

    public static function yoastMeta($id = null)
    {
        $data = [];
        $meta = get_post_meta($id);

        if ($meta) {
            // This function also gets Facebook meta
            // Facebook scrapes the data on their own so no need to return it

            // Twitter
            $twitter_meta_title = $meta['_yoast_wpseo_twitter-title'][0] ?? '';
            $twitter_meta_description = $meta['_yoast_wpseo_twitter-description'][0] ?? '';
            $twitter_meta_image = $meta['_yoast_wpseo_twitter-image'][0] ?? '';

            array_push($data, array('twitter_title' => $twitter_meta_title, 'twitter_description' => $twitter_meta_description, 'twitter_image' => $twitter_meta_image));
        }

        return $data;
    }
}
