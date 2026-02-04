<?php

$id = "section-sticky-cta";

new \Kirki\Section(
    $id,
    [
        'title'       => esc_html__( 'Barre CTA Mobile Sticky', 'kirki' ),
        'priority'    => 30,
    ]
);

// CTA Type (Appointment or Call)
new \Kirki\Field\Radio(
    [
        'settings'    => 'cta_type',
        'label'       => esc_html__( 'Type d\'action', 'kirki' ),
        'section'     => $id,
        'default'     => 'appointment',
        'priority'    => 10,
        'choices'     => [
            'appointment' => esc_html__( 'Prendre rendez-vous', 'kirki' ),
            'call' => esc_html__( 'Appeler', 'kirki' ),
        ],
    ]
);

// Custom Appointment URL
new \Kirki\Field\URL(
    [
        'settings'    => 'cta_appointment_url',
        'label'       => esc_html__( 'URL de prise de rendez-vous', 'kirki' ),
        'description' => esc_html__( 'Pré-rempli avec le lien défini dans les options générales', 'kirki' ),
        'section'     => $id,
        'default'     => get_theme_mod( 'link_appointment', '' ),
        'priority'    => 15,
        'active_callback' => [
            [
                'setting'  => 'cta_type',
                'operator' => '==',
                'value'    => 'appointment',
            ],
        ],
    ]
);

// Custom Phone Number
new \Kirki\Field\Text(
    [
        'settings'    => 'cta_phone_number',
        'label'       => esc_html__( 'Numéro de téléphone', 'kirki' ),
        'description' => esc_html__( 'Pré-rempli avec le numéro défini dans les options générales', 'kirki' ),
        'section'     => $id,
        'default'     => get_theme_mod( 'tel', '' ),
        'priority'    => 16,
        'active_callback' => [
            [
                'setting'  => 'cta_type',
                'operator' => '==',
                'value'    => 'call',
            ],
        ],
    ]
);


// Button Text for Appointment
new \Kirki\Field\Text(
    [
        'settings'    => 'cta_button_text_appointment',
        'label'       => esc_html__( 'Texte du bouton', 'kirki' ),
        'section'     => $id,
        'default'     => 'Prendre rendez-vous',
        'priority'    => 17,
        'active_callback' => [
            [
                'setting'  => 'cta_type',
                'operator' => '==',
                'value'    => 'appointment',
            ],
        ],
    ]
);

// Button Text for Call
new \Kirki\Field\Text(
    [
        'settings'    => 'cta_button_text_call',
        'label'       => esc_html__( 'Texte du bouton', 'kirki' ),
        'section'     => $id,
        'default'     => 'Appeler',
        'priority'    => 17,
        'active_callback' => [
            [
                'setting'  => 'cta_type',
                'operator' => '==',
                'value'    => 'call',
            ],
        ],
    ]
);

// Button Background Color
new \Kirki\Field\Color(
    [
        'settings'    => 'cta_button_bg_color',
        'label'       => esc_html__( 'Couleur de fond du bouton', 'kirki' ),
        'section'     => $id,
        'default'     => get_theme_mod( 'main_color', '#03045E' ),
        'priority'    => 18,
    ]
);

// Hide on Desktop
new \Kirki\Field\Checkbox(
    [
        'settings'    => 'cta_hide_on_desktop',
        'label'       => esc_html__( 'Masquer sur grands écrans', 'kirki' ),
        'section'     => $id,
        'default'     => true,
        'priority'    => 30,
    ]
);
