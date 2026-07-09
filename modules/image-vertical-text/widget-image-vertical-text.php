<?php
/**
 * Image with Vertical Text widget.
 *
 * A compact "signature" module pairing a portrait image with a short,
 * rotated (vertical) text label running alongside it — e.g. a name and
 * title next to a portrait photo. Fully stylable: typography, colors,
 * image border/radius/shadow, and a color or gradient overlay. Stacks to
 * a horizontal, upright layout on mobile for readability.
 *
 * @package TRS_Kit
 */

declare( strict_types=1 );

namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TRS_Widget_Image_Vertical_Text
 */
class TRS_Widget_Image_Vertical_Text extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'trs-image-vertical-text';
	}

	public function get_title(): string {
		return esc_html__( 'Image with Vertical Text', 'trs-kit' );
	}

	public function get_icon(): string {
		return 'eicon-image-box';
	}

	public function get_categories(): array {
		return [ 'trs-kit' ];
	}

	public function get_style_depends(): array {
		return [ 'trs-image-vertical-text' ];
	}

	// -------------------------------------------------------------------------
	// Controls
	// -------------------------------------------------------------------------

	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_layout_controls();

		$this->register_style_text_controls();
		$this->register_style_image_controls();
	}

	// ── Content ───────────────────────────────────────────────────────────────

	private function register_content_controls(): void {
		$this->start_controls_section( 'section_content', [
			'label' => esc_html__( 'Content', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'image', [
			'label'   => esc_html__( 'Image', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'default' => 'large',
			]
		);

		$this->add_control( 'vertical_text', [
			'label'       => esc_html__( 'Vertical Text', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'John Doe / Founder & CEO', 'trs-kit' ),
			'placeholder' => esc_html__( 'e.g. Jane Doe / CEO Company', 'trs-kit' ),
			'label_block' => true,
		] );

		$this->add_control( 'image_link', [
			'label'       => esc_html__( 'Link', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'trs-kit' ),
			'description' => esc_html__( 'Optional — wraps the whole module in a link.', 'trs-kit' ),
		] );

		$this->end_controls_section();
	}

	// ── Layout ────────────────────────────────────────────────────────────────

	private function register_layout_controls(): void {
		$this->start_controls_section( 'section_layout', [
			'label' => esc_html__( 'Layout', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'alignment', [
			'label'     => esc_html__( 'Module Alignment', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => [
				'flex-start' => [ 'title' => esc_html__( 'Left', 'trs-kit' ), 'icon' => 'eicon-text-align-left' ],
				'center'     => [ 'title' => esc_html__( 'Center', 'trs-kit' ), 'icon' => 'eicon-text-align-center' ],
				'flex-end'   => [ 'title' => esc_html__( 'Right', 'trs-kit' ), 'icon' => 'eicon-text-align-right' ],
			],
			'default'   => 'flex-start',
			'selectors' => [
				'{{WRAPPER}} .trs-ivt' => 'justify-content: {{VALUE}};',
			],
		] );

		$this->add_control( 'text_position', [
			'label'        => esc_html__( 'Text Side', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::CHOOSE,
			'options'      => [
				'left'  => [ 'title' => esc_html__( 'Left of Image', 'trs-kit' ), 'icon' => 'eicon-arrow-left' ],
				'right' => [ 'title' => esc_html__( 'Right of Image', 'trs-kit' ), 'icon' => 'eicon-arrow-right' ],
			],
			'default'      => 'left',
			'prefix_class' => 'trs-ivt-pos-',
		] );

		$this->add_control( 'text_vertical_align', [
			'label'     => esc_html__( 'Text Vertical Align', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'options'   => [
				'flex-start' => esc_html__( 'Top', 'trs-kit' ),
				'center'     => esc_html__( 'Middle', 'trs-kit' ),
				'flex-end'   => esc_html__( 'Bottom', 'trs-kit' ),
			],
			'default'   => 'center',
			'selectors' => [
				'{{WRAPPER}} .trs-ivt-text-col' => 'justify-content: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'gap', [
			'label'          => esc_html__( 'Gap Between Text & Image', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'        => [ 'size' => 24, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 20, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-ivt-inner' => 'gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'media_height', [
			'label'          => esc_html__( 'Image Height', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 150, 'max' => 900 ] ],
			'default'        => [ 'size' => 640, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 480, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 360, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-ivt-media' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'media_width', [
			'label'          => esc_html__( 'Image Width', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', '%' ],
			'range'          => [
				'px' => [ 'min' => 120, 'max' => 800 ],
				'%'  => [ 'min' => 10, 'max' => 100 ],
			],
			'default'        => [ 'size' => 340, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 300, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 100, 'unit' => '%' ],
			'selectors'      => [
				'{{WRAPPER}} .trs-ivt-media' => 'width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'stack_on_mobile', [
			'label'        => esc_html__( 'Stack on Mobile', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'description'  => esc_html__( 'Un-rotates the text and stacks it above the image on small screens for better readability.', 'trs-kit' ),
			'prefix_class' => 'trs-ivt-stack-',
		] );

		$this->end_controls_section();
	}

	// ── Style: Vertical Text ────────────────────────────────────────────────

	private function register_style_text_controls(): void {
		$this->start_controls_section( 'section_style_text', [
			'label' => esc_html__( 'Vertical Text', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'text_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1F1D1D',
			'selectors' => [ '{{WRAPPER}} .trs-ivt-text' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'vertical_text_typography',
				'selector'       => '{{WRAPPER}} .trs-ivt-text',
				'fields_options' => [
					'font_size'      => [ 'default' => [ 'unit' => 'px', 'size' => 14 ] ],
					'font_weight'    => [ 'default' => '500' ],
					'line_height'    => [ 'default' => [ 'unit' => 'em', 'size' => 1.4 ] ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => -0.4 ] ],
					'text_transform' => [ 'default' => 'uppercase' ],
				],
			]
		);

		$this->add_control( 'text_direction', [
			'label'                => esc_html__( 'Reading Direction', 'trs-kit' ),
			'type'                 => \Elementor\Controls_Manager::SELECT,
			'options'              => [
				'up'   => esc_html__( 'Bottom to Top', 'trs-kit' ),
				'down' => esc_html__( 'Top to Bottom', 'trs-kit' ),
			],
			'default'              => 'up',
			'selectors_dictionary' => [
				'up'   => '-90',
				'down' => '90',
			],
			'selectors'            => [
				'{{WRAPPER}} .trs-ivt-text' => 'transform: rotate({{VALUE}}deg);',
			],
		] );

		$this->add_responsive_control( 'text_padding', [
			'label'      => esc_html__( 'Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default'    => [ 'top' => '0', 'right' => '8', 'bottom' => '0', 'left' => '8', 'unit' => 'px', 'isLinked' => false ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ivt-text-col' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	// ── Style: Image ─────────────────────────────────────────────────────────

	private function register_style_image_controls(): void {
		$this->start_controls_section( 'section_style_image', [
			'label' => esc_html__( 'Image', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'object_fit', [
			'label'     => esc_html__( 'Image Fit', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'options'   => [
				'cover'   => esc_html__( 'Cover', 'trs-kit' ),
				'contain' => esc_html__( 'Contain', 'trs-kit' ),
				'fill'    => esc_html__( 'Fill', 'trs-kit' ),
			],
			'default'   => 'cover',
			'selectors' => [
				'{{WRAPPER}} .trs-ivt-media img' => 'object-fit: {{VALUE}};',
			],
		] );

		$this->add_control( 'object_position', [
			'label'     => esc_html__( 'Image Position', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'options'   => [
				'center'      => esc_html__( 'Center', 'trs-kit' ),
				'top'         => esc_html__( 'Top', 'trs-kit' ),
				'bottom'      => esc_html__( 'Bottom', 'trs-kit' ),
				'left'        => esc_html__( 'Left', 'trs-kit' ),
				'right'       => esc_html__( 'Right', 'trs-kit' ),
				'top left'    => esc_html__( 'Top Left', 'trs-kit' ),
				'top right'   => esc_html__( 'Top Right', 'trs-kit' ),
				'bottom left' => esc_html__( 'Bottom Left', 'trs-kit' ),
				'bottom right'=> esc_html__( 'Bottom Right', 'trs-kit' ),
			],
			'default'   => 'center',
			'condition' => [ 'object_fit' => [ 'cover', 'contain' ] ],
			'selectors' => [
				'{{WRAPPER}} .trs-ivt-media img' => 'object-position: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_zoom', [
			'label'        => esc_html__( 'Hover Zoom Effect', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => '',
			'prefix_class' => 'trs-ivt-zoom-',
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'media_border',
				'selector' => '{{WRAPPER}} .trs-ivt-media',
			]
		);

		$this->add_responsive_control( 'media_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 120 ],
				'%'  => [ 'min' => 0, 'max' => 50 ],
			],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ivt-media' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'media_box_shadow',
				'selector' => '{{WRAPPER}} .trs-ivt-media',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'media_overlay',
				'label'    => esc_html__( 'Overlay', 'trs-kit' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .trs-ivt-overlay',
			]
		);

		$this->end_controls_section();
	}

	// -------------------------------------------------------------------------
	// Render
	// -------------------------------------------------------------------------

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		$has_image = ! empty( $settings['image']['url'] );
		$has_text  = '' !== ( $settings['vertical_text'] ?? '' );

		if ( ! $has_image && ! $has_text ) {
			return;
		}

		$link = $settings['image_link'] ?? [];
		$url  = ! empty( $link['url'] ) ? $link['url'] : '';
		$tag  = '' !== $url ? 'a' : 'div';

		echo '<div class="trs-ivt">';

		printf( '<%1$s class="trs-ivt-inner"', esc_attr( $tag ) );

		if ( '' !== $url ) {
			printf( ' href="%s"', esc_url( $url ) );
			if ( ! empty( $link['is_external'] ) ) {
				echo ' target="_blank"';
			}
			if ( ! empty( $link['nofollow'] ) ) {
				echo ' rel="nofollow"';
			}
		}

		echo '>';

		$this->render_text_column( $settings, $has_text );
		$this->render_media_column( $settings, $has_image );

		printf( '</%s>', esc_attr( $tag ) );

		echo '</div>';
	}

	/**
	 * Outputs the rotated text column.
	 *
	 * @param array $settings Widget settings.
	 * @param bool  $has_text Whether vertical text is set.
	 */
	private function render_text_column( array $settings, bool $has_text ): void {
		if ( ! $has_text ) {
			return;
		}

		echo '<div class="trs-ivt-text-col">';
		echo '<span class="trs-ivt-text">' . esc_html( $settings['vertical_text'] ) . '</span>';
		echo '</div>';
	}

	/**
	 * Outputs the image column with its overlay layer.
	 *
	 * @param array $settings Widget settings.
	 * @param bool  $has_image Whether an image is set.
	 */
	private function render_media_column( array $settings, bool $has_image ): void {
		if ( ! $has_image ) {
			return;
		}

		echo '<div class="trs-ivt-media">';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor helper escapes internally.
		echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings );
		echo '<div class="trs-ivt-overlay" aria-hidden="true"></div>';
		echo '</div>';
	}
}
