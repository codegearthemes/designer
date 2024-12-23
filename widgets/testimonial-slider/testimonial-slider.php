<?php

namespace Designer\Widgets\Testimonial_Slider;

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

class Testimonial_Slider extends Widget_Base {

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        if( !wp_script_is('swiper', 'registered') ){
            wp_register_script( 'swiper', \Designer::plugin_url().'assets/vendor/swiper/js/swiper-bundle.min.js', ['elementor-frontend'], '7.0.1', true );
        }
        wp_register_style( 'testimonial-slider', \Designer::plugin_url().'widgets/testimonial-slider/assets/testimonial-slider.css', array(), '1.0.0', 'all' );
        wp_register_script( 'testimonial-slider', \Designer::plugin_url().'widgets/testimonial-slider/assets/testimonial-slider.js', array('swiper','elementor-frontend'), '1.0.0', true );

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
		return 'testimonial-slider';
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
		return esc_html__( 'Testimonial Slider', 'designer' );
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
		return 'designer-icon eicon-testimonial-carousel';
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
		return [ 'testimonial', 'testimonial slider', 'reviews' ];
	}

    
    /**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'swiper', 'testimonial-slider' ];
    }

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'testimonial-slider' ];
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

        $repeater = new Repeater();

        $repeater->add_control(
			'author_image',
			[
                'label' => __( 'Author Image', 'designer' ),
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
			'company_logo',
			[
                'label' => __( 'Company Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

        $repeater->add_control(
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

        $repeater->add_control(
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

        $repeater->add_control(
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

        $repeater->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
				'dynamic' => [
					'active' => true,
                ],
                'default'   => 'Designer is Best ',
			]
		);

        
		$repeater->add_control(
			'testimonial_rating_amount',
			[
				'label' => esc_html__( 'Rating', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
				'default' => 4.5,
			]
		);

        $repeater->add_control(
			'content',
			[
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet cursus volutpat. Aliquam sit amet ligula et justo tincidunt laoreet non vitae lorem. Aliquam porttitor tellus enim, eget commodo augue porta ut. Maecenas lobortis ligula vel tellus sagittis ullamcorperv vestibulum pellentesque cursutu.',
				'label_block' => true,
				'label' => __( 'Content', 'designer' ),
			]
		);

        $repeater->add_control(
			'testimonial_date',
			[
				'label' => esc_html__( 'Date', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '3 Days Ago',
			]
		);

       
        $this->add_control(
			'testimonials',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default'   => [
                    [
						'author_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'testimonial_rating_amount' => 4.5,
						'title' => esc_html__( 'Designer is Best ', 'designer' ),
						'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet cursus volutpat. Aliquam sit amet ligula et justo tincidunt laoreet non vitae lorem. Aliquam porttitor tellus enim, eget commodo augue porta ut. Maecenas lobortis ligula vel tellus sagittis ullamcorperv vestibulum pellentesque cursutu.', 'designer' ),
						'name' => esc_html__( 'Tim K.', 'designer' ),
						'position' => esc_html__( 'Designer CEO', 'designer' ),
						'testimonial_date' => esc_html__( '3 Days Ago', 'designer' ),
					],  
                    [
						'author_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'testimonial_rating_amount' => 5,
						'title' => esc_html__( 'Excellent Support', 'designer' ),
						'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet cursus volutpat. Aliquam sit amet ligula et justo tincidunt laoreet non vitae lorem. Aliquam porttitor tellus enim, eget commodo augue porta ut. Maecenas lobortis ligula vel tellus sagittis ullamcorperv vestibulum pellentesque cursutu.', 'designer' ),
						'name' => esc_html__( 'Brad B.', 'designer' ),
						'position' => esc_html__( 'Designer Founder', 'designer' ),
						'testimonial_date' => esc_html__( '5 Days Ago', 'designer' ),
					], 
                    [
						'author_image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'testimonial_rating_amount' => 5,
						'title' => esc_html__( 'Creative and Easy To Use', 'designer' ),
						'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet cursus volutpat. Aliquam sit amet ligula et justo tincidunt laoreet non vitae lorem. Aliquam porttitor tellus enim, eget commodo augue porta ut. Maecenas lobortis ligula vel tellus sagittis ullamcorperv vestibulum pellentesque cursutu.', 'designer' ),
						'name' => esc_html__( 'Simon M.', 'designer' ),
						'position' => esc_html__( 'Designer Marketing', 'designer' ),
						'testimonial_date' => esc_html__( '2 Days Ago', 'designer' ),
					], 
                ],
                'title_field' => '{{{ title }}}',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'_section_settings',
			[
				'label' => __( 'Settings', 'designer' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
			'autoplay_hover_pause',
			[
				'label' => esc_html__( 'Pause on hover', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'autoplay' => 'yes',
				]
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
			'loop',
			[
				'label' => __( 'Infinite Loop?', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'designer' ),
				'label_off' => __( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
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
                    'fraction' => __('Fraction', 'designer'),
                    'number' => __('Number', 'designer'),
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

        $this->add_responsive_control(
			'testimonial_gutter',
			[
				'label' => esc_html__( 'Gutter', 'designer' ),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
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
                'condition' => [
					'slide_perpage[size]!' => 1,
				],
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
			'testimonial_rating',
			[
				'label' => esc_html__( 'Rating', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
                'separator' => 'before'
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
					'testimonial_rating' => 'yes',
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
					'testimonial_rating' => 'yes',
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
					'testimonial_rating' => 'yes',
					'testimonial_rating_score' => '',
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
        $this->__testimonial_general_style_controls();
        $this->__testimonial_content_style_controls();
        $this->__testimonial_meta_controls();
        $this->__testimonial_arrow_style_controls();
        $this->__testimonial_dot_style_controls();
        $this->__testimonial_progress_bar_style_controls();
        $this->__testimonial_fraction_style_controls();
    }

    protected function __testimonial_general_style_controls() {

        $this->start_controls_section(
            '_section_general_style_item',
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
                    '{{WRAPPER}} .block--testimonial-slider .content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'testimonial_content_bg',
                'label'    => __( 'Background', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .block--testimonial-slider .content',
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_box_shadow',
				'selector' => '{{WRAPPER}} .block--testimonial-slider .content',
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
                    '{{WRAPPER}} .block--testimonial-slider .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.designer-testimonial-meta-position-left .designer-testimonial-meta' => 'padding-top: {{TOP}}{{UNIT}};',
					'{{WRAPPER}}.designer-testimonial-meta-position-right .designer-testimonial-meta' => 'padding-top: {{TOP}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block--testimonial-slider .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .block--testimonial-slider .content-item .designer-testimonial-meta' => 'text-align: {{VALUE}};',
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
				'type' => \Elementor\Controls_Manager::HEADING,
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

    protected function __testimonial_arrow_style_controls() {

        $this->start_controls_section(
            '_section_style_arrow',
            [
                'label' => __( 'Navigation : Arrow', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrow' => 'yes',
                ]
            ],

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

    protected function __testimonial_dot_style_controls() {

        $this->start_controls_section(
            '_section_style_dots',
            [
                'label' => __( 'Dots', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination_type' => ['bullets','number'],
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'pagination_number_typography',
                'selector' => '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet',
                'condition' => [
                    'pagination_type' =>'number',
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
            ]
        );

        $this->add_responsive_control(
            'dots_nav_spacing',
            [
                'label' => __( 'Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 5,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'gap: {{SIZE}}{{UNIT}};',
                ],
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
            ]
        );

        $this->add_control(
            'dots_nav_width_size',
            [
                'label' => __( 'Width', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'dots_nav_height_size',
            [
                'label' => __( 'Height', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
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
            ]
        );

        $this->add_control(
			'dots_color',
			[
				'label' => __( 'Number Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'color: {{VALUE}};',
				],
				'condition' => [
					'pagination_type' => 'number',
				]
			]
		);

        $this->add_control(
			'dots_bg_color',
			[
				'label' => __( 'Dots Background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'dots_active_color',
			[
				'label' => __( 'Number Active Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet-active' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'pagination_type' => 'number',
				]
			]
		);

		$this->add_control(
			'dots_active_bg_color',
			[
				'label' => __( 'Dots Active Background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

        $this->end_controls_section();
    }

    protected function __testimonial_progress_bar_style_controls() {

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

    protected function __testimonial_fraction_style_controls() {
        $this->start_controls_section(
            '_section_style_fraction',
            [
                'label' => __( 'Fraction', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination_type' => 'fraction',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'pagination_fraction_active_typography',
                'label'    => __( 'Fraction Active', 'designer' ),
                'selector' => '{{WRAPPER}} .swiper-pagination-fraction .swiper-pagination-current',
            ]
        );

        $this->add_control(
			'fraction_color',
			[
				'label' => __( 'Fraction Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-fraction' => 'color: {{VALUE}};',
				],
				'condition' => [
                    'pagination_type' => 'fraction',
                ]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'pagination_fraction_total_typography',
                'label'    => __( 'Fraction Total', 'designer' ),
                'selector' => '{{WRAPPER}} .swiper-pagination-fraction .swiper-pagination-total',
                'condition' => [
                    'pagination_type' => 'fraction',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_fraction_position_y',
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
                    '{{WRAPPER}} .swiper-pagination-fraction' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'pagination_type' => 'fraction',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_fraction_align',
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
                    'pagination_type' => 'fraction',
                ]
            ]
        );



        $this->end_controls_section();
    }

    public function render_testimonial_image( $testimonial ) {

		if ( !empty($testimonial['author_image']['url']) ) {?>
			<div class="designer-testimonial-image">
                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'thumbnail', 'author_image' ); ?>
			</div>
        <?php
        }

	}

    public function render_testimonial_meta( $testimonial, $testimonial_count ) { 
        $logo_element = 'div';
        ?>
        <?php if( $testimonial['name'] != '' || $testimonial['position'] != '' ): ?>
            <div class="author-meta">
                <?php if( $testimonial['name']): ?>
                    <p class="name h6"><?php echo wp_kses_post( $testimonial['name'] ); ?></p>
                <?php endif; ?>
                <?php if( $testimonial['position']): ?>
                    <small class="position"><?php echo wp_kses_post( $testimonial['position'] ); ?></small>
                <?php endif; ?>
                <?php if ( ! empty( $testimonial['company_logo']['url'] ) ) {
        
                    $this->add_render_attribute( 'logo_attribute'. $testimonial_count, 'class', 'designer-testimonial-logo-image elementor-clearfix' );
                    if ( ! empty( $testimonial['company_logo_url']['url'] ) ) {
                        
                        $logo_element = 'a';

                        $this->add_render_attribute( 'logo_attribute'. $testimonial_count, 'href', $testimonial['company_logo_url']['url'] );

                        if ( $testimonial['company_logo_url']['is_external'] ) {
                            $this->add_render_attribute( 'logo_attribute'. $testimonial_count, 'target', '_blank' );
                        }

                        if ( $testimonial['company_logo_url']['nofollow'] ) {
                            $this->add_render_attribute( 'logo_attribute'. $testimonial_count, 'nofollow', '' );
                        }

                    }
                    if ( !empty($testimonial['company_logo']['url']) ) {
                        echo '<'. esc_attr( $logo_element ) .' '. $this->get_render_attribute_string( 'logo_attribute'. $testimonial_count ) .'>';
                            echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'thumbnail', 'company_logo' );
                        echo '</'. esc_attr( $logo_element ) .'>';
                    }
                }?>
            </div>
        <?php endif;
    }

    public function designer_testimonial_content( $testimonial ) {
        $settings = $this->get_settings(); ?>

        <?php if( $testimonial['title'] || $testimonial['content'] ): ?>
            <div class="content">
                <?php if ( $settings['quote_show'] == 'yes' ): ?>
                    <div class="designer-testimonial-icon">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['testimonial_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                <?php endif; ?>
                <?php if( $testimonial['title']): ?>
                    <h4 class="title h5"><?php echo wp_kses_post( $testimonial['title'] ); ?></h4>
                <?php endif; ?>
                <?php if($settings['rating_position'] === 'top'): ?>
                    <?php $this->render_testimonial_rating( $testimonial ); ?>
                <?php endif;?>
                <?php if( $testimonial['content']): ?>
                    <p><?php echo wp_kses_post( $testimonial['content'] ); ?></p>
                <?php endif; ?>
                <?php if($settings['rating_position'] === 'bottom'): ?>
                    <?php $this->render_testimonial_rating( $testimonial ); ?>
                <?php endif;?>
                <?php if ( ! empty( $testimonial['testimonial_date'] ) ) : ?>
                    <div class="designer-testimonial-date"><?php echo esc_html( $testimonial['testimonial_date'] ); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
    }

    public function render_testimonial_rating( $testimonial ) {
		$settings = $this->get_settings();
		$rating_amount = $testimonial['testimonial_rating_amount'];
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

            if ( 'yes' === $settings['testimonial_rating'] && ! empty( $rating_amount ) ) : ?>	

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
        
		if ( empty( $settings['testimonials'] ) ) {
			return;
        }

        $config = [
            'dots'              => !empty($settings['dots']),
            'arrows'			=> !empty($settings['arrow']),
            'grabCursor'		=> (!empty($settings['grab_cursor']) && $settings['grab_cursor'] == 'yes') ? true: false,
            'speed'				=> !empty($settings['autoplay_speed']) ? $settings['autoplay_speed'] : 1000,
            'loop'  			=> ($settings['loop'] == 'yes') ? true : false,
            'slidesPerView'     => isset($settings['slide_perpage']['size']) ? $settings['slide_perpage']['size'] : 3,
            'spaceBetween'      => isset($settings['testimonial_gutter']['size']) ? $settings['testimonial_gutter']['size'] : 30,
            'breakpoints'		=> [
                320 => [
                    'slidesPerView'    => !empty($settings['slide_perpage_mobile']['size']) ? $settings['slide_perpage_mobile']['size'] : 1,
                    'slidesPerGroup'   => !empty($settings['slides_scroll_mobile']['size']) ? $settings['slides_scroll_mobile']['size'] : 1,
                    'spaceBetween'     => !empty($settings['testimonial_gutter_mobile']['size']) ? $settings['testimonial_gutter_mobile']['size'] : 15,
                    
                ],
                768 => [
                    'slidesPerView'    => !empty($settings['slide_perpage_tablet']['size']) ? $settings['slide_perpage_tablet']['size'] : 2,
                    'slidesPerGroup'   => !empty($settings['slides_scroll_tablet']['size']) ? $settings['slides_scroll_tablet']['size'] : 1,
                    'spaceBetween'     => !empty($settings['testimonial_gutter_tablet']['size']) ? $settings['testimonial_gutter_tablet']['size'] : 20,
                ],
                1024 => [
                    'slidesPerView'    => !empty($settings['slide_perpage']['size']) ? $settings['slide_perpage']['size'] : 3,
                    'slidesPerGroup'   => !empty($settings['slides_scroll']['size']) ? $settings['slides_scroll']['size'] : 1,
                    'spaceBetween'     => !empty($settings['testimonial_gutter']['size']) ? $settings['testimonial_gutter']['size'] : 30,
                ]
            ]
        ];

        if ('yes' === $settings['autoplay']) {
            $config['autoplay'] = [
                'disableOnInteraction' => false,
                'pauseOnMouseEnter' => !empty($settings['autoplay_hover_pause']),
            ];
        }

        if( $settings['arrow'] == 'yes') {
			$config['navigation'] = [
				'nextEl' => '.swiper-button-next-'.$this->get_id(),
				'prevEl' => '.swiper-button-prev-'.$this->get_id(),
			];
		}

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
		}elseif( 'fraction' === $settings['pagination_type'] ) {
			$config['pagination'] = [
				'el' => '.swiper-pagination-'.$this->get_id(),
				'type' => 'fraction',
			];
		}

       
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => [ 'block--testimonial-slider' ],
				'data-selector' => $this->get_id(),
                'data-config' => wp_json_encode($config)
        
            ]
        );
        if ('number' === $settings['pagination_type']) {
            $this->add_render_attribute('wrapper', 'class', 'testimonial-number-pagination');
        }
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div id="testimonial_slider_<?php echo esc_attr( $this->get_id() ) ?>" class="swiper">
                <div class="testimonial-inner testimonial-wrapper swiper-wrapper">
                    <?php
                        $testimonial_count = 0;
                        foreach ( $settings['testimonials'] as $testimonial ) : ?>
                            <div class="swiper-slide testimonial-slide">
                                <div class="content-item">

                                    <?php if ( $settings['meta_position'] === 'extra' ) : ?>
                                        <?php $this->render_testimonial_image($testimonial); ?>
                                    <?php endif; ?>

                                    <?php $this->designer_testimonial_content($testimonial);?>

                                    <?php if ( $settings['meta_position'] === 'extra' ) : ?>
                                        <?php $this->render_testimonial_meta( $testimonial, $testimonial_count );?>
                                    <?php endif; ?>
                                    
                                    <?php if ( $settings['meta_position'] !== 'extra' ) : ?>
                                        <div class="designer-testimonial-meta elementor-clearfix">
                                            <div class="author-meta-inner">
                                                <?php $this->render_testimonial_image($testimonial); ?>
                                                <?php $this->render_testimonial_meta( $testimonial, $testimonial_count );?>
                                            </div>	
                                        </div>
							        <?php endif; ?>
                                </div>
                            </div>
                        <?php
                        $testimonial_count++;
                        endforeach;
                    ?>

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
