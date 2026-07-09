<?php
/**
 * Slideshow widget.
 *
 * A full-bleed hero slideshow. Each slide has its own background image with
 * an optional overlay, plus a title, description, and a CTA button with an
 * editable icon. Slides are navigated with a set of segmented "line" style
 * indicators (in place of classic dots/chevrons), with optional arrow
 * buttons, autoplay, keyboard, and swipe support.
 *
 * @package TRS_Kit
 */

declare( strict_types=1 );

namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TRS_Widget_Slideshow
 */
class TRS_Widget_Slideshow extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'trs-slideshow';
	}

	public function get_title(): string {
		return esc_html__( 'Slideshow', 'trs-kit' );
	}

	public function get_icon(): string {
		return 'eicon-slides';
	}

	public function get_categories(): array {
		return [ 'trs-kit' ];
	}

	public function get_style_depends(): array {
		return [ 'trs-slideshow' ];
	}

	public function get_script_depends(): array {
		return [ 'trs-slideshow' ];
	}

	// -------------------------------------------------------------------------
	// Controls
	// -------------------------------------------------------------------------

	protected function register_controls(): void {
		$this->register_content_slides_controls();
		$this->register_content_layout_controls();
		$this->register_content_navigation_controls();

		$this->register_style_container_controls();
		$this->register_style_overlay_controls();
		$this->register_style_title_controls();
		$this->register_style_description_controls();
		$this->register_style_button_controls();
		$this->register_style_nav_lines_controls();
		$this->register_style_arrows_controls();
	}

	// ── Content: Slides ──────────────────────────────────────────────────────

	private function register_content_slides_controls(): void {
		$this->start_controls_section( 'section_slides', [
			'label' => esc_html__( 'Slides', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'background_image', [
			'label'   => esc_html__( 'Background Image', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$repeater->add_control( 'background_image_alt', [
			'label'       => esc_html__( 'Image Alt Text', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'placeholder' => esc_html__( 'Describe the image', 'trs-kit' ),
		] );

		$repeater->add_control( 'use_custom_overlay', [
			'label'        => esc_html__( 'Custom Overlay for this Slide', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => '',
			'description'  => esc_html__( 'Override the default overlay (set under Style → Overlay) for this slide only.', 'trs-kit' ),
		] );

		$repeater->add_control( 'overlay_color', [
			'label'     => esc_html__( 'Overlay Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(0, 0, 0, 0.35)',
			'condition' => [ 'use_custom_overlay' => 'yes' ],
		] );

		$repeater->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => esc_html__( 'Elegant Interiors, Timeless Comfort', 'trs-kit' ),
			'placeholder' => esc_html__( 'Enter a title', 'trs-kit' ),
		] );

		$repeater->add_control( 'description', [
			'label'       => esc_html__( 'Description', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'default'     => esc_html__( 'Discover pieces crafted with care, designed to bring warmth and character to every room.', 'trs-kit' ),
			'placeholder' => esc_html__( 'Enter a short description', 'trs-kit' ),
		] );

		$repeater->add_control( 'button_text', [
			'label'       => esc_html__( 'Button Text', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Discover', 'trs-kit' ),
			'placeholder' => esc_html__( 'Button label', 'trs-kit' ),
		] );

		$repeater->add_control( 'button_link', [
			'label'       => esc_html__( 'Button Link', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'trs-kit' ),
			'default'     => [ 'url' => '#' ],
		] );

		$repeater->add_control( 'button_icon', [
			'label'   => esc_html__( 'Button Icon', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => [
				'value'   => 'fas fa-arrow-right',
				'library' => 'fa-solid',
			],
		] );

		$this->add_control( 'slides', [
			'label'       => esc_html__( 'Slides', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'title'       => esc_html__( 'Elegant Interiors, Timeless Comfort', 'trs-kit' ),
					'description' => esc_html__( 'Discover pieces crafted with care, designed to bring warmth and character to every room.', 'trs-kit' ),
					'button_text' => esc_html__( 'Discover', 'trs-kit' ),
					'button_link' => [ 'url' => '#' ],
					'button_icon' => [ 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Crafted Details, Lasting Quality', 'trs-kit' ),
					'description' => esc_html__( 'Every piece is finished by hand, built to stay beautiful for years to come.', 'trs-kit' ),
					'button_text' => esc_html__( 'Discover', 'trs-kit' ),
					'button_link' => [ 'url' => '#' ],
					'button_icon' => [ 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Modern Living, Refined Spaces', 'trs-kit' ),
					'description' => esc_html__( 'Furniture and decor that adapt to the way you actually live.', 'trs-kit' ),
					'button_text' => esc_html__( 'Discover', 'trs-kit' ),
					'button_link' => [ 'url' => '#' ],
					'button_icon' => [ 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ],
				],
			],
		] );

		$this->end_controls_section();
	}

	// ── Content: Layout ──────────────────────────────────────────────────────

	private function register_content_layout_controls(): void {
		$this->start_controls_section( 'section_layout', [
			'label' => esc_html__( 'Layout', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_responsive_control( 'slide_height', [
			'label'          => esc_html__( 'Slideshow Height', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', 'vh' ],
			'range'          => [
				'px' => [ 'min' => 300, 'max' => 1000 ],
				'vh' => [ 'min' => 20, 'max' => 100 ],
			],
			'default'        => [ 'size' => 680, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 560, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 520, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-slideshow' => '--trs-ss-height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'content_h_align', [
			'label'        => esc_html__( 'Horizontal Alignment', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::CHOOSE,
			'options'      => [
				'left'   => [ 'title' => esc_html__( 'Left', 'trs-kit' ), 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => esc_html__( 'Center', 'trs-kit' ), 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => esc_html__( 'Right', 'trs-kit' ), 'icon' => 'eicon-text-align-right' ],
			],
			'default'      => 'left',
			'prefix_class' => 'trs-ss-align-',
		] );

		$this->add_control( 'content_v_align', [
			'label'        => esc_html__( 'Vertical Alignment', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::CHOOSE,
			'options'      => [
				'top'    => [ 'title' => esc_html__( 'Top', 'trs-kit' ), 'icon' => 'eicon-v-align-top' ],
				'middle' => [ 'title' => esc_html__( 'Middle', 'trs-kit' ), 'icon' => 'eicon-v-align-middle' ],
				'bottom' => [ 'title' => esc_html__( 'Bottom', 'trs-kit' ), 'icon' => 'eicon-v-align-bottom' ],
			],
			'default'      => 'bottom',
			'prefix_class' => 'trs-ss-valign-',
		] );

		$this->add_responsive_control( 'content_max_width', [
			'label'          => esc_html__( 'Content Max Width', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', '%' ],
			'range'          => [
				'px' => [ 'min' => 200, 'max' => 900 ],
				'%'  => [ 'min' => 20, 'max' => 100 ],
			],
			'default'        => [ 'size' => 605, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 480, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 100, 'unit' => '%' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-slideshow' => '--trs-ss-content-w: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'content_padding', [
			'label'          => esc_html__( 'Content Padding', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'     => [ 'px', '%' ],
			'default'        => [ 'top' => '64', 'right' => '64', 'bottom' => '64', 'left' => '64', 'unit' => 'px' ],
			'tablet_default' => [ 'top' => '48', 'right' => '40', 'bottom' => '48', 'left' => '40', 'unit' => 'px' ],
			'mobile_default' => [ 'top' => '32', 'right' => '24', 'bottom' => '32', 'left' => '24', 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-slideshow' => '--trs-ss-pad-top: {{TOP}}{{UNIT}}; --trs-ss-pad-right: {{RIGHT}}{{UNIT}}; --trs-ss-pad-bottom: {{BOTTOM}}{{UNIT}}; --trs-ss-pad-left: {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'content_gap', [
			'label'      => esc_html__( 'Gap Between Elements', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-slideshow' => '--trs-ss-gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'background_position', [
			'label'     => esc_html__( 'Image Position', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'options'   => [
				'center center' => esc_html__( 'Center Center', 'trs-kit' ),
				'center top'    => esc_html__( 'Center Top', 'trs-kit' ),
				'center bottom' => esc_html__( 'Center Bottom', 'trs-kit' ),
				'left center'   => esc_html__( 'Left Center', 'trs-kit' ),
				'right center'  => esc_html__( 'Right Center', 'trs-kit' ),
			],
			'default'   => 'center center',
			'selectors' => [
				'{{WRAPPER}} .trs-slideshow' => '--trs-ss-bg-pos: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	// ── Content: Navigation & Autoplay ───────────────────────────────────────

	private function register_content_navigation_controls(): void {
		$this->start_controls_section( 'section_navigation', [
			'label' => esc_html__( 'Navigation & Autoplay', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'transition_effect', [
			'label'   => esc_html__( 'Transition Effect', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => [
				'fade'  => esc_html__( 'Fade', 'trs-kit' ),
				'slide' => esc_html__( 'Slide', 'trs-kit' ),
			],
			'default' => 'fade',
		] );

		$this->add_control( 'transition_speed', [
			'label'      => esc_html__( 'Transition Speed (ms)', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 2000, 'step' => 50 ] ],
			'size_units' => [ 'px' ],
			'default'    => [ 'size' => 700, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-slideshow' => '--trs-ss-speed: {{SIZE}}ms;',
			],
		] );

		$this->add_control( 'show_nav_lines', [
			'label'        => esc_html__( 'Show Slide Changer (Lines)', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_arrows', [
			'label'        => esc_html__( 'Show Arrow Navigation', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => '',
		] );

		$this->add_control( 'autoplay_heading', [
			'label'     => esc_html__( 'Auto-Play', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'autoplay', [
			'label'   => esc_html__( 'Enable Auto-Play', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'autoplay_interval', [
			'label'      => esc_html__( 'Interval (seconds)', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::NUMBER,
			'min'        => 2,
			'max'        => 30,
			'step'       => 0.5,
			'default'    => 6,
			'conditions' => [
				'terms' => [ [ 'name' => 'autoplay', 'operator' => '===', 'value' => 'yes' ] ],
			],
		] );

		$this->add_control( 'autoplay_pause_on_hover', [
			'label'      => esc_html__( 'Pause on Hover', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SWITCHER,
			'default'    => 'yes',
			'conditions' => [
				'terms' => [ [ 'name' => 'autoplay', 'operator' => '===', 'value' => 'yes' ] ],
			],
		] );

		$this->end_controls_section();
	}

	// ── Style: Container ─────────────────────────────────────────────────────

	private function register_style_container_controls(): void {
		$this->start_controls_section( 'section_style_container', [
			'label' => esc_html__( 'Container', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'container_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 100 ],
				'%'  => [ 'min' => 0, 'max' => 50 ],
			],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-slideshow' => '--trs-ss-radius: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .trs-slideshow',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .trs-slideshow',
			]
		);

		$this->end_controls_section();
	}

	// ── Style: Overlay ───────────────────────────────────────────────────────

	private function register_style_overlay_controls(): void {
		$this->start_controls_section( 'section_style_overlay', [
			'label' => esc_html__( 'Overlay', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'           => 'default_overlay',
				'types'          => [ 'classic', 'gradient' ],
				'selector'       => '{{WRAPPER}} .trs-ss-overlay',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color'      => [ 'default' => 'rgba(0, 0, 0, 0.35)' ],
				],
			]
		);

		$this->add_control( 'overlay_note', [
			'type' => \Elementor\Controls_Manager::RAW_HTML,
			'raw'  => esc_html__( 'Individual slides can override this overlay under Slides → (slide) → Custom Overlay.', 'trs-kit' ),
			'content_classes' => 'elementor-descriptor',
		] );

		$this->end_controls_section();
	}

	// ── Style: Title ──────────────────────────────────────────────────────────

	private function register_style_title_controls(): void {
		$this->start_controls_section( 'section_style_title', [
			'label' => esc_html__( 'Title', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-ss-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'title_typography',
				'selector'       => '{{WRAPPER}} .trs-ss-title',
				'fields_options' => [
					'font_size'   => [ 'default' => [ 'unit' => 'px', 'size' => 56 ] ],
					'font_weight' => [ 'default' => '500' ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.15 ] ],
				],
			]
		);

		$this->end_controls_section();
	}

	// ── Style: Description ───────────────────────────────────────────────────

	private function register_style_description_controls(): void {
		$this->start_controls_section( 'section_style_description', [
			'label' => esc_html__( 'Description', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.9)',
			'selectors' => [ '{{WRAPPER}} .trs-ss-description' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'description_typography',
				'selector'       => '{{WRAPPER}} .trs-ss-description',
				'fields_options' => [
					'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 18 ] ],
				],
			]
		);

		$this->end_controls_section();
	}

	// ── Style: Button ─────────────────────────────────────────────────────────

	private function register_style_button_controls(): void {
		$this->start_controls_section( 'section_style_button', [
			'label' => esc_html__( 'Button', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'button_tab_normal', [
			'label' => esc_html__( 'Normal', 'trs-kit' ),
		] );

		$this->add_control( 'button_text_color', [
			'label'     => esc_html__( 'Text Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-ss-button' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'button_icon_color', [
			'label'     => esc_html__( 'Icon Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [
				'{{WRAPPER}} .trs-ss-button-icon i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-ss-button-icon svg' => 'fill: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_bg_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'transparent',
			'selectors' => [ '{{WRAPPER}} .trs-ss-button' => 'background-color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'button_tab_hover', [
			'label' => esc_html__( 'Hover', 'trs-kit' ),
		] );

		$this->add_control( 'button_text_color_hover', [
			'label'     => esc_html__( 'Text Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.75)',
			'selectors' => [ '{{WRAPPER}} .trs-ss-button:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'button_icon_color_hover', [
			'label'     => esc_html__( 'Icon Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.75)',
			'selectors' => [
				'{{WRAPPER}} .trs-ss-button:hover .trs-ss-button-icon i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-ss-button:hover .trs-ss-button-icon svg' => 'fill: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_bg_color_hover', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'transparent',
			'selectors' => [ '{{WRAPPER}} .trs-ss-button:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'button_icon_position', [
			'label'     => esc_html__( 'Icon Position', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => [
				'before' => [ 'title' => esc_html__( 'Before', 'trs-kit' ), 'icon' => 'eicon-h-align-left' ],
				'after'  => [ 'title' => esc_html__( 'After', 'trs-kit' ), 'icon' => 'eicon-h-align-right' ],
			],
			'default'   => 'after',
			'separator' => 'before',
			'selectors_dictionary' => [
				'before' => 'row-reverse',
				'after'  => 'row',
			],
			'selectors' => [
				'{{WRAPPER}} .trs-ss-button' => 'flex-direction: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'button_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 48 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ss-button-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trs-ss-button-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'button_icon_gap', [
			'label'      => esc_html__( 'Gap Between Text & Icon', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ss-button' => 'gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'      => 'button_border',
				'selector'  => '{{WRAPPER}} .trs-ss-button',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control( 'button_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 60 ],
				'%'  => [ 'min' => 0, 'max' => 50 ],
			],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ss-button' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'button_padding', [
			'label'      => esc_html__( 'Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '6', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ss-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'button_typography',
				'selector'       => '{{WRAPPER}} .trs-ss-button-text',
				'fields_options' => [
					'font_size'      => [ 'default' => [ 'unit' => 'px', 'size' => 18 ] ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 1 ] ],
				],
			]
		);

		$this->end_controls_section();
	}

	// ── Style: Slide Changer (Lines) ─────────────────────────────────────────

	private function register_style_nav_lines_controls(): void {
		$this->start_controls_section( 'section_style_nav_lines', [
			'label'     => esc_html__( 'Slide Changer', 'trs-kit' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_nav_lines' => 'yes' ],
		] );

		$this->add_control( 'nav_line_color', [
			'label'     => esc_html__( 'Line Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.4)',
			'selectors' => [ '{{WRAPPER}} .trs-slideshow' => '--trs-ss-line-color: {{VALUE}};' ],
		] );

		$this->add_control( 'nav_line_active_color', [
			'label'     => esc_html__( 'Active Line Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-slideshow' => '--trs-ss-line-active-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'nav_line_thickness', [
			'label'      => esc_html__( 'Line Thickness', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1, 'max' => 8 ] ],
			'default'    => [ 'size' => 2, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-slideshow' => '--trs-ss-line-thickness: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'nav_line_gap', [
			'label'      => esc_html__( 'Gap Between Lines', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default'    => [ 'size' => 10, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-slideshow' => '--trs-ss-line-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'nav_max_width', [
			'label'          => esc_html__( 'Total Width', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 100, 'max' => 600 ] ],
			'default'        => [ 'size' => 260, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 220, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 180, 'unit' => 'px' ],
			'selectors'      => [ '{{WRAPPER}} .trs-slideshow' => '--trs-ss-nav-max-w: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'nav_alignment', [
			'label'        => esc_html__( 'Alignment', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::CHOOSE,
			'options'      => [
				'left'   => [ 'title' => esc_html__( 'Left', 'trs-kit' ), 'icon' => 'eicon-h-align-left' ],
				'center' => [ 'title' => esc_html__( 'Center', 'trs-kit' ), 'icon' => 'eicon-h-align-center' ],
				'right'  => [ 'title' => esc_html__( 'Right', 'trs-kit' ), 'icon' => 'eicon-h-align-right' ],
			],
			'default'      => 'right',
			'prefix_class' => 'trs-ss-nav-align-',
		] );

		$this->end_controls_section();
	}

	// ── Style: Arrows ─────────────────────────────────────────────────────────

	private function register_style_arrows_controls(): void {
		$this->start_controls_section( 'section_style_arrows', [
			'label'     => esc_html__( 'Arrows', 'trs-kit' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_arrows' => 'yes' ],
		] );

		$this->start_controls_tabs( 'arrow_tabs' );

		$this->start_controls_tab( 'arrow_tab_normal', [
			'label' => esc_html__( 'Normal', 'trs-kit' ),
		] );

		$this->add_control( 'arrow_bg_color', [
			'label'     => esc_html__( 'Background', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.15)',
			'selectors' => [ '{{WRAPPER}} .trs-ss-arrow' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_border_color', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.6)',
			'selectors' => [ '{{WRAPPER}} .trs-ss-arrow' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_icon_color', [
			'label'     => esc_html__( 'Icon Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-ss-arrow' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'arrow_tab_hover', [
			'label' => esc_html__( 'Hover', 'trs-kit' ),
		] );

		$this->add_control( 'arrow_bg_color_hover', [
			'label'     => esc_html__( 'Background', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-ss-arrow:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_border_color_hover', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-ss-arrow:hover' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_icon_color_hover', [
			'label'     => esc_html__( 'Icon Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1F1D1D',
			'selectors' => [ '{{WRAPPER}} .trs-ss-arrow:hover' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control( 'arrow_size', [
			'label'      => esc_html__( 'Button Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 24, 'max' => 96 ] ],
			'default'    => [ 'size' => 48, 'unit' => 'px' ],
			'separator'  => 'before',
			'selectors'  => [ '{{WRAPPER}} .trs-ss-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrow_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 36 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-ss-arrow i' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrow_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'selectors'  => [ '{{WRAPPER}} .trs-ss-arrow' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();
	}

	// -------------------------------------------------------------------------
	// Render
	// -------------------------------------------------------------------------

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$slides   = $settings['slides'] ?? [];

		if ( empty( $slides ) ) {
			return;
		}

		$total          = count( $slides );
		$effect         = 'slide' === ( $settings['transition_effect'] ?? 'fade' ) ? 'slide' : 'fade';
		$show_lines     = 'yes' === ( $settings['show_nav_lines'] ?? 'yes' );
		$show_arrows    = 'yes' === ( $settings['show_arrows'] ?? '' );
		$autoplay       = 'yes' === ( $settings['autoplay'] ?? 'yes' );
		$autoplay_ms    = (float) ( $settings['autoplay_interval'] ?? 6 ) * 1000;
		$pause_on_hover = 'yes' === ( $settings['autoplay_pause_on_hover'] ?? 'yes' );

		printf(
			'<div class="trs-slideshow" data-effect="%1$s" data-autoplay="%2$s" data-autoplay-interval="%3$s" data-autoplay-pause-hover="%4$s" role="region" aria-roledescription="carousel" aria-label="%5$s">',
			esc_attr( $effect ),
			$autoplay ? 'true' : 'false',
			esc_attr( (string) $autoplay_ms ),
			$pause_on_hover ? 'true' : 'false',
			esc_attr__( 'Slideshow', 'trs-kit' )
		);

		echo '<div class="trs-ss-track">';
		foreach ( $slides as $index => $slide ) {
			$this->render_slide( $slide, $index, $total );
		}
		echo '</div>';

		if ( $show_lines && $total > 1 ) {
			$this->render_nav_lines( $total );
		}

		if ( $show_arrows && $total > 1 ) {
			$this->render_arrows();
		}

		echo '</div>';
	}

	/**
	 * Outputs a single slide (background, overlay, content).
	 *
	 * @param array $slide Repeater item.
	 * @param int   $index Zero-based slide index.
	 * @param int   $total Total number of slides.
	 */
	private function render_slide( array $slide, int $index, int $total ): void {
		$img_id  = ! empty( $slide['background_image']['id'] ) ? (int) $slide['background_image']['id'] : 0;
		$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'full' ) : ( $slide['background_image']['url'] ?? '' );
		$img_alt = ! empty( $slide['background_image_alt'] ) ? $slide['background_image_alt'] : wp_strip_all_tags( $slide['title'] ?? '' );

		$has_custom_overlay = 'yes' === ( $slide['use_custom_overlay'] ?? '' ) && ! empty( $slide['overlay_color'] );

		printf(
			'<div class="trs-ss-slide elementor-repeater-item-%1$s%2$s" data-index="%3$d" role="group" aria-roledescription="slide" aria-label="%4$s" aria-hidden="%5$s">',
			esc_attr( $slide['_id'] ),
			0 === $index ? ' trs-ss-slide--active' : '',
			(int) $index,
			esc_attr( sprintf( __( '%1$d of %2$d', 'trs-kit' ), $index + 1, $total ) ),
			0 === $index ? 'false' : 'true'
		);

		if ( $img_url ) {
			printf(
				'<div class="trs-ss-bg" style="background-image:url(%s);" role="img" aria-label="%s"></div>',
				esc_url( $img_url ),
				esc_attr( $img_alt )
			);
		}

		if ( $has_custom_overlay ) {
			printf( '<div class="trs-ss-overlay" style="background-color:%s;"></div>', esc_attr( $slide['overlay_color'] ) );
		} else {
			echo '<div class="trs-ss-overlay"></div>';
		}

		echo '<div class="trs-ss-content">';

		if ( ! empty( $slide['title'] ) ) {
			echo '<h2 class="trs-ss-title">' . nl2br( esc_html( $slide['title'] ) ) . '</h2>';
		}

		if ( ! empty( $slide['description'] ) ) {
			echo '<p class="trs-ss-description">' . nl2br( esc_html( $slide['description'] ) ) . '</p>';
		}

		if ( ! empty( $slide['button_text'] ) ) {
			$this->render_button( $slide );
		}

		echo '</div>'; // .trs-ss-content
		echo '</div>'; // .trs-ss-slide
	}

	/**
	 * Outputs a slide's CTA button (text + editable icon).
	 *
	 * @param array $slide Repeater item.
	 */
	private function render_button( array $slide ): void {
		$link   = $slide['button_link'] ?? [];
		$url    = ! empty( $link['url'] ) ? $link['url'] : '';
		$target = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
		$rel    = ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
		$tag    = '' !== $url ? 'a' : 'span';

		printf( '<%1$s class="trs-ss-button"%2$s%3$s%4$s>', $tag, '' !== $url ? ' href="' . esc_url( $url ) . '"' : '', $target, $rel );

		echo '<span class="trs-ss-button-text">' . esc_html( $slide['button_text'] ) . '</span>';

		if ( ! empty( $slide['button_icon']['value'] ) ) {
			echo '<span class="trs-ss-button-icon">';
			\Elementor\Icons_Manager::render_icon( $slide['button_icon'], [ 'aria-hidden' => 'true' ] );
			echo '</span>';
		}

		printf( '</%s>', $tag );
	}

	/**
	 * Outputs the segmented "line" slide-changer navigation.
	 *
	 * @param int $total Total number of slides.
	 */
	private function render_nav_lines( int $total ): void {
		printf( '<div class="trs-ss-nav" role="tablist" aria-label="%s">', esc_attr__( 'Slide navigation', 'trs-kit' ) );

		for ( $i = 0; $i < $total; $i++ ) {
			printf(
				'<button type="button" class="trs-ss-line%1$s" data-idx="%2$d" role="tab" aria-selected="%3$s" aria-label="%4$s"></button>',
				0 === $i ? ' trs-ss-line--active' : '',
				$i,
				0 === $i ? 'true' : 'false',
				esc_attr( sprintf( __( 'Go to slide %d', 'trs-kit' ), $i + 1 ) )
			);
		}

		echo '</div>';
	}

	/**
	 * Outputs the optional previous/next arrow buttons.
	 */
	private function render_arrows(): void {
		echo '<div class="trs-ss-arrows">';
		printf(
			'<button type="button" class="trs-ss-arrow trs-ss-arrow--prev" aria-label="%s"><i class="eicon-chevron-left" aria-hidden="true"></i></button>',
			esc_attr__( 'Previous slide', 'trs-kit' )
		);
		printf(
			'<button type="button" class="trs-ss-arrow trs-ss-arrow--next" aria-label="%s"><i class="eicon-chevron-right" aria-hidden="true"></i></button>',
			esc_attr__( 'Next slide', 'trs-kit' )
		);
		echo '</div>';
	}
}
