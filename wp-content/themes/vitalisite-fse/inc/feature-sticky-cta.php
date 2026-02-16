<?php
/**
 * Sticky Mobile CTA Bar.
 *
 * Renders a fixed bottom bar on mobile with appointment
 * and optional phone buttons. Shows after scroll.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output the sticky CTA bar via wp_footer.
 */
function render_sticky_cta() {
	if ( is_admin() ) {
		return;
	}

	$features = get_option( 'vitalisite_features', array() );

	if ( empty( $features['cta_enabled'] ) ) {
		return;
	}

	$cabinet = get_option( 'vitalisite_cabinet', array() );

	$cta_text  = ! empty( $features['cta_text'] ) ? $features['cta_text'] : __( 'Prendre rendez-vous', 'vitalisite-fse' );
	$cta_url   = ! empty( $features['cta_url'] ) ? $features['cta_url'] : ( ! empty( $cabinet['appointment_url'] ) ? $cabinet['appointment_url'] : '' );
	$show_phone = ! empty( $features['cta_phone'] );
	$phone      = ! empty( $cabinet['phone'] ) ? $cabinet['phone'] : '';

	if ( ! $cta_url && ! ( $show_phone && $phone ) ) {
		return;
	}

	$phone_href = $phone ? preg_replace( '/[^0-9+]/', '', $phone ) : '';
	?>
	<div class="vitalisite-sticky-cta" id="vitalisite-sticky-cta" aria-hidden="true">
		<div class="vitalisite-sticky-cta__inner">
			<?php if ( $show_phone && $phone_href ) : ?>
				<a href="tel:<?php echo esc_attr( $phone_href ); ?>" class="vitalisite-sticky-cta__btn vitalisite-sticky-cta__btn--phone" aria-label="<?php esc_attr_e( 'Appeler', 'vitalisite-fse' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
				</a>
			<?php endif; ?>
			<?php if ( $cta_url ) : ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="vitalisite-sticky-cta__btn vitalisite-sticky-cta__btn--primary" target="_blank" rel="noopener noreferrer">
					<?php echo esc_html( $cta_text ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<script>
	(function(){
		var cta = document.getElementById('vitalisite-sticky-cta');
		if (!cta) return;
		var threshold = 200;
		var visible = false;
		function toggle() {
			var show = window.scrollY > threshold;
			if (show !== visible) {
				visible = show;
				cta.classList.toggle('is-visible', show);
				cta.setAttribute('aria-hidden', show ? 'false' : 'true');
			}
		}
		window.addEventListener('scroll', toggle, {passive: true});
		toggle();
	})();
	</script>
	<?php
}
add_action( 'wp_footer', __NAMESPACE__ . '\render_sticky_cta' );
