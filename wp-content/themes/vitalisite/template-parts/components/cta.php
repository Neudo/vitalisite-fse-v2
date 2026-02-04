<?php
$main_color = get_theme_mod('primary_cta_color', '#007CBA');
$main_hover_color = get_theme_mod('primary_cta_hover_color', '#03486A');
$main_text_color = get_theme_mod('primary_cta_text_color', '#FFFFFF');

$cta_text = isset($cta_data['cta_text']) ? $cta_data['cta_text'] : '';
$cta_link = isset($cta_data['cta_link']) ? $cta_data['cta_link'] : '';
$target = isset($cta_data['cta_target']) ? $cta_data['cta_target'] : '';
$cta_classes = isset($cta_data['cta_classes']) ? $cta_data['cta_classes'] : '';
$cta_type = isset($cta_data['cta_type']) ? $cta_data['cta_type'] : 'solid';
$enable_download = isset($cta_data['enable_download']) ? $cta_data['enable_download'] : false;
$download_file = isset($cta_data['download_file']) ? $cta_data['download_file'] : [];

// Handle download links
if ($enable_download && !empty($download_file['url'])) {
    $cta_link = $download_file['url'];
    $target = '_blank';
    $download_attr = ' download="' . basename($download_file['url']) . '"';
} else {
    $download_attr = '';
}

// Render different CTA types based on cta_type
if ($cta_type === 'outline') {
    ?>
    <div class="cta-outline border-2 px-8 py-2 text-sm rounded-xl relative ease-in duration-300 w-fit <?= $cta_classes ?>" style="border-color: <?= esc_attr($main_color) ?>;">
        <a class="leading-9 after:inset-0 after:absolute transition-colors duration-300 hover:text-white" style="color: <?= esc_attr($main_color) ?>;" target="<?= esc_attr($target); ?>" href="<?= esc_url($cta_link); ?>"<?= $download_attr ?>><?= esc_html($cta_text); ?></a>
    </div>
    <style>
        .cta-outline:hover {
            background-color: <?= esc_attr($main_color) ?>;
        }
        .cta-outline:hover a {
            color: <?= esc_attr($main_text_color) ?> !important;
        }
    </style>
    <?php
} else {
    // Default solid CTA
    ?>
    <div class="cta px-8 py-2 text-sm rounded-xl relative ease-in duration-300 w-fit <?= $cta_classes ?>" style="background-color: <?= esc_attr($main_color) ?>;">
        <a class="leading-9 after:inset-0 after:absolute" style="color:<?=$main_text_color?>" target="<?= esc_attr($target); ?>" href="<?= esc_url($cta_link); ?>"<?= $download_attr ?>><?= esc_html($cta_text); ?></a>
    </div>
    <?php
}
?>

