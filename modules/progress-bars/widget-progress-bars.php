<?php
/**
 * Progress Bars widget.
 *
 * @package TRS_Kit
 */
namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TRS_Widget_Progress_Bars extends \Elementor\Widget_Base {

	public function get_name(): string { return 'trs-progress-bars'; }
	public function get_title(): string { return esc_html__( 'Progress Bars', 'trs-kit' ); }
	public function get_icon(): string { return 'eicon-skill-bar'; }
	public function get_categories(): array { return [ 'trs-kit' ]; }
	public function get_style_depends(): array { return [ 'trs-progress-bars' ]; }
	public function get_script_depends(): array { return [ 'trs-progress-bars' ]; }

	protected function register_controls(): void {
		$this->start_controls_section( 'section_content', [
			'label' => esc_html__( 'Content', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'step_number', [
			'label'       => esc_html__( 'Number', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '01',
			'label_block' => false,
		] );

		$repeater->add_control( 'number_shape', [
			'label'   => esc_html__( 'Number Shape', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => $this->get_shape_options(),
			'default' => 'circle',
		] );

		$repeater->add_control( 'step_heading', [
			'label'       => esc_html__( 'Heading', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Access your opportunities', 'trs-kit' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'progress_icon', [
			'label'   => esc_html__( 'Progress Icon', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => [
				'value'   => 'fas fa-arrow-right',
				'library' => 'fa-solid',
			],
		] );

		$repeater->add_control( 'icon_shape', [
			'label'   => esc_html__( 'Icon Shape', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => $this->get_shape_options(),
			'default' => 'circle',
		] );

		$repeater->add_control( 'use_custom_progress', [
			'label'        => esc_html__( 'Custom Progress', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'trs-kit' ),
			'label_off'    => esc_html__( 'No', 'trs-kit' ),
			'return_value' => 'yes',
			'default'      => '',
		] );

		$repeater->add_control( 'step_progress', [
			'label'      => esc_html__( 'Progress (%)', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'size' => 45, 'unit' => '%' ],
			'condition'  => [ 'use_custom_progress' => 'yes' ],
		] );

		$this->add_control( 'steps', [
			'label'       => esc_html__( 'Steps', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ step_number }}} - {{{ step_heading }}}',
			'default'     => [
				[
					'step_number' => '01',
					'step_heading'=> esc_html__( 'Access www.recrimco.ro/joburi', 'trs-kit' ),
				],
				[
					'step_number' => '02',
					'step_heading'=> esc_html__( 'Find our job opportunities', 'trs-kit' ),
				],
				[
					'step_number' => '03',
					'step_heading'=> esc_html__( 'Apply for an available position', 'trs-kit' ),
				],
				[
					'step_number' => '04',
					'step_heading'=> esc_html__( 'Start your perfect job!', 'trs-kit' ),
				],
			],
		] );

		$this->add_control( 'auto_progress_heading', [
			'label'     => esc_html__( 'Automatic Progress Distribution', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'progress_start', [
			'label'      => esc_html__( 'Start (%)', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'size' => 45, 'unit' => '%' ],
		] );

		$this->add_control( 'progress_end', [
			'label'      => esc_html__( 'End (%)', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'size' => 100, 'unit' => '%' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_layout', [
			'label' => esc_html__( 'Layout', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'step_gap', [
			'label'          => esc_html__( 'Step Gap', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', 'rem' ],
			'range'          => [
				'px'  => [ 'min' => 0, 'max' => 160 ],
				'rem' => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
			],
			'default'        => [ 'size' => 28, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 24, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'      => [ '{{WRAPPER}} .trs-progress-bars' => '--trs-pb-step-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'content_gap', [
			'label'      => esc_html__( 'Number/Heading Gap', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'size' => 26, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-pb-head' => 'column-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'content_bottom_spacing', [
			'label'      => esc_html__( 'Spacing Above Line', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-pb-head' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_number', [
			'label' => esc_html__( 'Number', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'number_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-pb-number' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'number_background_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-pb-number' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'number_border_color', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-pb-number' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'number_border_width', [
			'label'      => esc_html__( 'Border Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 12 ] ],
			'default'    => [ 'size' => 2, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-pb-number' => 'border-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'number_size', [
			'label'      => esc_html__( 'Shape Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 34, 'max' => 180 ] ],
			'default'    => [ 'size' => 58, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-pb-number' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .trs-pb-number',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'number_box_shadow',
				'selector' => '{{WRAPPER}} .trs-pb-number',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_heading', [
			'label' => esc_html__( 'Heading', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-pb-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .trs-pb-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_progress', [
			'label' => esc_html__( 'Progress Bar', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'line_color', [
			'label'     => esc_html__( 'Line Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#A3A3A3',
			'selectors' => [ '{{WRAPPER}} .trs-pb-line' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'line_fill_color', [
			'label'     => esc_html__( 'Fill Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#E67E22',
			'selectors' => [ '{{WRAPPER}} .trs-pb-fill' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'line_thickness', [
			'label'      => esc_html__( 'Thickness', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1, 'max' => 16 ] ],
			'default'    => [ 'size' => 2, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-pb-line' => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'line_round_ends', [
			'label'        => esc_html__( 'Round Ends', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'trs-kit' ),
			'label_off'    => esc_html__( 'No', 'trs-kit' ),
			'return_value' => 'yes',
			'default'      => '',
			'prefix_class' => 'trs-pb-round-ends-',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_icon', [
			'label' => esc_html__( 'Progress Icon', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'icon_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-pb-icon' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_background_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#E67E22',
			'selectors' => [ '{{WRAPPER}} .trs-pb-icon-wrap' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_border_color', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#E67E22',
			'selectors' => [ '{{WRAPPER}} .trs-pb-icon-wrap' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'icon_border_width', [
			'label'      => esc_html__( 'Border Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 12 ] ],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-pb-icon-wrap' => 'border-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Icon Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 72 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-pb-icon' => '--trs-pb-icon-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trs-pb-icon i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
				'{{WRAPPER}} .trs-pb-icon svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
				'{{WRAPPER}} .trs-pb-icon .e-font-icon-svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
			],
		] );

		$this->add_responsive_control( 'icon_container_size', [
			'label'      => esc_html__( 'Shape Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 28, 'max' => 160 ] ],
			'default'    => [ 'size' => 44, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-pb-icon-wrap' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_box_shadow',
				'selector' => '{{WRAPPER}} .trs-pb-icon-wrap',
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

		$steps_count = count( $steps );
		$start       = isset( $settings['progress_start']['size'] ) ? (float) $settings['progress_start']['size'] : 45;
		$end         = isset( $settings['progress_end']['size'] ) ? (float) $settings['progress_end']['size'] : 100;

		if ( $end < $start ) {
			$end = $start;
		}
		?>
		<div class="trs-progress-bars">
			<?php foreach ( $steps as $index => $step ) : ?>
				<?php
				$auto_progress = $this->get_auto_progress( $index, $steps_count, $start, $end );
				$progress      = $auto_progress;

				if ( 'yes' === ( $step['use_custom_progress'] ?? '' ) && isset( $step['step_progress']['size'] ) ) {
					$progress = (float) $step['step_progress']['size'];
				}

				$progress       = max( 0, min( 100, $progress ) );
				$content_offset = max( 0, min( 70, $progress - 35 ) );
				$number         = ! empty( $step['step_number'] ) ? $step['step_number'] : sprintf( '%02d', $index + 1 );
				$number_shape   = $this->get_shape_class( $step['number_shape'] ?? 'circle' );
				$icon_shape     = $this->get_shape_class( $step['icon_shape'] ?? 'circle' );
				?>
				<article class="trs-pb-step elementor-repeater-item-<?php echo esc_attr( $step['_id'] ); ?>" style="--trs-pb-progress: <?php echo esc_attr( $progress ); ?>%; --trs-pb-offset: <?php echo esc_attr( $content_offset ); ?>%;">
					<div class="trs-pb-head">
						<div class="trs-pb-number <?php echo esc_attr( $number_shape ); ?>">
							<?php echo esc_html( $number ); ?>
						</div>
						<?php if ( ! empty( $step['step_heading'] ) ) : ?>
							<h3 class="trs-pb-title"><?php echo esc_html( $step['step_heading'] ); ?></h3>
						<?php endif; ?>
					</div>
					<div class="trs-pb-line-wrap">
						<div class="trs-pb-line" aria-hidden="true">
							<span class="trs-pb-fill"></span>
						</div>
						<div class="trs-pb-icon-wrap <?php echo esc_attr( $icon_shape ); ?>">
							<span class="trs-pb-icon" aria-hidden="true">
								<?php
								if ( ! empty( $step['progress_icon'] ) ) {
									\Elementor\Icons_Manager::render_icon( $step['progress_icon'], [ 'aria-hidden' => 'true' ] );
								}
								?>
							</span>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}

	private function get_shape_options(): array {
		return [
			'circle'  => esc_html__( 'Circle', 'trs-kit' ),
			'square'  => esc_html__( 'Square', 'trs-kit' ),
			'rounded' => esc_html__( 'Rounded Square', 'trs-kit' ),
			'diamond' => esc_html__( 'Diamond', 'trs-kit' ),
			'star'    => esc_html__( 'Star', 'trs-kit' ),
			'hexagon' => esc_html__( 'Hexagon', 'trs-kit' ),
		];
	}

	private function get_shape_class( string $shape ): string {
		$shape = sanitize_key( $shape );
		$map   = [
			'circle'  => 'trs-pb-shape-circle',
			'square'  => 'trs-pb-shape-square',
			'rounded' => 'trs-pb-shape-rounded',
			'diamond' => 'trs-pb-shape-diamond',
			'star'    => 'trs-pb-shape-star',
			'hexagon' => 'trs-pb-shape-hexagon',
		];

		return $map[ $shape ] ?? $map['circle'];
	}

	private function get_auto_progress( int $index, int $count, float $start, float $end ): float {
		if ( $count <= 1 ) {
			return $end;
		}

		$ratio = $index / ( $count - 1 );
		return $start + ( ( $end - $start ) * $ratio );
	}
}
