<?php

/**
 * Plugin Name: Semesta AI
 * Description: Plugin WordPress Semesta AI dengan fitur Caption Generator, HPP Calculator, dan Template Konten.
 * Version: 1.0.0
 * Author: Aditya Kristyanto
 * Author URI: https://websweetstudio.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: semesta-ai
 */

if (! defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

// Define Constants
define('SEMESTA_AI_PATH', plugin_dir_path(__FILE__));
define('SEMESTA_AI_URL', plugin_dir_url(__FILE__));

// Include Files
require_once SEMESTA_AI_PATH . 'includes/admin-settings.php';
require_once SEMESTA_AI_PATH . 'includes/api-handler.php';
require_once SEMESTA_AI_PATH . 'includes/shortcodes.php';

// Enqueue Scripts and Styles
function semesta_ai_enqueue_scripts()
{
  // Tailwind CSS (CDN for simplicity in this MVP)
  wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com', array(), '3.0', false);

  // Alpine.js
  wp_enqueue_script('alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', array(), '3.0', true);

  // HTML2Canvas & JSPDF (For HPP Export)
  wp_enqueue_script('html2canvas', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js', array(), '1.4.1', true);
  wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', array(), '2.5.1', true);

  // Custom JS
  wp_enqueue_script('semesta-ai-app', SEMESTA_AI_URL . 'assets/js/app.js', array('alpine-js', 'jquery'), '1.0.0', true);

  // Pass data to JS (Nonce and API URL)
  wp_localize_script('semesta-ai-app', 'semestaAiData', array(
    'nonce' => wp_create_nonce('wp_rest'),
    'apiUrl' => get_rest_url(null, 'semesta-ai/v1/generate')
  ));

  // Custom CSS
  wp_enqueue_style('semesta-ai-style', SEMESTA_AI_URL . 'assets/css/style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'semesta_ai_enqueue_scripts');
