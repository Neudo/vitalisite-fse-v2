<?php
class Elementor_Cards extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'cards';
    }

    public function get_title(): string {
        return esc_html__( 'Cartes', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-parallax';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'cards' ];
    }

    protected function register_controls(): void {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Cards', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cards_title',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Écrivez votre titre ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'cards_description',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'media_upload' => false,
                'placeholder' => esc_html__( 'Écrivez votre contenu ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Liste des cartes', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'list_title',
                        'label' => esc_html__( 'Titre', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Titre' , 'textdomain' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'list_content',
                        'label' => esc_html__( 'Contenue', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::WYSIWYG,
                        'show_label' => false,
                    ],
                    [
                        'name' => 'list_cta_label',
                        'label'=> esc_html__('Texte du lien', 'textdomain'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'placeholder' => esc_html__('En savoir plus', 'textdomain')
                    ],
                    [
                        'name' => 'list_cta_url',
                        'label' => esc_html__( 'Lien', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::URL,
                        'options' => [ 'url', 'is_external', 'nofollow' ],
                        'default' => [
                            'url' => '',
                            'is_external' => false,
                            'nofollow' => true,
                        ],
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
                    ]

                ],
                'default' => [
                    [
                        'list_title' => esc_html__( 'Titre #1', 'textdomain' ),
                        'list_content' => esc_html__( 'Écrivez votre contenu ici.', 'textdomain' ),
                    ],
                    [
                        'list_title' => esc_html__( 'Titre #2', 'textdomain' ),
                        'list_content' => esc_html__( 'Écrivez votre contenu ici.', 'textdomain' ),
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );

        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/cards-template.php';
    }



}
