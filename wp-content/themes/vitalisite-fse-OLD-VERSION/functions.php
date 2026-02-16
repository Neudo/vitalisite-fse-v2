<?php
/**
 * Vitalisite FSE functions and definitions
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'VITALISITE_FSE_VERSION' ) ) {
	define( 'VITALISITE_FSE_VERSION', '1.0.1' );
}

// Désactiver TOUS les caches de patterns en développement
add_filter( 'transient_theme_block_patterns', '__return_false' );
add_filter( 'pre_transient_theme_block_patterns', '__return_false' );
add_filter( 'transient_wp_theme_files_patterns-vitalisite-fse', '__return_false' );
add_filter( 'pre_transient_wp_theme_files_patterns-vitalisite-fse', '__return_false' );

// Supprimer tous les transients de patterns
delete_transient( 'theme_block_patterns' );
delete_transient( 'wp_theme_files_patterns-vitalisite-fse' );

// Désactiver le cache des patterns dans l'éditeur
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function vitalisite_fse_setup() {
	// Add support for responsive embedded content
	add_theme_support( 'responsive-embeds' );

	// Add support for post thumbnails on all post types including CPTs
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'specialities', 'doctors', 'testimonials' ) );

	// Add support for editor styles
	add_theme_support( 'editor-styles' );

	// Add support for full and wide align images
	add_theme_support( 'align-wide' );

	// Add support for custom line height
	add_theme_support( 'custom-line-height' );

	// Add support for custom units
	add_theme_support( 'custom-units' );

	// Add support for custom spacing
	add_theme_support( 'custom-spacing' );

	// Add support for appearance tools
	add_theme_support( 'appearance-tools' );

	// Add support for link color
	add_theme_support( 'link-color' );

	// Add support for border
	add_theme_support( 'border' );

	// Load editor styles (applies to block editor)
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'vitalisite_fse_setup' );

/**
 * Load theme textdomain for translations
 * Chargé sur init pour éviter le warning WordPress 6.7+
 */
function vitalisite_fse_load_textdomain() {
	load_theme_textdomain( 'vitalisite-fse', get_template_directory() . '/languages' );
}
add_action( 'init', 'vitalisite_fse_load_textdomain' );

/**
 * Enqueue theme styles
 */
function vitalisite_fse_enqueue_styles() {
	wp_enqueue_style(
		'vitalisite-fse-style',
		get_stylesheet_uri(),
		array(),
		VITALISITE_FSE_VERSION
	);

	// Styles pour les blocs dynamiques
	wp_enqueue_style(
		'vitalisite-fse-blocks',
		get_template_directory_uri() . '/assets/css/blocks.css',
		array(),
		VITALISITE_FSE_VERSION
	);

	// Dashicons pour les icônes
	wp_enqueue_style( 'dashicons' );

	// GSAP pour les animations
	wp_enqueue_script(
		'gsap',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
		array(),
		'3.12.2',
		true
	);

	// Header responsive JS
	wp_enqueue_script(
		'vitalisite-header-responsive',
		get_template_directory_uri() . '/assets/js/header-responsive.js',
		array( 'gsap' ),
		VITALISITE_FSE_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'vitalisite_fse_enqueue_styles' );

/**
 * Enqueue editor styles and scripts
 */
function vitalisite_fse_enqueue_editor_assets() {
	// Styles
	wp_enqueue_style(
		'vitalisite-fse-blocks-editor',
		get_template_directory_uri() . '/assets/css/blocks.css',
		array(),
		VITALISITE_FSE_VERSION
	);

	wp_enqueue_style(
		'vitalisite-fse-blocks-editor-ui',
		get_template_directory_uri() . '/assets/css/blocks-editor.css',
		array(),
		VITALISITE_FSE_VERSION
	);

	// Scripts pour les blocs
	wp_enqueue_script(
		'vitalisite-fse-blocks-editor',
		get_template_directory_uri() . '/assets/js/blocks-editor.js',
		array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n', 'wp-data' ),
		VITALISITE_FSE_VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'vitalisite_fse_enqueue_editor_assets' );

/**
 * Register block patterns categories
 */
function vitalisite_fse_register_pattern_categories() {
	// Catégorie Pages
	register_block_pattern_category(
		'vitalisite-fse-pages',
		array(
			'label'       => __( 'Pages Vitalisite', 'vitalisite-fse' ),
			'description' => __( 'Modèles de pages complètes pour Vitalisite', 'vitalisite-fse' ),
		)
	);

	// Catégorie Sections
	register_block_pattern_category(
		'vitalisite-fse-sections',
		array(
			'label'       => __( 'Sections Vitalisite', 'vitalisite-fse' ),
			'description' => __( 'Sections réutilisables pour Vitalisite', 'vitalisite-fse' ),
		)
	);

	// Catégorie Heroes
	register_block_pattern_category(
		'vitalisite-heroes',
		array(
			'label'       => __( 'Hero', 'vitalisite-fse' ),
			'description' => __( 'Sections hero pour en-tête de page', 'vitalisite-fse' ),
		)
	);

	// Catégorie Témoignages
	register_block_pattern_category(
		'vitalisite-testimonials',
		array(
			'label'       => __( 'Témoignages', 'vitalisite-fse' ),
			'description' => __( 'Sections de témoignages patients', 'vitalisite-fse' ),
		)
	);

	// Catégorie Contenu (Texte + Image)
	register_block_pattern_category(
		'vitalisite-content',
		array(
			'label'       => __( 'Contenu', 'vitalisite-fse' ),
			'description' => __( 'Sections texte et image', 'vitalisite-fse' ),
		)
	);

	// Catégorie Chiffres clés
	register_block_pattern_category(
		'vitalisite-stats',
		array(
			'label'       => __( 'Chiffres clés', 'vitalisite-fse' ),
			'description' => __( 'Sections de statistiques et chiffres', 'vitalisite-fse' ),
		)
	);

	// Catégorie FAQ
	register_block_pattern_category(
		'vitalisite-faq',
		array(
			'label'       => __( 'FAQ', 'vitalisite-fse' ),
			'description' => __( 'Questions fréquentes', 'vitalisite-fse' ),
		)
	);

	// Catégorie Tarifs
	register_block_pattern_category(
		'vitalisite-pricing',
		array(
			'label'       => __( 'Tarifs', 'vitalisite-fse' ),
			'description' => __( 'Grilles tarifaires', 'vitalisite-fse' ),
		)
	);

	// Catégorie CTA (Call to Action)
	register_block_pattern_category(
		'vitalisite-cta',
		array(
			'label'       => __( 'Call to Action', 'vitalisite-fse' ),
			'description' => __( 'Sections d\'appel à l\'action', 'vitalisite-fse' ),
		)
	);

	// Catégorie Réservation
	register_block_pattern_category(
		'vitalisite-booking',
		array(
			'label'       => __( 'Réservation', 'vitalisite-fse' ),
			'description' => __( 'Widgets de prise de rendez-vous', 'vitalisite-fse' ),
		)
	);
}
add_action( 'init', 'vitalisite_fse_register_pattern_categories' );

/**
 * Register custom block styles
 */
function vitalisite_fse_register_block_styles() {
	// Style pour les boutons arrondis
	register_block_style(
		'core/button',
		array(
			'name'         => 'rounded-full',
			'label'        => __( 'Arrondi complet', 'vitalisite-fse' ),
			'inline_style' => '.wp-block-button.is-style-rounded-full .wp-block-button__link { border-radius: 9999px; }',
		)
	);

	// Style pour les listes avec checkmarks
	register_block_style(
		'core/list',
		array(
			'name'         => 'checkmark-list',
			'label'        => __( 'Liste avec checkmarks', 'vitalisite-fse' ),
			'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "✓";
				}
				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}
			',
		)
	);
}
add_action( 'init', 'vitalisite_fse_register_block_styles' );

