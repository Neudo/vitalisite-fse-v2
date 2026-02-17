<?php
/**
 * Vitalisite Setup Wizard.
 *
 * A 4-step guided setup for new theme installations:
 *   1. License activation (next blocked until active)
 *   2. Cabinet info (doctor name, phone, email, address, specialty, appointment URL)
 *   3. Horaires & Réseaux sociaux
 *   4. Personnalisation (how to choose a style variation)
 *
 * @package Vitalisite_FSE
 * @since   1.0.0
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ------------------------------------------------------------------ */
/*  1. Register submenu page under Vitalisite                         */
/* ------------------------------------------------------------------ */

function wizard_menu() {
	add_submenu_page(
		'vitalisite-settings',
		__( 'Assistant de configuration', 'vitalisite-fse' ),
		__( 'Assistant', 'vitalisite-fse' ),
		'manage_options',
		'vitalisite-wizard',
		__NAMESPACE__ . '\render_wizard_page'
	);
}
add_action( 'admin_menu', __NAMESPACE__ . '\wizard_menu' );

/* ------------------------------------------------------------------ */
/*  2. Redirect to wizard on first activation                         */
/* ------------------------------------------------------------------ */

function maybe_redirect_to_wizard() {
	if ( get_option( 'vitalisite_wizard_redirect' ) ) {
		delete_option( 'vitalisite_wizard_redirect' );
		if ( ! isset( $_GET['activate-multi'] ) ) {
			wp_safe_redirect( admin_url( 'admin.php?page=vitalisite-wizard' ) );
			exit;
		}
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\maybe_redirect_to_wizard' );

/**
 * Set redirect flag on theme activation.
 */
function set_wizard_redirect() {
	if ( ! get_option( OPTION_LICENSE_STATUS ) ) {
		update_option( 'vitalisite_wizard_redirect', true );
	}
}
add_action( 'after_switch_theme', __NAMESPACE__ . '\set_wizard_redirect' );

/* ------------------------------------------------------------------ */
/*  3. Enqueue wizard assets                                          */
/* ------------------------------------------------------------------ */

function enqueue_wizard_assets( $hook ) {
	if ( 'vitalisite_page_vitalisite-wizard' !== $hook ) {
		return;
	}

	$uri     = get_template_directory_uri();
	$version = VITALISITE_FSE_VERSION;

	wp_enqueue_style( 'vitalisite-wizard', $uri . '/assets/admin/wizard.css', array(), $version );
	wp_enqueue_script( 'vitalisite-wizard', $uri . '/assets/admin/wizard.js', array(), $version, true );
	wp_localize_script( 'vitalisite-wizard', 'vitalisiteWizard', array(
		'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
		'nonce'         => wp_create_nonce( 'vitalisite_license_nonce' ),
		'settingsUrl'   => admin_url( 'admin.php?page=vitalisite-settings' ),
		'licenseActive' => is_license_active(),
	) );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_wizard_assets' );

/* ------------------------------------------------------------------ */
/*  4. Render wizard page                                             */
/* ------------------------------------------------------------------ */

function render_wizard_page() {
	$current_step = isset( $_GET['step'] ) ? absint( $_GET['step'] ) : 1;
	$current_step = max( 1, min( 4, $current_step ) );

	$steps = array(
		1 => __( 'Licence', 'vitalisite-fse' ),
		2 => __( 'Cabinet', 'vitalisite-fse' ),
		3 => __( 'Horaires & Réseaux', 'vitalisite-fse' ),
		4 => __( 'Personnalisation', 'vitalisite-fse' ),
	);
	?>
	<div class="vitalisite-wizard-wrap">
		<div class="vitalisite-wizard">

			<!-- Header -->
			<div class="vitalisite-wizard__header">
				<h1 class="vitalisite-wizard__title">
					<span class="dashicons dashicons-heart"></span>
					<?php esc_html_e( 'Vitalisite — Assistant de configuration', 'vitalisite-fse' ); ?>
				</h1>
			</div>

			<!-- Steps indicator -->
			<div class="vitalisite-wizard__steps">
				<?php foreach ( $steps as $num => $label ) :
					$class = 'vitalisite-wizard__step';
					if ( $num === $current_step ) {
						$class .= ' vitalisite-wizard__step--active';
					} elseif ( $num < $current_step ) {
						$class .= ' vitalisite-wizard__step--done';
					}
				?>
					<div class="<?php echo esc_attr( $class ); ?>">
						<span class="vitalisite-wizard__step-number"><?php echo esc_html( $num ); ?></span>
						<span class="vitalisite-wizard__step-label"><?php echo esc_html( $label ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Step content -->
			<div class="vitalisite-wizard__content">
				<?php
				switch ( $current_step ) {
					case 1:
						render_wizard_step_license();
						break;
					case 2:
						render_wizard_step_cabinet();
						break;
					case 3:
						render_wizard_step_hours_social();
						break;
					case 4:
						render_wizard_step_personalization();
						break;
				}
				?>
			</div>

		</div>
	</div>
	<?php
}

/* ------------------------------------------------------------------ */
/*  Step 1: License                                                   */
/* ------------------------------------------------------------------ */

function render_wizard_step_license() {
	$is_active = is_license_active();
	$key       = get_license_key();
	?>
	<div class="vitalisite-wizard__step-content" data-step="1">
		<h2><?php esc_html_e( 'Activation de votre licence', 'vitalisite-fse' ); ?></h2>
		<p><?php esc_html_e( 'Saisissez la clé de licence reçue par email pour activer le thème.', 'vitalisite-fse' ); ?></p>

		<?php if ( $is_active ) : ?>
			<div class="vitalisite-wizard__notice vitalisite-wizard__notice--success">
				<span class="dashicons dashicons-yes-alt"></span>
				<?php esc_html_e( 'Licence activée !', 'vitalisite-fse' ); ?>
			</div>
			<div class="vitalisite-wizard__license-info">
				<code><?php echo esc_html( substr( $key, 0, 8 ) . '••••••••' ); ?></code>
				<button type="button" class="button vitalisite-wizard__btn-deactivate" id="vitalisite-deactivate-license">
					<?php esc_html_e( 'Désactiver', 'vitalisite-fse' ); ?>
				</button>
			</div>
		<?php else : ?>
			<div class="vitalisite-wizard__license-form">
				<input type="text" id="vitalisite-license-key" class="regular-text" placeholder="<?php esc_attr_e( 'XXXX-XXXX-XXXX-XXXX', 'vitalisite-fse' ); ?>">
				<button type="button" class="button button-primary" id="vitalisite-activate-license">
					<?php esc_html_e( 'Activer la licence', 'vitalisite-fse' ); ?>
				</button>
			</div>
		<?php endif; ?>

		<div class="vitalisite-wizard__feedback" id="vitalisite-license-feedback" hidden></div>

		<div class="vitalisite-wizard__nav">
			<span></span>
			<?php if ( $is_active ) : ?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=2' ) ); ?>" class="button button-primary button-hero" id="vitalisite-wizard-next">
					<?php esc_html_e( 'Suivant →', 'vitalisite-fse' ); ?>
				</a>
			<?php else : ?>
				<span class="button button-primary button-hero vitalisite-wizard__btn-disabled" id="vitalisite-wizard-next" title="<?php esc_attr_e( 'Activez votre licence pour continuer', 'vitalisite-fse' ); ?>">
					<?php esc_html_e( 'Suivant →', 'vitalisite-fse' ); ?>
				</span>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/* ------------------------------------------------------------------ */
/*  Step 2: Cabinet info                                              */
/* ------------------------------------------------------------------ */

function render_wizard_step_cabinet() {
	$cabinet = get_option( OPTION_CABINET, array() );
	$fields  = array(
		'doctor_name' => array(
			'label'       => __( 'Nom du praticien', 'vitalisite-fse' ),
			'placeholder' => 'Dr. Jean Dupont',
			'type'        => 'text',
		),
		'doctor_specialty' => array(
			'label'       => __( 'Spécialité', 'vitalisite-fse' ),
			'placeholder' => 'Ostéopathe D.O.',
			'type'        => 'text',
		),
		'phone' => array(
			'label'       => __( 'Téléphone', 'vitalisite-fse' ),
			'placeholder' => '01 42 42 42 42',
			'type'        => 'tel',
		),
		'email' => array(
			'label'       => __( 'Email de contact', 'vitalisite-fse' ),
			'placeholder' => 'contact@cabinet.fr',
			'type'        => 'email',
		),
		'address' => array(
			'label'       => __( 'Adresse du cabinet', 'vitalisite-fse' ),
			'placeholder' => '1 rue de la Liberté, 75013 Paris',
			'type'        => 'text',
		),
		'appointment_url' => array(
			'label'       => __( 'Lien de prise de RDV', 'vitalisite-fse' ),
			'placeholder' => 'https://www.doctolib.fr/…',
			'type'        => 'url',
		),
	);
	?>
	<div class="vitalisite-wizard__step-content" data-step="2">
		<h2><?php esc_html_e( 'Informations du cabinet', 'vitalisite-fse' ); ?></h2>
		<p><?php esc_html_e( 'Ces informations seront utilisées dans le header, footer et les patterns du thème.', 'vitalisite-fse' ); ?></p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=2' ) ); ?>" class="vitalisite-wizard__form">
			<?php wp_nonce_field( 'vitalisite_wizard_cabinet', '_wizard_cabinet_nonce' ); ?>

			<?php foreach ( $fields as $id => $field ) :
				$value = isset( $cabinet[ $id ] ) ? $cabinet[ $id ] : '';
			?>
				<div class="vitalisite-wizard__field">
					<label for="vitalisite_<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
					<input
						type="<?php echo esc_attr( $field['type'] ); ?>"
						id="vitalisite_<?php echo esc_attr( $id ); ?>"
						name="cabinet[<?php echo esc_attr( $id ); ?>]"
						value="<?php echo esc_attr( $value ); ?>"
						placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"
						class="regular-text"
					>
				</div>
			<?php endforeach; ?>

			<div class="vitalisite-wizard__nav">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=1' ) ); ?>" class="button">
					<?php esc_html_e( '← Précédent', 'vitalisite-fse' ); ?>
				</a>
				<button type="submit" class="button button-primary button-hero">
					<?php esc_html_e( 'Enregistrer et continuer →', 'vitalisite-fse' ); ?>
				</button>
			</div>
		</form>
	</div>
	<?php
}

/* ------------------------------------------------------------------ */
/*  Step 3: Hours & Social                                            */
/* ------------------------------------------------------------------ */

function render_wizard_step_hours_social() {
	$hours  = get_option( OPTION_HOURS, array() );
	$social = get_option( OPTION_SOCIAL, array() );

	$days = array(
		'monday'    => __( 'Lundi', 'vitalisite-fse' ),
		'tuesday'   => __( 'Mardi', 'vitalisite-fse' ),
		'wednesday' => __( 'Mercredi', 'vitalisite-fse' ),
		'thursday'  => __( 'Jeudi', 'vitalisite-fse' ),
		'friday'    => __( 'Vendredi', 'vitalisite-fse' ),
		'saturday'  => __( 'Samedi', 'vitalisite-fse' ),
		'sunday'    => __( 'Dimanche', 'vitalisite-fse' ),
	);

	$social_fields = array(
		'facebook'    => array( 'label' => 'Facebook',    'placeholder' => 'https://facebook.com/…' ),
		'instagram'   => array( 'label' => 'Instagram',   'placeholder' => 'https://instagram.com/…' ),
		'linkedin'    => array( 'label' => 'LinkedIn',    'placeholder' => 'https://linkedin.com/in/…' ),
		'doctolib'    => array( 'label' => 'Doctolib',    'placeholder' => 'https://www.doctolib.fr/…' ),
		'google_maps' => array( 'label' => 'Google Maps', 'placeholder' => 'https://maps.google.com/…' ),
	);
	?>
	<div class="vitalisite-wizard__step-content" data-step="3">
		<h2><?php esc_html_e( 'Horaires & Réseaux sociaux', 'vitalisite-fse' ); ?></h2>
		<p><?php esc_html_e( 'Configurez vos horaires d\'ouverture et vos liens de réseaux sociaux.', 'vitalisite-fse' ); ?></p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=3' ) ); ?>" class="vitalisite-wizard__form">
			<?php wp_nonce_field( 'vitalisite_wizard_hours_social', '_wizard_hours_social_nonce' ); ?>

			<!-- Hours -->
			<h3><?php esc_html_e( 'Horaires d\'ouverture', 'vitalisite-fse' ); ?></h3>

			<table class="widefat vitalisite-wizard__hours-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Jour', 'vitalisite-fse' ); ?></th>
						<th><?php esc_html_e( 'Fermé', 'vitalisite-fse' ); ?></th>
						<th><?php esc_html_e( 'Ouverture', 'vitalisite-fse' ); ?></th>
						<th><?php esc_html_e( 'Fermeture', 'vitalisite-fse' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $days as $key => $label ) :
						$day_data   = isset( $hours[ $key ] ) ? $hours[ $key ] : array();
						$is_closed  = ! empty( $day_data['closed'] );
						$open_time  = isset( $day_data['open'] ) ? $day_data['open'] : '09:00';
						$close_time = isset( $day_data['close'] ) ? $day_data['close'] : '18:00';
					?>
					<tr>
						<td><strong><?php echo esc_html( $label ); ?></strong></td>
						<td>
							<input type="checkbox" name="hours[<?php echo esc_attr( $key ); ?>][closed]" value="1" <?php checked( $is_closed ); ?>>
						</td>
						<td>
							<input type="time" name="hours[<?php echo esc_attr( $key ); ?>][open]" value="<?php echo esc_attr( $open_time ); ?>">
						</td>
						<td>
							<input type="time" name="hours[<?php echo esc_attr( $key ); ?>][close]" value="<?php echo esc_attr( $close_time ); ?>">
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<!-- Social -->
			<h3 style="margin-top: 2em;"><?php esc_html_e( 'Réseaux sociaux', 'vitalisite-fse' ); ?></h3>

			<?php foreach ( $social_fields as $id => $field ) :
				$value = isset( $social[ $id ] ) ? $social[ $id ] : '';
			?>
				<div class="vitalisite-wizard__field">
					<label for="vitalisite_social_<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
					<input
						type="url"
						id="vitalisite_social_<?php echo esc_attr( $id ); ?>"
						name="social[<?php echo esc_attr( $id ); ?>]"
						value="<?php echo esc_attr( $value ); ?>"
						placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"
						class="regular-text"
					>
				</div>
			<?php endforeach; ?>

			<div class="vitalisite-wizard__nav">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=2' ) ); ?>" class="button">
					<?php esc_html_e( '← Précédent', 'vitalisite-fse' ); ?>
				</a>
				<button type="submit" class="button button-primary button-hero">
					<?php esc_html_e( 'Enregistrer et continuer →', 'vitalisite-fse' ); ?>
				</button>
			</div>
		</form>
	</div>
	<?php
}

/* ------------------------------------------------------------------ */
/*  Step 4: Personalization (how to choose a style)                   */
/* ------------------------------------------------------------------ */

function render_wizard_step_personalization() {
	$styles_dir = get_template_directory() . '/styles';
	$variations = array();

	foreach ( glob( $styles_dir . '/*.json' ) as $file ) {
		$slug  = basename( $file, '.json' );
		$data  = json_decode( file_get_contents( $file ), true );
		$title = isset( $data['title'] ) ? $data['title'] : ucfirst( $slug );
		$variations[ $slug ] = $title;
	}
	?>
	<div class="vitalisite-wizard__step-content" data-step="4">
		<div class="vitalisite-wizard__done">
			<span class="vitalisite-wizard__done-icon dashicons dashicons-yes-alt"></span>
			<h2><?php esc_html_e( 'Configuration terminée !', 'vitalisite-fse' ); ?></h2>
			<p><?php esc_html_e( 'Votre site est prêt. Il ne reste plus qu\'à choisir le style visuel qui vous correspond.', 'vitalisite-fse' ); ?></p>
		</div>

		<div class="vitalisite-wizard__personalization-guide">
			<h3><?php esc_html_e( 'Comment personnaliser votre site ?', 'vitalisite-fse' ); ?></h3>

			<ol class="vitalisite-wizard__guide-steps">
				<li>
					<?php
					printf(
						esc_html__( 'Ouvrez l\'%s (Apparence → Éditeur)', 'vitalisite-fse' ),
						'<a href="' . esc_url( admin_url( 'site-editor.php' ) ) . '"><strong>' . esc_html__( 'Éditeur de site', 'vitalisite-fse' ) . '</strong></a>'
					);
					?>
				</li>
				<li><?php esc_html_e( 'Cliquez sur « Styles » dans le menu latéral gauche', 'vitalisite-fse' ); ?></li>
				<li><?php esc_html_e( 'Cliquez sur « Parcourir les styles »', 'vitalisite-fse' ); ?></li>
				<li><?php esc_html_e( 'Choisissez parmi les variations disponibles et cliquez pour appliquer', 'vitalisite-fse' ); ?></li>
				<li><?php esc_html_e( 'Cliquez sur « Enregistrer » en haut à droite pour sauvegarder', 'vitalisite-fse' ); ?></li>
			</ol>


		<div class="vitalisite-wizard__done-actions">
			<a href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>" class="button button-primary button-hero">
				<span class="dashicons dashicons-admin-customizer"></span>
				<?php esc_html_e( 'Ouvrir l\'éditeur de site', 'vitalisite-fse' ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-settings' ) ); ?>" class="button button-hero">
				<span class="dashicons dashicons-admin-settings"></span>
				<?php esc_html_e( 'Réglages Vitalisite', 'vitalisite-fse' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-hero" target="_blank">
				<span class="dashicons dashicons-external"></span>
				<?php esc_html_e( 'Voir le site', 'vitalisite-fse' ); ?>
			</a>
		</div>

		<div class="vitalisite-wizard__nav">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=3' ) ); ?>" class="button">
				<?php esc_html_e( '← Précédent', 'vitalisite-fse' ); ?>
			</a>
			<span></span>
		</div>
	</div>
	<?php
}

/* ------------------------------------------------------------------ */
/*  5. Handle step 2 form submission (Cabinet)                        */
/* ------------------------------------------------------------------ */

function handle_wizard_cabinet_save() {
	if ( ! isset( $_POST['_wizard_cabinet_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['_wizard_cabinet_nonce'], 'vitalisite_wizard_cabinet' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$cabinet = get_option( OPTION_CABINET, array() );
	$input   = isset( $_POST['cabinet'] ) ? (array) $_POST['cabinet'] : array();

	$sanitize_map = array(
		'doctor_name'      => 'sanitize_text_field',
		'doctor_specialty' => 'sanitize_text_field',
		'phone'            => 'sanitize_text_field',
		'email'            => 'sanitize_email',
		'address'          => 'sanitize_text_field',
		'appointment_url'  => 'esc_url_raw',
	);

	foreach ( $sanitize_map as $key => $callback ) {
		if ( isset( $input[ $key ] ) ) {
			$cabinet[ $key ] = call_user_func( $callback, wp_unslash( $input[ $key ] ) );
		}
	}

	update_option( OPTION_CABINET, $cabinet );

	wp_safe_redirect( admin_url( 'admin.php?page=vitalisite-wizard&step=3' ) );
	exit;
}
add_action( 'admin_init', __NAMESPACE__ . '\handle_wizard_cabinet_save' );

/* ------------------------------------------------------------------ */
/*  6. Handle step 3 form submission (Hours & Social)                 */
/* ------------------------------------------------------------------ */

function handle_wizard_hours_social_save() {
	if ( ! isset( $_POST['_wizard_hours_social_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['_wizard_hours_social_nonce'], 'vitalisite_wizard_hours_social' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Save hours.
	$hours_input = isset( $_POST['hours'] ) ? (array) $_POST['hours'] : array();
	$hours       = get_option( OPTION_HOURS, array() );
	$day_keys    = array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' );

	foreach ( $day_keys as $day ) {
		$day_data = isset( $hours_input[ $day ] ) ? $hours_input[ $day ] : array();
		$hours[ $day ] = array(
			'closed' => ! empty( $day_data['closed'] ),
			'open'   => isset( $day_data['open'] ) ? sanitize_text_field( $day_data['open'] ) : '09:00',
			'close'  => isset( $day_data['close'] ) ? sanitize_text_field( $day_data['close'] ) : '18:00',
		);
	}

	update_option( OPTION_HOURS, $hours );

	// Save social.
	$social_input = isset( $_POST['social'] ) ? (array) $_POST['social'] : array();
	$social       = get_option( OPTION_SOCIAL, array() );
	$social_keys  = array( 'facebook', 'instagram', 'linkedin', 'doctolib', 'google_maps' );

	foreach ( $social_keys as $key ) {
		if ( isset( $social_input[ $key ] ) ) {
			$social[ $key ] = esc_url_raw( wp_unslash( $social_input[ $key ] ) );
		}
	}

	update_option( OPTION_SOCIAL, $social );

	wp_safe_redirect( admin_url( 'admin.php?page=vitalisite-wizard&step=4' ) );
	exit;
}
add_action( 'admin_init', __NAMESPACE__ . '\handle_wizard_hours_social_save' );
