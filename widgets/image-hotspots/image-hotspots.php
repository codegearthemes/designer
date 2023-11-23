<?php
namespace Designer\Widgets\Image_Hotspots;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Hotspots extends Widget_base {

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

        wp_register_style( 'image-hotspots', \Designer::plugin_url().'widgets/image-hotspots/assets/image-hotspots.css', array(), '1.0.0', 'all' );
        wp_register_script( 'image-hotspots', \Designer::plugin_url().'widgets/image-hotspots/assets/image-hotspots.js', array('jquery','elementor-frontend'), '1.0.0', true );

    }

    public function get_name() {
		return 'image-hotspots';
	}

    public function get_title() {
		return esc_html__( 'Image Hotspots', 'designer' );
	}

    public function get_icon() {
		return 'designer-icon eicon-image-hotspot';
	}

    public function get_categories() {
		return [ 'designer'];
	}

	public function get_keywords() {
		return [ 'designer', 'image hotspots' ];
	}

    public function get_style_depends() {
		return [ 'image-hotspots' ];
	}

    public function get_script_depends() {
		return [ 'image-hotspots' ];
	}


    protected function register_controls() {

        // Section: Image ------------
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'designer' ),
			]
		);

        $this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
				'separator' => 'before',
			]
		);

        $this->end_controls_section(); // End Controls Section

        // Settings Control
        $this->_hotspots_settings_control();
        $this->_tooltips_settings_control();

        // Styles Control
        $this->_hotspots_styles_control();
        $this->_tooltips_styles_control();


       



    }

    protected function _hotspots_settings_control(){
         // Section: Hotspots ---------
		$this->start_controls_section(
			'section_hotspots',
			[
				'label' => esc_html__( 'Hotspots', 'designer' ),
			]
		);

        $repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_hotspot_item' );

		$repeater->start_controls_tab(
			'tab_hotspot_item_content',
			[
				'label' => esc_html__( 'Content', 'designer' ),
			]
		);

		$repeater->add_control(
			'hotspot_icon',
			[
				'label' => esc_html__( 'Select Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'hotspot_text',
			[
				'label' => esc_html__( 'Text', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'hotspot_custom_color',
			[
				'label' => esc_html__( 'Custom Color', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'hotspot_custom_text_color',
			[
				'label' => esc_html__( 'Text Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-hotspot-content' => 'color: {{VALUE}}',
				],
				'condition' => [
					'hotspot_custom_color' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'hotspot_custom_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-hotspot-content' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}}.designer-hotspot-anim-glow:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'hotspot_custom_color' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'hotspot_tooltip',
			[
				'label' => esc_html__( 'Tooltip', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'hotspot_tooltip_text',
			[
				'label' => '',
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Tooltip Content',
				'condition' => [
					'hotspot_tooltip' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'hotspot_link',
			[
				'label' => esc_html__( 'Link', 'designer' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://www.your-link.com', 'designer' ),
				'separator' => 'before',
				
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_hotspot_item_position',
			[
				'label' => esc_html__( 'Position', 'designer' ),
			]
		);

		$repeater->add_control(
			'hotspot_hr_position',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Horizontal Position (%)', 'designer' ),
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.designer-hotspot-item' => 'left: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'hotspot_vr_position',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Vertical Position (%)', 'designer' ),
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.designer-hotspot-item' => 'top: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'hotspot_items',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'hotspot_text' => '',
						'hotspot_hr_position' => [
							'unit' => '%',
							'size' => 30,
						],
						'hotspot_vr_position' => [
							'unit' => '%',
							'size' => 40,
						],
					],
					[
						'hotspot_text' => '',
						'hotspot_hr_position' => [
							'unit' => '%',
							'size' => 60,
						],
						'hotspot_vr_position' => [
							'unit' => '%',
							'size' => 20,
						],
					],
					
				],
				'title_field' => '{{{ hotspot_text }}}',
			]
		);

        $this->add_control(
			'hotspot_animation',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Animation', 'designer' ),
				'default' => 'glow',
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'glow' => esc_html__( 'Glow', 'designer' ),
					'pulse' => esc_html__( 'Pulse', 'designer' ),
					'shake' => esc_html__( 'Shake', 'designer' ),
					'swing' => esc_html__( 'Swing', 'designer' ),
					'tada' => esc_html__( 'Tada', 'designer' ),
				],
				'render_type' => 'template',
			]
		);

        $this->end_controls_section();
    }

    protected function _tooltips_settings_control() {
        
         // Section: Tooltips ---------
		$this->start_controls_section(
			'section_tooltips',
			[
				'label' => esc_html__( 'Tooltips', 'designer' ),
			]
		);

        $this->add_control(
            'tooltip_trigger',
            [
                'label' => esc_html__( 'Show Tooltips', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'by Default', 'designer' ),
					'click' => esc_html__( 'on Click', 'designer' ),
					'hover' => esc_html__( 'on Hover', 'designer' ),
				],
				'prefix_class' => 'designer-hotspot-trigger-',
				'render_type' => 'template',
				'separator' => 'after',
            ]
        );

        $this->add_control(
            'tooltip_position',
            [
                'label' => esc_html__( 'Position', 'designer' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__( 'Top', 'designer' ),
                    'bottom' => esc_html__( 'Bottom', 'designer' ),
                    'left' => esc_html__( 'Left', 'designer' ),
                    'right' => esc_html__( 'Right', 'designer' ),
                ],
                'prefix_class' => 'designer-hotspot-tooltip-position-',
                'render_type' => 'template',
            ]
        );

        $this->add_responsive_control(
            'tooltip_align',
            [
                'label' => esc_html__( 'Alignment', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'designer' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'designer' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'designer' ),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-tooltip' => 'text-align: {{VALUE}}',
				],
            ]
        );

        $this->add_responsive_control(
			'tooltip_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 115,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->add_control(
			'tooltip_triangle',
			[
				'label' => esc_html__( 'Triangle', 'designer' ),
				'type' => Controls_Manager::SWITCHER,				
				'default' => 'yes',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'tooltip_triangle_size',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Size', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-tooltip:before' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-top .designer-hotspot-tooltip' => 'margin-top: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-bottom .designer-hotspot-tooltip' => 'margin-bottom: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-left .designer-hotspot-tooltip' => 'margin-left: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-right .designer-hotspot-tooltip' => 'margin-right: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-top .designer-hotspot-tooltip:before' => 'bottom: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-bottom .designer-hotspot-tooltip:before' => 'top: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-right .designer-hotspot-tooltip:before' => 'left: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-left .designer-hotspot-tooltip:before' => 'right: calc(-{{SIZE}}{{UNIT}} + 1px);',
				],
				'condition' => [
					'tooltip_triangle' => 'yes',
				],
			]
		);

        $this->add_control(
			'tooltip_distance',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Distance', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}}.designer-hotspot-tooltip-position-top .designer-hotspot-tooltip' => 'top: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-bottom .designer-hotspot-tooltip' => 'bottom: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-left .designer-hotspot-tooltip' => 'left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-right .designer-hotspot-tooltip' => 'right: -{{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->add_control(
			'tooltip_animation',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Animation', 'designer' ),
				'default' => 'fade',
				'options' => [
					'shift-toward' => esc_html__( 'Shift Toward', 'designer' ),
					'fade' => esc_html__( 'Fade', 'designer' ),
					'scale' => esc_html__( 'Scale', 'designer' ),
				],
				'prefix_class' => 'designer-tooltip-effect-',
				'render_type' => 'template',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'tooltip_anim_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.2,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-tooltip' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
				],		
			]
		);

        $this->end_controls_section();
    }

    protected function _hotspots_styles_control() {
        $this->start_controls_section(
			'section_style_hotspots',
			[
				'label' => esc_html__( 'Hotspots', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'hotspot_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-content' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'hotspot_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-content' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .designer-hotspot-anim-glow:before' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'hotspot_border_color',
			[
				'label' => esc_html__( 'Border Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-content' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'hotspot_box_shadow',
				'selector' => '{{WRAPPER}} .designer-hotspot-content',
			]
		);

		$this->add_control(
			'hotspot_typography_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'hotspot_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-hotspot-text',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'icon_section',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label' => esc_html__( 'Position', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'right',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'designer' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'designer' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'designer-hotspot-icon-position-',
			]
		);

        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'designer' ),
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
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-content i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'icon_box_size',
			[
				'label' => esc_html__( 'Box Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 35,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-content' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'icon_distance',
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
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}}.designer-hotspot-icon-position-left .designer-hotspot-text ~ i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-hotspot-icon-position-right .designer-hotspot-text ~ i' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'hotspot_border_type',
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
					'{{WRAPPER}} .designer-hotspot-content' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'hotspot_border_width',
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
					'{{WRAPPER}} .designer-hotspot-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'hotspot_border_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'hotspot_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom' => 50,
					'left' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .designer-hotspot-anim-glow:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);




        $this->end_controls_section();

    }

    protected function _tooltips_styles_control() {
        // Section: Tooltips ---------
		$this->start_controls_section(
			'section_style_tooltips',
			[
				'label' => esc_html__( 'Tooltips', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'tooltip_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-tooltip' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'tooltip_bg_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Background Color', 'designer' ),
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-tooltip' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-top .designer-hotspot-tooltip:before' => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-bottom .designer-hotspot-tooltip:before' => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-left .designer-hotspot-tooltip:before' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}}.designer-hotspot-tooltip-position-right .designer-hotspot-tooltip:before' => 'border-right-color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .designer-hotspot-tooltip',
			]
		);

        $this->add_control(
			'tooltip_typography_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tooltip_typography',
				'label' => esc_html__( 'Typography', 'designer' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-hotspot-tooltip',
			]
		);

		$this->add_responsive_control(
			'tooltip_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', ],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tooltip_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-hotspot-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->end_controls_section();
    }


    protected function render() {

        $settings = $this->get_settings_for_display();

        $item_count = 0;

        $image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['image']['id'], 'image_size', $settings );

        if ( ! $image_src ) {
			$image_src = $settings['image']['url'];
		}

        $hotsposts_options = [	
			'tooltipTrigger' => $settings['tooltip_trigger'],
		];

        $this->add_render_attribute( 'hotspots_attribute', 'class', 'designer-image-hotspots' );
		$this->add_render_attribute( 'hotspots_attribute', 'data-options', wp_json_encode( $hotsposts_options ) );

        ?>
        <div <?php echo $this->get_render_attribute_string( 'hotspots_attribute'); ?>>

            <?php if ( $image_src ) : ?>
				<div class="designer-hotspot-image">
					<img src="<?php echo esc_url( $image_src ); ?>" >
				</div>
			<?php endif; ?>

            <div class="designer-hotspot-item-container">

                <?php foreach ( $settings['hotspot_items'] as  $item ) : ?>
                    <?php
                    
                    $hotspot_tag = 'div';

                    $this->add_render_attribute('hotspot_item_attribute'.$item_count, 'class', 'designer-hotspot-item elementor-repeater-item-'.esc_attr( $item['_id'] ));

                    if ( 'none' !== $settings['hotspot_animation'] ) {
						$this->add_render_attribute( 'hotspot_item_attribute'. $item_count, 'class', 'designer-hotspot-anim-'. $settings['hotspot_animation'] );
					}

                    $this->add_render_attribute( 'hotspot_content_attribute'. $item_count, 'class', 'designer-hotspot-content' );

                    if ( '' !== $item['hotspot_link']['url'] ) {

                        $hotspot_tag = 'a';

						$this->add_render_attribute( 'hotspot_content_attribute'. $item_count, 'href', $item['hotspot_link']['url'] );

						if ( $item['hotspot_link']['is_external'] ) {
							$this->add_render_attribute( 'hotspot_content_attribute'. $item_count, 'target', '_blank' );
						}

						if ( $item['hotspot_link']['nofollow'] ) {
							$this->add_render_attribute( 'hotspot_content_attribute'. $item_count, 'nofollow', '' );
						}
                        
                    }
                    
                    ?>
                    <div <?php echo $this->get_render_attribute_string( 'hotspot_item_attribute'. $item_count ); ?>>
                        <<?php echo esc_attr( $hotspot_tag ); ?> <?php echo $this->get_render_attribute_string( 'hotspot_content_attribute'. $item_count ); ?>>
                            <?php if ( '' !== $item['hotspot_text'] ) : ?>
                                    <span class="designer-hotspot-text"><?php echo esc_html( $item['hotspot_text'] ); ?></span>
							<?php endif; ?>

                            <?php if ( '' !== $item['hotspot_icon']['value'] && 'svg' !== $item['hotspot_icon']['library'] ) : ?>
								<i class="<?php echo esc_attr($item['hotspot_icon']['value']); ?>"></i>
							<?php elseif ( '' !== $item['hotspot_icon']['value'] && 'svg' == $item['hotspot_icon']['library'] ) : ?>
								<img src="<?php echo $item['hotspot_icon']['value']['url'] ?>">
							<?php endif; ?>

                        </<?php echo esc_attr( $hotspot_tag ); ?>>

                        <?php if ( 'yes' === $item['hotspot_tooltip'] && '' !== $item['hotspot_tooltip_text'] ) : ?>
							<div class="designer-hotspot-tooltip"><?php echo wp_kses_post($item['hotspot_tooltip_text']); ?></div>						
						<?php endif; ?>

                    </div>

                <?php 

                $item_count++;
            
            endforeach; 
            
            ?>

            </div>

        </div>

        <?php

    }



}