<?php

/**
 * Vitalisite FSE theme setup.
 */
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
    register_block_pattern_category(
        'banniere-vitalisite',
        array('label' => __('Bannière Vitalisite', 'vitalisite-fse'))
    );
    register_block_pattern_category(
        'vitalisite',
        array('label' => __('Vitalisite', 'vitalisite-fse'))
    );
});
