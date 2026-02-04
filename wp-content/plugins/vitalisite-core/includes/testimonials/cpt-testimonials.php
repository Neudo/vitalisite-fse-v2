<?php
function vitalisite_register_testimonials_cpt() {
    $labels = array(
        'name'               => 'Témoignages',
        'singular_name'      => 'Témoignage',
        'menu_name'          => 'Témoignages',
        'name_admin_bar'     => 'Témoignage',
        'add_new'            => 'Ajouter un témoignage',
        'add_new_item'       => 'Ajouter un nouveau témoignage',
        'new_item'           => 'Nouveau témoignage',
        'edit_item'          => 'Modifier le témoignage',
        'view_item'          => 'Voir le témoignage',
        'all_items'          => 'Tous les témoignages',
        'search_items'       => 'Rechercher un témoignage',
        'not_found'          => 'Aucun témoignage trouvé.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-testimonial',
        'supports'           => ['title'],
        'has_archive'        => false,
        'rewrite'            => array('slug' => 'temoignages'),
    );

    register_post_type('testimonials', $args);
}
add_action('init', 'vitalisite_register_testimonials_cpt');
