<?php
class Elementor_Carousel extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'carousel';
    }

    public function get_title(): string {
        return esc_html__( 'Carousel', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-slider-push';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'carousel', 'slider', 'home', 'main', 'accueil' ];
    }

    protected function register_controls(): void {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Carousel', 'elementor-addon' ),
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
            'slider_title',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Titre du slider', 'textdomain' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'slider_description',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__( 'Description du slider', 'textdomain' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Slides', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'list_title',
                        'label' => esc_html__( 'Titre', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'List Title' , 'textdomain' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'list_content',
                        'label' => esc_html__( 'Content', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::WYSIWYG,
                        'default' => esc_html__( 'Contenu de la slide' , 'textdomain' ),
                        'show_label' => false,
                    ],
                    [
                        'name' => 'list_link',
                        'label' => esc_html__( 'Lien', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::URL,
                        'options' => [ 'url', 'is_external', 'nofollow' ],
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
                        'label_block' => true,
                    ],
                    [
                        'name' => 'list_enable_download',
                        'label' => esc_html__( 'Activer le téléchargement', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'label_on' => esc_html__( 'Oui', 'textdomain' ),
                        'label_off' => esc_html__( 'Non', 'textdomain' ),
                        'return_value' => 'yes',
                        'default' => '',
                    ],
                    [
                        'name' => 'list_download_file',
                        'label' => esc_html__( 'Fichier à télécharger', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'media_type' => [ 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'image/jpeg', 'image/png', 'image/gif' ],
                        'condition' => [
                            'list_enable_download' => 'yes',
                        ],
                    ],
                    [
                        'name' => 'list_image',
                        'label' => esc_html__( 'Image', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => '',
                            'id' => 0,
                        ],
                        'label_block' => true,
                    ],
                    [
                        'name' => 'list_color',
                        'label' => esc_html__( 'Couleur', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#ffffff',
                        'label_block' => true,
                    ]
                ],
                'default' => [
                    [
                        'list_title' => esc_html__( 'Titre #1', 'textdomain' ),
                        'list_content' => esc_html__( 'Description de la slide.', 'textdomain' ),
                    ],
                    [
                        'list_title' => esc_html__( 'Titre #2', 'textdomain' ),
                        'list_content' => esc_html__( 'Contenu de la slide.', 'textdomain' ),
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );

        $this->add_control(
            'website_link',
            [
                'label' => esc_html__( 'Lien vers une page', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'slider_enable_download',
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
            'slider_download_file',
            [
                'label' => esc_html__( 'Fichier à télécharger', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => [ 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'image/jpeg', 'image/png', 'image/gif' ],
                'condition' => [
                    'slider_enable_download' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/slider-template.php';
    }
}