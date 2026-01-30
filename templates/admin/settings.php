<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
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
