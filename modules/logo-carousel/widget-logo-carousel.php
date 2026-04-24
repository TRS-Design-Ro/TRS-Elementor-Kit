<?php
/**
 * Logo Carousel widget.
 *
 * Infinite marquee-style logo strip with configurable speed, direction,
 * items-per-view, and gradient edge-fade effect.
 *
 * @package TRS_Kit
 */

namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TRS_Widget_Logo_Carousel
 */
class TRS_Widget_Logo_Carousel extends \Elementor\Widget_Base {

	public function get_name(): string        { return 'trs-logo-carousel'; }
	public function get_title(): string       { return esc_html__( 'Logo Carousel', 'trs-kit' ); }
	public function get_icon(): string        { return 'eicon-carousel'; }
	public function get_categories(): array   { return [ 'trs-kit' ]; }
	public function get_style_depends(): array  { return [ 'trs-logo-carousel' ]; }
	public function get_script_depends(): array { return [ 'trs-logo-carousel' ]; }

	// -------------------------------------------------------------------------
	// Controls
	// -------------------------------------------------------------------------

	protected function register_controls(): void {

		// ── Content: Logos ─────────────────────────────────────────────────────

		$this->start_controls_section( 'section_logos', [
			'label' => esc_html__( 'Logos', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'logo_image', [
			'label'   => esc_html__( 'Image', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$repeater->add_control( 'logo_alt', [
			'label'       => esc_html__( 'Alt Text', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'Company name', 'trs-kit' ),
		] );

		$repeater->add_control( 'logo_link', [
			'label'         => esc_html__( 'Link', 'trs-kit' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'show_external' => true,
			'default'       => [ 'url' => '' ],
		] );

		$this->add_control( 'logos', [
			'label'       => esc_html__( 'Logos', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[ 'logo_alt' => 'FocalPoint' ],
				[ 'logo_alt' => 'Screentime' ],
				[ 'logo_alt' => 'FeatherDev' ],
				[ 'logo_alt' => 'Company' ],
				[ 'logo_alt' => 'Partner' ],
			],
			'title_field' => '{{{ logo_alt ? logo_alt : "Logo" }}}',
		] );

		$this->end_controls_section();

		// ── Content: Settings ──────────────────────────────────────────────────

		$this->start_controls_section( 'section_settings', [
			'label' => esc_html__( 'Settings', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'autoplay', [
			'label'        => esc_html__( 'Auto-play', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'trs-kit' ),
			'label_off'    => esc_html__( 'No', 'trs-kit' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'autoplay_speed', [
			'label'      => esc_html__( 'Speed (seconds per loop)', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 's' ],
			'range'      => [ 's' => [ 'min' => 5, 'max' => 120, 'step' => 1 ] ],
			'default'    => [ 'unit' => 's', 'size' => 30 ],
			'condition'  => [ 'autoplay' => 'yes' ],
			'selectors'  => [ '{{WRAPPER}} .trs-logo-carousel' => '--trs-lc-speed: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'pause_on_hover', [
			'label'        => esc_html__( 'Pause on Hover', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'trs-kit' ),
			'label_off'    => esc_html__( 'No', 'trs-kit' ),
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'direction', [
			'label'     => esc_html__( 'Direction', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'options'   => [
				'left'  => esc_html__( 'Left (default)', 'trs-kit' ),
				'right' => esc_html__( 'Right (reverse)', 'trs-kit' ),
			],
			'default'   => 'left',
			'condition' => [ 'autoplay' => 'yes' ],
		] );

		$this->end_controls_section();

		// ── Style: Carousel ────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_carousel', [
			'label' => esc_html__( 'Carousel', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'items_per_view', [
			'label'          => esc_html__( 'Items in View', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::NUMBER,
			'min'            => 1,
			'max'            => 12,
			'step'           => 0.5,
			'default'        => 5,
			'tablet_default' => 3,
			'mobile_default' => 2,
			'selectors'      => [ '{{WRAPPER}} .trs-logo-carousel' => '--trs-lc-items: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'items_gap', [
			'label'          => esc_html__( 'Gap Between Items', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
			'default'        => [ 'unit' => 'px', 'size' => 48 ],
			'tablet_default' => [ 'unit' => 'px', 'size' => 32 ],
			'mobile_default' => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'      => [ '{{WRAPPER}} .trs-logo-carousel' => '--trs-lc-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_height', [
			'label'          => esc_html__( 'Logo Height', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 16, 'max' => 150 ] ],
			'default'        => [ 'unit' => 'px', 'size' => 48 ],
			'tablet_default' => [ 'unit' => 'px', 'size' => 40 ],
			'mobile_default' => [ 'unit' => 'px', 'size' => 32 ],
			'selectors'      => [ '{{WRAPPER}} .trs-lc-item img' => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'fade_color', [
			'label'     => esc_html__( 'Edge Fade Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-logo-carousel' => '--trs-lc-fade: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'fade_width', [
			'label'          => esc_html__( 'Fade Width', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', '%' ],
			'range'          => [
				'px' => [ 'min' => 0, 'max' => 300 ],
				'%'  => [ 'min' => 0, 'max' => 30 ],
			],
			'default'        => [ 'unit' => 'px', 'size' => 120 ],
			'tablet_default' => [ 'unit' => 'px', 'size' => 80 ],
			'mobile_default' => [ 'unit' => 'px', 'size' => 60 ],
			'selectors'      => [ '{{WRAPPER}} .trs-logo-carousel' => '--trs-lc-fade-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ── Style: Logo Items ──────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_items', [
			'label' => esc_html__( 'Logo Items', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->start_controls_tabs( 'logo_style_tabs' );

		// Normal state

		$this->start_controls_tab( 'logo_tab_normal', [
			'label' => esc_html__( 'Normal', 'trs-kit' ),
		] );

		$this->add_control( 'logo_opacity', [
			'label'     => esc_html__( 'Opacity', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ] ],
			'default'   => [ 'size' => 1 ],
			'selectors' => [ '{{WRAPPER}} .trs-lc-item img' => 'opacity: {{SIZE}};' ],
		] );

		$this->add_control( 'logo_grayscale', [
			'label'     => esc_html__( 'Greyscale (%)', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'   => [ 'size' => 0 ],
			'selectors' => [ '{{WRAPPER}} .trs-lc-item img' => 'filter: grayscale({{SIZE}}%);' ],
		] );

		$this->end_controls_tab();

		// Hover state

		$this->start_controls_tab( 'logo_tab_hover', [
			'label' => esc_html__( 'Hover', 'trs-kit' ),
		] );

		$this->add_control( 'logo_opacity_hover', [
			'label'     => esc_html__( 'Opacity', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ] ],
			'default'   => [ 'size' => 1 ],
			'selectors' => [ '{{WRAPPER}} .trs-lc-item:hover img' => 'opacity: {{SIZE}};' ],
		] );

		$this->add_control( 'logo_grayscale_hover', [
			'label'     => esc_html__( 'Greyscale on Hover (%)', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'   => [ 'size' => 0 ],
			'selectors' => [ '{{WRAPPER}} .trs-lc-item:hover img' => 'filter: grayscale({{SIZE}}%);' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	// -------------------------------------------------------------------------
	// Render
	// -------------------------------------------------------------------------

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['logos'] ) ) {
			return;
		}

		$autoplay       = 'yes' === ( $settings['autoplay'] ?? 'yes' );
		$pause_on_hover = 'yes' === ( $settings['pause_on_hover'] ?? 'yes' );
		$direction      = $settings['direction'] ?? 'left';

		$classes = [ 'trs-logo-carousel' ];
		if ( $autoplay ) {
			$classes[] = 'trs-lc--autoplay';
			if ( $pause_on_hover ) {
				$classes[] = 'trs-lc--pause-on-hover';
			}
			if ( 'right' === $direction ) {
				$classes[] = 'trs-lc--rtl';
			}
		}

		printf( '<div class="%s">', esc_attr( implode( ' ', $classes ) ) );
		echo '<div class="trs-lc-viewport">';
		echo '<div class="trs-lc-track">';

		foreach ( $settings['logos'] as $logo ) {
			if ( empty( $logo['logo_image']['url'] ) ) {
				continue;
			}

			$has_link = ! empty( $logo['logo_link']['url'] );

			printf(
				'<div class="trs-lc-item elementor-repeater-item-%s">',
				esc_attr( $logo['_id'] )
			);

			if ( $has_link ) {
				printf(
					'<a href="%s"%s%s class="trs-lc-link">',
					esc_url( $logo['logo_link']['url'] ),
					! empty( $logo['logo_link']['is_external'] ) ? ' target="_blank"' : '',
					! empty( $logo['logo_link']['nofollow'] ) ? ' rel="nofollow"' : ''
				);
			}

			printf(
				'<img src="%s" alt="%s" loading="lazy">',
				esc_url( $logo['logo_image']['url'] ),
				esc_attr( $logo['logo_alt'] ?? '' )
			);

			if ( $has_link ) {
				echo '</a>';
			}

			echo '</div>'; // .trs-lc-item
		}

		echo '</div>'; // .trs-lc-track
		echo '</div>'; // .trs-lc-viewport
		echo '</div>'; // .trs-logo-carousel
	}
}
