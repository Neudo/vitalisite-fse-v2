<?php
if (!defined('ABSPATH')) {
    exit;
}

function vitalisite_add_testimonials_meta_boxes() {
    add_meta_box(
        'details_meta', // ID unique de la meta box
        'Détails de la témoignage',  // Titre de la meta box
        'vitalisite_render_testimonials_meta_box', // Fonction de rendu
        'testimonials', // Post type cible
        'normal', // Contexte (normal, side, advanced)
        'high', // Priorité
    );
}
add_action('add_meta_boxes', 'vitalisite_add_testimonials_meta_boxes');


add_action('save_post', function ($post_id) {
    if (array_key_exists('testimonial_photo', $_POST)) {
        update_post_meta($post_id, 'testimonial_photo', sanitize_text_field($_POST['testimonial_photo']));
    }
});


/**
 * Rendu du contenu de la meta box.
 */
function vitalisite_render_testimonials_meta_box($post) {
    // Récupérer les données sauvegardées
    $comment = get_post_meta($post->ID, '_testimonial_comment', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);

    echo '<div class="wrapper">';
    // Champ pour le commentaire
    echo '<div class="form-group full">';
    echo '<label for="testimonial_comment">Temoignage :</label>';
    echo '<textarea id="testimonial_comment" name="testimonial_comment" rows="5" cols="50">' . esc_attr($comment). '</textarea><br><br>';
    echo '<p id="char-count">0 / 300 caractères.</p>';
    echo '</div>';

    // Champ pour la note
    echo '<div class="form-group">';
    echo '<label for="testimonial_rating">Note (entre 1 et 5) :</label>';
    echo '<input type="number" min="1" max="5" id="testimonial_rating" name="testimonial_rating" value="' . esc_attr($rating). '"><br><br>';
    echo '</div>';


    // Ajoute un nonce pour la sécurité
    wp_nonce_field('vitalisite_save_testimonials_meta_box', 'vitalisite_meta_box_nonce');
}

/**
 * Sauvegarder les données de la meta box.
 */
function vitalisite_save_testimonials_meta_box($post_id) {

    if (!isset($_POST['vitalisite_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['vitalisite_meta_box_nonce'], 'vitalisite_save_testimonials_meta_box')) {
        return;
    }

    // Vérifier les autorisations
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sauvegarder le commentaire
    if (isset($_POST['testimonial_comment'])) {
        update_post_meta($post_id, '_testimonial_comment', sanitize_text_field($_POST['testimonial_comment']));
    }

    if (isset($_POST['testimonial_rating'])) {
        update_post_meta($post_id, '_testimonial_rating', sanitize_text_field($_POST['testimonial_rating']));
    }
}
add_action('save_post', 'vitalisite_save_testimonials_meta_box');





