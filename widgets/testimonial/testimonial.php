<?php

namespace Designer\Widgets\Testimonial;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonial extends Widget_Base {

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
		return 'testimonial';
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
		return esc_html__( 'Testimonial', 'designer' );
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
		return 'designer-icon eicon-comments';
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
		return [ 'testimonial', 'reviews' ];
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
			'author_image',
			[
                'label' => __( 'Author Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
                'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'medium',
				'separator' => 'before',
				'exclude' => [
					'custom'
				]
			]
		);

		$this->add_control(
			'company_logo',
			[
                'label' => __( 'Company Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

        $this->add_control(
			'company_logo_url',
			[
				'label' => esc_html__( 'Logo URL', 'designer' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://www.your-site.com', 'designer' ),
				'conditions' => [
					'terms' => [
						[
							'name' => 'company_logo[url]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'name',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Author Name', 'designer' ),
				'placeholder' => __( 'Type name here', 'designer' ),
                'separator' => 'before',
				'dynamic' => [
					'active' => true,
                ],
                'default'   => 'Tim K.',
			]
		);

        
        $this->add_control(
			'position',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Author Position', 'designer' ),
				'placeholder' => __( 'Type position here', 'designer' ),
				'dynamic' => [
					'active' => true,
                ],
                'default'   => 'Designer CEO',
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
				],
				'default'   => 'Designer is Best',
			]
		);

        $this->add_control(
			'content',
			[
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet cursus volutpat. Aliquam sit amet ligula et justo tincidunt laoreet non vitae lorem. Aliquam porttitor tellus enim, eget commodo augue porta ut. Maecenas lobortis ligula vel tellus sagittis ullamcorperv vestibulum pellentesque cursutu.',
				'label_block' => true,
				'label' => __( 'Content', 'designer' ),
				'placeholder' => __( 'Type content here', 'designer' ),
			]
		);

		$this->add_control(
			'testimonial_date',
			[
				'label' => esc_html__( 'Date', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '3 Days Ago',
			]
		);

		$this->add_control(
			'quote_show',
			[
				'label' => esc_html__( 'Show Quote Icon', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
                'separator' => 'before',
			]
		);

		$this->add_control(
			'testimonial_icon',
			[
				'label' => esc_html__( 'Quote Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-quote-left',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'quote',
						'quote-left',
						'quote-right',
					],
					'fa-regular' => [
						'quote',
						'quote-left',
						'quote-right',
					],
				],
                'condition' => [
                    'quote_show' => 'yes'
                ],
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label' => esc_html__( 'Show rating?', 'designer' ),
				'type' =>  Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'testimonial_rating_amount',
			[
				'label' => esc_html__( 'Rating', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
				'default' => 5,
                'condition' => [
					'show_rating' => 'yes',
				]
			]
		);

		$this->add_control(
			'testimonial_rating_scale',
			[
				'label' => esc_html__( 'Scale', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5,
				'min' => 1,
				'max' => 10,
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'testimonial_rating_style',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style_1' => 'Style 1',
					'style_2' => 'Style 2',
				],
				'default' => 'style_2',
				'render_type' => 'template',
				'prefix_class' => 'designer-testimonial-rating-',
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'testimonial_unmarked_rating_style',
			[
				'label' => esc_html__( 'Unmarked Style', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Solid', 'designer' ),
						'icon' => 'fas fa-star',
					],
					'outline' => [
						'title' => esc_html__( 'Outline', 'designer' ),
						'icon' => 'far fa-star',
					],
				],
				'default' => 'outline',
				'condition' => [
					'show_rating' => 'yes',
					'testimonial_rating_amount' => '',
				],
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
        $this->__testimonial_style_controls();
		$this->__testimonial_content_style_controls();
		$this->__testimonial_meta_controls();
	}

	protected function __testimonial_style_controls() {
		$this->start_controls_section(
            '_section_style_item',
            [
                'label' => __( 'General', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'testimonial_general_bg',
                'label'    => __( 'Background', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .content-item',
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
					'bottom' => 50,
					'left' => 5,
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .content-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'testimonial_general_border',
				'label' => esc_html__( 'Box Border', 'designer' ),
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
				'selector' => '{{WRAPPER}} .content-item',
			]
		);

		$this->add_responsive_control(
            'item_border_radius',
            [
                'label' => __( 'Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .content-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

		$this->end_controls_section();
	}

	protected function __testimonial_content_style_controls() {

		$this->start_controls_section(
            '_section_content_style_item',
            [
                'label' => __( 'Content', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'text-align',
            [
                'label'     => __( 'Alignment', 'designer' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial .content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'testimonial_content_bg',
                'label'    => __( 'Background', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .block-testimonial .content',
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_box_shadow',
				'selector' => '{{WRAPPER}} .block-testimonial .content',
			]
		);

		$this->add_responsive_control(
            'box_padding',
            [
                'label'      => __( 'Padding', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'default' => [
					'top' => 25,
					'right' => 25,
					'bottom' => 27,
					'left' => 25,
				],
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block-testimonial .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.designer-testimonial-meta-position-left .designer-testimonial-meta' => 'padding-top: {{TOP}}{{UNIT}};',
					'{{WRAPPER}}.designer-testimonial-meta-position-right .designer-testimonial-meta' => 'padding-top: {{TOP}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'testimonial_content_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}} .block-testimonial .content',
            ]
        );

		$this->add_control(
            'box_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block-testimonial .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		// Icon
		$this->add_control(
			'icon_section',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#c1c1c1',
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .designer-testimonial-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Font Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 35,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-testimonial-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		
		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],	
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Alignment', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
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
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-icon' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'title_heading',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'title-text-align',
            [
                'label'     => __( 'Alignment', 'designer' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .block--testimonial-slider .content-item .title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block--testimonial-slider .content-item .title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_title_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block--testimonial-slider .content-item .title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => __( 'Spacing', 'designer' ),
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
                    '{{WRAPPER}} .block--testimonial-slider .content-item .title' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'content_heading',
			[
				'label' => esc_html__( 'Content', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'content-text-align',
            [
                'label'     => __( 'Alignment', 'designer' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .block--testimonial-slider .content-item .content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => __( 'Content color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block--testimonial-slider .content-item .content' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block--testimonial-slider .content-item .content',
            ]
        );

        $this->add_responsive_control(
            'content_spacing',
            [
                'label'      => __( 'Spacing', 'designer' ),
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
                    '{{WRAPPER}} .block--testimonial-slider .content-item .content' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Date
		$this->add_control(
			'date_section',
			[
				'label' => esc_html__( 'Date', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'date_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#c1c1c1',
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .designer-testimonial-date',
			]
		);

		$this->add_control(
			'date_align',
			[
				'label' => esc_html__( 'Alignment', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
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
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-date' => 'text-align: {{VALUE}};',
				],
			]
		);

        // Rating
		$this->add_control(
			'rating_section',
			[
				'label' => esc_html__( 'Rating', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'rating_position',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Position', 'designer' ),
				'default' => 'top',
				'options' => [
					'top' => esc_html__( 'Top', 'designer' ),
					'bottom' => esc_html__( 'Bottom', 'designer' ),
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFD726',
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-rating i:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rating_unmarked_color',
			[
				'label' => esc_html__( 'Unmarked Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d8d8d8',
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-rating i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rating_score_color',
			[
				'label' => esc_html__( 'Score Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffd726',
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-rating span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rating_align',
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
					'{{WRAPPER}} .designer-testimonial-rating' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'rating_size',
			[
				'label' => esc_html__( 'Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 22,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-rating i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_gutter',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Gutter', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -5,
						'max' => 50,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-rating i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-testimonial-rating span' => 'margin-left: {{SIZE}}{{UNIT}};',
				],	
			]
		);

		$this->add_responsive_control(
			'rating_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-testimonial-rating' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rating_color_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-testimonial-rating span',
			]
		);

		$this->end_controls_section();

	}

	protected function __testimonial_meta_controls() {
		$this->start_controls_section(
            '_section_meta_style_item',
            [
                'label' => __( 'Meta', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'meta_position',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Position', 'designer' ),
				'default' => 'bottom',
				'options' => [
					'top' => esc_html__( 'Top', 'designer' ),
					'left' => esc_html__( 'Left', 'designer' ),
					'right' => esc_html__( 'Right', 'designer' ),
					'bottom' => esc_html__( 'Bottom', 'designer' ),
					'extra' => esc_html__( 'Extra', 'designer' ),
				],
				'prefix_class' => 'designer-testimonial-meta-position-',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'meta_gutter',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Gutter', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}}.designer-testimonial-meta-position-top .designer-testimonial-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-testimonial-meta-position-left .designer-testimonial-meta' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-testimonial-meta-position-right .designer-testimonial-meta' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-testimonial-meta-position-bottom .designer-testimonial-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-testimonial-meta-position-extra .author-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
            'meta_text_align',
            [
                'label'     => __( 'Alignment', 'designer' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'prefix_class' => 'designer-testimonial-meta-align-',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial .content-item .designer-testimonial-meta' => 'text-align: {{VALUE}};',
                    '{{wrapper}}.designer-testimonial-meta-align-center .designer-testimonial-image'   => 'text-align: {{value}};',
                    '{{wrapper}}.designer-testimonial-meta-align-center .author-meta'   => 'text-align: {{value}};',
                ],
            ]
        );

		$this->add_control(
			'image_heading',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_position',
			[
				'label' => esc_html__( 'Position', 'designer' ),
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
                'prefix_class'	=> 'designer-testimonial-image-position-',
                'condition' => [
                	'meta_position!' => 'extra'
                ]
			]
		);

		$this->add_responsive_control(
            'image_size',
            [
                'label'      => __( 'Size', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 75,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 16,
                        'max' => 300,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}}  .designer-testimonial-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; object-fit: cover; display: inline-block;',
                ],
            ]
        );

		$this->add_responsive_control(
            'image_spacing',
            [
                'label'      => __( 'Spacing', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .designer-testimonial-image img' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                    '{{wrapper}}.designer-testimonial-image-position-right .author-meta-inner .designer-testimonial-image' => 'margin: 0 0 0 {{SIZE}}{{UNIT}};',
                    '{{wrapper}}.designer-testimonial-image-position-left .author-meta-inner .designer-testimonial-image' => 'margin: 0 {{SIZE}}{{UNIT}} 0 0;',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'testimonial_image_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}}  .designer-testimonial-image img',
            ]
        );

		$this->add_control(
            'image_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'default' => [
					'top' => 100,
					'right' => 100,
					'bottom' => 100,
					'left' => 100,
                    'unit'  => '%'
				],
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .designer-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'author_heading',
			[
				'label' => esc_html__( 'Name', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'author_color',
            [
                'label' => __( 'Name color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block--testimonial-slider .content-item .author-meta .name' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'author_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block--testimonial-slider .content-item .author-meta .name',
            ]
        );

		$this->add_responsive_control(
            'name_spacing',
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
                    '{{WRAPPER}} .block--testimonial-slider .content-item .author-meta .name' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'position_heading',
			[
				'label' => esc_html__( 'Position', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'position_color',
            [
                'label' => __( 'Position color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block--testimonial-slider .content-item .author-meta .position' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'position_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block--testimonial-slider .content-item .author-meta .position',
            ]
        );

		$this->add_responsive_control(
            'position_spacing',
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
                    '{{WRAPPER}} .block--testimonial-slider .content-item .author-meta .position' => 'margin: 0 0 {{SIZE}}{{UNIT}};display: inline-block;',
                ],
            ]
        );

		$this->add_control(
			'company_heading',
			[
				'label' => esc_html__( 'Company', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
            'company_size',
            [
                'label'      => __( 'Size', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 75,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 16,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
					'{{WRAPPER}}  .designer-testimonial-logo-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; object-fit: cover; display: inline-block;',
				],
            ]
        );

        $this->add_responsive_control(
            'company_spacing',
            [
                'label'      => __( 'Spacing', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .designer-testimonial-logo-image img' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'company_image_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}}  .designer-testimonial-logo-image img',
            ]
        );

        $this->add_control(
            'company_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'default' => [
					'top' => 100,
					'right' => 100,
					'bottom' => 100,
					'left' => 100,
                    'unit'  => '%'
				],
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .designer-testimonial-logo-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();
	}

	public function render_testimonial_image( $settings ) {

		if ( !empty($settings['author_image']['url']) ) {?>
			<div class="designer-testimonial-image">
                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'author_image' ); ?>
			</div>
        <?php
        }

	}

	public function render_testimonial_meta( $settings ) { 
        $logo_element = 'div';
        ?>
        <?php if( $settings['name'] != '' || $settings['position'] != '' ): ?>
            <div class="author-meta">
                <?php if( $settings['name']): ?>
                    <p class="name h6"><?php echo wp_kses_post( $settings['name'] ); ?></p>
                <?php endif; ?>
                <?php if( $settings['position']): ?>
                    <small class="position"><?php echo wp_kses_post( $settings['position'] ); ?></small>
                <?php endif; ?>
                <?php if ( ! empty( $settings['company_logo']['url'] ) ) {
        
                    $this->add_render_attribute( 'logo_attribute', 'class', 'designer-testimonial-logo-image elementor-clearfix' );
                    if ( ! empty( $settings['company_logo_url']['url'] ) ) {
                        
                        $logo_element = 'a';

                        $this->add_render_attribute( 'logo_attribute', 'href', $settings['company_logo_url']['url'] );

                        if ( $testimonial['company_logo_url']['is_external'] ) {
                            $this->add_render_attribute( 'logo_attribute', 'target', '_blank' );
                        }

                        if ( $testimonial['company_logo_url']['nofollow'] ) {
                            $this->add_render_attribute( 'logo_attribute', 'nofollow', '' );
                        }

                    }
                    if ( !empty($settings['company_logo']['url']) ) {
                        echo '<'. esc_attr( $logo_element ) .' '. $this->get_render_attribute_string( 'logo_attribute' ) .'>';
                            echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'company_logo' );
                        echo '</'. esc_attr( $logo_element ) .'>';
                    }
                }?>
            </div>
        <?php endif;
    }

	public function designer_testimonial_content( $settings ) { ?>

        <?php if( $settings['title'] || $settings['content'] ): ?>
            <div class="content">
                <?php if ( $settings['quote_show'] == 'yes' ): ?>
                    <div class="designer-testimonial-icon">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['testimonial_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                <?php endif; ?>
                <?php if( $settings['title']): ?>
                    <h4 class="title h5"><?php echo wp_kses_post( $settings['title'] ); ?></h4>
                <?php endif; ?>
                <?php if($settings['rating_position'] === 'top'): ?>
                    <?php $this->render_testimonial_rating( $settings ); ?>
                <?php endif;?>
                <?php if( $settings['content']): ?>
                    <p><?php echo wp_kses_post( $settings['content'] ); ?></p>
                <?php endif; ?>
                <?php if($settings['rating_position'] === 'bottom'): ?>
                    <?php $this->render_testimonial_rating( $settings ); ?>
                <?php endif;?>
                <?php if ( ! empty( $settings['testimonial_date'] ) ) : ?>
                    <div class="designer-testimonial-date"><?php echo esc_html( $settings['testimonial_date'] ); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
    }

	public function render_testimonial_rating( $settings ) {

		$rating_amount = $settings['testimonial_rating_amount'];
		$round_rating = (int)$rating_amount;
		$rating_icon = '&#xE934;';

		if ( 'style_1' === $settings['testimonial_rating_style'] ) {
			if ( 'outline' === $settings['testimonial_unmarked_rating_style'] ) {
				$rating_icon = '&#xE933;';
			}
		} elseif ( 'style_2' === $settings['testimonial_rating_style'] ) {
			$rating_icon = '&#9733;';

			if ( 'outline' === $settings['testimonial_unmarked_rating_style'] ) {
				$rating_icon = '&#9734;';
			}
		}

            if ( 'yes' === $settings['show_rating'] && ! empty( $rating_amount ) ) : ?>	

                <div class="designer-testimonial-rating">
                <?php for( $i = 1; $i <= $settings['testimonial_rating_scale']; $i++ ) : ?>
                    <?php if ( $i <= $rating_amount ) : ?>
                        <i class="designer-rating-icon-full"><?php echo esc_html($rating_icon); ?></i>
                    <?php elseif ( $i === $round_rating + 1 && $rating_amount !== $round_rating ) : ?>
                        <i class="designer-rating-icon-<?php echo esc_attr(( $rating_amount - $round_rating ) * 10); ?>"><?php echo esc_html($rating_icon); ?></i>
                    <?php else : ?>
                        <i class="designer-rating-icon-empty"><?php echo esc_html($rating_icon); ?></i>
                    <?php endif; ?>
                <?php endfor; ?>

                </div>

        <?php
            endif;
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

            $this->add_render_attribute(
                'wrapper',
                [
                    'class' => [ 'block-testimonial' ],
                ]
            );
        ?>
            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<div class="testimonial-inner testimonial-wrapper">
				<div class="content-item">

					<?php if ( $settings['meta_position'] === 'extra' ) : ?>
						<?php $this->render_testimonial_image($settings); ?>
					<?php endif; ?>

					<?php $this->designer_testimonial_content($settings);?>

					<?php if ( $settings['meta_position'] === 'extra' ) : ?>
						<?php $this->render_testimonial_meta( $settings );?>
					<?php endif; ?>

					<?php if ( $settings['meta_position'] !== 'extra' ) : ?>
						<div class="designer-testimonial-meta elementor-clearfix">
							<div class="author-meta-inner">
								<?php $this->render_testimonial_image($settings); ?>
								<?php $this->render_testimonial_meta( $settings );?>
							</div>	
						</div>
					<?php endif; ?>

				</div>
            </div>
        <?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 *
	 * @access protected
	 */
    protected function content_template() { }

}
