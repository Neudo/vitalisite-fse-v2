<?php
$description = get_post_meta($post->ID, '_speciality_description', true);
$photo = get_post_meta($post->ID, '_speciality_photo', true);
$image_url = $photo ? wp_get_attachment_image_src($photo, 'square')[0] : '';
$alt_text = get_post_meta($photo, '_wp_attachment_image_alt', true) ?: 'Image de la spécialité';
?>

<div class="px-6 md:px-14">

	<?php if(!empty($image_url)): ?>
		<div class="max-w-2xl mx-auto mb-10">
			<img class="rounded-3xl" src="<?= esc_url($image_url)?>" alt="<?=$alt_text?>">
		</div>
	<?php endif;?>

	<?php if(!empty($description)): ?>
		<div class="wysiwyg desc">
			<?=wpautop(wp_kses_post($description))?>
		</div>
	<?php endif;?>
</div>
