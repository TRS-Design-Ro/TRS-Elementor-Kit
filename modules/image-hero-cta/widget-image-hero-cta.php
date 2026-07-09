<?php
/**
 * Image Hero with CTA widget.
 *
 * A full-bleed hero band with an image/color/gradient background, a
 * frosted-glass content card (title, description, button), and thin
 * "viewfinder" lines that frame the content column against the photo.
 * Supports multiple cards arranged into a responsive grid of rows and
 * columns.
 *
 * @package TRS_Kit
 */

declare( strict_types=1 );

namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TRS_Widget_Image_Hero_Cta
 */
class TRS_Widget_Image_Hero_Cta extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'trs-image-hero-cta';
	}

	public function get_title(): string {
		return esc_html__( 'Image Hero with CTA', 'trs-kit' );
	}

	public function get_icon(): string {
		return 'eicon-image-box';
	}

	public function get_categories(): array {
		return [ 'trs-kit' ];
	}

	public function get_style_depends(): array {
		return [ 'trs-image-hero-cta' ];
	}

	// -------------------------------------------------------------------------
	// Controls
	// -------------------------------------------------------------------------

	protected function register_controls(): void {
		$this->register_content_cards_controls();
		$this->register_content_layout_controls();
		$this->register_content_frame_controls();

		$this->register_style_background_controls();
		$this->register_style_frame_controls();
		$this->register_style_card_controls();
		$this->register_style_title_controls();
		$this->register_style_description_controls();
		$this->register_style_button_controls();
	}

	// ── Content: Cards ───────────────────────────────────────────────────────

	private function register_content_cards_controls(): void {
		$this->start_controls_section( 'section_cards', [
			'label' => esc_html__( 'Cards', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Choose Excellence', 'trs-kit' ),
			'placeholder' => esc_html__( 'Enter a title', 'trs-kit' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'description', [
			'label'       => esc_html__( 'Description', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'default'     => esc_html__( 'Discover premium quality and craftsmanship in every detail, tailored to your unique style and needs.', 'trs-kit' ),
			'placeholder' => esc_html__( 'Enter a short description', 'trs-kit' ),
			'rows'        => 4,
		] );

		$repeater->add_control( 'button_text', [
			'label'       => esc_html__( 'Button Text', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Learn More', 'trs-kit' ),
			'placeholder' => esc_html__( 'Button label', 'trs-kit' ),
		] );

		$repeater->add_control( 'button_link', [
			'label'       => esc_html__( 'Button Link', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'trs-kit' ),
			'default'     => [ 'url' => '#' ],
		] );

		$this->add_control( 'cards', [
			'label'       => esc_html__( 'Cards', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'title'       => esc_html__( 'Choose Excellence', 'trs-kit' ),
					'description' => esc_html__( 'Discover premium quality and craftsmanship in every detail, tailored to your unique style and needs.', 'trs-kit' ),
					'button_text' => esc_html__( 'Learn More', 'trs-kit' ),
					'button_link' => [ 'url' => '#' ],
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

		$this->add_responsive_control( 'columns', [
			'label'          => esc_html__( 'Columns', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'options'        => [
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			],
			'default'        => '1',
			'tablet_default' => '1',
			'mobile_default' => '1',
			'selectors'      => [
				'{{WRAPPER}} .trs-ihc' => '--trs-ihc-cols: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'card_width', [
			'label'          => esc_html__( 'Card Width', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', '%' ],
			'range'          => [
				'px' => [ 'min' => 200, 'max' => 800 ],
				'%'  => [ 'min' => 20, 'max' => 100 ],
			],
			'default'        => [ 'size' => 389, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 340, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 100, 'unit' => '%' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-ihc' => '--trs-ihc-card-w: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'row_height', [
			'label'          => esc_html__( 'Card / Row Height', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 200, 'max' => 800 ] ],
			'default'        => [ 'size' => 450, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 420, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 380, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-ihc' => '--trs-ihc-row-h: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'section_min_height', [
			'label'          => esc_html__( 'Section Min Height', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 300, 'max' => 1000 ] ],
			'default'        => [ 'size' => 600, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 520, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 460, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-ihc' => '--trs-ihc-min-h: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'content_padding', [
			'label'          => esc_html__( 'Content Position (Padding)', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'     => [ 'px', '%' ],
			'default'        => [ 'top' => '75', 'right' => '0', 'bottom' => '75', 'left' => '150', 'unit' => 'px' ],
			'tablet_default' => [ 'top' => '50', 'right' => '0', 'bottom' => '50', 'left' => '40', 'unit' => 'px' ],
			'mobile_default' => [ 'top' => '32', 'right' => '20', 'bottom' => '32', 'left' => '20', 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-ihc' => '--trs-ihc-pad-top: {{TOP}}{{UNIT}}; --trs-ihc-pad-right: {{RIGHT}}{{UNIT}}; --trs-ihc-pad-bottom: {{BOTTOM}}{{UNIT}}; --trs-ihc-pad-left: {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'columns_gap', [
			'label'          => esc_html__( 'Columns Gap', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'        => [ 'size' => 24, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-ihc' => '--trs-ihc-gap-x: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'rows_gap', [
			'label'          => esc_html__( 'Rows Gap', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'        => [ 'size' => 24, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-ihc' => '--trs-ihc-gap-y: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	// ── Content: Frame Lines ─────────────────────────────────────────────────

	private function register_content_frame_controls(): void {
		$this->start_controls_section( 'section_frame', [
			'label' => esc_html__( 'Frame Lines', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_frame_lines', [
			'label'        => esc_html__( 'Show Frame Lines', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'description'  => esc_html__( 'Draws thin lines that frame the photo and the content column, like the reference design.', 'trs-kit' ),
		] );

		$this->add_control( 'show_frame_lines_mobile', [
			'label'        => esc_html__( 'Keep Inner Lines on Tablet/Mobile', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => '',
			'description'  => esc_html__( 'By default only the outer frame is kept on smaller screens for a cleaner look.', 'trs-kit' ),
			'condition'    => [ 'show_frame_lines' => 'yes' ],
		] );

		$this->end_controls_section();
	}

	// ── Style: Background ────────────────────────────────────────────────────

	private function register_style_background_controls(): void {
		$this->start_controls_section( 'section_style_background', [
			'label' => esc_html__( 'Section Background', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'           => 'section_background',
				'types'          => [ 'classic', 'gradient' ],
				'selector'       => '{{WRAPPER}} .trs-ihc-bg',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color'      => [ 'default' => '#2B2B2B' ],
				],
			]
		);

		$this->add_control( 'section_overlay_color', [
			'label'     => esc_html__( 'Overlay Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(0, 0, 0, 0.15)',
			'selectors' => [
				'{{WRAPPER}} .trs-ihc-overlay' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'section_border_radius', [
			'label'      => esc_html__( 'Section Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ihc' => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;',
			],
		] );

		$this->end_controls_section();
	}

	// ── Style: Frame Lines ───────────────────────────────────────────────────

	private function register_style_frame_controls(): void {
		$this->start_controls_section( 'section_style_frame', [
			'label'     => esc_html__( 'Frame Lines', 'trs-kit' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_frame_lines' => 'yes' ],
		] );

		$this->add_control( 'frame_line_color', [
			'label'     => esc_html__( 'Line Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.6)',
			'selectors' => [
				'{{WRAPPER}} .trs-ihc' => '--trs-ihc-line-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'frame_line_width', [
			'label'      => esc_html__( 'Line Thickness', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1, 'max' => 6 ] ],
			'default'    => [ 'size' => 1, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ihc' => '--trs-ihc-line-w: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	// ── Style: Card ───────────────────────────────────────────────────────────

	private function register_style_card_controls(): void {
		$this->start_controls_section( 'section_style_card', [
			'label' => esc_html__( 'Card', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_content_align', [
			'label'     => esc_html__( 'Text Alignment', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [ 'title' => esc_html__( 'Left', 'trs-kit' ), 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => esc_html__( 'Center', 'trs-kit' ), 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => esc_html__( 'Right', 'trs-kit' ), 'icon' => 'eicon-text-align-right' ],
			],
			'default'   => 'left',
			'selectors' => [
				'{{WRAPPER}} .trs-ihc-card' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'           => 'card_background',
				'types'          => [ 'classic', 'gradient' ],
				'selector'       => '{{WRAPPER}} .trs-ihc-card',
				'fields_options' => [
					'background'     => [ 'default' => 'gradient' ],
					'color'          => [ 'default' => 'rgba(255, 255, 255, 0.45)' ],
					'color_b'        => [ 'default' => 'rgba(255, 255, 255, 0.05)' ],
					'gradient_angle' => [ 'default' => [ 'unit' => 'deg', 'size' => 135 ] ],
				],
			]
		);

		$this->add_responsive_control( 'card_backdrop_blur', [
			'label'      => esc_html__( 'Backdrop Blur', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default'    => [ 'size' => 15, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ihc-card' => '-webkit-backdrop-filter: blur({{SIZE}}{{UNIT}}); backdrop-filter: blur({{SIZE}}{{UNIT}});',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .trs-ihc-card',
			]
		);

		$this->add_responsive_control( 'card_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 80 ],
				'%'  => [ 'min' => 0, 'max' => 50 ],
			],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ihc-card' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .trs-ihc-card',
			]
		);

		$this->add_responsive_control( 'card_padding', [
			'label'      => esc_html__( 'Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'default'    => [ 'top' => '40', 'right' => '32', 'bottom' => '40', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ihc-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
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
			'selectors' => [ '{{WRAPPER}} .trs-ihc-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .trs-ihc-title',
				'fields_options' => [
					'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 40 ] ],
				],
			]
		);

		$this->add_responsive_control( 'title_spacing', [
			'label'      => esc_html__( 'Spacing After', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-ihc-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

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
			'selectors' => [ '{{WRAPPER}} .trs-ihc-description' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .trs-ihc-description',
				'fields_options' => [
					'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 18 ] ],
				],
			]
		);

		$this->add_responsive_control( 'description_spacing', [
			'label'      => esc_html__( 'Spacing After', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'size' => 32, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-ihc-description' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

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

		$this->add_control( 'button_bg_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-ihc-button' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'button_text_color', [
			'label'     => esc_html__( 'Text Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1F1D1D',
			'selectors' => [ '{{WRAPPER}} .trs-ihc-button' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'button_tab_hover', [
			'label' => esc_html__( 'Hover', 'trs-kit' ),
		] );

		$this->add_control( 'button_bg_color_hover', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1F1D1D',
			'selectors' => [ '{{WRAPPER}} .trs-ihc-button:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'button_text_color_hover', [
			'label'     => esc_html__( 'Text Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-ihc-button:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'button_border_color_hover', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trs-ihc-button:hover' => 'border-color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'button_underline', [
			'label'        => esc_html__( 'Underline Text', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'separator'    => 'before',
			'prefix_class' => 'trs-ihc-underline-',
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .trs-ihc-button',
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
				'{{WRAPPER}} .trs-ihc-button' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .trs-ihc-button',
			]
		);

		$this->add_responsive_control( 'button_padding', [
			'label'      => esc_html__( 'Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'default'    => [ 'top' => '13', 'right' => '24', 'bottom' => '13', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ihc-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .trs-ihc-button',
				'fields_options' => [
					'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 14 ] ],
				],
			]
		);

		$this->end_controls_section();
	}

	// -------------------------------------------------------------------------
	// Render
	// -------------------------------------------------------------------------

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$cards    = $settings['cards'] ?? [];

		if ( empty( $cards ) ) {
			return;
		}

		$cols        = max( 1, min( 4, (int) ( $settings['columns'] ?? 1 ) ) );
		$show_lines  = 'yes' === ( $settings['show_frame_lines'] ?? 'yes' );
		$lines_mobile = 'yes' === ( $settings['show_frame_lines_mobile'] ?? '' );

		$wrapper_classes = [ 'trs-ihc' ];
		if ( $lines_mobile ) {
			$wrapper_classes[] = 'trs-ihc--lines-mobile';
		}

		printf( '<section class="%s">', esc_attr( implode( ' ', $wrapper_classes ) ) );

		echo '<div class="trs-ihc-bg" aria-hidden="true"></div>';
		echo '<div class="trs-ihc-overlay" aria-hidden="true"></div>';

		if ( $show_lines ) {
			$this->render_frame_lines( $cols );
		}

		echo '<div class="trs-ihc-grid">';
		foreach ( $cards as $card ) {
			$this->render_card( $card );
		}
		echo '</div>';

		echo '</section>';
	}

	/**
	 * Outputs the decorative "viewfinder" lines framing the content grid.
	 *
	 * Two horizontal lines bound the top/bottom of the whole grid across the
	 * full section width, and (columns + 1) vertical lines bound every card
	 * boundary across the full section height.
	 *
	 * @param int $cols Number of columns configured for the grid.
	 */
	private function render_frame_lines( int $cols ): void {
		echo '<div class="trs-ihc-frame" aria-hidden="true">';
		echo '<span class="trs-ihc-frame-h trs-ihc-frame-h--top"></span>';
		echo '<span class="trs-ihc-frame-h trs-ihc-frame-h--bottom"></span>';

		for ( $i = 0; $i <= $cols; $i++ ) {
			$gap_count = min( $i, max( 0, $cols - 1 ) );
			$edge_class = 'trs-ihc-frame-v';
			if ( 0 === $i ) {
				$edge_class .= ' trs-ihc-frame-v--start';
			} elseif ( $i === $cols ) {
				$edge_class .= ' trs-ihc-frame-v--end';
			} else {
				$edge_class .= ' trs-ihc-frame-v--inner';
			}
			printf(
				'<span class="%1$s" style="left: calc(var(--trs-ihc-pad-left) + (%2$d * var(--trs-ihc-card-w)) + (%3$d * var(--trs-ihc-gap-x)));"></span>',
				esc_attr( $edge_class ),
				$i,
				$gap_count
			);
		}

		echo '</div>';
	}

	/**
	 * Outputs a single glass content card.
	 *
	 * @param array $card Repeater item.
	 */
	private function render_card( array $card ): void {
		$title       = $card['title'] ?? '';
		$description = $card['description'] ?? '';
		$button_text = $card['button_text'] ?? '';
		$link        = $card['button_link'] ?? [];
		$url         = ! empty( $link['url'] ) ? $link['url'] : '';
		$target      = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
		$rel         = ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';

		printf( '<div class="trs-ihc-card elementor-repeater-item-%s">', esc_attr( $card['_id'] ) );

		if ( '' !== $title ) {
			echo '<h2 class="trs-ihc-title">' . esc_html( $title ) . '</h2>';
		}

		if ( '' !== $description ) {
			echo '<p class="trs-ihc-description">' . esc_html( $description ) . '</p>';
		}

		if ( '' !== $button_text ) {
			if ( '' !== $url ) {
				printf(
					'<a class="trs-ihc-button" href="%s"%s%s>%s</a>',
					esc_url( $url ),
					$target,
					$rel,
					esc_html( $button_text )
				);
			} else {
				echo '<span class="trs-ihc-button">' . esc_html( $button_text ) . '</span>';
			}
		}

		echo '</div>';
	}
}
