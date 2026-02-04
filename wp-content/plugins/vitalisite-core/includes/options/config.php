<?php
add_filter( 'kirki_field_image_button_label', function( $button_label ) {
    return esc_html__( 'Sélectionner une image', 'kirki' );
} );
