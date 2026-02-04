<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vitalisite
 */

$logo = get_theme_mod( 'header_logo' );
?>

<header id="masthead" class="content-1 bg-white <?= get_theme_mod('header_sticky') ? 'sticky top-0 z-50' : '' ?>">
	<nav id="site-navigation" class="flex items-center <?= get_theme_mod('link_appointment') !== '' ? 'justify-between':'justify-center'?> p-4 relative z-50 nav-desktop">
		<!-- Bouton Burger à cacher en desktop -->
		<button id="menu-toggle" class="focus:outline-none <?= get_theme_mod('link_appointment') !== '' ? '':'absolute'?>  top-6 left-4">
			<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
			</svg>
		</button>
		<!-- Logo -->
		<a class="header-logo" href="<?= esc_url(home_url('/')); ?>" >
			<?php
			if (!empty($logo['url'])) :
				?>
				<img src="<?= esc_url($logo['url']); ?>" alt="<?php bloginfo('name');?>" class="h-10">
			<?php else : ?>
				<img src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/logo-full.png" alt="<?php bloginfo('name'); ?>" class="h-10">
			<?php endif; ?>
		</a>
		<!-- Menu -->
		<div id="mobile-menu">
			<?php
			wp_nav_menu(array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
				'container'      => false,
				'walker'         => new Custom_Walker_Nav_Menu(),
			));
			?>
		</div>
		<!-- Doctolib Button -->
		<?php if (get_theme_mod('link_appointment') !== '')  :?>
			<a href="<?= get_theme_mod('link_appointment') ?>" target="_blank" class="book-button-mobile cta text-sm py-2 px-4 rounded-full flex items-center transition-all duration-300 ease-in-out">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
					<path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
					<path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
				</svg>
				<span id="book-button" class="ml-2 hidden md:block">Prendre rendez-vous</span>
			</a>
		<?php endif; ?>
	</nav>
</header>





