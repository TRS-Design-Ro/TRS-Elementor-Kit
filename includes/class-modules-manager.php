<?php
/**
 * Discovers and registers all widget modules inside the /modules directory.
 *
 * Convention: each module lives in modules/module-name/ and contains a
 * widget file named widget-module-name.php that defines a class
 * TRS_Kit\Modules\TRS_Widget_Module_Name extending \Elementor\Widget_Base.
 *
 * @package TRS_Kit
 */

declare( strict_types=1 );

namespace TRS_Kit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Modules_Manager
 */
final class Modules_Manager {

	/** @var \Elementor\Widgets_Manager */
	private \Elementor\Widgets_Manager $widgets_manager;

	/**
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 */
	public function __construct( \Elementor\Widgets_Manager $widgets_manager ) {
		$this->widgets_manager = $widgets_manager;
		$this->load_modules();
	}

	// -------------------------------------------------------------------------
	// Discovery
	// -------------------------------------------------------------------------

	/**
	 * Scans the modules directory, loads each widget file, and registers the widget.
	 */
	private function load_modules(): void {
		if ( ! is_dir( TRS_KIT_MODULES_PATH ) ) {
			return;
		}

		$module_dirs = glob( TRS_KIT_MODULES_PATH . '*', GLOB_ONLYDIR );

		if ( empty( $module_dirs ) ) {
			return;
		}

		foreach ( $module_dirs as $module_dir ) {
			$this->load_module( $module_dir );
		}
	}

	/**
	 * Loads a single module by directory path and registers its widget.
	 *
	 * @param string $module_dir Absolute path to the module folder.
	 */
	private function load_module( string $module_dir ): void {
		$module_slug   = basename( $module_dir );
		$widget_file   = $module_dir . '/widget-' . $module_slug . '.php';
		$class_name    = $this->slug_to_class_name( $module_slug );

		if ( ! file_exists( $widget_file ) ) {
			return;
		}

		require_once $widget_file;

		if ( ! class_exists( $class_name ) ) {
			return;
		}

		$this->widgets_manager->register( new $class_name() );
	}

	// -------------------------------------------------------------------------
	// Helpers
	// -------------------------------------------------------------------------

	/**
	 * Converts a hyphenated module slug to its fully-qualified widget class name.
	 *
	 * Example: 'hero-banner' → 'TRS_Kit\Modules\TRS_Widget_Hero_Banner'
	 *
	 * @param string $slug Module folder name.
	 * @return string Fully-qualified class name.
	 */
	private function slug_to_class_name( string $slug ): string {
		$pascal = implode( '_', array_map( 'ucfirst', explode( '-', $slug ) ) );
		return 'TRS_Kit\\Modules\\TRS_Widget_' . $pascal;
	}
}
