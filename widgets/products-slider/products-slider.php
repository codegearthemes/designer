<?php

namespace Designer\Widgets\Products_Slider;

use Designer;
use Designer\Includes\Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Products_Slider extends Widget_Base {

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

		wp_register_style( 'products-slider', \Designer::plugin_url().'widgets/products-slider/assets/product-slider.css', array(), '1.0.0', 'all' );

        if( !wp_script_is('swiper', 'registered') ){
            wp_register_script( 'swiper', \Designer::plugin_url().'assets/vendor/swiper/js/swiper.min.js', ['elementor-frontend'], '10.2.0', true );
        }
        wp_register_script( 'products-slider', \Designer::plugin_url().'widgets/products-slider/assets/product-slider.js', array('swiper','elementor-frontend'), '1.0.0', true );

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
		return 'designer-products-slider';
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
		return esc_html__( 'Products Slider', 'designer' );
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
		return 'designer-icon eicon-products';
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
		return [ 'designer-woocommerce' ];
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
		return [ 'slider', 'product', 'woocommerce' ];
	}

    /**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'swiper', 'products-slider' ];
    }

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'swiper', 'products-slider' ];
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
			'_products_settings',
			[
				'label' => esc_html__( 'Product Settings', 'designer' )
			]
		);

		if ( ! class_exists('WooCommerce') ) {
            $this->add_control(
                'products_woocommerce_required',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => __('<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=woocommerce&tab=search&type=term" target="_blank">WooCommerce</a> first.', 'designer'),
                    'content_classes' => 'warning',
                ]
            );
        }

		$this->add_control(
			'products_filter',
			[
				'label' => esc_html__( 'Filter By', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'recent-products',
				'options' => [
					'sale-products' 		=> esc_html__( 'Sale products', 'designer' ),
					'recent-products' 		=> esc_html__( 'Recent products', 'designer' ),
					'featured-products' 	=> esc_html__( 'Featured products', 'designer' ),
					'top-products' 			=> esc_html__( 'Top rated products', 'designer' ),
					'best-selling-products' => esc_html__( 'Best selling products', 'designer' ),
				],
			]
		);

		$this->add_control(
			'products_count',
			[
			   'label'   => __( 'Products Count', 'designer' ),
			   'type'    => Controls_Manager::NUMBER,
			   'default' => 8,
			   'min'     => 2,
			   'max'     => 30,
			   'step'    => 1,
			]
		);

		$this->add_control(
			'products_grid_categories',
			[
				'label' => esc_html__( 'Product categories', 'designer' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => Helper::instance()->woocommerce_product_categories(),
			]
		);

		$this->add_control(
            'products_order',
            [
                'label'   => __('Order', 'designer'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC'  => __('Ascending', 'designer'),
                    'DESC' => __('Descending', 'designer'),
                ],
            ]
        );

		$this->end_controls_section();
		$this->__products_slider_controls();
		$this->register_style_controls();
    }

	protected function __products_slider_controls(){

		$this->start_controls_section(
            '_products_slider',
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
						'min' => 2,
						'max' => 6,
						'step' => 1,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 4,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'default' => [
					'size' => 4,
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

	/**
	 * Register style controls.
	 *
	 * Add input fields to allow the user to customize the widget style.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_style_controls() {
        $this->__products_style_controls();
        $this->__content_style_controls();
        $this->__products_image_style_controls();
		$this->__products_arrow_style_controls();
		$this->__products_dot_style_controls();
		$this->__products_progressbar_style_controls();

    }

	protected function __products_style_controls(){

		$this->start_controls_section(
            '_products_styles',
            [
                'label' => esc_html__('Card', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'Padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .block-products__widget .products li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
				'label' => esc_html__( 'Border', 'designer' ),
                'selector' => '{{WRAPPER}} .block-products__widget .products li',
            ]
        );


        $this->add_control(
            'products_background_color',
            [
                'label'     => esc_html__('Background', 'designer'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .block-products__widget .products li' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();
	}

    protected function __content_style_controls() {
        $this->start_controls_section(
            '_content_styles',
            [
                'label' => esc_html__('Card Content', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .block-products__widget .card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .block-products__widget .purchase' => 'padding: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'content_background',
            [
                'label' => __( 'Background', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block-products__widget .card-content, {{WRAPPER}} .block-products__widget .purchase' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
			'products_title',
			[
				'label' => esc_html__( 'Products Title', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'title_color',
            [
                'label' => __( 'Title color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-products__widget .woocommerce-loop-product__title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .block-products__widget .woocommerce-loop-product__title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
				'label' => __( 'Title Typography', 'designer' ),
                'selector' => '{{WRAPPER}} .block-products__widget .woocommerce-loop-product__title',
            ]
        );

		$this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Title Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'default'   => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-products__widget .woocommerce-loop-product__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->add_control(
			'products_price',
			[
				'label' => esc_html__( 'Products Price', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'Price_color',
            [
                'label' => __( 'Price color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-products__widget .price' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
            'price_hover_color',
            [
                'label' => __( 'Price Hover color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-products__widget .price:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
				'label' => __( 'Price Typography', 'designer' ),
                'selector' => '{{WRAPPER}} .block-products__widget .price',
            ]
        );

		$this->add_responsive_control(
            'price_bottom_spacing',
            [
                'label' => __( 'Price Bottom Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'default'   => [
                    'size' => 12,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-products__widget .price' => 'margin: 0 0 {{SIZE}}{{UNIT}} 0;',
				],
            ]
        );



        $this->end_controls_section();

    }

    protected function __products_image_style_controls() {

		$this->start_controls_section(
            '_image_style_settings',
            [
                'label' => esc_html__('Image Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .block-products__widget .card-media:after' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .block-products__widget .product-card-inner:hover .card-media:after' => 'background-color: {{VALUE}};',
				],
			]
		);




		$this->end_controls_section();

	}


	protected function __products_arrow_style_controls() {
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

        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function __products_dot_style_controls() {

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
                    'px' => [
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
				'label' => __( 'Dots Background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
				],
				'condition' => [
                    'pagination_type' => 'bullets',
                ]
			]
		);

		$this->add_control(
			'dots_active_color',
			[
				'label' => __( 'Dots Active Background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
                    'pagination_type' => 'bullets',
                ],
				'separator' => 'after',
			]
		);

        $this->end_controls_section();
    }

	protected function __products_progressbar_style_controls() {

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

		if ( ! class_exists('WooCommerce') ) {
            return;
        }

		$config = [
			'dots'				=> !empty($settings['dots']),
            'arrows'			=> !empty($settings['arrow']),
			'spaceBetween'		=> $settings['space_between_items']['size'],
			'watchSlidesProgress' =>  true,
			'grabCursor'		=> (!empty($settings['grab_cursor']) && $settings['grab_cursor'] == 'yes') ? true: false,
			'autoplay'			=> !empty($settings['autoplay']),
            'pauseOnHover'		=> !empty($settings['autoplay_hover_pause']),
            'speed'				=> !empty($settings['autoplay_speed']) ? $settings['autoplay_speed'] : 1000,
            'slidesPerView'		=> $settings['slide_perpage']['size'],
            'slidesPerGroup'	=> $settings['slides_scroll']['size'],
            'loop'  			=> ( !empty($settings['infinite_loop'] ) && $settings['infinite_loop'] == 'yes' ) ? true : false,
            'breakpoints'		=> [
				320 => [
					'slidesPerView'    => isset($settings['slide_perpage_mobile']['size']) ? $settings['slide_perpage_mobile']['size'] : 2,
                    'slidesPerGroup'   => isset($settings['slides_scroll_mobile']['size']) ? $settings['slides_scroll_mobile']['size'] : 1,
					'spaceBetween'     => isset($settings['space_between_items_mobile']['size']) ? $settings['space_between_items_mobile']['size'] : 20,
                ],
                768 => [
					'slidesPerView'    => isset($settings['slide_perpage_tablet']['size']) ? $settings['slide_perpage']['size'] : 3,
                    'slidesPerGroup'   => isset($settings['slides_scroll_tablet']['size']) ? $settings['slides_scroll_tablet']['size'] : 1,
					'spaceBetween'     => isset($settings['space_between_items_tablet']['size']) ? $settings['space_between_items_tablet']['size'] : 20,
                ],
                1024 => [
					'slidesPerView'    => isset($settings['slide_perpage']['size']) ? $settings['slide_perpage']['size'] : 4,
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
				'id'	=> 'block_products_'.$this->get_id(),
                'class' => [
					'block-products__widget',
					'block-products__carousel',
                    !empty( $settings['image_hover'] ) ? 'designer-image--hover-' . $settings['image_hover'] : '',
					! empty( $settings['image_hover_zoom_origin'] ) ? 'designer-image--hover-from-' . $settings['image_hover_zoom_origin'] : '',
					'designer-navigation__'.$settings['_navigation_position'],
					($settings['_navigation_hide'] !== 'default') ? 'designer-hide-navigation__'.$settings['_navigation_hide'] : ''  ],
				'data-selector' => $this->get_id(),
                'data-config' => wp_json_encode($config)
            ]
        );

		$product_count = $settings['products_count'];
		$product_filters = $settings['products_filter'];

		$product_orders = $settings['products_order'];

		$product_categories = $settings['products_grid_categories']; // get custom field value
		$product_category_slug = '';
		if($product_categories >= 1 ) {
			$product_category_slug = implode(', ', $product_categories);
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> >
			<?php
				$args = [
					'post_type'      => 'product',
					'post_status'           => 'publish',
					'posts_per_page' => $product_count,
					'order'          => $product_orders
				];

				if ( ! empty($settings['products_grid_categories']) ) {
					$args['tax_query'] = [
						[
							'taxonomy' => 'product_cat',
							'field'    => 'slug',
							'terms'    => $product_category_slug,
							'operator' => 'IN',
						],
					];
				}

				if ( 'featured-products' == $product_filters ) {
					$args['tax_query'] = [
						'relation' => 'AND',
						[
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'featured',
						],
					];

					if ( $settings['products_grid_categories'] ) {
						$args['tax_query'][] = [
							'taxonomy' => 'product_cat',
							'field'    => 'slug',
							'terms'    => $product_category_slug,
						];
					}
				} elseif ( 'best-selling-products' == $product_filters ) {

					$args['meta_key'] = 'total_sales';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'ASC';

				} elseif ( 'sale-products' == $product_filters ) {

					$args['meta_query'] = [
						'relation' => 'OR',
						[
							'key'     => '_sale_price',
							'value'   => 0,
							'compare' => '>',
							'type'    => 'numeric',
						],
						[
							'key'     => '_min_variation_sale_price',
							'value'   => 0,
							'compare' => '>',
							'type'    => 'numeric',
						],
					];

				} elseif ( 'top-products' == $product_filters ) {
					$args['meta_key'] = '_wc_average_rating';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
				}

				$query = new \WP_Query($args);

				?>

				<?php if ( $query->have_posts() ) : ?>
					<div id="<?php echo esc_attr('products_slider_'.$this->get_id() ); ?>" class="block-products__slider woocommerce swiper designer-swiper-container designer-product-slider">
						<ul class="products block-products__inner columns-<?php echo esc_attr( $settings['slide_perpage']['size'] ) ?> slider-inner slider-wrapper swiper-wrapper">
							<?php while ( $query->have_posts() ) : $query->the_post(); ?>

								<?php wc_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; ?>
						</ul>
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
				<?php endif; ?>
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

				<?php wp_reset_postdata(); ?>
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
