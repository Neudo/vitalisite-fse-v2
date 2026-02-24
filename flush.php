<?php
require_once __DIR__ . '/wp-load.php';

// Clear theme JSON cache
\WP_Theme_JSON_Resolver::clean_cached_data();

// Clear options and transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_theme_json%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_theme_json%'");

echo "Caches cleaned successfully\n";
