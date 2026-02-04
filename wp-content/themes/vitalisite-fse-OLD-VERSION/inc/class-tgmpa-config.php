<?php
/**
 * TGMPA Configuration - Required Plugins
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/lib/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 */
function vitalisite_fse_register_required_plugins() {
	$plugins = array(
		// Plugin depuis le repo WordPress
		array(
			'name'     => 'Secure Custom Fields',
			'slug'     => 'secure-custom-fields',
			'required' => false,
		),
		// Optimisation d'images
		array(
			'name'     => 'Image Optimization',
			'slug'     => 'image-optimization',
			'required' => false,
		),
		// SEO
		array(
			'name'     => 'All in One SEO Pack',
			'slug'     => 'all-in-one-seo-pack',
			'required' => false,
		),
		// Formulaires
		array(
			'name'     => 'WPForms Lite',
			'slug'     => 'wpforms-lite',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'vitalisite-fse',
		'default_path' => '',
		'menu'         => 'vitalisite-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => __( 'Installer les plugins recommandés', 'vitalisite-fse' ),
			'menu_title'                      => __( 'Plugins Vitalisite', 'vitalisite-fse' ),
			'installing'                      => __( 'Installation du plugin: %s', 'vitalisite-fse' ),
			'updating'                        => __( 'Mise à jour du plugin: %s', 'vitalisite-fse' ),
			'oops'                            => __( 'Une erreur est survenue avec l\'API du plugin.', 'vitalisite-fse' ),
			'notice_can_install_required'     => _n_noop(
				'Ce thème nécessite le plugin suivant: %1$s.',
				'Ce thème nécessite les plugins suivants: %1$s.',
				'vitalisite-fse'
			),
			'notice_can_install_recommended'  => _n_noop(
				'Ce thème recommande le plugin suivant: %1$s.',
				'Ce thème recommande les plugins suivants: %1$s.',
				'vitalisite-fse'
			),
			'notice_ask_to_update'            => _n_noop(
				'Le plugin suivant nécessite une mise à jour pour assurer une compatibilité maximale avec ce thème: %1$s.',
				'Les plugins suivants nécessitent une mise à jour pour assurer une compatibilité maximale avec ce thème: %1$s.',
				'vitalisite-fse'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'Une mise à jour est disponible pour: %1$s.',
				'Des mises à jour sont disponibles pour: %1$s.',
				'vitalisite-fse'
			),
			'notice_can_activate_required'    => _n_noop(
				'Le plugin requis suivant est actuellement inactif: %1$s.',
				'Les plugins requis suivants sont actuellement inactifs: %1$s.',
				'vitalisite-fse'
			),
			'notice_can_activate_recommended' => _n_noop(
				'Le plugin recommandé suivant est actuellement inactif: %1$s.',
				'Les plugins recommandés suivants sont actuellement inactifs: %1$s.',
				'vitalisite-fse'
			),
			'install_link'                    => _n_noop(
				'Installer le plugin',
				'Installer les plugins',
				'vitalisite-fse'
			),
			'update_link'                     => _n_noop(
				'Mettre à jour le plugin',
				'Mettre à jour les plugins',
				'vitalisite-fse'
			),
			'activate_link'                   => _n_noop(
				'Activer le plugin',
				'Activer les plugins',
				'vitalisite-fse'
			),
			'return'                          => __( 'Retour à l\'installateur de plugins', 'vitalisite-fse' ),
			'plugin_activated'                => __( 'Plugin activé avec succès.', 'vitalisite-fse' ),
			'activated_successfully'          => __( 'Le plugin suivant a été activé avec succès:', 'vitalisite-fse' ),
			'plugin_already_active'           => __( 'Aucune action requise. Le plugin %1$s est déjà actif.', 'vitalisite-fse' ),
			'plugin_needs_higher_version'     => __( 'Le plugin %1$s est déjà installé, mais une version plus récente est requise. Veuillez mettre à jour le plugin.', 'vitalisite-fse' ),
			'complete'                        => __( 'Tous les plugins ont été installés et activés avec succès. %1$s', 'vitalisite-fse' ),
			'dismiss'                         => __( 'Ignorer ce message', 'vitalisite-fse' ),
			'notice_cannot_install_activate'  => __( 'Un ou plusieurs plugins requis ou recommandés doivent être installés, mis à jour ou activés.', 'vitalisite-fse' ),
			'contact_admin'                   => __( 'Veuillez contacter l\'administrateur de ce site pour obtenir de l\'aide.', 'vitalisite-fse' ),
			'nag_type'                        => 'updated',
		),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'vitalisite_fse_register_required_plugins' );
