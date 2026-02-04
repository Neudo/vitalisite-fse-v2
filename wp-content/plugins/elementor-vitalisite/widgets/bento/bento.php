<?php
class Elementor_Bento extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'bento';
    }

    public function get_title(): string {
        return esc_html__( 'Bento', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-gallery-group';
    }

    public function get_categories(): array {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords(): array {
        return [ 'bento', 'home', 'main', 'accueil' ];
    }

    protected function register_controls(): void {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Bento', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'bento_title_left',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Écrivez votre titre ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'bento_content_left',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'media_upload' => false,
            ]
        );

        $this->add_control(
            'bento_title_right',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Écrivez votre titre ici', 'textdomain' ),
            ]
        );

        $this->add_control(
            'bento_content_right',
            [
                'label' => esc_html__( 'Description', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'media_upload' => false,
            ]
        );





        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/bento-template.php';
        add_action( 'wp_footer', [ $this, 'enqueue_bento_script' ] );
    }

    public function enqueue_bento_script() {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const bentoSection = document.querySelector('.bento-section');
                if (bentoSection) {
                    console.log("Bento section loaded");
                }
            });
        </script>
        </#>
        <?php
    }
}