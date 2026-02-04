<?php
/**
 * Before/After Image Comparison Widget
 * 
 * @package Elementor_Vitalisite
 */

if (!defined('ABSPATH')) {
    exit;
}

class Elementor_Avant_Apres_Comparaison extends \Elementor\Widget_Base {

    public function get_name() {
        return 'avant_apres_comparaison';
    }

    public function get_title() {
        return __('Avant / Après Comparaison', 'elementor-vitalisite');
    }

    public function get_icon() {
        return 'eicon-image-before-after';
    }

    public function get_categories() {
        return ['vitalisite-category'];
    }

    public function get_keywords() {
        return ['avant', 'apres', 'comparaison', 'before', 'after', 'comparison', 'slider', 'image'];
    }

    protected function register_controls() {
        
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Contenu', 'elementor-vitalisite'),
            ]
        );

        $this->add_control(
            'widget_title',
            [
                'label' => __('Titre', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Saisir le titre (optionnel)', 'elementor-vitalisite'),
            ]
        );

        $this->add_control(
            'widget_description',
            [
                'label' => __('Description', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => __('Saisir la description (optionnel)', 'elementor-vitalisite'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_images',
            [
                'label' => __('Images', 'elementor-vitalisite'),
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label' => __('Activer plusieurs comparaisons (Carousel)', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'before_image',
            [
                'label' => __('Image Avant', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'enable_carousel' => '',
                ],
            ]
        );

        $this->add_control(
            'after_image',
            [
                'label' => __('Image Après', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'enable_carousel' => '',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'before_image_carousel',
            [
                'label' => __('Image Avant', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'after_image_carousel',
            [
                'label' => __('Image Après', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'comparison_title',
            [
                'label' => __('Titre (Optionnel)', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $this->add_control(
            'comparisons',
            [
                'label' => __('Comparaisons', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'before_image_carousel' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
                        'after_image_carousel' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
                        'comparison_title' => __('Comparaison 1', 'elementor-vitalisite'),
                    ],
                ],
                'title_field' => '{{{ comparison_title }}}',
                'condition' => [
                    'enable_carousel' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_labels',
            [
                'label' => __('Étiquettes', 'elementor-vitalisite'),
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label' => __('Afficher les étiquettes', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'before_label',
            [
                'label' => __('Étiquette Avant', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Avant', 'elementor-vitalisite'),
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'after_label',
            [
                'label' => __('Étiquette Après', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Après', 'elementor-vitalisite'),
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_disclaimer',
            [
                'label' => __('Avis de non-responsabilité', 'elementor-vitalisite'),
            ]
        );

        $this->add_control(
            'show_disclaimer',
            [
                'label' => __('Afficher l\'avis', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'disclaimer_text',
            [
                'label' => __('Texte de l\'avis', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Résultats individuels. Photos avec consentement du patient.', 'elementor-vitalisite'),
                'condition' => [
                    'show_disclaimer' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_carousel',
            [
                'label' => __('Paramètres du carousel', 'elementor-vitalisite'),
                'condition' => [
                    'enable_carousel' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Lecture automatique', 'elementor-vitalisite'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        include __DIR__ . '/before-after-template.php';
    }
}
