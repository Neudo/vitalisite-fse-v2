<?php
/**
 * Plugin Name: Elementor Vitalisite
 * Description: Simple hello world widgets for Elementor.
 * Version:     1.0.1
 * Author:      Bassalair Quentin <bassalair.quentin@gmail.com>
 * Author URI:  https://vitalisite.com
 * Text Domain: elementor-addon
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 */

function register_hello_world_widget( $widgets_manager ) {
    if (get_option('theme_license_status') !== 'activated') {
        return;
    }
    require_once( __DIR__ . '/widgets/hero/hero.php' );
    require_once( __DIR__ . '/widgets/slider/slider.php' );
    require_once( __DIR__ . '/widgets/bento/bento.php' );
    require_once (__DIR__ . '/widgets/dropdown/dropdown.php');
    require_once (__DIR__ . '/widgets/cards/cards.php');
    require_once (__DIR__ . '/widgets/text-simple/text-simple.php');
    require_once (__DIR__ . '/widgets/text-image/text-image.php');
    require_once (__DIR__ . '/widgets/vitalisite-forms/vitalisite-forms.php');
    require_once (__DIR__ . '/widgets/image/image.php');
    require_once (__DIR__ . '/widgets/testimonials/testimonials.php');
    require_once (__DIR__ . '/widgets/doctor-presentation/doctor-presentation.php');
    require_once (__DIR__ . '/widgets/before-after/before-after.php');
    require_once (__DIR__ . '/widgets/pricing/pricing.php');
    require_once (__DIR__ . '/widgets/opening-hours/opening-hours.php');
    require_once (__DIR__ . '/widgets/video/video.php');
    require_once (__DIR__ . '/widgets/google-reviews/google-reviews.php');


    $widgets_manager->register( new \Elementor_Image() );
    $widgets_manager->register( new \Elementor_Text_Simple() );

    if(get_post_type() !== 'post') {
        $widgets_manager->register( new \Elementor_Banniere() );
        $widgets_manager->register( new \Elementor_Bento() );
        $widgets_manager->register( new \Elementor_Dropdown() );
        $widgets_manager->register( new \Elementor_Carousel() );
        $widgets_manager->register( new \Elementor_Cards() );
        $widgets_manager->register( new \Elementor_Vitalisite_Forms() );
        $widgets_manager->register( new \Elementor_Text_Image() );
        $widgets_manager->register( new \Elementor_Testimonials() );
        $widgets_manager->register( new \Elementor_Doctor_Presentation() );
        $widgets_manager->register( new \Elementor_Avant_Apres_Comparaison() );
        $widgets_manager->register( new \Elementor_Pricing() );
        $widgets_manager->register( new \Elementor_Opening_Hours() );
        $widgets_manager->register( new \Elementor_Video() );
        $widgets_manager->register( new \Elementor_Google_Reviews() );
    }


}
add_action( 'elementor/widgets/register', 'register_hello_world_widget' );

// Clear all categories and add only our custom category with a very high priority
add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
    $reflection = new \ReflectionClass( $elements_manager );
    $property   = $reflection->getProperty( 'categories' );
    $property->setAccessible( true );
    $property->setValue( $elements_manager, [] ); // Clear all categories
    
    $elements_manager->add_category(
        'vitalisite-category',
        [
            'title' => __( 'Vitalisite', 'vitalisite' ),
            'icon'  => 'fa fa-heartbeat',
        ]
    );
}, 9);

