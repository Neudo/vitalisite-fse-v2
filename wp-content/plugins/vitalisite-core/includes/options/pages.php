<?php

new \Kirki\Panel(
    'pages',
    [
        'priority'    => 4,
        'title'       => esc_html__( 'Pages', 'kirki' ),
        'active_callback' => '__return_true',
    ]
);


// Section page 404
new \Kirki\Section(
    'section-404',
    [
        'title'       => esc_html__( 'Page 404', 'kirki' ),
        'panel'       => 'pages',
        'priority'    => 21,
        'active_callback' => '__return_true',
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'title_404',
        'label'       => esc_html__( 'Titre de la page 404', 'kirki' ),
        'section'     => 'section-404',
        'default'     => esc_html__( 'Page non trouvée.', 'kirki' ),
    ]
);

new \Kirki\Field\Textarea(
    [
        'settings'    => 'description_404',
        'label'       => esc_html__( 'Description de la page 404', 'kirki' ),
        'section'     => 'section-404',
        'default'     => esc_html__( 'Oups, il semblerait que la page que vous cherchez n\'existe pas. Cliquez sur le bouton ci-dessous afin de retourner à la page d\'accueil.', 'kirki' ),
    ]
);

new \Kirki\Field\Image(
    [
        'settings'    => 'image_404',
        'label'       => esc_html__( 'Image de la page 404', 'kirki' ),
        'section'     => 'section-404',
        'default'     => get_template_directory_uri() . '/assets/img/404.jpg',
    ]
);

// Section blog

new \Kirki\Section(
    'section-blog',
    [
        'title'       => esc_html__( 'Blog', 'kirki' ),
        'panel'       => 'pages',
        'priority'    => 22,
        'active_callback' => '__return_true',
    ]
);

new \Kirki\Field\Text(
    [
        'settings'    => 'blog_button_text',
        'label'       => esc_html__( 'Bouton lire l\'article', 'kirki' ),
        'section'     => 'section-blog',
        'default'     => esc_html__( 'Lire plus', 'kirki' ),
    ]
);


