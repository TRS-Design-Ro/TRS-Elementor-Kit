<?php
/**
 * Jobs Cards widget.
 *
 * @package TRS_Kit
 */

namespace TRS_Kit\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TRS_Widget_Jobs_Cards extends \Elementor\Widget_Base {

	public function get_name(): string { return 'trs-jobs-cards'; }
	public function get_title(): string { return esc_html__( 'Jobs Cards', 'trs-kit' ); }
	public function get_icon(): string { return 'eicon-posts-grid'; }
	public function get_categories(): array { return [ 'trs-kit' ]; }
	public function get_style_depends(): array { return [ 'trs-jobs-cards' ]; }
	public function get_script_depends(): array { return [ 'trs-jobs-cards' ]; }

	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	// -------------------------------------------------------------------------
	// Content controls
	// -------------------------------------------------------------------------

	private function register_content_controls(): void {

		// --- Job Cards repeater ---
		$this->start_controls_section( 'section_cards', [
			'label' => esc_html__( 'Job Cards', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'job_title', [
			'label'       => esc_html__( 'Job Title', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Truck Driver', 'trs-kit' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'job_description', [
			'label'       => esc_html__( 'Description / Location', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Charleroi, Belgium', 'trs-kit' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'badge_schedule', [
			'label'     => esc_html__( 'Schedule Badge', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => esc_html__( 'Full Time', 'trs-kit' ),
			'separator' => 'before',
		] );

		$repeater->add_control( 'badge_job_type', [
			'label'   => esc_html__( 'Job Type Badge', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Onsite', 'trs-kit' ),
		] );

		$repeater->add_control( 'badge_experience', [
			'label'       => esc_html__( 'Experience Badge', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( '1-3 Years of Experience', 'trs-kit' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'posted_time', [
			'label'     => esc_html__( 'Posted Time', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => esc_html__( '2 days ago', 'trs-kit' ),
			'separator' => 'before',
		] );

		$repeater->add_control( 'applicants_text', [
			'label'   => esc_html__( 'Applicants Text', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( '45 applications', 'trs-kit' ),
		] );

		$repeater->add_control( 'button_text', [
			'label'     => esc_html__( 'Button Text', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => esc_html__( 'APPLY NOW', 'trs-kit' ),
			'separator' => 'before',
		] );

		$repeater->add_control( 'button_url', [
			'label'       => esc_html__( 'Button URL', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => 'https://example.com',
		] );

		$repeater->add_control( 'salary_range', [
			'label'     => esc_html__( 'Salary Range', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => esc_html__( '$2,3K-$2,5K', 'trs-kit' ),
			'separator' => 'before',
		] );

		$repeater->add_control( 'salary_unit', [
			'label'   => esc_html__( 'Salary Unit', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( '/m', 'trs-kit' ),
		] );

		$repeater->add_control( 'employer_image', [
			'label'     => esc_html__( 'Employer Logo', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::MEDIA,
			'separator' => 'before',
		] );

		$repeater->add_control( 'employer_name', [
			'label'   => esc_html__( 'Employer Name', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Company Name', 'trs-kit' ),
		] );

		$this->add_control( 'cards', [
			'label'       => esc_html__( 'Cards', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'job_title'        => 'Truck Driver',
					'job_description'  => 'Charleroi, Belgium',
					'badge_schedule'   => 'Full Time',
					'badge_job_type'   => 'Onsite',
					'badge_experience' => '2-4 Years of Experience',
					'posted_time'      => '2 days ago',
					'applicants_text'  => '45 applications',
					'button_text'      => 'APPLY NOW',
					'salary_range'     => '$2,3K-$2,5K',
					'salary_unit'      => '/m',
					'employer_name'    => 'Picave',
				],
				[
					'job_title'        => 'Bus Driver',
					'job_description'  => 'Charleroi, Belgium',
					'badge_schedule'   => 'Full Time',
					'badge_job_type'   => 'Onsite',
					'badge_experience' => '2-4 Years of Experience',
					'posted_time'      => '3 days ago',
					'applicants_text'  => '145 applications',
					'button_text'      => 'APPLY NOW',
					'salary_range'     => '$2K-$2,4K',
					'salary_unit'      => '/m',
					'employer_name'    => 'Devkala',
				],
				[
					'job_title'        => 'Truck Driver',
					'job_description'  => 'Haga, The Netherlands',
					'badge_schedule'   => 'Full Time',
					'badge_job_type'   => 'Onsite',
					'badge_experience' => '1-3 Years of Experience',
					'posted_time'      => '4 days ago',
					'applicants_text'  => '25 applications',
					'button_text'      => 'APPLY NOW',
					'salary_range'     => '$1,3K-$2,3K',
					'salary_unit'      => '/m',
					'employer_name'    => 'Alsix',
				],
				[
					'job_title'        => 'Truck Driver',
					'job_description'  => 'Hamburg, Germany',
					'badge_schedule'   => 'Full Time',
					'badge_job_type'   => 'Onsite',
					'badge_experience' => '1-3 Years of Experience',
					'posted_time'      => '6 days ago',
					'applicants_text'  => '53 applications',
					'button_text'      => 'APPLY NOW',
					'salary_range'     => '$2,1K-$2,4K',
					'salary_unit'      => '/m',
					'employer_name'    => 'Devxy',
				],
				[
					'job_title'        => 'Truck Driver',
					'job_description'  => 'Amsterdam, the Netherlands',
					'badge_schedule'   => 'Full Time',
					'badge_job_type'   => 'Onsite',
					'badge_experience' => '1-3 Years of Experience',
					'posted_time'      => '10 days ago',
					'applicants_text'  => '68 applications',
					'button_text'      => 'APPLY NOW',
					'salary_range'     => '$2,1K-$3,5K',
					'salary_unit'      => '/m',
					'employer_name'    => 'Coudo',
				],
				[
					'job_title'        => 'Truck Driver',
					'job_description'  => 'Anvers, Belgium',
					'badge_schedule'   => 'Full Time',
					'badge_job_type'   => 'Onsite',
					'badge_experience' => '1-3 Years of Experience',
					'posted_time'      => '12 days ago',
					'applicants_text'  => '146 applications',
					'button_text'      => 'APPLY NOW',
					'salary_range'     => '$2,1K-$3K',
					'salary_unit'      => '/m',
					'employer_name'    => 'Mech.io',
				],
			],
			'title_field' => '{{{ job_title }}}',
		] );

		$this->end_controls_section();

		// --- Layout ---
		$this->start_controls_section( 'section_layout', [
			'label' => esc_html__( 'Layout', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_responsive_control( 'columns', [
			'label'          => esc_html__( 'Columns', 'trs-kit' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => '3',
			'tablet_default' => '2',
			'mobile_default' => '1',
			'options'        => [
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			],
			'selectors'      => [
				'{{WRAPPER}} .trs-jobs-cards__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
			],
		] );

		$this->add_responsive_control( 'column_gap', [
			'label'      => esc_html__( 'Column Gap', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-cards__grid' => 'column-gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'row_gap', [
			'label'      => esc_html__( 'Row Gap', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-cards__grid' => 'row-gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		// --- Info separator icon ---
		$this->start_controls_section( 'section_separator_icon', [
			'label' => esc_html__( 'Info Separator Icon', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'separator_icon', [
			'label'       => esc_html__( 'Icon', 'trs-kit' ),
			'type'        => \Elementor\Controls_Manager::ICONS,
			'default'     => [
				'value'   => 'fas fa-circle',
				'library' => 'fa-solid',
			],
			'skin'        => 'inline',
			'label_block' => false,
		] );

		$this->end_controls_section();
	}

	// -------------------------------------------------------------------------
	// Style controls
	// -------------------------------------------------------------------------

	private function register_style_controls(): void {

		// --- Card ---
		$this->start_controls_section( 'section_style_card', [
			'label' => esc_html__( 'Card', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'card_border_color', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#e67e22',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card' => 'border-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'card_border_width', [
			'label'      => esc_html__( 'Border Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default'    => [
				'top'      => '1',
				'right'    => '1',
				'bottom'   => '1',
				'left'     => '1',
				'unit'     => 'px',
				'isLinked' => true,
			],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
			],
		] );

		$this->add_responsive_control( 'card_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [
				'top'      => '20',
				'right'    => '20',
				'bottom'   => '20',
				'left'     => '20',
				'unit'     => 'px',
				'isLinked' => true,
			],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'card_inner_padding', [
			'label'      => esc_html__( 'Inner Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'default'    => [
				'top'      => '30',
				'right'    => '30',
				'bottom'   => '24',
				'left'     => '30',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__body-content' => 'padding-top: {{TOP}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}};',
				'{{WRAPPER}} .trs-jobs-card__footer'       => 'padding-right: {{RIGHT}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'card_box_shadow',
			'selector' => '{{WRAPPER}} .trs-jobs-card',
		] );

		$this->end_controls_section();

		// --- Card Hover ---
		$this->start_controls_section( 'section_style_hover', [
			'label' => esc_html__( 'Card Hover', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'hover_bg_type', [
			'label'   => esc_html__( 'Hover Background', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'gradient',
			'options' => [
				'none'     => esc_html__( 'None', 'trs-kit' ),
				'solid'    => esc_html__( 'Solid Color', 'trs-kit' ),
				'gradient' => esc_html__( 'Gradient', 'trs-kit' ),
			],
		] );

		$this->add_control( 'hover_solid_color', [
			'label'     => esc_html__( 'Hover Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'condition' => [ 'hover_bg_type' => 'solid' ],
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__body-bg' => 'background: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_gradient_from', [
			'label'     => esc_html__( 'Gradient From', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffba00',
			'condition' => [ 'hover_bg_type' => 'gradient' ],
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card' => '--jc-hover-from: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_gradient_to', [
			'label'     => esc_html__( 'Gradient To', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#fbd760',
			'condition' => [ 'hover_bg_type' => 'gradient' ],
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card' => '--jc-hover-to: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_gradient_angle', [
			'label'      => esc_html__( 'Gradient Angle', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'deg' ],
			'range'      => [ 'deg' => [ 'min' => 0, 'max' => 360 ] ],
			'default'    => [ 'unit' => 'deg', 'size' => 180 ],
			'condition'  => [ 'hover_bg_type' => 'gradient' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card' => '--jc-hover-angle: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'hover_title_color', [
			'label'     => esc_html__( 'Title Color on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__title' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_desc_color', [
			'label'     => esc_html__( 'Description Color on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__description' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_info_color', [
			'label'     => esc_html__( 'Info Text Color on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__posted-time' => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__applicants'  => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__separator'   => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_badge_bg_color', [
			'label'     => esc_html__( 'Badge Background on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#e67e22',
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__badge' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_badge_text_color', [
			'label'     => esc_html__( 'Badge Text Color on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__badge' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_button_bg_color', [
			'label'     => esc_html__( 'Button Background on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__button' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_button_text_color', [
			'label'     => esc_html__( 'Button Text Color on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__button' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_salary_range_color', [
			'label'     => esc_html__( 'Salary Range Color on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__salary-range' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_salary_unit_color', [
			'label'     => esc_html__( 'Salary Unit Color on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__salary-unit' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_employer_name_color', [
			'label'     => esc_html__( 'Employer Name Color on Hover', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card:hover .trs-jobs-card__employer-name' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

		// --- Title ---
		$this->start_controls_section( 'section_style_title', [
			'label' => esc_html__( 'Title', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__title' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .trs-jobs-card__title',
		] );

		$this->add_responsive_control( 'title_spacing', [
			'label'      => esc_html__( 'Bottom Spacing', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 6 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		// --- Description ---
		$this->start_controls_section( 'section_style_description', [
			'label' => esc_html__( 'Description', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#666666',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__description' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'description_typography',
			'selector' => '{{WRAPPER}} .trs-jobs-card__description',
		] );

		$this->add_responsive_control( 'description_spacing', [
			'label'      => esc_html__( 'Bottom Spacing', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		// --- Badges ---
		$this->start_controls_section( 'section_style_badges', [
			'label' => esc_html__( 'Badges', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'badge_bg_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#f5f5f5',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__badge' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'badge_text_color', [
			'label'     => esc_html__( 'Text Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#5f5270',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__badge' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'badge_typography',
			'selector' => '{{WRAPPER}} .trs-jobs-card__badge',
		] );

		$this->add_responsive_control( 'badge_padding', [
			'label'      => esc_html__( 'Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default'    => [
				'top'      => '5',
				'right'    => '12',
				'bottom'   => '5',
				'left'     => '12',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'badge_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [
				'top'      => '46',
				'right'    => '46',
				'bottom'   => '46',
				'left'     => '46',
				'unit'     => 'px',
				'isLinked' => true,
			],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'badges_spacing', [
			'label'      => esc_html__( 'Bottom Spacing', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 40 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__badges' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		// --- Job Info ---
		$this->start_controls_section( 'section_style_info', [
			'label' => esc_html__( 'Job Info', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'info_text_color', [
			'label'     => esc_html__( 'Text Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#666666',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__posted-time' => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-jobs-card__applicants'  => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'info_typography',
			'selector' => '{{WRAPPER}} .trs-jobs-card__posted-time, {{WRAPPER}} .trs-jobs-card__applicants',
		] );

		$this->add_control( 'separator_icon_color', [
			'label'     => esc_html__( 'Separator Icon Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__separator'     => 'color: {{VALUE}};',
				'{{WRAPPER}} .trs-jobs-card__separator svg' => 'fill: {{VALUE}};',
			],
		] );

		$this->add_control( 'separator_icon_size', [
			'label'      => esc_html__( 'Separator Icon Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 6 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__separator'     => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trs-jobs-card__separator svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'info_spacing', [
			'label'      => esc_html__( 'Bottom Spacing', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__info' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		// --- Button ---
		$this->start_controls_section( 'section_style_button', [
			'label' => esc_html__( 'Button', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'button_bg_color', [
			'label'     => esc_html__( 'Background Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__button' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_text_color', [
			'label'     => esc_html__( 'Text Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__button' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'button_typography',
			'selector' => '{{WRAPPER}} .trs-jobs-card__button',
		] );

		$this->add_responsive_control( 'button_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [
				'top'      => '46',
				'right'    => '46',
				'bottom'   => '46',
				'left'     => '46',
				'unit'     => 'px',
				'isLinked' => true,
			],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'button_padding', [
			'label'      => esc_html__( 'Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default'    => [
				'top'      => '10',
				'right'    => '22',
				'bottom'   => '10',
				'left'     => '22',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		// --- Salary ---
		$this->start_controls_section( 'section_style_salary', [
			'label' => esc_html__( 'Salary', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'salary_range_color', [
			'label'     => esc_html__( 'Range Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#fbd760',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__salary-range' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'salary_unit_color', [
			'label'     => esc_html__( 'Unit Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#666666',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__salary-unit' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'salary_typography',
			'selector' => '{{WRAPPER}} .trs-jobs-card__salary',
		] );

		$this->end_controls_section();

		// --- Divider ---
		$this->start_controls_section( 'section_style_divider', [
			'label' => esc_html__( 'Divider', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'divider_style', [
			'label'     => esc_html__( 'Style', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'dashed',
			'options'   => [
				'solid'  => esc_html__( 'Solid', 'trs-kit' ),
				'dashed' => esc_html__( 'Dashed', 'trs-kit' ),
				'dotted' => esc_html__( 'Dotted', 'trs-kit' ),
				'double' => esc_html__( 'Double', 'trs-kit' ),
			],
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__divider' => 'border-top-style: {{VALUE}};',
			],
		] );

		$this->add_control( 'divider_color', [
			'label'     => esc_html__( 'Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#e0e0e0',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__divider' => 'border-top-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'divider_weight', [
			'label'      => esc_html__( 'Weight', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__divider' => 'border-top-width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'divider_spacing', [
			'label'      => esc_html__( 'Vertical Spacing', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 16 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__divider' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		// --- Employer ---
		$this->start_controls_section( 'section_style_employer', [
			'label' => esc_html__( 'Employer', 'trs-kit' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'employer_logo_size', [
			'label'      => esc_html__( 'Logo Size', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 46 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__employer-logo' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'logo_shape', [
			'label'   => esc_html__( 'Logo Shape', 'trs-kit' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'circle',
			'options' => [
				'circle'  => esc_html__( 'Circle', 'trs-kit' ),
				'square'  => esc_html__( 'Square', 'trs-kit' ),
				'rounded' => esc_html__( 'Rounded', 'trs-kit' ),
				'custom'  => esc_html__( 'Custom', 'trs-kit' ),
			],
		] );

		$this->add_responsive_control( 'employer_logo_radius', [
			'label'      => esc_html__( 'Custom Border Radius', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'condition'  => [ 'logo_shape' => 'custom' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__employer-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
		] );

		$this->add_control( 'employer_logo_border_heading', [
			'label'     => esc_html__( 'Logo Border', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'employer_logo_border_style', [
			'label'     => esc_html__( 'Border Style', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'none',
			'options'   => [
				'none'   => esc_html__( 'None', 'trs-kit' ),
				'solid'  => esc_html__( 'Solid', 'trs-kit' ),
				'dashed' => esc_html__( 'Dashed', 'trs-kit' ),
				'dotted' => esc_html__( 'Dotted', 'trs-kit' ),
				'double' => esc_html__( 'Double', 'trs-kit' ),
			],
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__employer-logo' => 'border-style: {{VALUE}};',
			],
		] );

		$this->add_control( 'employer_logo_border_color', [
			'label'     => esc_html__( 'Border Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'condition' => [ 'employer_logo_border_style!' => 'none' ],
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__employer-logo' => 'border-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'employer_logo_border_width', [
			'label'      => esc_html__( 'Border Width', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'condition'  => [ 'employer_logo_border_style!' => 'none' ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__employer-logo' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'employer_name_color', [
			'label'     => esc_html__( 'Name Color', 'trs-kit' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#212121',
			'selectors' => [
				'{{WRAPPER}} .trs-jobs-card__employer-name' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'employer_name_typography',
			'selector' => '{{WRAPPER}} .trs-jobs-card__employer-name',
		] );

		$this->add_responsive_control( 'footer_vertical_padding', [
			'label'      => esc_html__( 'Footer Vertical Padding', 'trs-kit' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [
				'{{WRAPPER}} .trs-jobs-card__footer' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	// -------------------------------------------------------------------------
	// Render
	// -------------------------------------------------------------------------

	protected function render(): void {
		$settings   = $this->get_settings_for_display();
		$cards      = $settings['cards'] ?? [];
		$hover_type = $settings['hover_bg_type'] ?? 'gradient';
		$logo_shape = $settings['logo_shape'] ?? 'circle';

		if ( empty( $cards ) ) {
			return;
		}
		?>
		<div class="trs-jobs-cards" data-hover-type="<?php echo esc_attr( $hover_type ); ?>" data-logo-shape="<?php echo esc_attr( $logo_shape ); ?>">
			<div class="trs-jobs-cards__grid">
				<?php foreach ( $cards as $card ) : ?>
					<?php $this->render_card( $card, $settings ); ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	private function render_card( array $card, array $settings ): void {
		$button_url   = $card['button_url'] ?? [];
		$btn_href     = ! empty( $button_url['url'] ) ? esc_url( $button_url['url'] ) : '#';
		$btn_target   = ! empty( $button_url['is_external'] ) ? ' target="_blank"' : '';
		$btn_nofollow = ! empty( $button_url['nofollow'] ) ? ' rel="nofollow"' : '';
		$item_id      = $card['_id'] ?? '';
		$image_url    = $card['employer_image']['url'] ?? '';
		$image_id     = (int) ( $card['employer_image']['id'] ?? 0 );
		$image_alt    = $image_id ? get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : '';
		if ( empty( $image_alt ) ) {
			$image_alt = $card['employer_name'] ?? '';
		}
		?>
		<div class="trs-jobs-card elementor-repeater-item-<?php echo esc_attr( $item_id ); ?>">

			<div class="trs-jobs-card__body">
				<div class="trs-jobs-card__body-bg" aria-hidden="true"></div>
				<div class="trs-jobs-card__body-content">

					<?php if ( ! empty( $card['job_title'] ) ) : ?>
						<h3 class="trs-jobs-card__title"><?php echo esc_html( $card['job_title'] ); ?></h3>
					<?php endif; ?>

					<?php if ( ! empty( $card['job_description'] ) ) : ?>
						<p class="trs-jobs-card__description"><?php echo esc_html( $card['job_description'] ); ?></p>
					<?php endif; ?>

					<div class="trs-jobs-card__badges">
						<?php if ( ! empty( $card['badge_schedule'] ) ) : ?>
							<span class="trs-jobs-card__badge"><?php echo esc_html( $card['badge_schedule'] ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $card['badge_job_type'] ) ) : ?>
							<span class="trs-jobs-card__badge"><?php echo esc_html( $card['badge_job_type'] ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $card['badge_experience'] ) ) : ?>
							<span class="trs-jobs-card__badge"><?php echo esc_html( $card['badge_experience'] ); ?></span>
						<?php endif; ?>
					</div>

					<div class="trs-jobs-card__info">
						<?php if ( ! empty( $card['posted_time'] ) ) : ?>
							<span class="trs-jobs-card__posted-time"><?php echo esc_html( $card['posted_time'] ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $settings['separator_icon']['value'] ) ) : ?>
							<span class="trs-jobs-card__separator" aria-hidden="true">
								<?php \Elementor\Icons_Manager::render_icon( $settings['separator_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
						<?php endif; ?>
						<?php if ( ! empty( $card['applicants_text'] ) ) : ?>
							<span class="trs-jobs-card__applicants"><?php echo esc_html( $card['applicants_text'] ); ?></span>
						<?php endif; ?>
					</div>

					<div class="trs-jobs-card__action">
						<?php if ( ! empty( $card['button_text'] ) ) : ?>
							<a href="<?php echo $btn_href; ?>" class="trs-jobs-card__button"<?php echo $btn_target . $btn_nofollow; ?>>
								<?php echo esc_html( $card['button_text'] ); ?>
							</a>
						<?php endif; ?>
						<?php if ( ! empty( $card['salary_range'] ) || ! empty( $card['salary_unit'] ) ) : ?>
							<span class="trs-jobs-card__salary">
								<?php if ( ! empty( $card['salary_range'] ) ) : ?>
									<span class="trs-jobs-card__salary-range"><?php echo esc_html( $card['salary_range'] ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $card['salary_unit'] ) ) : ?>
									<span class="trs-jobs-card__salary-unit"><?php echo esc_html( $card['salary_unit'] ); ?></span>
								<?php endif; ?>
							</span>
						<?php endif; ?>
					</div>

				</div><!-- /.trs-jobs-card__body-content -->
			</div><!-- /.trs-jobs-card__body -->

			<div class="trs-jobs-card__divider"></div>

			<div class="trs-jobs-card__footer">
				<?php if ( ! empty( $image_url ) ) : ?>
					<img
						src="<?php echo esc_url( $image_url ); ?>"
						alt="<?php echo esc_attr( $image_alt ); ?>"
						class="trs-jobs-card__employer-logo"
						loading="lazy"
					>
				<?php endif; ?>
				<?php if ( ! empty( $card['employer_name'] ) ) : ?>
					<span class="trs-jobs-card__employer-name"><?php echo esc_html( $card['employer_name'] ); ?></span>
				<?php endif; ?>
			</div><!-- /.trs-jobs-card__footer -->

		</div><!-- /.trs-jobs-card -->
		<?php
	}
}
