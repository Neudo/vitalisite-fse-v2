<?php
/**
 * Debug tool pour nettoyer tous les caches Google Reviews
 */

// Ajouter un shortcode pour le debug
add_shortcode('debug_clean_google_cache', function() {
    if (!current_user_can('administrator')) {
        return 'Accès refusé';
    }
    
    global $wpdb;
    
    $output = '<div style="background: #f9f9f9; border: 1px solid #ccc; padding: 20px; margin: 20px 0; font-family: monospace;">';
    $output .= '<h3>🧹 Nettoyage complet des caches Google Reviews</h3>';
    
    // Compter avant nettoyage
    $before_count = $wpdb->get_var(
        "SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE '%vitalisite_reviews%'"
    );
    
    $output .= '<p><strong>Caches trouvés avant nettoyage:</strong> ' . $before_count . '</p>';
    
    // Supprimer les transients
    $transient_keys = $wpdb->get_col(
        "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '_transient_vitalisite_reviews_%'"
    );
    
    $timeout_keys = $wpdb->get_col(
        "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_vitalisite_reviews_%'"
    );
    
    $direct_keys = $wpdb->get_col(
        "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'vitalisite_reviews_%'"
    );
    
    $output .= '<h4>Transients supprimés:</h4><ul>';
    foreach ($transient_keys as $key) {
        $clean_key = str_replace('_transient_', '', $key);
        delete_transient($clean_key);
        $output .= '<li>' . $key . '</li>';
    }
    $output .= '</ul>';
    
    $output .= '<h4>Timeouts supprimés:</h4><ul>';
    foreach ($timeout_keys as $key) {
        $clean_key = str_replace('_transient_timeout_', '', $key);
        delete_transient($clean_key);
        $output .= '<li>' . $key . '</li>';
    }
    $output .= '</ul>';
    
    $output .= '<h4>Options directes supprimées:</h4><ul>';
    foreach ($direct_keys as $key) {
        delete_option($key);
        $output .= '<li>' . $key . '</li>';
    }
    $output .= '</ul>';
    
    // Supprimer aussi les options directes avec SQL
    $deleted = $wpdb->query(
        "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'vitalisite_reviews_%'"
    );
    
    // Compter après nettoyage
    $after_count = $wpdb->get_var(
        "SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE '%vitalisite_reviews%'"
    );
    
    $output .= '<p><strong>Caches restants après nettoyage:</strong> ' . $after_count . '</p>';
    $output .= '<p><strong>Options directes supprimées avec SQL:</strong> ' . $deleted . '</p>';
    
    // Afficher les options actuelles
    $output .= '<h4>Options actuelles:</h4>';
    $url = get_theme_mod('vitalisite_google_maps_url', '');
    $place_id = get_theme_mod('vitalisite_google_place_id', '');
    $enabled = get_theme_mod('vitalisite_google_reviews_enabled', false);
    
    $output .= '<ul>';
    $output .= '<li>URL Google Maps: "' . $url . '"</li>';
    $output .= '<li>Place ID: "' . $place_id . '"</li>';
    $output .= '<li>Activé: ' . ($enabled ? 'OUI' : 'NON') . '</li>';
    $output .= '</ul>';
    
    $output .= '</div>';
    
    return $output;
});
