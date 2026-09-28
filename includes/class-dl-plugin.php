<?php
defined( 'ABSPATH' ) || exit;

final class DL_Plugin {
    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'init', array( 'DL_Post_Type', 'register' ) );
        add_action( 'admin_menu', array( 'DL_Settings', 'menu' ) );
        add_action( 'admin_init', array( 'DL_Settings', 'register' ) );
        add_shortcode( 'dentist_locator', array( $this, 'shortcode' ) );
        add_action( 'wp_ajax_dl_fetch_dentists', array( 'DL_Search', 'handle' ) );
        add_action( 'wp_ajax_nopriv_dl_fetch_dentists', array( 'DL_Search', 'handle' ) );
    }

    public function shortcode() {
        wp_enqueue_style( 'dentist-locator', DL_URL . 'assets/css/dentist-locator.css', array(), DL_VERSION );
        wp_enqueue_script( 'dentist-locator', DL_URL . 'assets/js/dentist-locator.js', array(), DL_VERSION, true );
        wp_localize_script(
            'dentist-locator',
            'dentistLocator',
            array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'dl_search' ),
                'i18n'    => array(
                    'loading' => __( 'Loading dentists…', 'dentist-locator' ),
                    'error'   => __( 'We could not load dentists. Please try again.', 'dentist-locator' ),
                ),
            )
        );

        ob_start();
        include DL_PATH . 'templates/locator.php';
        return ob_get_clean();
    }
}
