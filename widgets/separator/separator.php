<?php

namespace Designer\Widgets\Separator;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Separator extends Widget_Base {

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
		return 'designer-separator';
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
		return esc_html__( 'Divider', 'designer' );
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
		return 'designer-icon eicon-divider';
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
			'Divider',
            'Separator',
            'Designer',
		];
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
                'label' => esc_html__('General', 'designer'),
            ]
        );

        
		$this->add_control(
			'separator_layout',
			[
				'label'   => __( 'Layout', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'options' => [
					'border-image'	=> __( 'Border Image', 'designer' ),
					'standard'		=> __( 'Standard', 'designer' ),
                    'with-icon'		=> __( 'With Icon', 'designer' ),
                ],

			]
        );

		$this->add_control(
			'position',
			[
				'label'   => __( 'Position', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'designer' ),
					'center'	=> __( 'Center', 'designer' ),
					'left'		=> __( 'Left', 'designer' ),
                    'right'		=> __( 'Right', 'designer' ),
                ],

			]
        );

        $this->end_controls_section();

		$this->__separator_border_image_control();
		$this->__separator_border_icon_control();

		// Styles Control
		$this->__separator_style_controls();
		$this->__separator_icon_style_controls();

    }



	protected function __separator_border_image_control() {

		$this->start_controls_section(
            '_separator_border_image_settings',
            [
                'label' => esc_html__('Separator Border Image', 'designer'),
            ]
        );

		$this->add_control(
			'separator_border_image',
			[
				'label' => esc_html__( 'Border Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'separator_layout' => 'border-image',
				],
			]
		);

		$this->add_control(
			'separator_border_image_size',
			[
				'label'   => __( 'Border Image Size', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => [
					'auto'	=> __( 'Auto', 'designer' ),
					'cover'		=> __( 'Cover', 'designer' ),
                    'contain'		=> __( 'Contain', 'designer' ),
                ],
				'selectors'	=> [
					'{{WRAPPER}} .designer-line' => 'background-size: {{VALUE}};',
				],
				'condition' => [
					'separator_layout' => 'border-image',
				],

			]
        );

		$this->add_control(
			'separator_border_image_position',
			[
				'label'   => __( 'Border Image Position', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'	=> __( 'Left', 'designer' ),
					'center'		=> __( 'Center', 'designer' ),
                    'right'		=> __( 'Right', 'designer' ),
                ],
				'selectors'	=> [
					'{{WRAPPER}} .designer-line' => 'background-position: top {{VALUE}};',
				],
				'condition' => [
					'separator_layout' => 'border-image',
					'separator_border_image_size'	=> ['auto', 'contain'],
				],

			]
        );

		$this->add_control(
			'separator_border_image_select',
			[
				'label'   => __( 'Border Image Repeat', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'round',
				'options' => [
					'round'	=> __( 'Round', 'designer' ),
					'repeat'		=> __( 'Repeat', 'designer' ),
                    'space'		=> __( 'Space', 'designer' ),
					'no-repeat'		=> __( 'None', 'designer' ),
                ],
				'selectors'	=> [
					'{{WRAPPER}} .designer-line' => 'background-repeat: {{VALUE}};',
				],
				'condition' => [
					'separator_layout' => 'border-image',
				],

			]
        );


		$this->end_controls_section();
	}

	protected function __separator_border_icon_control() {

		$this->start_controls_section(
            '_separator_border_icon_settings',
            [
                'label' => esc_html__('Separator Icon', 'designer'),
            ]
        );

		$this->add_control(
			'separator_icon',
			[
				'label' => __( 'Separator Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-paper-plane',
					'library' => 'fa-solid',
				],
				'condition' => [
					'separator_layout' => 'with-icon',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function __separator_style_controls() {
		$this->start_controls_section(
			'_section_separator_style',
			[
				'label' => esc_html__( 'Separator Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]

		);

		$this->add_control(
			'separator_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-line' => 'color: {{VALUE}}',
				],
				'condition'	=> [
					'separator_layout!' => 'border-image'
				],
			]
		);

		$this->add_control(
			'separator_border_style',
			[
				'label'   => __( 'Border Style', 'designer' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''	=> 	esc_html__( 'Default', 'designer' ),
					'solid'  => esc_html__( 'Solid', 'designer' ),
					'dashed' => esc_html__( 'Dashed', 'designer' ),
					'dotted' => esc_html__( 'Dotted', 'designer' ),
                ],
				'selectors' => [
					'{{WRAPPER}} .designer-line' => 'border-style: {{VALUE}}',
				],
                'condition'	=> [
					'separator_layout!' => 'border-image',
				],

			]
        );

		$this->add_responsive_control(
			'separator_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'vw'],
				'range'      => [ 
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .designer-line' => 'width: {{SIZE}}{{UNIT}};',
				],	
			]
		);

		$this->add_responsive_control(
			'separator_thickness',
			[
				'label' => esc_html__( 'Thickness', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .designer-line' => 'font-size: {{SIZE}}{{UNIT}};',
				],	
			]
		);

		$this->add_responsive_control(
			'separator_margin_top',
			[
				'label' => esc_html__( 'Margin Top', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'vh'],
				'range'      => [ 
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .designer-line' => 'margin-top: {{SIZE}}{{UNIT}};',
				],	
			]
		);

		$this->add_responsive_control(
			'separator_margin_bottom',
			[
				'label' => esc_html__( 'Margin Bottom', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'vh'],
				'range'      => [ 
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .designer-line' => 'margin-top: {{SIZE}}{{UNIT}};',
				],	
			]
		);



		$this->end_controls_section();
	}

	protected function __separator_icon_style_controls() {

		$this->start_controls_section(
			'_section_separator_icon_style',
			[
				'label' => esc_html__( 'Separator Icon Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]

		);

		$this->add_control(
			'separator_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-separator-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'separator_layout' => 'with-icon',
				],
			]
		);

		$this->add_responsive_control(
			'separator_icon_font_size',
			[
				'label' => esc_html__( 'Icon Font Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .designer-separator-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'separator_layout' => 'with-icon',
				],	
			]
		);

		$this->add_responsive_control(
			'separator_icon_margin',
			[
				'label' => esc_html__( 'Icon Margin', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .designer-separator-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'separator_layout' => 'with-icon',
				],	
			]
		);


		$this->end_controls_section();
	}

	private function get_separator_classes( $settings ) {
	
		$holder_classes[] = 'designer-separator';
		$holder_classes[] = ! empty( $settings['separator_layout'] ) ? 'designer-separator--' . $settings['separator_layout'] : '';
		$holder_classes[] = ! empty( $settings['position'] ) ? 'designer-position--' . $settings['position'] : '';

		return implode( ' ', $holder_classes );
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

		// Get Settings
		$settings = $this->get_settings();
		
		?>
		
        <div class="<?php echo $this->get_separator_classes($settings);?>">

            <?php if( 'standard' === $settings['separator_layout']):?>
                <div class="designer-line"></div>
            <?php endif;?>

            <?php if( 'border-image' === $settings['separator_layout']):
                $border_image_src = $settings['separator_border_image']['url'];   
            ?>
                <div class="designer-line" <?php if( $border_image_src ) { echo 'style="background-image:url('.$border_image_src.')"'; } ?> ></div>
            <?php endif;?>

            <?php if( 'with-icon' === $settings['separator_layout']):?>
                <div class="designer-line">
                    <div class="designer-inner-line"></div>
                    <?php if ( isset( $settings['separator_icon'] ) && ! empty( $settings['separator_icon']['value'] ) ) : ?>
                        <div class="designer-separator-icon">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['separator_icon'], [ 'aria-hidden' => 'true' ] );  ?>
                        </div>
                    <?php endif;?>
                        
                    <div class="designer-inner-line"></div>
                </div>
            <?php endif;?>
            
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