<?php

new \Kirki\Section(
    'typography',
    [
        'title'       => esc_html__( 'Typographie', 'kirki' ),
        'description' => esc_html__( 'Définissez ici vos styles de typographie.', 'kirki' ),
        'priority'    => 1,
    ]
);

new \Kirki\Field\Typography(
    [
        'settings'    => 'headings_setting',
        'label'       => esc_html__( 'Titres principaux', 'kirki' ),
        'section'     => 'typography',
        'priority'    => 10,
        'transport'   => 'auto',
        'default'     => [
            'font-family'     => 'Barlow',
            'variant'         => 'regular',
            'font-style'      => 'normal',
            'color'           => '#333333',
            'font-size'       => '70px',

        ],
        'output'      => [
            [
                'element'     => 'h1',
                'property'    => 'font-family',
            ],
            [
                'element' => 'h1',
                'property' => 'color',
            ],
            [
                'element' => 'h1',
                'property' => 'font-style',
            ],
            [
                'element' => 'h1',
                'property' => 'font-size',
            ],
        ],
    ]
);


// TODO: À voir plus tard
//new \Kirki\Field\Number(
//    [
//        'settings' => 'h1_size',
//        'label'    => esc_html__( 'Number Control', 'kirki' ),
//        'section'  => 'typography',
//        'default'  => [
//            'desktop' => 70,
//            'tablet'  => 50,
//            'mobile'  => 33,
//        ],
//        'responsive' => true,
//        'choices'  => [
//            'min'  => 8,
//            'max'  => 280,
//            'step' => 1,
//        ],
//    ]
//);



new \Kirki\Field\Typography(
    [
        'settings'    => 'subheadings_setting',
        'label'       => esc_html__( 'Sous-titres', 'kirki' ),
        'section'     => 'typography',
        'priority'    => 11,
        'transport'   => 'auto',
        'default'     => [
            'font-family'     => 'Barlow',
            'variant'         => 'regular',
            'font-style'      => 'normal',
            'color'           => '#333333',
            'font-size'       => '24px',
        ],
        'output'      => [
            [
                'element' => 'h2',
                'property'    => 'font-family',
            ],
            [
                'element' => 'h2',
                'property' => 'font-size',
            ],
            [
                'element' => 'h2',
                'property' => 'color',
            ],
            [
                'element' => 'h2',
                'property' => 'font-style',
            ],
        ],
    ]
);

new \Kirki\Field\Typography(
    [
        'settings'    => 'h3_setting',
        'label'       => esc_html__( 'Titres de niveaux 3', 'kirki' ),
        'section'     => 'typography',
        'priority'    => 12,
        'transport'   => 'auto',
        'default'     => [
            'font-family'     => 'Barlow',
            'variant'         => 'regular',
            'font-style'      => 'normal',
            'color'           => '#333333',
            'font-size'       => '32px',
        ],
        'output'      => [
            [
                'element' => 'h3',
                'property' => 'font-family',
            ],
            [
                'element' => 'h3',
                'property' => 'font-size',
            ],
            [
                'element' => 'h3',
                'property' => 'color',
            ],
            [
                'element' => 'h3',
                'property' => 'font-style',
            ],
        ],
    ]
);

new \Kirki\Field\Typography(
    [
        'settings'    => 'p_setting',
        'label'       => esc_html__( 'Texte courant', 'kirki' ),
        'section'     => 'typography',
        'priority'    => 15,
        'transport'   => 'auto',
        'default'     => [
            'font-family'     => 'Inter',
            'variant'         => 'regular',
            'font-style'      => 'normal',
            'color'           => '#333333',
            'font-size'       => '16px',
        ],
        'output'      => [
            [
                'element' => 'body',
                'property' => 'font-family',
            ],
            [
                'element' => 'body',
                'property' => 'font-size',
            ],
            [
                'element' => 'body',
                'property' => 'color',
            ],
            [
                'element' => 'body',
                'property' => 'font-style',
            ],
        ],
    ]
);