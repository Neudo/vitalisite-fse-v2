<?php
// Bloquer l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue public-facing scripts and styles.
 */
function vitalisite_enqueue_public_scripts() {
    // Ajouter un fichier CSS pour le front-end (public)
    wp_enqueue_style(
        'vitalisite-public-style',
        plugin_dir_url(__FILE__) . '../assets/css/public-style.css',
        [],
        '1.0'
    );

    // Ajouter un fichier JavaScript pour le front-end
    wp_enqueue_script(
        'vitalisite-public-script',
        plugin_dir_url(__FILE__) . '../assets/js/public-script.js',
        ['jquery'],
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'vitalisite_enqueue_public_scripts');

/**
 * Enqueue admin-specific scripts and styles.
 */
function vitalisite_enqueue_admin_scripts() {
    // Ajouter un fichier CSS pour le tableau de bord (admin)
    wp_enqueue_style(
        'vitalisite-admin-style',
        plugin_dir_url(__FILE__) . '../assets/css/admin-style.css',
        [],
        '1.0'
    );

    // Ajouter un fichier JavaScript pour le tableau de bord
    wp_enqueue_script(
        'vitalisite-admin-script',
        plugin_dir_url(__FILE__) . '../assets/js/admin-script.js',
        ['jquery'],
        '1.0',
        true
    );
}
add_action('admin_enqueue_scripts', 'vitalisite_enqueue_admin_scripts');

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_media(); // Charge l'API Media Uploader
    wp_enqueue_script('meta-box', plugin_dir_url(__FILE__) . '../assets/js/meta-box.js', ['jquery'], null, true);
    wp_enqueue_style('meta-box-style', plugin_dir_url(__FILE__) . '../assets/css/meta-box.css');
});
