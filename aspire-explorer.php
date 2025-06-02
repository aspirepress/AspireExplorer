<?php

/**
 * AspireExplorer - AspirePress Repository browser.
 *
 * @package     aspire-explorer
 * @author      AspireExplorer
 * @copyright   AspireExplorer
 * @license     GPLv2
 *
 * Plugin Name:       AspireExplorer
 * Plugin URI:        https://aspirepress.org/
 * Description:       AspirePress Repository browser.
 * Version:           0.1
 * Author:            AspirePress
 * Author URI:        https://docs.aspirepress.org/aspireexplorer/
 * Requires at least: 5.3
 * Requires PHP:      7.4
 * Tested up to:      6.7
 * License:           GPLv2
 * License URI:       https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 * Text Domain:       aspireexplorer
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/aspirepress/aspireexplorer
 * Primary Branch:    main
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! defined( 'AE_VERSION' ) ) {
	define( 'AE_VERSION', '0.1' );
}


add_action(
	'plugins_loaded',
	function () {
		if ( ! defined( 'AE_DIR_URL' ) ) {
			define( 'AE_DIR_URL', plugin_dir_url( __FILE__ ) );
		}
		if ( ! defined( 'AE_DIR_PATH' ) ) {
			define( 'AE_DIR_PATH', __DIR__ );
		}
		AspireExplorer\Controller\Main::get_instance();
	}
);

require_once __DIR__ . '/includes/autoload.php';

/**
 * Register activation/deactivation hooks.
 */
register_activation_hook( __FILE__, [ 'AspireExplorer\Controller\Main', 'on_activate' ] );
register_deactivation_hook( __FILE__, [ 'AspireExplorer\Controller\Main', 'on_deactivate' ] );
