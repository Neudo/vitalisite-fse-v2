<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some functionality here could be replaced by core features.
 *
 * @package vitalisite
 */

if ( ! function_exists( 'vitalisite_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function vitalisite_posted_on() {
		$time_string = '<time datetime="%1$s">%2$s</time>';
		$primary_color = get_theme_mod( 'main_color', '#007cba' );

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

echo '<div class="flex gap-2 items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6" style="color: ' . $primary_color . ';">
  <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
</svg>
',
		sprintf(
			'%2$s',
			esc_url( get_permalink() ),
			$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
echo '</div>';
	}


endif;

if ( ! function_exists( 'vitalisite_display_google_reviews_summary' ) ) :
	/**
	 * Affiche un résumé des avis Google (note globale et nombre d'avis)
	 */
	function vitalisite_display_google_reviews_summary() {
		$reviews_data = vitalisite_get_google_reviews();
		
		if ( empty( $reviews_data ) || empty( $reviews_data['rating'] ) ) {
			return;
		}
		
		$rating = $reviews_data['rating'];
		$total_reviews = $reviews_data['user_ratings_total'] ?? 0;
		$name = $reviews_data['name'] ?? '';
		
		echo '<div class="google-reviews-summary flex items-center gap-3">';
		echo '<div class="stars">' . vitalisite_format_rating( $rating ) . '</div>';
		echo '<div class="rating-info">';
		echo '<span class="font-bold">' . esc_html( number_format( $rating, 1 ) ) . '</span>';
		if ( $total_reviews > 0 ) {
			echo '<span class="text-sm text-gray-600 ml-1">(' . esc_html( $total_reviews ) . ')</span>';
		}
		if ( $name ) {
			echo '<span class="text-sm text-gray-600 ml-2">' . esc_html( $name ) . '</span>';
		}
		echo '</div>';
		echo '</div>';
	}
endif;

if ( ! function_exists( 'vitalisite_display_google_reviews_badge' ) ) :
	/**
	 * Affiche un badge simple avec la note Google
	 */
	function vitalisite_display_google_reviews_badge() {
		$reviews_data = vitalisite_get_google_reviews();
		
		if ( empty( $reviews_data ) || empty( $reviews_data['rating'] ) ) {
			return;
		}
		
		$rating = $reviews_data['rating'];
		$total_reviews = $reviews_data['user_ratings_total'] ?? 0;
		
		echo '<div class="google-reviews-badge inline-flex items-center gap-2 bg-gray-100 px-3 py-2 rounded-full">';
		echo '<div class="stars">' . vitalisite_format_rating( $rating ) . '</div>';
		echo '<span class="font-semibold text-sm">' . esc_html( number_format( $rating, 1 ) ) . '</span>';
		echo '<span class="text-xs text-gray-600">Google</span>';
		if ( $total_reviews > 0 ) {
			echo '<span class="text-xs text-gray-500">(' . esc_html( $total_reviews ) . ')</span>';
		}
		echo '</div>';
	}
endif;

if ( ! function_exists( 'vitalisite_setup_google_reviews_cron' ) ) :
	/**
	 * Configure le cron job pour rafraîchir les avis automatiquement
	 */
	function vitalisite_setup_google_reviews_cron() {
		// Ajouter le cron job s'il n'existe pas
		if ( ! wp_next_scheduled( 'vitalisite_refresh_google_reviews' ) ) {
			$duration = get_theme_mod( 'google_reviews_cache_duration', 24 );
			wp_schedule_event( time(), $duration . '_hours', 'vitalisite_refresh_google_reviews' );
		}
	}
	add_action( 'wp', 'vitalisite_setup_google_reviews_cron' );
endif;

if ( ! function_exists( 'vitalisite_refresh_google_reviews_cron' ) ) :
	/**
	 * Fonction exécutée par le cron pour rafraîchir les avis
	 */
	function vitalisite_refresh_google_reviews_cron() {
		// Forcer le rafraîchissement du cache
		vitalisite_clear_google_reviews_cache();
		vitalisite_get_google_reviews();
	}
	add_action( 'vitalisite_refresh_google_reviews', 'vitalisite_refresh_google_reviews_cron' );
endif;

if ( ! function_exists( 'vitalisite_google_reviews_shortcode' ) ) :
	/**
	 * Shortcode pour afficher les avis Google
	 * [google_reviews count="5" show_title="yes" layout="grid"]
	 */
	function vitalisite_google_reviews_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'count' => 5,
			'show_title' => 'yes',
			'layout' => 'grid',
			'columns' => 3,
		), $atts, 'google_reviews' );
		
		$reviews_data = vitalisite_get_google_reviews();
		
		if ( empty( $reviews_data ) || empty( $reviews_data['reviews'] ) ) {
			return '<p>' . __( 'Aucun avis disponible', 'vitalisite' ) . '</p>';
		}
		
		$reviews = array_slice( $reviews_data['reviews'], 0, intval( $atts['count'] ) );
		$output = '';
		
		// Container
		$output .= '<div class="google-reviews-shortcode google-reviews-' . esc_attr( $atts['layout'] ) . '">';
		
		// Header
		if ( $atts['show_title'] === 'yes' ) {
			$output .= '<div class="reviews-header text-center mb-6">';
			$output .= '<h3 class="text-2xl font-bold mb-3">' . __( 'Nos avis Google', 'vitalisite' ) . '</h3>';
			$output .= '<div class="flex items-center justify-center gap-3">';
			$output .= '<div class="stars">' . vitalisite_format_rating( $reviews_data['rating'] ) . '</div>';
			$output .= '<span class="font-bold">' . esc_html( number_format( $reviews_data['rating'], 1 ) ) . '</span>';
			$output .= '<span class="text-gray-600">(' . esc_html( $reviews_data['user_ratings_total'] ) . ' avis)</span>';
			$output .= '</div>';
			$output .= '</div>';
		}
		
		// Reviews grid
		$grid_class = $atts['layout'] === 'grid' ? 'grid grid-cols-1 md:grid-cols-' . intval( $atts['columns'] ) . ' gap-6' : 'space-y-4';
		$output .= '<div class="' . esc_attr( $grid_class ) . '">';
		
		foreach ( $reviews as $review ) {
			$output .= '<div class="review-card bg-white p-6 rounded-lg shadow-md">';
			$output .= '<div class="flex items-start gap-3 mb-3">';
			if ( ! empty( $review['profile_photo_url'] ) ) {
				$output .= '<img src="' . esc_url( $review['profile_photo_url'] ) . '" alt="' . esc_attr( $review['author_name'] ) . '" class="w-10 h-10 rounded-full">';
			}
			$output .= '<div class="flex-1">';
			$output .= '<div class="font-semibold">' . esc_html( $review['author_name'] ) . '</div>';
			$output .= '<div class="stars">' . vitalisite_format_rating( $review['rating'] ) . '</div>';
			if ( ! empty( $review['relative_time_description'] ) ) {
				$output .= '<div class="text-sm text-gray-500">' . esc_html( $review['relative_time_description'] ) . '</div>';
			}
			$output .= '</div>';
			$output .= '</div>';
			if ( ! empty( $review['text'] ) ) {
				$output .= '<p class="text-gray-700">' . esc_html( substr( $review['text'], 0, 200 ) ) . ( strlen( $review['text'] ) > 200 ? '...' : '' ) . '</p>';
			}
			$output .= '</div>';
		}
		
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'google_reviews', 'vitalisite_google_reviews_shortcode' );
endif;

