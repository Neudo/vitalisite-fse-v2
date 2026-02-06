<?php
/**
 * Plugin Name: Vitalisite Blocks
 * Description: Blocs Gutenberg et fonctionnalités pour le thème Vitalisite.
 * Version: 0.1.0
 * Author: Quentin
 * Text Domain: vitalisite-blocks
 */

if (!defined('ABSPATH')) {
  exit;
}

add_action('init', function () {
    register_block_type(__DIR__ . '/build/cta');
});
