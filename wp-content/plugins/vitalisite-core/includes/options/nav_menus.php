<?php

// Header
new \Kirki\Section(
    'header-params',
    [
        'title'       => esc_html__( 'Paramètres du header', 'kirki' ),
        'panel'       => 'nav_menus',
        'priority'    => 161,
        'active_callback' => '__return_true',
    ]
);


//new \Kirki\Field\Radio(
//    [
//        'settings' => 'header-layout',
//        'label'    => esc_html__( 'Choisissez un style pour le header', 'kirki' ),
//        'section'  => 'header-global',
//        'default'  => 'content-1',
//        'priority' => 10,
//        'choices'  => [
//            'content-1'   => [
//                esc_html__( 'Style 1', 'kirki' ),
//                esc_html__( 'These are some extra details about Red', 'kirki' ),
//            ],
//            'content-2'   => [
//                esc_html__( 'Style 2', 'kirki' ),
//                esc_html__( 'These are some extra details about Green', 'kirki' ),
//            ],
//            'content-3'   => [
//                esc_html__( 'Style 3', 'kirki' ),
//                esc_html__( 'These are some extra details about Blue', 'kirki' ),
//            ],
//        ],
//    ]
//);

//Logo
new \Kirki\Field\Image(
    [
        'settings'    => 'header_logo',
        'label'       => esc_html__( 'Logo', 'kirki' ),
        'section'     => 'header-params',
        'description' => esc_html__( 'Ajoutez ici votre logo.', 'kirki' ),
        'default'     => '',
        'choices'     => [
            'save_as' => 'array',
        ],
    ]
);

// Sticky header ?
new \Kirki\Field\Toggle(
    [
        'settings'    => 'header_sticky',
        'label'       => esc_html__( 'Activer l\'en-tête fixe (sticky)', 'kirki' ),
        'description' => esc_html__( 'Si cette option est activée, l\'en-tête restera visible en haut de l\'écran lorsque vous faites défiler la page.', 'kirki' ),
        'section'     => 'header-params',
        'default'     => false,
    ]
);



new \Kirki\Field\Typography(
    [
        'settings'    => 'nav_links_color',
        'label'       => esc_html__( 'Couleurs des liens', 'kirki' ),
        'section'     => 'header-params',
        'transport'   => 'auto',
        'default'     => [
            'color'           => '#333333',
        ],
        'output'      => [
            [
                'element' => '#primary-menu li a',
                'property' => 'color',
            ],
            [
                'element' => '#primary-menu li a svg',
                'property' => 'color',
            ],
        ],
    ]
);

new \Kirki\Field\Typography(
    [
        'settings'    => 'nav_links_hover_color',
        'label'       => esc_html__( 'Couleurs des liens au survol', 'kirki' ),
        'section'     => 'header-params',
        'transport'   => 'auto',
        'default'     => [
            'color'           => '#333333',
        ],
        'output'      => [
            [
                'element' => '#primary-menu li a:hover',
                'property' => 'color',
            ],
            [
                'element' => '#primary-menu li a svg',
                'property' => 'color',
            ],
        ],
    ]
);


// TODO: À voir plus tard
//new \Kirki\Field\Typography(
//    [
//        'settings'    => 'nav_links_active_color',
//        'label'       => esc_html__( 'Couleurs de la page active', 'kirki' ),
//        'section'     => 'header',
//        'transport'   => 'auto',
//        'default'     => [
//            'color'           => '#333333',
//        ],
//        'output'      => [
//            [
//                'element' => '#primary-menu li a',
//                'property' => 'color',
//            ],
//        ],
//    ]
//);


// Footer
new \Kirki\Section(
    'footer-params',
    [
        'title'       => esc_html__( 'Paramètres du footer', 'kirki' ),
        'panel'       => 'nav_menus',
        'priority'    => 171,
    ]
);

//Logo
new \Kirki\Field\Image(
    [
        'settings'    => 'footer_logo',
        'label'       => esc_html__( 'Logo', 'kirki' ),
        'section'     => 'footer-params',
        'default'     => '',
        'choices'     => [
            'save_as' => 'array',
        ],
    ]
);

//Copyright
new \Kirki\Field\Text(
    [
        'settings'    => 'footer_copyright',
        'label'       => esc_html__( 'Copyright', 'kirki' ),
        'section'     => 'footer-params',
        'default'     => esc_html__( '© 2024 Vitaliste. Tous droits réservés.', 'kirki' ),
    ]
);