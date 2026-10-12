<?php

/**
 * Vite WordPress Starter functions.
 *
 * @package ViteWordPressStarter
 */

if (!defined('ABSPATH')) {
    exit();
}

require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/vite-assets.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/taxonomies.php';
require_once get_template_directory() . '/inc/product-filters.php';
require_once get_template_directory() . '/inc/block-helpers.php';
