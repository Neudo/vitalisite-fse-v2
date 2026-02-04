<?php
/**
 * Configuration automatique du Place ID via API NextJS - Version simplifiée
 */

if (!function_exists('vitalisite_auto_configure_place_id')) {
    /**
     * Configure automatiquement le Place ID pour le client actuel
     */
    function vitalisite_auto_configure_place_id() {
        // Récupérer le Place ID depuis le customizer
        $place_id = get_theme_mod('vitalisite_google_place_id', '');
        if (empty($place_id)) {
            return ['success' => false, 'error' => 'Place ID non configuré dans les outils Google Reviews'];
        }
        
        // Récupérer le client ID
        $client_id = get_option('theme_license_key');
        if (empty($client_id)) {
            $client_id = str_replace(['http://', 'https://', 'www.'], '', home_url());
        }
        
        // Appeler l'API de configuration
        $api_url = 'https://vitalisite.com/api/admin/configure-google-reviews';
        
        $response = wp_remote_post($api_url, [
            'timeout' => 15,
            'headers' => [
                'Content-Type' => 'application/json',
                'User-Agent' => 'Vitalisite-Theme/1.0',
            ],
            'body' => json_encode([
                'client_id' => $client_id,
                'place_id' => $place_id,
                'business_name' => get_bloginfo('name'),
            ]),
        ]);
        
        if (is_wp_error($response)) {
            error_log('Vitalisite Reviews Configuration Error: ' . $response->get_error_message());
            return ['success' => false, 'error' => $response->get_error_message()];
        }
        
        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        error_log("Vitalisite Reviews Configuration: HTTP {$status_code} - {$body}");
        
        if ($status_code === 200 && isset($data['success']) && $data['success']) {
            error_log('Vitalisite Reviews: Configuration successful for ' . $client_id);
            return ['success' => true, 'message' => 'Place ID configuré avec succès'];
        }
        
        $error = $data['error'] ?? 'Erreur inconnue';
        error_log('Vitalisite Reviews Configuration Error: ' . $error);
        return ['success' => false, 'error' => $error];
    }
}

// Hook pour configurer automatiquement quand les options sont sauvegardées
add_action('update_option_theme_mods_vitalisite', function($old_value, $new_value) {
    // Si le Place ID est vidé, supprimer le cache
    if (isset($new_value['vitalisite_google_place_id']) && empty($new_value['vitalisite_google_place_id'])) {
        // Supprimer tous les caches Google Reviews (plus complet)
        global $wpdb;
        
        // Supprimer les transients avec _transient_
        $cache_keys = $wpdb->get_col(
            "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '_transient_vitalisite_reviews_%'"
        );
        
        foreach ($cache_keys as $cache_key) {
            $key = str_replace('_transient_', '', $cache_key);
            delete_transient($key);
        }
        
        // Supprimer les transients avec _transient_timeout_
        $timeout_keys = $wpdb->get_col(
            "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_vitalisite_reviews_%'"
        );
        
        foreach ($timeout_keys as $timeout_key) {
            $key = str_replace('_transient_timeout_', '', $timeout_key);
            delete_transient($key);
        }
        
        // Supprimer aussi les options directes (au cas où)
        $wpdb->query(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'vitalisite_reviews_%'"
        );
        
        error_log('Vitalisite: Place ID supprimé - TOUS les caches nettoyés');
        return;
    }
    
    // Vérifier si le Place ID a changé
    if (isset($new_value['vitalisite_google_place_id']) && $new_value['vitalisite_google_place_id'] !== ($old_value['vitalisite_google_place_id'] ?? '')) {
        vitalisite_auto_configure_place_id();
    }
}, 10, 2);

// Hook pour configurer quand l'option est activée
add_action('update_option_theme_mods_vitalisite', function($old_value, $new_value) {
    if (isset($new_value['vitalisite_google_reviews_enabled']) && $new_value['vitalisite_google_reviews_enabled'] && !($old_value['vitalisite_google_reviews_enabled'] ?? false)) {
        vitalisite_auto_configure_place_id();
    }
}, 10, 2);
