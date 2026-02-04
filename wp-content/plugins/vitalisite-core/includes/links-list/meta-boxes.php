<?php
if (!defined('ABSPATH')) {
    exit;
}
function vitalisite_add_links_list_meta_boxes($post) {
        add_meta_box(
            'links_list_meta', // ID unique de la meta box
            'Liste de liens',  // Titre de la meta box
            'vitalisite_render_links_list_meta_box', // Fonction de rendu
            'page', // Post type cible
            'normal', // Contexte (normal, side, advanced)
            'high' // Priorité
        );
}
add_action('add_meta_boxes_page', 'vitalisite_add_links_list_meta_boxes');


add_action('save_post', function ($post_id) {
    if (array_key_exists('_photo', $_POST)) {
        update_post_meta($post_id, '_photo', sanitize_text_field($_POST['_photo']));
    }
});


function vitalisite_render_links_list_meta_box($post)
{
    // Récupérer les données sauvegardées
    $title = get_post_meta($post->ID, '_title', true);
    $description = get_post_meta($post->ID, '_description', true);
    $links = get_post_meta($post->ID, '_my_links', true);
    if (!is_array($links)) {
        $links = [];
    }
    $photo = get_post_meta($post->ID, '_photo', true);
    $image_url = $photo ? wp_get_attachment_image_src($photo, 'thumbnail')[0] : '';

    echo '<div class="wrapper">';

    // Champ pour l'image
    echo '<div class="form-group image">';
    echo '<label for="photo">Photo :</label>';
    echo '<img id="photo_preview" src="' . esc_attr($image_url) . '" style="max-width:150px; max-height:150px; display:' . ($image_url ? 'block' : 'none') . ';">';
    echo '<input type="hidden" id="photo" name="photo" value="' . esc_attr($photo) . '">';
    echo '<button type="button" class="button" id="photo_button">Ajouter une image</button>';
    echo '<button type="button" class="button" id="photo_remove" style="display:' . ($photo ? 'inline-block' : 'none') . ';">Supprimer l\'image</button>';
    echo '</div>';

    // Champ pour le titre
    echo '<div class="form-group full">';
    echo '<label for="title">Titre :</label>';
    echo '<input type="text" id="title" name="title" value="' . esc_attr($title) . '" class="regular-text">';
    echo '</div>';

    // Champ pour la description
    echo '<div class="form-group full">';
    echo '<label for="description">Description :</label>';
    echo '<textarea id="description" name="description" rows="5" class="regular-text">' . esc_textarea($description) . '</textarea>';
    echo '</div>';

    // Champ pour les liens
    echo '<div class="form-group full">';
    echo '<div id="repeater-links">';

    foreach ($links as $index => $link) {
        $href = esc_attr($link['href'] ?? '');
        $label = esc_attr($link['label'] ?? '');

        echo '<div class="repeater-row">';
        echo '<input type="text" name="my_links[' . $index . '][href]" placeholder="URL" value="' . $href . '">';
        echo '<input type="text" name="my_links[' . $index . '][label]" placeholder="Label" value="' . $label . '">';
        echo '<button type="button" class="remove-link-row">Supprimer</button>';
        echo '</div>';
    }

    echo '</div>';
    echo '<button type="button" id="add-link-row">Ajouter un lien</button>';

    echo '</div>';


    echo '</div>';

?>

<?php

    // Ajoute un nonce pour la sécurité
    wp_nonce_field('vitalisite_save_links_list_meta_box', 'vitalisite_meta_box_nonce');

}


/**
 * Sauvegarder les données de la meta box.
 */
function vitalisite_save_links_list_meta_box($post_id) {

    if (!isset($_POST['vitalisite_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['vitalisite_meta_box_nonce'], 'vitalisite_save_links_list_meta_box')) {
        return;
    }

    // Vérifier les autorisations
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sauvegarder le titre
    if (isset($_POST['title'])) {
        update_post_meta($post_id, '_title', sanitize_text_field($_POST['title']));
    }

    // Sauvegarder la description
    if (isset($_POST['description'])) {
        update_post_meta($post_id, '_description', wp_kses_post($_POST['description']));
    }

    // Sauvegarder les liens
    if (isset($_POST['my_links']) && is_array($_POST['my_links'])) {
        $sanitized_links = [];

        foreach ($_POST['my_links'] as $link) {
            if (!empty($link['href']) || !empty($link['label'])) {
                $sanitized_links[] = [
                    'href'  => esc_url_raw($link['href']),
                    'label' => sanitize_text_field($link['label']),
                ];
            }
        }

        update_post_meta($post_id, '_my_links', $sanitized_links);
    } else {
        delete_post_meta($post_id, '_my_links');
    }

    // Sauvegarder l'image
    if (isset($_POST['photo'])) {
        update_post_meta($post_id, '_photo', sanitize_text_field($_POST['photo']));
    }
}
add_action('save_post', 'vitalisite_save_links_list_meta_box');