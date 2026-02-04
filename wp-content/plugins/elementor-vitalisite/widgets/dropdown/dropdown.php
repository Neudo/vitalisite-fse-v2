<?php
class Elementor_Dropdown extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'dropdown';
    }

    public function get_title(): string {
        return esc_html__( 'Liste déroulante', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-accordion';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'dropdown', 'menu', 'liste', 'faq' ];
    }

    protected function register_controls(): void {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Dropdown', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'dropdown_title',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Écrivez votre titre ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'dropdown_description',
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
                'label' => esc_html__( 'Repeater List', 'textdomain' ),
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
                        'default' => esc_html__( 'Votre texte ici' , 'textdomain' ),
                        'show_label' => false,
                    ],
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

        $this->add_control(
            'dropdown_button_label',
            [
                'label' => esc_html__( 'Bouton', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Libellé du bouton', 'textdomain' ),
            ]
        );

        $this->add_control(
            'dropdown_button_link',
            [
                'label' => esc_html__( 'Lien', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'Lien', 'textdomain' ),
            ]
        );

        $this->add_control(
            'dropdown_enable_download',
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
            'dropdown_download_file',
            [
                'label' => esc_html__( 'Fichier à télécharger', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => [ 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'image/jpeg', 'image/png', 'image/gif' ],
                'condition' => [
                    'dropdown_enable_download' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/dropdown-template.php';
    }



}
