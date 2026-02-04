<?php
/**
 * Elementor Site Import
 * 
 * Import automatique du contenu démo à l'activation du thème
 * 
 * @package vitalisite
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Classe pour gérer l'import du site démo Elementor
 */
class Vitalisite_Site_Import {

    /**
     * Instance unique
     */
    private static $instance = null;

    /**
     * Chemin vers le dossier demo-content
     */
    private $demo_path;

    /**
     * Option pour tracker si l'import a été fait
     */
    private $import_option = 'vitalisite_demo_imported';

    /**
     * Obtenir l'instance unique
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur
     */
    private function __construct() {
        $this->demo_path = get_template_directory() . '/demo-content/';

        // Import à l'activation du thème
        add_action('after_switch_theme', [$this, 'maybe_import_demo']);
        
        // Ajouter une page d'admin pour l'import manuel
        add_action('admin_menu', [$this, 'add_import_page']);
        
        // Handler AJAX pour l'import
        add_action('wp_ajax_vitalisite_import_demo', [$this, 'ajax_import_demo']);
        add_action('wp_ajax_vitalisite_reset_import', [$this, 'ajax_reset_import']);
    }

    /**
     * Importer le contenu démo si pas déjà fait
     */
    public function maybe_import_demo() {
        // Vérifier si déjà importé
        if (get_option($this->import_option)) {
            return;
        }

        $this->import_demo_content();
    }

    /**
     * Importer le contenu démo
     */
    public function import_demo_content() {
        if (!class_exists('\Elementor\Plugin')) {
            return ['success' => false, 'message' => 'Elementor n\'est pas installé.'];
        }

        $zip_file = $this->demo_path . 'demo.zip';

        if (!file_exists($zip_file)) {
            return ['success' => false, 'message' => 'Fichier demo.zip non trouvé.'];
        }

        // Extraire le zip
        $extract_path = $this->demo_path . 'extracted/';
        
        if (!is_dir($extract_path)) {
            wp_mkdir_p($extract_path);
        }

        $zip = new ZipArchive();
        if ($zip->open($zip_file) !== true) {
            return ['success' => false, 'message' => 'Impossible d\'ouvrir le fichier zip.'];
        }

        $zip->extractTo($extract_path);
        $zip->close();

        // Trouver le fichier manifest ou content.json
        $content_file = $this->find_content_file($extract_path);
        
        if (!$content_file) {
            $this->cleanup_extracted($extract_path);
            return ['success' => false, 'message' => 'Fichier de contenu non trouvé dans le zip.'];
        }

        // Lire et importer le contenu
        $result = $this->process_import($content_file, $extract_path);

        // Nettoyer
        $this->cleanup_extracted($extract_path);

        if ($result['success']) {
            update_option($this->import_option, time());
        }

        return $result;
    }

    /**
     * Trouver le fichier de contenu dans l'extraction
     */
    private function find_content_file($extract_path) {
        // Chercher manifest.json (export Elementor Kit)
        $manifest = $extract_path . 'manifest.json';
        if (file_exists($manifest)) {
            return $manifest;
        }

        // Chercher content.json
        $content = $extract_path . 'content.json';
        if (file_exists($content)) {
            return $content;
        }

        // Chercher dans les sous-dossiers
        $files = glob($extract_path . '**/manifest.json');
        if (!empty($files)) {
            return $files[0];
        }

        $files = glob($extract_path . '*/manifest.json');
        if (!empty($files)) {
            return $files[0];
        }

        return false;
    }

    /**
     * Traiter l'import du contenu
     */
    private function process_import($content_file, $extract_path) {
        $content = file_get_contents($content_file);
        $data = json_decode($content, true);

        if (!$data) {
            return ['success' => false, 'message' => 'Erreur de lecture du fichier JSON.'];
        }

        $imported = [
            'pages' => 0,
            'templates' => 0,
            'skipped' => 0,
        ];

        // Import via Elementor si c'est un kit
        if (isset($data['manifest_version']) || isset($data['site-settings'])) {
            return $this->import_elementor_kit($extract_path, $data);
        }

        // Import manuel des templates/pages
        if (isset($data['content'])) {
            // C'est un export de template unique
            $result = $this->import_single_template($data);
            if ($result) {
                $imported['templates']++;
            }
        }

        // Import des templates multiples
        if (isset($data['templates']) && is_array($data['templates'])) {
            foreach ($data['templates'] as $template) {
                if ($this->import_single_template($template)) {
                    $imported['templates']++;
                } else {
                    $imported['skipped']++;
                }
            }
        }

        // Import des pages
        if (isset($data['pages']) && is_array($data['pages'])) {
            foreach ($data['pages'] as $page) {
                if ($this->import_page($page)) {
                    $imported['pages']++;
                } else {
                    $imported['skipped']++;
                }
            }
        }

        return [
            'success' => true,
            'message' => sprintf(
                'Import terminé : %d pages, %d templates importés, %d ignorés.',
                $imported['pages'],
                $imported['templates'],
                $imported['skipped']
            ),
            'imported' => $imported,
        ];
    }

