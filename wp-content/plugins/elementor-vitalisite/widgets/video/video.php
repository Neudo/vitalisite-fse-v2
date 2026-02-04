<?php
class Elementor_Video extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'video_widget';
    }

    public function get_title(): string {
        return esc_html__( 'Vidéo', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-video-camera';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'video', 'vidéo', 'youtube', 'vimeo', 'embed', 'médical', 'patient' ];
    }

    protected function register_controls(): void {

        // Content Tab - Video Source
        $this->start_controls_section(
            'section_video',
            [
                'label' => esc_html__( 'Vidéo', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'video_source',
            [
                'label' => esc_html__( 'Source de la vidéo', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'url',
                'options' => [
                    'url' => esc_html__( 'URL (YouTube/Vimeo)', 'elementor-addon' ),
                    'upload' => esc_html__( 'Upload (MP4/WebM)', 'elementor-addon' ),
                ],
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label' => esc_html__( 'URL de la vidéo', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'https://www.youtube.com/watch?v=... ou https://vimeo.com/...', 'elementor-addon' ),
                'description' => esc_html__( 'Entrez l\'URL YouTube ou Vimeo', 'elementor-addon' ),
                'label_block' => true,
                'condition' => [
                    'video_source' => 'url',
                ],
            ]
        );

        $this->add_control(
            'video_upload',
            [
                'label' => esc_html__( 'Uploader une vidéo', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'video',
                'description' => esc_html__( 'Upload une vidéo MP4, WebM ou OGG', 'elementor-addon' ),
                'condition' => [
                    'video_source' => 'upload',
                ],
            ]
        );

        $this->add_control(
            'video_title',
            [
                'label' => esc_html__( 'Titre de la vidéo', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Titre optionnel', 'elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'video_description',
            [
                'label' => esc_html__( 'Description', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'media_upload' => false,
                'placeholder' => esc_html__( 'Description optionnelle de la vidéo', 'elementor-addon' ),
            ]
        );

        $this->add_control(
            'show_thumbnail',
            [
                'label' => esc_html__( 'Afficher la miniature', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'elementor-addon' ),
                'label_off' => esc_html__( 'Non', 'elementor-addon' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__( 'Lecture automatique', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'elementor-addon' ),
                'label_off' => esc_html__( 'Non', 'elementor-addon' ),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__( 'La lecture automatique fonctionne uniquement en mode muet', 'elementor-addon' ),
            ]
        );

        $this->end_controls_section();

        // Content Tab - CTA
        $this->start_controls_section(
            'section_cta',
            [
                'label' => esc_html__( 'Call-to-Action', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_cta',
            [
                'label' => esc_html__( 'Afficher le CTA', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'elementor-addon' ),
                'label_off' => esc_html__( 'Non', 'elementor-addon' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'cta_text',
            [
                'label' => esc_html__( 'Texte du CTA', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'En savoir plus', 'elementor-addon' ),
                'default' => esc_html__( 'En savoir plus', 'elementor-addon' ),
                'condition' => [
                    'show_cta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'cta_link',
            [
                'label' => esc_html__( 'Lien du CTA', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://...', 'elementor-addon' ),
                'condition' => [
                    'show_cta' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'video_style',
            [
                'label' => esc_html__( 'Style de la vidéo', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'rounded',
                'options' => [
                    'rounded' => esc_html__( 'Arrondi', 'elementor-addon' ),
                    'sharp' => esc_html__( 'Angles vifs', 'elementor-addon' ),
                ],
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label' => esc_html__( 'Alignement du contenu', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Gauche', 'elementor-addon' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Centre', 'elementor-addon' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Droite', 'elementor-addon' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/video-widget-template.php';
    }
}
