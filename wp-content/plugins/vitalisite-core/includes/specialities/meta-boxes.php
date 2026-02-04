<?php
if (!defined('ABSPATH')) {
    exit;
}

function vitalisite_add_specialities_meta_boxes() {
    add_meta_box(
        'details_meta', // ID unique de la meta box
        'Détails de la spécialité',  // Titre de la meta box
        'vitalisite_render_specialities_meta_box', // Fonction de rendu
        'specialities', // Post type cible
        'normal', // Contexte (normal, side, advanced)
        'high' // Priorité
    );
}
add_action('add_meta_boxes', 'vitalisite_add_specialities_meta_boxes');


add_action('save_post', function ($post_id) {
    if (array_key_exists('speciality_photo', $_POST)) {
        update_post_meta($post_id, 'speciality_photo', sanitize_text_field($_POST['speciality_photo']));
    }
});


/**
 * Rendu du contenu de la meta box.
 */
function vitalisite_render_specialities_meta_box($post) {
    // Récupérer les données sauvegardées
    $description = get_post_meta($post->ID, '_speciality_description', true);
    $photo = get_post_meta($post->ID, '_speciality_photo', true);
    $image_url = $photo ? wp_get_attachment_image_src($photo, 'thumbnail')[0] : '';

    echo '<div class="wrapper">';

    // Champ pour la photo
    echo '<div class="form-group image">';
    echo '<label for="speciality_photo">Image de présentation :</label>';
    echo '<img id="photo_preview" src="' . esc_attr($image_url) . '" style="max-width:150px; max-height:150px; display:' . ($image_url ? 'block' : 'none') . ';">';
    echo '<input type="hidden" id="photo" name="speciality_photo" value="' . esc_attr($photo) . '">';
    echo '<button type="button" class="button" id="photo_button">Ajouter une image</button>';
    echo '<button type="button" class="button" id="photo_remove" style="display:' . ($photo ? 'inline-block' : 'none') . ';">Supprimer l\'image</button>';
    echo '</div>';

// Champ pour la description avec éditeur WYSIWYG
    echo '<div class="form-group full">';
    echo '<label for="speciality_description">Description :</label>';

    $content = $description;
    $custom_editor_id = "speciality_description";
    $args = array(
        'media_buttons' => false, // This setting removes the media button.
        'textarea_name' => 'speciality_description', // Set custom name.
        'textarea_rows' => get_option('default_post_edit_rows', 25), //Determine the number of rows.
//        'quicktags' => false, // Remove view as HTML button.
    );
    wp_editor( $content, $custom_editor_id, $args );

    echo '</div>';

    echo '</div>';


    // Ajoute un nonce pour la sécurité
    wp_nonce_field('vitalisite_save_specialities_meta_box', 'vitalisite_meta_box_nonce');
}

/**
 * Sauvegarder les données de la meta box.
 */
function vitalisite_save_specialities_meta_box($post_id) {

    if (!isset($_POST['vitalisite_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['vitalisite_meta_box_nonce'], 'vitalisite_save_specialities_meta_box')) {
        return;
    }

    // Vérifier les autorisations
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sauvegarder la description
    if (isset($_POST['speciality_description'])) {
        update_post_meta($post_id, '_speciality_description', wp_kses_post($_POST['speciality_description']));
    }

    if (isset($_POST['speciality_photo'])) {
        update_post_meta($post_id, '_speciality_photo', sanitize_text_field($_POST['speciality_photo']));
    }
}
add_action('save_post', 'vitalisite_save_specialities_meta_box');