    /**
     * Import via Elementor Kit Import
     */
    private function import_elementor_kit($extract_path, $manifest_data) {
        // Utiliser l'API Elementor pour l'import de kit
        if (!class_exists('\Elementor\Plugin')) {
            return ['success' => false, 'message' => 'Elementor non disponible.'];
        }

        try {
            // Vérifier si le module d'import existe
            $import_export = \Elementor\Plugin::$instance->app->get_component('import-export');
            
            if (!$import_export) {
                // Fallback: import manuel
                return $this->manual_kit_import($extract_path, $manifest_data);
            }

            // Préparer les données d'import
            $import_settings = [
                'include' => ['content', 'templates', 'site-settings'],
                'overrideConditions' => false,
            ];

            // Lancer l'import
            $result = $import_export->import_kit($extract_path, $import_settings);

            if (is_wp_error($result)) {
                return ['success' => false, 'message' => $result->get_error_message()];
            }

            return ['success' => true, 'message' => 'Kit Elementor importé avec succès.'];

        } catch (Exception $e) {
            return $this->manual_kit_import($extract_path, $manifest_data);
        }
    }

    /**
     * Import manuel du kit si l'API Elementor n'est pas disponible
     */
    private function manual_kit_import($extract_path, $manifest_data) {
        $imported = ['pages' => 0, 'templates' => 0, 'skipped' => 0];

        // Importer les templates
        $templates_path = $extract_path . 'templates/';
        if (is_dir($templates_path)) {
            $template_files = glob($templates_path . '*.json');
            foreach ($template_files as $file) {
                $template_data = json_decode(file_get_contents($file), true);
                if ($template_data && $this->import_single_template($template_data)) {
                    $imported['templates']++;
                } else {
                    $imported['skipped']++;
                }
            }
        }

        // Importer le contenu (pages)
        $content_path = $extract_path . 'content/';
        if (is_dir($content_path)) {
            $content_files = glob($content_path . '*.json');
            foreach ($content_files as $file) {
                $page_data = json_decode(file_get_contents($file), true);
                if ($page_data && $this->import_page($page_data)) {
                    $imported['pages']++;
                } else {
                    $imported['skipped']++;
                }
            }
        }

        return [
            'success' => true,
            'message' => sprintf(
                'Import manuel terminé : %d pages, %d templates, %d ignorés.',
                $imported['pages'],
                $imported['templates'],
                $imported['skipped']
            ),
            'imported' => $imported,
        ];
    }

    /**
     * Importer un template unique
     */
    private function import_single_template($template_data) {
        if (empty($template_data['title']) && empty($template_data['name'])) {
            return false;
        }

        $title = isset($template_data['title']) ? $template_data['title'] : $template_data['name'];

        // Vérifier si existe déjà
        $existing = get_posts([
            'post_type' => 'elementor_library',
            'post_status' => 'any',
            'title' => $title,
            'posts_per_page' => 1,
            'suppress_filters' => true,
        ]);

        if (!empty($existing)) {
            return false; // Déjà existe
        }

        $template_type = isset($template_data['type']) ? $template_data['type'] : 'page';

        $post_id = wp_insert_post([
            'post_title' => sanitize_text_field($title),
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'elementor_library',
        ], true);

        if (is_wp_error($post_id) || !$post_id) {
            return false;
        }

        // Métadonnées Elementor
        update_post_meta($post_id, '_elementor_template_type', $template_type);
        update_post_meta($post_id, '_elementor_edit_mode', 'builder');
        
        if (defined('ELEMENTOR_VERSION')) {
            update_post_meta($post_id, '_elementor_version', ELEMENTOR_VERSION);
        }

        if (isset($template_data['content'])) {
            update_post_meta($post_id, '_elementor_data', wp_json_encode($template_data['content']));
        }

        wp_set_object_terms($post_id, $template_type, 'elementor_library_type');

        return $post_id;
    }

