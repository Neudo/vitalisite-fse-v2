<?php
/**
 * Page admin pour gérer les informations du médecin
 * 
 * Permet de modifier les infos après le wizard sans le relancer
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_Admin_Settings {

	/**
	 * Instance unique
	 */
	private static $instance = null;

	/**
	 * Slug de la page
	 */
	private $page_slug = 'vitalisite-settings';

	/**
	 * Singleton
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructeur
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Ajoute la page dans le menu admin
	 */
	public function add_admin_menu() {
		add_theme_page(
			__( 'Paramètres Vitalisite', 'vitalisite-fse' ),
			__( 'Paramètres', 'vitalisite-fse' ),
			'manage_options',
			$this->page_slug,
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Enregistre les settings
	 */
	public function register_settings() {
		register_setting(
			'vitalisite_settings_group',
			'vitalisite_doctor_info',
			array(
				'sanitize_callback' => array( $this, 'sanitize_doctor_info' ),
			)
		);
	}

	/**
	 * Sanitize les données
	 */
	public function sanitize_doctor_info( $input ) {
		$sanitized = array();

		$sanitized['name'] = isset( $input['name'] ) ? sanitize_text_field( $input['name'] ) : '';
		$sanitized['specialty'] = isset( $input['specialty'] ) ? sanitize_text_field( $input['specialty'] ) : '';
		$sanitized['address'] = isset( $input['address'] ) ? sanitize_textarea_field( $input['address'] ) : '';
		$sanitized['phone'] = isset( $input['phone'] ) ? sanitize_text_field( $input['phone'] ) : '';
		$sanitized['email'] = isset( $input['email'] ) ? sanitize_email( $input['email'] ) : '';
		$sanitized['booking_link'] = isset( $input['booking_link'] ) ? esc_url_raw( $input['booking_link'] ) : '';
		$sanitized['has_visio'] = isset( $input['has_visio'] ) ? true : false;
		$sanitized['photo_id'] = isset( $input['photo_id'] ) ? absint( $input['photo_id'] ) : 0;

		// Horaires
		$days = array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' );
		foreach ( $days as $day ) {
			$sanitized['hours_' . $day] = isset( $input['hours_' . $day] ) ? sanitize_text_field( $input['hours_' . $day] ) : '';
		}

		return $sanitized;
	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue_scripts( $hook ) {
		if ( 'appearance_page_' . $this->page_slug !== $hook ) {
			return;
		}

		wp_enqueue_media();
		
		wp_enqueue_style(
			'vitalisite-admin-settings',
			get_template_directory_uri() . '/assets/admin/settings.css',
			array(),
			VITALISITE_FSE_VERSION
		);

		wp_enqueue_script(
			'vitalisite-admin-settings',
			get_template_directory_uri() . '/assets/admin/settings.js',
			array( 'jquery' ),
			VITALISITE_FSE_VERSION,
			true
		);
	}

	/**
	 * Render la page de settings
	 */
	public function render_settings_page() {
		$doctor_info = get_option( 'vitalisite_doctor_info', array() );
		$days_labels = array(
			'monday'    => __( 'Lundi', 'vitalisite-fse' ),
			'tuesday'   => __( 'Mardi', 'vitalisite-fse' ),
			'wednesday' => __( 'Mercredi', 'vitalisite-fse' ),
			'thursday'  => __( 'Jeudi', 'vitalisite-fse' ),
			'friday'    => __( 'Vendredi', 'vitalisite-fse' ),
			'saturday'  => __( 'Samedi', 'vitalisite-fse' ),
			'sunday'    => __( 'Dimanche', 'vitalisite-fse' ),
		);
		?>
		<div class="wrap vitalisite-settings-wrap">
			<h1><?php esc_html_e( 'Paramètres Vitalisite', 'vitalisite-fse' ); ?></h1>
			
			<div class="vitalisite-settings-header">
				<p><?php esc_html_e( 'Modifiez les informations de votre cabinet médical. Ces données sont utilisées dans les différentes sections de votre site.', 'vitalisite-fse' ); ?></p>
				
				<div class="vitalisite-settings-actions">
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=vitalisite-setup-wizard' ) ); ?>" class="button">
						<span class="dashicons dashicons-update"></span>
						<?php esc_html_e( 'Relancer le wizard', 'vitalisite-fse' ); ?>
					</a>
				</div>
			</div>

			<?php settings_errors(); ?>

			<form method="post" action="options.php" class="vitalisite-settings-form">
				<?php settings_fields( 'vitalisite_settings_group' ); ?>

				<div class="vitalisite-settings-tabs">
					<nav class="nav-tab-wrapper">
						<a href="#tab-general" class="nav-tab nav-tab-active"><?php esc_html_e( 'Informations générales', 'vitalisite-fse' ); ?></a>
						<a href="#tab-hours" class="nav-tab"><?php esc_html_e( 'Horaires', 'vitalisite-fse' ); ?></a>
						<a href="#tab-advanced" class="nav-tab"><?php esc_html_e( 'Avancé', 'vitalisite-fse' ); ?></a>
					</nav>

					<!-- Tab: Informations générales -->
					<div id="tab-general" class="tab-content active">
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row">
									<label for="doctor_name">
										<?php esc_html_e( 'Nom complet', 'vitalisite-fse' ); ?>
										<span class="required">*</span>
									</label>
								</th>
								<td>
									<input 
										type="text" 
										id="doctor_name" 
										name="vitalisite_doctor_info[name]" 
										value="<?php echo esc_attr( $doctor_info['name'] ?? '' ); ?>"
										class="regular-text"
										required
									>
									<p class="description"><?php esc_html_e( 'Ex: Dr. Martin Dupont', 'vitalisite-fse' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="doctor_specialty">
										<?php esc_html_e( 'Spécialité', 'vitalisite-fse' ); ?>
										<span class="required">*</span>
									</label>
								</th>
								<td>
									<input 
										type="text" 
										id="doctor_specialty" 
										name="vitalisite_doctor_info[specialty]" 
										value="<?php echo esc_attr( $doctor_info['specialty'] ?? '' ); ?>"
										class="regular-text"
										required
									>
									<p class="description"><?php esc_html_e( 'Ex: Médecin généraliste, Cardiologue, Kinésithérapeute...', 'vitalisite-fse' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="doctor_address">
										<?php esc_html_e( 'Adresse du cabinet', 'vitalisite-fse' ); ?>
										<span class="required">*</span>
									</label>
								</th>
								<td>
									<textarea 
										id="doctor_address" 
										name="vitalisite_doctor_info[address]" 
										rows="3"
										class="large-text"
										required
									><?php echo esc_textarea( $doctor_info['address'] ?? '' ); ?></textarea>
									<p class="description"><?php esc_html_e( 'Adresse complète du cabinet', 'vitalisite-fse' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="doctor_phone">
										<?php esc_html_e( 'Téléphone', 'vitalisite-fse' ); ?>
										<span class="required">*</span>
									</label>
								</th>
								<td>
									<input 
										type="tel" 
										id="doctor_phone" 
										name="vitalisite_doctor_info[phone]" 
										value="<?php echo esc_attr( $doctor_info['phone'] ?? '' ); ?>"
										class="regular-text"
										required
									>
									<p class="description"><?php esc_html_e( 'Numéro de téléphone du cabinet', 'vitalisite-fse' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="doctor_email">
										<?php esc_html_e( 'Email', 'vitalisite-fse' ); ?>
										<span class="required">*</span>
									</label>
								</th>
								<td>
									<input 
										type="email" 
										id="doctor_email" 
										name="vitalisite_doctor_info[email]" 
										value="<?php echo esc_attr( $doctor_info['email'] ?? '' ); ?>"
										class="regular-text"
										required
									>
									<p class="description"><?php esc_html_e( 'Adresse email de contact', 'vitalisite-fse' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="booking_link">
										<?php esc_html_e( 'Lien de prise de rendez-vous', 'vitalisite-fse' ); ?>
									</label>
								</th>
								<td>
									<input 
										type="url" 
										id="booking_link" 
										name="vitalisite_doctor_info[booking_link]" 
										value="<?php echo esc_url( $doctor_info['booking_link'] ?? '' ); ?>"
										class="large-text"
									>
									<p class="description"><?php esc_html_e( 'Lien Doctolib, Resalib, Maiia ou autre plateforme de réservation', 'vitalisite-fse' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<?php esc_html_e( 'Consultations en visioconférence', 'vitalisite-fse' ); ?>
								</th>
								<td>
									<label>
										<input 
											type="checkbox" 
											name="vitalisite_doctor_info[has_visio]" 
											value="1"
											<?php checked( ! empty( $doctor_info['has_visio'] ) ); ?>
										>
										<?php esc_html_e( 'Je propose des consultations en visioconférence', 'vitalisite-fse' ); ?>
									</label>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="doctor_photo">
										<?php esc_html_e( 'Photo du professionnel', 'vitalisite-fse' ); ?>
									</label>
								</th>
								<td>
									<div class="photo-upload-wrapper">
										<?php
										$photo_id = $doctor_info['photo_id'] ?? 0;
										if ( $photo_id ) {
											$photo_url = wp_get_attachment_image_url( $photo_id, 'medium' );
											?>
											<div class="photo-preview">
												<img src="<?php echo esc_url( $photo_url ); ?>" alt="">
												<button type="button" class="button remove-photo">
													<?php esc_html_e( 'Supprimer', 'vitalisite-fse' ); ?>
												</button>
											</div>
											<?php
										}
										?>
										<button type="button" class="button upload-photo-button">
											<span class="dashicons dashicons-upload"></span>
											<?php esc_html_e( 'Choisir une photo', 'vitalisite-fse' ); ?>
										</button>
										<input type="hidden" name="vitalisite_doctor_info[photo_id]" id="doctor_photo_id" value="<?php echo esc_attr( $photo_id ); ?>">
									</div>
									<p class="description"><?php esc_html_e( 'Photo professionnelle pour la page À propos', 'vitalisite-fse' ); ?></p>
								</td>
							</tr>
						</table>
					</div>

					<!-- Tab: Horaires -->
					<div id="tab-hours" class="tab-content">
						<p class="description"><?php esc_html_e( 'Renseignez les horaires d\'ouverture de votre cabinet. Laissez vide pour les jours de fermeture.', 'vitalisite-fse' ); ?></p>
						
						<table class="form-table" role="presentation">
							<?php foreach ( $days_labels as $day => $label ) : ?>
							<tr>
								<th scope="row">
									<label for="hours_<?php echo esc_attr( $day ); ?>">
										<?php echo esc_html( $label ); ?>
									</label>
								</th>
								<td>
									<input 
										type="text" 
										id="hours_<?php echo esc_attr( $day ); ?>" 
										name="vitalisite_doctor_info[hours_<?php echo esc_attr( $day ); ?>]" 
										value="<?php echo esc_attr( $doctor_info['hours_' . $day] ?? '' ); ?>"
										class="regular-text"
										placeholder="<?php echo $day === 'sunday' ? esc_attr__( 'Fermé', 'vitalisite-fse' ) : esc_attr__( '9h00 - 18h00', 'vitalisite-fse' ); ?>"
									>
								</td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>

					<!-- Tab: Avancé -->
					<div id="tab-advanced" class="tab-content">
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row">
									<?php esc_html_e( 'Statut du wizard', 'vitalisite-fse' ); ?>
								</th>
								<td>
									<?php if ( get_option( 'vitalisite_setup_complete' ) ) : ?>
										<span class="dashicons dashicons-yes-alt" style="color: #00a32a;"></span>
										<?php esc_html_e( 'Configuration terminée', 'vitalisite-fse' ); ?>
									<?php else : ?>
										<span class="dashicons dashicons-warning" style="color: #dba617;"></span>
										<?php esc_html_e( 'Configuration incomplète', 'vitalisite-fse' ); ?>
									<?php endif; ?>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<?php esc_html_e( 'Réinitialiser le wizard', 'vitalisite-fse' ); ?>
								</th>
								<td>
									<button type="button" class="button button-secondary reset-wizard-button">
										<span class="dashicons dashicons-update"></span>
										<?php esc_html_e( 'Réinitialiser et relancer', 'vitalisite-fse' ); ?>
									</button>
									<p class="description"><?php esc_html_e( 'Réinitialise la configuration et relance le wizard depuis le début.', 'vitalisite-fse' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<?php esc_html_e( 'Statut de la licence', 'vitalisite-fse' ); ?>
								</th>
								<td>
									<?php 
									$license_status = get_option( 'theme_license_status' );
									if ( $license_status === 'activated' ) :
									?>
										<span class="dashicons dashicons-yes-alt" style="color: #00a32a;"></span>
										<?php esc_html_e( 'Licence activée', 'vitalisite-fse' ); ?>
									<?php else : ?>
										<span class="dashicons dashicons-warning" style="color: #dba617;"></span>
										<?php esc_html_e( 'Licence non activée', 'vitalisite-fse' ); ?>
									<?php endif; ?>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<?php submit_button( __( 'Enregistrer les modifications', 'vitalisite-fse' ) ); ?>
			</form>
		</div>
		<?php
	}
}

// Initialiser
Vitalisite_Admin_Settings::get_instance();
