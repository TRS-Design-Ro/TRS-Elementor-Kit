<?php
/**
 * Registers the TRS Kit widget category in the Elementor editor panel.
 *
 * @package TRS_Kit
 */

declare( strict_types=1 );

namespace TRS_Kit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Categories
 */
final class Categories {

	/**
	 * Adds the TRS Kit category to Elementor's widget panel.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager
	 */
	public function register( \Elementor\Elements_Manager $elements_manager ): void {
		$elements_manager->add_category(
			'trs-kit',
			[
				'title' => esc_html__( 'TRS Kit', 'trs-kit' ),
				'icon'  => 'eicon-plug',
			]
		);
	}
}
