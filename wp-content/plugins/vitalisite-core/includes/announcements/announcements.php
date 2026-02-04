<?php
if (!defined('ABSPATH')) {
    exit;
}
function add_announcement_menu() {
    add_menu_page(
        'Bandeau Annonce',
        'Annonce',
        'manage_options',
        'announcement-settings',
        'render_announcement_settings',
        'dashicons-megaphone',
        20
    );
}
add_action('admin_menu', 'add_announcement_menu');

function render_announcement_settings() {
    ?>
    <div class="wrap">
        <h1>Bandeau d'Annonce</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('announcement_settings');
            do_settings_sections('announcement-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function register_announcement_settings() {
    register_setting('announcement_settings', 'enable_announcement');
    register_setting('announcement_settings', 'announcement_text');
    register_setting('announcement_settings', 'announcement_bg_color');
    register_setting('announcement_settings', 'announcement_text_color');

    add_settings_section('announcement_section', '', null, 'announcement-settings');

    add_settings_field(
        'enable_announcement',
        'Activer le bandeau d\'annonce',
        function() {
            $value = get_option('enable_announcement', false);
            echo '<input type="checkbox" name="enable_announcement" value="1" ' . checked(1, $value, false) . '>';
        },
        'announcement-settings',
        'announcement_section'
    );

    add_settings_field(
        'announcement_text',
        'Texte de l\'annonce',
        function() {
            $value = get_option('announcement_text', '#ba1c2c');
            echo '<input type="text" name="announcement_text" value="' . esc_attr($value) . '" class="regular-text">';
        },
        'announcement-settings',
        'announcement_section'
    );

    add_settings_field(
        'announcement_bg_color',
        'Couleur de fond de l\'annonce',
        function() {
            $value = get_option('announcement_bg_color', '#FFFFFF');
            echo '<input type="color" name="announcement_bg_color" value="' . esc_attr($value) . '" class="regular-text">';
        },
        'announcement-settings',
        'announcement_section'
    );

    add_settings_field(
        'announcement_text_color',
        'Couleur du texte de l\'annonce',
        function() {
            $value = get_option('announcement_text_color', '');
            echo '<input type="color" name="announcement_text_color" value="' . esc_attr($value) . '" class="regular-text">';
        },
        'announcement-settings',
        'announcement_section'
    );
}
add_action('admin_init', 'register_announcement_settings');
