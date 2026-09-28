<?php
/**
 * Plugin Name: Dentist Locator with Interactive Australia Map
 * Description: Accessible, AJAX-powered Australian dentist locator.
 * Version: 2.0.0
 * Author: Shajjadur Rahaman Shawon
 * Text Domain: dentist-locator
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */
defined( 'ABSPATH' ) || exit;

define( 'DL_VERSION', '2.0.0' );
define( 'DL_FILE', __FILE__ );
define( 'DL_PATH', plugin_dir_path( __FILE__ ) );
define( 'DL_URL', plugin_dir_url( __FILE__ ) );

require_once DL_PATH . 'includes/class-dl-plugin.php';
require_once DL_PATH . 'includes/class-dl-post-type.php';
require_once DL_PATH . 'includes/class-dl-settings.php';
require_once DL_PATH . 'includes/class-dl-search.php';

DL_Plugin::instance();
