<?php
/**
 * Services Carousel widget.
 *
 * @package TRS_Kit
 */

namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TRS_Widget_Services_Carousel
 *
 * Horizontal drag-to-scroll carousel of service cards. Each card holds an
 * icon, title, description, and a CTA link button.
 */
class TRS_Widget_Services_Carousel extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'trs-services-carousel';
	}

	public function get_title(): string {
		return esc_html__( 'Services Carousel', 'trs-kit' );
	}

	public function get_icon(): string {
		return 'eicon-carousel';
	}

	public function get_categories(): array {
		return [ 'trs-kit' ];
	}

	public function get_style_depends(): array {
		return [ 'trs-services-carousel' ];
	}

	public function get_script_depends(): array {
		return [ 'trs-services-carousel' ];
	}

	// -------------------------------------------------------------------------
	// Controls
	// -------------------------------------------------------------------------

	protected function register_controls(): void {

		// ── Content: Items ────────────────────────────────────────────────────

		$this->start_controls_section( 'section_items', [
			'label' => esc_html__( 'Items', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'icon', [
			'label'   => esc_html__( 'Icon', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => [
				'value'   => 'fas fa-users',
				'library' => 'fa-solid',
			],
		] );

		$repeater->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Service Title', 'trs-kit' ),
		] );

		$repeater->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Describe this service in a few sentences.', 'trs-kit' ),
		] );

		$repeater->add_control( 'cta_text', [
			'label'   => esc_html__( 'Button Text', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Learn more', 'trs-kit' ),
		] );

		$repeater->add_control( 'cta_url', [
			'label'         => esc_html__( 'Button URL', 'trs-kit' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'placeholder'   => esc_html__( 'https://your-link.com', 'trs-kit' ),
			'show_external' => true,
			'default'       => [ 'url' => '' ],
		] );

		$this->add_control( 'items', [
			'label'       => esc_html__( 'Items', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'title'       => esc_html__( 'High-Volume Recruitment', 'trs-kit' ),
					'description' => esc_html__( 'We find the right drivers and warehouse staff for your exact needs. We filter out the noise and only send you people who are ready to work.', 'trs-kit' ),
					'cta_text'    => esc_html__( 'See how we recruit', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-users', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Complete Administration', 'trs-kit' ),
					'description' => esc_html__( 'Forget the legal headaches. We handle the contracts, work permits, and all the administrative heavy lifting long before day one.', 'trs-kit' ),
					'cta_text'    => esc_html__( 'Explore admin services', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-file-alt', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Dedicated Worker Support', 'trs-kit' ),
					'description' => esc_html__( 'Moving to a new country is hard. We provide your workers with real human support to solve their problems fast so they stay focused on the job.', 'trs-kit' ),
					'cta_text'    => esc_html__( 'View our support system', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-comments', 'library' => 'fa-solid' ],
				],
				[
					'title'       => esc_html__( 'Active Retention Management', 'trs-kit' ),
					'description' => esc_html__( 'Hiring is expensive; keeping people saves money. We actively manage your team to keep morale high and turnover incredibly low.', 'trs-kit' ),
					'cta_text'    => esc_html__( 'Stop your turnover', 'trs-kit' ),
					'icon'        => [ 'value' => 'fas fa-crown', 'library' => 'fa-solid' ],
				],
			],
			'title_field' => '{{{ title }}}',
		] );

		$this->end_controls_section();

		// ── Style: Card ───────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_card', [
			'label' => esc_html__( 'Card', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#f8f7f2',
			'selectors' => [
				'{{WRAPPER}} .trs-sc-card'         => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .trs-services-carousel' => '--trs-sc-card-bg: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'cards_per_view', [
			'label'          => esc_html__( 'Cards Visible', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::NUMBER,
			'min'            => 1,
			'max'            => 10,
			'step'           => 0.5,
			'default'        => 3.5,
			'tablet_default' => 2.5,
			'mobile_default' => 1.2,
			'description'    => esc_html__( 'Decimal values (e.g. 3.5) show a partial card to hint at overflow.', 'trs-kit' ),
			'selectors'      => [ '{{WRAPPER}} .trs-services-carousel' => '--trs-sc-cards: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'card_min_height', [
			'label'      => esc_html__( 'Minimum Height', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 800 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 390 ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-card' => 'min-height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', '%' ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_padding', [
			'label'      => esc_html__( 'Card Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'default'    => [
				'top'    => '24',
				'right'  => '24',
				'bottom' => '24',
				'left'   => '24',
				'unit'   => 'px',
			],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_gap', [
			'label'      => esc_html__( 'Gap Between Cards', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-services-carousel' => '--trs-sc-gap: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trs-sc-track'          => 'gap: {{SIZE}}{{UNIT}};',
			],
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
			'selectors' => [ '{{WRAPPER}} .trs-sc-icon-wrap' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_color', [
			'label'     => esc_html__( 'Icon Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [
				'{{WRAPPER}} .trs-sc-icon-wrap i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-sc-icon-wrap svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Icon Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-sc-icon-wrap i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trs-sc-icon-wrap svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'icon_wrap_size', [
			'label'      => esc_html__( 'Container Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'default'    => [ 'unit' => 'px', 'size' => 48 ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
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
			'selectors' => [ '{{WRAPPER}} .trs-sc-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .trs-sc-title',
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
			'selectors' => [ '{{WRAPPER}} .trs-sc-description' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .trs-sc-description',
			]
		);

		$this->end_controls_section();

		// ── Style: Button ─────────────────────────────────────────────────────

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
			'default'   => '#212121',
			'selectors' => [
				'{{WRAPPER}} .trs-sc-btn' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_text_color', [
			'label'     => esc_html__( 'Text Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .trs-sc-btn' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'button_tab_hover', [
			'label' => esc_html__( 'Hover', 'trs-kit' ),
		] );

		$this->add_control( 'button_bg_color_hover', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trs-sc-btn:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'button_text_color_hover', [
			'label'     => esc_html__( 'Text Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trs-sc-btn:hover' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'selector'  => '{{WRAPPER}} .trs-sc-btn',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	// -------------------------------------------------------------------------
	// Render
	// -------------------------------------------------------------------------

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['items'] ) ) {
			return;
		}

		echo '<div class="trs-services-carousel">';
		echo '<div class="trs-sc-track">';

		foreach ( $settings['items'] as $item ) {
			$url      = ! empty( $item['cta_url']['url'] ) ? esc_url( $item['cta_url']['url'] ) : '#';
			$target   = ! empty( $item['cta_url']['is_external'] ) ? ' target="_blank"' : '';
			$nofollow = ! empty( $item['cta_url']['nofollow'] ) ? ' rel="nofollow"' : '';

			printf(
				'<div class="trs-sc-card elementor-repeater-item-%s">',
				esc_attr( $item['_id'] )
			);

			// Icon
			echo '<div class="trs-sc-icon-wrap">';
			\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
			echo '</div>';

			// Card body
			echo '<div class="trs-sc-content">';
			echo '<div class="trs-sc-text">';

			if ( ! empty( $item['title'] ) ) {
				echo '<p class="trs-sc-title">' . esc_html( $item['title'] ) . '</p>';
			}

			if ( ! empty( $item['description'] ) ) {
				echo '<p class="trs-sc-description">' . esc_html( $item['description'] ) . '</p>';
			}

			echo '</div>'; // .trs-sc-text

			if ( ! empty( $item['cta_text'] ) ) {
				printf(
					'<a class="trs-sc-btn" href="%s"%s%s>',
					$url,
					$target,
					$nofollow
				);
				echo '<span>' . esc_html( $item['cta_text'] ) . '</span>';
				echo '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M2.625 7H11.375M11.375 7L7.875 3.5M11.375 7L7.875 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
				echo '</a>';
			}

			echo '</div>'; // .trs-sc-content
			echo '</div>'; // .trs-sc-card
		}

		echo '</div>'; // .trs-sc-track
		echo '</div>'; // .trs-services-carousel
	}
}
