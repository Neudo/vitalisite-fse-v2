<?php
class Elementor_Banniere extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'banniere';
    }

    public function get_title(): string {
        return esc_html__( 'Bannière', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-ehp-hero';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'banniere', 'hero', 'home', 'main', 'accueil' ];
    }

    protected function register_controls(): void {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Bannière', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hero_title',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Écrivez votre titre ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'hero_sub_title',
            [
                'label' => esc_html__( 'Sous titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Écrivez votre sous titre ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'hero_cta_text',
            [
                'label' => __( 'Texte du bouton', 'vitalisite' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Écrivez votre texte ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'hero_cta_link',
            [
                'label' => esc_html__( 'Lien', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'hero_enable_download',
            [
                'label' => esc_html__( 'Activer le téléchargement', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'textdomain' ),
                'label_off' => esc_html__( 'Non', 'textdomain' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'hero_download_file',
            [
                'label' => esc_html__( 'Fichier à télécharger', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => [ 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'image/jpeg', 'image/png', 'image/gif' ],
                'condition' => [
                    'hero_enable_download' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hero_content',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'media_upload' => false,
                'default' => esc_html__( 'Écrivez votre contenu ici', 'textdomain' ),
            ]
        );


        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Choisissez une image', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/hero-template.php';
        add_action( 'wp_footer', [ $this, 'enqueue_hero_script' ] );
    }

    public function enqueue_hero_script() {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const heroSection = document.querySelector('.hero-section');
                if (heroSection) {
                    console.log("Hero section loaded");
                }
            });
        </script>
        </#>
        <?php
    }
}