/**
 * Inclure le Setup Wizard
 */
require_once get_template_directory() . '/inc/setup-wizard.php';

/**
 * Inclure l'intégration avec le plugin Vitalisite Core
 */
require_once get_template_directory() . '/inc/plugin-integration.php';

/**
 * Inclure la page de paramètres admin
 */
require_once get_template_directory() . '/inc/admin-settings.php';

/**
 * Inclure le sélecteur de style du thème
 */
require_once get_template_directory() . '/inc/theme-style-selector.php';

/**
 * Inclure les Custom Post Types
 */
require_once get_template_directory() . '/inc/cpt/class-cpt-specialities.php';
require_once get_template_directory() . '/inc/cpt/class-cpt-testimonials.php';
require_once get_template_directory() . '/inc/cpt/class-cpt-doctors.php';

/**
 * Inclure les blocs dynamiques
 */
require_once get_template_directory() . '/inc/blocks/class-block-testimonials.php';
require_once get_template_directory() . '/inc/blocks/class-block-specialities.php';
require_once get_template_directory() . '/inc/blocks/class-block-team.php';
require_once get_template_directory() . '/inc/blocks/class-block-hero.php';

/**
 * Inclure le bandeau d'annonce
 */
require_once get_template_directory() . '/inc/class-announcement-bar.php';

/**
 * Inclure TGMPA pour les plugins recommandés
 */
require_once get_template_directory() . '/inc/class-tgmpa-config.php';

/**
 * Récupère les informations du médecin
 * 
 * @param string $key Clé spécifique à récupérer (optionnel)
 * @return mixed Toutes les infos ou une info spécifique
 */
function vitalisite_get_doctor_info( $key = '' ) {
	$doctor_info = get_option( 'vitalisite_doctor_info', array() );
	
	if ( empty( $key ) ) {
		return $doctor_info;
	}
	
	return isset( $doctor_info[ $key ] ) ? $doctor_info[ $key ] : '';
}

/**
 * Affiche les informations du médecin
 * Helper pour utilisation dans les patterns
 * 
 * @param string $key Clé à afficher
 * @param bool $echo Afficher ou retourner
 * @return string|void
 */
function vitalisite_doctor_info( $key, $echo = true ) {
	$value = vitalisite_get_doctor_info( $key );
	
	if ( $echo ) {
		echo esc_html( $value );
	} else {
		return $value;
	}
}

/**
 * Vérifie si le setup wizard a été complété
 * 
 * @return bool
 */
function vitalisite_is_setup_complete() {
	return (bool) get_option( 'vitalisite_setup_complete', false );
}

/**
 * Enqueue media uploader pour le wizard
 */
function vitalisite_fse_enqueue_media() {
	if ( isset( $_GET['page'] ) && $_GET['page'] === 'vitalisite-setup-wizard' ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'vitalisite_fse_enqueue_media' );

/**
 * AJAX : Réinitialiser le wizard
 */
function vitalisite_reset_wizard_ajax() {
	check_ajax_referer( 'vitalisite_reset_wizard', 'nonce' );
	
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => __( 'Permission refusée', 'vitalisite-fse' ) ) );
	}
	
	// Supprimer les options
	delete_option( 'vitalisite_setup_complete' );
	delete_option( 'vitalisite_doctor_info' );
	
	// Rediriger vers le wizard
	wp_send_json_success( array(
		'redirect' => admin_url( 'themes.php?page=vitalisite-setup-wizard' )
	) );
}
add_action( 'wp_ajax_vitalisite_reset_wizard', 'vitalisite_reset_wizard_ajax' );