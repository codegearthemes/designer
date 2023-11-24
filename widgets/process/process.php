<?php
namespace Designer\Widgets\Process;

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Process extends Widget_Base {

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        wp_register_style( 'process', \Designer::plugin_url() . 'widgets/process/assets/process.css', array(), '1.0.0', 'all' );

        wp_register_script( 'process', \Designer::plugin_url() . 'widgets/process/assets/process.js', array('jquery'), '1.0.0', true );
    

    }

    public function get_name() {
		return 'process';
	}

    public function get_title() {
		return esc_html__( 'Process', 'designer' );
	}

    public function get_icon() {
		return 'designer-icon eicon-time-line';
	}

	public function get_categories() {
		return [ 'designer'];
	}

    public function get_keywords() {
		return [ 'process', 'designer' ];
	}

    public function get_style_depends() {
		return [ 'process' ];
	}

    public function get_script_depends() {
        return [ 'process' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
			'__general_section',
			[
				'label' => esc_html__( 'General', 'designer' ),
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
			'icon_type',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'default' => [],
				'recommended' => [
					'fa-solid' => [
						'hand-peace',
						'chart-bar',
						'smile',
					],
					'fa-regular' => [
						'hand-peace',
						'chart-bar',
						'smile',
					],
				],
			]
		);

        $repeater->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
                'default'   => __('Item Title 1', 'designer'),
				'label' => __( 'Title', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
			]
		);

        $repeater->add_control(
			'content',
			[
				'label' => esc_html__( 'Text', 'designer' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempus nisl vitae magna pulvinar laoreet.', 'designer' ),
				'placeholder' => esc_html__( 'Type your description here', 'designer' ),
			]
		);

        $repeater->add_control(
            'content_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $repeater->add_responsive_control(
            'item_margin-top',
            [
                'label'      => esc_html__( 'Item Offset', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .designer-process.designer-item-layout--horizontal {{CURRENT_ITEM}}.designer-process-item' => 'margin-top: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $repeater->add_responsive_control(
            'item_icon_holder_size',
            [
                'label'      => esc_html__( 'Item Holder Size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'], 
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .designer-process-icon'   => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_icon_typography',
                'label'      => esc_html__( 'Item Typography', 'designer' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .designer-process-icon > .designer-item-icon-text',
			]
		);

        $repeater->add_control(
			'item_icon_color',
			[
				'label' => esc_html__( 'Item Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-process-icon ' => 'color: {{VALUE}};',
				],
			]
		);

        $repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_icon_holder_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .designer-process-icon ',
			]
		);

        $repeater->add_responsive_control(
			'item_icon_holder_radius',
			[
				'label' => esc_html__( 'Item Holder Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-process-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_icon_border',
                'label' => esc_html__( 'Item Border', 'designer' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .designer-process-icon',
			]
		);

        $repeater->add_control(
            'border_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $repeater->add_responsive_control(
            'item_line_top_offset',
            [
                'label'      => esc_html__( 'Line Top Offset', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .designer-process-line'   => 'top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .designer-process.designer-item-layout--horizontal {{CURRENT_ITEM}} .designer-process-line' => 'top: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $repeater->add_control(
            'line_transform_rotate',
            [
                'label'      => esc_html__( 'Line Rotation', 'designer' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 360,
				'step' => 1,
				'default' => 0,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .designer-process-line' => 'transform:rotate({{VALUE}}deg);',
                ]
            ]
        );

        $this->add_control(
            'process_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title'    => esc_html__( 'Item Title 1', 'designer' ),
                    ],
                    [
                       
                        'title'    => esc_html__( 'Item Title 2', 'designer' ),
                    ],
                    [
                       
                        'title'    => esc_html__( 'Item Title 3', 'designer' ),
                    ],
                    
                ],
                'title_field' => '{{{ title }}}',
            ]
           

        );

        $this->end_controls_section();

          // Animation
        $this->start_controls_section(
            '__animation_section',
            [
                'label' => esc_html__( 'Appear Animation', 'designer' ),
            ]
        );
    
        $this->add_control(
            'appear_animation',
            [
                'label' => esc_html__( 'Enable Appear Animation', 'designer' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'designer' ),
                    'no' => esc_html__( 'No', 'designer' ),
                ],
            ]
        );
    
        $this->end_controls_section();

          // layout
          $this->start_controls_section(
            '__process_layout_section',
            [
                'label' => esc_html__( 'Layout', 'designer' ),
            ]
        );
    
        $this->add_control(
            'process_layout',
            [
                'label' => esc_html__( 'Layout', 'designer' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__( 'Horizontal', 'designer' ),
                    'vertical' => esc_html__( 'Vertical', 'designer' ),
                ],
            ]
        );
    
        $this->end_controls_section();
        $this->register_style_controls();
    }

    protected function register_style_controls() {
		$this->__general_style_controls();
        $this->__content_style_controls();
        $this->__line_style_controls();
        $this->__spacing_style_controls();
        $this->__additional_style_controls();
    }

    protected function __general_style_controls() {
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'alignment',
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
					'{{WRAPPER}} .designer-process-content' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'alignment_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_responsive_control(
            'global_item_margin-top',
            [
                'label'      => esc_html__( 'Item Offset', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .designer-process.designer-item-layout--horizontal .designer-process-item' => 'margin-top: {{SIZE}}{{UNIT}};',
                ] 
            ]
        );

        $this->add_responsive_control(
            'global_item_icon_holder_size',
            [
                'label'      => esc_html__( 'Item Holder Size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .designer-process-icon'   => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ] 
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'global_item_icon_typography',
                'label'      => esc_html__( 'Item Typography', 'designer' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-process-icon > .designer-item-icon-text',
			]
		);

        $this->add_control(
			'global_item_icon_color',
			[
				'label' => esc_html__( 'Item Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-process-icon ' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'global_item_icon_holder_background',
                'label' => esc_html__('Item Holder Background', 'designer'),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .designer-process-icon ',
			]
		);

        $this->add_responsive_control(
			'global_item_icon_holder_radius',
			[
				'label' => esc_html__( 'Item Holder Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .designer-process-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'global_item_icon_border',
                'label' => esc_html__( 'Item Border', 'designer' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .designer-process-icon',
			]
		);




        $this->end_controls_section();
    }

    protected function __content_style_controls() {
        $this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
			'item_title_color',
			[
				'label' => esc_html__( 'Title Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-process .designer-process-title ' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_title_typography',
                'label'      => esc_html__( 'Title Typography', 'designer' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-process .designer-process-title',
			]
		);

        $this->add_control(
            'title_style_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_control(
			'item_text_color',
			[
				'label' => esc_html__( 'Text Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-process .designer-process-text' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_text_typography',
                'label'      => esc_html__( 'Text Typography', 'designer' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-process .designer-process-text',
			]
		);


        $this->end_controls_section();
    }

    protected function __line_style_controls() {
        $this->start_controls_section(
			'section_line_style',
			[
				'label' => __( 'Line Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'line_border_style',
			[
				'label' => esc_html__( 'Line Border Style', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid' => esc_html__( 'Solid', 'designer' ),
					'dashed' => esc_html__( 'Dashed', 'designer' ),
                    'dotted' => esc_html__( 'Dotted', 'designer' ),
				],
                'selectors' => [
                    '{{WRAPPER}} .designer-process.designer-item-layout--horizontal .designer-process-line-inner'   => 'border-bottom-style: {{VALUE}};',
                ]
			]
		);

        $this->add_control(
			'line_border_color',
			[
				'label' => esc_html__( 'Line Border Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-process.designer-item-layout--horizontal .designer-process-line-inner' => 'border-color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
            'line_thickness',
            [
                'label'      => esc_html__( 'Line Thickness', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],  
                'selectors' => [
                    '{{WRAPPER}} .designer-process-line-inner'   => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .designer-process.designer-item-layout--horizontal .designer-process-line' => 'top: calc(50% - {{SIZE}}{{UNIT}}/2);',
                ]
            ]
        );





        $this->end_controls_section();
    }

    protected function __spacing_style_controls() {

        $this->start_controls_section(
			'section_spacing_style',
			[
				'label' => __( 'Spacing Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


        $this->add_responsive_control(
			'title_margin_top',
			[
				'label' => esc_html__( 'Item Title Margin Top', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .designer-process .designer-process-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'text_margin_top',
			[
				'label' => esc_html__( 'Item Text Margin Top', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ], 
				'selectors' => [
					'{{WRAPPER}} .designer-process .designer-process-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'text_padding',
			[
				'label' => esc_html__( 'Item Text Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ], 
				'selectors' => [
					'{{WRAPPER}} .designer-process .designer-process-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);




        $this->end_controls_section();
    }

    protected function __additional_style_controls() {

        $this->start_controls_section(
			'section_additional_style',
			[
				'label' => __( 'Additional Style', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		); 

        $this->add_control(
			'additional_holder_color',
			[
				'label' => esc_html__( 'Additional Holder Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-process-number' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'additional_holder_typography',
                'label'      => esc_html__( 'Additional Holder Typography', 'designer' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .designer-process-number',
			]
		);

        $this->add_responsive_control(
            'additional_holder_size',
            [
                'label'      => esc_html__( 'Additional Holder Size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .designer-process-number'   => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ] 
            ]
        );

        $this->add_responsive_control(
            'additional_holder_position',
            [
                'label' => esc_html__( 'Additional Holder Position', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [
                    'top',
                    'right',
                ],
                'selectors' => [
                    '{{WRAPPER}} .designer-process-number' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'horizontal_additional_holder_background',
                'label' => esc_html__('Additional Holder Background', 'designer'),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .designer-process-number ',
			]
		);
        

        $this->end_controls_section();
    }

    private function get_holder_class( $settings ) {

        $holder_classes = array();

        $holder_classes[] = 'designer-process';

        $holder_classes[] = 'yes' === $settings['appear_animation'] ? 'designer--process-has-appear' : '';

        $holder_classes[] = 'designer-item-layout--'.$settings['process_layout'].'';
        
        return implode(' ', $holder_classes);

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $item_key = 1;
        $item_title_tag = $settings['title_tag'];

        ?>

        <div class = " <?php echo $this->get_holder_class($settings); ?> ">
            <div class="designer-process-inner">
                <?php foreach($settings['process_list'] as $process):?>

                    <div class= "designer-process-item  elementor-repeater-item-<?php echo $process['_id'];?>">
                        <div class="designer-process-item-inner">
                            <div class="designer-process-content">
                            <div class="designer-process-icon-holder">
                                <div class="designer-process-icon">
                                    <?php if ( isset( $process['icon_type'] ) && ! empty( $process['icon_type']['value'] ) ) : ?>
                                        <span class="designer-process-item-icon-text">
                                            <?php \Elementor\Icons_Manager::render_icon( $process['icon_type'], array( 'aria-hidden' => 'true' ) ); ?>
                                        </span>
                                        <div class="designer-process-number">
                                            <?php echo esc_html( $item_key ).'.'; ?>
                                        </div>
                                        <?php else:?>
                                            <div class="designer-item-icon-text">
                                                <?php echo esc_html( $item_key ).'.'; ?>
                                            </div>
                                    <?php endif; ?>
                                </div>

                                <div class="designer-process-line">
                                    <div class="designer-process-line-inner"></div>
                                </div>
                            </div>
                            <?php require \Designer::plugin_dir().'widgets/process/snippets/layout-'.$settings['process_layout'].'.php'; ?>
                            </div>
                        </div>

                    </div>

                    <?php 
                    $item_key++;
                endforeach;
            ?>
                
            </div>
            
        </div>

        <?php



    }  
}