<?php
/**
 * Helper functions for opening hours display
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Check if opening hours are configured
 */
function vitalisite_has_opening_hours() {
    $custom_hours_enabled = get_theme_mod( 'open_hours_enable', false );
    
    if ( $custom_hours_enabled ) {
        // Check if any day has hours configured
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ( $days as $day ) {
            $is_closed = get_theme_mod( "open_hours_{$day}_closed", false );
            if ( ! $is_closed ) {
                $open_time = get_theme_mod( "open_hours_{$day}_open", '' );
                $close_time = get_theme_mod( "open_hours_{$day}_close", '' );
                if ( ! empty( $open_time ) && ! empty( $close_time ) ) {
                    return true;
                }
            }
        }
        return false;
    } else {
        // Check legacy format
        $legacy_hours = get_theme_mod( 'open_hours', '' );
        return ! empty( $legacy_hours );
    }
}

/**
 * Get opening hours data
 */
function vitalisite_get_opening_hours() {
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    $hours = [];
    
    // Vérifier si les horaires personnalisés sont activés
    $custom_hours_enabled = get_theme_mod( 'open_hours_enable', false );
    
    if ( $custom_hours_enabled ) {
        // Utiliser les nouveaux champs personnalisés
        foreach ( $days as $day ) {
            $is_closed = get_theme_mod( "open_hours_{$day}_closed", false );
            
            if ( $is_closed ) {
                $hours[$day] = [
                    'closed' => true,
                    'open' => '',
                    'close' => ''
                ];
            } else {
                $hours[$day] = [
                    'closed' => false,
                    'open' => get_theme_mod( "open_hours_{$day}_open", '09:00' ),
                    'close' => get_theme_mod( "open_hours_{$day}_close", '18:00' )
                ];
            }
        }
    } else {
        // Utiliser l'ancien format pour compatibilité
        $legacy_hours = get_theme_mod( 'open_hours', '' );
        if ( ! empty( $legacy_hours ) ) {
            // Parser l'ancien format (ex: "Lundi - vendredi 9h00 - 18h00")
            foreach ( $days as $day ) {
                $hours[$day] = [
                    'closed' => true, // Par défaut fermé si legacy
                    'open' => '',
                    'close' => ''
                ];
            }
        }
    }
    
    return $hours;
}

/**
 * Check if currently open
 */
function vitalisite_is_open_now( $hours = null ) {
    if ( $hours === null ) {
        $hours = vitalisite_get_opening_hours();
    }
    
    $current_day = strtolower( date( 'l' ) );
    $current_time = date( 'H:i' );
    
    if ( ! isset( $hours[$current_day] ) || $hours[$current_day]['closed'] ) {
        return false;
    }
    
    $open_time = $hours[$current_day]['open'];
    $close_time = $hours[$current_day]['close'];
    
    if ( empty( $open_time ) || empty( $close_time ) ) {
        return false;
    }
    
    return $current_time >= $open_time && $current_time <= $close_time;
}

/**
 * Get day name in French
 */
function vitalisite_get_day_name_in_french( $day ) {
    $days = [
        'monday' => 'Lundi',
        'tuesday' => 'Mardi',
        'wednesday' => 'Mercredi',
        'thursday' => 'Jeudi',
        'friday' => 'Vendredi',
        'saturday' => 'Samedi',
        'sunday' => 'Dimanche'
    ];
    
    return isset( $days[$day] ) ? $days[$day] : $day;
}

/**
 * Get current day's hours for footer display
 */
function vitalisite_get_current_day_hours() {
    $hours = vitalisite_get_opening_hours();
    $current_day = strtolower( date( 'l' ) );
    
    if ( ! isset( $hours[$current_day] ) ) {
        return null;
    }
    
    $day_hours = $hours[$current_day];
    
    if ( $day_hours['closed'] ) {
        return 'Fermé aujourd\'hui';
    } else {
        $open_time = ! empty( $day_hours['open'] ) ? $day_hours['open'] : '09:00';
        $close_time = ! empty( $day_hours['close'] ) ? $day_hours['close'] : '18:00';
        return "Aujourd'hui: " . $open_time . ' - ' . $close_time;
    }
}

/**
 * Get next open day
 */
function vitalisite_get_next_open_day() {
    $hours = vitalisite_get_opening_hours();
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    $current_day_index = array_search( strtolower( date( 'l' ) ), $days );
    
    // Check remaining days this week
    for ( $i = $current_day_index + 1; $i < 7; $i++ ) {
        $day = $days[$i];
        if ( ! $hours[$day]['closed'] ) {
            return vitalisite_get_day_name_in_french( $day );
        }
    }
    
    // Check next week
    for ( $i = 0; $i <= $current_day_index; $i++ ) {
        $day = $days[$i];
        if ( ! $hours[$day]['closed'] ) {
            return vitalisite_get_day_name_in_french( $day );
        }
    }
    
    return null;
}
