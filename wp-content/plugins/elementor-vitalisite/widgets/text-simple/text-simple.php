<?php
class Elementor_Text_Simple extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'text-simple';
    }

    public function get_title(): string {
        return esc_html__( 'Texte simple', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-text';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'texte', 'simple' ];
    }

    protected function register_controls(): void {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Texte simple', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'has_bg',
            [
                'label' => esc_html__( 'Ajouter une couleur de fond ?', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'textdomain' ),
                'label_off' => esc_html__( 'Non', 'textdomain' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'text_simple_title',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Écrivez votre titre ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'text_simple_content',
            [
                'label' => esc_html__( 'Contenu', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'media_upload' => false,
                'placeholder' => esc_html__( 'Écrivez votre contenu ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'cta_link',
            [
                'label' => esc_html__( 'Lien', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://', 'textdomain' ),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'text_simple_enable_download',
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
            'text_simple_download_file',
            [
                'label' => esc_html__( 'Fichier à télécharger', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => [ 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'image/jpeg', 'image/png', 'image/gif' ],
                'condition' => [
                    'text_simple_enable_download' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'cta_text',
            [
                'label' => esc_html__( 'Texte du lien', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Écrivez votre texte ici', 'textdomain' ),
            ]
        );

        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/text-simple-template.php';
    }
}