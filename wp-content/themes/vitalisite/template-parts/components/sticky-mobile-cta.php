<?php
/**
 * Template part for displaying the sticky mobile CTA bar
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vitalisite
 */

// Get theme options for CTA bar
$cta_type = get_theme_mod('cta_type', 'appointment');


// Get custom values or fallback to theme defaults
switch ($cta_type) {
    case 'appointment':
        $custom_url = get_theme_mod('cta_appointment_url', '');
        $cta_url = !empty($custom_url) ? $custom_url : get_theme_mod('link_appointment', '');
        $cta_text = __('Prendre rendez-vous', 'vitalisite');
        $cta_link_type = 'url';
        break;

    case 'call':
        $custom_phone = get_theme_mod('cta_phone_number', '');
        $cta_url = !empty($custom_phone) ? $custom_phone : get_theme_mod('tel', '');
        $cta_text = __('Appeler', 'vitalisite');
        $cta_link_type = 'tel';
        break;

    default:
        $cta_url = '';
        $cta_text = '';
        $cta_link_type = 'url';
        break;
}

// Get custom button text based on CTA type
if ($cta_type === 'call') {
    $cta_text = get_theme_mod('cta_button_text_call', 'Appeler');
} else {
    $cta_text = get_theme_mod('cta_button_text_appointment', 'Prendre rendez-vous');
}

// Set icon automatically based on CTA type
$cta_icon = ($cta_type === 'call') ? 'phone' : 'calendar';
$cta_hide_on_desktop = get_theme_mod('cta_hide_on_desktop', true);

// Get button background color
$cta_bg_color = get_theme_mod('cta_button_bg_color', get_theme_mod('main_color', '#03045E'));

// Define icons SVG
$icons = [
    'calendar' => '<svg class="w-5 h-5 mr-2" fill="#ffffff" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>',
    'phone' => '<svg class="w-5 h-5 mr-2" fill="#ffffff" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>',
];

// Generate unique ID for this instance
$cta_id = 'sticky-mobile-cta-' . uniqid();

// Only show if we have a valid CTA URL
if (empty($cta_url) || $cta_hide_on_desktop) {
    return;
}
?>

<div class="sticky-mobile-cta-wrapper <?php echo $cta_hide_on_desktop ? 'md:hidden' : ''; ?>" id="<?php echo esc_attr($cta_id); ?>">
    <div class="sticky-mobile-cta fixed bottom-4 left-4 right-4 md:left-auto md:right-4 md:max-w-fit z-50 flex gap-2 shadow-lg rounded-xl" style="background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">

        <!-- Single CTA Button -->
        <a href="<?php echo $cta_link_type === 'tel' ? 'tel:' . esc_attr($cta_url) : esc_url($cta_url); ?>"
           class="cta-button flex-1 flex items-center justify-center py-3 px-4 font-semibold transition-colors duration-200 rounded-lg"
           style="background-color: <?php echo esc_attr($cta_bg_color); ?>; color: #ffffff;">
            <?php if (isset($icons[$cta_icon])) echo $icons[$cta_icon]; ?>
            <?php echo esc_html($cta_text); ?>
        </a>

    </div>
</div>
