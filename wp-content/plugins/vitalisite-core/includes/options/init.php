<?php
add_action( 'init', function() {
    if ( ! class_exists( 'Kirki' ) ) {
        return;
    }
    require_once plugin_dir_path(  __FILE__  ) . './config.php';
    require_once plugin_dir_path(  __FILE__  ) . './identity.php';
    require_once plugin_dir_path(  __FILE__  ) . './global.php';
    require_once plugin_dir_path(  __FILE__  ) . './colors.php';
    require_once plugin_dir_path(  __FILE__  ) . './nav_menus.php';
    require_once plugin_dir_path(  __FILE__  ) . './pages.php';
//    require_once plugin_dir_path(  __FILE__  ) . './typography.php';
    require_once plugin_dir_path(  __FILE__  ) . './contact.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . '/../options/sticky-mobile-cta.php';
    wp_enqueue_style( 'vitalisite-options', plugin_dir_url( __FILE__ ) . './theme_options.css' );
});
