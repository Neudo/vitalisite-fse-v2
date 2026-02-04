<?php
/**
 * Style Variations pour Vitalisite FSE
 * 
 * Les variations de style sont gérées nativement par WordPress
 * via les fichiers JSON dans le dossier /styles/
 * 
 * - styles/bento.json  
 * - styles/minimal.json
 *
 * Pour changer de style :
 * Apparence > Éditeur > Styles > Parcourir les styles (icône en haut à droite)
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Les Style Variations sont automatiquement détectées par WordPress
// à partir des fichiers JSON dans le dossier /styles/
// Aucun code PHP supplémentaire n'est nécessaire.

/**
 * Récupère le nom du style de thème actuellement sélectionné
 * 
 * Détecte le style en comparant le border-radius des boutons :
 * - Bento : 24px
 * - Minimal : 0 (carré)
 * - Default : 5px
 * 
 * @return string Le slug du style (bento, classique, minimal) ou 'default'
 */
function vitalisite_get_current_style_variation() {
	// Récupérer les données fusionnées (theme + user)
	$merged_data = WP_Theme_JSON_Resolver::get_merged_data();
	$raw_data = $merged_data->get_raw_data();
	
	// Vérifier le border-radius des boutons pour identifier le style
	$button_radius = '';
	
	// Chercher dans les éléments button
	if ( isset( $raw_data['styles']['elements']['button']['border']['radius'] ) ) {
		$button_radius = $raw_data['styles']['elements']['button']['border']['radius'];
	}
	// Ou dans le bloc core/button
	elseif ( isset( $raw_data['styles']['blocks']['core/button']['border']['radius'] ) ) {
		$button_radius = $raw_data['styles']['blocks']['core/button']['border']['radius'];
	}
	
	// Identifier le style basé sur le border-radius
	if ( $button_radius === '24px' ) {
		return 'bento';
	} elseif ( $button_radius === '0' || $button_radius === '0px' ) {
		return 'minimal';
	}
	
	// Par défaut
	return 'default';
}

/**
 * Ajoute une classe au body en fonction du style de thème sélectionné
 * 
 * @param array $classes Classes existantes du body
 * @return array Classes modifiées
 */
function vitalisite_add_style_variation_body_class( $classes ) {
	$style_variation = vitalisite_get_current_style_variation();
	
	if ( $style_variation && $style_variation !== 'default' ) {
		$classes[] = 'theme-style-' . $style_variation;
	}
	
	return $classes;
}
add_filter( 'body_class', 'vitalisite_add_style_variation_body_class' );

/**
 * Ajoute la classe au body via JavaScript (pour les thèmes FSE)
 * et injecte le CSS pour le style Bento
 */
function vitalisite_style_variation_scripts() {
	$style_variation = vitalisite_get_current_style_variation();
	
	if ( $style_variation && $style_variation !== 'default' ) {
		$class_name = 'theme-style-' . $style_variation;
		?>
		<script>
			document.body.classList.add('<?php echo esc_js( $class_name ); ?>');
		</script>
		<?php
		
		
	}
}
add_action( 'wp_body_open', 'vitalisite_style_variation_scripts' );

/**
 * Ajoute les styles spécifiques au style variation dans l'éditeur
 * 
 * Injecte les styles CSS directement dans l'éditeur pour que le rendu
 * corresponde au front-end.
 */
function vitalisite_editor_style_variation_styles() {
	$style_variation = vitalisite_get_current_style_variation();
	
	// Définir le border-radius selon le style
	$border_radius = '5px'; // classique par défaut
	if ( $style_variation === 'bento' ) {
		$border_radius = '24px';
	} elseif ( $style_variation === 'minimal' ) {
		$border_radius = '0';
	}
	
	$css = '.has-theme-border-radius { border-radius: ' . $border_radius . ' !important; }';
	
	if ( $style_variation === 'bento' ) {
		$css .= '
			.entry-content {
				padding: 0 30px;
			}
		';
	}
	
	wp_add_inline_style( 'wp-edit-blocks', $css );
}
add_action( 'enqueue_block_editor_assets', 'vitalisite_editor_style_variation_styles' );

/**
 * Enqueue le script de synchronisation des styles dans l'éditeur
 */
function vitalisite_enqueue_editor_style_switcher() {
	wp_enqueue_script(
		'vitalisite-editor-style-switcher',
		get_template_directory_uri() . '/assets/js/editor-style-switcher.js',
		[],
		filemtime( get_template_directory() . '/assets/js/editor-style-switcher.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'vitalisite_enqueue_editor_style_switcher' );


/**
 * Récupère le border-radius du thème actuel
 * 
 * @return string Le border-radius (ex: '7px', '0', '16px')
 */
function vitalisite_get_border_radius() {
	$style = vitalisite_get_current_style_variation();
	
	switch ( $style ) {
		case 'bento':
			return '24px';
		case 'minimal':
			return '0';
		default:
			return '5px';
	}
}
