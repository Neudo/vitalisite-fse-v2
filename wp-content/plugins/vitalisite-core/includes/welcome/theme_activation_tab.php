<?php
function display_theme_activation() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $activation_key = sanitize_text_field($_POST["key"]);
        check_activation_key($activation_key);

    } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["desactivate"])) {
        desactivate_theme();
    }

    if (get_option('theme_license_status') !== 'activated') {
        echo '<h1>Activation du thème</h1>';
        echo '<p>Le thème Vitalisite a besoin d\'être activé pour pouvoir être utilisé.</p>';
        echo '<p>Merci de bien vouloir saisir votre clé d’activation reçue par mail afin d’activer le thème.</p>';
        echo '<form method="POST" class="form-key-activation">';
        echo '<label>Clé d’activation du thème :</label>';
        echo '<input type="text" name="key" id="key" required>';
        echo '<button type="submit" name="submit">Activer</button>';
        echo '</form>';
    } else {
        echo '<div class="updated"><p>✅ Thème activé !</p></div>';
        echo '<p>Merci d’avoir choisi notre thème. Vous pouvez maintenant commencer à personnaliser votre site.</p>';
        // button theme desactivation
        echo '<form method="POST" >';
        echo '<button type="submit" name="desactivate" class="danger-btn">Désactiver le thème</button>';
        echo '</form>';
        echo '<a class="next-step" style="margin-top: 20px;" href="?page=theme-activation&tab=extensions">Étape suivante</a>';
    }

}

function check_activation_key($key) {
    $api_url = "https://vitalisite.com/api/check-license";

    $args = [
        "body" => json_encode(["unique_key" => $key]),
        "headers" => [
            "Content-Type" => "application/json",
        ],
        "method" => "POST"
    ];

    $response = wp_remote_post($api_url, $args);

    if (is_wp_error($response)) {
        return false;
    } else {
        $body = json_decode(wp_remote_retrieve_body($response), true);

        if ($body['success']) {
            // Stocker l’activation du thème dans la base de données WordPress
            update_option('theme_license_key', $key);
            update_option('theme_license_status', 'activated');

            echo '<div class="updated"><p>✅ Clé valide, thème activé !</p></div>';
        } else {
            echo '<div class="error"><p>❌ ' . esc_html($body['message']) . '</p></div>';
        }
    }
    return !empty($data["success"]) && $data["success"] === true;
}

function desactivate_theme() {

    $api_url = "https://vitalisite.com/api/desactivate-license";
    $key = get_option('theme_license_key');

    // Si aucune clé n'est trouvée, retourner une erreur
    if (empty($key)) {
        echo '<div class="error"><p>❌ Aucune clé d\'activation trouvée.</p></div>';
        return;
    }

    $args = [
        "body" => json_encode(["unique_key" => $key]),
        "headers" => [
            "Content-Type" => "application/json",
        ],
        "method" => "POST"
    ];

    // Appeler l'API Next.js pour désactiver la clé
    $response = wp_remote_post($api_url, $args);

    // Vérifier si la requête a échoué
    if (is_wp_error($response)) {
        echo '<div class="error"><p>❌ Erreur lors de la désactivation via l\'API.</p></div>';
        return;
    }

    // Vérifier la réponse de l'API
    $body = json_decode(wp_remote_retrieve_body($response), true);

    // Si la désactivation est réussie, mettre à jour l'option dans WordPress
    if ($body['success']) {
        // Mettre à jour l'état de la licence dans WordPress
        update_option('theme_license_status', 'deactivated');
        update_option('theme_license_key', "");

        echo '<div class="updated"><p>✅ Licence désactivée avec succès.</p></div>';
    } else {
        echo '<div class="error"><p>❌ ' . esc_html($body['message']) . '</p></div>';
    }
}



