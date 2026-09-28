<?php
defined( 'ABSPATH' ) || exit;

final class DL_Settings {
    public static function menu() {
        add_submenu_page(
            'edit.php?post_type=dentist',
            __( 'Locator Settings', 'dentist-locator' ),
            __( 'Locator Settings', 'dentist-locator' ),
            'manage_options',
            'dentist-locator-settings',
            array( __CLASS__, 'page' )
        );
    }

    public static function register() {
        register_setting( 'dl_settings', 'dma_no_results_title', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        register_setting( 'dl_settings', 'dma_no_results_text', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
        register_setting( 'dl_settings', 'dma_contact_phone', array( 'sanitize_callback' => array( __CLASS__, 'sanitize_phone' ) ) );
        register_setting( 'dl_settings', 'dma_contact_email', array( 'sanitize_callback' => 'sanitize_email' ) );
    }

    public static function sanitize_phone( $value ) {
        return preg_replace( '/[^0-9+() .-]/', '', (string) $value );
    }

    public static function page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Dentist Locator Settings', 'dentist-locator' ); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'dl_settings' ); ?>
                <table class="form-table" role="presentation">
                    <tr><th scope="row"><label for="dl-title"><?php esc_html_e( 'No Results Title', 'dentist-locator' ); ?></label></th>
                    <td><input id="dl-title" class="regular-text" name="dma_no_results_title" value="<?php echo esc_attr( get_option( 'dma_no_results_title', __( 'No dentists matched your search', 'dentist-locator' ) ) ); ?>"></td></tr>
                    <tr><th scope="row"><label for="dl-text"><?php esc_html_e( 'Instructional Text', 'dentist-locator' ); ?></label></th>
                    <td><textarea id="dl-text" class="large-text" rows="3" name="dma_no_results_text"><?php echo esc_textarea( get_option( 'dma_no_results_text', __( 'Revise your search or contact us directly.', 'dentist-locator' ) ) ); ?></textarea></td></tr>
                    <tr><th scope="row"><label for="dl-phone"><?php esc_html_e( 'Contact Phone', 'dentist-locator' ); ?></label></th>
                    <td><input id="dl-phone" class="regular-text" name="dma_contact_phone" value="<?php echo esc_attr( get_option( 'dma_contact_phone', '' ) ); ?>"></td></tr>
                    <tr><th scope="row"><label for="dl-email"><?php esc_html_e( 'Contact Email', 'dentist-locator' ); ?></label></th>
                    <td><input id="dl-email" type="email" class="regular-text" name="dma_contact_email" value="<?php echo esc_attr( get_option( 'dma_contact_email', '' ) ); ?>"></td></tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
