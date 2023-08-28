<?php

namespace Designer\Widgets\Posts_Cards;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Designer\Includes\Helper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Posts_Cards extends Widget_Base{

	public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
		wp_register_style( 'posts-card', \Designer::plugin_url().'widgets/posts-cards/assets/css/posts-card.css', array(), '1.0.0', 'all' );

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
		return 'posts-cards';
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
		return esc_html__( 'Advanced Posts', 'designer' );
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
		return 'eicon-archive-posts';
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
        return [ 'posts-card' ];
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
                'label' => esc_html__('Layout', 'designer'),
            ]
        );

		$this->add_control(
            'layout',
            [
                'label' => esc_html__('Select Layout', 'designer'),
                'type' => 'image-select',
                'default' => 'layout-1',
				'layout' => 'one-half',
                'options' => [
                    'layout-1' => [
                        'title' => esc_html__('Layout 1', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block1.png',
                        'width' => '50%',
                    ],
                    'layout-2' => [
                        'title' => esc_html__('Layout 2', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block2.png',
                        'width' => '50%',
                    ],
                    'layout-3' => [
                        'title' => esc_html__('Layout 3', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block3.png',
                        'width' => '50%',
                    ],
					'layout-4' => [
                        'title' => esc_html__('Layout 4', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block4.png',
                        'width' => '50%',
                    ],
					'layout-5' => [
                        'title' => esc_html__('Layout 5', 'designer'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block5.png',
                        'width' => '50%',
                    ]
                ],
				'separator' => 'after'
            ]
        );

		$this->add_control(
			'query_heading',
			[
				'label' => esc_html__( 'Post Queries', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING
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
				'separator' => 'before',
                'default'   => 'center'
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
		$this->__style_controls();
		$this->__primary_style_controls();
		$this->__general_style_controls();
    }

	protected function __style_controls() {

        $this->start_controls_section(
            '_style_settings',
            [
                'label' => esc_html__('Layout', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'posts_default_typo',
                'selector' => '{{WRAPPER}} .block--posts-grid .content'
            ]
		);

		$this->add_control(
            'background',
            [
                'label' => __( 'Background', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .content' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
				'selectors' => [
					'{{WRAPPER}} .block--posts-grid article .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'designer' ),
				'selector' => '{{WRAPPER}} .block--posts-grid article .content',
			]
		);

        $this->add_responsive_control(
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
					'{{WRAPPER}} .block--posts-grid article .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .block--posts-grid article .content',
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

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
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

        $this->end_controls_section();
    }

	protected function __primary_style_controls() {

        $this->start_controls_section(
            '_section_style_featured',
            [
                'label' => __( 'Primary', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'layout!' => array('layout-0', 'layout-4'),
                ],
            ]
        );

		$this->add_control(
			'featured_style',
			[
				'label' => esc_html__( 'Layout', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'thumb-background',
				'options' => [
					'default'  	 		=> esc_html__( 'Layout 1', 'designer' ),
					'thumb-left' 		=> esc_html__( 'Layout 2', 'designer' ),
					'thumb-right' 		=> esc_html__( 'Layout 3', 'designer' ),
					'thumb-background'  => esc_html__( 'Layout 4', 'designer' ),
				],
			]
		);

		$this->add_control(
			'featured_image',
			[
				'label' => esc_html__( 'Show featured image', 'designer' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' 	=> esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--posts-items .alpha-block .entry-title a' => 'color: {{VALUE}}',
                ],
				'separator' => 'before',
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .block--posts-items .alpha-block .entry-title'
            ]
        );

		$this->add_control(
            'meta_color',
            [
                'label' => __( 'Meta Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-items .alpha-block .meta-data' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-items .alpha-block .meta-data span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-items .alpha-block .meta-data a' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typo',
                'selector' => '{{WRAPPER}} .block--posts-items .alpha-block .meta-data'
            ]
        );

        $this->end_controls_section();
    }

	protected function __general_style_controls() {

        $this->start_controls_section(
            '_section_style_default',
            [
                'label' => __( 'General', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'featured_image_default',
			[
				'label' => esc_html__( 'Show featured image', 'designer' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_style_heading',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'title_color_default',
            [
                'label' => __( 'Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .entry-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_default_typo',
                'selector' => '{{WRAPPER}} .block--posts-grid .entry-title'
            ]
        );

		$this->add_control(
			'meta_style_heading',
			[
				'label' => esc_html__( 'Meta', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'meta_color_default',
            [
                'label' => __( 'Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' 	=> '#020101',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-grid .meta-data' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-grid .meta-data a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-grid .meta-data span' => 'color: {{VALUE}}',
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

		$this->add_control(
			'category_style_heading',
			[
				'label' => esc_html__( 'Category', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
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

		require \Designer::plugin_dir().'widgets/posts-cards/snippets/'.$settings['layout'].'.php';

    }
}
