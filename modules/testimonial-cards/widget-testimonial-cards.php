<?php
/**
 * Testimonial Cards widget.
 *
 * @package TRS_Kit
 */
namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TRS_Widget_Testimonial_Cards extends \Elementor\Widget_Base {

	public function get_name(): string { return 'trs-testimonial-cards'; }
	public function get_title(): string { return esc_html__( 'Testimonial Cards', 'trs-kit' ); }
	public function get_icon(): string { return 'eicon-testimonial'; }
	public function get_categories(): array { return [ 'trs-kit' ]; }
	public function get_style_depends(): array { return [ 'trs-testimonial-cards' ]; }
	public function get_script_depends(): array { return [ 'trs-testimonial-cards' ]; }

	protected function register_controls(): void {
		$this->start_controls_section( 'section_items', [
			'label' => esc_html__( 'Testimonials', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'author_image', [
			'label'   => esc_html__( 'Author Image', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$repeater->add_control( 'author_name', [
			'label'   => esc_html__( 'Name', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Jane Doe', 'trs-kit' ),
		] );

		$repeater->add_control( 'author_title', [
			'label'   => esc_html__( 'Job Title', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'CEO, Recrimco', 'trs-kit' ),
		] );

		$repeater->add_control( 'review_text', [
			'label'   => esc_html__( 'Review', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer feugiat sapien sed enim cursus, non varius mauris commodo.', 'trs-kit' ),
		] );

		$this->add_control( 'testimonials', [
			'label'       => esc_html__( 'Items', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ author_name }}}',
			'default'     => [
				[
					'author_name'  => esc_html__( 'Jane Doe', 'trs-kit' ),
					'author_title' => esc_html__( 'Founder', 'trs-kit' ),
				],
				[
					'author_name'  => esc_html__( 'Alex Carter', 'trs-kit' ),
					'author_title' => esc_html__( 'Operations Lead', 'trs-kit' ),
				],
				[
					'author_name'  => esc_html__( 'Emily Clark', 'trs-kit' ),
					'author_title' => esc_html__( 'HR Director', 'trs-kit' ),
				],
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_settings', [
			'label' => esc_html__( 'Settings', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'rows', [
			'label'   => esc_html__( 'Rows', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'min'     => 1,
			'max'     => 4,
			'default' => 2,
		] );

		$this->add_control( 'enable_animation', [
			'label'        => esc_html__( 'Enable Animation', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'direction', [
			'label'     => esc_html__( 'Direction', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'left',
			'options'   => [
				'left'  => esc_html__( 'Right to Left', 'trs-kit' ),
				'right' => esc_html__( 'Left to Right', 'trs-kit' ),
			],
			'condition' => [ 'enable_animation' => 'yes' ],
		] );

		$this->add_control( 'row_1_direction', [
			'label'     => esc_html__( 'Row 1 Direction', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'left',
			'options'   => [
				'left'  => esc_html__( 'Right to Left', 'trs-kit' ),
				'right' => esc_html__( 'Left to Right', 'trs-kit' ),
			],
			'condition' => [ 'enable_animation' => 'yes' ],
		] );

		$this->add_control( 'row_2_direction', [
			'label'     => esc_html__( 'Row 2 Direction', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'right',
			'options'   => [
				'left'  => esc_html__( 'Right to Left', 'trs-kit' ),
				'right' => esc_html__( 'Left to Right', 'trs-kit' ),
			],
			'condition' => [ 'enable_animation' => 'yes' ],
		] );

		$this->add_control( 'row_3_direction', [
			'label'     => esc_html__( 'Row 3 Direction', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'left',
			'options'   => [
				'left'  => esc_html__( 'Right to Left', 'trs-kit' ),
				'right' => esc_html__( 'Left to Right', 'trs-kit' ),
			],
			'condition' => [ 'enable_animation' => 'yes' ],
		] );

		$this->add_control( 'row_4_direction', [
			'label'     => esc_html__( 'Row 4 Direction', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'right',
			'options'   => [
				'left'  => esc_html__( 'Right to Left', 'trs-kit' ),
				'right' => esc_html__( 'Left to Right', 'trs-kit' ),
			],
			'condition' => [ 'enable_animation' => 'yes' ],
		] );

		$this->add_control( 'pause_on_hover', [
			'label'        => esc_html__( 'Pause on Hover', 'trs-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [ 'enable_animation' => 'yes' ],
		] );

		$this->add_control( 'animation_speed', [
			'label'      => esc_html__( 'Animation Speed (seconds)', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 's' ],
			'range'      => [ 's' => [ 'min' => 8, 'max' => 120, 'step' => 1 ] ],
			'default'    => [ 'size' => 36, 'unit' => 's' ],
			'selectors'  => [ '{{WRAPPER}} .trs-testimonial-cards' => '--trs-tc-speed: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'enable_animation' => 'yes' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_card', [
			'label' => esc_html__( 'Cards', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'cards_gap_horizontal', [
			'label'          => esc_html__( 'Horizontal Gap', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'        => [ 'size' => 24, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 18, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 14, 'unit' => 'px' ],
			'selectors'      => [ '{{WRAPPER}} .trs-testimonial-cards' => '--trs-tc-gap-x: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'cards_gap_vertical', [
			'label'          => esc_html__( 'Vertical Gap', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'        => [ 'size' => 24, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 18, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 14, 'unit' => 'px' ],
			'selectors'      => [ '{{WRAPPER}} .trs-testimonial-cards' => '--trs-tc-gap-y: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_width', [
			'label'          => esc_html__( 'Card Width', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', '%' ],
			'range'          => [
				'px' => [ 'min' => 220, 'max' => 700 ],
				'%'  => [ 'min' => 40, 'max' => 100 ],
			],
			'default'        => [ 'size' => 380, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 330, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 100, 'unit' => '%' ],
			'selectors'      => [ '{{WRAPPER}} .trs-testimonial-cards' => '--trs-tc-card-w: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_height', [
			'label'      => esc_html__( 'Card Min Height', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 180, 'max' => 700 ] ],
			'default'    => [ 'size' => 240, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-tc-card' => 'min-height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'card_bg_color', [
			'label'     => esc_html__( 'Card Background', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .trs-tc-card' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'card_border_color', [
			'label'     => esc_html__( 'Card Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trs-tc-card' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'card_radius', [
			'label'      => esc_html__( 'Card Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-tc-card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .trs-tc-card',
			]
		);

		$this->add_control( 'fade_color', [
			'label'     => esc_html__( 'Edge Fade Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#F6F6F6',
			'selectors' => [ '{{WRAPPER}} .trs-testimonial-cards' => '--trs-tc-fade: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'fade_width', [
			'label'      => esc_html__( 'Edge Fade Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 260 ],
				'%'  => [ 'min' => 0, 'max' => 30 ],
			],
			'default'    => [ 'size' => 100, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-testimonial-cards' => '--trs-tc-fade-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'fade_spread', [
			'label'      => esc_html__( 'Fade Spread', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [
				'%' => [ 'min' => 10, 'max' => 100, 'step' => 1 ],
			],
			'default'    => [ 'size' => 100, 'unit' => '%' ],
			'selectors'  => [ '{{WRAPPER}} .trs-testimonial-cards' => '--trs-tc-fade-spread: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_typography', [
			'label' => esc_html__( 'Typography', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'name_color', [
			'label'     => esc_html__( 'Name Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [ '{{WRAPPER}} .trs-tc-name' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'name_typography',
			'selector' => '{{WRAPPER}} .trs-tc-name',
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Job Title Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6D6D6D',
			'selectors' => [ '{{WRAPPER}} .trs-tc-title' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .trs-tc-title',
		] );

		$this->add_control( 'review_color', [
			'label'     => esc_html__( 'Review Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#3F3F3F',
			'selectors' => [ '{{WRAPPER}} .trs-tc-review' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'review_typography',
			'selector' => '{{WRAPPER}} .trs-tc-review',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_image', [
			'label' => esc_html__( 'Author Image', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'image_size', [
			'label'      => esc_html__( 'Image Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 40, 'max' => 220 ] ],
			'default'    => [ 'size' => 72, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trs-tc-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'global_image_shape', [
			'label'   => esc_html__( 'Image Shape', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'circle',
			'options' => [
				'circle'   => esc_html__( 'Circle', 'trs-kit' ),
				'square'   => esc_html__( 'Square', 'trs-kit' ),
				'rounded'  => esc_html__( 'Rounded', 'trs-kit' ),
				'diamond'  => esc_html__( 'Diamond', 'trs-kit' ),
				'star'     => esc_html__( 'Star', 'trs-kit' ),
				'triangle' => esc_html__( 'Triangle', 'trs-kit' ),
				'hexagon'  => esc_html__( 'Hexagon', 'trs-kit' ),
			],
		] );

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings     = $this->get_settings_for_display();
		$testimonials = $settings['testimonials'] ?? [];
		if ( empty( $testimonials ) ) {
			return;
		}

		$total_items   = count( $testimonials );
		$rows          = max( 1, min( 4, (int) ( $settings['rows'] ?? 2 ) ) );
		$rows          = min( $rows, max( 1, $total_items ) );
		// Avoid single-item rows, because marquee cloning would repeat one card on that row.
		$max_rows_without_single_item = max( 1, intdiv( $total_items, 2 ) );
		$rows = min( $rows, $max_rows_without_single_item );
		$enable_anim   = 'yes' === ( $settings['enable_animation'] ?? 'yes' );
		$pause_hover   = 'yes' === ( $settings['pause_on_hover'] ?? 'yes' );
		$direction     = ( 'right' === ( $settings['direction'] ?? 'left' ) ) ? 'right' : 'left';
		$global_shape  = $settings['global_image_shape'] ?? 'circle';
		$row_directions = [
			( 'right' === ( $settings['row_1_direction'] ?? $direction ) ) ? 'right' : 'left',
			( 'right' === ( $settings['row_2_direction'] ?? $direction ) ) ? 'right' : 'left',
			( 'right' === ( $settings['row_3_direction'] ?? $direction ) ) ? 'right' : 'left',
			( 'right' === ( $settings['row_4_direction'] ?? $direction ) ) ? 'right' : 'left',
		];

		// Keep the testimonials in their creation order and split sequentially into rows.
		$items_in_order = array_values( $testimonials );
		$rows_data      = [];
		$offset         = 0;
		$base_size      = intdiv( $total_items, $rows );
		$remainder      = $total_items % $rows;

		for ( $row_index = 0; $row_index < $rows; $row_index++ ) {
			$current_row_size = $base_size + ( $row_index < $remainder ? 1 : 0 );
			$rows_data[] = array_slice( $items_in_order, $offset, $current_row_size );
			$offset += $current_row_size;
		}

		$classes = [ 'trs-testimonial-cards' ];
		$classes[] = $enable_anim ? 'trs-tc--animated' : 'trs-tc--static';
		if ( $enable_anim && $pause_hover ) {
			$classes[] = 'trs-tc--pause-hover';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php foreach ( $rows_data as $row_index => $row_items ) : ?>
				<?php if ( empty( $row_items ) ) { continue; } ?>
				<div
					class="trs-tc-row-viewport"
					data-row-index="<?php echo esc_attr( (string) $row_index ); ?>"
					data-row-direction="<?php echo esc_attr( $row_directions[ $row_index ] ?? $direction ); ?>"
				>
					<div class="trs-tc-row-track">
						<?php foreach ( $row_items as $item ) : ?>
							<?php
							$name        = $item['author_name'] ?? '';
							$title       = $item['author_title'] ?? '';
							$review      = $item['review_text'] ?? '';
							$image_id    = ! empty( $item['author_image']['id'] ) ? (int) $item['author_image']['id'] : 0;
							$image_url   = ! empty( $item['author_image']['url'] ) ? $item['author_image']['url'] : '';
							$shape_class = 'is-shape-' . preg_replace( '/[^a-z0-9_-]/', '', (string) $global_shape );
							?>
							<article class="trs-tc-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
								<div class="trs-tc-card">
									<div class="trs-tc-head">
										<div class="trs-tc-avatar <?php echo esc_attr( $shape_class ); ?>">
											<?php if ( $image_id ) : ?>
												<?php echo wp_get_attachment_image( $image_id, 'thumbnail', false, [
													'class'   => 'trs-tc-avatar-img',
													'loading' => 'lazy',
													'alt'     => esc_attr( $name ),
												] ); ?>
											<?php elseif ( ! empty( $image_url ) ) : ?>
												<img class="trs-tc-avatar-img" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy">
											<?php endif; ?>
										</div>
										<div class="trs-tc-meta">
											<?php if ( ! empty( $name ) ) : ?>
												<p class="trs-tc-name"><?php echo esc_html( $name ); ?></p>
											<?php endif; ?>
											<?php if ( ! empty( $title ) ) : ?>
												<p class="trs-tc-title"><?php echo esc_html( $title ); ?></p>
											<?php endif; ?>
										</div>
									</div>
									<?php if ( ! empty( $review ) ) : ?>
										<p class="trs-tc-review"><?php echo esc_html( $review ); ?></p>
									<?php endif; ?>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
