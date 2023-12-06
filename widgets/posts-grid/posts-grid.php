<?php

namespace Designer\Widgets\Posts_Grid;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Designer\Includes\Helper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Posts_Grid extends Widget_Base{

	public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
		wp_register_style( 'posts-grid', \Designer::plugin_url().'widgets/posts-grid/assets/posts-grid.css', array(), '1.0.0', 'all' );

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
		return 'posts-grid';
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
		return esc_html__( 'Posts Grid/List', 'designer' );
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
		return 'designer-icon eicon-gallery-grid';
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
		return 'https://wordpress.org/support/plugin/designer';
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
			'posts'
		];
	}

	/**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'posts-grid' ];
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

		$this->start_controls_section(
            '_layout_settings',
            [
                'label' => esc_html__('Layout', 'designer'),
            ]
        );

		$this->add_control(
            'layout',
            [
                'label' => esc_html__('Select Layout', 'designer'),
                'type' => 'image-select',
                'default' => 'classic',
				'layout' => 'one-half',
                'options' => [
					'classic' => [
                        'title' => esc_html__('Classic', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/classic.svg',
                    ],
                    'side-image' => [
                        'title' => esc_html__('Side Image', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/side-image.svg',
					],
					'info-image' => [
                        'title' => esc_html__('Info on Image', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/card-layout-2.svg',
					],
					'info-top' => [
                        'title' => esc_html__('Info on Top', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/card-layout-3.svg',
                    ]
                ],
            ]
        );

		$this->add_control(
			'columns',
			[
				'label' => esc_html__( 'Number of Columns', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' =>  Helper::instance()->column_options(),
                'default'   => '3',
			]
		);

		$this->add_control(
			'columns_responsive',
			[
				'label' => esc_html__( 'Columns Responsive', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'predefined'  => __('Predefined', 'designer'),
					'custom'  => __('Custom', 'designer'),
				],
                'default'   => 'predefined',
			]
		);

		$this->add_control(
			'columns_1440',
			[
				'label' => esc_html__( 'Number of Columns 1367px - 1440px', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' =>  Helper::instance()->column_options(),
                'default'   => '3',
				'condition'	=> [
					'columns_responsive'	=> 'custom'
				]
			]
		);

		$this->add_control(
			'columns_1366',
			[
				'label' => esc_html__( 'Number of Columns 1025px - 1366px', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' =>  Helper::instance()->column_options(),
                'default'   => '3',
				'condition'	=> [
					'columns_responsive'	=> 'custom'
				]
			]
		);

		
		$this->add_control(
			'columns_1024',
			[
				'label' => esc_html__( 'Number of Columns 769px - 1024px', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' =>  Helper::instance()->column_options(),
                'default'   => '3',
				'condition'	=> [
					'columns_responsive'	=> 'custom'
				]
			]
		);

		$this->add_control(
			'columns_768',
			[
				'label' => esc_html__( 'Number of Columns 681px - 768px', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' =>  Helper::instance()->column_options(),
                'default'   => '3',
				'condition'	=> [
					'columns_responsive'	=> 'custom'
				]
			]
		);

		$this->add_control(
			'columns_680',
			[
				'label' => esc_html__( 'Number of Columns 481px - 680px', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' =>  Helper::instance()->column_options(),
                'default'   => '3',
				'condition'	=> [
					'columns_responsive'	=> 'custom'
				]
			]
		);

		$this->add_control(
			'columns_480',
			[
				'label' => esc_html__( 'Number of Columns 0 - 480px', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' =>  Helper::instance()->column_options(),
                'default'   => '3',
				'condition'	=> [
					'columns_responsive'	=> 'custom'
				]
			]
		);


		$this->add_responsive_control(
			'space_between_items',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Space Between Items', 'designer' ),
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step'	=> 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step'	=> 0.1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-grid > .designer-grid-inner' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'enable_pagination',
			[
				'label' => esc_html__( 'Enable Pagination', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'yes'  => __('Yes', 'designer'),
					'no'  => __('No', 'designer'),
				],
                'default'   => 'no',
			]
		);

		$this->add_control(
			'enable_zigzag',
			[
				'label' => esc_html__( 'Enable Zigzag', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'yes' => esc_html__( 'Yes', 'designer' ),
					'no' => esc_html__( 'No', 'designer' ),
				],
			]
		);

		$this->add_responsive_control(
			'zigzag_amount',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Zigzag Amount', 'designer' ),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-grid-inner >.post-grid-list:nth-of-type(even) > *' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'enable_zigzag'	=> 'yes',
				],
			]
		);



		$this->add_control(
			'meta_heading',
			[
				'label' => esc_html__( 'Meta', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'date',
			[
				'label' => esc_html__( 'Show Date', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'author',
			[
				'label' => esc_html__( 'Show Author', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'meta_icons',
			[
				'label' => esc_html__( 'Show meta icons', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'conditions' => [
					'relation' => 'or', 
					'terms' => [
						[
							'name' => 'date',
							'operator' => '===',
							'value'	=> 'yes',
						],
						[
							'name' => 'author',
							'operator' => '===',
							'value'	=> 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'category_heading',
			[
				'label' => esc_html__( 'Category', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_cat',
			[
				'label' => esc_html__( 'Show categories', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'cat_limit',
			[
				'label' => esc_html__( 'Category limit', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 4,
				'step' => 1,
				'default' => 1,
				'condition' => [
                    'show_cat' => array( 'yes' ),
                ],
			]
		);

		$this->add_control(
			'excerpt_heading',
			[
				'label' => esc_html__( 'Excerpt', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => esc_html__( 'Show excerpt', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' => esc_html__( 'Excerpt Length', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,
				'default' => 50,
				'condition'	=> [
					'show_excerpt' => 'yes',
				]
			]
		);

		$this->add_control(
			'media_heading',
			[
				'label' => esc_html__( 'Media', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'featured_image_default',
			[
				'label' => esc_html__( 'Show featured image', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		// Read More Button

		$this->add_control(
			'button_heading',
			[
				'label' => esc_html__( 'Button', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label' => esc_html__( 'Show Button', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->end_controls_section();

		$this->__button_settings_control();

        $this->register_advanced_controls();
    }

	  // Button Options
	  public function __button_settings_control(){

		$this->start_controls_section(
			'_button_settings',
			[
				'label' => __( 'Read More Button', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition'	=> [
					'show_button' => 'yes',
				]
			]
		);

		$this->add_control(
			'button_label',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Read More Text', 'designer' ),
				'description' => __('if nothing is written, "Read More" text will be used', 'designer'),
				'default' => __( '', 'designer' )
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
		
		$this->end_controls_section();

    }

    /**
	 * Register style controls.
	 *
	 * Add input fields to allow the user to customize the widget style.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_advanced_controls() {
		$this->__query_controls();
		$this->__pagination_style_controls();
		$this->__title_style_controls();
		$this->__excerpt_style_controls();
		$this->__meta_style_controls();
		$this->__category_style_controls();
		$this->__layout_spacing_style_controls();
		$this->__image_style_controls();

		$this->__button_style_controls();
		$this->__icon_style_controls();
		$this->__inner_border_style_controls();
		$this->__underline_style_controls();

		$this->__layout_content_style_controls();

		
		
    }

	protected function __query_controls() {

		$this->start_controls_section(
            '_query_settings',
            [
                'label' => esc_html__('Posts query', 'designer'),
            ]
        );

		$this->add_control(
			'post_per_page',
			[
				'label' => esc_html__( 'Post per page', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 9,
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Order', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC'	=> __( 'Descending', 'designer' ),
					'ASC'		=> __( 'Ascending', 'designer' ),
				]

			]
        );

		$this->add_control(
			'orderby',
			[
				'label'   => __( 'Order By', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'	=> __( 'Date', 'designer' ),
					'ID'		=> __( 'ID', 'designer' ),
					'menu_order'		=> __( 'Menu Order', 'designer' ),
					'name'		=> __( 'Post Name', 'designer' ),
					'rand'		=> __( 'Random', 'designer' ),
					'title'		=> __( 'Title', 'designer' ),
				]

			]
        );

		$this->add_control(
			'categories',
			[
				'label' => esc_html__( 'Select Category', 'designer' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => Helper::instance()->categories(),
			]
		);

		$this->add_control(
			'post_offset',
			[
				'label' => esc_html__( 'Post Offset', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
			]
		);

		$this->end_controls_section();
	}

	protected function __pagination_style_controls() {
		$this->start_controls_section(
            '_pagination_style_settings',
            [
                'label' => esc_html__('Pagination Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'enable_pagination' => 'yes',
				]
            ]
        );

		$this->end_controls_section();
	}

	protected function __title_style_controls() {

		$this->start_controls_section(
            '_title_style_settings',
            [
                'label' => esc_html__('Title Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'title_color',
            [
                'label' => __( 'Title color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
            'title_hover_color',
            [
                'label' => __( 'Title Hover color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .entry-title:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
				'label' => __( 'Title Typography', 'designer' ),
                'selector' => '{{WRAPPER}} .block--posts-grid .entry-title a',
            ]
        );

		$this->add_control(
			'title_hover_underline',
			[
				'label'   => __( 'Title Hover Underline', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'underline'	=> __( 'Yes', 'designer' ),
					''		=> __( 'No', 'designer' ),
				]

			]
        );


		$this->end_controls_section();
	}

	protected function __excerpt_style_controls() {

		$this->start_controls_section(
            '_excerpt_style_settings',
            [
                'label' => esc_html__('Excerpt Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'show_excerpt' => 'yes',
				]
            ]
        );

		$this->add_control(
            'excerpt_color',
            [
                'label' => __( 'Excerpt color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .entry-content ' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
				'label' => __( 'Title Typography', 'designer' ),
                'selector' => ' {{WRAPPER}} .block--posts-grid .entry-content ',
            ]
        );

		$this->end_controls_section();

	}

	protected function __meta_style_controls() {

		$this->start_controls_section(
            '_meta_style_settings',
            [
                'label' => esc_html__('Meta Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or', 
					'terms' => [
						[
							'name' => 'date',
							'operator' => '===',
							'value'	=> 'yes',
						],
						[
							'name' => 'author',
							'operator' => '===',
							'value'	=> 'yes',
						],
					],
				],
            ]
        );

		$this->add_control(
            'meta_color',
            [
                'label' => __( 'Meta Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' 	=> '',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .meta-data' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-grid .meta-data a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-grid .meta-data span' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
            'meta_hover_color',
            [
                'label' => __( 'Meta Hover Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' 	=> '',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .meta-data:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-grid .meta-data:hover a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-grid .meta-data:hover span' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_default_typo',
                'selector' => '{{WRAPPER}} .block--posts-grid .meta-data'
            ]
        );

		$this->add_responsive_control(
            'meta_items_spacing',
            [
                'label' => __( 'Meta Items Gap', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'default'   => [
                    'size' => 8,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .meta-data' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'date' => 'yes',
					'author' => 'yes',
				]
            ]
        );

		$this->end_controls_section();
	}

	protected function __category_style_controls() {

		$this->start_controls_section(
            '_category_style_settings',
            [
                'label' => esc_html__('Category Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_cat' => 'yes', 
				],
            ]
        );

		$this->add_control(
            'category_color_default',
            [
                'label' => __( 'Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' 	=> '#020101',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .categories a' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_default_typo',
                'selector' => '{{WRAPPER}} .block--posts-grid .categories a'
            ]
        );

		$this->add_responsive_control(
            'category_items_spacing',
            [
                'label' => __( 'Category Items Gap', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'default'   => [
                    'size' => 8,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .categories' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'cat_limit!' => 1,
				]
            ]
        );
		$this->end_controls_section();
	}

	protected function __image_style_controls() {

		$this->start_controls_section(
            '_image_style_settings',
            [
                'label' => esc_html__('Image Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'featured_image_default' => 'yes', 
				],
            ]
        );

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Image Border radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid .media-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label' => esc_html__( 'Image Margin', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid .media-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'layout' => 'side-image', 
				],
			]
		);

		$this->add_control(
			'image_hover',
			[
				'label' => esc_html__( 'Image Hover', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'zoom' => esc_html__( 'Zoom In', 'designer' ),
					'zoom-out' => esc_html__( 'Zoom Out', 'designer' ),
					'move' => esc_html__( 'Move', 'designer' ),
				],
				'default' => 'zoom',
			]
		);

		$this->add_control(
			'image_hover_zoom_origin',
			[
				'label' => esc_html__( 'Image Hover Zoom Origin', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'center' => esc_html__( 'Center', 'designer' ),
					'top' => esc_html__( 'Top', 'designer' ),
					'bottom' => esc_html__( 'Bottom', 'designer' ),
					'left' => esc_html__( 'Left', 'designer' ),
					'right' => esc_html__( 'Right', 'designer' ),
				],
				'default' => 'center',
				'condition'	=> [
					'image_hover' => ['zoom', 'zoom-out']
				]
			]
		);

		$this->add_control(
			'image_overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid .content .media-image a:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_overlay_hover_color',
			[
				'label' => esc_html__( 'Overlay Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid .content:hover .media-image a:after' => 'background-color: {{VALUE}};',
				],
			]
		);




		$this->end_controls_section();

	}

	protected function __layout_spacing_style_controls() {

        $this->start_controls_section(
            '_spacing_style_settings',
            [
                'label' => esc_html__('Layout Spacing Style ', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'category_spacing',
            [
                'label' => __( 'Category Bottom Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}}  .block--posts-grid .categories ' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					
                ]
            ]
        );

		$this->add_responsive_control(
            'meta_spacing',
            [
                'label' => __( 'Meta Bottom Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .meta-data ' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					
                ]
            ]
        );

		$this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Title Bottom Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					
                ]
            ]
        );

		$this->add_responsive_control(
            'text_spacing',
            [
                'label' => __( 'Text Bottom Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .entry-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					
                ]
            ]
        );

		$this->add_responsive_control(
            'image_width',
            [
                'label' => __( 'Image Width', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .media-image' => 'width: {{SIZE}}{{UNIT}};',
					
				],
            ]
        );

		$this->add_responsive_control(
            'image_height',
            [
                'label' => __( 'Image Height', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .media-image' => 'height: {{SIZE}}{{UNIT}};',
					
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
				'options' => [
					'' => esc_html__( 'None', 'designer' ),
					'reveal-horizontal' => esc_html__( 'Horizontal', 'designer' ),
					'reveal-vertical'  => esc_html__( 'Vertical', 'designer' ),
				],
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

	protected function __layout_content_style_controls() {
		$this->start_controls_section(
            '_content_style_settings',
            [
                'label' => esc_html__('Content Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'alignment',
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
                'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid .content' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .block--posts-grid .meta-data' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .block--posts-grid .categories' => 'justify-content: {{VALUE}};'
				]
            ]
        );

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Content Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid article .post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'background',
            [
                'label' => __( 'Background', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .content' => 'background-color: {{VALUE}}',
                ],
				'condition' => [
					'layout' => ['classic', 'info-top'], 
				],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'designer' ),
				'selector' => '{{WRAPPER}} .block--posts-grid article .content',
				'condition' => [
					'layout' => ['classic', 'info-top'], 
				],
			]
		);

        $this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid article .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'layout' => ['classic', 'info-top'], 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .block--posts-grid article .content',
				'condition' => [
					'layout' => ['classic', 'info-top'], 
				],
			]
		);

		$this->add_control(
			'content_vertical_alignment',
			[
				'label' => esc_html__( 'Content Vertical Alignment', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'flex-start' => esc_html__( 'Top', 'designer' ),
					'center' => esc_html__( 'Middle', 'designer' ),
					'flex-end'  => esc_html__( 'Bottom', 'designer' ),
				],
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid .content' => 'align-items: {{VALUE}};',
				],
				'condition'	=> [
					'layout'	=> 'side-image',
				]
			]
		);

		$this->add_control(
			'reverse_columns',
			[
				'label' => esc_html__( 'Reverse Columns', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'selectors_dictionary' => [
					'yes' => 'row-reverse',
					'no'	=> 'row',
				],
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid .content' => 'flex-direction: {{VALUE}};',
				],
				'condition'	=> [
					'layout'	=> 'side-image',
				]
			]
		);

		$this->end_controls_section();
	}

	private function get_holder_class( $settings ) {

		$holder_classes = array();

		$holder_classes[] = 'block--posts-grid';
		$holder_classes[] = 'designer-grid';
		$holder_classes[] = 'designer-layout--columns';
		$holder_classes[] = !empty( $settings['title_hover_underline'] ) ? 'designer-title--hover-' . $settings['title_hover_underline'] : '';
		$holder_classes[] = !empty( $settings['image_hover'] ) ? 'designer-image--hover-' . $settings['image_hover'] : '';
		$holder_classes[] = ! empty( $settings['image_hover_zoom_origin'] ) ? 'designer-image--hover-from-' . $settings['image_hover_zoom_origin'] : '';
		$holder_classes[] = ! empty( $settings['columns'] ) ? 'designer-col-num--' . $settings['columns'] : '';
		$holder_classes[] = ! empty( $settings['layout'] ) ? 'designer-item-layout--' . $settings['layout'] : '';
		$holder_classes[] = ! empty( $settings['columns_responsive'] ) ? 'designer-responsive--' . $settings['columns_responsive'] : '';

		if( 'custom' === $settings['columns_responsive'] ){
			$holder_classes[] = ! empty( $settings['columns_1440'] ) ? 'designer-col-num--1440--' . $settings['columns_1440'] : '';
			$holder_classes[] = ! empty( $settings['columns_1366'] ) ? 'designer-col-num--1366--' . $settings['columns_1366'] : '';
			$holder_classes[] = ! empty( $settings['columns_1024'] ) ? 'designer-col-num--1024--' . $settings['columns_1024'] : '';
			$holder_classes[] = ! empty( $settings['columns_768'] ) ? 'designer-col-num--768--' . $settings['columns_768'] : '';
			$holder_classes[] = ! empty( $settings['columns_680'] ) ? 'designer-col-num--680--' . $settings['columns_680'] : '';
			$holder_classes[] = ! empty( $settings['columns_480'] ) ? 'designer-col-num--480--' . $settings['columns_480'] : '';
		}
		
		return implode(' ', $holder_classes);

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

		$excerpt_length = ! empty( $settings['excerpt_length'] ) ? intval( $settings['excerpt_length'] ) : 50; // Default to 50 words

		$icon_box_style = '';

		if($settings['button_type'] === 'icon-boxed'){
			$icon_box_style = 'style=width:54px;';
		}

		$this->add_render_attribute( 'button_attribute', 'class', Helper::instance()->get_button_classes( $settings) );

		$readmore__button_label = ! empty( $settings['button_label'] ) ? $settings['button_label']  : 'Read More';
		
		?>

		<div class="<?php echo $this->get_holder_class($settings); ?>">
			<div class="designer-grid-inner">
				<?php 
					$categories = $settings['categories'];
					$args = [
						'posts_per_page' => $settings['post_per_page'],
						'order'	=> $settings['order'],
						'orderby'	=> $settings['orderby'],
						'offset' => $settings[ 'post_offset' ],

					];
					if( !empty(  $categories ) && is_array( $categories ) ){
						$args = [
							'posts_per_page' => $settings['post_per_page'],
							'category_name' => implode( ',', $categories ),
							'order'	=> $settings['order'],
							'orderby'	=> $settings['orderby'],
							'offset' => $settings[ 'post_offset' ],
						];
					}
					
					$query = new \WP_Query($args);
						while ( $query->have_posts() ) : $query->the_post();
							$categories = get_the_category( get_the_ID() );
								require \Designer::plugin_dir().'widgets/posts-grid/snippets/'.$settings['layout'].'.php'; 
						endwhile;
    			wp_reset_postdata();?>
			</div>

		</div>

		<?php
    }
}
