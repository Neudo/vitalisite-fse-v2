<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the `#content` element and all content thereafter.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package vitalisite
 */

?>

	</div><!-- #content -->
	<?php if (!is_404()) : ?>
		<?php get_template_part( 'template-parts/layout/footer', 'content' ); ?>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/components/sticky-mobile-cta' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