    /**
     * Importer une page
     */
    private function import_page($page_data) {
        if (empty($page_data['title']) && empty($page_data['post_title'])) {
            return false;
        }

        $title = isset($page_data['title']) ? $page_data['title'] : $page_data['post_title'];
        $slug = isset($page_data['slug']) ? $page_data['slug'] : sanitize_title($title);

        // Vérifier si la page existe déjà (par slug ou titre)
        $existing = get_page_by_path($slug);
        if ($existing) {
            return false;
        }

        $existing_by_title = get_page_by_title($title, OBJECT, 'page');
        if ($existing_by_title) {
            return false;
        }

        $post_id = wp_insert_post([
            'post_title' => sanitize_text_field($title),
            'post_name' => $slug,
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
        ], true);

        if (is_wp_error($post_id) || !$post_id) {
            return false;
        }

        // Métadonnées Elementor
        update_post_meta($post_id, '_elementor_edit_mode', 'builder');
        
        if (defined('ELEMENTOR_VERSION')) {
            update_post_meta($post_id, '_elementor_version', ELEMENTOR_VERSION);
        }

        if (isset($page_data['content'])) {
            update_post_meta($post_id, '_elementor_data', wp_json_encode($page_data['content']));
        }

        // Page settings
        if (isset($page_data['page_settings'])) {
            update_post_meta($post_id, '_elementor_page_settings', $page_data['page_settings']);
        }

        return $post_id;
    }

    /**
     * Nettoyer les fichiers extraits
     */
    private function cleanup_extracted($path) {
        if (!is_dir($path)) {
            return;
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }

        rmdir($path);
    }

    /**
     * Ajouter la page d'import dans l'admin
     */
    public function add_import_page() {
        add_theme_page(
            'Import Démo Vitalisite',
            'Import Démo',
            'manage_options',
            'vitalisite-demo-import',
            [$this, 'render_import_page']
        );
    }

    /**
     * Afficher la page d'import
     */
    public function render_import_page() {
        $is_imported = get_option($this->import_option);
        $zip_exists = file_exists($this->demo_path . 'demo.zip');
        ?>
        <div class="wrap">
            <h1>Import Démo Vitalisite</h1>
            
            <?php if (!$zip_exists): ?>
                <div class="notice notice-warning">
                    <p><strong>Fichier demo.zip non trouvé.</strong></p>
                    <p>Placez votre fichier d'export Elementor dans : <code><?php echo esc_html($this->demo_path); ?>demo.zip</code></p>
                </div>
            <?php else: ?>
                <?php if ($is_imported): ?>
                    <div class="notice notice-success">
                        <p>Le contenu démo a été importé le <?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $is_imported); ?></p>
                    </div>
                <?php endif; ?>

                <div class="card" style="max-width: 600px; padding: 20px;">
                    <h2>Importer le contenu démo</h2>
                    <p>Cette action va importer les pages et templates du fichier demo.zip.</p>
                    <p><strong>Note :</strong> Les pages et templates existants ne seront pas écrasés.</p>
                    
                    <p>
                        <button id="vitalisite-import-btn" class="button button-primary button-hero">
                            <?php echo $is_imported ? 'Réimporter le contenu' : 'Importer le contenu démo'; ?>
                        </button>
                    </p>

                    <?php if ($is_imported): ?>
                        <p>
                            <button id="vitalisite-reset-btn" class="button button-secondary">
                                Réinitialiser le statut d'import
                            </button>
                        </p>
                    <?php endif; ?>

                    <div id="vitalisite-import-status" style="margin-top: 20px;"></div>
                </div>
            <?php endif; ?>
        </div>

        <script>
        jQuery(document).ready(function($) {
            $('#vitalisite-import-btn').on('click', function() {
                var $btn = $(this);
                var $status = $('#vitalisite-import-status');
                
                $btn.prop('disabled', true).text('Import en cours...');
                $status.html('<p>⏳ Import en cours, veuillez patienter...</p>');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'vitalisite_import_demo',
                        nonce: '<?php echo wp_create_nonce('vitalisite_import'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            $status.html('<div class="notice notice-success"><p>✅ ' + response.data.message + '</p></div>');
                            $btn.text('Import terminé');
                        } else {
                            $status.html('<div class="notice notice-error"><p>❌ ' + response.data.message + '</p></div>');
                            $btn.prop('disabled', false).text('Réessayer');
                        }
                    },
                    error: function() {
                        $status.html('<div class="notice notice-error"><p>❌ Erreur de connexion.</p></div>');
                        $btn.prop('disabled', false).text('Réessayer');
                    }
                });
            });

            $('#vitalisite-reset-btn').on('click', function() {
                if (confirm('Réinitialiser le statut d\'import ?')) {
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'vitalisite_reset_import',
                            nonce: '<?php echo wp_create_nonce('vitalisite_import'); ?>'
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        });
        </script>
        <?php
    }

    /**
     * Handler AJAX pour l'import
     */
    public function ajax_import_demo() {
        check_ajax_referer('vitalisite_import', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Permissions insuffisantes.']);
        }

        $result = $this->import_demo_content();

        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }

    /**
     * Handler AJAX pour reset
     */
    public function ajax_reset_import() {
        check_ajax_referer('vitalisite_import', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Permissions insuffisantes.']);
        }

        delete_option($this->import_option);
        wp_send_json_success();
    }
}

// Initialiser
add_action('init', function() {
    Vitalisite_Site_Import::get_instance();
});
