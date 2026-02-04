<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vitalisite
 */

?>

<header id="masthead">
	<div>
		<nav id="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'vitalisite' ); ?>">
			<button aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'vitalisite' ); ?></button>

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'items_wrap'     => '<ul id="%1$s" class="%2$s" aria-label="submenu">%3$s</ul>',
				)
			);
			?>
		</nav><!-- #site-navigation -->
</header><!-- #masthead -->
<h1>Header numéro 2</h1>
