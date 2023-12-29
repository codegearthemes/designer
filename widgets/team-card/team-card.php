<?php

namespace Designer\Widgets\Team_Card;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Team_Card extends Widget_Base {

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        wp_register_style( 'team-cards', \Designer::plugin_url().'widgets/team-card/assets/team.css', array(), '1.0.0', 'all' );

    }

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
		return 'team-card';
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
		return esc_html__( 'Team', 'designer' );
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
		return 'designer-icon eicon-image-box';
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
		return 'https://www.codegearthemes.com/contact';
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
			'widget',
			'team',
			'member'
		];
	}

	/**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'team-cards' ];
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
			'image_text_settings',
			[
				'label' => __( 'Team', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
                'label' => __( 'Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
                'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'show_secondary_image',
			[
				'label' => esc_html__( 'Show Secondary Image', 'designer' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'secondary_image',
			[
                'label' => __( 'Secondary Image', 'designer' ),
				'description'	=> __('Replace Image on Hover', 'designer'),
				'type' => Controls_Manager::MEDIA,
                'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
				'condition'	=> [
					'show_secondary_image'	=> 'yes',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'separator' => 'before',
				'exclude' => [
					'custom'
				]
			]
		);


		$this->add_control(
			'name',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Name', 'designer' ),
				'default'	=> __('Fred Williams', 'designer'),
				'placeholder' => __( 'Type title here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'position',
			[
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'label' => __( 'Position', 'designer' ),
				'default'	=> __('Xyz Ceo', 'designer'),
				'placeholder' => __( 'Type position here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'profiles_heading',
			[
				'label' => esc_html__( 'Social Profiles', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
            'icon',
            [
                'label' => __( 'Social', 'designer' ),
                'label_block' => true,
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-twitter',
                    'library' => 'fa-brands',
                ],
            ]
		);

        $repeater->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'designer' ),
				'default' => __( 'Twitter', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater->add_control(
			'link',
			[
				'label' => __( 'Socail Profile Link', 'designer' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->add_control(
			'profiles',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default'	=> [
					[
						'title' => __( 'Instagram', 'designer' ),
						'icon'	=> [
							'value' => 'fab fa-instagram',
                    		'library' => 'fa-brands',
						]
					],
					[
						'title' => __( 'Facebook', 'designer' ),
						'icon'	=> [
							'value' => 'fab fa-facebook',
                    		'library' => 'fa-brands',
						]
					],
					[
						'title' => __( 'Twitter', 'designer' ),
						'icon'	=> [
							'value' => 'fab fa-twitter',
                    		'library' => 'fa-brands',
						]
					],
					

				],
				'title_field' => '{{{ title }}}',
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
		$this->__layout_style_controls();
        $this->__content_style_controls();
    }

	protected function __layout_style_controls() {

        $this->start_controls_section(
            '_section_style_layout',
            [
                'label' => __( 'Layout', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'layout',
			[
				'label'     => __( 'Layout', 'designer' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'info-below'        		=> __( 'Info Below', 'designer' ),
					'info-below-left'        	=> __( 'Info Below Left', 'designer' ),
                    'info-from-bottom'        	=> __( 'Info From Bottom', 'designer' ),
					'info-on-hover-inset'       => __( 'Info on Hover Inset', 'designer' ),
                    'info-on-hover'       		=> __( 'Info on Hover', 'designer' ),
					'social-on-hover'			=>__( 'Socials Icon on Hover', 'designer' ),
					'social-position-on-hover'  => __( 'Socials Icon and Position on Hover', 'designer' ),
				],
				'default'   => 'info-below',
			]
		);

		$this->add_control(
			'image_hover',
			[
				'label'     => __( 'Image Hover', 'designer' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''        => __( 'None', 'designer' ),
					'zoom'        => __( 'Zoom', 'designer' ),
				],
				'default'   => '',
			]
		);

        $this->end_controls_section();
    }

	protected function __content_style_controls() {

        $this->start_controls_section(
            '_section_style_content',
            [
                'label' => __( 'Information', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'image_heading',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'type' => Controls_Manager::HEADING,
			],
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}  .block--team-card .team-inner .image-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);



		
		$this->add_control(
			'general_heading',
			[
				'label' => esc_html__( 'Content', 'designer' ),
				'type' => Controls_Manager::HEADING,
			],
		);

		$this->add_control(
			'text_align',
			[
				'label' => esc_html__( 'Alignment', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
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
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .rte-content' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .block--team-card.designer-item-layout--social-position-on-hover .image-wrapper' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .block--team-card.designer-item-layout--social-on-hover .image-wrapper' => 'text-align: {{VALUE}};'
				],
				'condition'	=> [
					'layout!'	=> 'info-below-left',
				]
			]
		);

		$this->add_control(
			'content_vertical_align',
			[
				'label' => esc_html__( 'Content Vertical Alignement', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'flex-start' => esc_html__( 'Top', 'designer' ),
					'center'  => esc_html__( 'Middle', 'designer' ),
					'flex-end' => esc_html__( 'Bottom', 'designer' ),
				],
				'selectors' => [
					'{{WRAPPER}} .rte-content' => 'justify-content: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'layout',
							'operator' => '===',
							'value'	=> 'info-on-hover-inset',
						],
						[
							'name' => 'layout',
							'operator' => '===',
							'value'	=> 'info-on-hover',
						],
					],
				],
			],
			
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em',],
				'selectors' => [
					'{{WRAPPER}} .rte-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}  .rte-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'content_background',
            [
                'label' => __( 'Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rte-content' => 'background-color: {{VALUE}}',
                ],
				'condition'	=> [
					'layout!'	=> 'info-below-left',
				]
            ]
        );

		$this->add_control(
			'content_inset',
			[
				'label' => esc_html__( 'Content Background Inner Offset', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
						'step'	=> 0.1,
					],
				],
				'condition'	=> [
					'layout'	=> 'info-on-hover-inset',
				],
				'selectors'  => array(
					'{{WRAPPER}} .block--team-card.designer-item-layout--info-on-hover-inset  .rte-content' => 'clip-path: inset({{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}});',
				),
			]
		);



		$this->add_control(
			'name_heading',
			[
				'label' => esc_html__( 'Name', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
            'name_color',
            [
                'label' => __( 'Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--team-card .name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name',
                'selector' => '{{WRAPPER}} .block--team-card .name',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

		$this->add_control(
			'name_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
						'step'	=> 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .block--team-card .name' => 'margin: 0 0 {{SIZE}}{{UNIT}} 0;',
				],
			]
		);

		$this->add_control(
			'position_heading',
			[
				'label' => esc_html__( 'Position', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

        $this->add_control(
            'position_color',
            [
                'label' => __( 'Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--team-card .position' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position',
                'selector' => '{{WRAPPER}} .block--team-card .position',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

		$this->add_control(
			'position_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
						'step'	=> 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .block--team-card .position' => 'margin: 0 0 {{SIZE}}{{UNIT}} 0;',
				],
			]
		);

        $this->add_control(
			'social_heading',
			[
				'label' => esc_html__( 'Social icons', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'social_spacing',
			[
				'label' => esc_html__( 'Bottom Spacing', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
						'step'	=> 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .block--team-card.designer-item-layout--social-position-on-hover .image-wrapper .profiles' => 'bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .block--team-card.designer-item-layout--social-on-hover .image-wrapper .profiles' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'	=> [
					'layout'	=> 'social-position-on-hover',
					'layout'	=> 'social-on-hover'
				]
			]
		);

		$this->add_control(
			'social_horizontal_spacing',
			[
				'label' => esc_html__( 'Horizontal Spacing', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
						'step'	=> 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .block--team-card.designer-item-layout--social-position-on-hover .image-wrapper .profiles' => 'padding: 0 {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .block--team-card.designer-item-layout--social-on-hover .image-wrapper .profiles' => 'padding: 0 {{SIZE}}{{UNIT}};'
				],
				'condition'	=> [
					'layout'	=> 'social-position-on-hover'
				]
			]
		);


        $this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__( 'Width/Height', 'designer' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
                    'em' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .block--team-card .social-item' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				]
			]
		);

        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'designer' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
                    'em' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .block--team-card .social-item .icon-link' => 'width: {{SIZE}}{{UNIT}}',
				]
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'designer' ),
				'selector' => '{{WRAPPER}} .block--team-card .social-item',
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}  .block--team-card .social-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs( '_tabs_arrow' );

        $this->start_controls_tab(
            '_tab_social_normal',
            [
                'label' => __( 'Normal', 'designer' ),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default'=> '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}}  .block--team-card .social-item a' => 'color: {{VALUE}}',
					'{{WRAPPER}}  .block--team-card .social-item a svg path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => __( 'Background color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default'=> '#003d2b',
                'selectors' => [
                    '{{WRAPPER}}  .block--team-card .social-item' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_social_hover',
            [
                'label' => __( 'Hover', 'designer' ),
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => __( 'Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default'=> '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}}  .block--team-card .social-item:hover a' => 'color: {{VALUE}}',
					'{{WRAPPER}}  .block--team-card .social-item:hover a  svg path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_background',
            [
                'label' => __( 'Background color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default'=> '#003d2b',
                'selectors' => [
                    '{{WRAPPER}}  .block--team-card .social-item:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->add_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
						'step'	=> 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .block--team-card .profiles li:not(last-of-type)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }

	public function render_holder_classes( $settings ){
		$classes = array();

		$classes[] = 'block--team-card';
		$classes[] = !empty($settings['layout'] ) ? 'designer-item-layout--'.$settings['layout'] : '';
		$classes[]	= !empty($settings['image_hover']) ? 'designer-image--hover-'. $settings['image_hover'] : '';
		$classes[]	= 'yes' === $settings['show_secondary_image'] ? 'designer-secondary-image-active' : '';

		return implode(' ', $classes);
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

		$settings = $this->get_settings_for_display();?>
			<div class="<?php echo $this->render_holder_classes($settings); ?>">
				<?php require \Designer::plugin_dir().'widgets/team-card/snippets/'.$settings['layout'].'.php'; ?>
			</div>

		<?php
		
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function content_template() {}

}
