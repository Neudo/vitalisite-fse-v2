<?php
// Variables disponibles depuis opening-hours.php
// $settings = paramètres du widget
// $hours = tableau des horaires
// $is_open = booléen si ouvert maintenant
// $current_day = jour actuel (ex: 'monday')
?>

<div class="opening-hours-widget max-w-6xl mx-auto mt-8 lg:mt-16 bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
    <?php if ( ! empty( $settings['opening_hours_title'] ) ): ?>
        <h3 class="opening-hours-title text-2xl font-bold text-gray-800 mb-6 text-center">
            <?php echo esc_html( $settings['opening_hours_title'] ); ?>
        </h3>
    <?php endif; ?>

    <?php if ( $settings['show_open_now_indicator'] === 'yes' ): ?>
        <div class="open-now-indicator mb-6 text-center">
                <?php if ( ! empty( $settings['emergency_text'] ) ): ?>
                    <div class="emergency-info mt-4 p-4 rounded-lg border" 
                         style="border-color: <?php 
                             $primary_color = get_theme_mod('primary_cta_color', '#007CBA');
                             echo esc_attr($primary_color); 
                         ?>; background-color: <?php 
                             // Utiliser une version très claire de la couleur primaire
                             $primary_color = get_theme_mod('primary_cta_color', '#007CBA');
                             // Convertir hex en RGB manuellement
                             $hex = str_replace('#', '', $primary_color);
                             if (strlen($hex) == 3) {
                                 $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                                 $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                                 $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                             } else {
                                 $r = hexdec(substr($hex,0,2));
                                 $g = hexdec(substr($hex,2,2));
                                 $b = hexdec(substr($hex,4,2));
                             }
                             echo 'rgba(' . $r . ', ' . $g . ', ' . $b . ', 0.1)'; 
                         ?>;">
                        <p class="text-sm flex items-center" style="color: <?php 
                            $primary_color = get_theme_mod('primary_cta_color', '#007CBA');
                            echo esc_attr($primary_color); 
                        ?>;">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo esc_html( $settings['emergency_text'] ); ?>
                        </p>
                    </div>
                <?php endif; ?>         
        </div>
    <?php endif; ?>

    <div class="opening-hours-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <?php foreach ( $hours as $day => $day_hours ): 
            $day_name = $this->get_day_name_in_french( $day );
            $is_current_day = $day === $current_day;
        ?>
            <div class="opening-hours-day p-4 rounded-lg border transition-all duration-300 <?php echo $is_current_day ? 'shadow-md' : 'border-gray-200 hover:border-gray-300'; ?>"
                 style="<?php if ( $is_current_day ) { 
                     $primary_color = get_theme_mod('primary_cta_color', '#007CBA');
                     echo 'border-color: ' . esc_attr($primary_color) . ';';
                     echo 'box-shadow: 0 0 0 2px ' . esc_attr($primary_color) . ';';
                 } ?>">
                <div class="opening-hours-day-name font-semibold text-gray-800 mb-2">
                    <?php echo esc_html( $day_name ); ?>
                    <?php if ( $is_current_day ): ?>
                        <span class="ml-2 text-xs px-2 py-1 rounded-full text-white font-medium" 
                              style="background-color: <?php 
                                  $primary_color = get_theme_mod('primary_cta_color', '#007CBA');
                                  echo esc_attr($primary_color); 
                              ?>; color: <?php 
                                  $text_color = get_theme_mod('primary_cta_text_color', '#FFFFFF');
                                  echo esc_attr($text_color); 
                              ?>;">
                            <?php esc_html_e( 'Aujourd\'hui', 'elementor-addon' ); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="opening-hours-time font-semibold">
                    <?php if ( $day_hours['closed'] ): ?>
                        <span class="flex items-center text-gray-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"/>
                            </svg>
                            <?php esc_html_e( 'Fermé', 'elementor-addon' ); ?>
                        </span>
                    <?php else: ?>
                        <?php 
                        $open_time = ! empty( $day_hours['open'] ) ? $day_hours['open'] : '09:00';
                        $close_time = ! empty( $day_hours['close'] ) ? $day_hours['close'] : '18:00';
                        ?>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo esc_html( $open_time ) . ' - ' . esc_html( $close_time ); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ( $settings['show_phone_button'] === 'yes' || $settings['show_appointment_button'] === 'yes' ): ?>
        <div class="opening-hours-actions flex flex-col md:flex-row justify-center mt-8 gap-2">
            <?php if ( $settings['show_phone_button'] === 'yes' && $is_open ): ?>
                <?php 
                $phone = get_theme_mod( 'tel', '' );
                if ( ! empty( $phone ) ): 
                    $primary_color = get_theme_mod('primary_cta_color', '#007CBA');
                    $primary_hover = get_theme_mod('primary_cta_hover_color', '#03486A');
                    $text_color = get_theme_mod('primary_cta_text_color', '#FFFFFF');
                ?>
                <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" 
                   class="phone-button group flex items-center justify-center w-full max-w-[300px] mx-auto md:mx-0 px-6 py-3 rounded-xl font-semibold shadow-md transform transition-all duration-300 hover:scale-101 hover:shadow-md"
                   style="background-color: <?php echo esc_attr($primary_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span><?php esc_html_e( 'Appeler', 'elementor-addon' ); ?></span>
                </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ( $settings['show_appointment_button'] === 'yes' ): ?>
                <?php 
                $appointment_url = get_theme_mod( 'link_appointment', '' );
                if ( ! empty( $appointment_url ) ): 
                    $primary_color = get_theme_mod('primary_cta_color', '#007CBA');
                    $primary_hover = get_theme_mod('primary_cta_hover_color', '#03486A');
                    $text_color = get_theme_mod('primary_cta_text_color', '#FFFFFF');
                ?>
                <a href="<?php echo esc_url( $appointment_url ); ?>" 
                   target="_blank"
                   class="appointment-button group flex items-center justify-center w-full max-w-[300px] mx-auto md:mx-0 px-6 py-3 rounded-xl font-semibold shadow-md transform transition-all duration-300 hover:scale-103 hover:shadow-md"
                   style="background-color: <?php echo esc_attr($primary_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span><?php esc_html_e( 'Prendre rendez-vous', 'elementor-addon' ); ?></span>
                </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
