<?php
/**
 * Template Name: Liste des liens
 *
 * @package WordPress
 * @subpackage Vitalisite
 * @since Vitalisite 1.0
 */

get_header();

$title = get_post_meta(get_the_ID(), '_title', true);
$description = get_post_meta(get_the_ID(), '_description', true);
$links = get_post_meta(get_the_ID(), '_my_links', true);
$photo_id = get_post_meta(get_the_ID(), '_photo', true);
$photo_url = $photo_id ? wp_get_attachment_image_url($photo_id, 'large') : null;
?>

<div id="content" class="site-content max-w-[400px] mx-auto py-12">
	<?php if ($photo_url) : ?>
		<div class="mb-8 w-[96px] h-[96px] mx-auto rounded-full overflow-hidden">
			<img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover">
		</div>
	<?php endif; ?>

	<?php if ($title) : ?>
		<h1 class="text-4xl font-bold text-center mb-4"><?php echo esc_html($title); ?></h1>
	<?php endif; ?>

	<?php if ($description) : ?>
		<div class="text-center text-slate-950 text-lg mb-8">
			<?php echo wpautop(esc_html($description)); ?>
		</div>
	<?php endif; ?>


	<?php if (!empty($links)) : ?>
		<ul class="w-full flex flex-wrap justify-center gap-4 mt-4 mb-16">
			<?php foreach ($links as $link) : ?>
				<li class="relative border border-black tracking-wide p-4 w-full uppercase text-center text-sm hover:bg-slate-100 hover:text-slate-950 hover:scale-[1.02] transition-transform duration-300 ease-in-out">
					<a href="<?php echo esc_url($link['href']); ?>" target="_blank" class="after:inset-0 after:absolute w-full h-full transition-all duration-300 ease-in-out hover:bg-slate-100 hover:text-slate-950" rel="noopener">
						<?php echo esc_html($link['label']); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>

