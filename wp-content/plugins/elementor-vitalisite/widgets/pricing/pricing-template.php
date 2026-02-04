<?php
$unique_id = uniqid('pricing-');
$main_color = get_theme_mod('primary_cta_color', '#007CBA');
?>
<div class="max-w-6xl mx-auto mt-8 lg:mt-16">
    <?php if (!empty($settings['pricing_title'])) : ?>
        <h2 class="reveal-title text-center mb-8 text-4xl lg:text-5xl font-bold">
            <?= esc_html($settings['pricing_title']) ?>
        </h2>
    <?php endif; ?>

    <?php if (!empty($settings['pricing_description'])) : ?>
        <div class="text-center wysiwyg text-slate-500">
            <?= wp_kses_post($settings['pricing_description']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($settings['pricing_cards'])) : ?>
        <div class="flex flex-wrap justify-center gap-8 mb-12 mt-8 md:mt-12 max-w-6xl mx-auto">
            <?php foreach ($settings['pricing_cards'] as $card) : ?>
                <div class="pricing-card flex flex-col rounded-2xl p-8 text-center reveal-y relative overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 w-full lg:w-96 xl:w-80" style="border: 2px solid <?= !empty($card['card_border_color']) ? esc_attr($card['card_border_color']) : '#e5e7eb' ?>; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                    <div class="flex-1">
                    <!-- Header with title -->
                        <h3 class="text-2xl font-bold mb-8 md:mb-12 text-slate-900 leading-tight">
                            <?= esc_html($card['card_title']) ?>
                        </h3>
                    <!-- Description -->
                    <?php if (!empty($card['card_description'])) : ?>
                        <div class="text-slate-600 mb-6 md:mb-8 text-sm leading-relaxed min-h-[60px] text-left">
                            <?= wp_kses_post($card['card_description']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- CTA Button -->
                    <?php if (!empty($card['card_cta_text'])) : ?>
                        <div class="mb-6">
                            <?php
                            $cta_data = array(
                                'cta_text' => $card['card_cta_text'],
                                'cta_link' => $card['card_cta_url']['url'],
                                'cta_classes' => 'mx-auto',
                                'cta_target' => $card['card_cta_url']['is_external'] === 'on' ? '_blank' : '_self',
                                'enable_download' => $card['card_enable_download'] === 'yes',
                                'download_file' => $card['card_download_file'],
                            );
                            include get_template_directory() . '/template-parts/components/cta.php';
                            ?>
                        </div>
                    <?php endif; ?>
                    </div>

                    <!-- Price at bottom -->
                    <div class="pt-4 border-t border-slate-200">
                        <div class="text-3xl font-extrabold" style="color: <?= esc_attr($main_color) ?>">
                            <?= esc_html($card['card_price']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($settings['global_cta_text'])) : ?>
        <div class="w-fit mx-auto">
            <?php
            $cta_data = array(
                'cta_text' => $settings['global_cta_text'],
                'cta_link' => $settings['global_cta_url']['url'],
                'cta_classes' => 'px-12',
                'cta_type' => 'outline',
                'cta_target' => $settings['global_cta_url']['is_external'] === 'on' ? '_blank' : '_self',
                'enable_download' => $settings['global_enable_download'] === 'yes',
                'download_file' => $settings['global_download_file'],
            );
            include get_template_directory() . '/template-parts/components/cta.php';
            ?>
        </div>
    <?php endif; ?>
</div>
