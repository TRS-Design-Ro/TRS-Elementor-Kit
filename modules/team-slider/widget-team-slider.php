<?php
/**
 * Team Slider widget.
 *
 * Card-style circular slider that shows one large featured member (dark card,
 * portrait image, name, job title, description) alongside two smaller preview
 * cards (image + name only). Navigating animates the active card off to the
 * left while the next preview card grows into the active position.
 *
 * @package TRS_Kit
 */

namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TRS_Widget_Team_Slider
 */
class TRS_Widget_Team_Slider extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'trs-team-slider';
	}

	public function get_title(): string {
		return esc_html__( 'Team Slider', 'trs-kit' );
	}

	public function get_icon(): string {
		return 'eicon-person';
	}

	public function get_categories(): array {
		return [ 'trs-kit' ];
	}

	public function get_style_depends(): array {
		return [ 'trs-team-slider' ];
	}

	public function get_script_depends(): array {
		return [ 'trs-team-slider' ];
	}

	// -------------------------------------------------------------------------
	// Controls
	// -------------------------------------------------------------------------

	protected function register_controls(): void {

		// ── Content: Slides ───────────────────────────────────────────────────

		$this->start_controls_section( 'section_slides', [
			'label' => esc_html__( 'Slides', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'slide_image', [
			'label'   => esc_html__( 'Photo', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => '' ],
		] );

		$repeater->add_control( 'slide_image_alt', [
			'label'       => esc_html__( 'Photo Alt Text', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'placeholder' => esc_html__( 'Defaults to the member name', 'trs-kit' ),
		] );

		$repeater->add_control( 'slide_name', [
			'label'   => esc_html__( 'Name', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Jane Doe', 'trs-kit' ),
		] );

		$repeater->add_control( 'slide_job_title', [
			'label'   => esc_html__( 'Job Title', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'CEO', 'trs-kit' ),
		] );

		$repeater->add_control( 'slide_description', [
			'label'   => esc_html__( 'Description', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::WYSIWYG,
			'default' => esc_html__( 'Write a short bio or quote for this team member.', 'trs-kit' ),
		] );

		$this->add_control( 'slides', [
			'label'       => esc_html__( 'Team Members', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'slide_name'        => esc_html__( 'Jane Doe', 'trs-kit' ),
					'slide_job_title'   => esc_html__( 'CEO Recrimco', 'trs-kit' ),
					'slide_description' => esc_html__( '„Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ut aliquet nisl. Aliquam ultricies dui mauris, ac ultricies magna tempor quis. Etiam pellentesque fermentum eros id viverra.', 'trs-kit' ),
				],
				[
					'slide_name'        => esc_html__( 'Jessica Tan', 'trs-kit' ),
					'slide_job_title'   => esc_html__( 'Operations Manager', 'trs-kit' ),
					'slide_description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac nisi nec ex finibus posuere. Maecenas tempor dolor id odio gravida, quis egestas tellus fermentum.', 'trs-kit' ),
				],
				[
					'slide_name'        => esc_html__( 'John Doe', 'trs-kit' ),
					'slide_job_title'   => esc_html__( 'Head of Logistics', 'trs-kit' ),
					'slide_description' => esc_html__( 'Donec dignissim, felis et feugiat mattis, lacus metus ullamcorper enim, vitae ornare neque odio a neque. Nullam sit amet lacinia nisl.', 'trs-kit' ),
				],
			],
			'title_field' => '{{{ slide_name }}}',
		] );

		$this->end_controls_section();

		// ── Content: Auto-Play ────────────────────────────────────────────────

		$this->start_controls_section( 'section_autoplay', [
			'label' => esc_html__( 'Auto-Play', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'autoplay', [
			'label'   => esc_html__( 'Enable Auto-Play', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
		] );

		$this->add_control( 'autoplay_interval', [
			'label'      => esc_html__( 'Interval (seconds)', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::NUMBER,
			'min'        => 1,
			'max'        => 30,
			'step'       => 0.5,
			'default'    => 5,
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

		// ── Style: Layout ─────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_layout', [
			'label' => esc_html__( 'Layout', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'slide_height', [
			'label'      => esc_html__( 'Slide Height', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 300, 'max' => 900 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 655 ],
			'selectors'  => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-card-h: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'active_slide_width', [
			'label'      => esc_html__( 'Active Card Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 300, 'max' => 900 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 726 ],
			'selectors'  => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-active-w: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'preview_slide_width', [
			'label'      => esc_html__( 'Preview Card Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 120, 'max' => 450 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 305 ],
			'selectors'  => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-preview-w: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'slides_gap', [
			'label'      => esc_html__( 'Gap Between Cards', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'active_image_width', [
			'label'      => esc_html__( 'Active Image Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 80, 'max' => 400 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 214 ],
			'selectors'  => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-active-img-w: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_border_radius', [
			'label'      => esc_html__( 'Card Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-card-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_padding', [
			'label'      => esc_html__( 'Active Card Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 64 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-card-padding: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_inner_gap', [
			'label'      => esc_html__( 'Active Card Inner Gap', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 64 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 32 ],
			'selectors'  => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-card-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ── Style: Active Card ────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_card', [
			'label' => esc_html__( 'Active Card', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-card-bg: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		// ── Style: Name ───────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_name', [
			'label' => esc_html__( 'Name', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'active_name_color', [
			'label'     => esc_html__( 'Color (Active Card)', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .trs-ts-content .trs-ts-name' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'active_name_typography',
				'label'    => esc_html__( 'Typography (Active Card)', 'trs-kit' ),
				'selector' => '{{WRAPPER}} .trs-ts-content .trs-ts-name',
			]
		);

		$this->end_controls_section();

		// ── Style: Job Title ──────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_job_title', [
			'label' => esc_html__( 'Job Title', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'job_title_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255,255,255,0.65)',
			'selectors' => [ '{{WRAPPER}} .trs-ts-job-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'job_title_typography',
				'selector' => '{{WRAPPER}} .trs-ts-job-title',
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
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .trs-ts-description' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .trs-ts-description',
			]
		);

		$this->end_controls_section();

		// ── Style: Preview Name ───────────────────────────────────────────────

		$this->start_controls_section( 'section_style_preview_name', [
			'label' => esc_html__( 'Preview Name Label', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'preview_name_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-ts-preview-name' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'preview_name_typography',
				'selector' => '{{WRAPPER}} .trs-ts-preview-name',
			]
		);

		$this->add_responsive_control( 'preview_label_height', [
			'label'       => esc_html__( 'Label Area Height', 'trs-kit' ),
			'description' => esc_html__( 'Space reserved below the preview image for the name label.', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::SLIDER,
			'size_units'  => [ 'px' ],
			'range'       => [ 'px' => [ 'min' => 24, 'max' => 80 ] ],
			'default'     => [ 'unit' => 'px', 'size' => 44 ],
			'selectors'   => [ '{{WRAPPER}} .trs-team-slider' => '--trs-ts-label-h: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ── Style: Arrows ─────────────────────────────────────────────────────

		$this->start_controls_section( 'section_style_arrows', [
			'label' => esc_html__( 'Arrows', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->start_controls_tabs( 'tabs_arrow' );

		$this->start_controls_tab( 'tab_arrow_normal', [
			'label' => esc_html__( 'Normal', 'trs-kit' ),
		] );

		$this->add_control( 'arrow_bg_color', [
			'label'     => esc_html__( 'Background', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'transparent',
			'selectors' => [ '{{WRAPPER}} .trs-ts-arrow' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_border_color', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-ts-arrow' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_icon_color', [
			'label'     => esc_html__( 'Icon Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [
				'{{WRAPPER}} .trs-ts-arrow i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-ts-arrow svg' => 'fill: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_arrow_hover', [
			'label' => esc_html__( 'Hover', 'trs-kit' ),
		] );

		$this->add_control( 'arrow_bg_hover_color', [
			'label'     => esc_html__( 'Background', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-ts-arrow:hover, {{WRAPPER}} .trs-ts-arrow:focus-visible' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_border_hover_color', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-ts-arrow:hover, {{WRAPPER}} .trs-ts-arrow:focus-visible' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_icon_hover_color', [
			'label'     => esc_html__( 'Icon Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .trs-ts-arrow:hover i, {{WRAPPER}} .trs-ts-arrow:focus-visible i'     => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-ts-arrow:hover svg, {{WRAPPER}} .trs-ts-arrow:focus-visible svg' => 'fill: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control( 'arrow_divider', [
			'type' => \Elementor\Controls_Manager::DIVIDER,
		] );

		$this->add_responsive_control( 'arrow_size', [
			'label'      => esc_html__( 'Button Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 24, 'max' => 96 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 48 ],
			'selectors'  => [ '{{WRAPPER}} .trs-ts-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrow_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 36 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 18 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-ts-arrow i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trs-ts-arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'arrow_border_width', [
			'label'      => esc_html__( 'Border Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 5 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1.5 ],
			'selectors'  => [ '{{WRAPPER}} .trs-ts-arrow' => 'border-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrow_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'unit' => '%', 'size' => 50 ],
			'selectors'  => [ '{{WRAPPER}} .trs-ts-arrow' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrows_gap', [
			'label'      => esc_html__( 'Gap Between Arrows', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 32 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ '{{WRAPPER}} .trs-ts-nav' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrows_bottom_gap', [
			'label'      => esc_html__( 'Space Below Arrows', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .trs-ts-nav' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
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
		?>
		<div
			class="trs-team-slider"
			data-autoplay="<?php echo 'yes' === $settings['autoplay'] ? 'true' : 'false'; ?>"
			data-autoplay-interval="<?php echo esc_attr( (float) ( $settings['autoplay_interval'] ?? 5 ) ); ?>"
			data-autoplay-pause-hover="<?php echo 'yes' === ( $settings['autoplay_pause_on_hover'] ?? 'yes' ) ? 'true' : 'false'; ?>"
		>

			<div class="trs-ts-nav" role="group" aria-label="<?php esc_attr_e( 'Slider navigation', 'trs-kit' ); ?>">
				<button class="trs-ts-arrow trs-ts-arrow--prev" aria-label="<?php esc_attr_e( 'Previous member', 'trs-kit' ); ?>">
					<i class="eicon-chevron-left" aria-hidden="true"></i>
				</button>
				<button class="trs-ts-arrow trs-ts-arrow--next" aria-label="<?php esc_attr_e( 'Next member', 'trs-kit' ); ?>">
					<i class="eicon-chevron-right" aria-hidden="true"></i>
				</button>
			</div>

			<div class="trs-ts-viewport" aria-live="polite">
				<?php foreach ( $slides as $index => $slide ) : ?>
					<?php
					$img_id  = ! empty( $slide['slide_image']['id'] ) ? (int) $slide['slide_image']['id'] : 0;
					$img_url = ! empty( $slide['slide_image']['url'] ) ? esc_url( $slide['slide_image']['url'] ) : '';
					$img_alt = ! empty( $slide['slide_image_alt'] ) ? esc_attr( $slide['slide_image_alt'] ) : esc_attr( $slide['slide_name'] ?? '' );
					?>
					<div
						class="trs-ts-slide elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ); ?>"
						data-index="<?php echo (int) $index; ?>"
						role="group"
						aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d of %d', 'trs-kit' ), $index + 1, count( $slides ) ) ); ?>"
						aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>"
					>
						<div class="trs-ts-card">

							<div class="trs-ts-image-wrap">
								<?php if ( $img_id ) : ?>
									<?php echo wp_get_attachment_image( $img_id, 'large', false, [
										'class'   => 'trs-ts-image',
										'loading' => 'lazy',
										'alt'     => $img_alt,
									] ); ?>
								<?php elseif ( $img_url ) : ?>
									<img
										src="<?php echo $img_url; ?>"
										alt="<?php echo $img_alt; ?>"
										class="trs-ts-image"
										loading="lazy"
									>
								<?php endif; ?>
							</div>

							<div class="trs-ts-content" aria-hidden="true">
								<div class="trs-ts-meta">
									<?php if ( ! empty( $slide['slide_name'] ) ) : ?>
										<p class="trs-ts-name"><?php echo esc_html( $slide['slide_name'] ); ?></p>
									<?php endif; ?>
									<?php if ( ! empty( $slide['slide_job_title'] ) ) : ?>
										<p class="trs-ts-job-title"><?php echo esc_html( $slide['slide_job_title'] ); ?></p>
									<?php endif; ?>
								</div>
								<?php if ( ! empty( $slide['slide_description'] ) ) : ?>
									<div class="trs-ts-description">
										<?php echo wp_kses_post( $slide['slide_description'] ); ?>
									</div>
								<?php endif; ?>
							</div>

						</div>

						<?php if ( ! empty( $slide['slide_name'] ) ) : ?>
							<div class="trs-ts-preview-name" aria-hidden="true">
								<?php echo esc_html( $slide['slide_name'] ); ?>
							</div>
						<?php endif; ?>

					</div>
				<?php endforeach; ?>
			</div>

			<div class="trs-ts-dots" aria-hidden="true"></div>

		</div>
		<?php
	}
}
