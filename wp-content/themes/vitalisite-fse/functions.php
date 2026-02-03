<?php

/**
 * Vitalisite FSE theme setup.
 */
function vitalisite_is_dev_mode() {
    if (defined('VITALISITE_DEV_MODE') && VITALISITE_DEV_MODE) {
        return true;
    }
    if (function_exists('wp_get_environment_type')) {
        return wp_get_environment_type() === 'local';
    }
    return false;
}

add_action('after_setup_theme', function () {
    add_editor_style('style.css');
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'vitalisite-fse',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme()->get('Version')
    );
});

add_action('init', function () {
    if (vitalisite_is_dev_mode()) {
        if (function_exists('wp_clean_themes_cache')) {
            // Clear theme and pattern caches in local dev to reflect file changes.
            wp_clean_themes_cache(false);
        }
        if (class_exists('WP_Theme_JSON_Resolver')) {
            WP_Theme_JSON_Resolver::clean_cached_data();
        }
    }
    register_block_pattern_category(
        'banniere-vitalisite',
        array('label' => __('Bannière Vitalisite', 'vitalisite-fse'))
    );
    register_block_pattern_category(
        'vitalisite',
        array('label' => __('Vitalisite', 'vitalisite-fse'))
    );
});
