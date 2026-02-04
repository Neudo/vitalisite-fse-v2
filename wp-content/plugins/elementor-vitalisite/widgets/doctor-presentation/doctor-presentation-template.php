<?php
$unique_id = uniqid('doctor-presentation-');
$main_color = get_theme_mod('main_color', '#051b2e');
$has_bg = $settings['has_bg'];
$title_color = is_light_color($main_color) ? 'text-slate-950' : 'text-slate-100';
$text_color  = is_light_color($main_color) ? 'text-slate-800' : 'text-slate-200';
?>
<div class="max-w-3xl mx-auto mt-8 lg:mt-16 rounded-3xl <?= $has_bg === 'yes' ? 'p-8 lg:p-16' : '' ?> text-center" <?= $has_bg === 'yes' ? 'style="background-color:' . esc_attr($main_color) . '"' : '' ?>>
    <div class="flex flex-col items-center gap-6">
        <?php if ( ! empty( $settings['doctor_image']['url'] ) ) : ?>
            <div class="size-36 md:size-48 rounded-full overflow-hidden border-4" style="border-color: <?= esc_attr( $main_color ); ?>">
                <img src="<?= esc_url( $settings['doctor_image']['url'] ); ?>" alt="<?= esc_attr( $settings['doctor_name'] ); ?>" class="object-cover w-full h-full" />
            </div>
        <?php endif; ?>
        <h3 class="text-3xl font-extrabold <?= $has_bg === 'yes' ? esc_attr( $title_color ) : 'text-slate-950' ?>">
            <?= ! empty( $settings['doctor_name'] ) ? esc_html( $settings['doctor_name'] ) : 'Dr. Lorem Ipsum' ?>
        </h3>
        <div class="wysiwyg <?= $has_bg === 'yes' && ! is_light_color( $main_color ) ? 'dark' : '' ?> <?= $has_bg === 'yes' ? esc_attr( $text_color ) : 'text-slate-500' ?>">
            <?= ! empty( $settings['doctor_description'] ) ? wp_kses_post( $settings['doctor_description'] ) : '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>' ?>
        </div>
        <?php if ( ! empty( $settings['cta_link']['url'] ) && ! empty( $settings['cta_text'] ) ) : ?>
            <?php
            $cta_data = array(
                'cta_text'   => $settings['cta_text'],
                'cta_link'   => $settings['cta_link']['url'],
                'cta_classes' => 'mt-6',
                'cta_target' => $settings['cta_link']['is_external'] === 'on' ? '_blank' : '_self',
                'enable_download' => $settings['doctor_enable_download'] === 'yes',
                'download_file' => $settings['doctor_download_file'],
            );
            include get_template_directory() . '/template-parts/components/cta.php';
            ?>
        <?php endif; ?>
    </div>
</div>
