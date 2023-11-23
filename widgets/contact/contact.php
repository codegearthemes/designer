<?php

namespace Designer\Widgets\Contact;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Utils;
use Designer\Includes\Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;


class Contact extends Widget_Base{

    /**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'contact';
	}

    /**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Contact', 'designer' );
	}

    /**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'designer-icon eicon-form-horizontal';
	}

    /**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'mailto: support@codegearthemes.com';
	}

    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'designer' ];
	}


    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [
            'form',
			'widget',
			'contact',
		];
	}

    /**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_controls(){

        /**
         * Call to Action Content Settings
         */
        $this->start_controls_section(
            '_general_settings',
            [
                'label' => esc_html__('Settings', 'designer'),
            ]
        );

        $this->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->add_control(
			'content',
			[
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'label' => __( 'Content', 'designer' ),
				'placeholder' => __( 'Type content here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);


        $this->add_control(
			'contact',
			[
				'label' => esc_html__( 'Select contact form', 'designer' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => false,
				'options' => Helper::instance()->contact(),
			]
		);

        $this->end_controls_section();
        $this->register_style_controls();
    }

    /**
	 * Register style controls.
	 *
	 * Add input fields to allow the user to customize the widget style.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_style_controls() {
		$this->__general_style_controls();
		$this->__label_style_controls();
        $this->__input_style_controls();
        $this->__checkbox_style_controls();
        $this->__radio_style_controls();
        $this->__button_style_controls();
        $this->__global_style_controls();
        $this->__error_style_controls();
        $this->__response_style_controls();

    }

    protected function __general_style_controls() {

        $this->start_controls_section(
            '_style_settings',
            [
                'label' => esc_html__('Title and Content Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .title' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form .content' => 'text-align: {{VALUE}};'
				],
            ]
        );

		$this->add_control(
			'title_style_heading',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator'	=> 'before',
				'condition'	=> [
					'title!' => '',
				]
			]
		);

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .heading .title' => 'color: {{VALUE}};',
                ],
				'condition'	=> [
					'title!' => '',
				]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-contact-form .heading .title',
				'condition'	=> [
					'title!' => '',
				]
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => __( 'Bottom Spacing', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 5,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .block-contact-form .heading .title' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
                'condition'	=> [
                    'title!' => '',
                ]
            ]
        );

		$this->add_control(
			'content_style_heading',
			[
				'label' => esc_html__( 'Content', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator'	=> 'before',
				'condition'	=> [
					'content!' => '',
				]
			]
		);

        $this->add_control(
            'content_color',
            [
                'label' => __( 'Content Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .heading .content' => 'color: {{VALUE}};',
                ],
				'condition'	=> [
					'content!' => '',
				]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-contact-form .heading .content',
				'condition'	=> [
					'content!' => '',
				]
            ]
        );

        $this->add_responsive_control(
            'content_spacing',
            [
                'label'      => __( 'Bottom Spacing', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 30,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .block-contact-form .heading .content' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
				'condition'	=> [
					'content!' => '',
				]
            ]
        );

        $this->end_controls_section();

    }

	protected function __label_style_controls() {
		$this->start_controls_section(
            'label_style_settings',
            [
                'label' => esc_html__('Label Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'label_color',
            [
                'label' => __( 'Label Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form label' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-contact-form label',
            ]
        );



		$this->end_controls_section();

	}

    protected function __input_style_controls() {
        $this->start_controls_section(
            'input_style_settings',
            [
                'label' => esc_html__('Input Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
			'input_style_tabs'
		);


		$this->start_controls_tab(
			'input_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
			]
		);

        $this->add_control(
            'input_color',
            [
                'label' => __( 'Input Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input:not([type="submit"])' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form textarea' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form select' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form input:not([type="submit"])::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form textarea::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'input_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-contact-form input:not([type="submit"]),
                    {{WRAPPER}} .block-contact-form textarea,{{WRAPPER}} .block-contact-form select',
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => __( 'Input Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input:not([type="submit"])' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form textarea' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form select' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'input_border',
                'selector' => '{{WRAPPER}} .block-contact-form input:not([type="submit"]),
                    {{WRAPPER}} .block-contact-form textarea,{{WRAPPER}} .block-contact-form select',
            ]
        );

       
        $this->end_controls_tab();

        $this->start_controls_tab(
			'input_active_tab',
			[
				'label' => esc_html__( 'Active', 'designer' ),
			]
		);

        $this->add_control(
            'input_focus_color',
            [
                'label' => __( 'Input Focus Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input:not([type="submit"]):focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form textarea:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form select:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form input:not([type="submit"]):focus::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form textarea:focus::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'input_focus_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-contact-form input:not([type="submit"]):focus,
                    {{WRAPPER}} .block-contact-form textarea:focus,{{WRAPPER}} .block-contact-form select:focus',
            ]
        );

        $this->add_control(
            'input_focus_background_color',
            [
                'label' => __( 'Input Focus Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input:not([type="submit"]):focus' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form textarea:focus' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form select:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'input_focus_border',
                'selector' => '{{WRAPPER}} .block-contact-form input:not([type="submit"]):focus,
                    {{WRAPPER}} .block-contact-form textarea:focus,{{WRAPPER}} .block-contact-form select:focus',
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'input_border_radius_separator',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

        $this->add_responsive_control(
            'input_border_radius',
            [
                'label' => __( 'Input Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input:not([type="submit"]) ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .block-contact-form textarea ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .block-contact-form select ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_item_space',
            [
                'label' => esc_html__( 'Form Item Space', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [
                    'top',
                    'bottom',
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-form-control-wrap' => 'padding: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label' => __( 'Input Padding', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input:not([type="submit"]) ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .block-contact-form textarea ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .block-contact-form select ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

       
        $this->end_controls_section();
    }

    protected function __checkbox_style_controls() {
        $this->start_controls_section(
            'checkbox_style_settings',
            [
                'label' => esc_html__('Checkbox Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        ); 

        $this->add_responsive_control(
            'checkbox_input_size',
            [
                'label' => __( 'Checkbox Input Size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step'  => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step'  => 0.1,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type="checkbox"]' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'checkbox_margin',
            [
                'label' => __( 'Checkbox Input Margin', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type="checkbox"] ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'checkbox_space_between',
            [
                'label' => __( 'Checkbox Space Between', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 0,
                        'max' => 100,
                        'step'  => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step'  => 0.1,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-checkbox .wpcf7-list-item' => 'margin-left: 0;',
                    '{{WRAPPER}} .block-contact-form .wpcf7-checkbox .wpcf7-list-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'checkbox_holder_margin',
            [
                'label' => __( 'Checkbox Holder Margin', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-checkbox ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function __radio_style_controls() {
        $this->start_controls_section(
            'radio_style_settings',
            [
                'label' => esc_html__('Radio Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        ); 

        $this->add_responsive_control(
            'radio_input_size',
            [
                'label' => __( 'Radio Input Size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step'  => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step'  => 0.1,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type="radio"]' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'radio_margin',
            [
                'label' => __( 'Radio Input Margin', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type="radio"] ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'radio_space_between',
            [
                'label' => __( 'Radio Space Between', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 0,
                        'max' => 100,
                        'step'  => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step'  => 0.1,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-radio .wpcf7-list-item:not(:first-child)' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'radio_holder_margin',
            [
                'label' => __( 'Radio Holder Margin', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-radio ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function __button_style_controls() {

        $this->start_controls_section(
            'button_style_settings',
            [
                'label' => esc_html__('Button Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        ); 

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-contact-form input[type=submit], {{WRAPPER}} .block-contact-form button',
            ]
        );

        $this->start_controls_tabs(
			'button_style_tabs'
		);


		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
			]
		);

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type=submit], {{WRAPPER}} .block-contact-form button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __( 'Button Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type=submit], {{WRAPPER}} .block-contact-form button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
			'button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designer' ),
			]
		);

        $this->add_control(
            'button_hover_color',
            [
                'label' => __( 'Button Hover/Focus Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type=submit]:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form input[type=submit]:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form button:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_backgroud_hover_color',
            [
                'label' => __( 'Button Background Hover/Focus Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type=submit]:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form input[type=submit]:focus' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form button:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form button:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_hover_color',
            [
                'label' => __( 'Button Border Hover/Focus Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type=submit]:hover' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form input[type=submit]:focus' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form button:hover' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form button:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'button_border_separator',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .block-contact-form input[type=submit],{{WRAPPER}} .block-contact-form button',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => __( 'Button Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type=submit] ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .block-contact-form button ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_full_width',
            [
                'label'   => __('Button Full width', 'designer'),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    'full-width'  => __('Yes', 'designer'),
                    '' => __('No', 'designer'),
                ],

            ]
        );

        $this->add_control(
			'button_padding_separator',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __( 'Button Padding', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type=submit] ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .block-contact-form button ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => __( 'Button Margin', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form input[type=submit] ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .block-contact-form button ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function __global_style_controls() {

        $this->start_controls_section(
            'global_style_settings',
            [
                'label' => esc_html__('Global Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        ); 

        $this->add_responsive_control(
			'global_form_align',
			[
				'label' => esc_html__( 'Alignment', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'designer' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'designer' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'designer' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors'	=> [
					'{{WRAPPER}} .block-contact-form' => 'text-align: {{VALUE}};'
				]
			]
		);

        $this->end_controls_section();
    }

    protected function __error_style_controls() {

        $this->start_controls_section(
            'error_style_settings',
            [
                'label' => esc_html__('Error Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );  

        $this->add_responsive_control(
			'error_alignment',
			[
				'label' => esc_html__( 'Error Alignment', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'designer' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'designer' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'designer' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors'	=> [
					'{{WRAPPER}} .block-contact-form .wpcf7-not-valid-tip' => 'text-align: {{VALUE}};'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'error_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-contact-form .wpcf7-not-valid-tip',
            ]
        );

        $this->add_control(
            'error_color',
            [
                'label' => __( 'Error Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-not-valid-tip' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'error_margin',
            [
                'label' => __( 'Error Margin', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-not-valid-tip ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );


        $this->end_controls_section();
    }

    protected function __response_style_controls() {

        $this->start_controls_section(
            'response_style_settings',
            [
                'label' => esc_html__('Response Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        ); 

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'response_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-contact-form .wpcf7-response-output',
            ]
        );

        $this->add_control(
            'response_color',
            [
                'label' => __( 'Response Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-response-output' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'response_padding_separator',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

        $this->add_responsive_control(
            'response_padding',
            [
                'label' => __( 'Response Padding', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-response-output ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'response_margin',
            [
                'label' => __( 'Response Margin', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form .wpcf7-response-output ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'response_border',
                'selector' => '{{WRAPPER}} .block-contact-form .wpcf7-response-output',
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .block-contact-form .wpcf7-response-output',
			]
		);

        $this->add_control(
			'sent_separator',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

        $this->add_control(
            'sent_color',
            [
                'label' => __( 'Sent Border Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form form.sent .wpcf7-response-output' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'failed_color',
            [
                'label' => __( 'Failed Border Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form form.aborted .wpcf7-response-output' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'spam_color',
            [
                'label' => __( 'Spam Border Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form form.spam .wpcf7-response-output' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'invalid_color',
            [
                'label' => __( 'Invalid Border Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-contact-form form.invalid .wpcf7-response-output' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .block-contact-form form.unaccepted .wpcf7-response-output' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display(); ?>

        <div class="block-contact-form <?php echo ('full-width' === $settings['button_full_width']) ? 'designer-button__'.$settings['button_full_width']: ''; ?>">
            <?php if( !empty( $settings['title']) ): ?>
                <div class="heading">
                    <h3 class="title"><?php echo wp_kses_post($settings['title']); ?></h3>
                    <?php if( !empty( $settings['content']) ): ?>
                        <p class="content"><?php echo wp_kses_post($settings['content']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if( $settings['contact'] ): ?>
                <?php echo do_shortcode('[contact-form-7 id="'.$settings['contact'].'"]' ); ?>
            <?php endif; ?>
        </div>

        <?php
    }

}
