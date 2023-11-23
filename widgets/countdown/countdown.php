<?php

namespace Designer\Widgets\Countdown;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Countdown extends Widget_Base{

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

        wp_register_script( 'countdown-timer', \Designer::plugin_url().'widgets/countdown/assets/countdown.js', array('elementor-frontend'), '1.0.0', true );

    }

    public function get_name() {
		return 'countdown';
	}

    public function get_title() {
		return esc_html__( 'Countdown', 'designer' );
	}

    public function get_icon() {
		return 'designer-icon eicon-countdown';
	}

    public function get_custom_help_url() {
		return 'https://wordpress.org/support/plugin/designer/';
	}

    public function get_categories() {
		return [ 'designer' ];
	}

    public function get_keywords() {
		return [
			'countdown',
            'timer',
            'designer',
		];
	}

	public function get_script_depends() {
        return [ 'countdown-timer' ];
    }

    protected function register_controls(){

        $this->start_controls_section(
            '_general_settings',
            [
                'label' => esc_html__('General', 'designer'),
                "tab"	=> Controls_Manager::TAB_CONTENT,
            ]
        );

    
        $this->add_control(
			'due_date',
			[
				'label' => esc_html__( 'Date', 'designer' ),
				'type' => Controls_Manager::DATE_TIME,
                'default' => date( 'Y-m-d H:i', strtotime( '+1 month' ) ),
				'separator' => 'before',
             
			]
            
		);

        $this->add_control(
			'countdown_format',
			[
				'label' => esc_html__( 'Format', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'show-all',
				'options' => [
					'show-all'      => esc_html__( 'Show All', 'designer' ),
					'hide-months'      => esc_html__( 'Hide Months', 'designer' ),
                    'hide-seconds'  => esc_html__('Hide Seconds', 'designer'),
					'hide-minutes-seconds'  => esc_html__('Hide Minutes and Seconds', 'designer'),
					
				],
                
			]
		);

        $this->add_control(
			'show_label',
			[
				'label' => esc_html__( 'Show Labels', 'designer' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'separator' => 'before',
			]
		);

        $this->add_control(
			'show_separator',
			[
				'label' => esc_html__( 'Show Separator', 'designer' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
                'separator' => 'before',
			]
		);

        $this->end_controls_section();

        // Labels

        $this->start_controls_section(
            '_label_settings',
            [
                'label' => esc_html__('Labels', 'designer'),
                "tab"	=> Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'show_label' => 'yes',
                ]
            ]
        );

        
        $this->start_controls_tabs(
			'label_tabs'
		);

		$this->start_controls_tab(
			'singular_tab',
			[
				'label' => esc_html__( 'Singular', 'designer' ),
			]
		);

        $this->add_control(
			'month_label',
			[
				'label' => esc_html__( 'Month label', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Month', 'designer' ),
			]
		);

        $this->add_control(
			'day_label',
			[
				'label' => esc_html__( 'Day label', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Day', 'designer' ),
			]
		);

        $this->add_control(
			'hour_label',
			[
				'label' => esc_html__( 'Hour label', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Hour', 'designer' ),
			]
		);

        $this->add_control(
			'minute_label',
			[
				'label' => esc_html__( 'Minute label', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Minute', 'designer' ),
			]
		);

        $this->add_control(
			'second_label',
			[
				'label' => esc_html__( 'Second label', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Second', 'designer' ),
			]
		);

        $this->end_controls_tab();
        $this->start_controls_tab(
			'plural_tab',
			[
				'label' => esc_html__( 'Plural', 'designer' ),
			]
		);

        $this->add_control(
			'month_label_plural',
			[
				'label' => esc_html__( 'Month label Plural', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Months', 'designer' ),
			]
		);

        $this->add_control(
			'day_label_plural',
			[
				'label' => esc_html__( 'Month label Plural', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Days', 'designer' ),
			]
		);

        $this->add_control(
			'hour_label_plural',
			[
				'label' => esc_html__( 'Month label Plural', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Hours', 'designer' ),
			]
		);

        $this->add_control(
			'minute_label_plural',
			[
				'label' => esc_html__( 'Month label Plural', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Minutes', 'designer' ),
			]
		);

        $this->add_control(
			'second_label_plural',
			[
				'label' => esc_html__( 'Month label Plural', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Seconds', 'designer' ),
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'label_display',
			[
				'label' => esc_html__( 'Display', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'block',
				'options' => [
					'block' => esc_html__( 'Block', 'designer' ),
					'inline' => esc_html__( 'Inline', 'designer' ),	
				],
				'selectors_dictionary' => [
					'inline' => 'inline-block',
					'block' => 'block'
				],
				'selectors' => [
					'{{WRAPPER}} .designer-digit' => 'display: {{VALUE}}',
					'{{WRAPPER}} .designer-label' => 'display: {{VALUE}}',
				],
                'separator' => 'before',
				
			]
		);

        $this->end_controls_section();

        // Expire Actions

        $this->start_controls_section(
			'section_actions',
			[
				'label' => esc_html__( 'Expire Actions', 'designer' ),
			]
		);

		$this->add_control(
			'timer_actions',
			[
				'label' => esc_html__( 'Actions After Timer Expires', 'designer' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'options' => [
					'hide-timer' => esc_html__( 'Hide Timer', 'designer' ),
					'hide-element' => esc_html__( 'Hide Element', 'designer' ),
					'message' => esc_html__( 'Display Message', 'designer' ),
					'redirect' => esc_html__( 'Redirect', 'designer' ),
				],
				'multiple' => true,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'hide_element_selector',
			[
				'label' => esc_html__( 'CSS Selector to Hide Element', 'designer' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'separator' => 'before',
				'condition' => [
					'timer_actions' => 'hide-element',
				],
			]
		);

		$this->add_control(
			'display_message_text',
			[
				'label' => esc_html__( 'Display Message', 'designer' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '',
				'separator' => 'before',
				'condition' => [
					'timer_actions' => 'message',
				],
			]
		);

		$this->add_control(
			'redirect_url',
			[
				'label' => esc_html__( 'Redirect URL', 'designer' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'separator' => 'before',
				'condition' => [
					'timer_actions' => 'redirect',
				],
			]
		);

        $this->end_controls_section();

        // Style General Controls

        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'General', 'designer' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'general_bg_color',
				'label'	=> esc_html__('Background Color', 'designer'),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .digit-wrapper',
			]
		);

		$this->add_responsive_control(
			'general_gutter',
			[
				'label' => esc_html__( 'Gutter', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-countdown' => 'gap: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'general_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 800,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .digit-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'general_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 5,
					'right' => 5,
					'bottom' => 5,
					'left' => 5,
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .digit-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'general_border',
				'label' => esc_html__( 'Border', 'designer' ),
				'fields_options' => [
					'color' => [
						'default' => '#E8E8E8',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
				],
				'selector' => '{{WRAPPER}} .digit-wrapper',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'general_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 5,
					'right' => 5,
					'bottom' => 5,
					'left' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .digit-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
	        'general_box_shadow_divider',
	        [
	            'type' => Controls_Manager::DIVIDER,
	            'style' => 'thick',
	        ]
	    );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'general_box_shadow',
				'selector' => '{{WRAPPER}} .digit-wrapper',
			]
		);

		$this->end_controls_section();

		// Style Content Controls

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_align',
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
					'{{WRAPPER}} .digit-wrapper' => 'text-align: {{VALUE}}',
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'numbers_color',
			[
				'label' => esc_html__( 'Numbers Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-digit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'numbers_bg_color',
			[
				'label' => esc_html__( 'Numbers Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-digit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-digit',
			]
		);

		
		$this->add_responsive_control(
			'numbers_padding',
			[
				'label' => esc_html__( 'Numbers Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 40,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .designer-digit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'labels_color',
			[
				'label' => esc_html__( 'Labels Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-label' => 'color: {{VALUE}};',
				],
	            'separator' => 'before'
			]
		);

		$this->add_control(
			'labels_bg_color',
			[
				'label' => esc_html__( 'Labels Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-label' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'labels_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-label',
			]
		);

		$this->add_responsive_control(
			'labels_padding',
			[
				'label' => esc_html__( 'Labels Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .designer-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label' => esc_html__( 'Separator Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-countdown-separator span' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'separator_size',
			[
				'label' => esc_html__( 'Separator Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-countdown-separator span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_separator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'separator_margin',
			[
				'label' => esc_html__( 'Dots Margin', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-countdown-separator span:first-child' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'separator_circle',
			[
				'label' => esc_html__( 'Separator Border Radius', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'selectors_dictionary' => [
					'yes' => '50%;',
					'' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .designer-countdown-separator span' => 'border-radius: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

		// Section: Content ----------
		$this->start_controls_section(
			'section_style_message',
			[
				'label' => esc_html__( 'Message', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'timer_actions' => 'message',
				],
			]
		);

		$this->add_responsive_control(
            'message_align',
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
					'{{WRAPPER}} .designer-countdown-message' => 'text-align: {{VALUE}}',
				],
            ]
        );

		$this->add_control(
			'message_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-countdown-message' => 'color: {{VALUE}};',
				],
	            'separator' => 'before'
			]
		);

		$this->add_control(
			'message_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-countdown-message' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'message_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .designer-countdown-message',
			]
		);

		$this->add_responsive_control(
			'message_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .designer-countdown-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'message_top_distance',
			[
				'label' => esc_html__( 'Top Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-countdown-message' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); // End Controls Section

    }

    public function get_countdown_attributes( $settings ) {
		// Expired Actions
        $atts .= ' data-actions="'. esc_attr( $this->get_expired_actions_json( $settings ) ) .'"';

        // Date
        $atts .= ' data-date="'. esc_attr( gmdate( 'Y/m/d H:i:s', strtotime( $settings['due_date'] ) )  ) .'"';

		// Show Hide Atts Only 
		if($settings['countdown_format'] !== 'show-all'){
			$atts .= 'data-hide ="'.$settings['countdown_format'].'"';
		}

        // Label
        $date_formats = array(
            'month'  => array(
                'default' => esc_html__( 'Month', 'designer' ),
                'plural'  => esc_html__( 'Months', 'designer' ),
            ),
            'day'    => array(
                'default' => esc_html__( 'Day', 'designer' ),
                'plural'  => esc_html__( 'Days', 'designer' ),
            ),
            'hour'   => array(
                'default' => esc_html__( 'Hour', 'designer' ),
                'plural'  => esc_html__( 'Hours', 'designer' ),
            ),
            'minute' => array(
                'default' => esc_html__( 'Minute', 'designer' ),
                'plural'  => esc_html__( 'Minutes', 'designer' ),
            ),
            'second' => array(
                'default' => esc_html__( 'Second', 'designer' ),
                'plural'  => esc_html__( 'Seconds', 'designer' ),
            ),
        );

		if( 'yes' === $settings['show_label']){
			foreach( $date_formats as $key => $value){
				if(!empty($settings[$key.'_label'])){
					$atts .= 'data-'.$key.'-label = "'.$settings[$key.'_label'].'"';
				}else{
					$atts .= 'data-'.$key.'-label = "'.$value['default'].'"';
				}
	
				if(!empty($settings[$key.'_label_plural'])){
					$atts .= 'data-'.$key.'-label-plural = "'.$settings[$key.'_label_plural'].'"';
				}else{
					$atts .= 'data-'.$key.'-label-plural = "'.$value['plural'].'"';
				}
		
			}
		}

        return $atts;
	}

    public function get_expired_actions_json( $settings ) {
		$actions = [];

		if ( ! empty( $settings['timer_actions'] ) ) {
			foreach( $settings['timer_actions'] as $key => $value ) {
				switch ( $value ) {
					case 'hide-timer':
						$actions['hide-timer'] = '';
						break;

					case 'hide-element':
						$actions['hide-element'] = $settings['hide_element_selector'];
						break;

					case 'message':
						$actions['message'] = $settings['display_message_text'];
						break;

					case 'redirect':
						$actions['redirect'] = $settings['redirect_url'];
						break;
				}
			}
		}

		return json_encode( $actions );
	}

	public function render_countdown_items( $settings, $item){
		$html = '';
		
		$html .= '<span class="designer-digit">00</span>';
		if( 'yes' === $settings['show_label']){
			$html .= '<span class="designer-label">'.$item.'</span>';
		}

		return $html;
	}

	public function render_separator($settings){
		$separator = '';
		if ( $settings['show_separator'] ) {
			$separator .= '<span class="designer-countdown-separator"><span></span><span></span></span>';
		}
		return $separator;
	}


   

    protected function render() {

        $settings = $this->get_settings_for_display();?>

        <div class="block--countdown-wrapper" <?php echo $this->get_countdown_attributes( $settings ); ?>>
			<div class="designer-countdown">
				<?php if($settings['countdown_format'] !== 'hide-months'):?>
					<div class="digit-wrapper digit-months">
						<?php echo $this->render_countdown_items($settings, 'Months')?>
					</div>
					<?php echo $this->render_separator($settings);?>
				<?php endif;?>
				<div class="digit-wrapper digit-days">
					<?php echo $this->render_countdown_items($settings, 'Days')?>
				</div>
				<?php echo $this->render_separator($settings);?>
				<div class="digit-wrapper digit-hours">
					<?php echo $this->render_countdown_items($settings, 'Hours')?>
				</div>
				<?php if( $settings['countdown_format'] !== 'hide-minutes-seconds'):?>
					<?php echo $this->render_separator($settings);?>
					<div class="digit-wrapper digit-minutes">
						<?php echo $this->render_countdown_items($settings, 'Minutes')?>
					</div>
					<?php if( $settings['countdown_format'] !== 'hide-seconds'):?>
						<?php echo $this->render_separator($settings);?>
						<div class="digit-wrapper digit-seconds">
							<?php echo $this->render_countdown_items($settings, 'Seconds')?>
						</div>
					<?php endif;?>
				<?php endif;?>
			</div>

        </div>

    <?php
    }

   
}