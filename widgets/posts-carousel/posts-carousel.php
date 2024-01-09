<?php
namespace Designer\Widgets\Posts_Carousel;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Designer\Includes\Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;


class Posts_Carousel extends Widget_Base{

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

		wp_register_style( 'posts-carousel', \Designer::plugin_url().'widgets/posts-carousel/assets/post-carousel.css', array(), '1.0.0', 'all' );

        wp_register_script( 'posts-carousel', \Designer::plugin_url().'widgets/posts-carousel/assets/post-carousel.js', array('swiper','elementor-frontend'), '1.0.0', true );

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
		return 'designer-posts-carousel';
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
		return esc_html__( 'Posts Carousel', 'designer' );
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
		return 'designer-icon eicon-slider-push';
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
			'posts',
			'Posts Carousel',
            'CodegearThemes',
		];
	}

	/**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'swiper', 'posts-carousel' ];
    }

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'posts-carousel' ];
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
            '_general_settings',
            [
                'label' => esc_html__('Settings', 'designer'),
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
                        'imagesmall' => \Designer::plugin_url() .'assets/admin/src/post-block/classic.svg',
                    ],
                    'side-image' => [
                        'title' => esc_html__('Side Image', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/admin/src/post-block/side-image.svg',
					],
					'info-image' => [
                        'title' => esc_html__('Info on Image', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/admin/src/post-block/card-layout-2.svg',
					],
					'info-top' => [
                        'title' => esc_html__('Info on Top', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/admin/src/post-block/card-layout-3.svg',
                    ]
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
		$this->__general_query_controls();
		$this->__post_slider_controls();
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

		$this->__post_arrow_style_controls();
		$this->__post_dot_style_controls();
		$this->__post_progressbar_style_controls();
    }

	protected function __post_slider_controls(){

		$this->start_controls_section(
            '_post_slider',
            [
                'label' => esc_html__('Carousel', 'designer'),
            ]
        );

		$this->add_responsive_control(
			'slide_perpage',
			[
				'label' => esc_html__( 'Slides to show', 'designer' ),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 6,
						'step' => 1,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'default' => [
					'size' => 3,
					'unit' => 'px',
				],
			]
		);

		$this->add_responsive_control(
			'space_between_items',
			[
				'label' => esc_html__( 'Space Between Items', 'designer' ),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step'	=> 1,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'condition'	=> [
					'slide_perpage[size]!' => 1,
				]
			]
		);

		$this->add_responsive_control(
			'slides_scroll',
			[
				'label' => esc_html__( 'Slides to Scroll', 'designer' ),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
						'step' => 1,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'default' => [
					'size' => 1,
					'unit' => 'px',
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'designer' ),
				'type' =>  Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__( 'Speed (ms)', 'designer' ),
				'type' =>  Controls_Manager::NUMBER,
				'min' => 1000,
				'max' => 15000,
				'step' => 100,
				'default' => 1000,
				'condition' => [
					'autoplay' => 'yes',
				]
			]
		);
		$this->add_control(
			'autoplay_hover_pause',
			[
				'label' => esc_html__( 'Pause on hover', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'autoplay' => 'yes',
				]
			]
		);
		$this->add_control(
			'arrow',
			[
				'label' => esc_html__( 'Show arrow', 'designer' ),
				'type' =>   Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'arrow_icon',
			[
				'label' => esc_html__( 'Arrow Icon', 'designer' ),
				'description' => esc_html__( 'Add a left icon so right icon will be reverse of it.', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'arrow' => 'yes',
				]
			]
		);

		$this->add_control(
			'scrollbar',
			[
				'label' => esc_html__( 'Show scrollbar', 'designer' ),
				'type' =>   Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => ''
			]
		);

		$this->add_control(
			'infinite_loop',
			[
				'label' => esc_html__( 'Enable Loop?', 'designer' ),
				'type' =>   Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
            'pagination_type',
            [
                'label'   => __('Pagination', 'designer'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'hide',
                'options' => [
					'hide'	=>  __('Hide', 'designer'),
                    'progressbar'  => __('Progress Bar', 'designer'),
                    'bullets' => __('Dots', 'designer'),
                ],
            ]
        );

		$this->add_control(
			'grab_cursor',
			[
				'label' => esc_html__( 'Enable Grab Cursor?', 'designer' ),
				'type' =>   Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_section();
	}

	protected function __general_query_controls() {

		$this->start_controls_section(
            '_query_settings',
            [
                'label' => esc_html__('Query', 'designer'),
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
                    '{{WRAPPER}} .block--posts-carousel .entry-title a' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .block--posts-carousel .entry-title:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
				'label' => __( 'Title Typography', 'designer' ),
                'selector' => '{{WRAPPER}} .block--posts-carousel .entry-title a',
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
                    '{{WRAPPER}} .block--posts-carousel .entry-content ' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
				'label' => __( 'Title Typography', 'designer' ),
                'selector' => ' {{WRAPPER}} .block--posts-carousel .entry-content ',
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
                    '{{WRAPPER}} .block--posts-carousel .meta-data' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-carousel .meta-data a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-carousel .meta-data span' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .block--posts-carousel .meta-data:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-carousel .meta-data:hover a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-carousel .meta-data:hover span' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_default_typo',
                'selector' => '{{WRAPPER}} .block--posts-carousel .meta-data'
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
                    '{{WRAPPER}} .block--posts-carousel .meta-data' => 'gap: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .block--posts-carousel .categories a' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_default_typo',
                'selector' => '{{WRAPPER}} .block--posts-carousel .categories a'
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
                    '{{WRAPPER}} .block--posts-carousel .categories' => 'gap: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .block--posts-carousel .media-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .block--posts-carousel .media-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .block--posts-carousel .content .media-image a:after' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .block--posts-carousel .content:hover .media-image a:after' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}}  .block--posts-carousel .categories ' => 'margin-bottom: {{SIZE}}{{UNIT}};',

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
                    '{{WRAPPER}} .block--posts-carousel .meta-data ' => 'margin-bottom: {{SIZE}}{{UNIT}};',

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
                    '{{WRAPPER}} .block--posts-carousel .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

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
                    '{{WRAPPER}} .block--posts-carousel .entry-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',

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
                    '{{WRAPPER}} .block--posts-carousel .media-image' => 'width: {{SIZE}}{{UNIT}};',

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
                    '{{WRAPPER}} .block--posts-carousel .media-image' => 'height: {{SIZE}}{{UNIT}};',

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
					'{{WRAPPER}} .block--posts-carousel .content' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .block--posts-carousel .meta-data' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .block--posts-carousel .categories' => 'justify-content: {{VALUE}};'
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
					'{{WRAPPER}} .block--posts-carousel article .post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'background',
            [
                'label' => __( 'Background', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--posts-carousel .content' => 'background-color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}} .block--posts-carousel article .content',
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
					'{{WRAPPER}} .block--posts-carousel article .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .block--posts-carousel article .content',
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
					'{{WRAPPER}} .block--posts-carousel .content' => 'align-items: {{VALUE}};',
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
					'{{WRAPPER}} .block--posts-carousel .content' => 'flex-direction: {{VALUE}};',
				],
				'condition'	=> [
					'layout'	=> 'side-image',
				]
			]
		);

		$this->end_controls_section();
	}

	protected function __post_arrow_style_controls() {
		$this->start_controls_section(
            '_products_arrow_styles',
            [
                'label' => __( 'Navigation : Arrow', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

		$this->add_control(
            '_navigation_position',
            [
                'label'   => __('Navigation Position', 'designer'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'inside',
                'options' => [
                    'inside'  => __('Inside', 'designer'),
                    'outside' => __('Outside', 'designer'),
					'together' => __('Together', 'designer'),

                ],
            ]
        );

		$this->add_control(
            '_navigation_hide',
            [
                'label'   => __('Hide Navigation', 'designer'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    '1024'  => __('Below 1024px', 'designer'),
                    '767' => __('Below 767px', 'designer'),
					'default' => __('Default', 'designer'),

                ],
            ]
        );

		$this->add_control(
            '_navigation_alignment',
            [
                'label'   => __('Navigation alignment', 'designer'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'flex-start',
                'options' => [
                    'flex-start'  => __('Left', 'designer'),
                    'flex-end' => __('Right', 'designer'),
                ],
				'condition' => [
                    'arrow' => 'yes',
					'_navigation_position' => 'together',
                ],
				'prefix_class'	=> 'designer-navigation-alignment--',

            ]
        );

		$this->add_control(
            '_navigation_vertical_position',
            [
                'label'   => __('Navigation Vertical Position', 'designer'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'bottom'  => __('Bottom', 'designer'),
                    'top' => __('Top', 'designer'),
                ],
				'condition' => [
                    'arrow' => 'yes',
					'_navigation_position' => 'together',
                ],
				'prefix_class'	=> 'designer-navigation-together--'
            ]
        );

		$this->add_control(
            'arrow_position_toggle',
            [
                'label' => __( 'Position', 'designer' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'designer' ),
                'label_on' => __( 'Custom', 'designer' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'arrow' => 'yes',
					'_navigation_position!' => 'together',
                ]
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'arrow_position_y',
            [
                'label' => __( 'Vertical', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'arrow_position_toggle' => 'yes',
                    'arrow' => 'yes',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
						'step'	=> 1,
                    ],
                    '%' => [
                        'min' => -110,
                        'max' => 110,
						'step'	=> 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'top: {{SIZE}}{{UNIT}};-webkit-transform: translateY(-{{SIZE}}{{UNIT}}); transform: translateY(-{{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrow_position_x',
            [
                'label' => __( 'Horizontal', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'arrow_position_toggle' => 'yes',
                    'arrow' => 'yes',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
						'step'	=> 1,
                    ],
                    '%' => [
                        'min' => -110,
                        'max' => 110,
						'step'	=> 1,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .slide-previous' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slide-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

		$this->add_control(
            'arrow_position_together_toggle',
            [
                'label' => __( 'Position', 'designer' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'designer' ),
                'label_on' => __( 'Custom', 'designer' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'arrow' => 'yes',
					'_navigation_position' => 'together',
                ]
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'arrow_position_together_y',
            [
                'label' => __( 'Vertical', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'arrow_position_toggle' => 'yes',
                    'arrow' => 'yes',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
						'step'	=> 1,
                    ],
                    '%' => [
                        'min' => -110,
                        'max' => 110,
						'step'	=> 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .designer-swiper-together-nav' => 'margin-top:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-navigation-together--top .designer-swiper-together-nav' => 'margin-bottom:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrow_position_together_x',
            [
                'label' => __( 'Horizontal', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'arrow_position_toggle' => 'yes',
                    'arrow' => 'yes',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
						'step'	=> 1,
                    ],
                    '%' => [
                        'min' => -110,
                        'max' => 110,
						'step'	=> 1,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .designer-swiper-together-nav' => 'left:{{SIZE}}{{UNIT}};right:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

		$this->add_responsive_control(
            '_space_between_arrows',
            [
                'label' => __( 'Space Between Arrows', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'condition' => [
                    'arrow' => 'yes',
					'_navigation_position'=>'together',
                ],
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
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .designer-swiper-together-nav .slide-previous' => 'margin-right:{{SIZE}}{{UNIT}}!important;',
                ],
            ]
        );

		$this->add_responsive_control(
            'arrow_size',
            [
                'label' => __( 'Size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 60,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slide-previous svg, {{WRAPPER}} .slide-next svg' => 'width: calc( {{SIZE}}{{UNIT}} / 2 );height: calc( {{SIZE}}{{UNIT}} / 2 );'
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'arrow_border',
                'selector' => '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next',
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

		$this->add_responsive_control(
            'arrow_border_radius',
            [
                'label' => __( 'Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

		$this->start_controls_tabs( '_tabs_arrow' );

        $this->start_controls_tab(
            '_tab_arrow_normal',
            [
                'label' => __( 'Normal', 'designer' ),
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' => __( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'arrow_background_color',
            [
                'label' => __( 'Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_arrow_hover',
            [
                'label' => __( 'Hover', 'designer' ),
            ]
        );

        $this->add_control(
            'arrow_hover_color',
            [
                'label' => __( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'arrow_hover_background_color',
            [
                'label' => __( 'Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'arrow_hover_border_color',
            [
                'label' => __( 'Border Hover Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

		$this->end_controls_section();
	}

	protected function __post_dot_style_controls() {

        $this->start_controls_section(
            '_section_style_dots',
            [
                'label' => __( 'Dots', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'pagination_type' => 'bullets',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_nav_position_y',
            [
                'label' => __( 'Vertical Position', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'rem' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 150,
                    ],
                ],
                'default'   => [
                    'size' => -30,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
                    'pagination_type' => 'bullets',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_nav_spacing',
            [
                'label' => __( 'Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'gap: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
                    'pagination_type' => 'bullets',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_nav_align',
            [
                'label' => __( 'Alignment', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
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
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'justify-content: {{VALUE}}'
                ],
                'condition' => [
                    'pagination_type' => 'bullets',
                ]
            ]
        );

        $this->add_control(
            'dots_nav_width_size',
            [
                'label' => __( 'Width', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
                    'pagination_type' => 'bullets',
                ]
            ]
        );

        $this->add_control(
            'dots_nav_height_size',
            [
                'label' => __( 'Height', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
                    'pagination_type' => 'bullets',
                ]
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'dots_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}} .swiper-pagination span',
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius',
            [
                'label' => __( 'Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
				'condition' => [
                    'pagination_type' => 'bullets',
                ]
            ]
        );

        $this->add_control(
			'dots_color',
			[
				'label' => __( 'Dots background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
				],
				'condition' => [
                    'pagination_type' => 'bullets',
                ]
			]
		);

		$this->add_control(
			'dots_active_color',
			[
				'label' => __( 'Dots active background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
				],
				'condition' => [
                    'pagination_type' => 'bullets',
                ],
				'separator' => 'after',
			]
		);

        $this->end_controls_section();
    }

	protected function __post_progressbar_style_controls() {

		$this->start_controls_section(
            '_section_style_progress',
            [
                'label' => __( 'Progress Bar', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination_type' => 'progressbar',
                ]
            ]
        );

		$this->add_responsive_control(
            'progressbar_nav_position_y',
            [
                'label' => __( 'Vertical Position', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'rem' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 150,
                    ],
                ],
                'default'   => [
                    'size' => -30,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};top:auto;left:auto;',
                ],
				'condition' => [
                    'pagination_type' => 'progressbar',
                ]
            ]
        );

		$this->add_responsive_control(
            'progressbar_nav_height_size',
            [
                'label' => __( 'Height', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 2,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'pagination_type' => 'progressbar',
                ]
            ]
        );


        $this->add_responsive_control(
            'progressbar_width_size',
            [
                'label' => __( 'Width', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default'   => [
                    'size' => 100,
                    'unit' => '%'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'width: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
                    'pagination_type' => 'progressbar',
                ]
            ]
        );

		$this->add_control(
			'progressbar_color',
			[
				'label' => __( 'Progressbar background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-progressbar' => 'background: {{VALUE}};',
				],
				'condition' => [
                    'pagination_type' => 'progressbar',
                ]
			]
		);

		$this->add_control(
			'progressbar_active_color',
			[
				'label' => __( 'Progressbar active background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-progressbar-fill' => 'background-color: {{VALUE}};',
				],
				'condition' => [
                    'pagination_type' => 'progressbar',
                ],
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
            'progressbar_border_radius',
            [
                'label' => __( 'Progressbar Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
                    'pagination_type' => 'progressbar',
                ]
            ]
        );

		$this->add_responsive_control(
            'progressbar_active_border_radius',
            [
                'label' => __( 'Progressbar Active Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar-fill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
                    'pagination_type' => 'progressbar',
                ]
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

		$excerpt_length = ! empty( $settings['excerpt_length'] ) ? intval( $settings['excerpt_length'] ) : 50; // Default to 50 words

		$icon_box_style = '';

		if($settings['button_type'] === 'icon-boxed'){
			$icon_box_style = 'style=width:54px;';
		}

		$this->add_render_attribute( 'button_attribute', 'class', Helper::instance()->get_button_classes( $settings) );

		$readmore__button_label = ! empty( $settings['button_label'] ) ? $settings['button_label']  : 'Read More';

		$config = [
			'dots'				=> !empty($settings['dots']),
            'arrows'			=> !empty($settings['arrow']),
			'watchSlidesProgress' =>  true,
			'grabCursor'		=> (!empty($settings['grab_cursor']) && $settings['grab_cursor'] == 'yes') ? true: false,
			'autoplay'			=> !empty($settings['autoplay']),
            'pauseOnHover'		=> !empty($settings['autoplay_hover_pause']),
            'speed'				=> !empty($settings['autoplay_speed']) ? $settings['autoplay_speed'] : 1000,
            'slidesPerView'		=> isset($settings['slide_perpage']['size']) ? $settings['slide_perpage']['size'] : 3,
			'spaceBetween'		=> isset($settings['space_between_items']['size']) ? $settings['space_between_items']['size'] : 30,
            'slidesPerGroup'	=> $settings['slides_scroll']['size'],
            'loop'  			=> ( !empty($settings['infinite_loop'] ) && $settings['infinite_loop'] == 'yes' ) ? true : false,
            'breakpoints'		=> [
				320 => [
					'slidesPerView'    => isset($settings['slide_perpage_mobile']['size']) ? $settings['slide_perpage_mobile']['size'] : 1,
                    'slidesPerGroup'   => isset($settings['slides_scroll_mobile']['size']) ? $settings['slides_scroll_mobile']['size'] : 1,
					'spaceBetween'     => isset($settings['space_between_items_mobile']['size']) ? $settings['space_between_items_mobile']['size'] : 15,

                ],
                768 => [
					'slidesPerView'    => isset($settings['slide_perpage_tablet']['size']) ? $settings['slide_perpage_tablet']['size'] : 2,
                    'slidesPerGroup'   => isset($settings['slides_scroll_tablet']['size']) ? $settings['slides_scroll_tablet']['size'] : 1,
					'spaceBetween'     => isset($settings['space_between_items_tablet']['size']) ? $settings['space_between_items_tablet']['size'] : 20,
                ],
                1024 => [
					'slidesPerView'    => isset($settings['slide_perpage']['size']) ? $settings['slide_perpage']['size'] : 3,
                    'slidesPerGroup'   => isset($settings['slides_scroll']['size']) ? $settings['slides_scroll']['size'] : 1,
					'spaceBetween'     => isset($settings['space_between_items']['size']) ? $settings['space_between_items']['size'] : 30,
                ]
            ],

        ];

		if( 'bullets' === $settings['pagination_type']){
			$config['pagination'] = [
				'el' => '.swiper-pagination-'.$this->get_id(),
				'type' => 'bullets',
				'clickable' => true,
			];
		}elseif( 'progressbar' === $settings['pagination_type'] ) {
			$config['pagination'] = [
				'el' => '.swiper-pagination-'.$this->get_id(),
				'type' => 'progressbar',
				'clickable' => true,
			];
		}

		if( $settings['arrow'] == 'yes') {
			$config['navigation'] = [
				'nextEl' => '.swiper-button-next-'.$this->get_id(),
				'prevEl' => '.swiper-button-prev-'.$this->get_id(),
			];
		}

		if( $settings['scrollbar'] == 'yes' ){
			$config['scrollbar'] = [
				'el' => '.swiper-scrollbar-'.$this->get_id(),
				'hide'	=> true,
			];
		}

        $this->add_render_attribute(
            'wrapper',
            [
				'id'	=> 'block_posts_carousel_'.$this->get_id(),
				'class' => [
					'block--posts-carousel',
					!empty( $settings['title_hover_underline'] ) ? 'designer-title--hover-' . $settings['title_hover_underline'] : '',
					!empty( $settings['image_hover'] ) ? 'designer-image--hover-' . $settings['image_hover'] : '',
					! empty( $settings['image_hover_zoom_origin'] ) ? 'designer-image--hover-from-' . $settings['image_hover_zoom_origin'] : '',
					! empty( $settings['layout'] ) ? 'designer-item-layout--' . $settings['layout'] : '',
					! empty( $settings['_navigation_position'] ) ? 'designer-navigation__' . $settings['_navigation_position'] : '',
					($settings['_navigation_hide'] !== 'default') ? 'designer-hide-navigation__'.$settings['_navigation_hide'] : '',

				],
                'data-selector' => esc_attr( $this->get_id() ),
				'data-config' => wp_json_encode($config),
            ]
        );

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

        $query = new \WP_Query($args); ?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div id="block_postscarousel_<?php echo esc_attr( $this->get_id() ) ?>" class="designer-post-slider swiper designer-swiper-container">
				<div class="posts-inner swiper-wrapper">
					<?php
						while ( $query->have_posts() ) : $query->the_post();
							$categories = get_the_category( get_the_ID() ); ?>
							<div class="post--slider-item swiper-slide slider-slide">
								<?php require \Designer::plugin_dir().'widgets/posts-carousel/snippets/'.$settings['layout'].'.php'; ?>
							</div>
						<?php
						endwhile;
					wp_reset_postdata(); ?>
				</div>
				<?php if($settings['_navigation_position'] == 'inside'):?>
							<?php if( $settings['arrow'] == 'yes' ): ?>
								<div class="slide-previous swiper-button-prev-<?php echo esc_attr( $this->get_id() ) ?>">
									<?php
										if( $settings['arrow_icon']['value'] ){
											\Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
										}else{ ?>
											<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
												<path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
											</svg>
									<?php } ?>
								</div>
								<div class="slide-next swiper-button-next-<?php echo esc_attr( $this->get_id() ) ?>">
									<?php
										if( $settings['arrow_icon']['value'] ){
											\Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
										}else{ ?>
											<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
												<path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
											</svg>
									<?php } ?>
								</div>
							<?php endif; ?>
						<?php endif;?>
			</div>
			<?php if($settings['_navigation_position'] == 'outside'):?>
				<?php if( $settings['arrow'] == 'yes' ): ?>
					<div class="slide-previous swiper-button-prev-<?php echo esc_attr( $this->get_id() ) ?>">
						<?php
							if( $settings['arrow_icon']['value'] ){
								\Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
							}else{ ?>
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
									<path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
								</svg>
						<?php } ?>
					</div>
					<div class="slide-next swiper-button-next-<?php echo esc_attr( $this->get_id() ) ?>">
						<?php
							if( $settings['arrow_icon']['value'] ){
								\Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
							}else{ ?>
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
									<path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
								</svg>
						<?php } ?>
					</div>
				<?php endif; ?>
			<?php endif;?>
			<?php if($settings['_navigation_position'] == 'together'):?>
				<div class="designer-swiper-together-nav">
					<div class="designer-swiper-together-inner">
					<?php if( $settings['arrow'] == 'yes' ): ?>
						<div class="slide-previous swiper-button-prev-<?php echo esc_attr( $this->get_id() ) ?>">
							<?php
								if( $settings['arrow_icon']['value'] ){
									\Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
								}else{ ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
										<path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
									</svg>
							<?php } ?>
						</div>
						<div class="slide-next swiper-button-next-<?php echo esc_attr( $this->get_id() ) ?>">
							<?php
								if( $settings['arrow_icon']['value'] ){
									\Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
								}else{ ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
										<path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
									</svg>
							<?php } ?>
						</div>
					<?php endif; ?>
					</div>
				</div>
			<?php endif;?>

			<?php if( $settings['pagination_type'] !== 'hide'): ?>
				<div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $this->get_id() ) ?>"></div>
			<?php endif; ?>

			<?php if( $settings['scrollbar'] == 'yes' ): ?>
				<div class="swiper-scrollbar swiper-scrollbar-<?php echo esc_attr( $this->get_id() ) ?>"></div>
			<?php endif; ?>

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
