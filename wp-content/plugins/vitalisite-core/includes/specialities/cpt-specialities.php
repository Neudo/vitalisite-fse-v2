<?php
// Bloquer l'accès direct
if (!defined('ABSPATH')) {
    exit;
}


function vitalisite_register_specialities_cpt() {
    $labels = [
        'name' => 'Spécialités',
        'singular_name' => 'Spécialité',
        'add_new' => 'Ajouter une spécialité',
        'add_new_item' => 'Ajouter une nouvelle spécialité',
        'edit_item' => 'Modifier la spécialité',
        'new_item' => 'Nouvelle spécialité',
        'view_item' => 'Voir la spécialité',
        'all_items' => 'Tous les spécialités',
        'search_items' => 'Rechercher une spécialité',
        'not_found' => 'Aucune spécialité trouvé',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title'],
        'show_in_rest' => true,
        'rewrite'            => array('slug' => 'specialites'),
    ];

    register_post_type('specialities', $args);
}
add_action('init', 'vitalisite_register_specialities_cpt');

function add_elementor_support_for_specialites() {
    add_post_type_support('specialities', 'elementor');
}
add_action('init', 'add_elementor_support_for_specialites', 20);

