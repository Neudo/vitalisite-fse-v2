<?php
/**
 * Fonctions pour récupérer les avis Google depuis l'API Vitalisite NextJS
 * 
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('vitalisite_get_google_reviews')) {
    /**
     * Récupère les avis depuis l'API centralisée Vitalisite NextJS
     *
     * @param string $place_id Google Place ID
     * @return array
     */
    function vitalisite_get_google_reviews( $place_id = '' ) {
        if ( empty( $place_id ) ) {
            return [];
        }

        // Récupérer le client ID — utilise la clé de licence FSE (vitalisite_license_key)
        $license_key = get_option( 'vitalisite_license_key', '' );
        $client_id   = ! empty( $license_key ) ? $license_key : str_replace( ['http://', 'https://', 'www.'], '', home_url() );

        // Enregistrer/mettre à jour le Place ID côté API si nécessaire
        $registered_place_id = get_option( 'vitalisite_google_place_id_registered', '' );
        if ( $registered_place_id !== $place_id ) {
            vitalisite_configure_google_reviews( $place_id, $client_id );
        }

        // Vérifier le cache local (24h)
        $cache_key = 'vitalisite_reviews_' . md5( $client_id . $place_id );
        $cached_reviews = get_transient( $cache_key );

        if ( $cached_reviews !== false ) {
            return $cached_reviews;
        }

        // Appeler l'API centralisée NextJS
        $api_url = 'https://vitalisite.com/api/reviews/' . urlencode( $client_id );

        $response = wp_remote_get( $api_url, [
            'timeout' => 15,
            'headers' => [
                'X-License-Key' => $license_key,
                'X-Domain'      => parse_url( home_url(), PHP_URL_HOST ),
                'X-Place-ID'    => $place_id,
                'User-Agent'    => 'Vitalisite-Theme/1.0',
                'Content-Type'  => 'application/json',
            ]
        ]);

        if ( is_wp_error( $response ) ) {
            error_log( 'Vitalisite Reviews API Error: ' . $response->get_error_message() );
            return [];
        }

        $status_code = wp_remote_retrieve_response_code( $response );
        $body        = wp_remote_retrieve_body( $response );

        if ( $status_code !== 200 ) {
            error_log( "Vitalisite Reviews API Error: HTTP {$status_code} - {$body}" );
            return [];
        }

        $data = json_decode( $body, true );

        if ( json_last_error() !== JSON_ERROR_NONE || ! isset( $data['reviews'] ) ) {
            error_log( 'Vitalisite Reviews: Invalid response - keys: ' . ( is_array( $data ) ? implode( ', ', array_keys( $data ) ) : 'null' ) );
            return [];
        }

        // Mettre en cache local 24h
        set_transient( $cache_key, $data, DAY_IN_SECONDS );

        return $data;
    }
}

if (!function_exists('vitalisite_format_rating')) {
    /**
     * Formate l'affichage des étoiles en HTML
     */
    function vitalisite_format_rating($rating) {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                // Étoile pleine
                $stars .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fcd987" class="vitalisite-star vitalisite-star--filled">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                </svg>';
            } else {
                // Étoile vide
                $stars .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#c4c3c3" class="vitalisite-star vitalisite-star--empty">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>';
            }
        }
        return $stars;
    }
}

if (!function_exists('vitalisite_configure_google_reviews')) {
    /**
     * Enregistre le Place ID côté API Vitalisite pour ce client.
     * Doit être appelé avant vitalisite_get_google_reviews().
     *
     * @param string $place_id    Google Place ID
     * @param string $client_id  License key ou domaine
     * @return bool
     */
    function vitalisite_configure_google_reviews( $place_id, $client_id = '' ) {
        if ( empty( $client_id ) ) {
            $license_key = get_option( 'vitalisite_license_key', '' );
            $client_id   = ! empty( $license_key ) ? $license_key : str_replace( ['http://', 'https://', 'www.'], '', home_url() );
        }

        $response = wp_remote_post( 'https://vitalisite.com/api/admin/configure-google-reviews', [
            'timeout' => 15,
            'headers' => [
                'Content-Type' => 'application/json',
                'User-Agent'   => 'Vitalisite-Theme/1.0',
            ],
            'body' => json_encode( [
                'client_id'     => $client_id,
                'place_id'      => $place_id,
                'business_name' => get_bloginfo( 'name' ),
            ] ),
        ] );

        if ( is_wp_error( $response ) ) {
            error_log( 'Vitalisite Reviews Configure Error: ' . $response->get_error_message() );
            return false;
        }

        $status_code = wp_remote_retrieve_response_code( $response );
        $body        = wp_remote_retrieve_body( $response );
        $data        = json_decode( $body, true );

        if ( $status_code === 200 && ! empty( $data['success'] ) ) {
            // Mémoriser le Place ID enregistré pour éviter des appels répétés
            update_option( 'vitalisite_google_place_id_registered', $place_id );
            return true;
        }

        error_log( "Vitalisite Reviews Configure Error: HTTP {$status_code} - {$body}" );
        return false;
    }
}

if (!function_exists('vitalisite_clear_google_reviews_cache')) {
    /**
     * Vide le cache des avis Google
     */
    function vitalisite_clear_google_reviews_cache() {
        $license_key = get_option( 'vitalisite_license_key', '' );
        $client_id   = ! empty( $license_key ) ? $license_key : str_replace( ['http://', 'https://', 'www.'], '', home_url() );
        $place_id    = get_option( 'vitalisite_google_place_id_registered', '' );
        $cache_key   = 'vitalisite_reviews_' . md5( $client_id . $place_id );
        delete_transient( $cache_key );
    }
}
