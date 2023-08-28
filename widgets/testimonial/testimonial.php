<?php

namespace Designer\Widgets\Testimonial;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonial extends Widget_Base {

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
		return 'testimonial';
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
		return esc_html__( 'Testimonial', 'designer' );
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
		return 'eicon-comments';
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
		return [ 'testimonial', 'reviews' ];
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

		$this->add_control(
			'image',
			[
                'label' => __( 'Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
                'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->add_group_control(
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

        $this->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->add_control(
			'content',
			[
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'label' => __( 'Content', 'designer' ),
				'placeholder' => __( 'Type content here', 'designer' ),
			]
		);

        $this->add_control(
			'name',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Name', 'designer' ),
				'placeholder' => __( 'Type name here', 'designer' ),
                'separator' => 'before',
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->add_control(
			'position',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Postion', 'designer' ),
				'placeholder' => __( 'Type position here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label' => esc_html__( 'Show rating?', 'designer' ),
				'type' =>  Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'testimonial_rating_amount',
			[
				'label' => esc_html__( 'Rating', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
				'default' => 4.5,
                'condition' => [
					'show_rating' => 'yes',
				]
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
				'text' => __( '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >Buy Pro</a>', 'designer' ),
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
        $this->__testimonial_style_controls();
    }

    protected function __testimonial_style_controls() {

        $this->start_controls_section(
            '_section_style_item',
            [
                'label' => __( 'Style', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial .title' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .block-testimonial .title',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => __( 'Content Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#111111',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial .content' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .block-testimonial .content',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => __( 'Name Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#111111',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial .author-meta .name' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .block-testimonial author-meta .name',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label' => __( 'Poistion Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial .author-meta .position' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typography',
                'selector' => '{{WRAPPER}} .block-testimonial .author-meta .position',
                'scheme' => Typography::TYPOGRAPHY_1,
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
				'text' => __( '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >Buy Pro</a>', 'designer' ),
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

            $this->add_render_attribute(
                'wrapper',
                [
                    'class' => [ 'block-testimonial' ],
                ]
            );
        ?>
            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                <div class="block-testimonial__inner">
                    <div class="block-testimonial__item">
                        <?php
                            $this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
                            $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image'] ) );
                            $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $settings['image'] ) );
                            $this->add_render_attribute( 'image', 'class', 'image' );
                        ?>

                        <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>
                        <?php if( $settings['title'] || $settings['content'] ): ?>
                            <div class="content-item">
								<?php
									if ( $settings['show_rating'] ):
										$rating_amount = $settings['testimonial_rating_amount'];
										$round_rating = (int)$rating_amount;
										$rating_icon = '&#xE934;'; ?>
										<div class="testimonial-rating">
											<?php for( $i = 1; $i <= 5; $i++ ) : ?>
												<?php if ( $i <= $rating_amount ) : ?>
													<i class="rating-icon-full"><?php echo esc_html($rating_icon); ?></i>
												<?php elseif ( $i === $round_rating + 1 && $rating_amount !== $round_rating ) : ?>
													<i class="rating-icon-<?php echo esc_attr(( $rating_amount - $round_rating ) * 10); ?>">
														<?php echo esc_html($rating_icon); ?>
													</i>
												<?php else : ?>
													<i class="rating-icon-empty"><?php echo esc_html($rating_icon); ?></i>
												<?php endif; ?>
											<?php endfor; ?>
										</div>
										<?php
									endif;
								?>
                                <?php if( $settings['title']): ?>
                                    <h4 class="title h5"><?php echo wp_kses_post( $settings['title'] ); ?></h4>
                                <?php endif; ?>
                                <?php if( $settings['content']): ?>
                                    <p class="content"><?php echo wp_kses_post( $settings['content'] ); ?></p>
                                <?php endif; ?>

                                <?php if( $settings['name']): ?>
                                    <div class="author-meta">
                                        <p class="name h6"><?php echo wp_kses_post( $settings['name'] ); ?></p>
                                        <small class="position"><?php echo wp_kses_post( $settings['position'] ); ?></small>
                                    </div>
                                <?php endif; ?>

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
