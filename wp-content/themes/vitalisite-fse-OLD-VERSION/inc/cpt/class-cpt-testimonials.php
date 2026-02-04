<?php
/**
 * Custom Post Type: Testimonials
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_CPT_Testimonials {

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
	}

	/**
	 * Enregistre le CPT
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => __( 'Témoignages', 'vitalisite-fse' ),
			'singular_name'      => __( 'Témoignage', 'vitalisite-fse' ),
			'menu_name'          => __( 'Témoignages', 'vitalisite-fse' ),
			'add_new'            => __( 'Ajouter un témoignage', 'vitalisite-fse' ),
			'add_new_item'       => __( 'Ajouter un nouveau témoignage', 'vitalisite-fse' ),
			'edit_item'          => __( 'Modifier le témoignage', 'vitalisite-fse' ),
			'new_item'           => __( 'Nouveau témoignage', 'vitalisite-fse' ),
			'view_item'          => __( 'Voir le témoignage', 'vitalisite-fse' ),
			'all_items'          => __( 'Tous les témoignages', 'vitalisite-fse' ),
			'search_items'       => __( 'Rechercher un témoignage', 'vitalisite-fse' ),
			'not_found'          => __( 'Aucun témoignage trouvé', 'vitalisite-fse' ),
			'not_found_in_trash' => __( 'Aucun témoignage dans la corbeille', 'vitalisite-fse' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'temoignages' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 7,
			'menu_icon'          => 'dashicons-testimonial',
			'supports'           => array( 'title' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'testimonials', $args );
	}

	/**
	 * Ajoute les meta boxes
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'vitalisite_testimonial_details',
			__( 'Détails du témoignage', 'vitalisite-fse' ),
			array( $this, 'render_meta_box' ),
			'testimonials',
			'normal',
			'high'
		);
	}

	/**
	 * Affiche la meta box
	 */
	public function render_meta_box( $post ) {
		$comment = get_post_meta( $post->ID, '_testimonial_comment', true );
		$rating = get_post_meta( $post->ID, '_testimonial_rating', true );
		$author_role = get_post_meta( $post->ID, '_testimonial_author_role', true );
		$date = get_post_meta( $post->ID, '_testimonial_date', true );
		
		wp_nonce_field( 'vitalisite_save_testimonial', 'vitalisite_testimonial_nonce' );
		?>
		<div class="vitalisite-meta-box">
			<style>
				.vitalisite-meta-box .form-row { margin-bottom: 15px; }
				.vitalisite-meta-box label { display: block; margin-bottom: 5px; font-weight: 600; }
				.vitalisite-meta-box .description { color: #666; font-style: italic; font-size: 12px; }
				.vitalisite-meta-box .star-rating { display: flex; gap: 5px; }
				.vitalisite-meta-box .star-rating input[type="radio"] { display: none; }
				.vitalisite-meta-box .star-rating label { cursor: pointer; font-size: 24px; color: #ddd; }
				.vitalisite-meta-box .star-rating label:hover,
				.vitalisite-meta-box .star-rating label:hover ~ label,
				.vitalisite-meta-box .star-rating input:checked ~ label { color: #f1c40f; }
			</style>
			
			<div class="form-row">
				<label for="testimonial_comment"><?php esc_html_e( 'Témoignage', 'vitalisite-fse' ); ?></label>
				<textarea id="testimonial_comment" name="testimonial_comment" rows="5" class="widefat" maxlength="500"><?php echo esc_textarea( $comment ); ?></textarea>
				<span class="description"><?php esc_html_e( 'Le contenu du témoignage (max 500 caractères)', 'vitalisite-fse' ); ?></span>
			</div>
			
			<div class="form-row">
				<label><?php esc_html_e( 'Note', 'vitalisite-fse' ); ?></label>
				<div class="star-rating" style="flex-direction: row-reverse; justify-content: flex-end;">
					<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
						<input type="radio" id="rating_<?php echo $i; ?>" name="testimonial_rating" value="<?php echo $i; ?>" <?php checked( $rating, $i ); ?>>
						<label for="rating_<?php echo $i; ?>">★</label>
					<?php endfor; ?>
				</div>
			</div>
			
			<div class="form-row">
				<label for="testimonial_author_role"><?php esc_html_e( 'Rôle/Titre de l\'auteur', 'vitalisite-fse' ); ?></label>
				<input type="text" id="testimonial_author_role" name="testimonial_author_role" value="<?php echo esc_attr( $author_role ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Ex: Patient depuis 2020', 'vitalisite-fse' ); ?>">
			</div>
			
			<div class="form-row">
				<label for="testimonial_date"><?php esc_html_e( 'Date du témoignage', 'vitalisite-fse' ); ?></label>
				<input type="date" id="testimonial_date" name="testimonial_date" value="<?php echo esc_attr( $date ); ?>">
			</div>
		</div>
		<?php
	}

	/**
	 * Sauvegarde les meta boxes
	 */
	public function save_meta_boxes( $post_id ) {
		// Vérifications de sécurité
		if ( ! isset( $_POST['vitalisite_testimonial_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['vitalisite_testimonial_nonce'], 'vitalisite_save_testimonial' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Sauvegarde des champs
		if ( isset( $_POST['testimonial_comment'] ) ) {
			update_post_meta( $post_id, '_testimonial_comment', sanitize_textarea_field( $_POST['testimonial_comment'] ) );
		}

		if ( isset( $_POST['testimonial_rating'] ) ) {
			$rating = absint( $_POST['testimonial_rating'] );
			$rating = min( 5, max( 1, $rating ) ); // Entre 1 et 5
			update_post_meta( $post_id, '_testimonial_rating', $rating );
		}

		if ( isset( $_POST['testimonial_author_role'] ) ) {
			update_post_meta( $post_id, '_testimonial_author_role', sanitize_text_field( $_POST['testimonial_author_role'] ) );
		}

		if ( isset( $_POST['testimonial_date'] ) ) {
			update_post_meta( $post_id, '_testimonial_date', sanitize_text_field( $_POST['testimonial_date'] ) );
		}
	}

	/**
	 * Récupère les témoignages
	 */
	public static function get_testimonials( $args = array() ) {
		$defaults = array(
			'post_type'      => 'testimonials',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		$args = wp_parse_args( $args, $defaults );
		return get_posts( $args );
	}

	/**
	 * Génère les étoiles HTML
	 */
	public static function render_stars( $rating ) {
		$output = '<div class="vitalisite-stars" aria-label="' . sprintf( esc_attr__( 'Note: %d sur 5', 'vitalisite-fse' ), $rating ) . '">';
		
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( $i <= $rating ) {
				$output .= '<span class="star filled">★</span>';
			} else {
				$output .= '<span class="star empty">☆</span>';
			}
		}
		
		$output .= '</div>';
		return $output;
	}
}

// Initialiser
Vitalisite_CPT_Testimonials::get_instance();
