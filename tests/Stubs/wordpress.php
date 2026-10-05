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
