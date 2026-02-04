<?php
if(!defined('ABSPATH')) exit;

function vitalisite_add_doctors_meta_boxes() {
    add_meta_box(
        'details_meta', // ID unique de la meta box
        'Détails du Docteur',  // Titre de la meta box
        'vitalisite_render_doctors_meta_box', // Fonction de rendu
        'doctors', // Post type cible
        'normal', // Contexte (normal, side, advanced)
        'high', // Priorité
    );
}
add_action('add_meta_boxes', 'vitalisite_add_doctors_meta_boxes');


add_action('save_post', function ($post_id) {
    if (array_key_exists('doctor_photo', $_POST)) {
        update_post_meta($post_id, 'doctor_photo', sanitize_text_field($_POST['doctor_photo']));
    }
});


/**
 * Rendu du contenu de la meta box.
 */
function vitalisite_render_doctors_meta_box($post) {
    // Récupérer les données sauvegardées
    $selected_speciality = get_post_meta($post->ID, '_doctor_speciality', true);
    $phone_number = get_post_meta($post->ID, '_doctor_phone_number', true);
    $name = get_post_meta($post->ID, '_doctor_name', true);
    $last_name = get_post_meta($post->ID, '_doctor_last_name', true);
    $photo = get_post_meta($post->ID, '_doctor_photo', true);
    $image_url = $photo ? wp_get_attachment_image_src($photo, 'thumbnail')[0] : '';
    $available_online = get_post_meta($post->ID, '_doctor_available_online', true);

    // Récupérer toutes les spécialités disponibles
    $specialities = get_posts([
        'post_type' => 'specialities',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ]);


    // Champ pour le photo
    echo '<div class="form-group image">';
    echo '<label for="doctor_photo">Photo :</label>';
    echo '<img id="doctor_photo_preview" src="' . esc_attr($image_url) . '" style="max-width:150px; max-height:150px; display:' . ($image_url ? 'block' : 'none') . ';">';
    echo '<input type="hidden" id="photo" name="doctor_photo" value="' . esc_attr($photo) . '">';
    echo '<button type="button" class="button" id="photo_button">Ajouter une image</button>';
    echo '<button type="button" class="button" id="photo_remove" style="display:' . ($photo ? 'inline-block' : 'none') . ';">Supprimer l\'image</button>';
    echo '</div>';

    echo '<div class="wrapper">';

    // Champ pour le nom
    echo '<div class="form-group">';
    echo '<label for="doctor_name">Prénom :</label>';
    echo '<input type="text" id="doctor_name" name="doctor_name" value="' . esc_attr($name). '"><br><br>';
    echo '</div>';

    // Champ pour le nom de famille
    echo '<div class="form-group">';
    echo '<label for="doctor_last_name">Nom :</label>';
    echo '<input type="text" id="doctor_last_name" name="doctor_last_name" value="' . esc_attr($last_name). '"><br><br>';
    echo '</div>';

    // Champ pour la spécialité

    echo '<div class="form-group">';
    echo '<label for="doctor_speciality">Spécialité :</label>';
    echo '<select id="doctor_speciality" name="doctor_speciality">';

    echo '<option value="">-- Sélectionnez une spécialité --</option>'; // Option par défaut

    foreach ($specialities as $speciality) {
        $selected = ($selected_speciality == $speciality->ID) ? 'selected' : '';
        echo '<option value="' . esc_attr($speciality->ID) . '" ' . $selected . '>' . esc_html($speciality->post_title) . '</option>';
    }

    echo '</select>';
    echo '</div>';


    // Champ pour le numéro de téléphone
    echo '<div class="form-group">';
    echo '<label for="doctor_phone_number">Numéro de téléphone :</label>';
    echo '<input type="text" id="doctor_phone_number" name="doctor_phone_number" value="' . esc_attr($phone_number). '"><br><br>';
    echo '</div>';

    // Champ pour la disponibilité en ligne

    echo '<div class="form-group">';
    echo '<label for="doctor_available_online">Disponible en ligne :</label>';
    echo '<input type="checkbox" id="doctor_available_online" name="doctor_available_online" value="1" ' . checked($available_online, 1, false) . '"><br><br>';
    echo '</div>';


    echo '</div>';


    // Ajoute un nonce pour la sécurité
    wp_nonce_field('vitalisite_save_doctors_meta_box', 'vitalisite_meta_box_nonce');
}

/**
 * Sauvegarder les données de la meta box.
 */
function vitalisite_save_doctors_meta_box($post_id) {

    if (!isset($_POST['vitalisite_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['vitalisite_meta_box_nonce'], 'vitalisite_save_doctors_meta_box')) {
        return;
    }

    // Vérifier les autorisations
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }


    // Sauvegarder l'ID de la spécialité
    if (!empty($_POST['doctor_speciality'])) {
        update_post_meta($post_id, '_doctor_speciality', sanitize_text_field($_POST['doctor_speciality']));
    } else {
        delete_post_meta($post_id, '_doctor_speciality');
    }
    // Sauvegarder le numéro de téléphone
    if (isset($_POST['doctor_phone_number'])) {
        update_post_meta($post_id, '_doctor_phone_number', sanitize_text_field($_POST['doctor_phone_number']));
    }

    if (isset($_POST['doctor_name'])) {
        update_post_meta($post_id, '_doctor_name', sanitize_text_field($_POST['doctor_name']));
    }

    if (isset($_POST['doctor_last_name'])) {
        update_post_meta($post_id, '_doctor_last_name', sanitize_text_field($_POST['doctor_last_name']));
    }

    if (isset($_POST['doctor_photo'])) {
        update_post_meta($post_id, '_doctor_photo', sanitize_text_field($_POST['doctor_photo']));
    }

    if (isset($_POST['doctor_available_online'])) {
        update_post_meta($post_id, '_doctor_available_online', sanitize_text_field($_POST['doctor_available_online']));
    }
}
add_action('save_post', 'vitalisite_save_doctors_meta_box');
