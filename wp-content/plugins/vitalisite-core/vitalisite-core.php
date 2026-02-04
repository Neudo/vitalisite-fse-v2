<?php
/**
 * Plugin Name: Vitalisite
 * Description: Core functionalities for the Vitalisite theme (Custom Post Types, meta boxes, taxonomies, etc.)
 * Version: 1.0.2
 * Author:  Bassalair Quentin
 */

if (!defined('ABSPATH')) {
    exit;
}

define( 'VITALISITE_CORE_PLUGIN_NAME', 'Vitalisite-core' );
define( 'VITALISITE_CORE_VERSION', '1.0.0' );
define( 'VITALISITE_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'VITALISITE_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'VITALISITE_CORE_ASSETS_URL', plugin_dir_url( __FILE__ ) .'public/');

// Includes doctors files
//require_once plugin_dir_path(__FILE__) . 'includes/doctors/cpt-doctors.php';
//require_once plugin_dir_path(__FILE__) . 'includes/doctors/meta-boxes.php';

// Includes welcome files
require_once plugin_dir_path(__FILE__) . 'includes/welcome/welcome.php';

// Enqueue scripts
require_once plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';
require_once plugin_dir_path(  __FILE__  ) . 'includes/options/init.php';

if (get_option('theme_license_status') !== 'activated') {
    return;
}
// Includes specialities files
require_once plugin_dir_path(__FILE__) . 'includes/specialities/cpt-specialities.php';
require_once plugin_dir_path(__FILE__) . 'includes/specialities/meta-boxes.php';

// Includes testimonies files
require_once plugin_dir_path(__FILE__) . 'includes/testimonials/cpt-testimonials.php';
require_once plugin_dir_path(__FILE__) . 'includes/testimonials/meta-boxes.php';

//Includes announcements files
require_once plugin_dir_path(__FILE__) . 'includes/announcements/announcements.php';

// Includes links files
    require_once plugin_dir_path(__FILE__) . 'includes/links-list/meta-boxes.php';


function vitalisite_core_activate() {
//    vitalisite_register_doctors_cpt();
    vitalisite_register_specialities_cpt();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'vitalisite_core_activate');

// Hook de désactivation du plugin
function vitalisite_core_deactivate() {
    flush_rewrite_rules(); // Met à jour les permaliens
}
register_deactivation_hook(__FILE__, 'vitalisite_core_deactivate');
