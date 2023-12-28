<?php

namespace Designer\Widgets\Video_Popup;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Designer\Includes\Helper;

class Video_Popup extends Widget_Base{

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

        wp_register_style( 'glightbox', \Designer::plugin_url().'assets/vendor/glightbox/css/glightbox.css',array(), '3.1.0', 'all', true );

        wp_register_script( 'glightbox', \Designer::plugin_url().'assets/vendor/glightbox/js/glightbox.js', ['elementor-frontend'], '3.1.0', true );
        wp_register_script( 'video-popup', \Designer::plugin_url().'widgets/video-popup/assets/video-popup.js', array('elementor-frontend'), '1.0.0', true );

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
		return 'code-video-popup';
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
		return esc_html__( 'Video Popup', 'designer' );
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
		return 'designer-icon eicon-youtube';
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
			'popup',
            'video popup',
            'modal',
            'Youtube',
            'Vimeo',
            'iframe'
		];
	}

	    /**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'glightbox' ];
    }

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'glightbox', 'video-popup' ];
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
                'label' => esc_html__('Popup', 'designer'),
                "tab"	=> Controls_Manager::TAB_CONTENT,
                "description"	=> esc_html__( "Default popup options.", "designer" ),
            ]
        );

        $this->add_control(
			'popup_type',
			[
				'label' => __( 'Popup Type', 'designer' ),
				"description"	=> esc_html__( "Choose a Popup type options.", "designer" ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'icon',
				'options' => [
					'icon' => [
						'title' => __( 'Icon', 'designer' ),
						'icon' => 'eicon-favorite',
					],
					'btn' => [
						'title' => __( 'Button', 'designer' ),
						'icon' => 'eicon-button',
					],
                    'img' => [
						'title' => __( 'Image', 'elementor' ),
						'icon' => 'eicon-image',
					],
				],
				'toggle' => false,
			]
		);

        $this->add_control(
			"popup_url",
			[
				"type"			=> Controls_Manager::TEXT,
				"label" 		=> esc_html__( "Video URL", "designer" ),
				"description"	=> esc_html__( "Enter popup video url. Example https://www.youtube.com/watch?v=6nGLlpK_4Uo", "designer" ),
				"default"		=> "https://www.youtube.com/watch?v=6nGLlpK_4Uo"
			]
		);

        $this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'designer' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'designer' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'designer' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'designer' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .block--video-popup-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'enable_icon',
			[
				'label' => esc_html__( 'Enable Icon', 'designer' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'popup_type' => 'img',
				],
			]
		);

        $this->end_controls_section();

        //Icon Section
        $this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'popup_type',
							'operator' => '===',
							'value'	=> 'icon',
						],
						[
							'name' => 'enable_icon',
							'operator' => '===',
							'value'	=> 'yes',
						],
					],
				],
			]
		);
        $this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-play',
					'library' => 'fa-solid',
				],
			]
		);
        $this->add_control(
			'icon_view',
			[
				'label' => esc_html__( 'View', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'designer' ),
					'stacked' => esc_html__( 'Stacked', 'designer' ),
					'framed' => esc_html__( 'Framed', 'designer' ),
				],
				'default' => 'default',
				'prefix_class' => 'designer-view-',
			]
		);
		$this->add_control(
			'icon_shape',
			[
				'label' => esc_html__( 'Shape', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => esc_html__( 'Circle', 'designer' ),
					'square' => esc_html__( 'Square', 'designer' ),
				],
				'default' => 'circle',
				'condition' => [
					'icon_view!' => 'default',
				],
				'prefix_class' => 'designer-shape-',
			]
		);

		$this->add_control(
			'enable_ripple',
			[
				'label' => esc_html__( 'Enable Ripple Animation', 'designer' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'icon_view!' => 'default',
				],
			]
		);

		$this->add_control(
			'ripple_animation',
			[
				'label' => esc_html__( 'Ripple Animation', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-border' => esc_html__( 'Style Border', 'designer' ),
					'style-flat' => esc_html__( 'Style Flat', 'designer' ),
				],
				'default'	=> 'style-border',
				'prefix_class'	=> 'designer-ripple-animation-',
				'condition'	=> [
					'enable_ripple'	=> 'yes'
				]

			]

		);


		$this->end_controls_section();

        // Image Section
		$this->start_controls_section(
			"image_section",
			[
				"label"			=> esc_html__( "Image", "designer" ),
				"tab"			=> Controls_Manager::TAB_CONTENT,
				"description"	=> esc_html__( "Popup trigger image options available here.", "designer" ),
				'condition' => [
					'popup_type' => 'img',
				],
			]
		);
		$this->add_control(
			"image",
			[
				"type" => Controls_Manager::MEDIA,
				"label" => esc_html__( "Image", "designer" ),
				"description"	=> esc_html__( "Choose popup trigger image.", "designer" ),
				"dynamic" => [
					"active" => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'full',
				'separator' => 'none',
			]
		);
		$this->end_controls_section();

        // Button
		$this->start_controls_section(
			"button_section",
			[
				"label"			=> esc_html__( "Button", "designer" ),
				"tab"			=> Controls_Manager::TAB_CONTENT,
				"description"	=> esc_html__( "Button options available here.", "designer" ),
				'condition' => [
					'popup_type' => 'btn',
				],
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
			'button_label',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Button label', 'designer' ),
				'default' => __( 'Click Here', 'designer' )
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
		$this->__general_style_controls();
		$this->__icon_style_controls();
		$this->__button_all_style_controls();
		$this->__image_style_controls();
    }

	protected function __general_style_controls() {
		$this->start_controls_section(
			'section_style_general',
			[
				'label' => __( 'General', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'popup_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .block--video-popup-wrapper ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'popup_margin',
			[
				'label' => esc_html__( 'Margin', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .block--video-popup-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .block--video-popup-wrapper' => 'background-color: {{VALUE}};'
				]
			]
		);



		$this->end_controls_section();
	}

    protected function __icon_style_controls() {

		// Style Icon Section
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'popup_type',
							'operator' => '===',
							'value'	=> 'icon',
						],
						[
							'name' => 'enable_icon',
							'operator' => '===',
							'value'	=> 'yes',
						],
					],
				],
			]
		);
		$this->start_controls_tabs( 'icon_colors' );
		$this->start_controls_tab(
			'icon_colors_normal',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
			]
		);
		$this->add_control(
			'icon_primary_color',
			[
				'label' => esc_html__( 'Primary Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}}.designer-view-stacked .popup-trigger-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.designer-view-framed .popup-trigger-icon, {{WRAPPER}}.designer-view-default .popup-trigger-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.designer-view-framed .popup-trigger-icon, {{WRAPPER}}.designer-view-default .popup-trigger-icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'icon_secondary_color',
			[
				'label' => esc_html__( 'Secondary Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#888888',
				'condition' => [
					'icon_view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.designer-view-framed .popup-trigger-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.designer-view-stacked .popup-trigger-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.designer-view-stacked .popup-trigger-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'icon_colors_hover',
			[
				'label' => esc_html__( 'Hover', 'designer' ),
			]
		);
		$this->add_control(
			'icon_primary_hcolor',
			[
				'label' => esc_html__( 'Primary Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.designer-view-stacked:hover .popup-trigger-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.designer-view-framed:hover .popup-trigger-icon, {{WRAPPER}}.designer-view-default:hover .popup-trigger-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.designer-view-framed:hover .popup-trigger-icon, {{WRAPPER}}.designer-view-default:hover .popup-trigger-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_secondary_hcolor',
			[
				'label' => esc_html__( 'Secondary Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.designer-view-framed:hover .popup-trigger-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.designer-view-stacked:hover .popup-trigger-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.designer-view-stacked:hover .popup-trigger-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'designer' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .popup-trigger-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'icon_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}.designer-view-stacked .popup-trigger-icon' => 'padding: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.designer-view-framed .popup-trigger-icon' => 'padding: {{SIZE}}{{UNIT}};'
				],
				'defailt' => [
					'unit' => 'px',
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'condition' => [
					'icon_view!' => 'default',
				],
			]
		);
		$this->add_responsive_control(
			'icon_rotate',
			[
				'label' => esc_html__( 'Rotate', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'tablet_default' => [
					'unit' => 'deg',
				],
				'mobile_default' => [
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .popup-trigger-icon i, {{WRAPPER}} .popup-trigger-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);
		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .popup-trigger-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}} .popup-trigger-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'icon_border_width',
			[
				'label' => esc_html__( 'Border Width', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .popup-trigger-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'icon_view' => 'framed',
				],
			]
		);
		$this->add_control(
			'icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .popup-trigger-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'icon_view!' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'ripple_animation_border_radius',
			[
				'label' => esc_html__( 'Ripple Animation Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom' => 50,
					'left' => 50,
				],
				'selectors' => [
					'{{WRAPPER}}.designer-ripple-animation-style-border .popup-trigger-icon:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.designer-ripple-animation-style-border .popup-trigger-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.designer-ripple-animation-style-flat .popup-trigger-icon:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.designer-ripple-animation-style-flat .popup-trigger-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition'	=> [
					'enable_ripple'	=> 'yes',
				]
			]
		);

		$this->add_control(
			'ripple_animation_border_color',
			[
				'label' => esc_html__( 'Ripple Animation Border Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}}.designer-ripple-animation-style-border .popup-trigger-icon:before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}}.designer-ripple-animation-style-border .popup-trigger-icon:after' => 'border-color: {{VALUE}}',
				],
				'condition'	=> [
					'enable_ripple'	=> 'yes',
					'ripple_animation'	=> 'style-border',
				]
			]
		);

		$this->add_control(
			'ripple_animation_background_color',
			[
				'label' => esc_html__( 'Ripple Animation Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}}.designer-ripple-animation-style-flat .popup-trigger-icon:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.designer-ripple-animation-style-flat .popup-trigger-icon:after' => 'background-color: {{VALUE}}',
				],
				'condition'	=> [
					'enable_ripple'	=> 'yes',
					'ripple_animation'	=> 'style-flat',
				]
			]
		);




		$this->end_controls_section();

    }

	protected function __button_all_style_controls() {
		$this->__button_style_controls();
		$this->__icon_button_style_controls();
		$this->__inner_border_style_controls();
		$this->__underline_style_controls();
	}

	protected function __button_style_controls() {

        $this->start_controls_section(
            '_section_style_button',
            [
                'label' => __( 'Button', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'popup_type' => 'btn',
				]
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

	protected function __icon_button_style_controls() {

		$this->start_controls_section(
			'_section_style_icon',
			[
				'label' => esc_html__( 'Icon Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'popup_type'	=> 'btn',
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
					'popup_type'	=> 'btn',
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
					'popup_type'	=> 'btn',
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

	protected function __image_style_controls() {
		$this->start_controls_section(
			'_section_style_image',
			[
				'label' => esc_html__( 'Image Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'popup_type'	=> 'img',
				]
			]

		);

		$this->add_responsive_control(
			'image_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Width', 'designer' ),
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step'	=> 1,
					],
					'%' => [
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
				'selectors' => [
					'{{WRAPPER}} .designer-video-popup-trigger-img img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_max_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Max Width', 'designer' ),
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step'	=> 1,
					],
					'%' => [
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
				'selectors' => [
					'{{WRAPPER}} .designer-video-popup-trigger-img img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Height', 'designer' ),
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step'	=> 1,
					],
					'%' => [
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
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .designer-video-popup-trigger-img img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label'   => __( 'Object Fit', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'fill'           => __( 'Fill', 'designer' ),
					'cover'           => __( 'Cover', 'designer' ),
					'contain'           => __( 'Contain', 'designer' ),
				],
				'condition' => [
                    'image_height[size]!' => '',
                ],
				'selectors' => [
					'{{WRAPPER}} .designer-video-popup-trigger-img img' => 'object-fit: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'image_position',
			[
				'label'   => __( 'Object Position', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'center'           => __( 'Center Center', 'designer' ),
					'center-left'           => __( 'Center Left', 'designer' ),
					'center-right'           => __( 'Center Right', 'designer' ),
					'top-center'           => __( 'Top Center', 'designer' ),
					'top-left'           => __( 'Top Left', 'designer' ),
					'top-right'           => __( 'Top Right', 'designer' ),
					'bottom-center'           => __( 'Bottom Center', 'designer' ),
					'bottom-left'           => __( 'Bottom Left', 'designer' ),
					'bottom-right'           => __( 'Bottom Right', 'designer' ),
				],
				'selectors_dictionary' => [
					'center' => 'center center',
					'center-left' => 'center left',
					'center-right' => 'center right',
					'top-center' => 'top center',
					'top-left' => 'top left',
					'top-right' => 'top right',
					'bottom-center' => 'bottom center',
					'bottom-left' => 'bottom left',
					'bottom-right' => 'bottom right',

				],
				'condition' => [
					'image_height[size]!' => '',
                    'image_fit' => 'cover',
                ],
				'selectors' => [
					'{{WRAPPER}} .designer-video-popup-trigger-img img' => 'object-position: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .designer-video-popup-trigger-img:after' => 'background-color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_hover_color',
			[
				'label' => esc_html__( 'Overlay Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .block--video-popup-wrapper:hover .designer-video-popup-trigger-img:after' => 'background-color: {{VALUE}}',
				],
			]
		);



		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .designer-video-popup-trigger-img img',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .designer-video-popup-trigger-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function get_button_classes( $settings){
		$button_classes = array();

		$button_classes[]	= 'block-advanced__btn';
		$button_classes[]	= 'video-glightbox';
		$button_classes[]	= 'btn-link__text';
		$button_classes[]	= !empty($settings['button_layout'])? 'designer-layout--' .$settings['button_layout'] : '';
		$button_classes[]	= !empty($settings['button_type']) ? 'designer-type--'	.$settings['button_type']	: '';
		$button_classes[]	=  !empty($settings['button_size']) ? 'designer-size--'.$settings['button_size']	: '';
		$button_classes[]	= !empty($settings['button_hover_reveal'])? 'designer-hover--reveal designer--'.$settings['button_hover_reveal'] : '';
		$button_classes[]	=  !empty($settings['button_icon_align']) ? 'designer-icon--' .$settings['button_icon_align']: '';
		$button_classes[]	= !empty($settings['button_icon_move'])? 'designer-hover--icon-' .$settings['button_icon_move'] : '';
		$button_classes[]	= !empty($settings['inner_border_hover_animation'])? 'designer-inner-border-hover--' .$settings['inner_border_hover_animation'] : '';
		$button_classes[]	= 'yes'	=== $settings['show_underline']? 'designer-text-underline' : '';
		$button_classes[]	= !empty($settings['underline_alignment'])? 'designer-underline--'.$settings['underline_alignment'] : '';
		$button_classes[]	= 'yes'	=== $settings['show_hover_underline_draw'] ? 'designer-button-underline-draw' : '';

		$button_classes = array_filter($button_classes, function($class) {
			return !empty($class);
		});

		return implode(' ', $button_classes );
	}

	public function render_button_inner_border($settings){
		$inner_border = '';

		$inner_border .= '<div class="designer-m-inner-border">';

			if('move-outer-edge' !== $settings['inner_border_hover_animation']){
				$inner_border .= '<span class="designer-m-border-top"></span>';
				$inner_border .= '<span class="designer-m-border-right"></span>';
				$inner_border .= '<span class="designer-m-border-bottom"></span>';
				$inner_border .= '<span class="designer-m-border-left"></span>';
			}
		$inner_border .= '</div>';

		if ( ! empty( $settings['inner_border_hover_animation'] ) && ( ( 'draw d-draw-center' == $settings['inner_border_hover_animation'] ) || ( 'draw d-draw-one-point' == $settings['inner_border_hover_animation'] ) || ( 'draw d-draw-two-points' == $settings['inner_border_hover_animation'] ) ) ) {
			$inner_border .= '<div class="designer-m-inner-border designer-m-inner-border-copy">';
				$inner_border .= '<span class="designer-m-border-top"></span>';
				$inner_border .= '<span class="designer-m-border-right"></span>';
				$inner_border .= '<span class="designer-m-border-bottom"></span>';
				$inner_border .= '<span class="designer-m-border-left"></span>';
			$inner_border .= '</div>';
		}

		return $inner_border;

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

		//Define Variables
		$popup_url = isset( $settings['popup_url'] ) && !empty( $settings['popup_url'] ) ? $settings['popup_url'] : ''; ?>
		<div id = "block_video_popup_<?php echo esc_attr( $this->get_id() ); ?>" data-selector="<?php echo esc_attr( $this->get_id() ); ?>"  class="block--video-popup-wrapper">
			<?php
				switch ($settings['popup_type']) {
					case "icon":
						$this->add_render_attribute( 'icon-wrapper', 'class', 'designer-video-popup-trigger' );
						$this->add_render_attribute( 'icon-wrapper', 'class', 'popup-trigger-icon' );
						$this->add_render_attribute( 'icon-wrapper', 'class', 'video-glightbox' );
						$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon' );
						$this->add_render_attribute( 'icon-wrapper', 'href', esc_url( $popup_url ) );
						if ( ! empty( $settings['hover_animation'] ) ) {
							$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-animation-'.$settings['hover_animation'] );
						}

						echo '<a '. $this->get_render_attribute_string( 'icon-wrapper' ) .'>';
								\Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
						echo '</a>';

					break;

					case "btn":
						$icon_box_style = '';

						if($settings['button_type'] === 'icon-boxed'){
							$icon_box_style = 'style=width:54px;';
						}

                        $this->add_render_attribute( 'button_attribute', 'class', 'video-glightbox ' . Helper::instance()->get_button_classes($settings) );
						$this->add_render_attribute( 'button_attribute', 'href', esc_url( $popup_url ) );
						echo '<div class = "block-action__advanced">';
							echo ' <a ' .$this->get_render_attribute_string('button_attribute').'>';
								if( $settings['button_label'] != '' ):
									echo '<span class="label">'.esc_html( $settings['button_label'] ).'</span>';
								endif;

								if( 'yes'	===	$settings['show_icon_sidebar']):
									echo '<span class="designer-m-border"></span>';
								endif;

								if ( $settings['button_icon_enable'] == 'yes' ):

									echo '<span class="designer-m-icon"'.esc_attr($icon_box_style).' >';
										echo '<span class="designer-m-icon-inner">';
											\Elementor\Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] );
											if($settings['button_icon_move'] !== 'move-horizontal-short' && $settings['button_icon_move'] !== ''){
												\Elementor\Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] );
											}
										echo '</span>';
									echo '</span>';

								endif;

								if( $settings['button_type'] === 'inner-border'):
									echo Helper::instance()->render_button_inner_border($settings);
								endif;

							echo '</a>';
						echo '</div>';

					break;

					case "img":
						$this->add_render_attribute( 'image-wrapper', 'class', 'designer-video-popup-trigger' );
						$this->add_render_attribute( 'image-wrapper', 'class', 'designer-video-popup-trigger-img' );
						$this->add_render_attribute( 'image-wrapper', 'href', esc_url( $popup_url ) );
						$this->add_render_attribute( 'image-wrapper', 'class', 'video-glightbox' );?>
						<a <?php echo $this->get_render_attribute_string('image-wrapper');?>>
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>
							<?php if('yes' === $settings['enable_icon']):
								$this->add_render_attribute( 'image-icon-wrapper', 'class', 'popup-trigger-icon' );
								$this->add_render_attribute( 'image-icon-wrapper', 'class', 'elementor-icon' );
								if ( ! empty( $settings['hover_animation'] ) ) {
									$this->add_render_attribute( 'image-icon-wrapper', 'class', 'elementor-animation-'.$settings['hover_animation'] );
								}

							?>
								<div <?php echo $this->get_render_attribute_string('image-icon-wrapper');?>>
									<?php if( $settings['selected_icon'] ):?>
										<?php \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );?>
									<?php endif;?>
								</div>
							<?php endif;?>
						</a>
						<?php
					break;

				}

			?>
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
    protected function content_template() {
	}

}
