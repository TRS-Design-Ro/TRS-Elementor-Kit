<?php
/**
 * Scans the modules directory and registers (not enqueues) each module's CSS and JS.
 *
 * Individual widgets declare which assets they need via get_style_depends() and
 * get_script_depends(). Elementor then enqueues only those assets when the
 * widget is present on the page.
 *
 * @package TRS_Kit
 */

declare( strict_types=1 );

namespace TRS_Kit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Assets_Manager
 */
final class Assets_Manager {

	/**
	 * Walks the modules directory and registers CSS + JS for every module found.
	 */
	public function register_all(): void {
		if ( ! is_dir( TRS_KIT_MODULES_PATH ) ) {
			return;
		}

		$module_dirs = glob( TRS_KIT_MODULES_PATH . '*', GLOB_ONLYDIR );

		if ( empty( $module_dirs ) ) {
			return;
		}

		foreach ( $module_dirs as $module_dir ) {
			$this->register_module_assets( $module_dir );
		}
	}

	// -------------------------------------------------------------------------
	// Internal
	// -------------------------------------------------------------------------

	/**
	 * Registers the CSS and JS for a single module (if the files exist).
	 *
	 * @param string $module_dir Absolute path to the module folder.
	 */
	private function register_module_assets( string $module_dir ): void {
		$slug       = basename( $module_dir );
		$handle     = 'trs-' . $slug;
		$css_file   = $module_dir . '/' . $slug . '.css';
		$js_file    = $module_dir . '/' . $slug . '.js';
		$module_url = TRS_KIT_MODULES_URL . $slug . '/';

		if ( file_exists( $css_file ) ) {
			wp_register_style(
				$handle,
				$module_url . $slug . '.css',
				[],
				TRS_KIT_VERSION
			);
		}

		if ( file_exists( $js_file ) ) {
			wp_register_script(
				$handle,
				$module_url . $slug . '.js',
				[ 'jquery' ],
				TRS_KIT_VERSION,
				true
			);
		}
	}
}
