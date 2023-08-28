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


class Posts_Carousel extends Widget_Base{

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

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
		return 'posts-carousel';
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
		return 'eicon-slider-push';
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
		return [
			'widget',
			'posts',
			'Posts Carousel',
            'CodegearThemes',
		];
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
            array(
                'label'       => esc_html__( 'Layout:', 'designer' ),
                'type'        => Controls_Manager::SELECT,
                'label_block' => true,
                'default'       =>  'default',
                'options'      => array(
					'default'   => esc_html__('Default','designer'),
                )
            )
        );

		$this->add_responsive_control(
			'slide_perpage',
			[
				'label' => esc_html__( 'Slides per page', 'designer' ),
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
            'item_spacing',
            [
                'label' => __( 'Horizontal Spacing', 'designer' ),
                'type' => Controls_Manager::NUMBER,
                'placeholder' => '15',
				'min' => 0,
				'max' => 100,
				'step' => 5,
				'default' => 15,
                'frontend_available' => true,
            ]
        );

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay?', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'designer' ),
				'label_off' => __( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __( 'Infinite Loop?', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'designer' ),
				'label_off' => __( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
				'render_type' => 'ui',
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
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'arrow' => 'yes',
				]
			]
		);

        $this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Show dots', 'designer' ),
				'type' =>   Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'feature_1',
			[
				'label' => esc_html__( 'Need more options', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >'.__( "Buy Pro", "designer").'</a>',
			]
		);

        $this->end_controls_section();
        $this->register_advanced_controls();
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
		$this->__title_style_controls();
		$this->__general_style_controls();
		$this->__arrow_style_controls();
    }

	protected function __general_query_controls() {

		$this->start_controls_section(
            '_query_settings',
            [
                'label' => esc_html__('Query', 'designer'),
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
			'post_per_page',
			[
				'label' => esc_html__( 'Post per page', 'designer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 4,
			]
		);

		$this->add_control(
			'author',
			[
				'label' => esc_html__( 'Show Author', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'date',
			[
				'label' => esc_html__( 'Show Date', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_cat',
			[
				'label' => esc_html__( 'Show Categories', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'feature_2',
			[
				'label' => esc_html__( 'Need more options', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >'.__( "Buy Pro", "designer").'</a>',
			]
		);

		$this->end_controls_section();
	}

    protected function __title_style_controls() {

        $this->start_controls_section(
            '_section_style_title',
            [
                'label' => __( 'Title', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'title_color',
            [
                'label' => __( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--posts-carousel .entry-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title',
                'selector' => '{{WRAPPER}} .block--posts-carousel .entry-title',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->end_controls_section();
    }

    protected function __general_style_controls() {

        $this->start_controls_section(
            '_style_settings',
            [
                'label' => esc_html__('Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'designer' ),
				'selector' => '{{WRAPPER}} .block--posts-carousel .post--slider-item',
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
				'selectors' => [
					'{{WRAPPER}} .block--posts-carousel post--slider-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'feature_3',
			[
				'label' => esc_html__( 'Need more options', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >'.__( "Buy Pro", "designer").'</a>',
			]
		);

        $this->end_controls_section();
    }

	protected function __arrow_style_controls() {

        $this->start_controls_section(
            '_section_style_arrow',
            [
                'label' => __( 'Navigation', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'button_size',
            [
                'label' => __( 'Button size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
					'unit' => 'px',
					'size' => 40
				]
            ]
        );

        $this->add_responsive_control(
            'arrow_size',
            [
                'label' => __( 'Arrow size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
					'unit' => 'px',
					'size' => 30
				],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous svg, {{WRAPPER}} .slide-next svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'arrow_border',
                'selector' => '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next',
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
                'label' => __( 'Icon Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_bg_color',
            [
                'label' => __( 'Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'background-color: {{VALUE}};',
                ],
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
                'label' => __( 'Icon Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_bg_color',
            [
                'label' => __( 'Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_border_color',
            [
                'label' => __( 'Border Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'arrow_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
			'feature_4',
			[
				'label' => esc_html__( 'Need more options', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >'.__( "Buy Pro", "designer").'</a>',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

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

		$config = [
			'dots'				=> !empty($settings['dots']),
            'arrows'			=> !empty($settings['arrow']),
			'autoplay'			=> !empty($settings['autoplay']),
            'pauseOnHover'		=> !empty($settings['autoplay_hover_pause']),
            'speed'				=> !empty($settings['speed']) ? $settings['speed'] : 1000,
            'loop'  			=> ( !empty($settings['loop'] ) && $settings['loop'] == 'yes' ) ? true : false,
			'spaceBetween'      => $settings['item_spacing'],
			'pagination' => [
				'el' => '.swiper-pagination-'.$this->get_id(),
				'type' => "bullets",
                'clickable' => true,
			],
			'navigation' => [
				'nextEl' => '.swiper-button-next-'.$this->get_id(),
				'prevEl' => '.swiper-button-prev-'.$this->get_id(),
			],
			'breakpoints'		=> [
                320 => [
                    'slidesPerView'    => !empty($settings['slide_perpage_mobile']['size']) ? $settings['slide_perpage_mobile']['size'] : 1,
                    'slidesPerGroup'   => !empty($settings['slides_scroll_mobile']['size']) ? $settings['slides_scroll_mobile']['size'] : 1,
                ],
                768 => [
                    'slidesPerView'    => !empty($settings['slide_perpage_tablet']['size']) ? $settings['slide_perpage_tablet']['size'] : 3,
                    'slidesPerGroup'   => !empty($settings['slides_scroll_tablet']['size']) ? $settings['slides_scroll_tablet']['size'] : 1
                ],
                1024 => [
                    'slidesPerView'    => !empty($settings['slide_perpage']['size']) ? $settings['slide_perpage']['size'] : 3,
                    'slidesPerGroup'   => !empty($settings['slides_scroll']['size']) ? $settings['slides_scroll']['size'] : 1,
                ]
            ]
        ];

        $this->add_render_attribute(
            'wrapper',
            [
                'class' => [ 'block--posts-carousel', $settings['layout'] ],
                'data-selector' => esc_attr( $this->get_id() ),
				'data-config' => wp_json_encode($config)
            ]
        );

        $categories = $settings['categories'];
        if( !empty(  $categories ) && is_array( $categories ) ){
			$args = [
				'posts_per_page' => $settings['post_per_page'],
				'category_name' => implode( ',', $categories )
			];
		}else{
			$args = [
				'posts_per_page' => $settings['post_per_page'],
			];
		}

        $query = new \WP_Query($args); ?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div id="block_postscarousel_<?php echo esc_attr( $this->get_id() ) ?>" class="swiper swiper-container">
				<div class="posts-inner swiper-wrapper">
					<?php
						while ( $query->have_posts() ) : $query->the_post();
							$categories = get_the_category( get_the_ID() ); ?>
							<div class="post--slider-item swiper-slide slider-slide">
								<article id="post-<?php the_ID(); ?>" <?php post_class('post-grid'); ?>>
									<div class="content">
										<?php if ( has_post_thumbnail() ) { ?>
											<div class="image-left">
												<?php the_post_thumbnail( 'full' );  ?>
											</div>
										<?php } ?>
										<div class="entry-header">
											<?php
												if ( ! empty( $categories ) && $settings['show_cat'] ) { ?>
													<div class="categories">
														<?php foreach( $categories as $category ) { ?>
															<a class="entry-term" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'designer' ), $category->name ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
														<?php } ?>
													</div>
													<?php
												}
												the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
											?>
											<?php if( $settings['date'] || $settings['author'] ): ?>
												<div class="meta-data">
													<?php
														if( $settings['date'] )
															echo Helper::instance()->author(); ?>
													<?php
														if( $settings['date'] )
															echo Helper::instance()->posted_on(); ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</article>
							</div>
						<?php
						endwhile;
					wp_reset_postdata(); ?>
				</div>
			</div>
			<?php if( $settings['arrow'] == 'yes' ): ?>
				<div class="slide-previous swiper-button-prev-<?php echo esc_attr($this->get_id()) ?>">
					<?php
						if( $settings['arrow_icon']['value'] ){
							\Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
						}else{ ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
								<path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
							</svg>
					<?php } ?>
				</div>
				<div class="slide-next swiper-button-next-<?php echo esc_attr($this->get_id()) ?>">
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
			<?php if( $settings['dots'] == 'yes' ): ?>
				<div class="swiper-pagination swiper-pagination-<?php echo esc_attr($this->get_id()) ?>"></div>
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
