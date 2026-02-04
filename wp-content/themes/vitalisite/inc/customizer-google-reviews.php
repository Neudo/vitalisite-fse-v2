<?php
/**
 * Customizer settings for Google Reviews - NextJS API Integration
 * Note: Les options principales sont dans vitalisite-core/includes/options/global.php (Kirki)
 * Ce fichier ajoute seulement les fonctions de test et configuration
 *
 * @package vitalisite
 */

if (!function_exists('vitalisite_google_reviews_customizer')) {
    /**
     * Add Google Reviews configuration tools to the customizer
     */
    function vitalisite_google_reviews_customizer($wp_customize) {
        
        // Section pour les outils de configuration (pas les options principales)
        $wp_customize->add_section('vitalisite_google_reviews_tools', array(
            'title' => __('🌟 Outils Avis Google', 'vitalisite'),
            'priority' => 31,
            'description' => __('Configurez et testez l\'affichage des avis Google sur votre site.', 'vitalisite'),
        ));

        // Activer/Désactiver les avis Google
        $wp_customize->add_setting('vitalisite_google_reviews_enabled', array(
            'default' => false,
            'sanitize_callback' => 'wp_validate_boolean',
            'transport' => 'refresh',
        ));

        $wp_customize->add_control('vitalisite_google_reviews_enabled', array(
            'label' => __('Activer les avis Google', 'vitalisite'),
            'description' => __('Activez l\'affichage des avis Google sur votre site.', 'vitalisite'),
            'section' => 'vitalisite_google_reviews_tools',
            'type' => 'checkbox',
        ));

        // Place ID (champ principal)
        $wp_customize->add_setting('vitalisite_google_place_id', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));

        $wp_customize->add_control('vitalisite_google_place_id', array(
            'label' => __('Google Place ID', 'vitalisite'),
            'description' => __('Entrez votre Google Place ID. <a href="https://localranking.com" target="_blank">Trouvez votre Place ID ici</a>.', 'vitalisite'),
            'section' => 'vitalisite_google_reviews_tools',
            'type' => 'text',
            'input_attrs' => array(
                'placeholder' => 'ChIJd1Aa6Bt55kcRyLqPQNo_5tU',
            ),
        ));

    }
    add_action('customize_register', 'vitalisite_google_reviews_customizer');
}

