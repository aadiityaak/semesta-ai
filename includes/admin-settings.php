<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Settings
function semesta_ai_register_settings() {
    register_setting( 'semesta_ai_options_group', 'semesta_ai_google_api_key' );
}
add_action( 'admin_init', 'semesta_ai_register_settings' );

// Add Menu Page
function semesta_ai_add_admin_menu() {
    add_menu_page(
        'Semesta AI Settings',
        'Semesta AI',
        'manage_options',
        'semesta_ai',
        'semesta_ai_options_page',
        'dashicons-superhero',
        100
    );
}
add_action( 'admin_menu', 'semesta_ai_add_admin_menu' );

// Options Page Content
function semesta_ai_options_page() {
    ?>
    <div class="wrap">
        <h1>Semesta AI Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'semesta_ai_options_group' ); ?>
            <?php do_settings_sections( 'semesta_ai_options_group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Google AI Studio API Key</th>
                    <td>
                        <input type="password" name="semesta_ai_google_api_key" value="<?php echo esc_attr( get_option( 'semesta_ai_google_api_key' ) ); ?>" class="regular-text" />
                        <p class="description">Masukkan API Key dari Google AI Studio (Gemini API).</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
