<?php
class Elementor_Vitalisite_Forms extends \Elementor\Widget_Base {
    public function get_name() {
        return 'custom_form';
    }

    public function get_title() {
        return __('Formulaire de contact', 'textdomain');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return ['vitalisite-category'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_form',
            [
                'label' => __('Champs du formulaire', 'textdomain'),
            ]
        );

        //titre du formulaire
        $this->add_control(
            'form_title',
            [
                'label' => __('Titre du formulaire', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Titre du formulaire de contact', 'textdomain'),
            ]
        );
        // description du formulaire
        $this->add_control(
            'form_description',
            [
                'label' => __('Description du formulaire', 'textdomain'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'placeholder' => __('N\'hésitez pas à prendre rendez-vous ou demander plus de renseignements via ce formulaire de contact.', 'textdomain'),
            ]
        );

        // Adresse du cabinet
        $this->add_control(
            'form_address',
            [
                'label' => __('Adresse du cabinet', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('address') ? get_theme_mod('address') : '',
                'placeholder' => __('1 rue de la Liberté, 75013 Paris', 'textdomain'),
            ]
        );

        // Téléphone du cabinet
        $this->add_control(
            'form_tel',
            [
                'label' => __('Téléphone du cabinet', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('tel') ? get_theme_mod('tel') : '',
                'placeholder' => __('01 42 42 42 42', 'textdomain'),
            ]
        );

        // Email du cabinet
        $this->add_control(
            'form_email',
            [
                'label' => __('Email du cabinet', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('email') ? get_theme_mod('email') : '',
                'placeholder' => __('contact@hello.com', 'textdomain'),
            ]
        );

        // Horaires de rendez-vous
        $this->add_control(
            'show_hours',
            [
                'label' => __('Afficher les horaires de rendez-vous ?', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Oui', 'textdomain' ),
				'label_off' => esc_html__( 'Non', 'textdomain' ),

            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'field_type',
            [
                'label' => __('Type de champ', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'text' => __('Texte', 'textdomain'),
                    'email' => __('Email', 'textdomain'),
                    'tel' => __('Téléphone', 'textdomain'),
                ],
                'default' => 'text',
            ]
        );

        $repeater->add_control(
            'field_label',
            [
                'label' => __('Label', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Nouveau champ', 'textdomain'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'field_placeholder',
            [
                'label' => __('Placeholder', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'field_required',
            [
                'label' => __('Requis', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Oui', 'textdomain'),
                'label_off' => __('Non', 'textdomain'),
                'return_value' => 'required',
                'default' => '',
            ]
        );

        $this->add_control(
            'form_fields',
            [
                'label' => __('Champs', 'textdomain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ field_label }}}',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get formatted opening hours from theme mods
     * @return string Formatted open hours
     */
    private function get_formatted_hours() {
        // If detailed hours are not enabled, return the simple format
        if (!get_theme_mod('open_hours_enable', false)) {
            return get_theme_mod('open_hours', '');
        }
        
        // Get hours for each day
        $days = [
            'monday'    => get_theme_mod('open_hours_monday', ''),
            'tuesday'   => get_theme_mod('open_hours_tuesday', ''),
            'wednesday' => get_theme_mod('open_hours_wednesday', ''),
            'thursday'  => get_theme_mod('open_hours_thursday', ''),
            'friday'    => get_theme_mod('open_hours_friday', ''),
            'saturday'  => get_theme_mod('open_hours_saturday', ''),
            'sunday'    => get_theme_mod('open_hours_sunday', '')
        ];
        
        // Create formatted string
        $formatted = '';
        $days_fr = [
            'monday'    => 'Lundi',
            'tuesday'   => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday'  => 'Jeudi',
            'friday'    => 'Vendredi',
            'saturday'  => 'Samedi',
            'sunday'    => 'Dimanche'
        ];
        
        foreach ($days as $day => $hours) {
            if (!empty($hours)) {
                $formatted .= $days_fr[$day] . ' : ' . $hours . "\n";
            }
        }
        
        return trim($formatted);
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include(__DIR__ . '/vitalisite-forms-template.php');
    }
}



\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_Vitalisite_Forms());
