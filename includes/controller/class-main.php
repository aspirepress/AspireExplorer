<?php
/**
 * Class Main
 *
 * The Main Workflow Controller for the Plugin.
 */

namespace AspireExplorer\Controller;

use PHPCSStandards\Composer\Plugin\Installers\PHPCodeSniffer\Plugin;

class Main extends \AspireExplorer\Model\Singleton {
	/**
	 * Constructor.
	 */
	protected function init() {
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
		Plugins::get_instance();
	}

	public function wp_enqueue_scripts() {
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style(
			'aspire-explorer-styles',
			AE_DIR_URL . 'assets/css/aspire-explorer.css',
			[],
			filemtime( AE_DIR_PATH . '/assets/css/aspire-explorer.css' )
		);
		wp_enqueue_script(
			'aspire-explorer-scripts',
			AE_DIR_URL . 'assets/js/aspire-explorer.js',
			[ 'jquery' ],
			filemtime( AE_DIR_PATH . '/assets/js/aspire-explorer.js' ),
			true
		);
	}

	/**
	 * Activate plugin: flush rewrite rules
	 */
	public static function on_activate() {
		Plugins::get_instance();
		flush_rewrite_rules();
	}

	/**
	 * Deactivate plugin: flush rewrite rules
	 */
	public static function on_deactivate() {
		flush_rewrite_rules();
	}
}
