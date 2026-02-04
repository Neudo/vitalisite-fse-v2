<?php

$id = "section-colors";

new \Kirki\Section(
    $id,
    [
        'title'       => esc_html__( 'Couleurs', 'kirki' ),
        'description' => esc_html__( 'Définissez les couleurs de votre thème.', 'kirki' ),
        'priority'    => 1,
    ]
);

new \Kirki\Field\Custom(
    [
        'settings' => 'separator_colors',
        'section'  => 'section-colors',
        'default'  => '<hr><h3 style="margin-top:20px;font-size:22px">Couleurs du site</h3>',
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'main_color',
        'label'       => __( 'Couleur principale', 'kirki' ),
        'section'     => $id,
        'default'     => '#03045E',
    ]
);


new \Kirki\Field\Custom(
    [
        'settings' => 'separator_primary_cta',
        'section'  => 'section-colors',
        'default'  => '<hr><h3 style="margin-top:20px;font-size:22px">Couleurs des boutons principaux</h3>',
    ]
);



new \Kirki\Field\Color(
    [
        'settings'    => 'primary_cta_color',
        'label'       => __( 'Couleur des boutons', 'kirki' ),
        'section'     => $id,
        'default'     => '#09243C',
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'primary_cta_hover_color',
        'label'       => __( 'Couleur des boutons au survol', 'kirki' ),
        'section'     => $id,
        'default'     => '#155287',
    ]
);

new \Kirki\Field\Color(
    [
        'settings'    => 'primary_cta_text_color',
        'label'       => __( 'Couleur du texte des boutons', 'kirki' ),
        'section'     => $id,
        'default'     => '#FFFFFF',
    ]
);