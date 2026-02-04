<?php
function my_theme_activation_menu() {
    add_menu_page(
        'Activation du thème',  // Titre de la page
        'Activation',           // Texte du menu
        'manage_options',       // Capacité requise
        'theme-activation',     // Slug du menu
        'my_theme_activation_page', // Fonction d'affichage
        'dashicons-admin-generic', // Icône du menu
        2                       // Position
    );
}

add_action('admin_menu', 'my_theme_activation_menu');

function my_theme_activation_page() {
    ?>
    <div class="wrapper-tabs">
        <div class="nav-tab-wrapper" role="tablist" aria-label="Navigation des onglets">
            <a href="?page=theme-activation&tab=bienvenue" class="nav-tab <?php echo get_current_tab() === 'bienvenue' ? 'nav-tab-active' : ''; ?>">Bienvenue</a>
            <a href="?page=theme-activation&tab=activation" class="nav-tab <?php echo get_current_tab() === 'activation' ? 'nav-tab-active' : ''; ?>">Activation du thème</a>
            <a href="?page=theme-activation&tab=extensions" class="nav-tab <?php echo get_current_tab() === 'extensions' ? 'nav-tab-active' : ''; ?>">Vérifier les extensions requises</a>
            <a href="?page=theme-activation&tab=personnalisation" class="nav-tab <?php echo get_current_tab() === 'personnalisation' ? 'nav-tab-active' : ''; ?>">Commencez la personnalisation</a>
            <a href="?page=theme-activation&tab=aide" class="nav-tab <?php echo get_current_tab() === 'aide' ? 'nav-tab-active' : ''; ?>">Besoin d'aide ?</a>
        </div>

        <div class="tab-content">
            <?php
            switch (get_current_tab()) {
                case 'extensions':
                    display_required_plugins();
                    break;
                case 'personnalisation':
                    display_customization_guide();
                    break;
                case 'activation':
                    display_theme_activation();
                    break;
                case 'aide':
                    display_need_help();
                    break;
                default:
                    display_welcome_message();
                    break;
            }
            ?>
        </div>
    </div>
    <?php
}

function handle_plugin_activation() {
    if (!isset($_POST['activate_plugin_nonce']) || !wp_verify_nonce($_POST['activate_plugin_nonce'], 'activate_plugin_nonce')) {
        wp_die('Jeton de sécurité invalide.');
    }

    if (!current_user_can('activate_plugins')) {
        wp_die('Vous n\'avez pas la permission d\'activer des plugins.');
    }

    if (isset($_POST['plugin_to_activate'])) {
        $plugin_to_activate = sanitize_text_field($_POST['plugin_to_activate']);
        $result = activate_plugin($plugin_to_activate);

        if (is_wp_error($result)) {
            wp_die('Erreur lors de l\'activation du plugin : ' . $result->get_error_message());
        }
    }

    wp_redirect(admin_url('admin.php?page=theme-activation&tab=extensions'));
    exit;
}
add_action('admin_post_activate_plugin', 'handle_plugin_activation');


function get_current_tab() {
    return isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'bienvenue';
}

require_once plugin_dir_path(__FILE__) . 'welcome_message_tab.php';

require_once plugin_dir_path(__FILE__) . 'theme_activation_tab.php';

require_once plugin_dir_path(__FILE__) . 'required_plugins_tab.php';

require_once plugin_dir_path(__FILE__) . 'customization_guide_tab.php';

require_once plugin_dir_path(__FILE__) . 'need_help.php';