if (!function_exists('vitalisite_google_reviews_customizer_scripts')) {
    /**
     * Add JavaScript for Google Reviews customizer
     */
    function vitalisite_google_reviews_customizer_scripts() {
        ?>
        <script>
        // Mettre à jour l'affichage du statut seulement (pas le Place ID)
        jQuery(document).ready(function($) {
            // Récupérer le statut depuis le customizer via AJAX
            $.post('<?php echo admin_url('admin-ajax.php'); ?>', {
                action: 'vitalisite_get_google_reviews_status'
            }, function(response) {
                if (response.success) {
                    // Mettre à jour le statut seulement
                    if (response.data.place_id) {
                        $('#customize-control-vitalisite_google_reviews_status input').val('✅ Configuré');
                    } else {
                        $('#customize-control-vitalisite_google_reviews_status input').val('❌ Non configuré');
                    }
                } else {
                    $('#customize-control-vitalisite_google_reviews_status input').val('❌ Erreur');
                }
            });
        });

        function vitalisiteValidateGoogleMapsURL() {
            const button = document.querySelector('#vitalisite_google_validate_url button');
            const originalText = button.value;
            button.value = 'Validation en cours...';
            button.disabled = true;

            const url = document.querySelector('#customize-control-vitalisite_google_maps_url input').value;
            
            if (!url) {
                alert('Veuillez entrer une URL Google Maps');
                button.value = originalText;
                button.disabled = false;
                return;
            }

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=vitalisite_validate_google_maps_url&google_maps_url=' + encodeURIComponent(url)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('#customize-control-vitalisite_google_place_id input').value = data.data.place_id;
                    document.querySelector('#customize-control-vitalisite_google_reviews_status input').value = '✅ Place ID extrait';
                    
                    // Sauvegarder automatiquement
                    wp.customize('vitalisite_google_place_id', data.data.place_id).set();
                    
                    alert('✅ Place ID extrait avec succès: ' + data.data.place_id);
                } else {
                    alert('❌ Erreur: ' + data.data.error);
                    document.querySelector('#customize-control-vitalisite_google_reviews_status input').value = '❌ Erreur extraction';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Erreur lors de la validation');
                document.querySelector('#customize-control-vitalisite_google_reviews_status input').value = '❌ Erreur réseau';
            })
            .finally(() => {
                button.value = originalText;
                button.disabled = false;
            });
        }

        function vitalisiteTestGoogleReviews() {
            const button = document.querySelector('#vitalisite_google_reviews_test button');
            const originalText = button.value;
            button.value = 'Test en cours...';
            button.disabled = true;

            // Mettre à jour le statut
            document.querySelector('#customize-control-vitalisite_google_reviews_status input').value = '🔄 Test en cours...';

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=vitalisite_test_google_reviews'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    document.querySelector('#customize-control-vitalisite_google_reviews_status input').value = '✅ Test réussi';
                } else {
                    alert('❌ Erreur: ' + data.error);
                    document.querySelector('#customize-control-vitalisite_google_reviews_status input').value = '❌ Erreur';
                }
            })
            .catch(error => {
                alert('❌ Erreur de connexion: ' + error.message);
                document.querySelector('#customize-control-vitalisite_google_reviews_status input').value = '❌ Erreur connexion';
            })
            .finally(() => {
                button.value = originalText;
                button.disabled = false;
            });
        }

        function vitalisiteClearGoogleReviewsCache() {
            if (!confirm('⚠️ Voulez-vous vraiment vider le cache des avis Google ?\n\nCela forcera une nouvelle récupération des données au prochain chargement.')) {
                return;
            }

            const button = document.querySelector('#vitalisite_google_reviews_clear_cache button');
            const originalText = button.value;
            button.value = 'Suppression...';
            button.disabled = true;

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=vitalisite_clear_google_reviews_cache'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Cache vidé avec succès !');
                    document.querySelector('#customize-control-vitalisite_google_reviews_status input').value = '✅ Cache vidé';
                } else {
                    alert('❌ Erreur: ' + data.message);
                }
            })
            .catch(error => {
                alert('❌ Erreur: ' + error.message);
            })
            .finally(() => {
                button.value = originalText;
                button.disabled = false;
            });
        }
        </script>
        <?php
    }
    add_action('customize_controls_print_footer_scripts', 'vitalisite_google_reviews_customizer_scripts');
}

