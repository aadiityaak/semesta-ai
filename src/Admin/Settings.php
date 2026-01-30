<?php

namespace SemestaAi\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Settings {

    public function __construct() {
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
    }

    public function register_settings() {
        register_setting( 'semesta_ai_options_group', 'semesta_ai_google_api_key' );
    }

    public function add_admin_menu() {
        add_menu_page(
            'Semesta AI Settings',
            'Semesta AI',
            'manage_options',
            'semesta_ai',
            array( $this, 'options_page' ),
            'dashicons-superhero',
            100
        );
    }

    public function options_page() {
        include SEMESTA_AI_PATH . 'templates/admin/settings.php';
    }
}
