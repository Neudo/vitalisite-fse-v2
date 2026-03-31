<?php
/**
 * Vitalisite setup wizard.
 *
 * @package Vitalisite_FSE
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register submenu page under Vitalisite.
 */
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

/**
 * Redirect to the wizard after theme activation.
 */
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

/**
 * Enqueue wizard assets.
 *
 * @param string $hook Current admin page hook.
 */
function enqueue_wizard_assets( $hook ) {
	if ( 'vitalisite_page_vitalisite-wizard' !== $hook ) {
		return;
	}

	$uri     = get_template_directory_uri();
	$version = VITALISITE_FSE_VERSION;

	wp_enqueue_style( 'vitalisite-wizard', $uri . '/assets/admin/wizard.css', array(), $version );
	wp_enqueue_script( 'vitalisite-wizard', $uri . '/assets/admin/wizard.js', array(), $version, true );
	wp_localize_script(
		'vitalisite-wizard',
		'vitalisiteWizard',
		array(
			'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
			'nonce'         => wp_create_nonce( 'vitalisite_license_nonce' ),
			'settingsUrl'   => admin_url( 'admin.php?page=vitalisite-settings' ),
			'licenseActive' => is_license_active(),
		)
	);
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_wizard_assets' );

/**
 * Render the wizard page.
 */
function render_wizard_page() {
	$current_step = isset( $_GET['step'] ) ? absint( $_GET['step'] ) : 1;
	$current_step = max( 1, min( 7, $current_step ) );

	$steps = array(
		1 => __( 'Licence', 'vitalisite-fse' ),
		2 => __( 'Ton', 'vitalisite-fse' ),
		3 => __( 'Style', 'vitalisite-fse' ),
		4 => __( 'Pages', 'vitalisite-fse' ),
		5 => __( 'Cabinet', 'vitalisite-fse' ),
		6 => __( 'Horaires', 'vitalisite-fse' ),
		7 => __( 'Thème visuel', 'vitalisite-fse' ),
	);
	?>
	<div class="vitalisite-wizard-wrap">
		<div class="vitalisite-wizard">
			<div class="vitalisite-wizard__header">
				<h1 class="vitalisite-wizard__title">
					<span class="dashicons dashicons-heart"></span>
					<?php esc_html_e( 'Vitalisite — Assistant de configuration', 'vitalisite-fse' ); ?>
				</h1>
			</div>

			<div class="vitalisite-wizard__steps">
				<?php foreach ( $steps as $number => $label ) : ?>
					<?php
					$class = 'vitalisite-wizard__step';
					if ( $number === $current_step ) {
						$class .= ' vitalisite-wizard__step--active';
					} elseif ( $number < $current_step ) {
						$class .= ' vitalisite-wizard__step--done';
					}
					?>
					<div class="<?php echo esc_attr( $class ); ?>">
						<span class="vitalisite-wizard__step-number"><?php echo esc_html( $number ); ?></span>
						<span class="vitalisite-wizard__step-label"><?php echo esc_html( $label ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="vitalisite-wizard__content">
				<?php
				switch ( $current_step ) {
					case 1:
						render_wizard_step_license();
						break;
					case 2:
						render_wizard_step_tone();
						break;
					case 3:
						render_wizard_step_writing_style();
						break;
					case 4:
						render_wizard_step_demo_pages();
						break;
					case 5:
						render_wizard_step_cabinet();
						break;
					case 6:
						render_wizard_step_hours_social();
						break;
					case 7:
						render_wizard_step_personalization();
						break;
				}
				?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render a list of choice cards.
 *
 * @param string                                   $field_name Field name.
 * @param string                                   $selected   Selected value.
 * @param array<string, array<string, string>>     $options    Options list.
 */
function render_wizard_choice_cards( $field_name, $selected, array $options ) {
	?>
	<div class="vitalisite-wizard__choice-grid">
		<?php foreach ( $options as $slug => $option ) : ?>
			<label class="vitalisite-wizard__choice-card">
				<input
					type="radio"
					name="<?php echo esc_attr( $field_name ); ?>"
					value="<?php echo esc_attr( $slug ); ?>"
					<?php checked( $selected, $slug ); ?>
				>
				<span class="vitalisite-wizard__choice-title"><?php echo esc_html( $option['label'] ); ?></span>
				<span class="vitalisite-wizard__choice-description"><?php echo esc_html( $option['description'] ); ?></span>
			</label>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Step 1: License.
 */
function render_wizard_step_license() {
	$is_active = is_license_active();
	$key       = get_license_key();
	?>
	<div class="vitalisite-wizard__step-content" data-step="1">
		<h2><?php esc_html_e( 'Activation de votre licence', 'vitalisite-fse' ); ?></h2>
		<p><?php esc_html_e( 'Saisissez la clé reçue par e-mail pour activer le thème avant de démarrer la configuration.', 'vitalisite-fse' ); ?></p>

		<?php if ( $is_active ) : ?>
			<div class="vitalisite-wizard__notice vitalisite-wizard__notice--success">
				<span class="dashicons dashicons-yes-alt"></span>
				<?php esc_html_e( 'Licence activée.', 'vitalisite-fse' ); ?>
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
				<span class="button button-primary button-hero vitalisite-wizard__btn-disabled" id="vitalisite-wizard-next" title="<?php esc_attr_e( 'Activez votre licence pour continuer.', 'vitalisite-fse' ); ?>">
					<?php esc_html_e( 'Suivant →', 'vitalisite-fse' ); ?>
				</span>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/**
 * Step 2: Tone.
 */
function render_wizard_step_tone() {
	$setup = get_demo_setup();
	?>
	<div class="vitalisite-wizard__step-content" data-step="2">
		<h2><?php esc_html_e( 'Choisissez le ton du site', 'vitalisite-fse' ); ?></h2>
		<p><?php esc_html_e( 'Ce choix détermine si le site parle à la première personne du singulier ou du pluriel.', 'vitalisite-fse' ); ?></p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=2' ) ); ?>" class="vitalisite-wizard__form">
			<?php wp_nonce_field( 'vitalisite_wizard_tone', '_wizard_tone_nonce' ); ?>
			<?php render_wizard_choice_cards( 'demo_tone', $setup['tone'], get_demo_tone_options() ); ?>

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

/**
 * Step 3: Writing style.
 */
function render_wizard_step_writing_style() {
	$setup = get_demo_setup();
	?>
	<div class="vitalisite-wizard__step-content" data-step="3">
		<h2><?php esc_html_e( 'Choisissez le style rédactionnel', 'vitalisite-fse' ); ?></h2>
		<p><?php esc_html_e( 'Le style rédactionnel influence le vocabulaire, l’ambiance et la façon dont les pages démo présentent votre pratique.', 'vitalisite-fse' ); ?></p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=3' ) ); ?>" class="vitalisite-wizard__form">
			<?php wp_nonce_field( 'vitalisite_wizard_writing_style', '_wizard_writing_style_nonce' ); ?>
			<?php render_wizard_choice_cards( 'demo_writing_style', $setup['writing_style'], get_demo_writing_style_options() ); ?>

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

/**
 * Step 4: Demo pages.
 */
function render_wizard_step_demo_pages() {
	$setup         = get_demo_setup();
	$definitions   = get_demo_pages_definition();
	$selected      = array_map( 'sanitize_title', (array) $setup['pages'] );
	$has_selection = ! empty( $selected );
	?>
	<div class="vitalisite-wizard__step-content" data-step="4">
		<h2><?php esc_html_e( 'Génération des pages de démonstration', 'vitalisite-fse' ); ?></h2>
		<p><?php esc_html_e( 'Choisissez les pages préconstruites à générer. Leur contenu suivra le ton et le style rédactionnel choisis aux étapes précédentes.', 'vitalisite-fse' ); ?></p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=4' ) ); ?>" class="vitalisite-wizard__form">
			<?php wp_nonce_field( 'vitalisite_wizard_demo_pages', '_wizard_demo_pages_nonce' ); ?>

			<div class="vitalisite-wizard__demo-actions">
				<button type="button" class="button" id="vitalisite-select-all-pages">
					<?php esc_html_e( 'Tout sélectionner', 'vitalisite-fse' ); ?>
				</button>
				<button type="button" class="button" id="vitalisite-unselect-all-pages">
					<?php esc_html_e( 'Tout désélectionner', 'vitalisite-fse' ); ?>
				</button>
			</div>

			<div class="vitalisite-wizard__page-list">
				<?php foreach ( $definitions as $slug => $page ) : ?>
					<?php
					$existing = get_page_by_path( $slug, OBJECT, 'page' );
					$checked  = $has_selection ? in_array( $slug, $selected, true ) : ! ( $existing instanceof \WP_Post );
					?>
					<label class="vitalisite-wizard__page-card">
						<input
							type="checkbox"
							name="demo_pages[]"
							value="<?php echo esc_attr( $slug ); ?>"
							<?php checked( $checked ); ?>
							<?php disabled( $existing instanceof \WP_Post ); ?>
						>
						<span class="vitalisite-wizard__page-card-title"><?php echo esc_html( $page['label'] ); ?></span>
						<span class="vitalisite-wizard__page-card-description"><?php echo esc_html( $page['description'] ); ?></span>
						<?php if ( $existing instanceof \WP_Post ) : ?>
							<span class="vitalisite-wizard__page-card-meta"><?php esc_html_e( 'Déjà présente sur ce site, elle ne sera pas recréée.', 'vitalisite-fse' ); ?></span>
						<?php endif; ?>
					</label>
				<?php endforeach; ?>
			</div>

			<div class="vitalisite-wizard__nav">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=3' ) ); ?>" class="button">
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

/**
 * Step 5: Cabinet info.
 */
function render_wizard_step_cabinet() {
	$cabinet = get_option( OPTION_CABINET, array() );
	$fields  = array(
		'doctor_name'      => array(
			'label'       => __( 'Nom du praticien', 'vitalisite-fse' ),
			'placeholder' => 'Dr. Jean Dupont',
			'type'        => 'text',
		),
		'doctor_specialty' => array(
			'label'       => __( 'Spécialité', 'vitalisite-fse' ),
			'placeholder' => 'Ostéopathe D.O.',
			'type'        => 'text',
		),
		'phone'            => array(
			'label'       => __( 'Téléphone', 'vitalisite-fse' ),
			'placeholder' => '01 42 42 42 42',
			'type'        => 'tel',
		),
		'email'            => array(
			'label'       => __( 'Email de contact', 'vitalisite-fse' ),
			'placeholder' => 'contact@cabinet.fr',
			'type'        => 'email',
		),
		'address'          => array(
			'label'       => __( 'Adresse du cabinet', 'vitalisite-fse' ),
			'placeholder' => '1 rue de la Liberté, 75013 Paris',
			'type'        => 'text',
		),
		'appointment_url'  => array(
			'label'       => __( 'Lien de prise de rendez-vous', 'vitalisite-fse' ),
			'placeholder' => 'https://www.doctolib.fr/…',
			'type'        => 'url',
		),
	);
	?>
	<div class="vitalisite-wizard__step-content" data-step="5">
		<h2><?php esc_html_e( 'Informations du cabinet', 'vitalisite-fse' ); ?></h2>
		<p><?php esc_html_e( 'Ces informations seront réutilisées dans les pages générées, le header, le footer et plusieurs patterns du thème.', 'vitalisite-fse' ); ?></p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=5' ) ); ?>" class="vitalisite-wizard__form">
			<?php wp_nonce_field( 'vitalisite_wizard_cabinet', '_wizard_cabinet_nonce' ); ?>

			<?php foreach ( $fields as $id => $field ) : ?>
				<?php $value = isset( $cabinet[ $id ] ) ? $cabinet[ $id ] : ''; ?>
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
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=4' ) ); ?>" class="button">
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

/**
 * Step 6: Hours and social links.
 */
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
		'facebook'    => array( 'label' => 'Facebook', 'placeholder' => 'https://facebook.com/…' ),
		'instagram'   => array( 'label' => 'Instagram', 'placeholder' => 'https://instagram.com/…' ),
		'linkedin'    => array( 'label' => 'LinkedIn', 'placeholder' => 'https://linkedin.com/in/…' ),
		'doctolib'    => array( 'label' => 'Doctolib', 'placeholder' => 'https://www.doctolib.fr/…' ),
		'google_maps' => array( 'label' => 'Google Maps', 'placeholder' => 'https://maps.google.com/…' ),
	);
	?>
	<div class="vitalisite-wizard__step-content" data-step="6">
		<h2><?php esc_html_e( 'Horaires et réseaux', 'vitalisite-fse' ); ?></h2>
		<p><?php esc_html_e( 'Configurez vos horaires et vos liens utiles. Les pages sélectionnées seront générées quand vous validerez cette étape.', 'vitalisite-fse' ); ?></p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=6' ) ); ?>" class="vitalisite-wizard__form">
			<?php wp_nonce_field( 'vitalisite_wizard_hours_social', '_wizard_hours_social_nonce' ); ?>

			<h3><?php esc_html_e( 'Horaires d’ouverture', 'vitalisite-fse' ); ?></h3>
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
					<?php foreach ( $days as $key => $label ) : ?>
						<?php
						$day_data   = isset( $hours[ $key ] ) ? $hours[ $key ] : array();
						$is_closed  = ! empty( $day_data['closed'] );
						$open_time  = isset( $day_data['open'] ) ? $day_data['open'] : '09:00';
						$close_time = isset( $day_data['close'] ) ? $day_data['close'] : '18:00';
						?>
						<tr>
							<td><strong><?php echo esc_html( $label ); ?></strong></td>
							<td><input type="checkbox" name="hours[<?php echo esc_attr( $key ); ?>][closed]" value="1" <?php checked( $is_closed ); ?>></td>
							<td><input type="time" name="hours[<?php echo esc_attr( $key ); ?>][open]" value="<?php echo esc_attr( $open_time ); ?>"></td>
							<td><input type="time" name="hours[<?php echo esc_attr( $key ); ?>][close]" value="<?php echo esc_attr( $close_time ); ?>"></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<h3 style="margin-top:2em;"><?php esc_html_e( 'Réseaux sociaux et liens utiles', 'vitalisite-fse' ); ?></h3>

			<?php foreach ( $social_fields as $id => $field ) : ?>
				<?php $value = isset( $social[ $id ] ) ? $social[ $id ] : ''; ?>
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
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=5' ) ); ?>" class="button">
					<?php esc_html_e( '← Précédent', 'vitalisite-fse' ); ?>
				</a>
				<button type="submit" class="button button-primary button-hero">
					<?php esc_html_e( 'Générer les pages et continuer →', 'vitalisite-fse' ); ?>
				</button>
			</div>
		</form>
	</div>
	<?php
}

/**
 * Step 7: Visual theme guidance.
 */
function render_wizard_step_personalization() {
	$styles_dir = get_template_directory() . '/styles';
	$variations = array();

	foreach ( glob( $styles_dir . '/*.json' ) as $file ) {
		$data             = json_decode( file_get_contents( $file ), true );
		$variations[] = isset( $data['title'] ) ? $data['title'] : ucfirst( basename( $file, '.json' ) );
	}
	?>
	<div class="vitalisite-wizard__step-content" data-step="7">
		<div class="vitalisite-wizard__done">
			<span class="vitalisite-wizard__done-icon dashicons dashicons-yes-alt"></span>
			<h2><?php esc_html_e( 'Configuration terminée', 'vitalisite-fse' ); ?></h2>
			<p><?php esc_html_e( 'Vos pages démo sont prêtes. Il ne reste plus qu’à choisir la variation visuelle qui correspond à votre identité.', 'vitalisite-fse' ); ?></p>
		</div>

		<?php if ( ! empty( $variations ) ) : ?>
			<div class="vitalisite-wizard__theme-list">
				<strong><?php esc_html_e( 'Variations disponibles :', 'vitalisite-fse' ); ?></strong>
				<ul class="vitalisite-wizard__theme-tags">
					<?php foreach ( $variations as $variation ) : ?>
						<li><?php echo esc_html( $variation ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<div class="vitalisite-wizard__personalization-guide">
			<h3><?php esc_html_e( 'Comment choisir votre thème visuel ?', 'vitalisite-fse' ); ?></h3>
			<ol class="vitalisite-wizard__guide-steps">
				<li><?php esc_html_e( 'Ouvrez l’Éditeur de site depuis Apparence → Éditeur.', 'vitalisite-fse' ); ?></li>
				<li><?php esc_html_e( 'Cliquez sur “Styles”, puis sur “Parcourir les styles”.', 'vitalisite-fse' ); ?></li>
				<li><?php esc_html_e( 'Choisissez la variation qui vous convient puis validez-la.', 'vitalisite-fse' ); ?></li>
				<li><?php esc_html_e( 'Enregistrez ensuite vos changements en haut à droite.', 'vitalisite-fse' ); ?></li>
			</ol>
		</div>

		<div class="vitalisite-wizard__done-actions">
			<a href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>" class="button button-primary button-hero">
				<span class="dashicons dashicons-admin-customizer"></span>
				<?php esc_html_e( 'Ouvrir l’éditeur de site', 'vitalisite-fse' ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-settings' ) ); ?>" class="button button-hero">
				<span class="dashicons dashicons-admin-settings"></span>
				<?php esc_html_e( 'Réglages Vitalisite', 'vitalisite-fse' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-hero" target="_blank" rel="noreferrer">
				<span class="dashicons dashicons-external"></span>
				<?php esc_html_e( 'Voir le site', 'vitalisite-fse' ); ?>
			</a>
		</div>

		<div class="vitalisite-wizard__nav">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-wizard&step=6' ) ); ?>" class="button">
				<?php esc_html_e( '← Précédent', 'vitalisite-fse' ); ?>
			</a>
			<span></span>
		</div>
	</div>
	<?php
}

/**
 * Save tone step.
 */
function handle_wizard_tone_save() {
	if ( ! isset( $_POST['_wizard_tone_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wizard_tone_nonce'] ) ), 'vitalisite_wizard_tone' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	save_demo_setup(
		array(
			'tone' => isset( $_POST['demo_tone'] ) ? sanitize_key( wp_unslash( $_POST['demo_tone'] ) ) : 'je',
		)
	);

	wp_safe_redirect( admin_url( 'admin.php?page=vitalisite-wizard&step=3' ) );
	exit;
}
add_action( 'admin_init', __NAMESPACE__ . '\handle_wizard_tone_save' );

/**
 * Save writing style step.
 */
function handle_wizard_writing_style_save() {
	if ( ! isset( $_POST['_wizard_writing_style_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wizard_writing_style_nonce'] ) ), 'vitalisite_wizard_writing_style' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	save_demo_setup(
		array(
			'writing_style' => isset( $_POST['demo_writing_style'] ) ? sanitize_key( wp_unslash( $_POST['demo_writing_style'] ) ) : 'professionnel',
		)
	);

	wp_safe_redirect( admin_url( 'admin.php?page=vitalisite-wizard&step=4' ) );
	exit;
}
add_action( 'admin_init', __NAMESPACE__ . '\handle_wizard_writing_style_save' );

/**
 * Save demo pages step.
 */
function handle_wizard_demo_pages_save() {
	if ( ! isset( $_POST['_wizard_demo_pages_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wizard_demo_pages_nonce'] ) ), 'vitalisite_wizard_demo_pages' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	save_demo_setup(
		array(
			'pages' => isset( $_POST['demo_pages'] ) ? (array) wp_unslash( $_POST['demo_pages'] ) : array(),
		)
	);

	wp_safe_redirect( admin_url( 'admin.php?page=vitalisite-wizard&step=5' ) );
	exit;
}
add_action( 'admin_init', __NAMESPACE__ . '\handle_wizard_demo_pages_save' );

/**
 * Save cabinet step.
 */
function handle_wizard_cabinet_save() {
	if ( ! isset( $_POST['_wizard_cabinet_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wizard_cabinet_nonce'] ) ), 'vitalisite_wizard_cabinet' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$cabinet = get_option( OPTION_CABINET, array() );
	$input   = isset( $_POST['cabinet'] ) ? (array) wp_unslash( $_POST['cabinet'] ) : array();

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
			$cabinet[ $key ] = call_user_func( $callback, $input[ $key ] );
		}
	}

	update_option( OPTION_CABINET, $cabinet );

	wp_safe_redirect( admin_url( 'admin.php?page=vitalisite-wizard&step=6' ) );
	exit;
}
add_action( 'admin_init', __NAMESPACE__ . '\handle_wizard_cabinet_save' );

/**
 * Save hours and social step and generate selected pages.
 */
function handle_wizard_hours_social_save() {
	if ( ! isset( $_POST['_wizard_hours_social_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wizard_hours_social_nonce'] ) ), 'vitalisite_wizard_hours_social' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$hours_input = isset( $_POST['hours'] ) ? (array) wp_unslash( $_POST['hours'] ) : array();
	$hours       = get_option( OPTION_HOURS, array() );
	$day_keys    = array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' );

	foreach ( $day_keys as $day ) {
		$day_data      = isset( $hours_input[ $day ] ) ? $hours_input[ $day ] : array();
		$hours[ $day ] = array(
			'closed' => ! empty( $day_data['closed'] ),
			'open'   => isset( $day_data['open'] ) ? sanitize_text_field( $day_data['open'] ) : '09:00',
			'close'  => isset( $day_data['close'] ) ? sanitize_text_field( $day_data['close'] ) : '18:00',
		);
	}

	update_option( OPTION_HOURS, $hours );

	$social_input = isset( $_POST['social'] ) ? (array) wp_unslash( $_POST['social'] ) : array();
	$social       = get_option( OPTION_SOCIAL, array() );
	$social_keys  = array( 'facebook', 'instagram', 'linkedin', 'doctolib', 'google_maps' );

	foreach ( $social_keys as $key ) {
		if ( isset( $social_input[ $key ] ) ) {
			$social[ $key ] = esc_url_raw( $social_input[ $key ] );
		}
	}

	update_option( OPTION_SOCIAL, $social );

	$setup = get_demo_setup();
	install_demo_pages( $setup['tone'], $setup['writing_style'], $setup['pages'] );

	wp_safe_redirect( admin_url( 'admin.php?page=vitalisite-wizard&step=7' ) );
	exit;
}
add_action( 'admin_init', __NAMESPACE__ . '\handle_wizard_hours_social_save' );
