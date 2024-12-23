<?php

namespace Designer\Widgets\Dual_Header;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Dual_Header extends Widget_Base {

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        wp_register_style( 'dual-header', \Designer::plugin_url() . 'widgets/dual-header/assets/dual-header.css', array(), '1.0.0', 'all' );

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
		return 'dual-header';
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
		return esc_html__( 'Dual Header', 'designer' );
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
		return 'designer-icon eicon-t-letter';
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
		return [ 'dual heading', 'heading' ];
	}

	public function get_style_depends() {
		return [ 'dual-header' ];
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
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .block--dual-header' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
				'description' => __( 'Add your title here. You can highlight a word using asterisks (eg: Center aligned *section* title)', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div'
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'enable_highlighted_shape',
			[
				'label' => esc_html__( 'Enable Highlighted Shape', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'yes' => esc_html__( 'Yes', 'designer' ),
					'no' => esc_html__( 'No', 'designer' ),
				],
			]
		);

		$this->add_control(
			'highlighted_shape',
			[
				'label' => esc_html__( 'Shape', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle' => esc_html__( 'Circle', 'designer' ),
					'underline-zigzag' => esc_html__( 'Underline Zigzag', 'designer' ),
					'curly' => esc_html__( 'Curly', 'designer' ),
					'x' => esc_html__( 'Cross X', 'designer' ),
					'strikethrough' => esc_html__( 'Linethrough', 'designer' ),
					'underline' => esc_html__( 'Underline', 'designer' ),
					'double' => esc_html__( 'Double', 'designer' ),
					'double-underline' => esc_html__( 'Double Underline', 'designer' ),
					'diagonal' => esc_html__( 'Diagonal', 'designer' ),
					'underline-new'	=> esc_html__( 'Underline New', 'designer' ),
				],
				'condition' => [
					'enable_highlighted_shape' => 'yes',
				],
			]
		);

		$this->add_control(
			'highlighted_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'selectors' => [
					'{{WRAPPER}} .designer-highlighted-text svg path' => '-webkit-animation-duration: {{VALUE}}s; animation-duration: {{VALUE}}s;',
				],
				'render_type' => 'template',
				'condition' => [
					'enable_highlighted_shape' => 'yes',
				],
			]
		);

		$this->add_control(
			'anim_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 2,
				'min' => 0,
				'max' => 15,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .designer-highlighted-text svg path' => '-webkit-animation-delay: {{VALUE}}s; animation-delay: {{VALUE}}s;',
					'{{WRAPPER}} .designer-highlighted-text svg.designer-highlight-x path:first-child' => '-webkit-animation-delay: -webkit-calc({{VALUE}}s + 0.3s); animation-delay: calc({{VALUE}}s + 0.3s);',
					'{{WRAPPER}} .designer-highlighted-text svg.designer-highlight-double path:last-child' => '-webkit-animation-delay: -webkit-calc({{VALUE}}s + 0.3s); animation-delay: calc({{VALUE}}s + 0.3s);',
					'{{WRAPPER}} .designer-highlighted-text svg.designer-highlight-double-underline path:last-child' => '-webkit-animation-delay: -webkit-calc({{VALUE}}s + 0.3s); animation-delay: calc({{VALUE}}s + 0.3s);',
				],
				'render_type' => 'template',
				'condition' => [
					'enable_highlighted_shape' => 'yes',
				],
			]
		); 

		$this->add_control(
			'anim_loop',
			[
				'label' => esc_html__( 'Loop', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}} .designer-highlighted-text svg path' => '-webkit-animation-iteration-count: infinite; animation-iteration-count: infinite;',
				],
				'prefix_class' => 'designer-animated-text-infinite-',
				'render_type' => 'template',
				'condition' => [
					'enable_highlighted_shape' => 'yes',
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
        $this->__dual_header_primary_style_controls();
		$this->__dual_header_highlight_style_controls();
		$this->__higlighted_shape_style_controls();
    }

    protected function __dual_header_primary_style_controls() {

        $this->start_controls_section(
            '_section_primary_style_item',
            [
                'label' => __( 'Primary Header', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block--dual-header .title' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'dual_header_typography',
                'selector' => '{{WRAPPER}} .block--dual-header .title',
            ]
        );


        $this->end_controls_section();
    }

	protected function __dual_header_highlight_style_controls() {

		$this->start_controls_section(
            '_section_highlight_style_item',
            [
                'label' => __( 'Highlighted Header', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'title_Highlighted_color',
            [
                'label' => __( 'Highlighted text color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .block--dual-header .title .designer-highlighted-text-inner' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'dual_header_highlight_typography',
                'selector' => '{{WRAPPER}} .block--dual-header .title .designer-highlighted-text-inner',
            ]
        );

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'dual_header_highlight_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}} .block--dual-header .title .designer-highlighted-text',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block--dual-header .title .designer-highlighted-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_padding',
            [
                'label'      => __( 'Padding', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block--dual-header .title .designer-highlighted-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'animation_section_bg',
                'label'    => __( 'Section Background', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .block--dual-header .title .designer-highlighted-text',
            ]
        );

		$this->end_controls_section();
	}

	protected function __higlighted_shape_style_controls() {
		$this->start_controls_section(
            '_section_highlight_shape_style_item',
            [
                'label' => __( 'Highlighted Shape', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_highlighted_shape' => 'yes',
				],
            ]
        );


		$this->add_control(
			'highlight_shape_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-highlighted-text path' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'highlight_shape_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 120,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-highlighted-text svg' => 'width: {{SIZE}}%;',
				],	
			]
		);

		$this->add_responsive_control(
			'highlight_shape_height',
			[
				'label' => esc_html__( 'Height', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 120,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 90,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-highlighted-text svg' => 'height: {{SIZE}}%;',
				],	
			]
		);

		$this->add_responsive_control(
			'highlight_shape_weight',
			[
				'label' => esc_html__( 'Weight', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-highlighted-text path' => 'stroke-width: {{SIZE}}{{UNIT}}',
				],	
			]
		);

		$this->add_control(
			'highlight_shape_position',
			[
				'label' => esc_html__( 'Shape Position', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'over',
				'options' => [
					'under' => esc_html__( 'Under Text', 'designer' ),
					'over' => esc_html__( 'Over Text', 'designer' ),
				],
				'selectors_dictionary' => [
					'under' => '0',
					'over' => '1'
				],
				'selectors' => [
					'{{WRAPPER}} .designer-highlighted-text svg' => 'z-index: {{VALUE}}',
				],
			]
		);





		$this->end_controls_section();
	}

	public function designer_highlighted_text($settings) {
		
		$svg_arr = [
			'circle' 			=> [ 'M284.72,15.61C276.85,14.43,2-2.85,2,80.46c0,34.09,45.22,58.86,196.31,62.81C719.59,154.18,467-74.85,109,29.15' ],
			'curly' 			=> [ 'M1.15,18C64.07,44.13,108.42,1.4,169.63,3.1,182.11,3.76,191.39,6.58,201,10c71.41,33.39,112-8.7,188.65-7,35.22,1.74,69.81,22.6,103,17' ],
			'underline' 		=> [ 'M.68,28.11c110.51-22,247.46-34.55,400.89-14.68,32.94,4.27,64.42,9.74,94.37,16.09' ],
			'double' 			=> [ 'M.58,16s93-15.56,303-12c118,2,180,12,180,12', 'M.58,127s93-13.31,303.15-10.26C421.79,118.48,483.83,127,483.83,127' ],
			'double-underline' 	=> [ 'M.58,16s93-15.56,303-12c118,2,180,12,180,12', 'M29.83,33.28S111.54,17.1,296.13,20.8c103.71,2.08,158.2,12.48,158.2,12.48' ],
			'underline-zigzag' 	=> [ 'M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9' ],
			'diagonal' 			=> [ 'M.25,3.49C114.44,11.6,252,36.14,397.07,97.15c31.14,13.1,60.52,27,88.18,41.34' ],
			'strikethrough' 	=> [ 'M4,74.8h499.3' ],
			'x' 				=> [ 'M1.61,3.49C115.8,11.6,253.39,36.14,398.43,97.15c31.14,13.1,60.53,27,88.18,41.34', 'M486.61,3.49C372.42,11.6,234.84,36.14,89.79,97.15c-31.14,13.1-60.52,27-88.18,41.34' ],
			'underline-new'		=> ['M.58,16s93-15.56,303-12c118,2,180,12,180,12']
		];

		if ( 'yes' === $settings['enable_highlighted_shape'] ) :		
			$svg_shape = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" class="designer-highlight-'.esc_html( $settings['highlighted_shape'] ).'" preserveAspectRatio="none">';
				foreach ( $svg_arr[$settings['highlighted_shape']] as $value ) :
					$svg_shape .= '<path d="'.esc_attr($value).'"></path>';
				endforeach;
				$svg_shape .= '</svg>';
			return $svg_shape;
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

            $this->add_render_attribute(
                'wrapper',
                [
                    'class' => [ 'block--dual-header' ],
                ]
            );
        ?>
            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                <div class="dual--header-inner">
                    <div class="block-dualheader__item">
                        <?php if( $settings['title'] ): ?>
                            <div class="content-item">
                                <?php
									$title = $settings['title'];
									if ( preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $settings['title'] ) ) {
										$title = preg_replace("/\*([^*]+)\*/", "<span class='designer-highlighted-text'><span class='designer-highlighted-text-inner'>$1</span>".$this->designer_highlighted_text($settings)."</span>", $settings['title'] );
									}
									if( $settings['title']):
										printf( '<%1$s class="title h1">%2$s</%1$s>',
											tag_escape( $settings['title_tag'], 'h2' ),
											$title
										);
									endif;
								?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
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
