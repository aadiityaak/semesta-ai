<?php
/**
 * Plugin Name: Semesta AI
 * Description: Plugin WordPress Semesta AI dengan fitur Caption Generator, HPP Calculator, dan Template Konten.
 * Version: 1.0.0
 * Author: Semesta AI
 * Text Domain: semesta-ai
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define Constants
define( 'SEMESTA_AI_PATH', plugin_dir_path( __FILE__ ) );
define( 'SEMESTA_AI_URL', plugin_dir_url( __FILE__ ) );

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'SemestaAi\\';
    $base_dir = SEMESTA_AI_PATH . 'src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Initialize Plugin
function semesta_ai_init() {
    SemestaAi\Core\Plugin::get_instance();
}
add_action( 'plugins_loaded', 'semesta_ai_init' );
