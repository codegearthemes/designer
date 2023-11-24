<?php

namespace Designer\Widgets\Button_Advanced;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Designer\Includes\Helper;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Button_Advanced extends Widget_Base {

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
		return 'button-advanced';
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
		return esc_html__( 'Button Advanced', 'designer' );
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
		return 'designer-icon eicon-button';
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
		return 'https://wordpress.org/support/plugin/designer/';
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
		return [ 'button' ];
	}

    /**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

        $this->start_controls_section(
			'_general_settings',
			[
				'label' => __( 'General', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_layout',
			[
				'label'   => __( 'Button Layout', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'btn-link',
				'options' => [
					'btn-link'   => __( 'Filled', 'designer' ),
					'text-link'  	 => __( 'Text', 'designer' ),
					'outlined'		 => __('Outlined', 'designer'),
				]

			]
        );

		$this->add_control(
			'button_type',
			[
				'label'   => __( 'Button Type', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'options' => [
					'standard'   	=> __( 'Standard', 'designer' ),
					'inner-border' 	=> __( 'Inner Border', 'designer' ),
					'icon-boxed'		=> __('Icon Boxed', 'designer'),
				],
				'condition'	=> [
					'button_layout!'	=>	'text-link',
				]


			]
        );

		$this->add_control(
			'show_underline',
			[
				'label' => esc_html__( 'Show Underline', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);


		$this->add_control(
			'button_size',
			[
				'label'   => __( 'Size', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'	=> __( 'Normal', 'designer' ),
					'small'		=> __( 'Small', 'designer' ),
					'large'		=> __('Large', 'designer'),
					'full-width'	=> __('Full Width', 'designer'),
				]

			]
        );

        $this->add_control(
			'button_label',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Button label', 'designer' ),
				'default' => __( 'Click Here', 'designer' )
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => __( 'Button Link', 'designer' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://example.com',
                'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_icon_enable',
			[
				'label' => esc_html__( 'Icon enable', 'designer' ),
				'type' =>  Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'separator'	=> 'before'
			]
		);

        $this->add_control(
			'button_arrow_icon',
			[
				'label' => __( 'Button icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-long-arrow-alt-right',
					'library' => 'fa-solid',
				],
				'condition' => [
                    'button_icon_enable' => 'yes',
                ],
			]
		);

        $this->add_control(
			'button_icon_align',
			[
				'label'   => __( 'Icon position', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
					'row-reverse'   => __( 'Before', 'designer' ),
					'row'           => __( 'After', 'designer' ),
				],
				'condition' => [
                    'button_icon_enable' => 'yes',
                ],

			]
		);

		$this->add_control(
			'show_icon_sidebar',
			[
				'label' => esc_html__( 'Enable Icon Side Border', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'	=> [
					'button_type'	=> 'icon-boxed',
				]
			]

		);

		$this->add_responsive_control(
            'button_alignment',
            [
                'label' => __( 'Button Alignment', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'flex-start',
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => true,
				'separator'	=> 'before',
				'selectors' => [
                    '{{WRAPPER}} .block-action__advanced ' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'accessibility',
			[
				'label' => esc_html__( 'Accessibility', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'button_title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Button title', 'designer' ),
                'description' => __( 'Button title text for accessibility.', 'designer' ),
			]
		);

        $this->end_controls_section();
        $this->register_button_style_controls();
	}

    /**
	 * Register style controls.
	 *
	 * Add input fields to allow the user to customize the widget style.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_button_style_controls() {
        $this->__button_style_controls();
		$this->__icon_style_controls();
		$this->__inner_border_style_controls();
		$this->__underline_style_controls();
    }

    protected function __button_style_controls() {

        $this->start_controls_section(
            '_section_style_button',
            [
                'label' => __( 'Button', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label',
                'selector' => '{{WRAPPER}} .block-action__advanced .btn-link__text',
            ]
        );

		$this->add_control(
            '_button_style_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Button color', 'designer' ),
				'show_label' => false,
            ]
        );

		$this->start_controls_tabs( '_tabs_button' );

		// Button color
		$this->start_controls_tab(
            '_tab_button_normal',
            [
                'label' => __( 'Normal', 'designer' ),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-action__advanced .btn-link__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __( 'Background color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
                    'button_layout' => 'btn-link',
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-action__advanced .btn-link__text' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
            'button_border_color',
            [
                'label' => __( 'Border color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
                    'button_layout!' => 'text-link',
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-action__advanced .btn-link__text' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

		// Button hover color
		$this->start_controls_tab(
            '_tab_button_hover',
            [
                'label' => __( 'Hover', 'designer' ),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __( 'Button hover color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-action__advanced .block-advanced__btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => __( 'Button hover background', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition'	=> [
					'button_layout!'	=> 'text-link',
				],
                'selectors' => [
					'{{WRAPPER}} .block-action__advanced .block-advanced__btn.designer-layout--btn-link:not(.designer-hover--reveal):hover'   => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .block-action__advanced .block-advanced__btn.designer-layout--outlined:not(.designer-hover--reveal):hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .block-action__advanced .block-advanced__btn.designer-layout--btn-link.designer-hover--reveal:after'   => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .block-action__advanced .block-advanced__btn.designer-layout--outlined.designer-hover--reveal:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Button Hover Border color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' => '#003d20',
				'condition'	=> [
					'button_layout!'	=> 'text-link',
				],
                'selectors' => [
                    '{{WRAPPER}} .block-action__advanced .block-advanced__btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
			'button_hover_reveal',
			[
				'label' => esc_html__( 'Background Reveal', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => Helper::instance()->button_hover_background_reveal(),
				'condition'	=> [
					'button_layout!'	=> 'text-link',
				]
			]
		);


        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->add_responsive_control(
			'button_border_width',
			[
				'type' => Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Border Width', 'designer' ),
				'size_units' => [ 'px'],
                'default' => [
                    'size' => 1,
                    'unit' => 'px'
                ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .btn-link__text' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'	=> [
					'button_layout!'	=> 'text-link',
				],
			]
		);

        $this->add_responsive_control(
			'button_padding',
			[
				'type' => Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'designer' ),
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .btn-link__text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .block-advanced__btn.designer-type--icon-boxed .label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .block-advanced__btn.designer-type--icon-boxed .designer-m-icon' => 'padding: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}};',
				],
				'condition'	=> [
					'button_layout!'	=> 'text-link',
				],
			]
		);

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => __( 'Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .block-action__advanced .btn-link__text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'	=> [
					'button_layout!'	=> 'text-link',
				],
            ]
        );


        $this->end_controls_section();
    }

	protected function __icon_style_controls() {
		$this->start_controls_section(
			'_section_style_icon',
			[
				'label' => esc_html__( 'Icon Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'button_icon_enable'	=> 'yes',
				]
			]

		);

        $this->add_responsive_control(
            'button_icon_size',
            [
                'label' => __( 'Icon Size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'default'   => [
                    'size' => 14,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

		$this->start_controls_tabs(
			'style_icon_tabs'
		);

		$this->start_controls_tab(
			'style_icon_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label' => esc_html__( 'Icon Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner' => 'background-color: {{VALUE}};'
				],
				'condition'	=> [
					'button_type'	=> 'icon-boxed'
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_icon_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designer' ),
			]
		);

		$this->add_control(
			'icon_bg_hover_color',
			[
				'label' => esc_html__( 'Icon Background Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner:hover' => 'background-color: {{VALUE}};'
				],
				'condition'	=> [
					'button_type'	=> 'icon-boxed'
				],
			]
		);


		$this->add_control(
			'button_icon_move',
			[
				'label'   => __( 'Move Icon', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'move-horizontal-short',
				'options' => [
					'move-horizontal-short'   => __( 'Horizontal Short', 'designer' ),
					'move-horizontal'           => __( 'Horizontal', 'designer' ),
					'move-vertical'           => __( 'Vertical', 'designer' ),
					'move-diagonal'           => __( 'Diagonal', 'designer' ),
					''           => __( 'None', 'designer' ),
				],

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'margin',
			[
				'label' => esc_html__( 'Margin', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em',],
				'separator'	=> 'before',
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_side_border_color',
			[
				'label' => esc_html__( 'Icon Side Border Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'separator'	=> 'before',
				'selectors' => [
					'{{WRAPPER}} .designer-m-border' => 'background-color:{{VALUE}}; align-self: center;',
				],
				'condition'	=> [
					'show_icon_sidebar' => 'yes',
				],
			]
		);

		$this->add_control(
			'icon_side_border_hover_color',
			[
				'label' => esc_html__( 'Icon Side Border Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-advanced__btn.designer-type--icon-boxed:hover .designer-m-border' => 'background-color:{{VALUE}};',
				],
				'condition'	=> [
					'show_icon_sidebar' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
            'button_icon_border_height',
            [
                'label' => __( 'Icon Side Border Height', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
					'{{WRAPPER}} .designer-m-border' => 'height:{{SIZE}}{{UNIT}};',
				],
				'condition'	=> [
					'show_icon_sidebar' => 'yes',
				]
            ]
        );

		$this->add_responsive_control(
            'button_icon_border_width',
            [
                'label' => __( 'Icon Side Border Width', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
                'selectors' => [
                    '{{WRAPPER}} .designer-m-border' => 'width:{{SIZE}}{{UNIT}};',
				],
				'condition'	=> [
					'show_icon_sidebar' => 'yes',
				]
            ]
        );



		$this->end_controls_section();
	}

	protected function __inner_border_style_controls() {
		$this->start_controls_section(
			'_section_inner_border_style',
			[
				'label' => esc_html__( 'Inner Border Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'button_type'	=> 'inner-border',
				]
			]

		);

		$this->start_controls_tabs(
			'style_inner_border_tabs'
		);


		$this->start_controls_tab(
			'style_inner_border_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
			]
		);

		$this->add_control(
			'inner_border_color',
			[
				'label' => esc_html__( 'Inner Border Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-m-inner-border' => 'color:{{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_inner_border_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designer' ),
			]
		);

		$this->add_control(
			'inner_border_hover_color',
			[
				'label' => esc_html__( 'Inner Border Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-advanced__btn.designer-type--inner-border:not(.designer-inner-border-hover--draw):hover .designer-m-inner-border:not(.designer-m-inner-border-copy)'	=> 'color:{{VALUE}};',
					'{{WRAPPER}} .block-advanced__btn.designer-type--inner-border .designer-m-inner-border.designer-m-inner-border-copy' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'inner_border_hover_animation',
			[
				'label'   => __( 'Hover', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''   => __( 'Change Color', 'designer' ),
					'draw d-draw-center'          => __( 'Draw From Center', 'designer' ),
					'draw d-draw-one-point'       => __( 'Draw From One Point', 'designer' ),
					'draw d-draw-two-points'      => __( 'Draw From Two Points', 'designer' ),
					'remove d-remove-center'      => __( 'Remove To Center', 'designer' ),
					'remove d-remove-one-point'   => __( 'Remove To One Point', 'designer' ),
					'remove d-remove-two-points'  => __( 'Remove To Two Points', 'designer' ),
					'move-outer-edge'           => __( 'Move To Outer Edge', 'designer' ),
				],

			]
		);

		$this->end_controls_tab();


		$this->end_controls_tabs();

		$this->add_responsive_control(
            'inner_border_offset',
            [
                'label' => __( 'Inner Border Offset', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'   => [
                    'size' => 5,
                    'unit' => 'px'
                ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 30,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'separator'	=> 'before',
				'selectors'	=> [
					'{{WRAPPER}} .designer-m-inner-border'	=> 'font-size:{{SIZE}}{{UNIT}}',
				]
            ]
        );

		$this->add_responsive_control(
            'inner_border_width',
            [
                'label' => __( 'Inner Border Width', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'   => [
                    'size' => 2,
                    'unit' => 'px'
                ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'	=> [
					'{{WRAPPER}} .designer-m-border-top'	=> 'height:{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .designer-m-border-right'	=> 'width:{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .designer-m-border-bottom'	=> 'height:{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .designer-m-border-left'	=> 'width:{{SIZE}}{{UNIT}}',
				]
            ]
        );

		$this->end_controls_section();
	}

	protected function __underline_style_controls() {
		$this->start_controls_section(
			'_section_underline_style',
			[
				'label' => esc_html__( 'Underline Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'show_underline'	=> 'yes',
				]
			]

		);

		$this->start_controls_tabs(
			'style_tabs'
		);

		$this->start_controls_tab(
			'underline_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
			]
		);

		$this->add_control(
			'underline_color',
			[
				'label' => esc_html__( 'Underline Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-underline .label:after' => 'background-color:{{VALUE}}',
				]
			]
		);


		$this->add_responsive_control(
            'underline_width',
            [
                'label' => __( 'Underline Width', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'   => [
                    'size' => 58,
                    'unit' => 'px'
                ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-underline .label:after '	=> 'width:{{SIZE}}{{UNIT}}',
				]
            ]
        );
		$this->end_controls_tab();


		$this->start_controls_tab(
			'underline_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designer' ),
			]
		);

		$this->add_control(
			'underline_hover_color',
			[
				'label' => esc_html__( 'Underline Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-underline:hover .label:after' => 'background-color:{{VALUE}}',
				]
			]
		);

		$this->add_responsive_control(
            'underline_hover_width',
            [
                'label' => __( 'Underline Hover Width', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'   => [
                    'size' => 58,
                    'unit' => 'px'
                ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-underline:hover .label:after '	=> 'width:{{SIZE}}{{UNIT}}',
				]
            ]
        );

		$this->add_control(
			'show_hover_underline_draw',
			[
				'label' => esc_html__( 'Enable Hover Underline Draw', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'	=> [
					'underline_alignment!'	=> 'center',
				]
			]

		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
            'underline_offset',
            [
                'label' => __( 'Underline Offset', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default'   => [
                    'size' => 0,
                    'unit' => 'px'
                ],
				'range' => [
					'px' => [
						'min' => -20,
						'max' => 20,
						'step' => 1,
					],
				],
				'separator'	=> 'before',
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-underline .label:after '	=> 'bottom:{{SIZE}}{{UNIT}}',
				]
            ]
        );

		$this->add_responsive_control(
            'underline_thickness',
            [
                'label' => __( 'Underline Thickness', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'   => [
                    'size' => 2,
                    'unit' => 'px'
                ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-underline .label:after '	=> 'height:{{SIZE}}{{UNIT}}',
				]
            ]
        );


		$this->add_responsive_control(
			'underline_alignment',
			[
				'label' => esc_html__( 'Underline Alignment', 'designer' ),
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

        $settings = $this->get_settings_for_display();

		$icon_box_style = '';

		if($settings['button_type'] === 'icon-boxed'){
			$icon_box_style = 'style=width:54px;';
		}

        $this->add_render_attribute( 'button_attribute', 'class', Helper::instance()->get_button_classes( $settings) );

		$button_url = $settings['button_link'] ['url'];
       
		if( '' !== $button_url){
			$this->add_render_attribute( 'button_attribute', 'href', $settings['button_link'] ['url']);

			if( $settings['button_link'] ['is_external']){
				$this->add_render_attribute( 'button_attribute', 'target', '_blank' );
			}

			if( $settings['button_link'] ['nofollow']){
				$this->add_render_attribute( 'button_attribute', 'rel', 'nofollow' );
			}

			if( !empty( $settings['button_title'] ) ){
				$this->add_render_attribute( 'button_attribute', 'title', $settings['button_title'] );
			}
		}
        ?>
        <div class="block-action__advanced">
            <a <?php echo $this->get_render_attribute_string('button_attribute');?> >
                <?php if( $settings['button_label'] != '' ): ?>
                    <span class="label">
                        <?php echo esc_html( $settings['button_label'] ) ?>
                    </span>
                <?php endif; ?>
				<?php if( 'yes'	===	$settings['show_icon_sidebar']):?>
					<span class="designer-m-border"></span>
				<?php endif; ?>
                <?php if ( $settings['button_icon_enable'] == 'yes' ): ?>
					<span class="designer-m-icon" <?php echo esc_attr($icon_box_style);?> >
						<span class="designer-m-icon-inner">
							<?php
								\Elementor\Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] );
								if($settings['button_icon_move'] !== 'move-horizontal-short' && $settings['button_icon_move'] !== ''){
									\Elementor\Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] );
								}
							?>
						</span>
					</span>
                <?php endif; ?>

				<?php if( $settings['button_type'] === 'inner-border'):?>
					<?php echo Helper::instance()->render_button_inner_border($settings); ?>
				<?php endif;?>
            </a>
        </div>
        <?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 *
	 * @access protected
	 */
    protected function content_template() {}

}
