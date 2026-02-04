<?php
class Elementor_Testimonials extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'testimonials';
    }

    public function get_title(): string {
        return esc_html__( 'Témoignages', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-testimonial';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'testimonials', 'testimonial', 'testimony', 'testimony', 'testimonial', 'testimony', 'testimony', 'testimonial', 'testimony', 'testimony', 'témoignage', 'témoignage', 'témoignage', 'témoignage', 'témoignage', 'témoignage', 'témoignage', 'témoignage', 'témoignage', 'témoignage', 'témoignage', 'témoignage', 'témoignage' ];
    }

    protected function register_controls(): void {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Testimonials', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'testimonials_title',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Titre du testimonial', 'textdomain' ),
            ]
        );

        $this->add_control(
            'post_to_display',
            [
                'label' => esc_html__('Nombre de témoignages à afficher'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => esc_html__('3'),
                'description' => esc_html__('Saisissez -1 pour afficher tous les témoignages'),
                'default' => esc_html__('3')
            ]
        );

        $this->add_control(
            'testimonials_description',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'media_upload' => false,
            ]
        );

        // Display type
        $this->add_control(
            'testimonials_display',
            [
                'label' => esc_html__( 'Type d\'affichage', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slider',
                'options' => [
                    'slider' => esc_html__( 'Slider', 'textdomain' ),
                    'list' => esc_html__( 'Liste', 'textdomain' ),
                ],
            ]
        );

        // Source des témoignages
        $this->add_control(
            'testimonials_source',
            [
                'label' => esc_html__( 'Source des témoignages', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'local',
                'options' => [
                    'local' => esc_html__( 'Mes témoignages rédigés', 'textdomain' ),
                    'google' => esc_html__( 'Avis Google My Business', 'textdomain' ),
                ],
            ]
        );

        // CTA "Laisser un avis"
        $this->add_control(
            'show_leave_review_cta',
            [
                'label' => esc_html__( 'Afficher le CTA "Laisser un avis"', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'textdomain' ),
                'label_off' => esc_html__( 'Non', 'textdomain' ),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'testimonials_source' => 'google',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/testimonials-template.php';
    }
}