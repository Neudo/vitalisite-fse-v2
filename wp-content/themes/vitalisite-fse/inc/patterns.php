<?php
/**
 * Register block pattern categories, custom blocks, and filter unwanted patterns.
 *
 * This file is included from within the Vitalisite_FSE namespace.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * All allowed pattern categories — single source of truth.
 */
function get_pattern_categories() {
	return array(
		'vitalisite'            => __( 'Vitalisite', 'vitalisite-fse' ),
		'vitalisite-blocks'     => __( 'Vitalisite Blocks', 'vitalisite-fse' ),
		'vitalisite-header'     => __( 'Header Vitalisite', 'vitalisite-fse' ),
		'vitalisite-footer'     => __( 'Footer Vitalisite', 'vitalisite-fse' ),
		'banniere-vitalisite'   => __( 'Bannière Vitalisite', 'vitalisite-fse' ),
		'vitalisite-carrousel'  => __( 'Carrousel', 'vitalisite-fse' ),
		'vitalisite-bento'      => __( 'Bento Grid', 'vitalisite-fse' ),
		'vitalisite-accordion'  => __( 'FAQ / Accordion', 'vitalisite-fse' ),
		'vitalisite-cards'        => __( 'Cards', 'vitalisite-fse' ),
		'vitalisite-video'        => __( 'Vidéo', 'vitalisite-fse' ),
		'vitalisite-testimonials'  => __( 'Témoignages', 'vitalisite-fse' ),
		'vitalisite-before-after'  => __( 'Avant / Après', 'vitalisite-fse' ),
		'vitalisite-text-image'      => __( 'Texte + Image', 'vitalisite-fse' ),
		'vitalisite-pricing'         => __( 'Tarifs', 'vitalisite-fse' ),
		'vitalisite-doctor'          => __( 'Présentation Docteur', 'vitalisite-fse' ),
		'vitalisite-opening-hours'   => __( 'Horaires d\'ouverture', 'vitalisite-fse' ),
	);
}

/**
 * Register pattern categories + custom blocks.
 */
function register_patterns_and_blocks() {
	// Register all pattern categories.
	foreach ( get_pattern_categories() as $slug => $label ) {
		register_block_pattern_category( $slug, array( 'label' => $label ) );
	}

	// Register custom blocks.
	$build_dir = get_template_directory() . '/build';

	$blocks = array(
		'slider',
		'cards-container',
		'card',
		'accordion',
		'accordion-item',
		'text-image',
	);

	foreach ( $blocks as $block ) {
		register_block_type( $build_dir . '/' . $block );
	}

	// Blocks with server-side render callbacks (global namespace functions).
	$ssr_blocks = array(
		'testimonials'  => 'vitalisite_render_testimonials_block',
		'video'         => 'vitalisite_render_video_block',
		'before-after'   => 'vitalisite_render_before_after_block',
		'opening-hours'  => 'vitalisite_render_opening_hours_block',
	);

	foreach ( $ssr_blocks as $block => $callback ) {
		register_block_type( $build_dir . '/' . $block, array(
			'render_callback' => $callback,
		) );
	}
}
add_action( 'init', __NAMESPACE__ . '\register_patterns_and_blocks' );

/**
 * Register custom block categories for the inserter.
 */
function register_block_categories( $categories ) {
	$custom = array(
		array( 'slug' => 'vitalisite-blocks', 'title' => __( 'Vitalisite', 'vitalisite-fse' ), 'icon' => null ),
	);

	return array_merge( $custom, $categories );
}
add_filter( 'block_categories_all', __NAMESPACE__ . '\register_block_categories' );

/**
 * Remove non-theme pattern categories and patterns.
 */
function filter_patterns() {
	$allowed_slugs = array_keys( get_pattern_categories() );

	if ( class_exists( 'WP_Block_Pattern_Categories_Registry' ) ) {
		$registry = \WP_Block_Pattern_Categories_Registry::get_instance();
		foreach ( $registry->get_all_registered() as $category ) {
			if ( ! in_array( $category['name'], $allowed_slugs, true ) ) {
				$registry->unregister( $category['name'] );
			}
		}
	}

	if ( class_exists( 'WP_Block_Patterns_Registry' ) ) {
		$registry = \WP_Block_Patterns_Registry::get_instance();
		foreach ( $registry->get_all_registered() as $pattern ) {
			$name        = isset( $pattern['name'] ) ? $pattern['name'] : '';
			$cats        = isset( $pattern['categories'] ) ? $pattern['categories'] : array();
			$has_allowed = array_intersect( $cats, $allowed_slugs );
			$is_theme    = str_starts_with( $name, 'vitalisite-fse/' );

			if ( ! $is_theme && empty( $has_allowed ) ) {
				$registry->unregister( $name );
			}
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\filter_patterns', 100 );
