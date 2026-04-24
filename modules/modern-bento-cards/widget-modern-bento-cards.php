<?php
/**
 * Modern Bento Cards widget.
 *
 * @package TRS_Kit
 */
declare( strict_types=1 );

namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TRS_Widget_Modern_Bento_Cards extends \Elementor\Widget_Base {

	public function get_name(): string { return 'trs-modern-bento-cards'; }
	public function get_title(): string { return esc_html__( 'Modern Bento Cards', 'trs-kit' ); }
	public function get_icon(): string { return 'eicon-posts-grid'; }
	public function get_categories(): array { return [ 'trs-kit' ]; }
	public function get_style_depends(): array { return [ 'trs-modern-bento-cards' ]; }
	public function get_script_depends(): array { return [ 'trs-modern-bento-cards' ]; }

	protected function register_controls(): void {
		$this->register_layout_controls();
		$this->register_image_card_controls( 1 );
		$this->register_text_card_controls( 2 );
		$this->register_text_card_controls( 3 );
		$this->register_text_card_controls( 4 );
		$this->register_text_card_controls( 5 );
		$this->register_image_card_controls( 6 );
		$this->register_style_controls();
	}

	private function register_layout_controls(): void {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'trs-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'cards_gap',
			[
				'label'          => esc_html__( 'Cards Gap', 'trs-kit' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => [ 'px' ],
				'range'          => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'        => [ 'size' => 14, 'unit' => 'px' ],
				'tablet_default' => [ 'size' => 14, 'unit' => 'px' ],
				'mobile_default' => [ 'size' => 12, 'unit' => 'px' ],
				'selectors'      => [
					'{{WRAPPER}} .trs-modern-bento-cards' => '--trs-mbc-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cards_min_height',
			[
				'label'          => esc_html__( 'Cards Min Height', 'trs-kit' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => [ 'px' ],
				'range'          => [ 'px' => [ 'min' => 180, 'max' => 520 ] ],
				'default'        => [ 'size' => 330, 'unit' => 'px' ],
				'tablet_default' => [ 'size' => 260, 'unit' => 'px' ],
				'mobile_default' => [ 'size' => 220, 'unit' => 'px' ],
				'selectors'      => [
					'{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-card' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_image_card_controls( int $index ): void {
		$selector = '{{WRAPPER}} .trs-mbc-card--' . $index;

		$this->start_controls_section(
			'section_image_card_' . $index,
			[
				'label' => sprintf( esc_html__( 'Image Card %d', 'trs-kit' ), $index ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'card_' . $index . '_image',
			[
				'label'   => esc_html__( 'Image', 'trs-kit' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
			]
		);

		$this->add_control(
			'card_' . $index . '_background',
			[
				'label'     => esc_html__( 'Background Color', 'trs-kit' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#212121',
				'selectors' => [ $selector => 'background-color: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();
	}

	private function register_text_card_controls( int $index ): void {
		$selector = '{{WRAPPER}} .trs-mbc-card--' . $index;

		$this->start_controls_section(
			'section_text_card_' . $index,
			[
				'label' => sprintf( esc_html__( 'Text Card %d', 'trs-kit' ), $index ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'card_' . $index . '_heading',
			[
				'label'   => esc_html__( 'Heading', 'trs-kit' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 2 === $index ? esc_html__( '7.5M', 'trs-kit' ) : ( 3 === $index ? esc_html__( '2020', 'trs-kit' ) : ( 4 === $index ? esc_html__( '20+', 'trs-kit' ) : esc_html__( '100%', 'trs-kit' ) ) ),
			]
		);

		$this->add_control(
			'card_' . $index . '_subheading',
			[
				'label'   => esc_html__( 'Subheading', 'trs-kit' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 2 === $index ? esc_html__( 'Rapid Financial Growth', 'trs-kit' ) : ( 3 === $index ? esc_html__( 'Years in the Trenches', 'trs-kit' ) : ( 4 === $index ? esc_html__( 'Operational Hub', 'trs-kit' ) : esc_html__( 'Service Expansion', 'trs-kit' ) ) ),
			]
		);

		$this->add_control(
			'card_' . $index . '_text',
			[
				'label'   => esc_html__( 'Text', 'trs-kit' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 2 === $index ? esc_html__( 'Our turnover in 2024 is growing massively from our start in 2020. Real proof of market trust.', 'trs-kit' ) : ( 3 === $index ? esc_html__( 'The year we were founded. We survived the toughest markets and kept growing.', 'trs-kit' ) : ( 4 === $index ? esc_html__( 'Dedicated internal experts handling recruitment, paperwork, and daily worker support so you do not have to.', 'trs-kit' ) : esc_html__( 'Complete evolution from one-off recruiting to full organizational consulting and training.', 'trs-kit' ) ) ),
			]
		);

		$this->add_control(
			'card_' . $index . '_background',
			[
				'label'     => esc_html__( 'Background Color', 'trs-kit' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F8F7F2',
				'selectors' => [ $selector => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'card_' . $index . '_heading_color',
			[
				'label'     => esc_html__( 'Heading Color', 'trs-kit' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#212121',
				'selectors' => [ $selector . ' .trs-mbc-title' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'card_' . $index . '_subheading_color',
			[
				'label'     => esc_html__( 'Subheading Color', 'trs-kit' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#212121',
				'selectors' => [ $selector . ' .trs-mbc-subheading' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'card_' . $index . '_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'trs-kit' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#212121',
				'selectors' => [ $selector . ' .trs-mbc-text' => 'color: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_controls(): void {
		$this->start_controls_section(
			'section_style_cards',
			[
				'label' => esc_html__( 'Cards', 'trs-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'          => esc_html__( 'Card Padding', 'trs-kit' ),
				'type'           => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'     => [ 'px' ],
				'default'        => [
					'top'      => 24,
					'right'    => 24,
					'bottom'   => 24,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'tablet_default' => [
					'top'      => 20,
					'right'    => 20,
					'bottom'   => 20,
					'left'     => 20,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'mobile_default' => [
					'top'      => 18,
					'right'    => 18,
					'bottom'   => 18,
					'left'     => 18,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'      => [
					'{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'size' => 24, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-card' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-media, {{WRAPPER}} .trs-modern-bento-cards .trs-mbc-media-image' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'trs-kit' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#EBEBEB',
				'selectors' => [
					'{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'trs-kit' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 8 ] ],
				'default'    => [ 'size' => 1, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-card' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-card',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_typography',
			[
				'label' => esc_html__( 'Typography', 'trs-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Headings', 'trs-kit' ),
				'selector' => '{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'subheading_typography',
				'label'    => esc_html__( 'Subheadings', 'trs-kit' ),
				'selector' => '{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-subheading',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Description', 'trs-kit' ),
				'selector' => '{{WRAPPER}} .trs-modern-bento-cards .trs-mbc-text',
			]
		);

		$this->end_controls_section();
	}

	private function render_image_card( array $settings, int $index ): void {
		$image_id   = ! empty( $settings[ 'card_' . $index . '_image' ]['id'] ) ? (int) $settings[ 'card_' . $index . '_image' ]['id'] : 0;
		$image_url  = ! empty( $settings[ 'card_' . $index . '_image' ]['url'] ) ? (string) $settings[ 'card_' . $index . '_image' ]['url'] : '';
		?>
		<article class="trs-mbc-card trs-mbc-card--<?php echo esc_attr( (string) $index ); ?> trs-mbc-card--image">
			<div class="trs-mbc-media">
				<?php if ( $image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$image_id,
						'large',
						false,
						[
							'class'   => 'trs-mbc-media-image',
							'loading' => 'lazy',
							'alt'     => esc_attr__( 'Modern bento image', 'trs-kit' ),
						]
					);
					?>
				<?php elseif ( '' !== $image_url ) : ?>
					<img class="trs-mbc-media-image" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr__( 'Modern bento image', 'trs-kit' ); ?>" loading="lazy">
				<?php endif; ?>
			</div>
		</article>
		<?php
	}

	private function render_text_card( array $settings, int $index ): void {
		$heading    = ! empty( $settings[ 'card_' . $index . '_heading' ] ) ? (string) $settings[ 'card_' . $index . '_heading' ] : '';
		$subheading = ! empty( $settings[ 'card_' . $index . '_subheading' ] ) ? (string) $settings[ 'card_' . $index . '_subheading' ] : '';
		$text       = ! empty( $settings[ 'card_' . $index . '_text' ] ) ? (string) $settings[ 'card_' . $index . '_text' ] : '';
		?>
		<article class="trs-mbc-card trs-mbc-card--<?php echo esc_attr( (string) $index ); ?> trs-mbc-card--text">
			<div class="trs-mbc-content">
				<?php if ( '' !== $heading ) : ?>
					<h3 class="trs-mbc-title"><?php echo esc_html( $heading ); ?></h3>
				<?php endif; ?>
				<?php if ( '' !== $subheading ) : ?>
					<p class="trs-mbc-subheading"><?php echo esc_html( $subheading ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $text ) : ?>
					<p class="trs-mbc-text"><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
			</div>
		</article>
		<?php
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		?>
		<section class="trs-modern-bento-cards" aria-label="<?php echo esc_attr__( 'Modern bento cards', 'trs-kit' ); ?>">
			<?php
			$this->render_image_card( $settings, 1 );
			$this->render_text_card( $settings, 2 );
			$this->render_text_card( $settings, 3 );
			$this->render_text_card( $settings, 4 );
			$this->render_text_card( $settings, 5 );
			$this->render_image_card( $settings, 6 );
			?>
		</section>
		<?php
	}
}
