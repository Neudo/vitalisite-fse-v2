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
    add_editor_style(array(
        'style.css',
        'assets/styles/header.css',
        'assets/styles/hero.css',
    ));
    // Hide core block patterns to keep the inserter focused on theme patterns.
    remove_theme_support('core-block-patterns');
});

// Disable remote patterns from the WordPress.org pattern directory.
add_filter('should_load_remote_block_patterns', '__return_false');

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'vitalisite-fse',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_style(
        'vitalisite-fse-header',
        get_template_directory_uri() . '/assets/styles/header.css',
        array('vitalisite-fse'),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_style(
        'vitalisite-fse-hero',
        get_template_directory_uri() . '/assets/styles/hero.css',
        array('vitalisite-fse'),
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
        'vitalisite-header',
        array('label' => __('Header Vitalisite', 'vitalisite-fse'))
    );
    register_block_pattern_category(
        'vitalisite-footer',
        array('label' => __('Footer Vitalisite', 'vitalisite-fse'))
    );
    register_block_pattern_category(
        'banniere-vitalisite',
        array('label' => __('Bannière Vitalisite', 'vitalisite-fse'))
    );
    register_block_pattern_category(
        'vitalisite',
        array('label' => __('Vitalisite', 'vitalisite-fse'))
    );
});

add_action('init', function () {
    $allowed_categories = array(
        'vitalisite',
        'banniere-vitalisite',
        'vitalisite-header',
        'vitalisite-footer',
    );

    if (class_exists('WP_Block_Pattern_Categories_Registry')) {
        $categories_registry = WP_Block_Pattern_Categories_Registry::get_instance();
        foreach ($categories_registry->get_all_registered() as $category) {
            if (!in_array($category['name'], $allowed_categories, true)) {
                $categories_registry->unregister($category['name']);
            }
        }
    }

    if (class_exists('WP_Block_Patterns_Registry')) {
        $patterns_registry = WP_Block_Patterns_Registry::get_instance();
        foreach ($patterns_registry->get_all_registered() as $pattern) {
            $pattern_name = isset($pattern['name']) ? $pattern['name'] : '';
            $pattern_categories = isset($pattern['categories']) ? $pattern['categories'] : array();
            $has_allowed_category = array_intersect($pattern_categories, $allowed_categories);
            $is_theme_pattern = str_starts_with($pattern_name, 'vitalisite-fse/');
            if (!$is_theme_pattern && empty($has_allowed_category)) {
                $patterns_registry->unregister($pattern_name);
            }
        }
    }
}, 100);
