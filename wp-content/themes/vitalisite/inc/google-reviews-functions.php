<?php
/**
 * Fonctions pour récupérer les avis Google depuis l'API Vitalisite NextJS
 */

if (!function_exists('vitalisite_get_google_reviews')) {
    /**
     * Récupère les avis depuis l'API centralisée Vitalisite NextJS
     */
    function vitalisite_get_google_reviews() {
        // Vérifier si la licence est active
        if (get_option('theme_license_status') !== 'activated') {
            error_log('Vitalisite Reviews: Theme not activated');
            return [];
        }
        
        // Vérifier si les avis Google sont activés
        $enabled = get_theme_mod('vitalisite_google_reviews_enabled', false);
        if (!$enabled) {
            error_log('Vitalisite Reviews: Google Reviews disabled in customizer');
            return [];
        }
        
        // Récupérer le Place ID depuis le customizer
        $place_id = get_theme_mod('vitalisite_google_place_id', '');
        if (empty($place_id)) {
            error_log('Vitalisite Reviews: No place_id configured in customizer - returning empty array');
            return [];
        }
        
        // Récupérer le client ID (license key ou domain)
        $client_id = get_option('theme_license_key');
        if (empty($client_id)) {
            $client_id = str_replace(['http://', 'https://', 'www.'], '', home_url());
        }
        
        // Vérifier le cache local (24h)
        $cache_key = 'vitalisite_reviews_' . md5($client_id . $place_id);
        $cached_reviews = get_transient($cache_key);
        
        if ($cached_reviews !== false) {
            error_log('Vitalisite Reviews: Cache hit for ' . $client_id);
            return $cached_reviews;
        }
        
        error_log('Vitalisite Reviews: API call for ' . $client_id . ' with place_id: ' . $place_id);
        
        // Appeler l'API centralisée NextJS
        $api_url = "https://vitalisite.com/api/reviews/" . urlencode($client_id);
        
        $response = wp_remote_get($api_url, [
            'timeout' => 15,
            'headers' => [
                'X-License-Key' => get_option('theme_license_key'),
                'X-Domain' => parse_url(home_url(), PHP_URL_HOST),
                'X-Place-ID' => $place_id,  // Ajouter le Place ID en header
                'User-Agent' => 'Vitalisite-Theme/1.0',
                'Content-Type' => 'application/json',
            ]
        ]);
        
        if (is_wp_error($response)) {
            error_log('Vitalisite Reviews API Error: ' . $response->get_error_message());
            return [];
        }
        
        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        
        error_log("Vitalisite Reviews API Response: HTTP {$status_code}");
        
        if ($status_code !== 200) {
            error_log("Vitalisite Reviews API Error: HTTP {$status_code} - {$body}");
            
            // Gérer les erreurs spécifiques
            $data = json_decode($body, true);
            if (isset($data['error'])) {
                switch ($data['error']) {
                    case 'Place ID manquant':
                        // Afficher un message à l'admin
                        add_action('admin_notices', function() {
                            echo '<div class="notice notice-warning is-dismissible"><p>⚠️ <strong>Google Reviews:</strong> Place ID manquant côté API. Contactez le support.</p></div>';
                        });
                        break;
                    case 'Clé non trouvée':
                    case 'Licence non activée':
                        add_action('admin_notices', function() {
                            echo '<div class="notice notice-error is-dismissible"><p>❌ <strong>Google Reviews:</strong> Licence invalide. Vérifiez votre activation du thème.</p></div>';
                        });
                        break;
                    case 'Domaine non autorisé':
                        add_action('admin_notices', function() {
                            echo '<div class="notice notice-error is-dismissible"><p>❌ <strong>Google Reviews:</strong> Domaine non autorisé. Contactez le support.</p></div>';
                        });
                        break;
                }
            }
            
            return [];
        }
        
        $data = json_decode($body, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('Vitalisite Reviews JSON Error: ' . json_last_error_msg());
            return [];
        }
        
        if (!isset($data['reviews'])) {
            error_log('Vitalisite Reviews: Invalid data structure');
            error_log('Vitalisite Reviews: Data received: ' . print_r($data, true));
            return [];
        }
        
        // Mettre en cache local 24h
        set_transient($cache_key, $data, DAY_IN_SECONDS);
        error_log('Vitalisite Reviews: Success! Cached locally for ' . $client_id);
        
        return $data;
    }
}

if (!function_exists('vitalisite_configure_google_reviews')) {
    /**
     * Configure le Place ID pour un client via l'API NextJS
     */
    function vitalisite_configure_google_reviews($place_id, $business_name = '') {
        $client_id = get_option('theme_license_key');
        if (empty($client_id)) {
            $client_id = str_replace(['http://', 'https://', 'www.'], '', home_url());
        }
        
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
                'business_name' => $business_name ?: get_bloginfo('name'),
            ]),
        ]);
        
        if (is_wp_error($response)) {
            error_log('Vitalisite Reviews Configuration Error: ' . $response->get_error_message());
            return ['success' => false, 'error' => $response->get_error_message()];
        }
        
        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        error_log("Vitalisite Reviews Configuration: HTTP {$status_code}");
        
        if ($status_code === 200 && isset($data['success']) && $data['success']) {
            // Sauvegarder le place_id localement pour référence
            update_option('vitalisite_google_place_id', $place_id);
            error_log('Vitalisite Reviews: Configuration successful for ' . $client_id);
            return ['success' => true, 'message' => 'Configuration réussie'];
        }
        
        $error = $data['error'] ?? 'Erreur inconnue';
        error_log('Vitalisite Reviews Configuration Error: ' . $error);
        return ['success' => false, 'error' => $error];
    }
}

if (!function_exists('vitalisite_format_rating')) {
    /**
     * Formate l'affichage des étoiles
     */
    function vitalisite_format_rating($rating) {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '⭐';
            } else {
                $stars .= '☆';
            }
        }
        return $stars;
    }
}

if (!function_exists('vitalisite_clear_google_reviews_cache')) {
    /**
     * Vide le cache des avis Google
     */
    function vitalisite_clear_google_reviews_cache() {
        $client_id = get_option('theme_license_key');
        if (empty($client_id)) {
            $client_id = str_replace(['http://', 'https://', 'www.'], '', home_url());
        }
        
        $cache_key = 'vitalisite_reviews_' . md5($client_id);
        delete_transient($cache_key);
        
        error_log('Vitalisite Reviews: Cache cleared for ' . $client_id);
    }
}

if (!function_exists('vitalisite_format_rating')) {
    /**
     * Formate l'affichage des étoiles
     */
    function vitalisite_format_rating($rating) {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                // Étoile pleine
                $stars .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fcd987" class="size-6 text-yellow-500">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                </svg>';
            } else {
                // Étoile vide
                $stars .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#c4c3c3" class="size-6 text-yellow-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>';
            }
        }
        return $stars;
    }
}

if (!function_exists('vitalisite_clear_google_reviews_cache')) {
    /**
     * Vide le cache des avis Google
     */
    function vitalisite_clear_google_reviews_cache() {
        $place_id = get_theme_mod('google_place_id', '');
        if (!empty($place_id)) {
            $cache_key = 'google_reviews_' . md5($place_id);
            delete_transient($cache_key);
        }
    }
}
