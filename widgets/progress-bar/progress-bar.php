<?php

namespace Designer\Widgets\Progress_Bar;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;

if( ! defined( 'ABSPATH' ) ){
    exit; // Exit if accessed directly.
}

class Progress_Bar extends Widget_Base{

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

        wp_register_style( 'progress-style', \Designer::plugin_url().'widgets/progress-bar/assets/progress-bar.css', array(), '1.0.0', 'all' );

        wp_register_script( 'progress-numerator', \Designer::plugin_url().'widgets/progress-bar/assets/progress-bar.js', array('jquery','elementor-frontend'), '1.0.0', true );

    }

    public function get_name() {
		return 'progress-bar';
	}

    public function get_title() {
		return esc_html__( 'Progress Bar', 'designer' );
	}

	public function get_icon() {
		return 'designer-icon eicon-skill-bar';
	}

	public function get_categories() {
		return [ 'designer'];
	}

	public function get_keywords() {
		return [ 'designer', 'progress bar', 'skill bar', 'skills bar', 'percentage bar', 'bar chart' ];
	}

	public function get_script_depends() {
		return [ 'jquery-numerator', 'progress-numerator' ];
	}

	public function get_style_depends() {
		return [ 'progress-style' ];
	}

    protected function register_controls() {

        // Section: General ----------
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'designer' ),
			]
		);

        $this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'hr-line',
				'options' => [
					'circle' => esc_html__( 'Circle', 'designer' ),
					'hr-line' => esc_html__( 'Horizontal Line', 'designer' ),
                    'vr-line'   => esc_html__('Vertical Line', 'designer'),
				],
				'prefix_class' => 'designer-prbar-layout-',
				'render_type' => 'template',
			]
		);

        $this->add_control(
			'max_value',
			[
				'label' => esc_html__( 'Max Value', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 100,
				'min' => 0,
				'step' => 1,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'counter_value',
			[
				'label' => esc_html__( 'Counter Value', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 70,
				'min' => 0,
				'step' => 1,
			]
		);

        $this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Title',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_position',
			[
				'label' => esc_html__( 'Title Position', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => esc_html__( 'Inside', 'designer' ),
					'outside' => esc_html__( 'Outside', 'designer' ),
				],
				'prefix_class' => 'designer-pbar-title-pos-',
				'render_type' => 'template',
				'condition' => [
					'layout!' => 'vr-line',
				],
			]
		);

        $this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'counter_switcher',
			[
				'label' => esc_html__( 'Show Counter', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before'
			]
		);

        $this->add_control(
			'counter_position',
			[
				'label' => esc_html__( 'Counter Position', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => esc_html__( 'Inside', 'designer' ),
					'outside' => esc_html__( 'Outside', 'designer' ),
				],
				'prefix_class' => 'designer-pbar-counter-pos-',
				'render_type' => 'template',
				'condition' => [
					'counter_switcher' => 'yes',
				],
			]
		);

        $this->add_control(
			'counter_follow_line',
			[
				'label' => esc_html__( 'Follow Pr. Line', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_position' => 'inside',
					'layout' => 'hr-line',
				],
			]
		);

        $this->add_control(
			'counter_prefix',
			[
				'label' => esc_html__( 'Counter Prefix', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'condition' => [
					'counter_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'counter_suffix',
			[
				'label' => esc_html__( 'Counter Suffix', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '%',
				'condition' => [
					'counter_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'counter_separator',
			[
				'label' => esc_html__( 'Show Thousand Separator', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'counter_switcher' => 'yes',
				],
			]
		);

        $this->end_controls_section();

        $this-> __section_settings();

        // Styles
        $this-> __general_styles();


    }

    protected function __section_settings(){

        $this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Settings', 'designer' ),
			]
		);

        $this->add_responsive_control(
			'circle_size',
			[
				'label' => esc_html__( 'Circle Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'widescreen_default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'laptop_default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'tablet_extra_default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'mobile_extra_default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-circle' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
				'condition' => [
					'layout' => 'circle',
				],
			]
		);

		$this->add_responsive_control(
			'line_width',
			[
				'label' => esc_html__( 'Line Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'condition' => [
					'layout' => 'circle',
				],
			]
		);

		$this->add_responsive_control(
			'prline_width',
			[
				'label' => esc_html__( 'Progress Line Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'condition' => [
					'layout' => 'circle',
				],
			]
		);

        $this->add_responsive_control(
			'line_size',
			[
				'label' => esc_html__( 'Line Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 27,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-hr-line' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-prbar-vr-line' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout!' => 'circle',
				],
			]
		);

        $this->add_responsive_control(
			'vr_line_height',
			[
				'label' => esc_html__( 'Vertical Line Height', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 277,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-vr-line' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => 'vr-line',
				],
			]
		);

        $this->add_control(
			'anim_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-circle-prline' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .designer-prbar-hr-line-inner' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .designer-prbar-vr-line-inner' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
				],				
				'render_type' => 'template',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'anim_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-circle-prline' => '-webkit-transition-delay: {{VALUE}}s; transition-delay: {{VALUE}}s;',
					'{{WRAPPER}} .designer-prbar-hr-line-inner' => '-webkit-transition-delay: {{VALUE}}s; transition-delay: {{VALUE}}s;',
					'{{WRAPPER}} .designer-prbar-vr-line-inner' => '-webkit-transition-delay: {{VALUE}}s; transition-delay: {{VALUE}}s;',
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'anim_timing',
			[
				'label' => esc_html__( 'Animation Timing', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'ease-default'   => __('Default', 'designer'),
                    'linear'         => __('Linear', 'designer'),
                    'ease-in'        => __('Ease In', 'designer'),
                    'ease-out'       => __('Ease Out', 'designer'),    
                ],
				'default' => 'ease-default',
			]
		);

        $this->add_control(
			'anim_loop',
			[
				'label' => esc_html__( 'Animation Loop', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'anim_loop_delay',
			[
				'label' => esc_html__( 'Loop Delay', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
				'min' => 0,
				'max' => 5,
				'step' => 1,
                'condition' =>  [
                    'anim_loop' => 'yes'
                ]
			]
		);

        $this->end_controls_section();
    }

    protected function __general_styles(){

        $this->start_controls_section(
			'section_style_general',
			[
				'label' => esc_html__( 'General', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'wrapper_section',
			[
				'label' => esc_html__( 'Wrapper', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'counter_switcher' => 'yes',
				],
			]
		);

        $this->add_control(
			'general_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-circle-line' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .designer-prbar-hr-line' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .designer-prbar-vr-line' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'circle_line_bg_color',
			[
				'label' => esc_html__( 'Inactive Line Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#dddddd',
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-circle-line' => 'stroke: {{VALUE}}',
				],
                'condition' => [
					'layout' => 'circle',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'general_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'designer' ),
				'selector' => '{{WRAPPER}} .designer-prbar-hr-line, {{WRAPPER}} .designer-prbar-vr-line, {{WRAPPER}} .designer-prbar-circle svg',
			]
		);

		$this->add_control(
			'general_border_type',
			[
				'label' => esc_html__( 'Border Type', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'solid' => esc_html__( 'Solid', 'designer' ),
					'double' => esc_html__( 'Double', 'designer' ),
					'dotted' => esc_html__( 'Dotted', 'designer' ),
					'dashed' => esc_html__( 'Dashed', 'designer' ),
					'groove' => esc_html__( 'Groove', 'designer' ),
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-hr-line' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .designer-prbar-vr-line' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'layout!' => 'circle'
				]
			]
		);

		$this->add_responsive_control(
			'general_border_width',
			[
				'label' => esc_html__( 'Border Width', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-hr-line' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .designer-prbar-vr-line' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'general_border_type!' => 'none',
					'layout!' => 'circle'
				],
			]
		);

		$this->add_control(
			'general_border_color',
			[
				'label' => esc_html__( 'Border Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e5e5e5',
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-hr-line' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .designer-prbar-vr-line' => 'border-color: {{VALUE}}',
				],
                'condition' => [
					'general_border_type!' => 'none',
					'layout!' => 'circle'
				],
			]
		);

		$this->add_control(
			'general_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-hr-line' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-prline-rounded-yes .designer-prbar-hr-line-inner' => 'border-top-right-radius: calc({{RIGHT}}{{UNIT}} - {{general_border_width.RIGHT}}{{general_border_width.UNIT}});border-bottom-right-radius: calc({{BOTTOM}}{{UNIT}} - {{general_border_width.BOTTOM}}{{general_border_width.UNIT}});',
					'{{WRAPPER}} .designer-prbar-vr-line' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-prline-rounded-yes .designer-prbar-vr-line-inner' => 'border-top-right-radius: calc({{RIGHT}}{{UNIT}} - {{general_border_width.RIGHT}}{{general_border_width.UNIT}});border-top-left-radius: calc({{TOP}}{{UNIT}} - {{general_border_width.TOP}}{{general_border_width.UNIT}});',
				],
				'default' => [
					'top' => 5,
					'right' => 5,
					'bottom' => 5,
					'left' => 5,
				],			
				'condition' => [
					'layout!' => 'circle',
				],
			]
		);

		$this->add_control(
			'prline_section',
			[
				'label' => esc_html__( 'Progress Line', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'circle_prline_bg_type',
            [
                'label' => esc_html__( 'Background Type', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'color',
                'options' => [
                    'color' => [
                        'title' => esc_html__( 'Classic', 'designer' ),
                        'icon' => 'fa fa-paint-brush',
                    ],
                    'gradient' => [
                        'title' => esc_html__( 'Gradient', 'designer' ),
                        'icon' => 'fa fa-barcode',
                    ],
                ],
                'condition' => [
					'layout' => 'circle',
				],
            ]
        );

		$this->add_control(
			'circle_prline_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'condition' => [
					'circle_prline_bg_type' => 'color',
					'layout' => 'circle',
				],
			]
		);

		$this->add_control(
			'circle_prline_bg_color_a',
			[
				'label' => esc_html__( 'Background Color A', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7E7E7E',
				'condition' => [
					'circle_prline_bg_type' => 'gradient',
					'layout' => 'circle',
				],
			]
		);

		$this->add_control(
			'circle_prline_bg_color_b',
			[
				'label' => esc_html__( 'Background Color B', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'condition' => [
					'circle_prline_bg_type' => 'gradient',
					'layout' => 'circle',
				],
			]
		);

		$this->add_control(
			'circle_prline_grad_angle',
			[
				'label' => esc_html__( 'Gradient Angle', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 360,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition' => [
					'circle_prline_bg_type' => 'gradient',
					'layout' => 'circle',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'prline_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .designer-prbar-hr-line-inner, {{WRAPPER}} .designer-prbar-vr-line-inner',
				'condition' => [
					'layout!' => 'circle',
				],
			]
		);

		$this->add_control(
			'prline_round',
			[
				'label' => esc_html__( 'Rounded Line', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-circle-prline' => 'stroke-linecap: round;',
				],
				'prefix_class' => 'designer-prbar-prline-rounded-',
				'render_type' => 'template',
			]
		);

        $this->add_control(
			'show_stripe',
			[
				'label' => esc_html__( 'Show Stripe', 'designer' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
                'prefix_class'  => 'designer-prbar-stripe-',
				'condition' => [
					'layout!' => 'circle',
				],
			]
		);

        $this->add_control(
			'stripe_animation',
			[
				'label' => esc_html__( 'Stripe Animation', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'anim-right',
				'options' => [
					'anim-right' => esc_html__( 'Animation From Right', 'designer' ),
					'anim-left' => esc_html__( 'Animation From Left', 'designer' ),
				],
                'prefix_class'  => 'designer-prbar-stripe-',
                'condition' => [
                    'show_stripe'   => 'yes'
                ]
			]
		);

        $this->add_control(
			'title_section',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'  => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C7C6C6',
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-prbar-title',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'title_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}.designer-prbar-layout-hr-line .designer-prbar-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-layout-circle.designer-pbar-title-pos-inside .designer-prbar-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-layout-circle.designer-pbar-title-pos-outside .designer-prbar-title' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-layout-vr-line .designer-prbar-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'subtitle_section',
			[
				'label' => esc_html__( 'Subtitle', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'  => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C7C6C6',
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-subtitle' => 'color: {{VALUE}}',
				],
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-prbar-subtitle',
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}}.designer-prbar-layout-hr-line .designer-prbar-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-layout-circle.designer-pbar-title-pos-inside .designer-prbar-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-layout-circle.designer-pbar-title-pos-outside .designer-prbar-subtitle' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-layout-vr-line .designer-prbar-subtitle' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->add_control(
			'counter_section',
			[
				'label' => esc_html__( 'Counter', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'counter_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'counter_color',
			[
				'label'  => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C7C6C6',
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-counter' => 'color: {{VALUE}}',
				],
				'condition' => [
					'counter_switcher' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'counter_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-prbar-counter',
				'condition' => [
					'counter_switcher' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'counter_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}}.designer-prbar-layout-hr-line .designer-prbar-counter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-layout-vr-line .designer-prbar-counter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-prbar-layout-circle.designer-pbar-counter-pos-outside .designer-prbar-counter' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_position!' => 'inside',
					'layout!' => 'hr-line'
				],
			]
		);

		$this->add_control(
			'counter_prefix_section',
			[
				'label' => esc_html__( 'Counter Prefix', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_prefix!' => ''
				],
			]
		);

		$this->add_control(
			'counter_prefix_vr_position',
			[
				'label' => esc_html__( 'Vertical Position', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'designer' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'designer' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'designer' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'middle',
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-counter-value-prefix' => '-webkit-align-self: {{VALUE}}; align-self: {{VALUE}};',
				],
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_prefix!' => ''
				],
			]
		);

		$this->add_responsive_control(
			'counter_prefix_size',
			[
				'label' => esc_html__( 'Font Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-counter-value-prefix' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_prefix!' => ''
				],
			]
		);

		$this->add_responsive_control(
			'counter_prefix_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-counter-value-prefix' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_prefix!' => ''
				],
			]
		);

		$this->add_control(
			'counter_suffix_section',
			[
				'label' => esc_html__( 'Counter Suffix', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_suffix!' => ''
				],
			]
		);

		$this->add_control(
			'counter_suffix_vr_position',
			[
				'label' => esc_html__( 'Vertical Position', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'designer' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'designer' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'designer' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'middle',
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-counter-value-suffix' => '-webkit-align-self: {{VALUE}}; align-self: {{VALUE}};',
				],
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_suffix!' => ''
				],
			]
		);

		$this->add_responsive_control(
			'counter_suffix_size',
			[
				'label' => esc_html__( 'Font Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-counter-value-suffix' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_suffix!' => ''
				],
			]
		);

		$this->add_responsive_control(
			'counter_suffix_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-prbar-counter-value-suffix' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'counter_switcher' => 'yes',
					'counter_suffix!' => ''
				],
			]
		);


        $this->end_controls_section(); 
    }

    protected function render_progress_bar_counter() {
		// Get Settings
		$settings = $this->get_settings();

		?>

		<div class="designer-prbar-counter">

			<?php if ( '' !== $settings['counter_prefix'] ) : ?>
			<span class="designer-prbar-counter-value-prefix"><?php echo esc_html( $settings['counter_prefix'] ); ?></span>
			<?php endif; ?>

			<?php if ( '' !== $settings['counter_value'] ) : ?>
			<span class="designer-prbar-counter-value">0</span>
			<?php endif; ?>

			<?php if ( '' !== $settings['counter_suffix'] ) : ?>
			<span class="designer-prbar-counter-value-suffix"><?php echo esc_html( $settings['counter_suffix'] ); ?></span>
			<?php endif; ?>

		</div>

		<?php
	}

    protected function render_progress_bar_content( $position ) {
		
		$settings = $this->get_settings();
		$is_counter = ( 'yes' === $settings['counter_switcher'] && $position === $settings['counter_position'] );
		$is_title = ( '' !== $settings['title'] && $position === $settings['title_position'] );
		$is_subtitle = ( '' !== $settings['subtitle'] && $position === $settings['title_position'] );
		$do_follow = 'yes' === $this->get_settings_for_display('counter_follow_line') && 'inside' === $settings['counter_position'] ? true : false;

		if ( $is_title || $is_subtitle || $is_counter ) {
			
			echo '<div class="designer-prbar-content elementor-clearfix">';

				if ( $is_title || $is_subtitle ) {
					echo '<div class="designer-prbar-title-wrap">';
						if ( $is_title ) {
							echo '<div class="designer-prbar-title">'. esc_html( $settings['title'] )  .'</div>';
						}

						if ( $is_title ) {
							echo '<div class="designer-prbar-subtitle">'. esc_html( $settings['subtitle'] )  .'</div>';
						}
					echo '</div>';
				}
				
				if ( $is_counter && ! $do_follow ) {
					$this->render_progress_bar_counter();
				}
			
			echo '</div>';
		}
	}

    protected function render_progress_bar_hr_line(){

        // Get Settings
		$settings = $this->get_settings();

        $this->render_progress_bar_content('outside');

        ?>

        <div class="designer-prbar-hr-line">
			<div class="designer-prbar-hr-line-inner designer-anim-timing-<?php echo esc_attr( $settings['anim_timing'] ); ?>">
				<?php
					if ( 'yes' === $this->get_settings_for_display('counter_follow_line') && 'inside' === $settings['counter_position'] ) {
						$this->render_progress_bar_counter();
					}
				?>
			</div>
			<?php $this->render_progress_bar_content('inside'); ?>
		</div>


        <?php

    }

	protected function render_progress_bar_circle( $percent ){
		// Get Settings
		$settings = $this->get_settings();

		$circle_stocke_bg = $settings['circle_prline_bg_color'];
		$circle_size = $settings['circle_size']['size'];
		$circle_half_size = ( $circle_size / 2 );
		$circle_viewbox = sprintf( '0 0 %1$s %1$s', $circle_size );
		$circle_line_width = $settings['line_width']['size'] ? $settings['line_width']['size'] : 15;
		$circle_prline_width = $settings['prline_width']['size'] ? $settings['prline_width']['size'] : 15;
		$circle_radius = $circle_half_size - ( $circle_prline_width / 2 );

		if ( $circle_line_width > $circle_prline_width ) {
			$circle_radius = $circle_half_size - ( $circle_line_width / 2 );
		}

		if ( $circle_prline_width > $circle_half_size ) {
			$circle_radius = $circle_half_size / 2;
			$circle_prline_width = $circle_half_size;
		}

		if ( $circle_line_width > $circle_half_size ) {
			$circle_radius = $circle_half_size / 2;
			$circle_line_width = $circle_half_size;
		}

		$circle_perimeter = 2 * M_PI * $circle_radius;
		$circle_offset = $circle_perimeter - ( ( $circle_perimeter / 100 ) * $percent );

		$circle_options = [
			'circleOffset' => $circle_offset,
			'circleSize' => $circle_size,
			'circleViewbox' => $circle_viewbox,
			'circleRadius' => $circle_radius,
			'circleLineWidth' => $circle_line_width,
			'circlePrlineWidth' => $circle_prline_width,
			'circleOffset' => $circle_offset,
			'circleDasharray' => $circle_perimeter,
		];

		$this->add_render_attribute( 'designer-prbar-circle', [
			'class' => 'designer-prbar-circle',
			'data-circle-options' => wp_json_encode( $circle_options ),
		] );

		?>

		<div <?php echo $this->get_render_attribute_string( 'designer-prbar-circle' ); ?>>

			<svg class="designer-prbar-circle-svg" viewBox="<?php echo esc_attr( $circle_viewbox ); ?>" >
				
				<?php if ( 'gradient' === $settings['circle_prline_bg_type'] ) : ?>

					<?php $circle_stocke_bg = 'url( #designer-prbar-circle-gradient-'. esc_attr($this->get_id()) .' )'; ?>
						
					<linearGradient id="designer-prbar-circle-gradient-<?php echo esc_attr($this->get_id()); ?>" gradientTransform="rotate(<?php echo esc_html($settings['circle_prline_grad_angle']['size']); ?> 0.5 0.5)" gradientUnits="objectBoundingBox"  x1="-0.5" y1="0.5" x2="1.5" y2="0.5">
						<stop offset="0%" stop-color="<?php echo esc_attr( $settings['circle_prline_bg_color_a'] ); ?>"></stop>
						<stop offset="100%" stop-color="<?php echo esc_attr( $settings['circle_prline_bg_color_b'] ); ?>"></stop>
					</linearGradient>

				<?php endif; ?>
				
				<circle class="designer-prbar-circle-line"
					cx="<?php echo esc_attr( $circle_half_size ); ?>"
					cy="<?php echo esc_attr( $circle_half_size ); ?>"
					r="<?php echo esc_attr( $circle_radius ); ?>"
					stroke-width="<?php echo esc_attr( $circle_line_width ); ?>"
				/>

				<circle class="designer-prbar-circle-prline designer-anim-timing-<?php echo esc_attr( $settings['anim_timing'] ); ?>"
					cx="<?php echo esc_attr( $circle_half_size ); ?>"
					cy="<?php echo esc_attr( $circle_half_size ); ?>"
					r="<?php echo esc_attr( $circle_radius ); ?>"
					stroke="<?php echo esc_attr( $circle_stocke_bg ); ?>"
					fill="none"
					stroke-width="<?php echo esc_attr( $circle_prline_width ); ?>"
					style="stroke-dasharray: <?php echo esc_attr($circle_perimeter); ?>; stroke-dashoffset: <?php echo esc_attr($circle_perimeter); ?>;"
				/>

			</svg>

			<?php $this->render_progress_bar_content( 'inside' ); ?>
		</div>

		<?php

		$this->render_progress_bar_content( 'outside' );

		
	}

	protected function render_progress_bar_vr_line(){
		 // Get Settings
		 $settings = $this->get_settings();

		$is_title = ( '' !== $settings['title'] );
		$is_subtitle = ( '' !== $settings['subtitle'] );
		
		 ?>

		<div class="designer-prbar-counter">
			<?php if ( '' !== $settings['counter_prefix'] ) : ?>
			<span class="designer-prbar-counter-value-prefix"><?php echo esc_html( $settings['counter_prefix'] ); ?></span>
			<?php endif; ?>

			<?php if ( '' !== $settings['counter_value'] ) : ?>
			<span class="designer-prbar-counter-value">0</span>
			<?php endif; ?>

			<?php if ( '' !== $settings['counter_suffix'] ) : ?>
			<span class="designer-prbar-counter-value-suffix"><?php echo esc_html( $settings['counter_suffix'] ); ?></span>
			<?php endif; ?>
		</div>

		<div class="designer-prbar-vr-line">
			<div class="designer-prbar-vr-line-inner designer-anim-timing-<?php echo esc_attr( $settings['anim_timing'] ); ?>"></div>
		</div>

		<?php if ( $is_title || $is_subtitle ):?>	
			<?php if ( $is_title ) : ?>
				<div class="designer-prbar-title"> <?php echo esc_html( $settings['title'] ) ; ?> </div>
			<?php endif; ?>

			<?php if ( $is_subtitle ) : ?>
				<div class="designer-prbar-subtitle"> <?php echo esc_html( $settings['subtitle'] ) ; ?> </div>
			<?php endif; ?>
		<?php endif; ?>


 
		 <?php

	}


    protected function render() {

        // Get Settings
		$settings = $this->get_settings();

       
        $prbar_counter_percent = round( ( $settings['counter_value'] / $settings['max_value'] ) * 100 );

        $progress_bar_options = [
			'counterValue' => $settings['counter_value'],
			'counterValuePercent' => $prbar_counter_percent,
			'counterSeparator' => $settings['counter_separator'],
			'animDuration' => ( $settings['anim_duration'] * 1000 ),
			'animDelay' => ( $settings['anim_delay'] * 1000 ),
			'loop' => isset($settings['anim_loop']) ? $settings['anim_loop'] : '',
			'loopDelay' => isset($settings['anim_loop_delay']) ? $settings['anim_loop_delay'] : '',
		];

        $this->add_render_attribute( 'designer-progress-bar', [
			'class' => 'designer-progress-bar',
			'data-options' => wp_json_encode( $progress_bar_options ),
		] );

        ?>
        <div <?php echo $this->get_render_attribute_string( 'designer-progress-bar' ); ?>>

            <?php
               switch ($settings['layout']) {
                    case 'circle':
						$this->render_progress_bar_circle($prbar_counter_percent);
                        break;

                    case 'hr-line':
                        $this->render_progress_bar_hr_line();
                        break;
                    
                    case 'vr-line':
						$this->render_progress_bar_vr_line();
                        break;

                    default:
						$this->render_progress_bar_hr_line();
                        break;
                }
            ?>

        </div>


        <?php


    }

}