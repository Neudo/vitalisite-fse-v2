<?php
/**
 * Custom Post Type: Specialities
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_CPT_Specialities {

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
			'name'               => __( 'Spécialités', 'vitalisite-fse' ),
			'singular_name'      => __( 'Spécialité', 'vitalisite-fse' ),
			'add_new'            => __( 'Ajouter une spécialité', 'vitalisite-fse' ),
			'add_new_item'       => __( 'Ajouter une nouvelle spécialité', 'vitalisite-fse' ),
			'edit_item'          => __( 'Modifier la spécialité', 'vitalisite-fse' ),
			'new_item'           => __( 'Nouvelle spécialité', 'vitalisite-fse' ),
			'view_item'          => __( 'Voir la spécialité', 'vitalisite-fse' ),
			'all_items'          => __( 'Toutes les spécialités', 'vitalisite-fse' ),
			'search_items'       => __( 'Rechercher une spécialité', 'vitalisite-fse' ),
			'not_found'          => __( 'Aucune spécialité trouvée', 'vitalisite-fse' ),
			'not_found_in_trash' => __( 'Aucune spécialité dans la corbeille', 'vitalisite-fse' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'specialites' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 6,
			'menu_icon'          => 'dashicons-portfolio',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'specialities', $args );
	}

	/**
	 * Ajoute les meta boxes
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'vitalisite_speciality_details',
			__( 'Détails de la spécialité', 'vitalisite-fse' ),
			array( $this, 'render_meta_box' ),
			'specialities',
			'normal',
			'high'
		);
	}

	/**
	 * Affiche la meta box
	 */
	public function render_meta_box( $post ) {
		$short_description = get_post_meta( $post->ID, '_speciality_short_description', true );
		$photo = get_post_meta( $post->ID, '_speciality_photo', true );
		$image_url = $photo ? wp_get_attachment_image_url( $photo, 'thumbnail' ) : '';
		
		wp_nonce_field( 'vitalisite_save_speciality', 'vitalisite_speciality_nonce' );
		?>
		<div class="vitalisite-meta-box">
			<p>
				<label><strong><?php esc_html_e( 'Image de présentation', 'vitalisite-fse' ); ?></strong></label><br>
				<img id="speciality_photo_preview" src="<?php echo esc_url( $image_url ); ?>" style="max-width:150px; max-height:150px; display:<?php echo $image_url ? 'block' : 'none'; ?>; margin: 10px 0;">
				<input type="hidden" id="speciality_photo" name="speciality_photo" value="<?php echo esc_attr( $photo ); ?>">
				<button type="button" class="button" id="speciality_photo_button"><?php esc_html_e( 'Ajouter une image', 'vitalisite-fse' ); ?></button>
				<button type="button" class="button" id="speciality_photo_remove" style="display:<?php echo $photo ? 'inline-block' : 'none'; ?>;"><?php esc_html_e( 'Supprimer', 'vitalisite-fse' ); ?></button>
			</p>
			<p>
				<label for="speciality_short_description"><strong><?php esc_html_e( 'Description courte', 'vitalisite-fse' ); ?></strong></label><br>
				<textarea id="speciality_short_description" name="speciality_short_description" rows="3" class="widefat"><?php echo esc_textarea( $short_description ); ?></textarea>
				<span class="description"><?php esc_html_e( 'Résumé affiché dans les listes (max 150 caractères recommandés)', 'vitalisite-fse' ); ?></span>
			</p>
		</div>
		<?php
	}

	/**
	 * Sauvegarde les meta boxes
	 */
	public function save_meta_boxes( $post_id ) {
		// Vérifications de sécurité
		if ( ! isset( $_POST['vitalisite_speciality_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['vitalisite_speciality_nonce'], 'vitalisite_save_speciality' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Sauvegarde des champs
		if ( isset( $_POST['speciality_photo'] ) ) {
			update_post_meta( $post_id, '_speciality_photo', absint( $_POST['speciality_photo'] ) );
		}

		if ( isset( $_POST['speciality_short_description'] ) ) {
			update_post_meta( $post_id, '_speciality_short_description', sanitize_textarea_field( $_POST['speciality_short_description'] ) );
		}
	}

	/**
	 * Enqueue les scripts admin
	 */
	public function enqueue_admin_scripts( $hook ) {
		global $post_type;
		
		if ( 'specialities' === $post_type && in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
			wp_enqueue_media();
			
			// Inline script pour le Media Uploader
			wp_add_inline_script( 'jquery', '
				jQuery(document).ready(function($) {
					var mediaUploader;
					
					$("#speciality_photo_button").click(function(e) {
						e.preventDefault();
						
						if (mediaUploader) {
							mediaUploader.open();
							return;
						}
						
						mediaUploader = wp.media({
							title: "Choisissez une image",
							button: { text: "Utiliser cette image" },
							multiple: false
						});
						
						mediaUploader.on("select", function() {
							var attachment = mediaUploader.state().get("selection").first().toJSON();
							$("#speciality_photo").val(attachment.id);
							$("#speciality_photo_preview").attr("src", attachment.url).show();
							$("#speciality_photo_remove").show();
						});
						
						mediaUploader.open();
					});
					
					$("#speciality_photo_remove").click(function(e) {
						e.preventDefault();
						$("#speciality_photo").val("");
						$("#speciality_photo_preview").hide();
						$(this).hide();
					});
				});
			' );
		}
	}

	/**
	 * Récupère les spécialités
	 */
	public static function get_specialities( $args = array() ) {
		$defaults = array(
			'post_type'      => 'specialities',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		);

		$args = wp_parse_args( $args, $defaults );
		return get_posts( $args );
	}
}

// Initialiser
Vitalisite_CPT_Specialities::get_instance();
