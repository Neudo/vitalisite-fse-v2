<?php
/**
 * Custom Post Type: Doctors
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_CPT_Doctors {

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
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Enregistre le CPT
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => __( 'Équipe médicale', 'vitalisite-fse' ),
			'singular_name'      => __( 'Membre', 'vitalisite-fse' ),
			'menu_name'          => __( 'Équipe', 'vitalisite-fse' ),
			'add_new'            => __( 'Ajouter un membre', 'vitalisite-fse' ),
			'add_new_item'       => __( 'Ajouter un nouveau membre', 'vitalisite-fse' ),
			'edit_item'          => __( 'Modifier le membre', 'vitalisite-fse' ),
			'new_item'           => __( 'Nouveau membre', 'vitalisite-fse' ),
			'view_item'          => __( 'Voir le membre', 'vitalisite-fse' ),
			'all_items'          => __( 'Tous les membres', 'vitalisite-fse' ),
			'search_items'       => __( 'Rechercher un membre', 'vitalisite-fse' ),
			'not_found'          => __( 'Aucun membre trouvé', 'vitalisite-fse' ),
			'not_found_in_trash' => __( 'Aucun membre dans la corbeille', 'vitalisite-fse' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'equipe' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-id',
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'doctors', $args );
	}

	/**
	 * Ajoute les meta boxes
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'vitalisite_doctor_details',
			__( 'Informations du membre', 'vitalisite-fse' ),
			array( $this, 'render_meta_box' ),
			'doctors',
			'normal',
			'high'
		);
	}

	/**
	 * Affiche la meta box
	 */
	public function render_meta_box( $post ) {
		$first_name = get_post_meta( $post->ID, '_doctor_first_name', true );
		$last_name = get_post_meta( $post->ID, '_doctor_last_name', true );
		$speciality_id = get_post_meta( $post->ID, '_doctor_speciality', true );
		$phone = get_post_meta( $post->ID, '_doctor_phone', true );
		$email = get_post_meta( $post->ID, '_doctor_email', true );
		$available_online = get_post_meta( $post->ID, '_doctor_available_online', true );
		$booking_url = get_post_meta( $post->ID, '_doctor_booking_url', true );
		
		// Récupérer les spécialités
		$specialities = get_posts( array(
			'post_type'      => 'specialities',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'ASC',
		) );
		
		wp_nonce_field( 'vitalisite_save_doctor', 'vitalisite_doctor_nonce' );
		?>
		<style>
			.vitalisite-doctor-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
			.vitalisite-doctor-meta .form-row { margin-bottom: 15px; }
			.vitalisite-doctor-meta .form-row.full { grid-column: 1 / -1; }
			.vitalisite-doctor-meta label { display: block; margin-bottom: 5px; font-weight: 600; }
			.vitalisite-doctor-meta .description { color: #666; font-style: italic; font-size: 12px; }
			.vitalisite-doctor-meta input[type="text"],
			.vitalisite-doctor-meta input[type="email"],
			.vitalisite-doctor-meta input[type="tel"],
			.vitalisite-doctor-meta input[type="url"],
			.vitalisite-doctor-meta select { width: 100%; }
		</style>
		
		<div class="vitalisite-doctor-meta">
			<div class="form-row">
				<label for="doctor_first_name"><?php esc_html_e( 'Prénom', 'vitalisite-fse' ); ?></label>
				<input type="text" id="doctor_first_name" name="doctor_first_name" value="<?php echo esc_attr( $first_name ); ?>">
			</div>
			
			<div class="form-row">
				<label for="doctor_last_name"><?php esc_html_e( 'Nom', 'vitalisite-fse' ); ?></label>
				<input type="text" id="doctor_last_name" name="doctor_last_name" value="<?php echo esc_attr( $last_name ); ?>">
			</div>
			
			<div class="form-row">
				<label for="doctor_speciality"><?php esc_html_e( 'Spécialité', 'vitalisite-fse' ); ?></label>
				<select id="doctor_speciality" name="doctor_speciality">
					<option value=""><?php esc_html_e( '-- Sélectionner --', 'vitalisite-fse' ); ?></option>
					<?php foreach ( $specialities as $speciality ) : ?>
						<option value="<?php echo esc_attr( $speciality->ID ); ?>" <?php selected( $speciality_id, $speciality->ID ); ?>>
							<?php echo esc_html( $speciality->post_title ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="form-row">
				<label for="doctor_phone"><?php esc_html_e( 'Téléphone', 'vitalisite-fse' ); ?></label>
				<input type="tel" id="doctor_phone" name="doctor_phone" value="<?php echo esc_attr( $phone ); ?>" placeholder="01 23 45 67 89">
			</div>
			
			<div class="form-row">
				<label for="doctor_email"><?php esc_html_e( 'Email', 'vitalisite-fse' ); ?></label>
				<input type="email" id="doctor_email" name="doctor_email" value="<?php echo esc_attr( $email ); ?>">
			</div>
			
			<div class="form-row">
				<label for="doctor_booking_url"><?php esc_html_e( 'Lien de prise de RDV', 'vitalisite-fse' ); ?></label>
				<input type="url" id="doctor_booking_url" name="doctor_booking_url" value="<?php echo esc_attr( $booking_url ); ?>" placeholder="https://doctolib.fr/...">
			</div>
			
			<div class="form-row full">
				<label>
					<input type="checkbox" name="doctor_available_online" value="1" <?php checked( $available_online, '1' ); ?>>
					<?php esc_html_e( 'Disponible pour les consultations en ligne', 'vitalisite-fse' ); ?>
				</label>
			</div>
		</div>
		<?php
	}

	/**
	 * Sauvegarde les meta boxes
	 */
	public function save_meta_boxes( $post_id ) {
		// Vérifications de sécurité
		if ( ! isset( $_POST['vitalisite_doctor_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['vitalisite_doctor_nonce'], 'vitalisite_save_doctor' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Sauvegarde des champs
		$fields = array(
			'doctor_first_name'      => 'sanitize_text_field',
			'doctor_last_name'       => 'sanitize_text_field',
			'doctor_speciality'      => 'absint',
			'doctor_phone'           => 'sanitize_text_field',
			'doctor_email'           => 'sanitize_email',
			'doctor_booking_url'     => 'esc_url_raw',
		);

		foreach ( $fields as $field => $sanitize_callback ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, '_' . $field, call_user_func( $sanitize_callback, $_POST[ $field ] ) );
			}
		}

		// Checkbox
		update_post_meta( $post_id, '_doctor_available_online', isset( $_POST['doctor_available_online'] ) ? '1' : '0' );
	}

	/**
	 * Enqueue les scripts admin
	 */
	public function enqueue_admin_scripts( $hook ) {
		global $post_type;
		
		if ( 'doctors' === $post_type && in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
			wp_enqueue_media();
		}
	}

	/**
	 * Récupère les docteurs
	 */
	public static function get_doctors( $args = array() ) {
		$defaults = array(
			'post_type'      => 'doctors',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		);

		$args = wp_parse_args( $args, $defaults );
		return get_posts( $args );
	}

	/**
	 * Récupère le nom complet
	 */
	public static function get_full_name( $post_id ) {
		$first_name = get_post_meta( $post_id, '_doctor_first_name', true );
		$last_name = get_post_meta( $post_id, '_doctor_last_name', true );
		
		return trim( $first_name . ' ' . $last_name );
	}
}

// Initialiser
Vitalisite_CPT_Doctors::get_instance();
