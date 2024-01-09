<?php
namespace Designer\Widgets\Pricing_Table;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons;
use Elementor\Icons_Manager;
use Designer\Includes\Helper;




if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pricing_Table extends Widget_Base {
    
    public function get_name() {
		return 'designer-pricing-table';
	}

    public function get_title() {
		return esc_html__( 'Pricing Table', 'designer' );
	}

    public function get_icon() {
		return 'designer-icon eicon-price-table';
	}

	public function get_categories() {
		return [ 'designer'];
	}

	public function get_keywords() {
		return [ 'designer', 'price table', 'pricing table', 'features table' ];
	}

    protected function register_controls(){
        $this->start_controls_section(
            '_price_general_settings',
            [
                'label' => esc_html__('Price Table', 'designer'),
                "tab"	=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
			'type_select',
			[
				'label' => esc_html__( 'Type', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'feature',
				'options' => [
					'feature' => esc_html__( 'Feature', 'designer' ),
					'divider' => esc_html__( 'Divider', 'designer' ),
					'heading'	=> esc_html__('Heading', 'designer'),
					'price'		=> esc_html__('Price', 'designer'),
					'text'		=> esc_html__('Text', 'designer'),
					'button'	=> esc_html__('Button', 'designer'),
				],
			]
		);

		// Heading
		$repeater->add_control(
			'heading_title',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Price Title',
				'condition' => [
					'type_select'	=> 'heading',
				],
			]
		);

        $repeater->add_control(
			'heading_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Subtitle text',
				'condition' => [
					'type_select'	=> 'heading',
				],
			]
		);

        $repeater->add_control(
			'heading_icon_type',
			[
				'label' => esc_html__( 'Icon Type', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'icon' => esc_html__( 'Icon', 'designer' ),
					'image' => esc_html__( 'Image', 'designer' ),
				],
				'condition' => [
					'type_select'	=> 'heading',
				],
			]
		);

		$repeater->add_control(
			'heading_image',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'type_select'	=> 'heading',
					'heading_icon_type' => 'image',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'heading_image_size', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
				'condition' => [
					'type_select'	=> 'heading',
					'heading_icon_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'heading_icon',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-gem',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'gem',
						'dot-circle',
						'square-full',
					],
					'fa-regular' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
				'condition' => [
					'type_select'	=> 'heading',
					'heading_icon_type' => 'icon',
				],
			]
		);

		// Price
		$repeater->add_control(
			'price',
			[
				'label' => esc_html__( 'Price', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '59',
				'condition'	=> [
					'type_select'	=> 'price',
				]
			]
		);

        $repeater->add_control(
			'sub_price',
			[
				'label' => esc_html__( 'Sub Price', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '99',
				'condition'	=> [
					'type_select'	=> 'price',
				]
			]
		);

        $repeater->add_control(
			'currency_symbol',
			[
				'label' => esc_html__( 'Currency Symbol', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'designer' ),
					'dollar' => '&#36; ' ._x( 'Dollar', 'Currency Symbol', 'designer' ),
					'euro' => '&#128; ' ._x( 'Euro', 'Currency Symbol', 'designer' ),
					'pound' => '&#163; ' ._x( 'Pound Sterling', 'Currency Symbol', 'designer' ),
					'ruble' => '&#8381; ' ._x( 'Ruble', 'Currency Symbol', 'designer' ),
					'peso' => '&#8369; ' ._x( 'Peso', 'Currency Symbol', 'designer' ),
					'krona' => 'kr ' ._x( 'Krona', 'Currency Symbol', 'designer' ),
					'lira' => '&#8356; ' ._x( 'Lira', 'Currency Symbol', 'designer' ),
					'franc' => '&#8355; ' ._x( 'Franc', 'Currency Symbol', 'designer' ),
					'baht' => '&#3647; ' ._x( 'Baht', 'Currency Symbol', 'designer' ),
					'shekel' => '&#8362; ' ._x( 'Shekel', 'Currency Symbol', 'designer' ),
					'won' => '&#8361; ' ._x( 'Won', 'Currency Symbol', 'designer' ),
					'yen' => '&#165; ' ._x( 'Yen/Yuan', 'Currency Symbol', 'designer' ),
					'guilder' => '&fnof; ' ._x( 'Guilder', 'Currency Symbol', 'designer' ),
					'peseta' => '&#8359 ' ._x( 'Peseta', 'Currency Symbol', 'designer' ),
					'real' => 'R$ ' ._x( 'Real', 'Currency Symbol', 'designer' ),
					'rupee' => '&#8360; ' ._x( 'Rupee', 'Currency Symbol', 'designer' ),
					'indian_rupee' => '&#8377; ' ._x( 'Rupee (Indian)', 'Currency Symbol', 'designer' ),
					'custom' => esc_html__( 'Custom', 'designer' ),
				],
				'default' => 'dollar',
				'condition'	=> [
					'type_select'	=> 'price',
				]
			]
		);

        $repeater->add_control(
			'currency',
			[
				'label' => esc_html__( 'Currency', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '$',
				'condition' => [
					'type_select'	=> 'price',
					'currency_symbol' => 'custom',
				],
			]
		);

        $repeater->add_control(
			'sale',
			[
				'label' => esc_html__( 'Sale', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'condition'	=> [
					'type_select'	=> 'price',
				]
			]
		);

        $repeater->add_control(
			'old_price',
			[
				'label' => esc_html__( 'Old Price', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '55',
				'condition' => [
					'type_select'	=> 'price',
					'sale' => 'yes',
				],
			]
		);

        $repeater->add_control(
			'period',
			[
				'label' => esc_html__( 'Period', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '/Month',
				'condition'	=> [
					'type_select'	=> 'price',
				]
			]
		);


		// Feature
        $repeater->add_control(
			'feature_text',
			[
				'label' => esc_html__( 'Text', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Awesome Feature',
				'condition' => [
					'type_select' => 'feature',
				],
			]
		);

        $repeater->add_control(
			'feature_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(84,89,95,1)',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-pricing-table-feature-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-pricing-table-feature-icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'type_select' => 'feature',
				],
			]
		);

		$repeater->add_control(
			'select_icon',
			[
				'label' => esc_html__( 'Select Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'conditions' => [
       		    	'relation' => 'or',
					'terms' => [
						[
							'name' => 'type_select',
							'operator' => '=',
							'value' => 'feature',
                        ]
					],
				],
			]
		);

		$repeater->add_control(
			'feature_linethrough',
			[
				'label' => esc_html__( 'Line Through', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'type_select' => 'feature',
				],
			]
		);

		$repeater->add_control(
			'feature_linethrough_text_color',
			[
				'label' => esc_html__( 'Text Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} span.designer-pricing-table-ftext-line-yes span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'type_select' => 'feature',
					'feature_linethrough' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'feature_linethrough_color',
			[
				'label' => esc_html__( 'Line Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} span.designer-pricing-table-ftext-line-yes' => 'color: {{VALUE}};',
				],
				'condition' => [
					'type_select' => 'feature',
					'feature_linethrough' => 'yes',
				],
			]
		);

        $repeater->add_control(
			'divider_style',
			[
				'label' => esc_html__( 'Style', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'designer' ),
					'double' => esc_html__( 'Double', 'designer' ),
					'dotted' => esc_html__( 'Dotted', 'designer' ),
					'dashed' => esc_html__( 'Dashed', 'designer' ),
					'groove' => esc_html__( 'Groove', 'designer' ),
				],
				'default' => 'dashed',		
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-pricing-table-divider' => 'border-top-style: {{VALUE}};',
				],
				'condition' => [
					'type_select' => 'divider',
				],
			]
		);

		$repeater->add_control(
			'divider_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F9F9F9',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'type_select' => 'divider',
				],
			]
		);

		$repeater->add_control(
			'divider_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-pricing-table-divider' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'type_select' => 'divider',
				],
			]
		);

        $repeater->add_responsive_control(
			'divider_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 300,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-pricing-table-divider' => 'width: {{SIZE}}{{UNIT}};',
				],	
				'condition' => [
					'type_select' => 'divider',
				],
			]
		);

        $repeater->add_responsive_control(
			'divider_height',
			[
				'label' => esc_html__( 'Height', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-pricing-table-divider' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],	
				'condition' => [
					'type_select' => 'divider',
				],
			]
		);

		
		$repeater->add_control(
			'text',
			[
				'label' => '',
				'type' => Controls_Manager::TEXTAREA,
				'default' =>'Text Element',
				'condition' => [
					'type_select' => 'text',
				]
			]
		);

		// Button
        $repeater->add_control(
			'button_label',
			[
				'type' => Controls_Manager::TEXT,
				'label' => __( 'Button label', 'designer' ),
				'default' => __( 'Click Here', 'designer' ),
				'condition' => [
					'type_select'	=> 'button',
                ],
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label' => __( 'Button Link', 'designer' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
                'default' => [
					'url' => '#',
				],
				'condition' => [
					'type_select'	=> 'button',
                ],
			]
		);

		$repeater->add_responsive_control(
            'button_alignment',
            [
                'label' => __( 'Button Alignment', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'flex-center',
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'flex-center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
				'condition' => [
					'type_select' => 'button',
				]
            ]
        );

		$this->add_control(
			'feature_items',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'type_select' => 'heading',
						'heading_icon' => [ 'value' => 'far fa-gem', 'library' => 'fa-regular' ],
					],
					[
						'type_select' => 'price',
					],
					[
						'type_select' => 'feature',
						'feature_text' => 'Showcase Feature 1',
						'feature_linethrough' => 'yes',
						'feature_icon_color' => '#7a7a7a',
						'feature_linethrough_text_color' => '#7a7a7a',
						'feature_linethrough_color' => '#7a7a7a',
						'select_icon' => [ 'value' => 'fas fa-check', 'library' => 'fa-solid' ],
					],
					[
						'type_select' => 'feature',
						'feature_text' => 'Showcase Feature 2',
						'feature_icon_color' => 'rgba(84,89,95,1)',
						'select_icon' => [ 'value' => 'fas fa-check', 'library' => 'fa-solid' ],
					],
					[
						'type_select' => 'feature',
						'feature_text' => 'Showcase Feature 3',
						'feature_icon_color' => 'rgba(97,206,112,1)',
						'select_icon' => [ 'value' => 'fas fa-check', 'library' => 'fa-solid' ],
					],
					[
						'type_select' => 'feature',
						'feature_text' => 'Showcase Feature 4',
						'feature_icon_color' => 'rgba(97,206,112,1)',
						'select_icon' => [ 'value' => 'fas fa-check', 'library' => 'fa-solid' ],
					],
					[
						'type_select' => 'feature',
						'feature_text' => 'Showcase Feature 5',
						'feature_icon_color' => 'rgba(97,206,112,1)',
						'select_icon' => [ 'value' => 'fas fa-check', 'library' => 'fa-solid' ],
					],
					[
						'type_select' => 'button',
						'button_alignment' => 'flex-center',
						'button_size'	=> 'full-width',
						'button_label'	=> 'Click Here',
						'button_link'	=> '',
					],
					[
						'type_select' => 'text',
					],
				],
				'title_field' => '{{{ type_select }}}',
			]
		);

		

		
        $this->end_controls_section();

		// Settings Control
		$this->__button_settings_controls_section();
        $this->__badge_settings_controls_section();
        $this->__hover_settings_controls_animation();

		// Styles Control
        $this->__heading_styles_controls();
        $this->__price_styles_controls();
        $this->__features_styles_controls();
        $this->__button_style_controls();
		$this->__icon_style_controls();
		$this->__inner_border_style_controls();
		$this->__underline_style_controls();
		$this->__text_style_controls();
		$this->__badge_style_controls();
		$this->__table_style_controls();

    }

	protected function __button_settings_controls_section(){
		$this->start_controls_section(
            'section_button_settings', 
            [
                'label' => esc_html__('Button Settings', 'designer'),
                'type'  => Controls_Manager::SECTION,
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
			'button_icon_enable',
			[
				'label' => esc_html__( 'Icon enable', 'designer' ),
				'type' =>  Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'separator'	=> 'before',	
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

	}

    protected function __badge_settings_controls_section(){
        $this->start_controls_section(
            'section_badge', 
            [
                'label' => esc_html__('Badge', 'designer'),
                'type'  => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
			'badge_style',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Style', 'designer' ),
				'default' => 'corner',
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'corner' => esc_html__( 'Corner', 'designer' ),
					'circle' => esc_html__( 'Circle', 'designer' ),
					'flag' => esc_html__( 'Flag', 'designer' ),
				],
			]
		);

        $this->add_control(
			'badge_title',
			[
				'label' => esc_html__( ' Title', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Sale',
				'condition' => [
					'badge_style!' => 'none',
				],
			]
		);

        $this->add_control(
            'badge_hr_position',
            [
                'label' => esc_html__( 'Horizontal Position', 'designer' ),
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
                    ]
                ],
                'condition' => [
					'badge_style!' => 'none',
				],
            ]
        );

        $this->add_responsive_control(
			'badge_cyrcle_size',
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
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-badge-circle .designer-pricing-table-badge-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],	
				'condition' => [
					'badge_style' => 'circle',
					'badge_style!' => 'none',
				],
			]
		);

        $this->add_responsive_control(
			'badge_circle_top_distance',
			[
				'label' => esc_html__( 'Top Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => -50,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-badge-circle' => 'transform: translateX({{badge_cyrcle_side_distance.SIZE}}%) translateY({{SIZE}}%);',
				],	
				'condition' => [
					'badge_style' => 'circle',
					'badge_style!' => 'none',
				],
			]
		);

        $this->add_responsive_control(
			'badge_cyrcle_side_distance',
			[
				'label' => esc_html__( 'Side Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => -50,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-badge-circle' => 'transform: translateX({{SIZE}}%) translateY({{badge_circle_top_distance.SIZE}}%);',
				],	
				'condition' => [
					'badge_style' => 'circle',
					'badge_style!' => 'none',
				],
			]
		);

        $this->add_responsive_control(
			'badge_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 27,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-badge-corner .designer-pricing-table-badge-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg);',
					'{{WRAPPER}} .designer-pricing-table-badge-flag' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'badge_style!' => [ 'none', 'circle' ],
				],
			]
		);

        $this->end_controls_section();
    }

    protected function __hover_settings_controls_animation(){
        $this->start_controls_section(
			'section_hv_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'designer' ),
				'tab' => Controls_Manager::SECTION,
			]
		);

        $this->add_control(
			'hv_animation',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Effect', 'designer' ),
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'slide' => esc_html__( 'Slide', 'designer' ),
					'bounce' => esc_html__( 'Bounce', 'designer' ),
				],
                'prefix_class'	=> 'designer-pricing-table-animation-',
			]
		);

        $this->add_control(
			'hv_animation_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.2,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}}.designer-pricing-table-animation-slide' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s;',
					'{{WRAPPER}}.designer-pricing-table-animation-bounce' => '-webkit-animation-duration: {{VALUE}}s;animation-duration: {{VALUE}}s;',
					'{{WRAPPER}}.designer-pricing-table-animation-zoom' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s;',
				],
				
			]
		);

        $this->end_controls_section();
    }

    protected function __heading_styles_controls(){
        $this->start_controls_section(
			'section_style_heading',
			[
				'label' => esc_html__( 'Heading', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'heading_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#f9f9f9',
					],
				],
				'selector' => '{{WRAPPER}} .designer-pricing-table-heading'
			]
		);

        $this->add_responsive_control(
			'heading_section_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 27,
					'right' => 20,
					'bottom' => 25,
					'left' => 20,
				],
				'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_section',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_title_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2d2d2d',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-title' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_title_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-pricing-table-title',
			]
		);

        $this->add_control(
			'heading_title_distance',
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
					'{{WRAPPER}} .designer-pricing-table-title' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
				],	
			]
		);

        $this->add_control(
			'sub_title_section',
			[
				'label' => esc_html__( 'Sub Title', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'heading_sub_title_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#919191',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_sub_title_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-pricing-table-sub-title',
			]
		);

		$this->add_control(
			'icon_section',
			[
				'label' => esc_html__( 'Icon / Image', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_icon_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_icon_positon',
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
                'prefix_class'	=> 'designer-pricing-table-heading-',
			]
		);

		$this->add_responsive_control(
			'heading_icon_size',
			[
				'label' => esc_html__( 'Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
					'{{WRAPPER}} .designer-pricing-table-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-pricing-table-icon img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_icon_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
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
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}}.designer-pricing-table-heading-left .designer-pricing-table-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-pricing-table-heading-center .designer-pricing-table-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-pricing-table-heading-right .designer-pricing-table-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],	
			]
		);


        $this->end_controls_section();
    }

    protected function __price_styles_controls(){
        $this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__( 'Price', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'price_wrap_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#333333',
					],
				],
				'selector' => '{{WRAPPER}} .designer-pricing-table-price'
			]
		);

        $this->add_responsive_control(
			'price_wrap_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 40,
					'right' => 20,
					'bottom' => 30,
					'left' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

        $this->add_control(
			'price_section',
			[
				'label' => esc_html__( 'Price', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-price' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-pricing-table-price',
			]
		);

		$this->add_control(
			'sub_price_section',
			[
				'label' => esc_html__( 'Sub Price', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'sub_price_size',
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
					'size' => 19,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-sub-price' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sub_price_vr_position',
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
					'{{WRAPPER}} .designer-pricing-table-sub-price' => '-webkit-align-self: {{VALUE}}; align-self: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'currency_section',
			[
				'label' => esc_html__( 'Currency Symbol', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'currency_size',
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
					'size' => 24,
				],		
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-currency' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'currency_hr_position',
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
			]
		);

		$this->add_control(
			'currency_vr_position',
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
					'{{WRAPPER}} .designer-pricing-table-currency' => '-webkit-align-self: {{VALUE}}; align-self: {{VALUE}};',
				],
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
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-old-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'old_price_size',
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
					'size' => 20,
				],		
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-old-price' => 'font-size: {{SIZE}}{{UNIT}};',
				],
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
				'default' => 'middle',
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-old-price' => '-webkit-align-self: {{VALUE}}; align-self: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'period_section',
			[
				'label' => esc_html__( 'Period', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'period_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-period' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'period_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-pricing-table-period',
			]
		);

		$this->add_control(
			'period_hr_position',
			[
				'label' => esc_html__( 'Position', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options' => [
					'below' => esc_html__( 'Below', 'designer' ),
					'beside' => esc_html__( 'Beside', 'designer' ),
				],
				'default' => 'below',
			]
		);


        $this->end_controls_section();
    }

    protected function __features_styles_controls(){

        $this->start_controls_section(
            'section_style_features',
            [
                'label' => esc_html__('Features', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'feature_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f9f9f9',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table section' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'enable_even_color',
			[
				'label' => esc_html__( 'Enable Even Color', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);


        $this->add_control(
			'feature_bg_even_color',
			[
				'label' => esc_html__( 'Background Even Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table section:nth-of-type(even)' => 'background-color: {{VALUE}};',
				],
                'condition'    => [
                    'enable_even_color' => 'yes',
                ]
			]
		);

        $this->add_responsive_control(
			'feature_section_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
				],
				'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-feature-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->add_control(
			'feature_section_top_distance',
			[
				'label' => esc_html__( 'List Top Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
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
					'{{WRAPPER}} .designer-pricing-table-feature:first-of-type' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'feature_section_bot_distance',
			[
				'label' => esc_html__( 'List Bottom Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
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
					'{{WRAPPER}} .designer-pricing-table-feature:last-of-type' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'feature_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#54595f',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-feature span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'feature_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-pricing-table-feature',
			]
		);

		$this->add_responsive_control(
			'feature_align',
			[
				'label' => esc_html__( 'Alignment', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'designer' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'designer' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'designer' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors_dictionary' => [
					'flex-start' => 'justify-content: flex-start; text-align: left;',
					'center' => 'justify-content: center; text-align: center;',
					'flex-end' => 'justify-content: flex-end; text-align: right;',
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-feature-inner' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'feature_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 100,
					],
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 357,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-feature-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'feature_icon_section',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'feature_icon_size',
			[
				'label' => esc_html__( 'Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 30,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-feature-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'feature_divider',
			[
				'label' => esc_html__( 'Divider', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_off' => esc_html__( 'Off', 'designer' ),
				'label_on' => esc_html__( 'On', 'designer' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'feature_divider_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d6d6d6',				
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-feature:after' => 'border-bottom-color: {{VALUE}};',
				],
				'condition' => [
					'feature_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'feature_divider_type',
			[
				'label' => esc_html__( 'Style', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'designer' ),
					'double' => esc_html__( 'Double', 'designer' ),
					'dotted' => esc_html__( 'Dotted', 'designer' ),
					'dashed' => esc_html__( 'Dashed', 'designer' ),
					'groove' => esc_html__( 'Groove', 'designer' ),
				],
				'default' => 'dashed',		
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-feature:after' => 'border-bottom-style: {{VALUE}};',
				],
				'condition' => [
					'feature_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'feature_divider_weight',
			[
				'label' => esc_html__( 'Weight', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 5,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-feature:after' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'feature_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'feature_divider_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 45,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-feature:after' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'feature_divider' => 'yes',
				],
			]
		);


        $this->end_controls_section();


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
                'scheme' => Typography::TYPOGRAPHY_1,
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

	protected function __text_style_controls(){
		$this->start_controls_section(
			'__section_style_text',
			[
				'label' => esc_html__( 'Text', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'text_section_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#f9f9f9',
					],
				],
				'selector' => '{{WRAPPER}} .designer-pricing-table-text'
			]
		);

		$this->add_control(
			'text_section_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 5,
					'right' => 70,
					'bottom' => 30,
					'left' => 70,
				],
				'size_units' => [ 'px'],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'default' => '#a5a5a5',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-text' => 'color: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => esc_html__( 'Typography', 'designer' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-pricing-table-text'
			]
		);

		$this->add_control(
			'text_align',
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
					'{{WRAPPER}} .designer-pricing-table-text' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section(); // End Controls Section
	}

	protected function __badge_style_controls(){
		$this->start_controls_section(
			'section_style_badge',
			[
				'label' => esc_html__( 'Badge', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-badge-inner' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Background Color', 'designer' ),
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table-badge-inner' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .designer-pricing-table-badge-flag:before' => ' border-top-color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => esc_html__( 'Typography', 'designer' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-pricing-table-badge-inner'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'badge_box_shadow',
				'selector' => '{{WRAPPER}} .designer-pricing-table-badge-inner'
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 10,
					'bottom' => 0,
					'left' => 10,
				],
				'size_units' => [ 'px' ],
				'selectors' => [
				'{{WRAPPER}} .designer-pricing-table-badge .designer-pricing-table-badge-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section(); // End Controls Section
	}

	protected function __table_style_controls(){
		$this->start_controls_section(
			'section_style_wrapper',
			[
				'label' => esc_html__( 'Table Style', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_wrapper_style' );

		$this->start_controls_tab(
			'tab_wrapper_normal',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wrapper_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#f9f9f9',
					],
				],
				'selector' => '{{WRAPPER}} .designer-pricing-table'
			]
		);

		$this->add_control(
			'wrapper_border_color',
			[
				'label' => esc_html__( 'Border Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wrapper_box_shadow',
				'selector' => '{{WRAPPER}} .designer-pricing-table',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_wrapper_hover',
			[
				'label' => esc_html__( 'Hover', 'designer' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wrapper_bg_hover_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#f9f9f9',
					],
				],
				'selector' => '{{WRAPPER}} .designer-pricing-table:hover'
			]
		);

		$this->add_control(
			'wrapper_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wrapper_hover_box_shadow',
				'selector' => '{{WRAPPER}} .designer-pricing-table:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		
		$this->add_control(
			'button_margin_top',
			[
				'label' => esc_html__( 'Button Margin Top', 'designer' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em'],
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
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .block-advanced__btn' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'wrapper_transition_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.1,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table' => 'transition-duration: {{VALUE}}s',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'wrapper_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'wrapper_border_type',
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
					'{{WRAPPER}} .designer-pricing-table' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'wrapper_border_width',
			[
				'label' => esc_html__( 'Border Width', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'wrapper_border_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-pricing-table' => 'border-radius: calc({{SIZE}}{{UNIT}} + 2px);',
					'{{WRAPPER}} .designer-pricing-table-item-first' => 'border-top-left-radius: {{SIZE}}{{UNIT}}; border-top-right-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-pricing-table-item-last' => 'border-bottom-left-radius: {{SIZE}}{{UNIT}}; border-bottom-right-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section(); // End Controls Section
	}

	private function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar' => '&#36;',
			'euro' => '&#128;',
			'pound' => '&#163;',
			'ruble' => '&#8381;',
			'peso' => '&#8369;',
			'krona' => 'kr',
			'lira' => '&#8356;',
			'franc' => '&#8355;',
			'shekel' => '&#8362;',
			'baht' => '&#3647;',
			'won' => '&#8361;',
			'yen' => '&#165;',
			'guilder' => '&fnof;',
			'peseta' => '&#8359',
			'real' => 'R$',
			'rupee' => '&#8360;',
			'indian_rupee' => '&#8377;',
		];

		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

	public function render_feature_items($settings){
		$html = '';
		
		foreach( $settings['feature_items'] as $key => $feature){
			// Fisrt and Last Item Classes
			if ( 0 === $key ) {
				$rep_item_class = ' designer-pricing-table-item-first';
			} elseif ( count($settings['feature_items']) - 1 === $key ) {
				$rep_item_class = ' designer-pricing-table-item-last';
			} else {
				$rep_item_class = '';
			}

			if($feature['type_select'] === 'feature'){
				$html .= '<section class="elementor-repeater-item-'.esc_html($feature['_id']).' designer-pricing-table-item designer-pricing-table-'.esc_attr( $feature['type_select']).' '.$rep_item_class.'">';
					$html .= '<div class="designer-pricing-table-feature-inner">';
						if ( '' !== $feature['select_icon']['value'] ) :
							$html .= '<div class="designer-pricing-table-feature-icon">';
								ob_start();
									Icons_Manager::render_icon( $feature['select_icon'], [ 'aria-hidden' => 'true' ] );
								$html .= ob_get_clean();
							$html .= '</div>';
						endif;
						$html .= '<span class="designer-pricing-table-feature-text designer-pricing-table-ftext-line-'.esc_attr( $feature['feature_linethrough'] ).'">'.wp_kses_post($feature['feature_text']).'</span>';
					$html .= '</div>';
				$html .= '</section>';
			}else{
				$html .= '<div class="elementor-repeater-item-'.esc_html($feature['_id']).' designer-pricing-table-item designer-pricing-table-'.esc_attr( $feature['type_select']).' '.$rep_item_class.'">';
					if( $feature['type_select'] === 'heading'){
						$html .= '<div class="designer-pricing-table-inner">';
					
							if ( $feature['heading_icon_type'] === 'icon' && '' !== $feature['heading_icon'] ) :
								$html .= '<div class="designer-pricing-table-icon">';
								ob_start();
									Icons_Manager::render_icon( $feature['heading_icon'], [ 'aria-hidden' => 'true' ] );
								$html .= ob_get_clean();
								$html .= '</div>';
								elseif ( $feature['heading_icon_type'] === 'image' && ! empty( $feature['heading_image']['url'] ) ) :
									$html .= '<div class= "designer-pricing-table-icon">';
										$html .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $feature, 'heading_image_size', 'heading_image' );
									$html .= '</div>';
							endif;

							if( !empty($feature['heading_title']) || !empty( $feature['heading_sub_title']) ) :

								$html .= '<div class="designer-pricing-table-title-wrap">';
									if( !empty($feature['heading_title'])):
										$html .= '<h3 class="designer-pricing-table-title">'.wp_kses_post($feature['heading_title']).'</h3>';
									endif;
									if( !empty($feature['heading_sub_title'])):
										$html .= '<span class="designer-pricing-table-sub-title">'.wp_kses_post($feature['heading_sub_title']).'</span>';
									endif;
								$html .= '</div>';

							endif;


						$html .= '</div>';
					}elseif( $feature['type_select'] === 'price'){
					
						$html .= '<div class="designer-pricing-table-price-inner">';
	
							if ( $feature['sale'] === 'yes' && ! empty( $feature['old_price'] ) ) :
								$html .= '<span class="designer-pricing-table-old-price">'.esc_html($feature['old_price']).'</span>';
							endif;
	
							if ( 'none' !== $feature['currency_symbol'] && 'custom' !== $feature['currency_symbol'] && $settings['currency_hr_position'] === 'before' ) {
								$html .= '<span class="designer-pricing-table-currency">'.esc_html($this->get_currency_symbol($feature['currency_symbol'])).'</span>';
							}elseif( 'custom' === $feature['currency_symbol'] ){
								if ( ! empty( $feature['currency'] ) && $feature['currency_hr_position'] === 'before' ) {
									$html .= '<span class="designer-pricing-table-currency">'.esc_html($feature['currency']).'</span>';
								}
							}
	
							if ( ! empty( $feature['price'] ) ) :
								$html .= '<span class="designer-pricing-table-main-price">'.esc_html($feature['price']).'</span>';
							endif;
	
							if ( ! empty( $feature['sub_price'] ) ) :
								$html .= '<span class="designer-pricing-table-sub-price">'.esc_html($feature['sub_price']).'</span>';
							endif;
	
							if ( 'none' !== $feature['currency_symbol'] && 'custom' !== $feature['currency_symbol'] && $settings['currency_hr_position'] === 'after' ) {
								$html .= '<span class="designer-pricing-table-currency">'.esc_html($this->get_currency_symbol($feature['currency_symbol'])).'</span>';
							}elseif( 'custom' === $feature['currency_symbol'] ){
								if ( ! empty( $feature['currency'] ) && $feature['currency_hr_position'] === 'after' ) {
									$html .= '<span class="designer-pricing-table-currency">'.esc_html($feature['currency']).'</span>';
								}
							}
	
							if ( ! empty( $feature['period'] ) && $settings['period_hr_position'] === 'beside' ) :
								$html .= '<div class="designer-pricing-table-period">'.esc_html($feature['period']).'</div>';		
	
							endif;
	
						$html .= '</div>';
	
						if ( ! empty( $feature['period'] ) && $settings['period_hr_position'] === 'below' ) :
							$html .= '<div class="designer-pricing-table-period">'.esc_html($feature['period']).'</div>';		
	
						endif;
	
	
						
					}elseif( $feature['type_select'] === 'button' && ! empty( $feature['button_label'] ) ){
						$icon_box_style = '';

						if($settings['button_type'] === 'icon-boxed'){
							$icon_box_style = 'style=width:54px;';
						}

                        $this->add_render_attribute( 'button_attribute', 'class', Helper::instance()->get_button_classes( $settings) );
                        if( !empty( $settings['button_title'] ) ){
                            $this->add_render_attribute( 'button_attribute', 'title', $settings['button_title'] );
                        }

						$button_url = $feature['button_link'] ['url'];

						if( '' !== $button_url){
							$this->add_render_attribute( 'button_attribute', 'href', $feature['button_link'] ['url']);
							
							if( $feature['button_link'] ['is_external']){
								$this->add_render_attribute( 'button_attribute', 'target', '_blank' );
							}

							if( $feature['button_link'] ['nofollow']){
								$this->add_render_attribute( 'button_attribute', 'rel', 'nofollow' );
							}
						}

						$html .= '<div class="block-action__advanced '.esc_attr( $feature['button_alignment']  ).'">';

							$html .= '<a '.$this->get_render_attribute_string('button_attribute').'>';

							if( $feature['button_label'] != '' ):
								$html .= '<span class="label">'.esc_html( $feature['button_label'] ).'</span>';
							endif;

							if( 'yes'	===	$settings['show_icon_sidebar']):
								$html .= '<span class="designer-m-border"></span>';
							endif;

							if ( $settings['button_icon_enable'] == 'yes' ):
								$html .= '<span class="designer-m-icon"'.esc_attr($icon_box_style).'>';
									$html .= '<span class="designer-m-icon-inner">';
										ob_start();
										Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] );
										$html .= ob_get_clean();
										if($settings['button_icon_move'] !== 'move-horizontal-short' && $settings['button_icon_move'] !== ''):
											ob_start();
											Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] );
											$html .= ob_get_clean();
										endif;
									$html .= '</span>';
								$html .= '</span>';
							endif;

							if($settings['button_type'] === 'inner-border'){
								$html .= Helper::instance()->render_button_inner_border($settings);
							}

							$html .= '</a>';

						$html .= '</div>';

					}elseif( $feature['type_select'] === 'text' && ! empty( $feature['text'] ) ){
						$html .= wp_kses_post($feature['text']) ;
					}elseif( $feature['type_select'] === 'divider' ){
						$html .= '<div class="designer-pricing-table-divider"></div>';
					}
				$html .= '</div>';
			}

		}

		return $html;
	}

	protected function render(){
		$settings = $this->get_settings_for_display(); ?>

		<div class="designer-pricing-table">
			
			<?php echo $this->render_feature_items($settings);?>
	
			<?php if ( $settings['badge_style'] !== 'none' && ! empty( $settings['badge_title'] ) ) :
				$this->add_render_attribute( 'designer-pricing-table-badge-attr', 'class', 'designer-pricing-table-badge designer-pricing-table-badge-'. esc_attr($settings[ 'badge_style']) );
				if ( ! empty( $settings['badge_hr_position'] ) ) :
					$this->add_render_attribute( 'designer-pricing-table-badge-attr', 'class', 'designer-pricing-table-badge-'. esc_attr($settings['badge_hr_position']) );
				endif;
				?>
				<div <?php echo $this->get_render_attribute_string( 'designer-pricing-table-badge-attr' ); ?>>	
					<div class="designer-pricing-table-badge-inner"><?php echo esc_html($settings['badge_title']); ?></div>	
				</div>

			<?php endif; ?>
		</div>

		<?php
	}

}