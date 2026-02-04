<?php
/**
 * Announcement Bar
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_Announcement_Bar {

	/**
	 * Instance unique
	 */
	private static $instance = null;

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
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'wp_head', array( $this, 'output_announcement_styles' ), 5 );
		add_action( 'wp_body_open', array( $this, 'render_announcement' ), 1 );
	}

	/**
	 * Ajoute le menu admin
	 */
	public function add_menu() {
		add_menu_page(
			__( 'Bandeau Annonce', 'vitalisite-fse' ),
			__( 'Annonce', 'vitalisite-fse' ),
			'manage_options',
			'vitalisite-announcement',
			array( $this, 'render_settings_page' ),
			'dashicons-megaphone',
			80
		);
	}

	/**
	 * Enregistre les settings
	 */
	public function register_settings() {
		register_setting( 'vitalisite_announcement_settings', 'vitalisite_announcement_enabled' );
		register_setting( 'vitalisite_announcement_settings', 'vitalisite_announcement_text' );
		register_setting( 'vitalisite_announcement_settings', 'vitalisite_announcement_link' );
		register_setting( 'vitalisite_announcement_settings', 'vitalisite_announcement_link_text' );
		register_setting( 'vitalisite_announcement_settings', 'vitalisite_announcement_bg_color' );
		register_setting( 'vitalisite_announcement_settings', 'vitalisite_announcement_text_color' );
		register_setting( 'vitalisite_announcement_settings', 'vitalisite_announcement_dismissible' );

		add_settings_section(
			'vitalisite_announcement_section',
			'',
			null,
			'vitalisite-announcement'
		);

		add_settings_field(
			'vitalisite_announcement_enabled',
			__( 'Activer le bandeau', 'vitalisite-fse' ),
			array( $this, 'render_enabled_field' ),
			'vitalisite-announcement',
			'vitalisite_announcement_section'
		);

		add_settings_field(
			'vitalisite_announcement_text',
			__( 'Texte de l\'annonce', 'vitalisite-fse' ),
			array( $this, 'render_text_field' ),
			'vitalisite-announcement',
			'vitalisite_announcement_section'
		);

		add_settings_field(
			'vitalisite_announcement_link',
			__( 'Lien (optionnel)', 'vitalisite-fse' ),
			array( $this, 'render_link_field' ),
			'vitalisite-announcement',
			'vitalisite_announcement_section'
		);

		add_settings_field(
			'vitalisite_announcement_link_text',
			__( 'Texte du lien', 'vitalisite-fse' ),
			array( $this, 'render_link_text_field' ),
			'vitalisite-announcement',
			'vitalisite_announcement_section'
		);

		add_settings_field(
			'vitalisite_announcement_bg_color',
			__( 'Couleur de fond', 'vitalisite-fse' ),
			array( $this, 'render_bg_color_field' ),
			'vitalisite-announcement',
			'vitalisite_announcement_section'
		);

		add_settings_field(
			'vitalisite_announcement_text_color',
			__( 'Couleur du texte', 'vitalisite-fse' ),
			array( $this, 'render_text_color_field' ),
			'vitalisite-announcement',
			'vitalisite_announcement_section'
		);

		add_settings_field(
			'vitalisite_announcement_dismissible',
			__( 'Peut être fermé', 'vitalisite-fse' ),
			array( $this, 'render_dismissible_field' ),
			'vitalisite-announcement',
			'vitalisite_announcement_section'
		);
	}

	/**
	 * Page de settings
	 */
	public function render_settings_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Bandeau d\'Annonce', 'vitalisite-fse' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'vitalisite_announcement_settings' );
				do_settings_sections( 'vitalisite-announcement' );
				submit_button();
				?>
			</form>
			
			<div class="vitalisite-announcement-preview" style="margin-top: 30px;">
				<h2><?php esc_html_e( 'Aperçu', 'vitalisite-fse' ); ?></h2>
				<?php $this->render_announcement( true ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Champ enabled
	 */
	public function render_enabled_field() {
		$value = get_option( 'vitalisite_announcement_enabled', false );
		?>
		<label>
			<input type="checkbox" name="vitalisite_announcement_enabled" value="1" <?php checked( 1, $value ); ?>>
			<?php esc_html_e( 'Afficher le bandeau d\'annonce sur le site', 'vitalisite-fse' ); ?>
		</label>
		<?php
	}

	/**
	 * Champ texte
	 */
	public function render_text_field() {
		$value = get_option( 'vitalisite_announcement_text', '' );
		?>
		<input type="text" name="vitalisite_announcement_text" value="<?php echo esc_attr( $value ); ?>" class="regular-text" style="width: 100%; max-width: 500px;">
		<p class="description"><?php esc_html_e( 'Le message à afficher dans le bandeau', 'vitalisite-fse' ); ?></p>
		<?php
	}

	/**
	 * Champ lien
	 */
	public function render_link_field() {
		$value = get_option( 'vitalisite_announcement_link', '' );
		?>
		<input type="url" name="vitalisite_announcement_link" value="<?php echo esc_attr( $value ); ?>" class="regular-text" placeholder="https://">
		<?php
	}

	/**
	 * Champ texte du lien
	 */
	public function render_link_text_field() {
		$value = get_option( 'vitalisite_announcement_link_text', __( 'En savoir plus', 'vitalisite-fse' ) );
		?>
		<input type="text" name="vitalisite_announcement_link_text" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
		<?php
	}

	/**
	 * Champ couleur de fond
	 */
	public function render_bg_color_field() {
		$value = get_option( 'vitalisite_announcement_bg_color', '#03045e' );
		?>
		<input type="color" name="vitalisite_announcement_bg_color" value="<?php echo esc_attr( $value ); ?>">
		<?php
	}

	/**
	 * Champ couleur du texte
	 */
	public function render_text_color_field() {
		$value = get_option( 'vitalisite_announcement_text_color', '#ffffff' );
		?>
		<input type="color" name="vitalisite_announcement_text_color" value="<?php echo esc_attr( $value ); ?>">
		<?php
	}

	/**
	 * Champ dismissible
	 */
	public function render_dismissible_field() {
		$value = get_option( 'vitalisite_announcement_dismissible', true );
		?>
		<label>
			<input type="checkbox" name="vitalisite_announcement_dismissible" value="1" <?php checked( 1, $value ); ?>>
			<?php esc_html_e( 'Permettre aux visiteurs de fermer le bandeau', 'vitalisite-fse' ); ?>
		</label>
		<?php
	}

	/**
	 * Styles CSS
	 */
	public function output_announcement_styles() {
		if ( ! get_option( 'vitalisite_announcement_enabled', false ) ) {
			return;
		}

		$bg_color = get_option( 'vitalisite_announcement_bg_color', '#03045e' );
		$text_color = get_option( 'vitalisite_announcement_text_color', '#ffffff' );
		?>
		<style id="vitalisite-announcement-styles">
			.vitalisite-announcement-bar {
				background-color: <?php echo esc_attr( $bg_color ); ?>;
				color: <?php echo esc_attr( $text_color ); ?>;
				padding: 10px 20px;
				text-align: center;
				font-size: 14px;
				position: relative;
				z-index: 9999;
			}
			.vitalisite-announcement-bar a {
				color: <?php echo esc_attr( $text_color ); ?>;
				text-decoration: underline;
				margin-left: 10px;
				font-weight: 600;
			}
			.vitalisite-announcement-bar a:hover {
				opacity: 0.8;
			}
			.vitalisite-announcement-bar__close {
				position: absolute;
				right: 15px;
				top: 50%;
				transform: translateY(-50%);
				background: none;
				border: none;
				color: <?php echo esc_attr( $text_color ); ?>;
				cursor: pointer;
				font-size: 20px;
				line-height: 1;
				padding: 5px;
				opacity: 0.7;
			}
			.vitalisite-announcement-bar__close:hover {
				opacity: 1;
			}
			.vitalisite-announcement-bar.is-hidden {
				display: none;
			}
		</style>
		<?php
	}

	/**
	 * Affiche le bandeau
	 */
	public function render_announcement( $force = false ) {
		if ( ! $force && ! get_option( 'vitalisite_announcement_enabled', false ) ) {
			return;
		}

		$text = get_option( 'vitalisite_announcement_text', '' );
		
		if ( empty( $text ) ) {
			return;
		}

		$link = get_option( 'vitalisite_announcement_link', '' );
		$link_text = get_option( 'vitalisite_announcement_link_text', __( 'En savoir plus', 'vitalisite-fse' ) );
		$dismissible = get_option( 'vitalisite_announcement_dismissible', true );
		?>
		<div class="vitalisite-announcement-bar" id="vitalisite-announcement">
			<span class="vitalisite-announcement-bar__text"><?php echo esc_html( $text ); ?></span>
			<?php if ( $link ) : ?>
				<a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $link_text ); ?></a>
			<?php endif; ?>
			<?php if ( $dismissible ) : ?>
				<button type="button" class="vitalisite-announcement-bar__close" aria-label="<?php esc_attr_e( 'Fermer', 'vitalisite-fse' ); ?>" onclick="this.parentElement.classList.add('is-hidden'); localStorage.setItem('vitalisite_announcement_closed', Date.now());">
					×
				</button>
			<?php endif; ?>
		</div>
		<?php if ( $dismissible && ! $force ) : ?>
		<script>
			(function() {
				var closed = localStorage.getItem('vitalisite_announcement_closed');
				if (closed && (Date.now() - parseInt(closed)) < 86400000) {
					document.getElementById('vitalisite-announcement').classList.add('is-hidden');
				}
			})();
		</script>
		<?php endif;
	}
}

// Initialiser
Vitalisite_Announcement_Bar::get_instance();
