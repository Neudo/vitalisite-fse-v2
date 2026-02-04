<?php
class Elementor_Doctor_Presentation extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'doctor-presentation';
    }

    public function get_title(): string {
        return esc_html__( 'Présentation docteur', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-user-circle-o';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'docteur', 'presentation', 'doctor' ];
    }

    protected function register_controls(): void {

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Présentation docteur', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'doctor_image',
            [
                'label' => esc_html__( 'Image du docteur', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => ['image'],
            ]
        );

        $this->add_control(
            'doctor_name',
            [
                'label' => esc_html__( 'Nom du docteur', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Nom Prénom', 'textdomain' ),
            ]
        );

        $this->add_control(
            'doctor_description',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'media_upload' => false,
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
            'cta_text',
            [
                'label' => esc_html__( 'Texte du bouton', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Prendre rendez-vous', 'textdomain' ),
            ]
        );

        $this->add_control(
            'cta_link',
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
            'doctor_enable_download',
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
            'doctor_download_file',
            [
                'label' => esc_html__( 'Fichier à télécharger', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => [ 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'image/jpeg', 'image/png', 'image/gif' ],
                'condition' => [
                    'doctor_enable_download' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/doctor-presentation-template.php';
    }
}
