<?php

namespace SemestaAi\Core;

if (! defined('ABSPATH')) {
  exit;
}

class Plugin
{

  private static $instance = null;

  public static function get_instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  private function __construct()
  {
    $this->init_hooks();
    $this->includes();
  }

  private function includes()
  {
    // Classes are autoloaded, but we need to instantiate them to hook into WordPress
    new \SemestaAi\Admin\Settings();
    new \SemestaAi\Api\GoogleAiController();
    new \SemestaAi\Frontend\Shortcode();
    new \SemestaAi\Core\PostTypes();
  }

  private function init_hooks()
  {
    add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
  }

  public function enqueue_scripts()
  {
    // Tailwind CSS
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com', array(), '3.0', false);

    // Alpine.js
    wp_enqueue_script('alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', array(), '3.0', true);

    // HTML2Canvas & JSPDF (For HPP Export)
    wp_enqueue_script('html2canvas', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js', array(), '1.4.1', true);
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', array(), '2.5.1', true);

    // Custom CSS
    wp_enqueue_style('semesta-ai-style', SEMESTA_AI_URL . 'assets/css/style.css', array(), '1.0.0');
  }
}
