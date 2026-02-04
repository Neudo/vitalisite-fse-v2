<?php
// Bloquer l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

function vitalisite_register_doctors_cpt() {
    $labels = [
        'name' => 'Docteur(s)',
        'singular_name' => 'Docteur',
        'add_new' => 'Ajouter un docteur',
        'add_new_item' => 'Ajouter un nouveau docteur',
        'edit_item' => 'Modifier le docteur',
        'new_item' => 'Nouveau docteur',
        'view_item' => 'Voir le docteur',
        'all_items' => 'Tous les docteurs',
        'search_items' => 'Rechercher un docteur',
        'not_found' => 'Aucun docteur trouvé',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-id',
        'supports' => ['title'],
        'show_in_rest' => true,
        'rewrite'            => array('slug' => 'docteurs'),
    ];

    register_post_type('doctors', $args);
}
add_action('init', 'vitalisite_register_doctors_cpt');
