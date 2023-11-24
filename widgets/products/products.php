<?php

namespace Designer\Widgets\Products;

use Designer;
use Designer\Includes\Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Products extends Widget_Base {

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
		return 'products';
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
		return esc_html__( 'Products', 'designer' );
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
		return [ 'woocommerce-elements' ];
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
        return [ 'swiper' ];
    }

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'slider' ];
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
			'products_settings',
			[
				'label' => esc_html__( 'Products', 'designer' )
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
			'products_grid_column',
			[
				'label' => esc_html__( 'Columns', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'2' => esc_html__( '2', 'designer' ),
					'3' => esc_html__( '3', 'designer' ),
					'4' => esc_html__( '4', 'designer' ),
					'5' => esc_html__( '5', 'designer' ),
					'6' => esc_html__( '6', 'designer' ),
				],
			]
		);

		$this->add_control(
			'products_grid_count',
			[
			   'label'   => __( 'Products Count', 'designer' ),
			   'type'    => Controls_Manager::NUMBER,
			   'default' => 8,
			   'min'     => 1,
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
        $this->__products_style_controls();
		$this->__content_style_controls();
        $this->__products_image_style_controls();
    }

	protected function __products_style_controls(){

		$this->start_controls_section(
            'products_styles',
            [
                'label' => esc_html__('Styles', 'designer'),
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

		$this->add_render_attribute(
            'products',
            [
				'id'	=> 'block_products_'.$this->get_id(),
                'class' => [ 
					'block-products__widget', 
					'block--products-grid', 
                    !empty( $settings['image_hover'] ) ? 'designer-image--hover-' . $settings['image_hover'] : '',
					! empty( $settings['image_hover_zoom_origin'] ) ? 'designer-image--hover-from-' . $settings['image_hover_zoom_origin'] : ''],
            ]
        );

		$product_count = $settings['products_grid_count'];
		$product_columns = $settings['products_grid_column'];
		$product_filters = $settings['products_filter'];

		$product_orders = $settings['products_order'];

		$product_categories = $settings['products_grid_categories']; // get custom field value
		$product_category_slug = '';
		if($product_categories >= 1 ) {
			$product_category_slug = implode(', ', $product_categories);
		}
		?>
		<div id="block--products-<?php echo esc_attr($this->get_id()); ?>" <?php $this->print_render_attribute_string( 'products' ); ?>>
			<?php
				$args = [
					'post_type'      => 'product',
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
					<div class="block--products-wrapper woocommerce">
						<ul class="block-products__inner products columns-<?php echo absint($product_columns); ?> ">
							<?php while ( $query->have_posts() ) : $query->the_post(); ?>

								<?php wc_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; ?>
						</ul>
					</div>
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
    protected function content_template() { }
}
