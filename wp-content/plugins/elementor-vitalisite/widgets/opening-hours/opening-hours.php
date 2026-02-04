<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Elementor_Opening_Hours extends \Elementor\Widget_Base {

    public function get_name() {
        return 'opening-hours';
    }

    public function get_title() {
        return esc_html__( 'Horaires d\'Ouverture', 'elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-clock';
    }

    public function get_categories() {
        return [ 'vitalisite-category' ];
    }

    public function get_keywords() {
        return [ 'horaires', 'ouverture', 'planning', 'rendez-vous' ];
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
            'opening_hours_title',
            [
                'label' => esc_html__( 'Titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( "Nos horaires d'ouverture", 'textdomain' ),
                'default' => esc_html__( "Nos horaires d'ouverture", 'textdomain' ),
            ]
        );

        $this->add_control(
            'show_open_now_indicator',
            [
                'label' => esc_html__( 'Afficher l\'indicateur "Ouvert/Fermé"', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'textdomain' ),
                'label_off' => esc_html__( 'Non', 'textdomain' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_phone_button',
            [
                'label' => esc_html__( 'Afficher le bouton d\'appel', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'textdomain' ),
                'label_off' => esc_html__( 'Non', 'textdomain' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_appointment_button',
            [
                'label' => esc_html__( 'Afficher le bouton de rendez-vous', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'textdomain' ),
                'label_off' => esc_html__( 'Non', 'textdomain' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'emergency_text',
            [
                'label' => esc_html__( 'Texte d\'urgence (hors horaires)', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( "En cas d'urgence, appelez le 15", 'textdomain' ),
                'condition' => [
                    'show_open_now_indicator' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab Start

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Couleur du titre', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .opening-hours-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'days_color',
            [
                'label' => esc_html__( 'Couleur des jours', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .opening-hours-day' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hours_color',
            [
                'label' => esc_html__( 'Couleur des horaires', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .opening-hours-time' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'open_color',
            [
                'label' => esc_html__( 'Couleur "Ouvert"', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#22c55e',
                'selectors' => [
                    '{{WRAPPER}} .status-open' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'closed_color',
            [
                'label' => esc_html__( 'Couleur "Fermé"', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ef4444',
                'selectors' => [
                    '{{WRAPPER}} .status-closed' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        
        // Récupérer les horaires depuis le customizer
        $hours = $this->get_opening_hours();
        
        if ( empty( $hours ) ) {
            echo '<p>' . esc_html__( 'Aucun horaire configuré', 'elementor-addon' ) . '</p>';
            return;
        }

        // Vérifier si le cabinet est ouvert
        $is_open = $this->is_open_now( $hours );
        $current_day = strtolower( date( 'l' ) );
        
        include 'opening-hours-template.php';
    }

    private function get_opening_hours() {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $hours = [];
        
        // Utiliser directement les horaires personnalisés (plus de switch)
        foreach ( $days as $day ) {
            $is_closed = get_theme_mod( "open_hours_{$day}_closed", false );
            
            if ( $is_closed ) {
                $hours[$day] = [
                    'closed' => true,
                    'open' => '',
                    'close' => ''
                ];
            } else {
                $hours[$day] = [
                    'closed' => false,
                    'open' => get_theme_mod( "open_hours_{$day}_open", '09:00' ),
                    'close' => get_theme_mod( "open_hours_{$day}_close", '18:00' )
                ];
            }
        }
        
        return $hours;
    }

    private function is_open_now( $hours ) {
        // Utiliser la timezone de WordPress
        $timezone = new DateTimeZone( wp_timezone_string() );
        $current_time = new DateTime( 'now', $timezone );
        
        $current_day = strtolower( $current_time->format( 'l' ) );
        $current_time_str = $current_time->format( 'H:i' );
        
        if ( ! isset( $hours[$current_day] ) || $hours[$current_day]['closed'] ) {
            return false;
        }
        
        $open_time = $hours[$current_day]['open'];
        $close_time = $hours[$current_day]['close'];
        
        if ( empty( $open_time ) || empty( $close_time ) ) {
            return false;
        }
        
        // Comparer les heures avec la timezone WordPress
        return ( $current_time_str >= $open_time && $current_time_str <= $close_time );
    }

    private function get_day_name_in_french( $day ) {
        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi',
            'sunday' => 'Dimanche'
        ];
        
        return isset( $days[$day] ) ? $days[$day] : $day;
    }

}
