<?php
/**
 * Custom Post Type: Spécialités
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_CPT_Specialities {

	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ) );
	}

	public function register_post_type() {
		$labels = array(
			'name'               => __( 'Spécialités', 'vitalisite-fse' ),
			'singular_name'      => __( 'Spécialité', 'vitalisite-fse' ),
			'menu_name'          => __( 'Spécialités', 'vitalisite-fse' ),
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
			'menu_icon'          => 'dashicons-plus-alt',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'specialities', $args );
	}

	public function add_meta_boxes() {
		add_meta_box(
			'vitalisite_speciality_details',
			__( 'Détails de la spécialité', 'vitalisite-fse' ),
			array( $this, 'render_meta_box' ),
			'specialities',
			'side',
			'default'
		);
	}

	public function render_meta_box( $post ) {
		$icon  = get_post_meta( $post->ID, '_speciality_icon', true );
		$order = get_post_meta( $post->ID, '_speciality_order', true );

		wp_nonce_field( 'vitalisite_save_speciality', 'vitalisite_speciality_nonce' );
		?>
		<div class="vitalisite-meta-box">
			<style>
				.vitalisite-meta-box .form-row { margin-bottom: 15px; }
				.vitalisite-meta-box label { display: block; margin-bottom: 5px; font-weight: 600; }
				.vitalisite-meta-box .description { color: #666; font-style: italic; font-size: 12px; }
			</style>

			<div class="form-row">
				<label for="speciality_icon"><?php esc_html_e( 'Icône (classe Dashicon ou SVG)', 'vitalisite-fse' ); ?></label>
				<input type="text" id="speciality_icon" name="speciality_icon" value="<?php echo esc_attr( $icon ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Ex: dashicons-heart', 'vitalisite-fse' ); ?>">
				<span class="description"><?php esc_html_e( 'Optionnel. Classe Dashicon ou code SVG pour illustrer la spécialité.', 'vitalisite-fse' ); ?></span>
			</div>

			<div class="form-row">
				<label for="speciality_order"><?php esc_html_e( 'Ordre d\'affichage', 'vitalisite-fse' ); ?></label>
				<input type="number" id="speciality_order" name="speciality_order" value="<?php echo esc_attr( $order ); ?>" class="small-text" min="0" step="1" placeholder="0">
				<span class="description"><?php esc_html_e( 'Ordre de tri (0 = premier).', 'vitalisite-fse' ); ?></span>
			</div>
		</div>
		<?php
	}

	public function save_meta_boxes( $post_id ) {
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

		if ( isset( $_POST['speciality_icon'] ) ) {
			update_post_meta( $post_id, '_speciality_icon', sanitize_text_field( $_POST['speciality_icon'] ) );
		}

		if ( isset( $_POST['speciality_order'] ) ) {
			update_post_meta( $post_id, '_speciality_order', absint( $_POST['speciality_order'] ) );
		}
	}

	public static function get_specialities( $args = array() ) {
		$defaults = array(
			'post_type'      => 'specialities',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'meta_key'       => '_speciality_order',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
		);

		$args = wp_parse_args( $args, $defaults );
		return get_posts( $args );
	}
}

Vitalisite_CPT_Specialities::get_instance();