if ( ! function_exists( 'vitalisite_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function vitalisite_posted_by() {
		printf(
		/* translators: 1: posted by label, only visible to screen readers. 2: author link. 3: post author. */
			'<span class="sr-only">%1$s</span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span>',
			esc_html__( 'Posted by', 'vitalisite' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'vitalisite_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function vitalisite_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="sr-only"> on %s</span>', 'vitalisite' ), get_the_title() ) );
		}
	}
endif;

if ( ! function_exists( 'vitalisite_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 * This template tag is used in the entry header.
	 */
	function vitalisite_entry_meta() {
		$primary_color = get_theme_mod( 'main_color', '#007cba' );

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Posted by.
//			vitalisite_posted_by();

			// Posted on.
			vitalisite_posted_on();

			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( __( ', ', 'vitalisite' ) );
			if ( $categories_list ) {
				echo '<div class="flex flex-wrap items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6" style="color: ' . $primary_color . ';">
  						<path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" />
					  </svg>',
				sprintf(
				/* translators: 1: posted in label, only visible to screen readers. 2: list of categories. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Posted in', 'vitalisite' ),
					$categories_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
				echo '</div>';
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'vitalisite' ) );
			if ( $tags_list ) {
				sprintf(
				/* translators: 1: tags label, only visible to screen readers. 2: list of tags. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Tags:', 'vitalisite' ),
					$tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
		}

		// Comment count.
//		if ( ! is_singular() ) {
//			vitalisite_comment_count();
//		}

		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="sr-only">%s</span>', 'vitalisite' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
	}
endif;

if ( ! function_exists( 'vitalisite_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function vitalisite_entry_footer() {
		$primary_color = get_theme_mod( 'main_color', '#007cba' );

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Posted by.
//			vitalisite_posted_by();

			// Posted on.
			vitalisite_posted_on();

			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( __( ', ', 'vitalisite' ) );
			if ( $categories_list ) {
				echo '<div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6" style="color: ' . $primary_color . ';">
  						<path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" />
					  </svg>',
				printf(
				/* translators: 1: posted in label, only visible to screen readers. 2: list of categories. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Posted in', 'vitalisite' ),
					$categories_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
				echo '</div>';
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'vitalisite' ) );
			if ( $tags_list ) {
				printf(
				/* translators: 1: tags label, only visible to screen readers. 2: list of tags. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Tags:', 'vitalisite' ),
					$tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
		}

		// Comment count.
//		if ( ! is_singular() ) {
//			vitalisite_comment_count();
//		}

		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="sr-only">%s</span>', 'vitalisite' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
	}
endif;

if ( ! function_exists( 'vitalisite_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail, wrapping the post thumbnail in an
	 * anchor element except when viewing a single post.
	 */
	function vitalisite_post_thumbnail() {
		if ( ! vitalisite_can_show_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<figure class="rounded-3xl overflow-hidden w-full max-w-[400px] mx-auto">
				<?php the_post_thumbnail('post_thumbnail'); ?>
			</figure><!-- .post-thumbnail -->

		<?php
		else :
			?>

			<figure class="rounded-3xl overflow-hidden w-full max-w-[400px] mx-auto">
				<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail('post_thumbnail', array(
						'class' => 'object-cover h-full'
					)); ?>
				</a>
			</figure>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'vitalisite_comment_avatar' ) ) :
	/**
	 * Returns the HTML markup to generate a user avatar.
	 *
	 * @param mixed $id_or_email The Gravatar to retrieve. Accepts a user_id, gravatar md5 hash,
	 *                           user email, WP_User object, WP_Post object, or WP_Comment object.
	 */
	function vitalisite_get_user_avatar_markup( $id_or_email = null ) {

		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}

		return sprintf( '<div class="vcard">%s</div>', get_avatar( $id_or_email, vitalisite_get_avatar_size() ) );
	}
endif;

if ( ! function_exists( 'vitalisite_discussion_avatars_list' ) ) :
	/**
	 * Displays a list of avatars involved in a discussion for a given post.
	 *
	 * @param array $comment_authors Comment authors to list as avatars.
	 */
	function vitalisite_discussion_avatars_list( $comment_authors ) {
		if ( empty( $comment_authors ) ) {
			return;
		}
		echo '<ol>', "\n";
		foreach ( $comment_authors as $id_or_email ) {
			printf(
				"<li>%s</li>\n",
				vitalisite_get_user_avatar_markup( $id_or_email ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		echo '</ol>', "\n";
	}
endif;

if ( ! function_exists( 'vitalisite_the_posts_navigation' ) ) :
	/**
	 * Wraps `the_posts_pagination` for use throughout the theme.
	 */
	function vitalisite_the_posts_navigation() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => __( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
</svg>
', 'vitalisite' ),
				'next_text' => __( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M16.72 7.72a.75.75 0 0 1 1.06 0l3.75 3.75a.75.75 0 0 1 0 1.06l-3.75 3.75a.75.75 0 1 1-1.06-1.06l2.47-2.47H3a.75.75 0 0 1 0-1.5h16.19l-2.47-2.47a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
</svg>
', 'vitalisite' ),
			)
		);
	}
endif;

if ( ! function_exists( 'vitalisite_content_class' ) ) :
	/**
	 * Displays the class names for the post content wrapper.
	 *
	 * This allows us to add Tailwind Typography’s modifier classes throughout
	 * the theme without repeating them in multiple files. (They can be edited
	 * at the top of the `../functions.php` file via the
	 * VITALISITE_TYPOGRAPHY_CLASSES constant.)
	 *
	 * Based on WordPress core’s `body_class` and `get_body_class` functions.
	 *
	 * @param string|string[] $classes Space-separated string or array of class
	 *                                 names to add to the class list.
	 */
	function vitalisite_content_class( $classes = '' ) {
		$all_classes = array( $classes, VITALISITE_TYPOGRAPHY_CLASSES );

		foreach ( $all_classes as &$class_groups ) {
			if ( ! empty( $class_groups ) ) {
				if ( ! is_array( $class_groups ) ) {
					$class_groups = preg_split( '#\s+#', $class_groups );
				}
			} else {
				// Ensure that we always coerce class to being an array.
				$class_groups = array();
			}
		}

		$combined_classes = array_merge( $all_classes[0], $all_classes[1] );
		$combined_classes = array_map( 'esc_attr', $combined_classes );

		// Separates class names with a single space, preparing them for the
		// post content wrapper.
		echo 'class="' . esc_attr( implode( ' ', $combined_classes ) ) . '"';
	}
endif;
