<?php
/**
 * Classe pour le bloc Hero React
 *
 * @package Vitalisite_FSE
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe Vitalisite_Block_Hero
 */
class Vitalisite_Block_Hero {

	/**
	 * Constructeur
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_block' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_editor_styles' ] );
	}

	/**
	 * Enregistre le bloc
	 */
	public function register_block() {
		$block_path = get_template_directory() . '/build/blocks/hero';
		
		// Vérifier si le bloc a été buildé
		if ( ! file_exists( $block_path . '/block.json' ) ) {
			return;
		}

		register_block_type( $block_path );
	}

	/**
	 * Force le chargement des styles dans l'éditeur
	 */
	public function enqueue_editor_styles() {
		$style_path = get_template_directory() . '/build/blocks/hero/style-index.css';
		
		if ( file_exists( $style_path ) ) {
			wp_enqueue_style(
				'vitalisite-hero-editor-style',
				get_template_directory_uri() . '/build/blocks/hero/style-index.css',
				[],
				filemtime( $style_path )
			);
		}
	}
}

// Initialiser
new Vitalisite_Block_Hero();
