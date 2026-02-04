<?php

$id = "section-global";

new \Kirki\Section(
    $id,
    [
        'title'       => esc_html__( 'Global', 'kirki' ),
        'priority'    => 2,
    ]
);

// Adresse
new \Kirki\Field\Text(
    [
        'settings'    => 'address',
        'label'       => esc_html__( 'Adresse', 'kirki' ),
        'section'     => $id,
        'priority'    => 10,
    ]
);

// Tel
new \Kirki\Field\Text(
    [
        'settings'    => 'tel',
        'label'       => esc_html__( 'Téléphone', 'kirki' ),
        'section'     => $id,
        'priority'    => 15,
    ]
);

// Email de contact
new \Kirki\Field\Text(
    [
        'settings'    => 'contact_email',
        'label'       => esc_html__( 'Email de contact', 'kirki' ),
        'section'     => $id,
        'priority'    => 20,
    ]
);

// Lien rendez-vous
new \Kirki\Field\URL(
    [
        'settings'    => 'link_appointment',
        'label'       => esc_html__( 'Lien rendez-vous', 'kirki' ),
        'section'     => $id,
        'priority'    => 25,
    ]
);

// Lien prise de rendez-vous
new \Kirki\Field\Text(
    [
        'settings'    => 'link_appointment',
        'label'       => esc_html__( 'Lien de prise de rendez-vous', 'kirki' ),
        'section'     => $id,
        'priority'    => 45,
        'description' => esc_html__( 'Lien vers votre application de prise de rendez-vous, par exemple : Doctolib, Resalib ...', 'kirki' ),
    ]
);

// Email de contact
new \Kirki\Field\Text(
    [
        'settings'    => 'email_contact',
        'label'       => esc_html__( 'Email de contact', 'kirki' ),
        'section'     => $id,
        'priority'    => 50,
        'description' => esc_html__( 'L\'adresse email à laquelle le formulaire de contact sera envoyé.', 'kirki' ),
    ]
);

//Horaires des rendez-vous - Version améliorée avec time pickers

// Horaires d'ouverture

