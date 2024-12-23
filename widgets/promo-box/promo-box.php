<?php
namespace Designer\Widgets\Promo_Box;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons;
use Elementor\Icons_Manager;
use Designer\Includes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promo_Box extends Widget_Base{

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

        wp_register_style( 'promo-box', \Designer::plugin_url().'widgets/promo-box/assets/promo-box.css', array(), '1.0.0', 'all' );
		wp_register_script( 'promo-box', \Designer::plugin_url().'widgets/promo-box/assets/promo-box.js', array('jquery'), '1.0.0', true );

    }

    public function get_name() {
		return 'designer-promo-box';
	}

    public function get_title() {
		return esc_html__( 'Promo Box', 'designer' );
	}

    public function get_icon() {
		return 'designer-icon eicon-image';
	}

    public function get_categories() {
		return [ 'designer'];
	}

    public function get_keywords() {
		return [ 'designer', 'image hover', 'image effects', 'image box', 'promo box', 'banner box', 'animated banner', 'interactive banner' ];
	}

	public function get_style_depends() {
		return [ 'promo-box' ];
	}

	public function get_script_depends() {
		return [ 'promo-box' ];
	}

    public function add_control_image_style() {
		$this->add_control(
			'image_style',
			[
				'label' => esc_html__( 'Style', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover' => esc_html__( 'Cover', 'designer' ),
					'classic' => esc_html__( 'Classic', 'designer' ),
				],
				'prefix_class' => 'designer-promo-box-style-',
				'render_type' => 'template',
			]
		);
	}

    public function add_control_image_position(){
        $this->add_control(
			'image_position',
			[
				'label' => esc_html__( 'Image Position', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'position-left',
				'options' => [
					'position-left' => esc_html__( 'Left', 'designer' ),
					'position-right' => esc_html__( 'Right', 'designer' ),
                    'position-center' => esc_html__( 'Center', 'designer' ),
				],
				'prefix_class' => 'designer-promo-box-image-',
				'render_type' => 'template',
                'condition'   => [
                    'image_style'   => 'classic'
                ]
			]
		);
    }

    public function add_control_border_animation() {
		$this->add_control(
			'border_animation',
			[
				'label' => esc_html__( 'Select Animation', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'oscar' => esc_html__( 'Oscar', 'designer' ),
					'jazz' => esc_html__( 'Jazz', 'designer' ),
					'layla' => esc_html__( 'Layla', 'designer' ),
					'bubba' => esc_html__( 'Bubba', 'designer' ),
					'romeo' => esc_html__( 'Romeo', 'designer' ),
					'chicho' => esc_html__( 'Chicho', 'designer' ),
					'apollo' => esc_html__( 'Apollo', 'designer' ),
					'apollo-revert' => esc_html__( 'Apollo Revert', 'designer' ),
					'suprema' => esc_html__( 'Suprema', 'designer' ),
				],
				'default' => 'oscar',
				'condition' => [
					'image[url]!' => '',
				],
			]
		);
	}

    public function add_control_image_min_width(){
		$this->add_responsive_control(
			'image_min_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Width', 'designer' ),
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 1000,
					],
					'vh' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 310,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-image' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition'	=> [
					'image_position!' => 'position-center',
					'image_style'	=> 'classic',
				]

			]
		);
	}

    public function add_control_image_min_height(){
		$this->add_responsive_control(
			'image_min_height',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Height', 'designer' ),
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 1000,
					],
					'vh' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 390,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-image' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition'	=> [
					'image_style'	=> 'classic',
				]
			]
		);
	}

  
    // Button Options
    public function __button_settings_control(){
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
                ],
                'condition' =>  [
                    'content_link_type' => ['btn', 'box'],
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
                    'content_link_type' => ['btn', 'box'],
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
                'condition' =>  [
                    'content_link_type' => ['btn', 'box'],
                ]
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
                'condition' =>  [
                    'content_link_type' => ['btn', 'box'],
                ]

			]
        );

        $this->add_control(
			'button_label',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Button label', 'designer' ),
				'default' => __( 'Click Here', 'designer' ),
                'condition' =>  [
                    'content_link_type' => ['btn', 'box'],
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
				'separator'	=> 'before',
                'condition' =>  [
                    'content_link_type' => ['btn', 'box'],
                ]
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
                    'content_link_type' => ['btn', 'box'],
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
                    'content_link_type' => ['btn', 'box'],
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
					'content_link_type' => ['btn', 'box'],
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
                'condition'	=> [
					'content_link_type' => ['btn', 'box'],
				]
			]
		);

        $this->add_control(
			'button_title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Button title', 'designer' ),
                'description' => __( 'Button title text for accessibility.', 'designer' ),
                'condition'	=> [
					'content_link_type' => ['btn', 'box'],
				]
			]
		);

    }

    protected function register_controls() {
       // Section: Image ------------
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		); 

        $this->add_control_image_style();

        $this->add_control_image_position();

		$this->add_control_image_min_width();

		$this->add_control_image_min_height();

        $this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
			]
		);

        $this->end_controls_section();

        // Settings Control
        $this->__section_content_settings();
        $this->__section_effect_settings();
        $this->__badge_settings_controls_section();

        // Styles Control
        $this->__section_style_controls();
        $this->__button_style_controls();
		$this->__icon_style_controls();
		$this->__inner_border_style_controls();
		$this->__underline_style_controls();
        $this->__badge_style_controls();
        $this->__overlay_style_controls();
    }

    protected function __section_content_settings(){
        $this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'content_icon_type',
            [
                'label' => esc_html__( 'Select Icon Type', 'designer' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'none' => esc_html__( 'None', 'designer' ),
                    'icon' => esc_html__( 'Icon', 'designer' ),
                    'image' => esc_html__( 'Image', 'designer' ),
                ],
            ]
        );

		$this->add_control(
			'content_image',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'content_image_size',
				'default' => 'full',
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'content_icon',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'content_title',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => __('Banner Title','designer'),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_title_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => esc_html__( 'H1', 'designer' ),
					'h2' => esc_html__( 'H2', 'designer' ),
					'h3' => esc_html__( 'H3', 'designer' ),
					'h4' => esc_html__( 'H4', 'designer' ),
					'h5' => esc_html__( 'H5', 'designer' ),
					'h6' => esc_html__( 'H6', 'designer' ),
					'div' => esc_html__( 'div', 'designer' ),
					'span' => esc_html__( 'span', 'designer' ),
					'p' => esc_html__( 'p', 'designer' ),
				],
				'default' => 'h3',
			]
		);

		$this->add_control(
			'content_description',
			[
				 'label' => esc_html__( 'Description', 'designer' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 'designer'),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_link_type',
			[
				'label' => esc_html__( 'Link Type', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'title' => esc_html__( 'Title', 'designer' ),
					'btn' => esc_html__( 'Button', 'designer' ),
					'box' => esc_html__( 'Box', 'designer' ),
				],
				'default' => 'btn',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_link',
			[
				'type' => Controls_Manager::URL,
				'label' => esc_html__( 'Link', 'designer' ),
				'placeholder' => esc_html__( 'https://your-link.com', 'designer' ),
				'default' => [
					'url' => '#',
				],
				'separator' => 'before',
				'condition' => [
					'content_link_type!' => 'none',
				],
			]
		);

        $this->__button_settings_control();


        $this->end_controls_section();
    }

    protected function __section_effect_settings(){

        $this->start_controls_section(
			'section_effect',
			[
				'label' => esc_html__( 'Effects', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        
		$this->add_control(
			'hover_animation_section',
			[
				'label' => esc_html__( 'Hover Animation', 'designer' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control_border_animation();

        $this->add_control(
			'border_animation_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-bg-overlay::after' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .designer-promo-box-bg-overlay::before' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s;',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => 'none',
				],
			]
		);

        $this->add_control(
			'border_animation_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-bg-overlay::after' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
					'{{WRAPPER}} .designer-promo-box-bg-overlay::before' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => 'none',
				],
			]
		);

        $this->add_control(
			'border_animation_section',
			[
				'label' => esc_html__( 'Hover Border Style', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => 'none',
				],
			]
		);

        $this->add_control(
			'border_animation_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'default' => 'rgba(255,255,255,0.93)',
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-bg-overlay::before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .designer-promo-box-bg-overlay::after' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-apollo::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-apollo-revert::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-romeo::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-romeo::after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-suprema::after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-suprema::before' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => 'none',
				],
			]
		);

		$this->add_control(
			'border_animation_type',
			[
				'label' => esc_html__( 'Type', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'designer' ),
					'double' => esc_html__( 'Double', 'designer' ),
					'dotted' => esc_html__( 'Dotted', 'designer' ),
					'dashed' => esc_html__( 'Dashed', 'designer' ),
					'groove' => esc_html__( 'Groove', 'designer' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .designer-border-anim-layla::before' => 'border-top-style: {{VALUE}};border-bottom-style: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-layla::after' => 'border-left-style: {{VALUE}};border-right-style: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-oscar::before' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-bubba::before' => 'border-top-style: {{VALUE}};border-bottom-style: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-bubba::after' => 'border-left-style: {{VALUE}};border-right-style: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-chicho::before' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .designer-border-anim-jazz::after' => 'border-top-style: {{VALUE}};border-bottom-style: {{VALUE}};',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => [ 'none', 'apollo', 'romeo', 'suprema', 'apollo-revert' ],
				],
			]
		);

		$this->add_control(
			'border_animation_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
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
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-bg-overlay::before' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-promo-box-bg-overlay::after' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-border-anim-romeo::before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-border-anim-romeo::after' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-border-anim-suprema::after' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-border-anim-suprema::before' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => [ 'none', 'apollo', 'apollo-revert' ],
				],
			]
		);

		$this->add_control(
			'border_animation_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-border-anim-layla::before' => 'top: calc({{SIZE}}{{UNIT}} + 20px);right: {{SIZE}}{{UNIT}};bottom: calc({{SIZE}}{{UNIT}} + 20px);left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-border-anim-layla::after' => 'top: {{SIZE}}{{UNIT}};right: calc({{SIZE}}{{UNIT}} + 20px);bottom: {{SIZE}}{{UNIT}};left: calc({{SIZE}}{{UNIT}} + 20px);',
					'{{WRAPPER}} .designer-border-anim-oscar::before' => 'top: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};bottom: {{SIZE}}{{UNIT}};left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-border-anim-bubba::before' => 'top: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};bottom: {{SIZE}}{{UNIT}};left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-border-anim-bubba::after' => 'top: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};bottom: {{SIZE}}{{UNIT}};left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-border-anim-chicho::before' => 'top: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};bottom: {{SIZE}}{{UNIT}};left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => [ 'none', 'apollo', 'apollo-revert', 'romeo', 'jazz', 'suprema' ],
				],	
			]
		);

		
		$this->add_control(
			'__animation_tr',
			[
				'label' => esc_html__( 'Animation Transparency', 'designer' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'hover_animation_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'image_animation_section',
			[
				'label' => esc_html__( 'Image Animation', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'image_animation',
			[
				'label' => esc_html__( 'Select Animation', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'zoom-in' => esc_html__( 'Zoom In', 'designer' ),
					'zoom-out' => esc_html__( 'Zoom Out', 'designer' ),
					'move-left' => esc_html__( 'Move Left', 'designer' ),
					'move-right' => esc_html__( 'Move Right', 'designer' ),
					'move-up' => esc_html__( 'Move Top', 'designer' ),
					'move-down' => esc_html__( 'Move Bottom', 'designer' ),
				],
				'default' => 'zoom-in',
				'condition' => [
					'image[url]!' => '',
				],
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
				'selectors' => [
					'{{WRAPPER}} .designer-bg-anim-zoom-in' => 'transform-origin: {{VALUE}};',
					'{{WRAPPER}} .designer-bg-anim-zoom-out' => 'transform-origin: {{VALUE}};',
				],
				'condition'	=> [
					'image_animation' => ['zoom-in', 'zoom-out']
				]
			]
		);

		$this->add_control(
			'image_animation_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-bg-image' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .designer-promo-box-bg-overlay' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s;',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'image_animation_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-bg-image' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
					'{{WRAPPER}} .designer-promo-box-bg-overlay' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
				],
				'condition' => [
					'image[url]!' => '',
					'image_animation!' => 'none',
				],
			]
		);

		$this->add_control(
			'image_animation_timing',
			[
				'label' => esc_html__( 'Animation Timing', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'ease-default'   => __('Default', 'designer'),
                    'linear'         => __('Linear', 'designer'),
                    'ease-in'        => __('Ease In', 'designer'),
                    'ease-out'       => __('Ease Out', 'designer'),    
                ],
				'default' => 'ease-default',
				'condition' => [
					'image[url]!' => '',
					'image_animation!' => 'none',
				],
			]
		);

		// Heading Animation

		$this->add_control(
			'_title_animation_section',
			[
				'label' => esc_html__( 'Title Animation', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'content_title!' => '',
				],
				'separator'	=> 'before',
			]
		);

		$this->add_control(
			'title_animation',
			[
				'label' => esc_html__( 'Select Animation', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'fade-in' => esc_html__( 'Fade In', 'designer' ),
					'fade-out' => esc_html__( 'Fade Out', 'designer' ),
					'slide-top' => esc_html__( 'Slide Top', 'designer' ),
					'slide-bottom' => esc_html__( 'Slide Bottom', 'designer' ),
					'slide-left' => esc_html__( 'Slide Left', 'designer' ),
					'slide-right' => esc_html__( 'Slide Right', 'designer' ),
					'roll-left' => esc_html__( 'Roll Left', 'designer' ),
					'roll-right' => esc_html__( 'Roll Right', 'designer' ),
					'skew-top' => esc_html__( 'Skew Top', 'designer' ),
					'skew-bottom' => esc_html__( 'Skew Bottom', 'designer' ),
					
				],
				'default' => 'none',
				'condition' => [
					'content_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_animation_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-title' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
				],
				'condition' => [
					'content_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_animation_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-title' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
				],
				'condition' => [
					'content_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_animation_size',
			[
				'label' => esc_html__( 'Animation Size', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'small' => esc_html__( 'Small', 'designer' ),
					'medium' => esc_html__( 'Medium', 'designer' ),
					'large'  => esc_html__( 'Large', 'designer' ),
				],
				'condition' => [
					'content_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_animation_timing',
			[
				'label' => esc_html__( 'Animation Timing', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'ease-default'   => __('Default', 'designer'),
                    'linear'         => __('Linear', 'designer'),
                    'ease-in'        => __('Ease In', 'designer'),
                    'ease-out'       => __('Ease Out', 'designer'),    
                ],
				'default' => 'ease-default',
				'condition' => [
					'content_title!' => '',
				],
			]
		);

		// Description Animation

		$this->add_control(
			'_description_animation_section',
			[
				'label' => esc_html__( 'Description Animation', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'content_description!' => '',
				],
				'separator'	=> 'before',
			]
		);

		$this->add_control(
			'description_animation',
			[
				'label' => esc_html__( 'Select Animation', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'fade-in' => esc_html__( 'Fade In', 'designer' ),
					'slide-top' => esc_html__( 'Slide Top', 'designer' ),
					'slide-bottom' => esc_html__( 'Slide Bottom', 'designer' ),
					'slide-left' => esc_html__( 'Slide Left', 'designer' ),
					'slide-right' => esc_html__( 'Slide Right', 'designer' ),
					'roll-left' => esc_html__( 'Roll Left', 'designer' ),
					'roll-right' => esc_html__( 'Roll Right', 'designer' ),
					'skew-top' => esc_html__( 'Skew Top', 'designer' ),
					'skew-bottom' => esc_html__( 'Skew Bottom', 'designer' ),
					
				],
				'default' => 'none',
				'condition' => [
					'content_description!' => '',
				],
			]
		);

		$this->add_control(
			'description_animation_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-description' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
				],
				'condition' => [
					'content_description!' => '',
				],
			]
		);

		$this->add_control(
			'description_animation_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-description' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
				],
				'condition' => [
					'content_description!' => '',
				],
			]
		);

		$this->add_control(
			'description_animation_size',
			[
				'label' => esc_html__( 'Animation Size', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'small' => esc_html__( 'Small', 'designer' ),
					'medium' => esc_html__( 'Medium', 'designer' ),
					'large'  => esc_html__( 'Large', 'designer' ),
				],
				'condition' => [
					'content_description!' => '',
				],
			]
		);

		$this->add_control(
			'description_animation_timing',
			[
				'label' => esc_html__( 'Animation Timing', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'ease-default'   => __('Default', 'designer'),
                    'linear'         => __('Linear', 'designer'),
                    'ease-in'        => __('Ease In', 'designer'),
                    'ease-out'       => __('Ease Out', 'designer'),    
                ],
				'default' => 'ease-default',
				'condition' => [
					'content_description!' => '',
				],
			]
		);

		// Button Animation

		$this->add_control(
			'_button_animation_section',
			[
				'label' => esc_html__( 'Button Animation', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'content_link_type' => ['btn', 'box'],
				],
				'separator'	=> 'before',
			]
		);

		$this->add_control(
			'btn_animation',
			[
				'label' => esc_html__( 'Select Animation', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'fade-in' => esc_html__( 'Fade In', 'designer' ),
					'slide-top' => esc_html__( 'Slide Top', 'designer' ),
					'slide-bottom' => esc_html__( 'Slide Bottom', 'designer' ),
					'slide-left' => esc_html__( 'Slide Left', 'designer' ),
					'slide-right' => esc_html__( 'Slide Right', 'designer' ),
					'roll-left' => esc_html__( 'Roll Left', 'designer' ),
					'roll-right' => esc_html__( 'Roll Right', 'designer' ),
					'skew-top' => esc_html__( 'Skew Top', 'designer' ),
					'skew-bottom' => esc_html__( 'Skew Bottom', 'designer' ),
					
				],
				'default' => 'none',
				'condition' => [
					'content_link_type' => ['btn', 'box'],
				],
			]
		);

		
		$this->add_control(
			'button_animation_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-btn-wrap' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
				],
				'condition' => [
					'content_link_type' => ['btn', 'box'],
				],
			]
		);

		$this->add_control(
			'button_animation_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-btn-wrap' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
				],
				'condition' => [
					'content_link_type' => ['btn', 'box'],
				],
			]
		);

		$this->add_control(
			'btn_animation_size',
			[
				'label' => esc_html__( 'Animation Size', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'small' => esc_html__( 'Small', 'designer' ),
					'medium' => esc_html__( 'Medium', 'designer' ),
					'large'  => esc_html__( 'Large', 'designer' ),
				],
				'condition' => [
					'content_link_type' => ['btn', 'box'],
				],
			]
		);

		$this->add_control(
			'btn_animation_timing',
			[
				'label' => esc_html__( 'Animation Timing', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'ease-default'   => __('Default', 'designer'),
                    'linear'         => __('Linear', 'designer'),
                    'ease-in'        => __('Ease In', 'designer'),
                    'ease-out'       => __('Ease Out', 'designer'),    
                ],
				'default' => 'ease-default',
				'condition' => [
					'content_link_type' => ['btn', 'box'],
				],
			]
		);

		// Icon Animation

		$this->add_control(
			'_icon_animation_section',
			[
				'label' => esc_html__( 'Icon Animation', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'content_icon_type' => 'icon',
				],
				'separator'	=> 'before',
			]
		);

		$this->add_control(
			'icon_animation',
			[
				'label' => esc_html__( 'Select Animation', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'designer' ),
					'fade-in' => esc_html__( 'Fade In', 'designer' ),
					'slide-top' => esc_html__( 'Slide Top', 'designer' ),
					'slide-bottom' => esc_html__( 'Slide Bottom', 'designer' ),
					'slide-left' => esc_html__( 'Slide Left', 'designer' ),
					'slide-right' => esc_html__( 'Slide Right', 'designer' ),
					'roll-left' => esc_html__( 'Roll Left', 'designer' ),
					'roll-right' => esc_html__( 'Roll Right', 'designer' ),
					'skew-top' => esc_html__( 'Skew Top', 'designer' ),
					'skew-bottom' => esc_html__( 'Skew Bottom', 'designer' ),
					
				],
				'default' => 'none',
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_animation_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-icon' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
				],
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_animation_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-icon' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
				],
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);


		$this->add_control(
			'icon_animation_size',
			[
				'label' => esc_html__( 'Animation Size', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'small' => esc_html__( 'Small', 'designer' ),
					'medium' => esc_html__( 'Medium', 'designer' ),
					'large'  => esc_html__( 'Large', 'designer' ),
				],
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_animation_timing',
			[
				'label' => esc_html__( 'Animation Timing', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'ease-default'   => __('Default', 'designer'),
                    'linear'         => __('Linear', 'designer'),
                    'ease-in'        => __('Ease In', 'designer'),
                    'ease-out'       => __('Ease Out', 'designer'),    
                ],
				'default' => 'ease-default',
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		// Reveal Content

		$this->add_control(
			'reveal_content_section',
			[
				'label' => esc_html__( 'Reveal Content From Bottom', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator'	=> 'before',
				'condition'   => [
                    'image_style'   => 'cover'
                ]
			]
		);

		$this->add_control(
			'reveal_content_enable',
			[
				'label' => esc_html__( 'Reveal Content From bottom', 'designer' ),
				'type' =>  Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'   => [
                    'image_style'   => 'cover'
                ]
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
				'default' => 'none',
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
					'{{WRAPPER}} .designer-promo-box-badge-circle .designer-promo-box-badge-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .designer-promo-box-badge-circle' => 'transform: translateX({{badge_cyrcle_side_distance.SIZE}}%) translateY({{SIZE}}%);',
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
					'{{WRAPPER}} .designer-promo-box-badge-circle' => 'transform: translateX({{SIZE}}%) translateY({{badge_circle_top_distance.SIZE}}%);',
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
					'{{WRAPPER}} .designer-promo-box-badge-corner .designer-promo-box-badge-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg);',
					'{{WRAPPER}} .designer-promo-box-badge-flag' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'badge_style!' => [ 'none', 'circle' ],
				],
			]
		);

        $this->end_controls_section();
    }

    protected function __section_style_controls(){
        $this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'tabs_content_colors' );

        $this->start_controls_tab(
			'tab_content_normal_colors',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
			]
		);

        $this->add_control(
            'content_background_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-content' => 'background-color: {{VALUE}}',
				],
                'condition' =>  [
                    'image_style'   => 'classic',
                ]
			]
        );

        $this->add_control(
			'content_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .designer-promo-box-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'content_title_color',
			[
				'label' => esc_html__( 'Title Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .designer-promo-box-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_description_color',
			[
				'label' => esc_html__( 'Description Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

        $this->start_controls_tab(
			'tab_content_hover_colors',
			[
				'label' => esc_html__( 'Hover', 'designer' ),
			]
		);

        $this->add_control(
            'content_background_hover_color',
			[
				'label' => esc_html__( 'Background Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box:hover .designer-promo-box-content' => 'background-color: {{VALUE}}',
				],
                'condition' =>  [
                    'image_style'   => 'classic',
                ]
			]
        );

        $this->add_control(
			'content_hover_icon_color',
			[
				'label' => esc_html__( 'Icon Hover Color', 'Designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box:hover .designer-promo-box-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .designer-promo-box:hover .designer-promo-box-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'content_hover_title_color',
			[
				'label' => esc_html__( 'Title Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box:hover .designer-promo-box-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .designer-promo-box:hover .designer-promo-box-title a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
            'content_hover_description_color',
			[
				'label' => esc_html__( 'Description Hover Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box:hover .designer-promo-box-description' => 'color: {{VALUE}}',
				],
			]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'content_trans_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.3,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-content' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .designer-promo-box-icon i' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .designer-promo-box-title span' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .designer-promo-box-title a' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .designer-promo-box-description p' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
				],
			]
		);

        $this->add_responsive_control(
			'content_min_height',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Height', 'designer' ),
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 1000,
					],
					'vh' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 280,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-content' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 30,
					'right' => 30,
					'bottom' => 30,
					'left' => 30,
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden',
				],
			]
		);


		$this->add_control(
			'content_vr_position',
			[
				'label' => esc_html__( 'Vertical Position', 'designer' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
                'default' => 'middle',
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
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end'
				],
                'selectors' => [
					'{{WRAPPER}} .designer-promo-box-content' =>  '-webkit-justify-content: {{VALUE}};justify-content: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'content_align',
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
					'{{WRAPPER}} .designer-promo-box-content' => 'text-align: {{VALUE}};',
				],
			]
		);

        // Image
		$this->add_control(
			'content_image_section',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'content_image_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-icon img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'content_image_height',
			[
				'label' => esc_html__( 'Height', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-icon img' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'content_image_fit',
			[
				'label' => esc_html__( 'Image Fit', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'default' => 'cover',
				'options' => [
					'fill' => esc_html__( 'Fill', 'designer' ),
					'cover' => esc_html__( 'Cover', 'designer' ),
					'contain' => esc_html__( 'Contain', 'designer' ),
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-icon img' => 'object-fit: {{VALUE}};',
				],
				'condition' => [
					'content_image_height[size]!' => '',
				],
			]
		);


		// Icon
		$this->add_control(
			'content_icon_section',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'content_icon_size',
			[
				'label' => esc_html__( 'Font Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step'	=> 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 27,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-content .designer-promo-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .designer-promo-box-content .designer-promo-box-icon svg' => 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'content_icon_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-content .designer-promo-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_icon_type!' => 'none',
				],	
			]
		);

		$this->add_control(
			'content_icon_border_radius',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-content .designer-promo-box-icon img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

		// Title
		$this->add_control(
			'content_title_section',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_title_typography',
				'selector' => '{{WRAPPER}} .designer-promo-box-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'content_title_shadow',
				'selector' => '{{WRAPPER}} .designer-promo-box-title',
			]
		);

		$this->add_responsive_control(
			'content_title_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-title' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
				],	
			]
		);

		// Description
		$this->add_control(
			'content_description_section',
			[
				'label' => esc_html__( 'Description', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_description_typography',
				'selector' => '{{WRAPPER}} .designer-promo-box-description',
			]
		);

		$this->add_responsive_control(
			'content_description_distance',
			[
				'label' => esc_html__( 'Distance', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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

		$this->add_control(
			'button_hover_control',
			[
				'label' => esc_html__( 'Button Hover Control', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'button',
				'options' => [
					'button' => esc_html__( 'From Button Itself', 'designer' ),
					'box' => esc_html__( 'From Box', 'designer' ),
				],
				'prefix_class' => 'designer-button-hover-control-',
				'render_type' => 'template',
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label',
                'selector' => '{{WRAPPER}} .block-action__advanced .btn-link__text'
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
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .block-action__advanced .block-advanced__btn' => 'color: {{VALUE}};',
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
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .block-action__advanced .block-advanced__btn.designer-layout--btn-link:not(.designer-hover--reveal)'   => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .block-action__advanced .block-advanced__btn.designer-layout--outlined:not(.designer-hover--reveal)' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .block-action__advanced .block-advanced__btn.designer-layout--btn-link.designer-hover--reveal:after'   => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .block-action__advanced .block-advanced__btn.designer-layout--outlined.designer-hover--reveal:after' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .block-action__advanced .block-advanced__btn' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.designer-button-hover-control-box  .designer-promo-box:hover .block-action__advanced .btn-link__text .designer-m-icon-inner' => 'background-color: {{VALUE}};'
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
					'{{WRAPPER}}.designer-button-hover-control-box  .designer-promo-box:hover .block-advanced__btn.designer-type--icon-boxed .designer-m-border' => 'background-color:{{VALUE}};',
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
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .block-advanced__btn.designer-type--inner-border:not(.designer-inner-border-hover--draw) .designer-m-inner-border:not(.designer-m-inner-border-copy)'	=> 'color:{{VALUE}};',
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .block-advanced__btn.designer-type--inner-border .designer-m-inner-border.designer-m-inner-border-copy' => 'color: {{VALUE}};',
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
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .designer-text-underline .label:after' => 'background-color:{{VALUE}}',
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
					'{{WRAPPER}}.designer-button-hover-control-box .designer-promo-box:hover .designer-text-underline .label:after '	=> 'width:{{SIZE}}{{UNIT}}',
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

    protected function __badge_style_controls(){
		$this->start_controls_section(
			'section_style_badge',
			[
				'label' => esc_html__( 'Badge', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'badge_style!'  => 'none',
                ]
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'designer' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-badge-inner' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .designer-promo-box-badge-inner' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .designer-promo-box-badge-flag:before' => ' border-top-color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => esc_html__( 'Typography', 'designer' ),
				'selector' => '{{WRAPPER}} .designer-promo-box-badge-inner'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'badge_box_shadow',
				'selector' => '{{WRAPPER}} .designer-promo-box-badge-inner'
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
				'{{WRAPPER}} .designer-promo-box-badge .designer-promo-box-badge-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section(); // End Controls Section
	}

    protected function __overlay_style_controls(){
        $this->start_controls_section(
			'section_style_overlay',
			[
				'label' => esc_html__( 'Overlay', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_overlay_colors' );

		$this->start_controls_tab(
			'tab_overlay_normal_colors',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Overlay Color', 'designer' ),
				'default' => 'rgba(51, 51, 51, 0.39)',
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-bg-overlay' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'bg_css_filters',
				'selector' => '{{WRAPPER}} .designer-promo-box-bg-image',
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_overlay_hover_colors',
			[
				'label' => esc_html__( 'Hover', 'designer' ),
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'overlay_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Overlay Color', 'designer' ),
				'default' => 'rgba(51, 51, 51, 0.69)',
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box:hover .designer-promo-box-bg-overlay' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'bg_css_filters_hover',
				'selector' => '{{WRAPPER}} .designer-promo-box:hover .designer-promo-box-bg-image',
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'overlay_blend_mode',
			[
				'label' => esc_html__( 'Blend Mode', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal' => esc_html__( 'Normal', 'designer' ),
					'multiply' => esc_html__( 'Multiply', 'designer' ),
					'screen' => esc_html__( 'Screen', 'designer' ),
					'overlay' => esc_html__( 'Overlay', 'designer' ),
					'darken' => esc_html__( 'Darken', 'designer' ),
					'lighten' => esc_html__( 'Lighten', 'designer' ),
					'color-dodge' => esc_html__( 'Color-dodge', 'designer' ),
					'color-burn' => esc_html__( 'Color-burn', 'designer' ),
					'hard-light' => esc_html__( 'Hard-light', 'designer' ),
					'soft-light' => esc_html__( 'Soft-light', 'designer' ),
					'difference' => esc_html__( 'Difference', 'designer' ),
					'exclusion' => esc_html__( 'Exclusion', 'designer' ),
					'hue' => esc_html__( 'Hue', 'designer' ),
					'saturation' => esc_html__( 'Saturation', 'designer' ),
					'color' => esc_html__( 'Color', 'designer' ),
					'luminosity' => esc_html__( 'luminosity', 'designer' ),
				],
				'selectors' => [
					'{{WRAPPER}} .designer-promo-box-bg-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->end_controls_section(); // End Controls Section
    }

    protected function render(){
        // Get Settings
        $settings = $this->get_settings();

        $icon_box_style = '';

		if($settings['button_type'] === 'icon-boxed'){
			$icon_box_style = 'style=width:54px;';
		}

        $image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['image']['id'], 'image_size', $settings );
		$content_image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['content_image']['id'], 'content_image_size', $settings );

		if ( ! $image_src ) {
			$image_src = $settings['image']['url'];
		}

		if ( ! $content_image_src ) {
			$content_image_src = $settings['content_image']['url'];
		}

		$reveal_content = '';

		if( 'yes' === $settings['reveal_content_enable']) {
			$reveal_content = 'designer--reveal-content';
		}

        $this->add_render_attribute( 'button_attribute', 'class', Helper::instance()->get_button_classes( $settings) );
        if( !empty( $settings['button_title'] ) ){
            $this->add_render_attribute( 'button_attribute', 'title', $settings['button_title'] );
        }

        $content_btn_element = 'div';
        $link_url = $settings['content_link'] ['url'];

		if( '' !== $link_url){
			$this->add_render_attribute( 'link_attribute', 'href', $settings['content_link'] ['url']);
			
			if( $settings['content_link'] ['is_external']){
				$this->add_render_attribute( 'link_attribute', 'target', '_blank' );
			}

			if( $settings['content_link'] ['nofollow']){
				$this->add_render_attribute( 'link_attribute', 'rel', 'nofollow' );
			}

		}

        // Animations
    
		$this->add_render_attribute( 'title_attribute', 'class', 'designer-promo-box-title' );
		if ( 'none' !== $settings['title_animation'] ) {
			$anim_transparency = 'yes' === $settings['__animation_tr'] ? ' designer-anim-transparency' : '';
			$this->add_render_attribute( 'title_attribute', 'class', 'designer-anim-transparency designer-anim-size-medium designer-element-'. $settings['title_animation'] .' designer-anim-timing-'. $settings['title_animation_timing'] .' designer-anim-size-'. $settings['title_animation_size']. $anim_transparency );	
		}

		$this->add_render_attribute( 'description_attribute', 'class', 'designer-promo-box-description' );
		if ( 'none' !== $settings['description_animation'] ) {
			$anim_transparency = 'yes' === $settings['__animation_tr'] ? ' designer-anim-transparency' : '';
			$this->add_render_attribute( 'description_attribute', 'class', 'designer-anim-transparency designer-anim-size-medium designer-element-'. $settings['description_animation'] .' designer-anim-timing-'. $settings['description_animation_timing'] .' designer-anim-size-'. $settings['description_animation_size']. $anim_transparency );	
		}

		$this->add_render_attribute( 'btn_attribute', 'class', 'designer-promo-box-btn-wrap' );
		if ( 'none' !== $settings['btn_animation'] ) {
			$anim_transparency = 'yes' === $settings['__animation_tr'] ? ' designer-anim-transparency' : '';
			$this->add_render_attribute( 'btn_attribute', 'class', 'designer-anim-transparency designer-anim-size-medium designer-element-'. $settings['btn_animation'] .' designer-anim-timing-'. $settings['btn_animation_timing'] .' designer-anim-size-'. $settings['btn_animation_size']. $anim_transparency );	
		}

		$this->add_render_attribute( 'icon_attribute', 'class', 'designer-promo-box-icon' );
		if ( 'none' !== $settings['icon_animation'] ) {
			$anim_transparency = 'yes' === $settings['__animation_tr'] ? ' designer-anim-transparency' : '';
			$this->add_render_attribute( 'icon_attribute', 'class', 'designer-anim-transparency designer-anim-size-medium designer-element-'. $settings['icon_animation'] .' designer-anim-timing-'. $settings['icon_animation_timing'] .' designer-anim-size-'. $settings['icon_animation_size']. $anim_transparency );	
		}

        ?>

        <div class="designer-promo-box designer-animation-wrap <?php echo esc_attr( $reveal_content); ?>">
			<?php if ( 'box' === $settings['content_link_type'] ): ?>
				<a class="designer-promo-box-link" <?php echo $this->get_render_attribute_string( 'link_attribute' ); ?>></a>	
			<?php endif; ?>

			<?php if ( $image_src ) : ?>
				<div class="designer-promo-box-image">
					<div class="designer-promo-box-bg-image designer-bg-anim-<?php echo esc_attr($settings['image_animation']); ?> designer-anim-timing-<?php echo esc_attr( $settings['image_animation_timing'] ); ?>" style="background-image:url(<?php echo esc_url( $image_src ); ?>);"></div>
					<div class="designer-promo-box-bg-overlay designer-border-anim-<?php echo esc_attr($settings['border_animation']); ?>"></div>
				</div>
			<?php endif; ?>

			<div class="designer-promo-box-content">

				<?php if ( 'none' !== $settings['content_icon_type'] ) : ?>
				<div <?php echo $this->get_render_attribute_string('icon_attribute'); ?>>
					<?php if ( 'icon' === $settings['content_icon_type'] && '' !== $settings['content_icon']['value'] ) : ?>
						<?php Icons_Manager::render_icon( $settings['content_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<?php elseif ( 'image' === $settings['content_icon_type'] && $content_image_src ) : ?>
						<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'content_image_size', 'content_image' ); ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php

				if ( '' !== $settings['content_title'] ) {

					echo '<'. esc_attr($settings['content_title_tag']) .' '. $this->get_render_attribute_string( 'title_attribute' ) .'>';
					if ( 'title' === $settings['content_link_type'] ) {
						echo '<a '. $this->get_render_attribute_string( 'link_attribute' ).'>';
					}

					echo '<span>'. wp_kses_post($settings['content_title']) .'</span>';
				
					if ( 'title' === $settings['content_link_type'] ) {
						echo '</a>';
					}

					echo '</'. esc_attr($settings['content_title_tag']) .'>';
				}

				?>

				<?php if ( '' !== $settings['content_description'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'description_attribute' ); ?>>
						<?php echo '<p>'. wp_kses_post($settings['content_description']) .'</p>'; ?>	
					</div>						
				<?php endif; ?>

				<?php if ( 'btn' === $settings['content_link_type'] || 'box' === $settings['content_link_type'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'btn_attribute' ); ?>>
						<div class="block-action__advanced">
							<a <?php echo $this->get_render_attribute_string('button_attribute');?> <?php echo $this->get_render_attribute_string('link_attribute');?> >
								<?php if( $settings['button_label'] != '' ): ?>
									<span class="label">
										<?php echo esc_html( $settings['button_label'] ) ?>
									</span>
								<?php endif; ?>
								<?php if( 'yes'	===	$settings['show_icon_sidebar']):?>
									<span class="designer-m-border"></span>
								<?php endif; ?>
								<?php if ( $settings['button_icon_enable'] == 'yes' ): ?>
									<span class="designer-m-icon" <?php echo esc_attr($icon_box_style);?> >
										<span class="designer-m-icon-inner">
											<?php 
												\Elementor\Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] ); 
												if($settings['button_icon_move'] !== 'move-horizontal-short' && $settings['button_icon_move'] !== ''){
													\Elementor\Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] ); 
												}
											?>
										</span>
									</span>
								<?php endif; ?>

								<?php if( $settings['button_type'] === 'inner-border'):?>
									<?php echo Helper::instance()->render_button_inner_border($settings);?>
								<?php endif;?>
							</a>
						</div>
    				</div>	

				<?php endif;?>

				
			</div>
        </div>
        <!-- Badge -->
        <?php if ( $settings['badge_style'] !== 'none' && ! empty( $settings['badge_title'] ) ) :
            $this->add_render_attribute( 'designer-promo-box-badge-attr', 'class', 'designer-promo-box-badge designer-promo-box-badge-'. esc_attr($settings[ 'badge_style']) );
            if ( ! empty( $settings['badge_hr_position'] ) ) :
                $this->add_render_attribute( 'designer-promo-box-badge-attr', 'class', 'designer-promo-box-badge-'. esc_attr($settings['badge_hr_position']) );
            endif;
            ?>
            <div <?php echo $this->get_render_attribute_string( 'designer-promo-box-badge-attr' ); ?>>	
                <div class="designer-promo-box-badge-inner"><?php echo esc_html($settings['badge_title']); ?></div>	
            </div>

        <?php endif; ?>




        <?php
    }


}