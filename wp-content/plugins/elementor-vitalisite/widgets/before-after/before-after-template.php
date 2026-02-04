<?php
$unique_id = uniqid('before-after-');
$enable_carousel = $settings['enable_carousel'] === 'yes';
?>

<div class="vitalisite-before-after-wrapper" id="<?= esc_attr($unique_id) ?>">
    
    <?php if (!empty($settings['widget_title'])) : ?>
        <h2 class="widget-title text-3xl font-bold mb-4 text-center">
            <?= esc_html($settings['widget_title']) ?>
        </h2>
    <?php endif; ?>
    
    <?php if (!empty($settings['widget_description'])) : ?>
        <div class="widget-description text-lg text-gray-600 mb-8 text-center max-w-3xl mx-auto">
            <?= wp_kses_post($settings['widget_description']) ?>
        </div>
    <?php endif; ?>
    
    <?php if ($enable_carousel && !empty($settings['comparisons'])) : ?>
        <div class="swiper vitalisite-before-after-swiper" 
             id="swiper-<?= esc_attr($unique_id) ?>"
             data-autoplay="<?= esc_attr($settings['autoplay']) ?>">
            <div class="swiper-wrapper">
                <?php foreach ($settings['comparisons'] as $index => $item) : ?>
                    <div class="swiper-slide">
                        <?php if (!empty($item['comparison_title'])) : ?>
                            <h3 class="comparison-title text-2xl font-bold mb-4 text-center">
                                <?= esc_html($item['comparison_title']) ?>
                            </h3>
                        <?php endif; ?>
                        
                        <div class="before-after-container grid grid-cols-1 md:grid-cols-2 gap-4 mx-0">
                            <div class="before-image-wrapper relative overflow-hidden max-w-full md:max-w-[40vw]">
                                <img src="<?= esc_url($item['before_image_carousel']['url']) ?>" 
                                     alt="<?= esc_attr($settings['before_label']) ?>" 
                                     class="rounded-3xl-important w-fit h-auto object-contain max-h-[400px] mx-auto">
                                <?php if ($settings['show_labels'] === 'yes') : ?>
                                    <span class="image-label absolute top-5 left-5 bg-black/70 text-white px-3 py-1 rounded-lg text-sm">
                                        <?= esc_html($settings['before_label']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="after-image-wrapper relative overflow-hidden max-w-full md:max-w-[40vw]">
                                <img src="<?= esc_url($item['after_image_carousel']['url']) ?>" 
                                     alt="<?= esc_attr($settings['after_label']) ?>" 
                                     class="rounded-3xl-important w-fit h-auto object-contain max-h-[400px] mx-auto">
                                <?php if ($settings['show_labels'] === 'yes') : ?>
                                    <span class="image-label absolute top-4 left-4 bg-black/70 text-white px-3 py-1 rounded text-sm">
                                        <?= esc_html($settings['after_label']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
        
    <?php else : ?>
        <div class="before-after-container grid grid-cols-1 md:grid-cols-2 gap-4 mx-0">
            <div class="before-image-wrapper relative overflow-hidden max-w-full md:max-w-[40vw]">
                <img src="<?= esc_url($settings['before_image']['url']) ?>" 
                     alt="<?= esc_attr($settings['before_label']) ?>" 
                     class="rounded-3xl-important w-fit h-auto object-contain max-h-[400px] mx-auto">
                <?php if ($settings['show_labels'] === 'yes') : ?>
                    <span class="image-label absolute top-5 left-5 bg-black/70 text-white px-3 py-1 rounded-2xl text-sm">
                        <?= esc_html($settings['before_label']) ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="after-image-wrapper relative overflow-hidden max-w-full md:max-w-[40vw]">
                <img src="<?= esc_url($settings['after_image']['url']) ?>" 
                     alt="<?= esc_attr($settings['after_label']) ?>" 
                     class="rounded-3xl-important w-fit h-auto object-contain max-h-[400px] mx-auto">
                <?php if ($settings['show_labels'] === 'yes') : ?>
                    <span class="image-label absolute top-5 right-5 bg-black/70 text-white px-3 py-1 rounded-2xl text-sm">
                        <?= esc_html($settings['after_label']) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($settings['show_disclaimer'] === 'yes') : ?>
        <p class="before-after-disclaimer text-sm text-gray-500 mt-4 text-center italic">
            <?= esc_html($settings['disclaimer_text']) ?>
        </p>
    <?php endif; ?>
    
</div>
