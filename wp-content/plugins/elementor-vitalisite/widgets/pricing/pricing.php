<?php
class Elementor_Pricing extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'pricing';
    }

    public function get_title(): string {
        return esc_html__( 'Tarifs', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-price-list';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'pricing', 'tarifs', 'prix' ];
    }

    protected function register_controls(): void {

        // Content Tab Start

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Contenu', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pricing_title',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Nos tarifs', 'textdomain' ),
            ]
        );

        $this->add_control(
            'pricing_description',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'media_upload' => false,
                'placeholder' => esc_html__( 'Description des tarifs', 'textdomain' ),
            ]
        );

        $this->end_controls_section();

        // Pricing Cards Section

        $this->start_controls_section(
            'section_pricing_cards',
            [
                'label' => esc_html__( 'Cartes de prix', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'card_title',
            [
                'label' => esc_html__( 'Titre de la carte', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Consultation', 'textdomain' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'card_description',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => esc_html__( 'Description de la prestation', 'textdomain' ),
            ]
        );

        $repeater->add_control(
            'card_border_color',
            [
                'label' => esc_html__( 'Couleur de bordure', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'description' => esc_html__( 'Laisser vide pour la couleur par défaut', 'textdomain' ),
            ]
        );

        $repeater->add_control(
            'card_price',
            [
                'label' => esc_html__( 'Prix', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '50€',
                'placeholder' => esc_html__( 'Ex: 50€, 75€/séance', 'textdomain' ),
            ]
        );

        $repeater->add_control(
            'card_cta_text',
            [
                'label' => esc_html__( 'Texte du bouton', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Réserver', 'textdomain' ),
            ]
        );

        $repeater->add_control(
            'card_cta_url',
            [
                'label' => esc_html__( 'Lien du bouton', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => true,
                ],
            ]
        );

        $repeater->add_control(
            'card_enable_download',
            [
                'label' => esc_html__( 'Activer le téléchargement', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'textdomain' ),
                'label_off' => esc_html__( 'Non', 'textdomain' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $repeater->add_control(
            'card_download_file',
            [
                'label' => esc_html__( 'Fichier à télécharger', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => [ 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'image/jpeg', 'image/png', 'image/gif' ],
                'condition' => [
                    'card_enable_download' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pricing_cards',
            [
                'label' => esc_html__( 'Cartes de tarifs', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'card_title' => esc_html__( 'Consultation initiale', 'textdomain' ),
                        'card_price' => '80€',
                        'card_cta_text' => esc_html__( 'Prendre rendez-vous', 'textdomain' ),
                    ],
                    [
                        'card_title' => esc_html__( 'Séance de suivi', 'textdomain' ),
                        'card_price' => '60€',
                        'card_cta_text' => esc_html__( 'Prendre rendez-vous', 'textdomain' ),
                    ],
                ],
                'title_field' => '{{{ card_title }}} - {{{ card_price }}}',
            ]
        );

        $this->end_controls_section();

        // Global CTA Section

        $this->start_controls_section(
            'section_global_cta',
            [
                'label' => esc_html__( 'CTA globale', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'global_cta_text',
            [
                'label' => esc_html__( 'Texte du CTA global', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Prendre rendez-vous', 'textdomain' ),
            ]
        );

        $this->add_control(
            'global_cta_url',
            [
                'label' => esc_html__( 'Lien du CTA global', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'global_enable_download',
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
            'global_download_file',
            [
                'label' => esc_html__( 'Fichier à télécharger', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => [ 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'image/jpeg', 'image/png', 'image/gif' ],
                'condition' => [
                    'global_enable_download' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/pricing-template.php';
    }

}
