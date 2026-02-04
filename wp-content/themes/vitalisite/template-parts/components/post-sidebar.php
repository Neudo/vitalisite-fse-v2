<?php
$main_color = get_theme_mod('main_color', '#051b2e');
$text_color = is_light_color($main_color) ? 'fill-slate-950' : 'fill-slate-100';
$is_archive_sidebar = get_query_var('is_archive_sidebar');

?>
<div class="<?= $is_archive_sidebar ? 'flex-col mb-8'  : 'sticky top-24 r-0 z-10 flex-col md:w-[400px] h-fit lg:ml-8' ?> flex  items-center justify-center p-4 rounded-3xl border-2 " style="color: <?= $text_color?>">
	<h1 class="rounded-xl p-4 w-full text-2xl mb-6 <?= is_light_color($main_color) ? 'text-slate-950' : 'text-slate-100' ?>" style="background-color:<?= $main_color?>"><?php echo esc_html('Catégories')?></h1>
	<?php
	$categories = get_categories();?>
	<div class="<?= $is_archive_sidebar ? 'flex flex-wrap gap-4 flex-row justify-start w-full' : 'flex flex-col w-full' ?>">
		<?php foreach ($categories as $category) {
			echo '<a class="text-slate-500 p-4 hover:bg-slate-100 rounded-xl transition-all duration-300 ease-in-out ' . (!$is_archive_sidebar ? 'w-full' : '') . '" href="'.get_category_link($category->term_id).'">'.$category->name.'</a>';
		}
		echo '</div>';
		?>

		<?php if (!$is_archive_sidebar) : ?>
		<h1 class="rounded-xl p-4 w-full text-2xl mb-6 mt-6 <?= is_light_color($main_color) ? 'text-slate-950' : 'text-slate-100' ?>" style="background-color:<?= $main_color?>"><?php echo esc_html('Derniers articles')?></h1>
		<?php
		$latest_posts = get_posts(array(
			'numberposts' => 3,
			'orderby' => 'date',
			'order' => 'DESC',

		));
		?>
		<div class="flex flex-col w-full">
			<?php
			foreach ($latest_posts as $post) {
				echo '<a class="text-slate-500 p-4 hover:bg-slate-100 rounded-xl transition-all duration-300 ease-in-out w-full" href="' . get_permalink($post->ID) . '">' . $post->post_title . '</a>';
			}
			?>
		</div>
		<?php endif; ?>
	</div>