if (!function_exists('vitalisite_validate_google_maps_url_ajax')) {
    /**
     * AJAX handler for validating Google Maps URL and extracting Place ID
     */
    function vitalisite_validate_google_maps_url_ajax() {
        $url = sanitize_url($_POST['google_maps_url'] ?? '');
        
        if (empty($url)) {
            wp_send_json_error(['error' => 'URL vide']);
        }
        
        // Valider que c'est une URL Google Maps
        if (!strpos($url, 'google.com/maps') && !strpos($url, 'maps.google.com')) {
            wp_send_json_error(['error' => 'URL invalide. Doit être une URL Google Maps.']);
        }
        
        // Extraire le Place ID depuis l'URL
        $place_id = '';
        
        // Format 1: ?cid=123456789
        if (preg_match('/[?&]cid=([^&]+)/', $url, $matches)) {
            $place_id = $matches[1];
        }
        // Format 2: /place/.../@lat,lng/data=!3m1!4b1!4m6!3m5!1sPLACE_ID
        elseif (preg_match('/\/place\/[^\/]+\/@[^,]+,[^,]+,[^,]+z\/data=[^!]*!3m1!4b1!4m6!3m5!1s([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $place_id = $matches[1];
        }
        // Format 3: /place/.../data=...!1sPLACE_ID
        elseif (preg_match('/\/place\/[^\/]+\/data=[^!]*!1s([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $place_id = $matches[1];
        }
        // Format 4: /g/1pp2x5l4l (short URL)
        elseif (preg_match('/\/g\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $place_id = $matches[1];
        }
        // Format 5: /place/.../place_id=...
        elseif (preg_match('/[?&]place_id=([^&]+)/', $url, $matches)) {
            $place_id = $matches[1];
        }
        
        // Debug : logguer l'URL et les tentatives de match
        error_log('Vitalisite Google Maps URL: ' . $url);
        error_log('Vitalisite extracted Place ID: ' . $place_id);
        
        if (empty($place_id)) {
            wp_send_json_error(['error' => 'Impossible d\'extraire le Place ID depuis cette URL. Vérifiez que l\'URL est correcte.']);
        }
        
        // Sauvegarder le Place ID
        set_theme_mod('vitalisite_google_place_id', $place_id);
        
        wp_send_json_success([
            'place_id' => $place_id,
            'message' => 'Place ID extrait avec succès'
        ]);
    }
    add_action('wp_ajax_vitalisite_validate_google_maps_url', 'vitalisite_validate_google_maps_url_ajax');
}

if (!function_exists('vitalisite_get_google_reviews_status_ajax')) {
    /**
     * AJAX handler for getting Google Reviews status
     */
    function vitalisite_get_google_reviews_status_ajax() {
        $place_id = get_theme_mod('vitalisite_google_place_id', '');
        $enabled = get_theme_mod('vitalisite_google_reviews_enabled', false);
        
        wp_send_json_success([
            'place_id' => $place_id,
            'enabled' => $enabled,
            'status' => $place_id && $enabled ? 'configured' : 'not_configured'
        ]);
    }
    add_action('wp_ajax_vitalisite_get_google_reviews_status', 'vitalisite_get_google_reviews_status_ajax');
}

if (!function_exists('vitalisite_test_google_reviews_ajax')) {
    /**
     * AJAX handler for testing Google Reviews
     */
    function vitalisite_test_google_reviews_ajax() {
        check_ajax_referer('vitalisite_google_reviews', 'nonce');
        
        // Simuler un appel pour tester
        $reviews_data = vitalisite_get_google_reviews();
        
        if (!empty($reviews_data) && isset($reviews_data['reviews'])) {
            wp_send_json_success([
                'success' => true, 
                'message' => 'Configuration réussie ! ' . count($reviews_data['reviews']) . ' avis trouvés.'
            ]);
        } else {
            wp_send_json_error([
                'success' => false, 
                'error' => 'Aucun avis trouvé. Vérifiez votre Place ID et votre connexion API.'
            ]);
        }
    }
    add_action('wp_ajax_vitalisite_test_google_reviews', 'vitalisite_test_google_reviews_ajax');
}

if (!function_exists('vitalisite_clear_google_reviews_cache_ajax')) {
    /**
     * AJAX handler for clearing Google Reviews cache
     */
    function vitalisite_clear_google_reviews_cache_ajax() {
        check_ajax_referer('vitalisite_google_reviews', 'nonce');
        
        vitalisite_clear_google_reviews_cache();
        
        wp_send_json_success(['success' => true, 'message' => 'Cache vidé avec succès']);
    }
    add_action('wp_ajax_vitalisite_clear_google_reviews_cache', 'vitalisite_clear_google_reviews_cache_ajax');
}

if (!function_exists('vitalisite_google_reviews_localize_scripts')) {
    /**
     * Localize scripts for AJAX
     */
    function vitalisite_google_reviews_localize_scripts() {
        wp_localize_script('jquery', 'vitalisite_google_reviews', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('vitalisite_google_reviews'),
        ));
    }
    add_action('wp_enqueue_scripts', 'vitalisite_google_reviews_localize_scripts');
}
