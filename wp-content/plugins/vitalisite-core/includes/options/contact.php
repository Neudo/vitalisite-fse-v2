<?php




new \Kirki\Section(
    'social-networks',
    [
        'title'       => esc_html__( 'Réseaux sociaux', 'kirki' ),
        'description' => esc_html__( 'Vos réseaux sociaux, les liens seront affichés dans le footer et sur la page de contact.', 'kirki' ),
        'priority'    => 41,
    ]
);

//Facebook
new \Kirki\Field\Text(
    [
        'settings' => 'facebook',
        'label'    => esc_html__( 'Facebook', 'kirki' ),
        'section'  => 'social-networks',
        'priority' => 10,
    ]
);

//Twitter
new \Kirki\Field\Text(
    [
        'settings' => 'twitter',
        'label'    => esc_html__( 'Twitter', 'kirki' ),
        'section'  => 'social-networks',
        'priority' => 20,
    ]
);

//LinkedIn
new \Kirki\Field\Text(
    [
        'settings' => 'linkedin',
        'label'    => esc_html__( 'LinkedIn', 'kirki' ),
        'section'  => 'social-networks',
        'priority' => 30,
    ]
);

//YouTube
new \Kirki\Field\Text(
    [
        'settings' => 'youtube',
        'label'    => esc_html__( 'YouTube', 'kirki' ),
        'section'  => 'social-networks',
        'priority' => 40,
    ]
);

//Instagram
new \Kirki\Field\Text(
    [
        'settings' => 'instagram',
        'label'    => esc_html__( 'Instagram', 'kirki' ),
        'section'  => 'social-networks',
        'priority' => 50,
    ]
);

//WhatsApp

new \Kirki\Field\Text(
    [
        'settings' => 'whatsapp',
        'label'    => esc_html__( 'WhatsApp', 'kirki' ),
        'section'  => 'social-networks',
        'priority' => 60,
    ]
);
