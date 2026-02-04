<?php
$unique_id = uniqid('slider-');
$bg_color = get_theme_mod('main_color');
$has_bg = $settings['has_bg'];
?>

<div class="max-w-5xl mx-auto mt-14 md:mt-24 lg:max-w-6xl <?= $has_bg === 'yes' ? 'rounded-3xl p-4 lg:p-14 bg-slate-100': '' ?> ">
<h2 class="reveal-title text-center text-4xl lg:text-5xl font-bold mb-4 lg:mb-8"><?= !empty($settings['slider_title']) ? $settings['slider_title'] : 'Lorem ipsum dolor sit amet' ?></h2>
<div class="text-center text-slate-500 mb-8 lg:mb-16">
    <?= !empty($settings['slider_description']) ? $settings['slider_description'] : '<p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>' ?>
</div>
<div id="<?= esc_attr($unique_id)?>" class="swiper-section swiper">
    <div class="swiper-wrapper">
        <?php
        $settings = $this->get_settings_for_display();
        $slider_items = $settings['list'];
        foreach ($slider_items as $item) {
            $title = $item['list_title'];
            $subtitle = $item['list_content'];
            $image = $item['list_image'];
            $link = $item['list_link'];
            $color = $item['list_color'];
            ?>
            <div class="swiper-slide relative overflow-hidden shadow-md h-[400px] md:h-[490px] rounded-3xl flex justify-end flex-col">
                <?php if($image['url'] != '') : ?>
                    <div class="wrapper h-full">
                        <img src="<?= esc_url($image['url']) ?>" alt="<?= esc_attr($title) ?>" class="w-full h-full object-cover">
                    </div>
                <?php else : ?>
                    <div class="w-full h-full" style="background-color:<?= $color?>"></div>
                <?php endif; ?>
                <div class="p-8 bg-white w-full">
                    <h3 class="mb-4 font-bold text-2xl">
                        <?php if($link['url'] != '') : ?>
                            <?php
                            $download_attr = '';
                            if ($item['list_enable_download'] === 'yes' && !empty($item['list_download_file']['url'])) {
                                $download_attr = ' download="' . basename($item['list_download_file']['url']) . '"';
                            }
                            ?>
                            <a class="before:absolute before:inset-0" href="<?= $download_attr ? esc_url($item['list_download_file']['url']) : esc_url($link['url']) ?>" target="<?= $link['is_external'] ? '_blank' : '_self' ?>" rel="<?= $link['nofollow'] ? 'nofollow' : '' ?>"<?= $download_attr ?>>
                                <?= !empty($title) ? $title : 'Lorem ipsum' ?>
                            </a>
                        <?php else : ?>
                            <?= !empty($title) ? $title : 'Lorem ipsum' ?>
                        <?php endif; ?>
                    </h3>
                    <?= !empty($subtitle) ? esc_html(wp_trim_words($subtitle, 15, ' [...]')) : 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip [...]' ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="swiper-navigation flex gap-4 mt-8">
        <div class="button-prev p-4 rounded-full w-fit" style="background-color:<?= get_theme_mod('main_color') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 <?= is_light_color($bg_color) ? 'text-slate-950' : 'text-slate-200' ?>">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </div>
        <div class="button-next p-4 rounded-full w-fit" style="background-color:<?= get_theme_mod('main_color') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 <?= is_light_color($bg_color) ? 'text-slate-950' : 'text-slate-200' ?>">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>

        </div>
    </div>

    <?php if (!empty($settings['website_link']['url'])) : ?>
        <div class="flex justify-center mt-8">
            <?php
            $cta_data = array(
                'cta_text' => __('En savoir plus', 'elementor-vitalisite'),
                'cta_link' => $settings['website_link']['url'],
                'cta_classes' => '',
                'cta_target' => $settings['website_link']['is_external'] === 'on' ? '_blank' : '_self',
                'enable_download' => $settings['slider_enable_download'] === 'yes',
                'download_file' => $settings['slider_download_file'],
            );
            include get_template_directory() . '/template-parts/components/cta.php';
            ?>
        </div>
    <?php endif; ?>

</div>