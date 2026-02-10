<?php
/**
 * Server-side rendering for the video block.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vitalisite_render_video_block( $attributes ) {
	$video_type   = ! empty( $attributes['videoType'] ) ? $attributes['videoType'] : 'youtube';
	$youtube_url  = ! empty( $attributes['youtubeUrl'] ) ? $attributes['youtubeUrl'] : '';
	$video_url    = ! empty( $attributes['videoUrl'] ) ? $attributes['videoUrl'] : '';
	$poster_url   = ! empty( $attributes['posterUrl'] ) ? $attributes['posterUrl'] : '';
	$aspect_ratio = ! empty( $attributes['aspectRatio'] ) ? $attributes['aspectRatio'] : '16/9';

	$has_video = ( 'youtube' === $video_type && $youtube_url ) || ( 'upload' === $video_type && $video_url );

	if ( ! $has_video ) {
		return '<div class="vitalisite-video-placeholder"><p>' . esc_html__( 'Aucune vidéo configurée.', 'vitalisite-fse' ) . '</p></div>';
	}

	ob_start();
	?>
	<div class="vitalisite-video-player" style="aspect-ratio: <?php echo esc_attr( $aspect_ratio ); ?>;">
		<?php if ( 'youtube' === $video_type ) :
			$embed_id = vitalisite_extract_youtube_id( $youtube_url );
			if ( $embed_id ) :
		?>
			<iframe
				src="https://www.youtube.com/embed/<?php echo esc_attr( $embed_id ); ?>?rel=0"
				frameborder="0"
				allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
				allowfullscreen
				loading="lazy"
				title="<?php esc_attr_e( 'Vidéo', 'vitalisite-fse' ); ?>"
			></iframe>
		<?php else : ?>
			<p class="vitalisite-video-error"><?php esc_html_e( 'URL YouTube invalide.', 'vitalisite-fse' ); ?></p>
		<?php endif; ?>
		<?php else : ?>
			<video controls preload="metadata"<?php echo $poster_url ? ' poster="' . esc_url( $poster_url ) . '"' : ''; ?>>
				<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
				<?php esc_html_e( 'Votre navigateur ne supporte pas la lecture vidéo.', 'vitalisite-fse' ); ?>
			</video>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Extract YouTube video ID from various URL formats.
 */
function vitalisite_extract_youtube_id( $url ) {
	$patterns = array(
		'/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
		'/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
	);

	foreach ( $patterns as $pattern ) {
		if ( preg_match( $pattern, $url, $matches ) ) {
			return $matches[1];
		}
	}

	return '';
}
