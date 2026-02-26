<?php
/**
 * Shortcode dynamique : réseaux sociaux depuis les options du BO.
 *
 * Usage : [vitalisite_social_links] dans un bloc HTML ou shortcode.
 * Se réévalue à chaque affichage de la page.
 *
 * @package Vitalisite_FSE
 * @since   1.0.0
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rendu des icônes de réseaux sociaux depuis vitalisite_social.
 *
 * @param array $atts Attributs du shortcode (non utilisés).
 * @return string HTML des liens sociaux, ou chaîne vide.
 */
function render_social_links_shortcode( $atts ) {
	$networks = array(
		'facebook'  => array(
			'label' => 'Facebook',
			'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"/></svg>',
		),
		'instagram' => array(
			'label' => 'Instagram',
			'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false"><path d="M12 2c-2.7 0-3.1 0-4.1.1C4.4 2.3 2.3 4.3 2.1 7.8 2 8.9 2 9.3 2 12s0 3.1.1 4.1c.2 3.5 2.3 5.6 5.8 5.8 1 .1 1.4.1 4.1.1s3.1 0 4.1-.1c3.5-.2 5.6-2.3 5.8-5.8.1-1 .1-1.4.1-4.1s0-3.1-.1-4.1c-.2-3.5-2.3-5.6-5.8-5.8C15.1 2 14.7 2 12 2zm0 1.8c2.7 0 3 0 4.1.1 2.7.1 3.9 1.4 4 4 .1 1.1.1 1.4.1 4.1 0 2.7 0 3-.1 4.1-.1 2.7-1.3 3.9-4 4-1.1.1-1.4.1-4.1.1-2.7 0-3 0-4.1-.1-2.7-.1-3.9-1.4-4-4C3.8 15 3.8 14.7 3.8 12c0-2.7 0-3 .1-4.1.1-2.7 1.3-3.9 4-4C9 3.8 9.3 3.8 12 3.8zm0 3.1a5.1 5.1 0 100 10.2A5.1 5.1 0 0012 6.9zm0 8.4a3.3 3.3 0 110-6.6 3.3 3.3 0 010 6.6zm5.3-8.6a1.2 1.2 0 100 2.4 1.2 1.2 0 000-2.4z"/></svg>',
		),
		'linkedin'  => array(
			'label' => 'LinkedIn',
			'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false"><path d="M19.7 3H4.3A1.3 1.3 0 003 4.3v15.4A1.3 1.3 0 004.3 21h15.4a1.3 1.3 0 001.3-1.3V4.3A1.3 1.3 0 0019.7 3zM8.3 18.4H5.6V9.7h2.7v8.7zM7 8.4a1.6 1.6 0 110-3.2 1.6 1.6 0 010 3.2zm11.4 10h-2.7v-4.2c0-1 0-2.3-1.4-2.3-1.4 0-1.6 1.1-1.6 2.2v4.3h-2.7V9.7h2.6v1.2h.1c.4-.7 1.2-1.4 2.5-1.4 2.7 0 3.2 1.8 3.2 4.1v4.8z"/></svg>',
		),
		'doctolib'  => array(
			'label' => 'Doctolib',
			'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14.5H11v-5h2v5zm0-7H11V7.5h2V9.5z"/></svg>',
		),
	);

	$items = '';

	foreach ( $networks as $key => $network ) {
		$url = vitalisite_get_option( OPTION_SOCIAL, $key, '' );
		if ( empty( $url ) ) {
			continue;
		}
		$items .= sprintf(
			'<li class="vitalisite-social-link vitalisite-social-link--%1$s"><a href="%2$s" target="_blank" rel="noopener noreferrer" aria-label="%3$s">%4$s</a></li>',
			esc_attr( $key ),
			esc_url( $url ),
			esc_attr( $network['label'] ),
			$network['icon']
		);
	}

	if ( empty( $items ) ) {
		return '';
	}

	return '<ul class="vitalisite-social-links">' . $items . '</ul>';
}
add_shortcode( 'vitalisite_social_links', __NAMESPACE__ . '\render_social_links_shortcode' );
