<?php
namespace Designer\Widgets\Tabs_Vertical;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Tabs_Vertical extends Widget_Base {
    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        wp_register_style( 'tabs-vertical', \Designer::plugin_url().'widgets/tabs-vertical/assets/tabs-vertical.css', array(), '1.0.0', 'all' );
        wp_register_script( 'tabs-vertical', \Designer::plugin_url().'widgets/tabs-vertical/assets/tabs-vertical.js', array('jquery'), '1.0.0', true );
    }

    public function get_name() {
		return 'designer-tabs-vertical';
	}

    public function get_title() {
		return esc_html__( 'Vertical Tabs', 'designer' );
	}

    public function get_icon() {
		return 'designer-icon eicon-tabs';
	}

	public function get_categories() {
		return [ 'designer'];
	}

    public function get_keywords() {
		return [ 'tabs', 'vertical tabs' ];
	}

    public function get_style_depends() {
		return ['tabs-vertical'];
	}

    public function get_script_depends() {
		return ['jquery-ui-tabs', 'tabs-vertical'];
	}

    protected function register_controls() {
        $this->start_controls_section(
			'_section_tabs',
			[
				'label' => esc_html__( 'Tabs', 'designer' ),
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__( 'Label', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Tab 1',
			]
		);

        $repeater->add_control(
            'tab_content_type',
            [
                'label' => esc_html__( 'Content Type', 'designer' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'editor',
                'options' => [
                    'editor' => esc_html__( 'Editor', 'designer' ),
                    'template' => esc_html__( 'Elementor Template', 'designer' ),
                ],
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
			'tab_content',
			[
				'label' => esc_html__( 'Content', 'designer' ),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Tab Content', 'designer' ),
				'default' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima incidunt voluptates nemo, dolor optio quia architecto quis delectus perspiciatis. Nobis atque id hic neque possimus voluptatum voluptatibus tenetur, perspiciatis consequuntur.',
				'condition' => [
					'tab_content_type' => 'editor',
				],
			]
		);

        $repeater->add_control(
			'select_template' ,
			[
				'label'	=> esc_html__( 'Select Template', 'designer' ),
				'type' => 'designer-ajax-select2',
				'options' => 'ajaxselect2/get_elementor_templates',
				'label_block' => true,
				'condition' => [
					'tab_content_type' => 'template',
				],
			]
		);

        $this->add_control(
			'tabs',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => 'Tab 1',
					],
					[
						'tab_title' => 'Tab 2',
					],
					[
						'tab_title' => 'Tab 3',
					]
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

        $this->add_control(
			'content_media_responsive',
			[
				'label' => esc_html__( 'Place Content below tab on screen under', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '680',
				'options' => [
					'480' => esc_html__( '480px', 'designer' ),
					'680'  => esc_html__( '680px', 'designer' ),
					'768' => esc_html__( '768px', 'designer' ),
					'1024' => esc_html__( '1024px', 'designer' ),
				],
			]
		);

        $this->end_controls_section();

         // Styles
         $this->add_title_style();
         $this->add_text_style();
         $this->add_spacing_style();
    }


    protected function add_title_style() {
        $this->start_controls_section(
			'section_title_style_tabs',
			[
				'label' => esc_html__( 'Title Style', 'designer' ),
                'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'title_alignment',
			[
				'label' => esc_html__( 'Alignment', 'designer' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation .designer-tab-title a' => 'text-align: {{VALUE}};',
				],
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
				'default' => 'h5',
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation .designer-tab-title a',
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

            $this->start_controls_tab(
                'style_normal_tab',
                [
                    'label' => esc_html__( 'Normal', 'designer' ),
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Color', 'designer' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation .designer-tab-title a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'title_background_color',
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation .designer-tab-title a',
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'style_hover_tab',
                [
                    'label' => esc_html__( 'Active/Hover', 'designer' ),
                ]
            );

            $this->add_control(
                'title_hover_color',
                [
                    'label' => esc_html__( 'Title Active/Hover Color', 'designer' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li.ui-state-hover a' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li.ui-state-active a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'title_hover_background',
                    'types' => [ 'classic', 'gradient' ],
                    'title'      => esc_html__( 'Title Active/Hover Background', 'designer' ),
                    'selector' => '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li a:before',
                ]
            );

            $this->add_responsive_control(
                'title_sideline_width',
                [
                    'type' => Controls_Manager::SLIDER,
                    'label' => esc_html__( 'Title Active/Hover Sideline Width', 'designer' ),
                    'size_units' => [ 'px', '%', 'em' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 50,
                        ],
                        '%' => [
                            'min' => 1,
                            'max' => 100,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li a:after' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'title_sideline_bottom',
                [
                    'type' => Controls_Manager::SLIDER,
                    'label' => esc_html__( 'Title Active/Hover Sideline Offset', 'designer' ),
                    'size_units' => [ 'px', '%', 'em' ],
                    'range' => [
                        'px' => [
                            'min' => -10,
                            'max' => 10,
                        ],
                        '%'  => [
							'min' => - 100,
							'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li a:after' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'title_sideline_color',
                [
                    'label' => esc_html__( 'Title Active/Hover Sideline Color', 'designer' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li a:after' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'title_sideline_draw',
                [
                    'label' => esc_html__( 'Title Active/Hover Sideline Draw', 'designer' ),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => false,
                    'default' => 'top',
                    'options' => [
                        'top' => esc_html__( 'From Top', 'designer' ),
                        'center' =>esc_html__( 'From Center', 'designer' ),
                        '' =>esc_html__( 'None', 'designer' )

                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'divider_style_title_text',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'selector' => '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li a',
			]
		);



        $this->end_controls_section();
    }

    protected function add_text_style() {
        $this->start_controls_section(
			'section_text_style_tabs',
			[
				'label' => esc_html__( 'Text Style', 'designer' ),
                'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-content .d-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-content .d-content',
            ]
        );

        $this->add_control(
            'text_background_color',
            [
                'label' => esc_html__( 'Text Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-content .d-content' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'text_border',
				'selector' => '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-content .d-content',
                'selector' => '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-content',
			]
		);


        $this->end_controls_section();
    }

    protected function add_spacing_style() {
        $this->start_controls_section(
			'section_spacing_style_tabs',
			[
				'label' => esc_html__( 'Spacing Style', 'designer' ),
                'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Title Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Content Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-content .d-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


        $this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Title Margin', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'title_width',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__( 'Title Width', 'designer' ),
                'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .designer-tabs-vertical .designer-tabs-vertical-navigation li a' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    private function get_holder_classes( $settings ) {
        $holder_classes = array();
        $holder_classes[] = 'designer-tabs-vertical';
        $holder_classes[] = ! empty( $settings['content_media_responsive'] ) ? 'designer-responsive--' . $settings['content_media_responsive'] : '';
        $holder_classes[] = ! empty( $settings['title_sideline_draw'] ) ? 'designer-title-hover--sideline-draw designer-title-sideline-from-' . $settings['title_sideline_draw'] : '';

        return implode( ' ', $holder_classes );
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $tab_title_tag = $settings['title_tag'];
        ?>

        <div class="<?php echo $this->get_holder_classes($settings);?>">
            <ul class = "designer-tabs-vertical-navigation">
                <?php foreach( $settings['tabs'] as $tab ) : ?>
                    <li>
                        <<?php echo esc_attr( $tab_title_tag ); ?> class = "designer-tab-title">
                            <a href="#designer-tab-<?php echo esc_attr( $tab['_id'] ); ?>">
                                <span class="d-text">
                                    <?php echo esc_html( $tab['tab_title'] ); ?>
                                </span>
                            </a>
                        </<?php echo esc_attr( $tab_title_tag ); ?>>

                    </li>
                <?php endforeach;?>
            </ul>
            <?php foreach( $settings['tabs'] as $tab ) : ?>
                <div class="designer-tabs-vertical-content" id="designer-tab-<?php echo esc_attr( $tab['_id'] ); ?>">
                    <?php
                        switch ($tab['tab_content_type']) {
                            case 'editor':
                                echo '<p class="d-content">'.wp_kses_post( $tab['tab_content'] ).'</p>';
                                break;

                            case 'template':
                                if (!empty($tab['select_template'])) {
                                    $edit_link = '<span class="designer-template-edit-btn" data-permalink="'. esc_url(get_permalink($tab['select_template'])) .'">Edit Template</span>';
                                
                                    $has_css = 'internal' === get_option( 'elementor_css_print_method' );
                        
                                    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $tab['select_template'], $has_css ) . $edit_link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                }
                                break;
                            default:
                                echo '<span class="d-content">'.wp_kses_post( $tab['tab_content'] ).'</span>';
                            break;

                        }


                    ?>

                </div>
            <?php endforeach;?>

        </div>



        <?php



    }

}

