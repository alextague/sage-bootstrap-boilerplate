<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Move Yoast SEO metabox to the bottom of the edit screen.
 */
add_filter('wpseo_metabox_prio', function () {
    return 'low';
});

/**
 * Adds {module-name}-js classes to the body tag if an associated js file exists in resources/scripts/modules.
 * This allows us to use dynamic js routing for each module.
 * No need to import by hand, just make sure the file name matches the ACF FC Layout slug (with dashes instead of underscores).
 *
 * @return array The filtered body classes.
 */
add_filter('body_class', function ($classes) {

    if (have_rows('page_builder')) {
        $page_builder = get_field('page_builder');

        foreach ($page_builder as $module) {
            if (file_exists(get_stylesheet_directory()."/resources/js/modules/".str_replace('_', '-', $module['acf_fc_layout']).".js")) {
                $classes[] = str_replace('_', '-', $module['acf_fc_layout'])."-js";
            }
        }
    }

    return $classes;
});