function vitalisite_import_elementor_templates() {
    if ( get_option('vitalisite_templates_imported') ) return; // Empêche les doublons

    // Utiliser le chemin du plugin au lieu du thème
    $plugin_dir = plugin_dir_path(__FILE__);
    $template_dir = $plugin_dir . 'templates/';
    $files = glob($template_dir . '*.json');
    
    if (empty($files)) {
        error_log('Vitalisite: No template files found in ' . $template_dir);
        return;
    }

    foreach ($files as $file) {
        $data = json_decode(file_get_contents($file), true);
        
        if (!$data) {
            error_log('Vitalisite: Failed to parse JSON file: ' . $file);
            continue;
        }

        $post_id = wp_insert_post([
            'post_title'  => $data['title'] ?? basename($file, '.json'),
            'post_type'   => 'elementor_library',
            'post_status' => 'publish'
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            // Enregistrer les données Elementor
            update_post_meta($post_id, '_elementor_data', wp_slash(json_encode($data['content'])));
            update_post_meta($post_id, '_elementor_template_type', $data['type'] ?? 'page');
            update_post_meta($post_id, '_elementor_page_settings', $data['page_settings'] ?? []);
            update_post_meta($post_id, '_elementor_edit_mode', 'builder');
            update_post_meta($post_id, '_elementor_version', '3.12.2'); // Mettre à jour avec votre version d'Elementor
            
            error_log('Vitalisite: Successfully imported template: ' . ($data['title'] ?? basename($file)));
        } else {
            error_log('Vitalisite: Failed to create post for template: ' . basename($file));
            if (is_wp_error($post_id)) {
                error_log('Vitalisite: Error: ' . $post_id->get_error_message());
            }
        }
    }

    update_option('vitalisite_templates_imported', true);
    error_log('Vitalisite: All templates imported successfully');
}
// Changer le hook pour s'assurer qu'Elementor est chargé
add_action('elementor/init', 'vitalisite_import_elementor_templates');

function vitalisite_hide_elementor_categories() {
    echo '<style>
        #elementor-panel-category-wordpress, 
        #elementor-panel-category-theme-elements-single,
        #elementor-panel-category-basic,
        #elementor-panel-category-pro-elements,
        #elementor-panel-category-general { 
            display: none !important; 
        }
    </style>';
}
add_action('elementor/editor/before_enqueue_scripts', 'vitalisite_hide_elementor_categories');


// enqueue styles output.css
add_action( 'elementor/frontend/after_enqueue_styles', 'vitalisite_after_enqueue_styles' );
function vitalisite_after_enqueue_styles() {
    wp_enqueue_style( 'vitalisite-output', plugins_url( 'assets/output.css', __FILE__ ) );
}

function vitalisite_enqueue_scripts() {
    wp_enqueue_script( 'vitalisite-app', plugins_url( 'assets/js/app.js', __FILE__ ), [], false, true );
    wp_enqueue_script( 'vitalisite-app-form', plugins_url( 'assets/js/form-script.js', __FILE__ ), [], false, true );
    wp_enqueue_script( 'vitalisite-before-after', plugins_url( 'assets/js/before-after.js', __FILE__ ), [], '1.0.0', true );

    wp_localize_script('vitalisite-app-form', 'ajax_object', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('vitalisite_form_nonce')
    ]);
}
add_action( 'wp_enqueue_scripts', 'vitalisite_enqueue_scripts' );


function vitalisite_enqueue_swiper() {
    if (!wp_script_is('swiper', 'registered')) {
        wp_register_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', [], '10.0', true);
        wp_register_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', [], '10.0');
    }
    wp_enqueue_script('swiper');
    wp_enqueue_style('swiper');
}
add_action('wp_enqueue_scripts', 'vitalisite_enqueue_swiper');

add_action('wp_ajax_vitalisite_form_handler', 'vitalisite_form_handler');
add_action('wp_ajax_nopriv_vitalisite_form_handler', 'vitalisite_form_handler');

function vitalisite_form_handler() {

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'vitalisite_form_nonce')) {
        wp_die();
    }

    if (!isset($_POST['email']) || !is_email($_POST['email'])) {
        wp_send_json_error(['message' => 'Email invalide']);
    }

    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    $email_content = "Message principal :\n$message\n\n";

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'custom_') === 0) { // Vérifier les champs dynamiques
            $label = ucfirst(str_replace('_', ' ', str_replace('custom_', '', $key))); // Reformater le label
            $email_content .= "$label : " . sanitize_text_field($value) . "\n";
        }
    }

    $to = get_theme_mod('email_contact') ? get_theme_mod('email_contact') : get_option('admin_email');
    $subject = "Nouveau message du formulaire de contact de " . get_bloginfo('name');
    $headers = ['From: ' . $email];

    if (wp_mail($to, $subject, $email_content, $headers)) {
        wp_send_json_success(['message' => 'Message envoyé avec succès !']);
    } else {
        wp_send_json_error(['message' => 'Erreur lors de l’envoi du mail.']);
    }

}