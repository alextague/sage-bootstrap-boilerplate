<?php

/**
 * Minimal WordPress function stubs for unit testing theme classes outside of WordPress.
 *
 * Set $GLOBALS['wp_stubs'] in a test to control what each stub returns.
 */
if (! function_exists('get_post_thumbnail_id')) {
    function get_post_thumbnail_id($post = null)
    {
        return $GLOBALS['wp_stubs']['thumbnail_id'] ?? 0;
    }
}

if (! function_exists('wp_get_attachment_image_src')) {
    function wp_get_attachment_image_src($attachment_id, $size = 'thumbnail')
    {
        return $GLOBALS['wp_stubs']['image_src'] ?? false;
    }
}

if (! function_exists('wp_get_attachment_image_srcset')) {
    function wp_get_attachment_image_srcset($attachment_id, $size = 'medium', $image_meta = null)
    {
        return $GLOBALS['wp_stubs']['srcset'] ?? false;
    }
}

if (! function_exists('get_post')) {
    function get_post($post = null)
    {
        return (object) ['post_title' => $GLOBALS['wp_stubs']['post_title'] ?? ''];
    }
}

if (! function_exists('get_post_meta')) {
    function get_post_meta($post_id, $key = '', $single = false)
    {
        return $GLOBALS['wp_stubs']['alt'] ?? '';
    }
}

if (! function_exists('has_nav_menu')) {
    function has_nav_menu($location)
    {
        return $GLOBALS['wp_stubs']['has_nav_menu'] ?? false;
    }
}

if (! function_exists('wp_nav_menu')) {
    // Records the arguments it was called with in $GLOBALS['wp_stubs']['wp_nav_menu_args']
    function wp_nav_menu($args = [])
    {
        $GLOBALS['wp_stubs']['wp_nav_menu_args'] = $args;

        if (($args['echo'] ?? true) !== false) {
            echo '<ul></ul>';

            return null;
        }

        return '<ul class="'.$args['menu_class'].'"></ul>';
    }
}

if (! function_exists('get_post_type')) {
    function get_post_type($post = null)
    {
        return $GLOBALS['wp_stubs']['post_type'] ?? 'page';
    }
}

if (! function_exists('get_post_types')) {
    function get_post_types($args = [], $output = 'names', $operator = 'and')
    {
        return [];
    }
}

if (! function_exists('get_post_type_archive_link')) {
    function get_post_type_archive_link($post_type)
    {
        return false;
    }
}

if (! function_exists('is_search')) {
    function is_search()
    {
        return false;
    }
}

if (! class_exists('Walker_Nav_Menu')) {
    class Walker_Nav_Menu {}
}
