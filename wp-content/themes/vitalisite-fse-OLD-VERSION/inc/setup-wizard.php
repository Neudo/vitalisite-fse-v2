<?php
/**
 * Setup Wizard pour Vitalisite FSE
 * 
 * Gère l'installation initiale du thème avec :
 * - Step 1 : Vérification de la licence
 * - Step 2 : Informations du médecin
 * - Step 3 : Customisation du thème (couleurs, fonts)
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_Setup_Wizard {

	/**
	 * Instance unique de la classe
	 */
	private static $instance = null;

	/**
	 * Slug de la page du wizard
	 */
	private $page_slug = 'vitalisite-setup-wizard';

	/**
	 * Steps du wizard
	 */
	private $steps = array();

	/**
	 * Step actuel
	 */
	private $current_step = '';

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
		$this->init_steps();
		$this->init_hooks();
	}

	/**
	 * Initialise les steps du wizard
	 */
	private function init_steps() {
		$this->steps = array(
			'license' => array(
				'name'    => __( 'Licence', 'vitalisite-fse' ),
				'view'    => array( $this, 'step_license' ),
				'handler' => array( $this, 'save_license' ),
			),
			'doctor_info' => array(
				'name'    => __( 'Informations', 'vitalisite-fse' ),
				'view'    => array( $this, 'step_doctor_info' ),
				'handler' => array( $this, 'save_doctor_info' ),
			),
			'customization' => array(
				'name'    => __( 'Personnalisation', 'vitalisite-fse' ),
				'view'    => array( $this, 'step_customization' ),
				'handler' => array( $this, 'save_customization' ),
			),
			'done' => array(
				'name'    => __( 'Terminé', 'vitalisite-fse' ),
				'view'    => array( $this, 'step_done' ),
				'handler' => '',
			),
		);

		$this->current_step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : 'license';
	}

	/**
	 * Initialise les hooks WordPress
	 */
	private function init_hooks() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'handle_redirect' ) );
		add_action( 'admin_init', array( $this, 'handle_save' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Ajoute la page du wizard dans l'admin
	 */
	public function add_admin_menu() {
		add_theme_page(
			__( 'Configuration Vitalisite', 'vitalisite-fse' ),
			__( 'Configuration', 'vitalisite-fse' ),
			'manage_options',
			$this->page_slug,
			array( $this, 'render_wizard' )
		);
	}

	/**
	 * Redirige vers le wizard si c'est la première activation
	 */
	public function handle_redirect() {
		// Vérifier si c'est la première activation
		if ( get_option( 'vitalisite_setup_complete' ) ) {
			return;
		}

		// Éviter les redirections infinies
		if ( wp_doing_ajax() || is_network_admin() || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Vérifier si on est déjà sur la page du wizard
		if ( isset( $_GET['page'] ) && $_GET['page'] === $this->page_slug ) {
			return;
		}

		// Rediriger vers le wizard
		wp_safe_redirect( admin_url( 'themes.php?page=' . $this->page_slug ) );
		exit;
	}

	/**
	 * Gère la sauvegarde des données
	 */
	public function handle_save() {
		if ( ! isset( $_POST['vitalisite_wizard_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['vitalisite_wizard_nonce'], 'vitalisite_wizard_save' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$current_step = isset( $_POST['current_step'] ) ? sanitize_key( $_POST['current_step'] ) : '';

		if ( empty( $current_step ) || ! isset( $this->steps[ $current_step ] ) ) {
			return;
		}

		// Appeler le handler du step actuel
		$handler = $this->steps[ $current_step ]['handler'];
		if ( is_callable( $handler ) ) {
			call_user_func( $handler );
		}

		// Rediriger vers le step suivant
		$next_step = $this->get_next_step( $current_step );
		wp_safe_redirect( admin_url( 'themes.php?page=' . $this->page_slug . '&step=' . $next_step ) );
		exit;
	}

	/**
	 * Récupère le step suivant
	 */
	private function get_next_step( $current_step ) {
		$keys = array_keys( $this->steps );
		$current_index = array_search( $current_step, $keys );
		
		if ( $current_index !== false && isset( $keys[ $current_index + 1 ] ) ) {
			return $keys[ $current_index + 1 ];
		}

		return 'done';
	}

	/**
	 * Enqueue les scripts et styles du wizard
	 */
	public function enqueue_scripts( $hook ) {
		if ( 'appearance_page_' . $this->page_slug !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'vitalisite-wizard',
			get_template_directory_uri() . '/assets/admin/wizard.css',
			array(),
			VITALISITE_FSE_VERSION
		);

		wp_enqueue_script(
			'vitalisite-wizard',
			get_template_directory_uri() . '/assets/admin/wizard.js',
			array( 'jquery' ),
			VITALISITE_FSE_VERSION,
			true
		);

		wp_localize_script(
			'vitalisite-wizard',
			'vitalisiWizard',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'vitalisite_wizard' ),
			)
		);
	}

	/**
	 * Render le wizard
	 */
	public function render_wizard() {
		?>
		<div class="vitalisite-wizard-wrapper">
			<div class="vitalisite-wizard-container">
				<?php $this->render_header(); ?>
				<?php $this->render_steps(); ?>
				<?php $this->render_content(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render le header du wizard
	 */
	private function render_header() {
		?>
		<div class="vitalisite-wizard-header">
			<h1><?php esc_html_e( 'Configuration de Vitalisite', 'vitalisite-fse' ); ?></h1>
			<p><?php esc_html_e( 'Configurez votre site en quelques étapes simples', 'vitalisite-fse' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Render les steps du wizard
	 */
	private function render_steps() {
		?>
		<div class="vitalisite-wizard-steps">
			<?php
			$step_number = 1;
			foreach ( $this->steps as $step_key => $step ) {
				$is_active = ( $step_key === $this->current_step );
				$is_completed = $this->is_step_completed( $step_key );
				$class = array( 'vitalisite-wizard-step' );
				
				if ( $is_active ) {
					$class[] = 'active';
				}
				if ( $is_completed ) {
					$class[] = 'completed';
				}
				?>
				<div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
					<span class="step-number"><?php echo esc_html( $step_number ); ?></span>
					<span class="step-name"><?php echo esc_html( $step['name'] ); ?></span>
				</div>
				<?php
				$step_number++;
			}
			?>
		</div>
		<?php
	}

	/**
	 * Vérifie si un step est complété
	 */
	private function is_step_completed( $step_key ) {
		$keys = array_keys( $this->steps );
		$current_index = array_search( $this->current_step, $keys );
		$step_index = array_search( $step_key, $keys );

		return $step_index < $current_index;
	}

	/**
	 * Render le contenu du step actuel
	 */
	private function render_content() {
		if ( ! isset( $this->steps[ $this->current_step ] ) ) {
			return;
		}

		$step = $this->steps[ $this->current_step ];
		
		if ( is_callable( $step['view'] ) ) {
			call_user_func( $step['view'] );
		}
	}

	/**
	 * Step 1 : Licence
	 */
	public function step_license() {
		$license_key = get_option( 'vitalisite_license_key', '' );
		?>
		<div class="vitalisite-wizard-content">
			<h2><?php esc_html_e( 'Activation de votre licence', 'vitalisite-fse' ); ?></h2>
			<p><?php esc_html_e( 'Entrez votre clé de licence pour activer le thème et recevoir les mises à jour.', 'vitalisite-fse' ); ?></p>

			<form method="post" class="vitalisite-wizard-form">
				<?php wp_nonce_field( 'vitalisite_wizard_save', 'vitalisite_wizard_nonce' ); ?>
				<input type="hidden" name="current_step" value="license">

				<div class="form-group">
					<label for="license_key">
						<?php esc_html_e( 'Clé de licence', 'vitalisite-fse' ); ?>
						<span class="required">*</span>
					</label>
					<input 
						type="text" 
						id="license_key" 
						name="license_key" 
						value="<?php echo esc_attr( $license_key ); ?>"
						placeholder="XXXX-XXXX-XXXX-XXXX"
						required
					>
					<p class="description">
						<?php esc_html_e( 'Vous trouverez votre clé de licence dans votre email de confirmation d\'achat.', 'vitalisite-fse' ); ?>
					</p>
				</div>

				<?php
				/**
				 * Hook pour ajouter des champs supplémentaires dans le step licence
				 * Utilisé par le plugin Vitalisite pour la validation
				 */
				do_action( 'vitalisite_wizard_license_fields' );
				?>

				<div class="vitalisite-wizard-actions">
					<button type="submit" class="button button-primary button-large">
						<?php esc_html_e( 'Continuer', 'vitalisite-fse' ); ?>
						<span class="dashicons dashicons-arrow-right-alt2"></span>
					</button>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Sauvegarde la licence
	 */
	public function save_license() {
		if ( isset( $_POST['license_key'] ) ) {
			$license_key = sanitize_text_field( $_POST['license_key'] );
			update_option( 'vitalisite_license_key', $license_key );

			/**
			 * Hook pour valider la licence avec le plugin Vitalisite
			 */
			do_action( 'vitalisite_validate_license', $license_key );
		}
	}

	/**
	 * Step 2 : Informations du médecin
	 */
	public function step_doctor_info() {
		$doctor_info = get_option( 'vitalisite_doctor_info', array() );
		?>
		<div class="vitalisite-wizard-content">
			<h2><?php esc_html_e( 'Informations du professionnel de santé', 'vitalisite-fse' ); ?></h2>
			<p><?php esc_html_e( 'Ces informations seront utilisées dans les différentes sections de votre site.', 'vitalisite-fse' ); ?></p>

			<form method="post" class="vitalisite-wizard-form" enctype="multipart/form-data">
				<?php wp_nonce_field( 'vitalisite_wizard_save', 'vitalisite_wizard_nonce' ); ?>
				<input type="hidden" name="current_step" value="doctor_info">

				<div class="form-row">
					<div class="form-group">
						<label for="doctor_name">
							<?php esc_html_e( 'Nom complet', 'vitalisite-fse' ); ?>
							<span class="required">*</span>
						</label>
						<input 
							type="text" 
							id="doctor_name" 
							name="doctor_name" 
							value="<?php echo esc_attr( $doctor_info['name'] ?? '' ); ?>"
							placeholder="Dr. Martin Dupont"
							required
						>
					</div>

					<div class="form-group">
						<label for="doctor_specialty">
							<?php esc_html_e( 'Spécialité', 'vitalisite-fse' ); ?>
							<span class="required">*</span>
						</label>
						<input 
							type="text" 
							id="doctor_specialty" 
							name="doctor_specialty" 
							value="<?php echo esc_attr( $doctor_info['specialty'] ?? '' ); ?>"
							placeholder="Médecin généraliste"
							required
						>
					</div>
				</div>

				<div class="form-group">
					<label for="doctor_address">
						<?php esc_html_e( 'Adresse du cabinet', 'vitalisite-fse' ); ?>
						<span class="required">*</span>
					</label>
					<textarea 
						id="doctor_address" 
						name="doctor_address" 
						rows="3"
						placeholder="123 Rue de la Santé&#10;75001 Paris"
						required
					><?php echo esc_textarea( $doctor_info['address'] ?? '' ); ?></textarea>
				</div>

				<div class="form-row">
					<div class="form-group">
						<label for="doctor_phone">
							<?php esc_html_e( 'Téléphone', 'vitalisite-fse' ); ?>
							<span class="required">*</span>
						</label>
						<input 
							type="tel" 
							id="doctor_phone" 
							name="doctor_phone" 
							value="<?php echo esc_attr( $doctor_info['phone'] ?? '' ); ?>"
							placeholder="01 23 45 67 89"
							required
						>
					</div>

					<div class="form-group">
						<label for="doctor_email">
							<?php esc_html_e( 'Email', 'vitalisite-fse' ); ?>
							<span class="required">*</span>
						</label>
						<input 
							type="email" 
							id="doctor_email" 
							name="doctor_email" 
							value="<?php echo esc_attr( $doctor_info['email'] ?? '' ); ?>"
							placeholder="contact@cabinet.fr"
							required
						>
					</div>
				</div>

				<div class="form-group">
					<label for="booking_link">
						<?php esc_html_e( 'Lien de prise de rendez-vous', 'vitalisite-fse' ); ?>
					</label>
					<input 
						type="url" 
						id="booking_link" 
						name="booking_link" 
						value="<?php echo esc_url( $doctor_info['booking_link'] ?? '' ); ?>"
						placeholder="https://www.doctolib.fr/..."
					>
					<p class="description">
						<?php esc_html_e( 'Lien Doctolib, Resalib, Maiia ou autre plateforme de réservation', 'vitalisite-fse' ); ?>
					</p>
				</div>

				<div class="form-group">
					<label>
						<input 
							type="checkbox" 
							name="has_visio" 
							value="1"
							<?php checked( ! empty( $doctor_info['has_visio'] ) ); ?>
						>
						<?php esc_html_e( 'Je propose des consultations en visioconférence', 'vitalisite-fse' ); ?>
					</label>
				</div>

				<div class="form-group">
					<label for="doctor_photo">
						<?php esc_html_e( 'Photo du professionnel', 'vitalisite-fse' ); ?>
					</label>
					<div class="photo-upload-wrapper">
						<?php
						$photo_id = $doctor_info['photo_id'] ?? 0;
						if ( $photo_id ) {
							$photo_url = wp_get_attachment_image_url( $photo_id, 'thumbnail' );
							?>
							<div class="photo-preview">
								<img src="<?php echo esc_url( $photo_url ); ?>" alt="">
								<button type="button" class="remove-photo" data-photo-id="<?php echo esc_attr( $photo_id ); ?>">
									<span class="dashicons dashicons-no"></span>
								</button>
							</div>
							<?php
						}
						?>
						<button type="button" class="button upload-photo-button">
							<span class="dashicons dashicons-upload"></span>
							<?php esc_html_e( 'Choisir une photo', 'vitalisite-fse' ); ?>
						</button>
						<input type="hidden" name="doctor_photo_id" id="doctor_photo_id" value="<?php echo esc_attr( $photo_id ); ?>">
					</div>
					<p class="description">
						<?php esc_html_e( 'Photo professionnelle pour la page À propos (optionnel)', 'vitalisite-fse' ); ?>
					</p>
				</div>

				<div class="vitalisite-wizard-actions">
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=' . $this->page_slug . '&step=license' ) ); ?>" class="button button-large">
						<span class="dashicons dashicons-arrow-left-alt2"></span>
						<?php esc_html_e( 'Retour', 'vitalisite-fse' ); ?>
					</a>
					<button type="submit" class="button button-primary button-large">
						<?php esc_html_e( 'Continuer', 'vitalisite-fse' ); ?>
						<span class="dashicons dashicons-arrow-right-alt2"></span>
					</button>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Sauvegarde les informations du médecin
	 */
	public function save_doctor_info() {
		$doctor_info = array(
			'name'         => isset( $_POST['doctor_name'] ) ? sanitize_text_field( $_POST['doctor_name'] ) : '',
			'specialty'    => isset( $_POST['doctor_specialty'] ) ? sanitize_text_field( $_POST['doctor_specialty'] ) : '',
			'address'      => isset( $_POST['doctor_address'] ) ? sanitize_textarea_field( $_POST['doctor_address'] ) : '',
			'phone'        => isset( $_POST['doctor_phone'] ) ? sanitize_text_field( $_POST['doctor_phone'] ) : '',
			'email'        => isset( $_POST['doctor_email'] ) ? sanitize_email( $_POST['doctor_email'] ) : '',
			'booking_link' => isset( $_POST['booking_link'] ) ? esc_url_raw( $_POST['booking_link'] ) : '',
			'has_visio'    => isset( $_POST['has_visio'] ) ? true : false,
			'photo_id'     => isset( $_POST['doctor_photo_id'] ) ? absint( $_POST['doctor_photo_id'] ) : 0,
		);

		update_option( 'vitalisite_doctor_info', $doctor_info );
	}

	/**
	 * Step 3 : Customisation
	 */
	public function step_customization() {
		// Récupérer les valeurs actuelles de theme.json
		$theme_json = $this->get_theme_json();
		$current_colors = $theme_json['settings']['color']['palette'] ?? array();
		$current_fonts = $theme_json['settings']['typography']['fontFamilies'] ?? array();

		// Extraire les couleurs principales
		$primary_color = $this->get_color_by_slug( $current_colors, 'primary' );
		$secondary_color = $this->get_color_by_slug( $current_colors, 'secondary' );
		$accent_color = $this->get_color_by_slug( $current_colors, 'accent' );

		// Extraire les fonts
		$heading_font = $current_fonts[0]['slug'] ?? 'montserrat';
		$body_font = $current_fonts[0]['slug'] ?? 'montserrat';
		?>
		<div class="vitalisite-wizard-content">
			<h2><?php esc_html_e( 'Personnalisation du thème', 'vitalisite-fse' ); ?></h2>
			<p><?php esc_html_e( 'Choisissez les couleurs et typographies de votre site.', 'vitalisite-fse' ); ?></p>

			<form method="post" class="vitalisite-wizard-form">
				<?php wp_nonce_field( 'vitalisite_wizard_save', 'vitalisite_wizard_nonce' ); ?>
				<input type="hidden" name="current_step" value="customization">

				<h3><?php esc_html_e( 'Couleurs', 'vitalisite-fse' ); ?></h3>
				
				<div class="form-row">
					<div class="form-group">
						<label for="primary_color">
							<?php esc_html_e( 'Couleur principale', 'vitalisite-fse' ); ?>
						</label>
						<input 
							type="color" 
							id="primary_color" 
							name="primary_color" 
							value="<?php echo esc_attr( $primary_color ); ?>"
							class="color-picker"
						>
						<p class="description">
							<?php esc_html_e( 'Utilisée pour les titres et éléments importants', 'vitalisite-fse' ); ?>
						</p>
					</div>

					<div class="form-group">
						<label for="secondary_color">
							<?php esc_html_e( 'Couleur secondaire', 'vitalisite-fse' ); ?>
						</label>
						<input 
							type="color" 
							id="secondary_color" 
							name="secondary_color" 
							value="<?php echo esc_attr( $secondary_color ); ?>"
							class="color-picker"
						>
						<p class="description">
							<?php esc_html_e( 'Couleur complémentaire', 'vitalisite-fse' ); ?>
						</p>
					</div>

					<div class="form-group">
						<label for="accent_color">
							<?php esc_html_e( 'Couleur d\'accent', 'vitalisite-fse' ); ?>
						</label>
						<input 
							type="color" 
							id="accent_color" 
							name="accent_color" 
							value="<?php echo esc_attr( $accent_color ); ?>"
							class="color-picker"
						>
						<p class="description">
							<?php esc_html_e( 'Utilisée pour les boutons et liens', 'vitalisite-fse' ); ?>
						</p>
					</div>
				</div>

				<h3><?php esc_html_e( 'Typographie', 'vitalisite-fse' ); ?></h3>

				<div class="form-row">
					<div class="form-group">
						<label for="heading_font">
							<?php esc_html_e( 'Police des titres', 'vitalisite-fse' ); ?>
						</label>
						<select id="heading_font" name="heading_font">
							<option value="montserrat" <?php selected( $heading_font, 'montserrat' ); ?>>Montserrat</option>
							<option value="roboto" <?php selected( $heading_font, 'roboto' ); ?>>Roboto</option>
							<option value="system-font" <?php selected( $heading_font, 'system-font' ); ?>>System Font</option>
						</select>
					</div>

					<div class="form-group">
						<label for="body_font">
							<?php esc_html_e( 'Police du texte', 'vitalisite-fse' ); ?>
						</label>
						<select id="body_font" name="body_font">
							<option value="montserrat" <?php selected( $body_font, 'montserrat' ); ?>>Montserrat</option>
							<option value="roboto" <?php selected( $body_font, 'roboto' ); ?>>Roboto</option>
							<option value="system-font" <?php selected( $body_font, 'system-font' ); ?>>System Font</option>
						</select>
					</div>
				</div>

				<div class="color-preview-section">
					<h4><?php esc_html_e( 'Aperçu', 'vitalisite-fse' ); ?></h4>
					<div class="preview-box">
						<h2 class="preview-heading" style="color: <?php echo esc_attr( $primary_color ); ?>">
							<?php esc_html_e( 'Titre principal', 'vitalisite-fse' ); ?>
						</h2>
						<p class="preview-text">
							<?php esc_html_e( 'Ceci est un exemple de texte pour visualiser vos choix de couleurs et typographie.', 'vitalisite-fse' ); ?>
						</p>
						<button type="button" class="preview-button" style="background-color: <?php echo esc_attr( $accent_color ); ?>">
							<?php esc_html_e( 'Prendre rendez-vous', 'vitalisite-fse' ); ?>
						</button>
					</div>
				</div>

				<div class="vitalisite-wizard-actions">
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=' . $this->page_slug . '&step=doctor_info' ) ); ?>" class="button button-large">
						<span class="dashicons dashicons-arrow-left-alt2"></span>
						<?php esc_html_e( 'Retour', 'vitalisite-fse' ); ?>
					</a>
					<button type="submit" class="button button-primary button-large">
						<?php esc_html_e( 'Terminer la configuration', 'vitalisite-fse' ); ?>
						<span class="dashicons dashicons-yes"></span>
					</button>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Sauvegarde la customisation et met à jour theme.json
	 */
	public function save_customization() {
		$primary_color = isset( $_POST['primary_color'] ) ? sanitize_hex_color( $_POST['primary_color'] ) : '#03045E';
		$secondary_color = isset( $_POST['secondary_color'] ) ? sanitize_hex_color( $_POST['secondary_color'] ) : '#09243C';
		$accent_color = isset( $_POST['accent_color'] ) ? sanitize_hex_color( $_POST['accent_color'] ) : '#177BCB';
		$heading_font = isset( $_POST['heading_font'] ) ? sanitize_text_field( $_POST['heading_font'] ) : 'montserrat';
		$body_font = isset( $_POST['body_font'] ) ? sanitize_text_field( $_POST['body_font'] ) : 'montserrat';

		// Mettre à jour theme.json
		$this->update_theme_json( array(
			'primary_color'   => $primary_color,
			'secondary_color' => $secondary_color,
			'accent_color'    => $accent_color,
			'heading_font'    => $heading_font,
			'body_font'       => $body_font,
		) );

		// Marquer le setup comme complété
		update_option( 'vitalisite_setup_complete', true );
	}

	/**
	 * Step 4 : Terminé
	 */
	public function step_done() {
		?>
		<div class="vitalisite-wizard-content vitalisite-wizard-done">
			<div class="done-icon">
				<span class="dashicons dashicons-yes-alt"></span>
			</div>
			<h2><?php esc_html_e( 'Configuration terminée !', 'vitalisite-fse' ); ?></h2>
			<p><?php esc_html_e( 'Votre site Vitalisite est maintenant configuré et prêt à être personnalisé.', 'vitalisite-fse' ); ?></p>

			<div class="next-steps">
				<h3><?php esc_html_e( 'Prochaines étapes', 'vitalisite-fse' ); ?></h3>
				<ul>
					<li>
						<span class="dashicons dashicons-admin-appearance"></span>
						<?php esc_html_e( 'Personnalisez votre site avec l\'éditeur de site', 'vitalisite-fse' ); ?>
					</li>
					<li>
						<span class="dashicons dashicons-admin-page"></span>
						<?php esc_html_e( 'Créez vos pages avec les patterns disponibles', 'vitalisite-fse' ); ?>
					</li>
					<li>
						<span class="dashicons dashicons-admin-media"></span>
						<?php esc_html_e( 'Ajoutez vos propres images et contenus', 'vitalisite-fse' ); ?>
					</li>
				</ul>
			</div>

			<div class="vitalisite-wizard-actions">
				<a href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>" class="button button-primary button-large">
					<span class="dashicons dashicons-edit"></span>
					<?php esc_html_e( 'Ouvrir l\'éditeur de site', 'vitalisite-fse' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url() ); ?>" class="button button-large">
					<?php esc_html_e( 'Retour au tableau de bord', 'vitalisite-fse' ); ?>
				</a>
			</div>
		</div>
		<?php
	}

	/**
	 * Récupère le contenu de theme.json
	 */
	private function get_theme_json() {
		$theme_json_path = get_template_directory() . '/theme.json';
		
		if ( ! file_exists( $theme_json_path ) ) {
			return array();
		}

		$theme_json_content = file_get_contents( $theme_json_path );
		return json_decode( $theme_json_content, true );
	}

	/**
	 * Met à jour theme.json avec les nouvelles valeurs
	 */
	private function update_theme_json( $values ) {
		$theme_json = $this->get_theme_json();

		if ( empty( $theme_json ) ) {
			return false;
		}

		// Mettre à jour les couleurs
		if ( isset( $theme_json['settings']['color']['palette'] ) ) {
			foreach ( $theme_json['settings']['color']['palette'] as &$color ) {
				if ( $color['slug'] === 'primary' && isset( $values['primary_color'] ) ) {
					$color['color'] = $values['primary_color'];
				}
				if ( $color['slug'] === 'secondary' && isset( $values['secondary_color'] ) ) {
					$color['color'] = $values['secondary_color'];
				}
				if ( $color['slug'] === 'accent' && isset( $values['accent_color'] ) ) {
					$color['color'] = $values['accent_color'];
				}
			}
		}

		// Mettre à jour la font principale dans styles
		if ( isset( $values['body_font'] ) ) {
			$theme_json['styles']['typography']['fontFamily'] = 'var(--wp--preset--font-family--' . $values['body_font'] . ')';
		}

		// Sauvegarder le fichier theme.json
		$theme_json_path = get_template_directory() . '/theme.json';
		$json_content = json_encode( $theme_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
		
		return file_put_contents( $theme_json_path, $json_content );
	}

	/**
	 * Récupère une couleur par son slug
	 */
	private function get_color_by_slug( $colors, $slug ) {
		foreach ( $colors as $color ) {
			if ( $color['slug'] === $slug ) {
				return $color['color'];
			}
		}
		return '#000000';
	}
}

// Initialiser le wizard
Vitalisite_Setup_Wizard::get_instance();