// Lundi
new \Kirki\Field\Checkbox(
    [
        'settings'    => 'open_hours_monday_closed',
        'label'       => esc_html__( 'Lundi - Fermé', 'kirki' ),
        'section'     => $id,
        'priority'    => 61,
        'default'     => false,
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_monday_open',
        'label'       => esc_html__( 'Lundi - Ouverture', 'kirki' ),
        'section'     => $id,
        'priority'    => 62,
        'default'     => '09:00',
        'placeholder' => esc_html__( '09:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_monday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_monday_close',
        'label'       => esc_html__( 'Lundi - Fermeture', 'kirki' ),
        'section'     => $id,
        'priority'    => 63,
        'default'     => '18:00',
        'placeholder' => esc_html__( '18:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_monday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

// Mardi
new \Kirki\Field\Checkbox(
    [
        'settings'    => 'open_hours_tuesday_closed',
        'label'       => esc_html__( 'Mardi - Fermé', 'kirki' ),
        'section'     => $id,
        'priority'    => 64,
        'default'     => false,
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_tuesday_open',
        'label'       => esc_html__( 'Mardi - Ouverture', 'kirki' ),
        'section'     => $id,
        'priority'    => 65,
        'default'     => '09:00',
        'placeholder' => esc_html__( '09:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_tuesday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_tuesday_close',
        'label'       => esc_html__( 'Mardi - Fermeture', 'kirki' ),
        'section'     => $id,
        'priority'    => 66,
        'default'     => '18:00',
        'placeholder' => esc_html__( '18:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_tuesday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

// Mercredi
new \Kirki\Field\Checkbox(
    [
        'settings'    => 'open_hours_wednesday_closed',
        'label'       => esc_html__( 'Mercredi - Fermé', 'kirki' ),
        'section'     => $id,
        'priority'    => 67,
        'default'     => false,
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_wednesday_open',
        'label'       => esc_html__( 'Mercredi - Ouverture', 'kirki' ),
        'section'     => $id,
        'priority'    => 68,
        'default'     => '09:00',
        'placeholder' => esc_html__( '09:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_wednesday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_wednesday_close',
        'label'       => esc_html__( 'Mercredi - Fermeture', 'kirki' ),
        'section'     => $id,
        'priority'    => 69,
        'default'     => '18:00',
        'placeholder' => esc_html__( '18:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_wednesday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

// Jeudi
new \Kirki\Field\Checkbox(
    [
        'settings'    => 'open_hours_thursday_closed',
        'label'       => esc_html__( 'Jeudi - Fermé', 'kirki' ),
        'section'     => $id,
        'priority'    => 70,
        'default'     => false,
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_thursday_open',
        'label'       => esc_html__( 'Jeudi - Ouverture', 'kirki' ),
        'section'     => $id,
        'priority'    => 71,
        'default'     => '09:00',
        'placeholder' => esc_html__( '09:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_thursday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_thursday_close',
        'label'       => esc_html__( 'Jeudi - Fermeture', 'kirki' ),
        'section'     => $id,
        'priority'    => 72,
        'default'     => '18:00',
        'placeholder' => esc_html__( '18:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_thursday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

// Vendredi
new \Kirki\Field\Checkbox(
    [
        'settings'    => 'open_hours_friday_closed',
        'label'       => esc_html__( 'Vendredi - Fermé', 'kirki' ),
        'section'     => $id,
        'priority'    => 73,
        'default'     => false,
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_friday_open',
        'label'       => esc_html__( 'Vendredi - Ouverture', 'kirki' ),
        'section'     => $id,
        'priority'    => 74,
        'default'     => '09:00',
        'placeholder' => esc_html__( '09:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_friday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_friday_close',
        'label'       => esc_html__( 'Vendredi - Fermeture', 'kirki' ),
        'section'     => $id,
        'priority'    => 75,
        'default'     => '18:00',
        'placeholder' => esc_html__( '18:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_friday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

// Samedi
new \Kirki\Field\Checkbox(
    [
        'settings'    => 'open_hours_saturday_closed',
        'label'       => esc_html__( 'Samedi - Fermé', 'kirki' ),
        'section'     => $id,
        'priority'    => 76,
        'default'     => true,
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_saturday_open',
        'label'       => esc_html__( 'Samedi - Ouverture', 'kirki' ),
        'section'     => $id,
        'priority'    => 77,
        'default'     => '09:00',
        'placeholder' => esc_html__( '09:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_saturday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_saturday_close',
        'label'       => esc_html__( 'Samedi - Fermeture', 'kirki' ),
        'section'     => $id,
        'priority'    => 78,
        'default'     => '12:00',
        'placeholder' => esc_html__( '12:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_saturday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

// Dimanche
new \Kirki\Field\Checkbox(
    [
        'settings'    => 'open_hours_sunday_closed',
        'label'       => esc_html__( 'Dimanche - Fermé', 'kirki' ),
        'section'     => $id,
        'priority'    => 79,
        'default'     => true,
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_sunday_open',
        'label'       => esc_html__( 'Dimanche - Ouverture', 'kirki' ),
        'section'     => $id,
        'priority'    => 80,
        'default'     => '09:00',
        'placeholder' => esc_html__( '09:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_sunday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'open_hours_sunday_close',
        'label'       => esc_html__( 'Dimanche - Fermeture', 'kirki' ),
        'section'     => $id,
        'priority'    => 81,
        'default'     => '12:00',
        'placeholder' => esc_html__( '12:00', 'kirki' ),
        'active_callback' => [
            [
                'setting'  => 'open_hours_enable',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'open_hours_sunday_closed',
                'operator' => '!=',
                'value'    => true,
            ]
        ],
    ]
);


