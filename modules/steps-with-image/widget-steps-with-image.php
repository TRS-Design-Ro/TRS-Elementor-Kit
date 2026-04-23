<?php
/**
 * Steps With Image widget.
 *
 * Three-column layout: steps on the left, a portrait image in the centre,
 * steps on the right. Steps are auto-split between the two panels. On mobile
 * the image floats to the top and all steps stack in a single column.
 *
 * @package TRS_Kit
 */

namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TRS_Widget_Steps_With_Image
 */
class TRS_Widget_Steps_With_Image extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'trs-steps-with-image';
	}

	public function get_title(): string {
		return esc_html__( 'Steps With Image', 'trs-kit' );
	}

	public function get_icon(): string {
		return 'eicon-time-line';
	}

	public function get_categories(): array {
		return [ 'trs-kit' ];
	}

	public function get_style_depends(): array {
		return [ 'trs-steps-with-image' ];
	}

	// -------------------------------------------------------------------------
	// Controls
	// -------------------------------------------------------------------------

	protected function register_controls(): void {

		// ── Content: Steps ────────────────────────────────────────────────────

		$this->start_controls_section( 'section_steps', [
			'label' => esc_html__( 'Steps', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'icon', [
			'label'   => esc_html__( 'Icon', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => [
				'value'   => 'fas fa-check',
				'library' => 'fa-solid',
			],
		] );

		$repeater->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Step Title', 'trs-kit' ),
		] );

		$repeater->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Describe this step in a few sentences.', 'trs-kit' ),
		] );

		$this->add_control( 'steps', [
			'label'       => esc_html__( 'Steps', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'title'       => esc_html__( 'Step 1: The needs analysis', 'trs-kit' ),
					'description' => esc_html__( 'We start by understanding your exact volume, peak seasons, and operational bottlenecks. We listen actively and adapt our services to your specific targets.', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-search', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Step 2: Targeted recruitment', 'trs-kit' ),
					'description' => esc_html__( 'Our team hunts for reliable candidates ready to work. We filter out the noise and select people who are truly built for high-pressure environments.', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-users', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Step 3: Complete administration', 'trs-kit' ),
					'description' => esc_html__( 'You never touch a work permit. We take total ownership of the legal compliance, contracts, and paperwork before day one.', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-file-alt', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Step 4: Arrival & onboarding', 'trs-kit' ),
					'description' => esc_html__( 'We ensure the workforce arrives on time and understands their exact duties. We handle the cultural and transition challenges so they hit the ground running.', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-plane-arrival', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Step 5: Daily human support', 'trs-kit' ),
					'description' => esc_html__( 'Your new hires get dedicated support from our team. We solve their housing, language, or personal issues fast, keeping them focused on the job.', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-headset', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Step 6: Active retention', 'trs-kit' ),
					'description' => esc_html__( 'We do not disappear after the hire. We continuously manage morale and performance to keep your turnover low and your operations stable.', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-crown', 'library' => 'fa-solid' ],
				],
			],
			'title_field' => '{{{ title }}}',
		] );

		$this->add_control( 'left_panel_count', [
			'label'       => esc_html__( 'Steps on Left Side', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::NUMBER,
			'min'         => 1,
			'max'         => 20,
			'step'        => 1,
			'default'     => '',
			'placeholder' => esc_html__( 'Auto', 'trs-kit' ),
			'description' => esc_html__( 'Leave blank to auto-balance. Set a fixed number so that removing the last repeater item always removes from the right side — no steps jump between panels.', 'trs-kit' ),
		] );

		$this->end_controls_section();

		// ── Content: Image ────────────────────────────────────────────────────

		$this->start_controls_section( 'section_image', [
			'label' => esc_html__( 'Image', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'image', [
			'label'   => esc_html__( 'Center Image', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => '' ],
		] );

		$this->add_control( 'image_alt', [
			'label'   => esc_html__( 'Image Alt Text', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );

		$this->end_controls_section();

		// ── Style: Panel ──────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_panel', [
			'label' => esc_html__( 'Steps Panel', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'panel_bg_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#f8f7f2',
			'selectors' => [ '{{WRAPPER}} .trs-swi-panel' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'panel_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .trs-swi-panel' => '--trs-swi-panel-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'panel_padding', [
			'label'      => esc_html__( 'Panel Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'default'    => [
				'top'    => '24',
				'right'  => '24',
				'bottom' => '24',
				'left'   => '24',
				'unit'   => 'px',
			],
			'selectors'  => [ '{{WRAPPER}} .trs-swi-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'columns_gap', [
			'label'      => esc_html__( 'Gap Between Columns', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [ '{{WRAPPER}} .trs-steps-with-image' => '--trs-swi-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ── Style: Icon ───────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_icon', [
			'label' => esc_html__( 'Icon', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'icon_bg_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#fbd760',
			'selectors' => [ '{{WRAPPER}} .trs-swi-icon-wrap' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_color', [
			'label'     => esc_html__( 'Icon Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [
				'{{WRAPPER}} .trs-swi-icon-wrap i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-swi-icon-wrap svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Icon Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 48 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-swi-icon-wrap i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trs-swi-icon-wrap svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'icon_wrap_size', [
			'label'      => esc_html__( 'Container Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 32, 'max' => 96 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 48 ],
			'selectors'  => [ '{{WRAPPER}} .trs-swi-icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ── Style: Title ──────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_title', [
			'label' => esc_html__( 'Title', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-swi-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .trs-swi-title',
			]
		);

		$this->end_controls_section();

		// ── Style: Description ────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_description', [
			'label' => esc_html__( 'Description', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-swi-description' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .trs-swi-description',
			]
		);

		$this->end_controls_section();

		// ── Style: Divider ────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_divider', [
			'label' => esc_html__( 'Divider', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'divider_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#e0dfd9',
			'selectors' => [ '{{WRAPPER}} .trs-swi-divider' => 'border-top-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'step_spacing', [
			'label'      => esc_html__( 'Spacing Between Steps', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 80 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 28 ],
			'selectors'  => [ '{{WRAPPER}} .trs-swi-divider' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ── Style: Image ──────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_image', [
			'label' => esc_html__( 'Image', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'image_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .trs-swi-image-wrap' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'image_column_width', [
			'label'       => esc_html__( 'Image Column Width', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::SLIDER,
			'size_units'  => [ 'px', '%' ],
			'range'       => [ 'px' => [ 'min' => 160, 'max' => 500 ] ],
			'default'     => [ 'unit' => 'px', 'size' => 260 ],
			'description' => esc_html__( 'Only applies on desktop (≥ 960 px).', 'trs-kit' ),
			'selectors'   => [ '{{WRAPPER}} .trs-steps-with-image' => '--trs-swi-image-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'image_position', [
			'label'     => esc_html__( 'Focal Point', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'center top',
			'options'   => [
				'center top'    => esc_html__( 'Top', 'trs-kit' ),
				'center center' => esc_html__( 'Centre', 'trs-kit' ),
				'center bottom' => esc_html__( 'Bottom', 'trs-kit' ),
			],
			'selectors' => [ '{{WRAPPER}} .trs-swi-image' => 'object-position: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		// ── Style: Mobile ─────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_mobile', [
			'label' => esc_html__( 'Mobile', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'hide_image_mobile', [
			'label'     => esc_html__( 'Hide Image on Mobile', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'trs-kit' ),
			'label_off' => esc_html__( 'Show', 'trs-kit' ),
			'default'   => '',
		] );

		$this->add_control( 'unite_panels_mobile', [
			'label'       => esc_html__( 'Unite Step Panels on Mobile', 'trs-kit' ),
			'description' => esc_html__( 'Joins the two step panels into one continuous block instead of two separate cards.', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::SWITCHER,
			'label_on'    => esc_html__( 'Yes', 'trs-kit' ),
			'label_off'   => esc_html__( 'No', 'trs-kit' ),
			'default'     => '',
		] );

		$this->end_controls_section();
	}

	// -------------------------------------------------------------------------
	// Render
	// -------------------------------------------------------------------------

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$steps    = $settings['steps'] ?? [];

		if ( empty( $steps ) ) {
			return;
		}

		$count = count( $steps );

		// Use a pinned left-count when set so that removing the last repeater
		// item always removes from the right panel — no steps jump visually.
		$pinned_left = isset( $settings['left_panel_count'] ) && '' !== $settings['left_panel_count']
			? max( 1, min( (int) $settings['left_panel_count'], $count - 1 ) )
			: (int) ceil( $count / 2 );

		$left_steps  = array_slice( $steps, 0, $pinned_left );
		$right_steps = array_slice( $steps, $pinned_left );

		$image_url = ! empty( $settings['image']['url'] ) ? esc_url( $settings['image']['url'] ) : '';
		$image_id  = ! empty( $settings['image']['id'] ) ? (int) $settings['image']['id'] : 0;
		$image_alt = ! empty( $settings['image_alt'] ) ? esc_attr( $settings['image_alt'] ) : '';

		$wrapper_classes = [ 'trs-steps-with-image' ];

		if ( 'yes' === ( $settings['hide_image_mobile'] ?? '' ) ) {
			$wrapper_classes[] = 'trs-swi--hide-image-mobile';
		}

		if ( 'yes' === ( $settings['unite_panels_mobile'] ?? '' ) ) {
			$wrapper_classes[] = 'trs-swi--united-mobile';
		}

		printf( '<div class="%s">', esc_attr( implode( ' ', $wrapper_classes ) ) );

		// ── Left panel ──────────────────────────────────────────────────────
		echo '<div class="trs-swi-panel trs-swi-panel--left">';
		$this->render_steps( $left_steps );
		echo '</div>';

		// ── Center image ────────────────────────────────────────────────────
		echo '<div class="trs-swi-image-wrap">';
		if ( $image_id ) {
			echo wp_get_attachment_image(
				$image_id,
				'large',
				false,
				[
					'class'   => 'trs-swi-image',
					'loading' => 'lazy',
					'alt'     => $image_alt,
				]
			);
		} elseif ( $image_url ) {
			printf(
				'<img src="%s" alt="%s" class="trs-swi-image" loading="lazy" />',
				$image_url,
				$image_alt
			);
		}
		echo '</div>';

		// ── Right panel (always rendered to preserve grid) ──────────────────
		echo '<div class="trs-swi-panel trs-swi-panel--right">';
		if ( ! empty( $right_steps ) ) {
			$this->render_steps( $right_steps );
		}
		echo '</div>';

		echo '</div>'; // .trs-steps-with-image
	}

	/**
	 * Outputs the step rows (icon + text) for one panel, with dividers in between.
	 *
	 * @param array $steps Slice of the repeater items.
	 */
	private function render_steps( array $steps ): void {
		$total = count( $steps );

		foreach ( $steps as $index => $step ) {
			printf(
				'<div class="trs-swi-step elementor-repeater-item-%s">',
				esc_attr( $step['_id'] )
			);

			echo '<div class="trs-swi-step-inner">';

			echo '<div class="trs-swi-icon-wrap" aria-hidden="true">';
			\Elementor\Icons_Manager::render_icon( $step['icon'], [ 'aria-hidden' => 'true' ] );
			echo '</div>';

			echo '<div class="trs-swi-step-content">';

			if ( ! empty( $step['title'] ) ) {
				echo '<p class="trs-swi-title">' . esc_html( $step['title'] ) . '</p>';
			}

			if ( ! empty( $step['description'] ) ) {
				echo '<p class="trs-swi-description">' . esc_html( $step['description'] ) . '</p>';
			}

			echo '</div>'; // .trs-swi-step-content
			echo '</div>'; // .trs-swi-step-inner
			echo '</div>'; // .trs-swi-step

			if ( $index < $total - 1 ) {
				echo '<hr class="trs-swi-divider" aria-hidden="true" />';
			}
		}
	}
}
