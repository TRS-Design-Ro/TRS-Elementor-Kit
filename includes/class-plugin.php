<?php
/**
 * Main plugin class — bootstraps all sub-systems.
 *
 * @package TRS_Kit
 */

declare( strict_types=1 );

namespace TRS_Kit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Plugin
 *
 * Singleton entry-point. Validates requirements, then wires up the kit.
 */
final class Plugin {

	/** @var Plugin|null */
	private static ?Plugin $instance = null;

	/** @var Modules_Manager */
	public Modules_Manager $modules_manager;

	/** @var Assets_Manager */
	public Assets_Manager $assets_manager;

	/**
	 * Returns the single instance, creating it on first call.
	 */
	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Private constructor — use Plugin::instance().
	 */
	private function __construct() {
		if ( ! $this->check_requirements() ) {
			return;
		}

		$this->load_includes();
		$this->init_hooks();
	}

	// -------------------------------------------------------------------------
	// Requirements
	// -------------------------------------------------------------------------

	/**
	 * Checks PHP version and that Elementor is active and at the minimum version.
	 */
	private function check_requirements(): bool {
		if ( version_compare( PHP_VERSION, TRS_KIT_MIN_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'notice_php_version' ] );
			return false;
		}

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'notice_elementor_missing' ] );
			return false;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, TRS_KIT_MIN_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'notice_elementor_version' ] );
			return false;
		}

		return true;
	}

	// -------------------------------------------------------------------------
	// Bootstrapping
	// -------------------------------------------------------------------------

	/**
	 * Requires all include files.
	 */
	private function load_includes(): void {
		require_once TRS_KIT_PATH . 'includes/class-categories.php';
		require_once TRS_KIT_PATH . 'includes/class-assets-manager.php';
		require_once TRS_KIT_PATH . 'includes/class-modules-manager.php';
	}

	/**
	 * Registers all WordPress / Elementor hooks.
	 */
	private function init_hooks(): void {
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'register_assets' ] );
	}

	// -------------------------------------------------------------------------
	// Elementor callbacks
	// -------------------------------------------------------------------------

	/**
	 * Registers the TRS Kit widget category in the Elementor panel.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager
	 */
	public function register_categories( \Elementor\Elements_Manager $elements_manager ): void {
		( new Categories() )->register( $elements_manager );
	}

	/**
	 * Discovers and registers all widget classes via Modules_Manager.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 */
	public function register_widgets( \Elementor\Widgets_Manager $widgets_manager ): void {
		$this->modules_manager = new Modules_Manager( $widgets_manager );
	}

	/**
	 * Registers (but does not enqueue) all module CSS and JS assets.
	 * Elementor handles on-demand enqueuing via get_style_depends() / get_script_depends().
	 */
	public function register_assets(): void {
		$this->assets_manager = new Assets_Manager();
		$this->assets_manager->register_all();
	}

	// -------------------------------------------------------------------------
	// Admin notices
	// -------------------------------------------------------------------------

	/** @internal */
	public function notice_php_version(): void {
		$this->render_notice(
			sprintf(
				/* translators: 1: minimum PHP version, 2: current PHP version */
				esc_html__( 'TRS Elementor Kit requires PHP %1$s or higher. Your server is running PHP %2$s.', 'trs-kit' ),
				TRS_KIT_MIN_PHP_VERSION,
				PHP_VERSION
			)
		);
	}

	/** @internal */
	public function notice_elementor_missing(): void {
		$this->render_notice(
			esc_html__( 'TRS Elementor Kit requires Elementor to be installed and activated.', 'trs-kit' )
		);
	}

	/** @internal */
	public function notice_elementor_version(): void {
		$this->render_notice(
			sprintf(
				/* translators: minimum Elementor version required */
				esc_html__( 'TRS Elementor Kit requires Elementor %s or higher. Please update Elementor.', 'trs-kit' ),
				TRS_KIT_MIN_ELEMENTOR_VERSION
			)
		);
	}

	/**
	 * Outputs a styled admin error notice.
	 */
	private function render_notice( string $message ): void {
		printf(
			'<div class="notice notice-error"><p><strong>%s</strong> %s</p></div>',
			esc_html__( 'TRS Elementor Kit:', 'trs-kit' ),
			$message // Already escaped by caller.
		);
	}
}
