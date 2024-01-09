<?php
namespace Designer\Widgets\Pricing_List;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Pricing_List extends Widget_Base {

    public function get_name() {
		return 'designer-pricing-list';
	}

    public function get_title() {
		return esc_html__( 'Pricing List', 'designer' );
	}

    public function get_icon() {
		return 'designer-icon eicon-price-list';
	}

    public function get_categories() {
		return [ 'designer'];
	}

	public function get_keywords() {
		return [ 'designer', 'pricing list', 'price list', 'price menu', 'pricing menu', 'food menu', 'restaurant menu' ];
	}

    public function add_control_prlist_position() {
        $this->add_control(
            'prlist_position', 
            [
                'label' => esc_html__( 'Price List Position', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'left' => esc_html__( 'Left', 'designer' ),
					'center' => esc_html__( 'Center', 'designer' ),
					'right'  => esc_html__( 'Right', 'designer' ),
				],
				'prefix_class'  => 'designer-price-list-position-'
            ]
        );
    }

	public function add_control_prlist_vr_position() {
		$this->add_control(
            'prlist_vr_position', 
            [
                'label' => esc_html__( 'Price List Vertical Position', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'flex-start' => esc_html__( 'Top', 'designer' ),
					'center' => esc_html__( 'Middle', 'designer' ),
					'flex-end'  => esc_html__( 'Bottom', 'designer' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .designer-price-list-item' => '-webkit-align-items: {{VALUE}}; align-items:{{VALUE}};'
				],
				'condition'	=> [
					'prlist_position!'	=> 'center',
				]
            ]
        );
	}
	
	
	public function add_section_style_image() {

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
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
                    '{{WRAPPER}}  .designer-price-list-image img' => 'max-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; object-fit:cover;',
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
                    '{{WRAPPER}}.designer-price-list-position-center .designer-price-list-image img' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                    '{{wrapper}}.designer-price-list-position-right .designer-price-list-image img' => 'margin: 0 0 0 {{SIZE}}{{UNIT}};',
                    '{{wrapper}}.designer-price-list-position-left .designer-price-list-image img' => 'margin: 0 {{SIZE}}{{UNIT}} 0 0;',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}}  .designer-price-list-image img',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .designer-price-list-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

	}

    protected function register_controls() {
        // Section: Items -----------
		$this->start_controls_section(
			'section_price_list_items',
			[
				'label' => esc_html__( 'Items', 'designer' ),
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
            'prlist_image', 
            [
                'label' => esc_html__( 'Item Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
            ]
        );

		$repeater->add_group_control(
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

        $repeater->add_control(
			'prlist_title',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Sweet Cakes',
			]
		);

        $repeater->add_control(
			'_title_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-price-list-title' => 'color: {{VALUE}};',
				],
			]
		);

        $repeater->add_control(
			'prlist_price',
			[
				'label' => esc_html__( 'Price', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '$30',
			]
		);

		$repeater->add_control(
			'prlist_old_price',
			[
				'label' => esc_html__( 'Old Price', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);

        $repeater->add_control(
			'_price_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Price Color', 'designer' ),
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-price-list-price' => 'color: {{VALUE}};',
				],
			]
		);

        $repeater->add_control(
			'prlist_description',
			[
				'label'   	=> esc_html__( 'Description', 'designer' ),
				'type'    	=> Controls_Manager::TEXTAREA,
				'default' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Best pricing list widget.',
			]
		);

        $repeater->add_control(
			'prlist_link',
			[
				'label' => __( 'Link', 'designer' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
			]
		);

        $this->add_control(
			'prlist_items',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'prlist_title' => 'Price List 1',
						'prlist_price' => '$20',
						'prlist_description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Best pricing list widget.',
						'prlist_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'prlist_title' => 'Price List 2',
						'prlist_price' => '$40',
						'prlist_description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Best pricing list widget.',
						'prlist_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'prlist_title' => 'Price List 3',
						'prlist_price' => '$17',
						'prlist_old_price' => '25',
						'prlist_description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Best pricing list widget.',
						'prlist_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
				],
				'title_field' => '{{{ prlist_title }}}',
			]
		);

        $this->add_control_prlist_position();
		$this->add_control_prlist_vr_position();
        $this->end_controls_section(); // End Controls Section


		// Styles
		// Section: General ----------
		$this->start_controls_section(
			'section_style_general',
			[
				'label' => esc_html__( 'General', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'general_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .designer-price-list-item'
			]
		);

		$this->add_responsive_control(
			'general_gutter',
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
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				],
				'selector' => '{{WRAPPER}} .designer-price-list-item',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'general_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
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
				'selector' => '{{WRAPPER}} .designer-price-list-item',
			]
		);
		$this->end_controls_section();

		$this->add_section_style_image();
		$this->add_section_style_title();
		$this->add_section_style_separator();
		$this->add_section_style_price();
		$this->add_section_style_description();
    }

	public function add_section_style_title() {
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'title_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-price-list-title',
			]
		);

		$this->add_responsive_control(
			'title_distance',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Distance', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'prlist_position' => 'center',
				],
			]
		);

		$this->end_controls_section();
	}

	public function add_section_style_separator() {

		$this->start_controls_section(
			'section_style_separator',
			[
				'label'	=> esc_html__( 'Separator', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,

			]
		);

		$this->add_control(
			'separator_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'default' => '#a8a8a8',
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-separator' => 'border-color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'separator_style',
			[
				'label' => esc_html__( 'Style', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'solid' => esc_html__( 'Solid', 'designer' ),
					'double' => esc_html__( 'Double', 'designer' ),
					'dotted' => esc_html__( 'Dotted', 'designer' ),
					'dashed' => esc_html__( 'Dashed', 'designer' ),
					'groove' => esc_html__( 'Groove', 'designer' ),
				],
				'default' => 'dotted',
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-separator' => 'border-bottom-style: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'separator_weight',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Weight', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-separator' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'separator_spacing',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Spacing', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-separator' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	public function add_section_style_price() {
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__( 'Price', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'price_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_bg_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Background Color', 'designer' ),
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-price-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Min Width', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-price-wrap' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_typography_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-price-list-price, {{WRAPPER}} .designer-price-list-old-price',
			]
		);

		$this->add_control(
			'old_price_section',
			[
				'label' => esc_html__( 'Old Price', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-old-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'old_price_size',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Font Size', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 50,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 11,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-old-price' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'old_price_hr_position',
			[
				'label' => esc_html__( 'Alignment', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'before',
				'options' => [
					'before' => [
						'title' => esc_html__( 'Before', 'designer' ),
						'icon' => 'eicon-h-align-left',
					],
					'after' => [
						'title' => esc_html__( 'After', 'designer' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'designer-price-list-old-position-',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'old_price_vr_position',
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
				'default' => 'top',
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-old-price' => '-webkit-align-self: {{VALUE}}; align-self: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_padding',
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
					'{{WRAPPER}} .designer-price-list-price-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'price_border',
				'label' => esc_html__( 'Border', 'designer' ),
				'fields_options' => [
					'color' => [
						'default' => '#E8E8E8',
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
				],
				'selector' => '{{WRAPPER}} .designer-price-list-price-wrap',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-price-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_box_shadow_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'price_box_shadow',
				'selector' => '{{WRAPPER}} .designer-price-list-price-wrap',
			]
		);




		$this->end_controls_section();
	}

	public function add_section_style_description() {

		$this->start_controls_section(
			'section_style_description',
			[
				'label' => esc_html__( 'Description', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'description_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'default' => '#757575',
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-price-list-description',
			]
		);

		$this->add_control(
			'description_align',
			[
				'label' => esc_html__( 'Alignment', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
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
					'justify' => [
						'title' => esc_html__( 'Justify', 'designer' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-description' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'description_distance',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Distance', 'designer' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 7,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-price-list-description' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	protected function render_element_image( $item) {

		if ( ! empty( $item['prlist_image']['url'] ) ) {

			echo '<div class="designer-price-list-image">';
				echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'prlist_image' );
			echo '</div>';

		}

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$tag_element = 'div';
		$item_count  = 0;
		?>

		<div class="designer-price-list">
			<?php foreach ($settings['prlist_items'] as $item):
				
				$this->add_render_attribute( 'tag_attribute'.$item_count, 'class', 'designer-price-list-item elementor-repeater-item-'.esc_attr( $item['_id']) );

				if( '' !== $item['prlist_link']['url'] ){
					$tag_element = 'a';

					$this->add_render_attribute( 'tag_attribute'.$item_count, 'href', $item['prlist_link']['url'] );

					if( $item['prlist_link']['is_external'] ){
						$this->add_render_attribute( 'tag_attribute'.$item_count, 'target', '_blank' );
					}

					if( $item['prlist_link']['nofollow'] ){
						$this->add_render_attribute( 'tag_attribute'.$item_count, 'nofollow', '' );
					}
				}else{
					$tag_element = 'div';
				}

				?>
				<?php echo '<'. esc_attr( $tag_element ) .' '.$this->get_render_attribute_string('tag_attribute'.$item_count) .'>'; ?>

					<?php $this->render_element_image( $item); ?>

					<div class="designer-price-list-content">
						<div class="designer-price-list-heading">
							<?php if ( '' !== $item['prlist_title'] ) : ?>								
								<span class="designer-price-list-title"><?php echo esc_html( $item['prlist_title'] ); ?></span>							
							<?php endif; ?>

							<?php if ( 'none' !== $settings['separator_style'] ) : ?>						
								<span class="designer-price-list-separator"></span>
							<?php endif ?>

							<?php if ( '' !== $item['prlist_price'] || '' !== $item['prlist_old_price'] ) : ?>
								<span class="designer-price-list-price-wrap">
									<?php if ( '' !== $item['prlist_price'] ) : ?>	
									<span class="designer-price-list-price"><?php echo esc_html( $item['prlist_price'] ); ?></span>
									<?php endif; ?>

									<?php if ( '' !== $item['prlist_old_price'] ) : ?>	
									<span class="designer-price-list-old-price"><?php echo esc_html( $item['prlist_old_price'] ); ?></span>
									<?php endif; ?>
								</span>
							<?php endif; ?>
						</div>

						<?php if ( '' !== $item['prlist_description'] ) : ?>
							<div class="designer-price-list-description"><?php echo wp_kses_post( $item['prlist_description'] ); ?></div>
						<?php endif; ?>

					</div>

				<?php echo '</'. esc_attr( $tag_element ) .'>'; ?>

				
			<?php 
			$item_count++;
			endforeach; ?>
		</div>


		<?php
	}

}

