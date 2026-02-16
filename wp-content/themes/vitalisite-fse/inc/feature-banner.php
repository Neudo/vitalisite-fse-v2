<?php
/**
 * Announcement Banner.
 *
 * Renders a dismissible banner at the top of the page
 * based on admin settings (Fonctionnalités tab).
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output the announcement banner before the header template part.
 */
function render_announcement_banner( $block_content, $block ) {
	if ( 'core/template-part' !== $block['blockName'] ) {
		return $block_content;
	}
	if ( empty( $block['attrs']['slug'] ) || 'header' !== $block['attrs']['slug'] ) {
		return $block_content;
	}

	$features = get_option( 'vitalisite_features', array() );

	if ( empty( $features['banner_enabled'] ) || empty( $features['banner_text'] ) ) {
		return $block_content;
	}

	$text        = esc_html( $features['banner_text'] );
	$style       = ! empty( $features['banner_style'] ) ? $features['banner_style'] : 'info';
	$dismissible = ! empty( $features['banner_dismissible'] );
	$link_text   = ! empty( $features['banner_link_text'] ) ? $features['banner_link_text'] : '';
	$link_url    = ! empty( $features['banner_link_url'] ) ? $features['banner_link_url'] : '';

	$style_class = 'vitalisite-banner--' . esc_attr( $style );
	$banner_hash = substr( md5( $features['banner_text'] ), 0, 8 );

	ob_start();
	?>
	<div class="vitalisite-banner <?php echo $style_class; ?><?php echo $dismissible ? ' vitalisite-banner--hidden' : ''; ?>" role="alert" id="vitalisite-banner" data-banner-hash="<?php echo esc_attr( $banner_hash ); ?>">
		<div class="vitalisite-banner__inner">
			<p class="vitalisite-banner__text">
				<?php echo $text; ?>
				<?php if ( $link_text && $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" class="vitalisite-banner__link"><?php echo esc_html( $link_text ); ?> →</a>
				<?php endif; ?>
			</p>
			<?php if ( $dismissible ) : ?>
				<button type="button" class="vitalisite-banner__close" aria-label="<?php esc_attr_e( 'Fermer', 'vitalisite-fse' ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>
			<?php endif; ?>
		</div>
	</div>
	<script>
	(function(){
		var b=document.getElementById('vitalisite-banner');
		if(!b)return;
		var h=b.getAttribute('data-banner-hash');
		var k='vitalisite_banner_dismissed_'+h;
		if(localStorage.getItem(k)==='1'){
			b.remove();return;
		}
		b.classList.remove('vitalisite-banner--hidden');
		var btn=b.querySelector('.vitalisite-banner__close');
		if(btn){
			btn.addEventListener('click',function(){
				localStorage.setItem(k,'1');
				b.remove();
			});
		}
	})();
	</script>
	<?php
	$banner = ob_get_clean();

	return $banner . $block_content;
}
add_filter( 'render_block', __NAMESPACE__ . '\render_announcement_banner', 10, 2 );
