<?php
namespace Designer\Widgets\Business_Hours;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Business_Hours extends Widget_Base{

    public function get_name() {
        return 'designer-business-hours';
    }

    public function get_title() {
        return esc_html__( 'Business Hours', 'designer' );
    }

    public function get_icon() {
        return 'designer-icon eicon-clock-o';
    }

    public function get_categories() {
        return ['designer'];
    }

    public function get_keywords() {
        return [ 'designer', 'business hours', 'working hours', 'opening hours', 'opening times', 'currently open' ];
    }

    protected function register_controls() {

       // Section: Business Hours ---
		$this->start_controls_section(
			'section_business_hours_items',
			[
				'label' => esc_html__( 'Business Hours', 'designer' ),
                'tab'	=> Controls_Manager::TAB_CONTENT,
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
			'day',
			[
				'label' => esc_html__( 'Day', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Monday',
			]
		);

        $repeater->add_control(
			'_icon',
			[
				'label' => esc_html__( 'Select Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'default' => [],
			]
		);

        $repeater->add_control(
			'_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(51,51,51,1)',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-business-day i ' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-business-day svg ' => 'fill: {{VALUE}};',
				],
			]
		);

        $repeater->add_control(
			'time',
			[
				'label' => esc_html__( 'Time', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => '08:00 AM - 05:00 PM',
				'separator' => 'before'
			]
		);

        $repeater->add_control(
			'_highlight',
			[
				'label' => esc_html__( 'Highlight this Item', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
                'separator' => 'before',
			]
		);

        $repeater->add_control(
			'highlight_color',
			[
				'label' => esc_html__( 'Highlight Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
                'condition' => [
                    '_highlight'    => 'yes',
				],
				'selectors'	=> [
					'{{WRAPPER}} {{CURRENT_ITEM}}.block-business__hours-item .designer-business-day'	=> 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}}.block-business__hours-item .designer-business-time'	=> 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-business-day i ' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .designer-business-day svg ' => 'fill: {{VALUE}};',
				]
				
			]
		);

        $repeater->add_control(
			'highlight_bg_color',
			[
				'label' => esc_html__( 'Highlight Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
                'condition' => [
                    '_highlight'    => 'yes',
				],
				'selectors'	=> [
					'{{WRAPPER}} {{CURRENT_ITEM}}.block-business__hours-item'	=> 'background-color: {{VALUE}};',
				]
				
			]
		);

        $repeater->add_control(
			'closed',
			[
				'label' => esc_html__( 'Closed', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'separator' => 'before'
			]
		);

        $repeater->add_control(
			'closed_text',
			[
				'label' => esc_html__( 'Closed Text', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Closed',
				'condition' => [
					'closed' => 'yes',
				],
			]
		);

        $this->add_control(
			'hours_items',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'day' => 'Monday',
					],
					[
						'day' => 'Tuesday',
					],
					[
						'day' => 'Wednesday',
					],
					[
						'day' => 'Thursday',
					],
					[
						'day' => 'Friday',
					],
					[
						'day' => 'Saturday',
						'time' => '08:00 AM - 01:00 PM',
					],
					[
						'day' => 'Sunday',
						'closed' => 'yes',
					],
				],
				'title_field' => '{{{ day }}}',
			]
		);


        $this->end_controls_section();

        // Styles
		// Section: General ----------
		$this->start_controls_section(
			'section_style_general',
			[
				'label' => esc_html__( 'General', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'tabs_general_colors' );

		$this->start_controls_tab(
			'tab_general_normal_colors',
			[
				'label' => esc_html__( 'Normal', 'designer' ),
			]
		);

        $this->add_control(
			'general_day_color',
			[
				'label' => esc_html__( 'Day Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-business-day' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'general_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(84,89,95,1)',
				'selectors' => [
					'{{WRAPPER}} .designer-business-day i ' => 'color: {{VALUE}};',
					'{{WRAPPER}} .designer-business-day svg ' => 'fill: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'general_time_color',
			[
				'label' => esc_html__( 'Time Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .designer-business-time' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'general_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .block-business__hours-item' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .block-business__hours' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
			'tab_general_hover_colors',
			[
				'label' => esc_html__( 'Hover', 'designer' ),
			]
		);

        $this->add_control(
			'general_hover_day_color',
			[
				'label' => esc_html__( 'Day Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-business__hours .block-business__hours-item:not(.block-business__hours-item-closed, .block-business__hours-highlighted):hover .designer-business-day' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'general_hover_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(84,89,95,1)',
				'selectors' => [
					'{{WRAPPER}} .block-business__hours .block-business__hours-item:not(.block-business__hours-item-closed, .block-business__hours-highlighted):hover .designer-business-day i ' => 'color: {{VALUE}};',
					'{{WRAPPER}} .block-business__hours .block-business__hours-item:not(.block-business__hours-item-closed, .block-business__hours-highlighted):hover .designer-business-day svg ' => 'fill: {{VALUE}};'
				],
			]
		);

        $this->add_control(
			'general_hover_time_color',
			[
				'label' => esc_html__( 'Time Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-business__hours .block-business__hours-item:not(.block-business__hours-item-closed, .block-business__hours-highlighted):hover .designer-business-time' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'general_hover_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f7f7f7',
				'selectors' => [
					'{{WRAPPER}} .block-business__hours .block-business__hours-item:not(.block-business__hours-item-closed, .block-business__hours-highlighted):hover' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'enable_even_color',
			[
				'label' => esc_html__( 'Enable Even Color', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'feature_bg_even_color',
			[
				'label' => esc_html__( 'Background Even Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#eeeeee',
				'selectors' => [
					'{{WRAPPER}} .block-business__hours div:nth-of-type(even)' => 'background-color: {{VALUE}};',
				],
                'condition'    => [
                    'enable_even_color' => 'yes',
                ]
			]
		);

        $this->add_control(
			'general_closed_section',
			[
				'label' => esc_html__( 'Closed', 'designer' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'general_closed_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .block-business__hours-item-closed' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'general_closed_day_color',
			[
				'label' => esc_html__( 'Day Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .block-business__hours-item-closed .designer-business-day' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'general_closed_color',
			[
				'label' => esc_html__( 'Text Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .block-business__hours-item-closed .designer-business-closed' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'general_day_typography_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Day Typography', 'designer' ),
				'name' => 'general_day_typography',
				'selector' => '{{WRAPPER}} .designer-business-day',
			]
		);

        $this->add_responsive_control(
			'_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
					'{{WRAPPER}} .designer-business-day i'	=> 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Time Typography', 'designer' ),
				'name' => 'general_time_typography',
				'selector' => '{{WRAPPER}} .designer-business-time,{{WRAPPER}} .designer-business-closed',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'general_divider',
			[
				'label' => esc_html__( 'Divider', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'general_divider_color',
			[
				'label' => esc_html__( 'Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .block-business__hours-item:after' => 'border-bottom-color: {{VALUE}};',
				],
				'condition' => [
					'general_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'general_divider_type',
			[
				'label' => esc_html__( 'Style', 'designer' ),
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
					'{{WRAPPER}} .block-business__hours-item:after' => 'border-bottom-style: {{VALUE}};',
				],
				'condition' => [
					'general_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'general_divider_weight',
			[
				'label' => esc_html__( 'Weight', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .block-business__hours-item:after' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'general_divider' => 'yes',
				],
			]
		);

		
		$this->add_control(
			'general_padding',
			[
				'label' => esc_html__( 'Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
				],
				'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .block-business__hours-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'general_wrapper_padding',
			[
				'label' => esc_html__( 'Wrapper Padding', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .block-business__hours' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'general_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
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
					'color' => [
						'default' => '#E8E8E8',
					],
				],
				'selector' => '{{WRAPPER}} .block-business__hours',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'general_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designer' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .block-business__hours' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
				],
				'separator' => 'before',
			]
		);

        $this->end_controls_section();
    }

	protected function render() {

		$settings = $this->get_settings_for_display();
		$item_count = 0;
		?>

		<div class="block-business__hours">
			<?php
			foreach ($settings['hours_items'] as $item) :
				
				if( '' !== $item['day'] || '' !== $item['time']  ) :
					
					$this->add_render_attribute( 'hours_item_attribute'.$item_count, 'class', 'block-business__hours-item elementor-repeater-item-'.esc_attr( $item['_id'] ) );

					
					if ( 'yes' === $item['closed'] ) {
						$this->add_render_attribute( 'hours_item_attribute'. $item_count, 'class', 'block-business__hours-item-closed' );
					}

					if( 'yes'	=== $item['_highlight'] ) {
						$this->add_render_attribute( 'hours_item_attribute'. $item_count, 'class', 'block-business__hours-highlighted' );
					}

					?>

					<div <?php echo $this->get_render_attribute_string( 'hours_item_attribute'. $item_count ); ?>>
						<?php if ( '' !== $item['day'] ) : ?>	
							<span class="designer-business-day">
								<?php Icons_Manager::render_icon( $item['_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								<?php echo esc_html($item['day']); ?>
							</span>
						<?php endif; ?>

						<?php if ( 'yes' === $item['closed'] ) : ?>	
							<span class="designer-business-closed"><?php echo esc_html($item['closed_text']); ?></span>
							<?php elseif ( '' !== $item['time'] ) : ?>	
							<span class="designer-business-time"><?php echo esc_html($item['time']); ?></span>
						<?php endif; ?>

					</div>

					<?php


				endif;

				$item_count++;
			endforeach; ?>
		</div>

		<?php

	}

}