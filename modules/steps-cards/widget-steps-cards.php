<?php
/**
 * Steps Cards widget.
 *
 * @package TRS_Kit
 */
namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TRS_Widget_Steps_Cards extends \Elementor\Widget_Base {

	public function get_name(): string { return 'trs-steps-cards'; }
	public function get_title(): string { return esc_html__( 'Steps Cards', 'trs-kit' ); }
	public function get_icon(): string { return 'eicon-time-line'; }
	public function get_categories(): array { return [ 'trs-kit' ]; }
	public function get_style_depends(): array { return [ 'trs-steps-cards' ]; }
	public function get_script_depends(): array { return [ 'trs-steps-cards' ]; }

	protected function register_controls(): void {
		$this->start_controls_section( 'section_content', [
			'label' => esc_html__( 'Content', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'step_icon', [
			'label'   => esc_html__( 'Icon', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => [
				'value'   => 'fas fa-check-circle',
				'library' => 'fa-solid',
			],
		] );

		$repeater->add_control( 'step_heading', [
			'label'       => esc_html__( 'Heading', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Initial Discovery', 'trs-kit' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'step_subheading', [
			'label'       => esc_html__( 'Subheading', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Step 01', 'trs-kit' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'step_description', [
			'label'   => esc_html__( 'Description', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Share your goals and requirements so the team can define the right strategy for your project.', 'trs-kit' ),
		] );

		$this->add_control( 'steps', [
			'label'       => esc_html__( 'Cards', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ step_subheading }}} - {{{ step_heading }}}',
			'default'     => [
				[
					'step_heading'    => esc_html__( 'Initial Discovery', 'trs-kit' ),
					'step_subheading' => esc_html__( 'Step 01', 'trs-kit' ),
					'step_description'=> esc_html__( 'Share your goals and requirements so the team can define the right strategy for your project.', 'trs-kit' ),
				],
				[
					'step_heading'    => esc_html__( 'Planning & Setup', 'trs-kit' ),
					'step_subheading' => esc_html__( 'Step 02', 'trs-kit' ),
					'step_description'=> esc_html__( 'A complete execution plan is prepared, including milestones, timelines, and communication flow.', 'trs-kit' ),
				],
				[
					'step_heading'    => esc_html__( 'Implementation', 'trs-kit' ),
					'step_subheading' => esc_html__( 'Step 03', 'trs-kit' ),
					'step_description'=> esc_html__( 'The approved plan is implemented with iterative reviews to keep quality and progress aligned.', 'trs-kit' ),
				],
				[
					'step_heading'    => esc_html__( 'Launch & Support', 'trs-kit' ),
					'step_subheading' => esc_html__( 'Step 04', 'trs-kit' ),
					'step_description'=> esc_html__( 'After launch, performance is monitored and support is provided for smooth long-term operation.', 'trs-kit' ),
				],
			],
		] );

		$this->add_responsive_control( 'columns', [
			'label'          => esc_html__( 'Cards Per Row', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::NUMBER,
			'min'            => 1,
			'max'            => 6,
			'default'        => 2,
			'tablet_default' => 2,
			'mobile_default' => 1,
			'selectors'      => [ '{{WRAPPER}} .trs-steps-cards' => '--trs-sc-columns: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'cards_gap', [
			'label'          => esc_html__( 'Cards Gap', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', 'rem' ],
			'range'          => [
				'px'  => [ 'min' => 0, 'max' => 80 ],
				'rem' => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ],
			],
			'default'        => [ 'size' => 24, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 20, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'      => [ '{{WRAPPER}} .trs-steps-cards' => '--trs-sc-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_cards', [
			'label' => esc_html__( 'Cards', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_background_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-sc-card' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'card_border_color', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#E8E8E8',
			'selectors' => [ '{{WRAPPER}} .trs-sc-card' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'card_border_width', [
			'label'      => esc_html__( 'Border Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
			'default'    => [ 'size' => 1, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-card' => 'border-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_padding', [
			'label'      => esc_html__( 'Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_content_spacing', [
			'label'      => esc_html__( 'Content Spacing', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 10, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-card' => 'row-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .trs-sc-card',
			]
		);

		$this->add_control( 'hover_state_heading', [
			'label' => esc_html__( 'Hover State', 'trs-kit' ),
			'type'  => \Elementor\Controls_Manager::HEADING,
		] );

		$this->add_control( 'card_hover_border_color', [
			'label'     => esc_html__( 'Hover Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trs-sc-card:hover' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_hover_box_shadow',
				'selector' => '{{WRAPPER}} .trs-sc-card:hover',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_icon', [
			'label' => esc_html__( 'Icon', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'icon_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#111111',
			'selectors' => [ '{{WRAPPER}} .trs-sc-icon' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_background_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#F4F4F4',
			'selectors' => [ '{{WRAPPER}} .trs-sc-icon-wrap' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 14, 'max' => 80 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-icon' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_box_size', [
			'label'      => esc_html__( 'Container Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 32, 'max' => 140 ] ],
			'default'    => [ 'size' => 56, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_box_radius', [
			'label'      => esc_html__( 'Container Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 14, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-icon-wrap' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_spacing_bottom', [
			'label'      => esc_html__( 'Spacing Below Icon', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-icon-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_heading', [
			'label' => esc_html__( 'Heading', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#111111',
			'selectors' => [ '{{WRAPPER}} .trs-sc-heading' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .trs-sc-heading',
			]
		);

		$this->add_responsive_control( 'heading_spacing_bottom', [
			'label'      => esc_html__( 'Spacing Below Heading', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 10, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_subheading', [
			'label' => esc_html__( 'Subheading', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'subheading_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#616161',
			'selectors' => [ '{{WRAPPER}} .trs-sc-subheading' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'subheading_typography',
				'selector' => '{{WRAPPER}} .trs-sc-subheading',
			]
		);

		$this->add_responsive_control( 'subheading_spacing_bottom', [
			'label'      => esc_html__( 'Spacing Below Subheading', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-sc-subheading' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_description', [
			'label' => esc_html__( 'Description', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#3A3A3A',
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
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$steps    = $settings['steps'] ?? [];

		if ( empty( $steps ) ) {
			return;
		}
		?>
		<div class="trs-steps-cards">
			<?php foreach ( $steps as $step ) : ?>
				<article class="trs-sc-card elementor-repeater-item-<?php echo esc_attr( $step['_id'] ); ?>">
					<div class="trs-sc-icon-wrap">
						<?php if ( ! empty( $step['step_icon'] ) ) : ?>
							<?php \Elementor\Icons_Manager::render_icon( $step['step_icon'], [ 'aria-hidden' => 'true', 'class' => 'trs-sc-icon' ] ); ?>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $step['step_heading'] ) ) : ?>
						<h3 class="trs-sc-heading"><?php echo esc_html( $step['step_heading'] ); ?></h3>
					<?php endif; ?>

					<?php if ( ! empty( $step['step_subheading'] ) ) : ?>
						<p class="trs-sc-subheading"><?php echo esc_html( $step['step_subheading'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $step['step_description'] ) ) : ?>
						<p class="trs-sc-description"><?php echo esc_html( $step['step_description'] ); ?></p>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
