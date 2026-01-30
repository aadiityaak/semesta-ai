<?php

namespace SemestaAi\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shortcode {

    public function __construct() {
        add_shortcode( 'semesta_caption', array( $this, 'caption_shortcode' ) );
        add_shortcode( 'semesta_hpp', array( $this, 'hpp_shortcode' ) );
        add_shortcode( 'semesta_template', array( $this, 'template_shortcode' ) );
    }

    public function caption_shortcode() {
        ob_start();
        include SEMESTA_AI_PATH . 'templates/frontend/caption-generator.php';
        return ob_get_clean();
    }

    public function hpp_shortcode() {
        ob_start();
        include SEMESTA_AI_PATH . 'templates/frontend/hpp-calculator.php';
        return ob_get_clean();
    }

    public function template_shortcode() {
        ob_start();
        include SEMESTA_AI_PATH . 'templates/frontend/template-content.php';
        return ob_get_clean();
    }
}
