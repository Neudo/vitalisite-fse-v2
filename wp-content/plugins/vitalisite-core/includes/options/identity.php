<?php

$id = "title_tagline";

new \Kirki\Field\Image(
    [
        'settings'    => 'image_setting_id',
        'label'       => esc_html__( 'Logo', 'kirki' ),
        'section'     => 'title_tagline',
        'default'     => '',
        'choices'     => [
            'save_as' => 'array',
        ],
    ]
);