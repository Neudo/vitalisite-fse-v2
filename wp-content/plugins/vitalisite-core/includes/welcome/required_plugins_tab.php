<?php
function display_required_plugins() {
    $required_plugins = [
        'elementor/elementor.php' => 'Elementor',
        'kirki/kirki.php' => 'Kirki Customizer Framework',
        'elementor-vitalisite/elementor-addon.php' => 'Elementor Vitalisite',
        'secure-custom-fields/secure-custom-fields.php' => 'Secure Custom Fields',
    ];
    $strongly_recommended_plugins = [
        'image-optimization/image-optimization.php' => 'Image Optimization',
        'all-in-one-seo-pack/all_in_one_seo_pack.php' => 'All in One SEO Pack',
    ];

    ?>

        <h1>Vérifier les extensions requises</h1>
        <p>Assurez-vous que toutes les extensions nécessaires sont bien installées et activées.</p>

        <table class="widefat fixed">
            <thead>
            <tr>
                <th>Nom du plugin</th>
                <th>État</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($required_plugins as $slug => $name): ?>
                <tr>
                    <td><?php echo esc_html($name); ?></td>
                    <td>
                        <?php if (is_plugin_active($slug)): ?>
                            <span style="color: green; font-weight: bold;">Activé ✅</span>
                        <?php else: ?>
                            <span style="color: red; font-weight: bold;">Désactivé ❌</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!is_plugin_active($slug)): ?>
                            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                                <input type="hidden" name="action" value="activate_plugin">
                                <input type="hidden" name="plugin_to_activate" value="<?php echo esc_attr($slug); ?>">
                                <?php wp_nonce_field('activate_plugin_nonce', 'activate_plugin_nonce'); ?>
                                <?php submit_button('Activer', 'primary'); ?>
                            </form>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Extensions recommandées</h2>
        <p>Si vous avez déjà installé certaines extensions, assurez-vous qu'elles sont bien activées.</p>

        <table class="widefat fixed">
            <thead>
            <tr>
                <th>Nom du plugin</th>
                <th>État</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($strongly_recommended_plugins as $slug => $name): ?>
                <tr>
                    <td><?php echo esc_html($name); ?></td>
                    <td>
                        <?php if (is_plugin_active($slug)): ?>
                            <span style="color: green; font-weight: bold;">Activé ✅</span>
                        <?php else: ?>
                            <span style="color: red; font-weight: bold;">Désactivé ❌</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!is_plugin_active($slug)): ?>
                            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                                <input type="hidden" name="action" value="activate_plugin">
                                <input type="hidden" name="plugin_to_activate" value="<?php echo esc_attr($slug); ?>">
                                <?php wp_nonce_field('activate_plugin_nonce', 'activate_plugin_nonce'); ?>
                                <?php submit_button('Activer', 'primary'); ?>
                            </form>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a class="next-step" style="margin-top: 20px;" href="?page=theme-activation&tab=personnalisation">Étape suivante</a>





    <?php
    if (isset($_POST['activate_plugin'])) {
        $plugin_to_activate = sanitize_text_field($_POST['plugin_to_activate']);
        if (!is_plugin_active($plugin_to_activate)) {
            activate_plugin($plugin_to_activate);
            wp_redirect(admin_url('admin.php?page=theme-activation&tab=extensions'));
            exit;
        }
    }
}
