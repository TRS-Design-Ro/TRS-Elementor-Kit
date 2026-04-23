<?php
/**
 * Plugin Name:       TRS Elementor Kit
 * Plugin URI:        https://trsdesign.co
 * Description:       A collection of custom Elementor widgets built for TRS websites.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            TRS Design
 * Author URI:        https://trsdesign.co
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       trs-kit
 * Domain Path:       /languages
 *
 * @package TRS_Kit
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TRS_KIT_VERSION', '1.0.0' );
define( 'TRS_KIT_FILE', __FILE__ );
define( 'TRS_KIT_PATH', plugin_dir_path( __FILE__ ) );
define( 'TRS_KIT_URL', plugin_dir_url( __FILE__ ) );
define( 'TRS_KIT_MODULES_PATH', TRS_KIT_PATH . 'modules/' );
define( 'TRS_KIT_MODULES_URL', TRS_KIT_URL . 'modules/' );
define( 'TRS_KIT_MIN_ELEMENTOR_VERSION', '3.10.0' );
define( 'TRS_KIT_MIN_PHP_VERSION', '7.4' );

/**
 * Load the plugin after all plugins are loaded, so we can check for Elementor.
 */
add_action( 'plugins_loaded', static function (): void {
	load_plugin_textdomain( 'trs-kit', false, dirname( plugin_basename( TRS_KIT_FILE ) ) . '/languages' );

	require_once TRS_KIT_PATH . 'includes/class-plugin.php';

	\TRS_Kit\Plugin::instance();
} );
