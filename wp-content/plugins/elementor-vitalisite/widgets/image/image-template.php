<?php
$unique_id = uniqid('image-');
?>
<div class="max-w-6xl mx-auto mt-8 lg:mt-16 rounded-3xl">
    <h2 class="reveal-title text-center mb-8 text-4xl lg:text-5xl font-bold">
        <?= !empty($settings['image_title']) ? esc_html($settings['image_title']) : 'Lorem ipsum dolor sit amet' ?>
    </h2>

    <div class="text-center mb-10 wysiwyg text-slate-500">
        <?= !empty($settings['image_description']) ? wp_kses_post($settings['image_description']) : '<p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>' ?>
    </div>

    <?php if (!empty($settings['image_url']['url'])) : ?>
        <div class="rounded-3xl overflow-hidden relative group reveal-y">
            <img src="<?= esc_url($settings['image_url']['url']); ?>" alt="<?= esc_attr($settings['image_title']); ?>" class="w-full duration-700 ease-in-out group-hover:scale-[1.06]" />
            <?php if (!empty($settings['cta_link']['url'])) : ?>
                <?php $cta_data = array(
                    'cta_text' => $settings['cta_text'],
                    'cta_link' => $settings['cta_link']['url'],
                    'class' => ':before-absolute :before-inset-0 z-20 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2',
                    'cta_target' => $settings['cta_link']['is_external'] === 'on' ? '_blank' : '_self',
                    'enable_download' => $settings['image_enable_download'] === 'yes',
                    'download_file' => $settings['image_download_file'],
                ); ?>
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                    <?php include get_template_directory() . '/template-parts/components/cta.php'; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>