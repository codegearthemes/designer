<?php
namespace Designer\Widgets\Text_Marquee;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;




if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Text_Marquee extends Widget_Base {

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

        wp_register_style( 'text-marquee', \Designer::plugin_url().'widgets/text-marquee/assets/text-marquee.css', array(), '1.0.0', 'all' );

    }

    public function get_name() {
		return 'text-marquee';
	}

    public function get_title() {
		return esc_html__( 'Text Marquee', 'designer' );
	}

    public function get_icon() {
		return 'designer-icon eicon-animation-text';
	}

    public function get_categories() {
		return [ 'designer'];
	}

    public function get_keywords() {
		return [ 'designer', 'text marquee', 'text', 'animation' ];
	}

	public function get_style_depends() {
		return [ 'text-marquee' ];
	}

    protected function register_controls() {
        $this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'General', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		); 

        $repeater = new Repeater();

        
		$repeater->add_control(
			'list_text',
			[
				'label' => esc_html__( 'Text', 'designer' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Example Text' , 'designer' ),
				'label_block' => true,
			]
		);

        $repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector'	=> '{{WRAPPER}} {{CURRENT_ITEM}}.designer-text-item',
				
			]
		);

		$repeater->add_control(
			'separator_icon',
			[
				'label' => esc_html__( 'Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'default' => [],
                    				
			]
		);

        $this->add_control(
			'list_item',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_text' => esc_html__( 'Move Text 1', 'designer' ),
					],
					[
						'list_text' => esc_html__( 'Move Text 2', 'designer' ),
					],
                    [
						'list_text' => esc_html__( 'Move Text 3', 'designer' ),
					],
				],
				
			]
		);

		$this->add_control(
			'duration',
			[
				'type' => Controls_Manager::NUMBER,
				'label' => esc_html__( 'Animation Duration', 'designer' ),
				'min' => 0,
				'step' => 1,
				'default' => 20,
			]
		);

        $this->add_control(
			'reverse_direction',
			[
				'label' => esc_html__( 'Reverse Direction', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => '',
				'selectors_dictionary'	=> [
					'yes'	=> 'animation: designer-move-horizontal-reverse-text',
					''		=> 'animation: designer-move-horizontal-normal-text',
				],
				'selectors'	=>	[
					'{{WRAPPER}} .designer-text-marquee .designer-marquee-text.designer-text--original'	=> '{{VALUE}} {{duration.VALUE}}s linear infinite',
					'{{WRAPPER}} .designer-text-marquee .designer-marquee-text.designer-text--clone'	=> '{{VALUE}}-clone {{duration.VALUE}}s linear infinite',
				]

			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => esc_html__( 'Pause On Hover', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
				'selectors_dictionary'	=> [
					'yes'	=> 'animation-play-state: paused',
				],
				'selectors'	=>	[
					'{{WRAPPER}} .designer-text-marquee:hover .designer-marquee-text.designer-text--original'	=> '{{VALUE}} ',
					'{{WRAPPER}} .designer-text-marquee:hover .designer-marquee-text.designer-text--clone'	=> '{{VALUE}}',
				]
               
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'designer' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		); 

        $this->add_control(
            'color',
            [
                'label' =>  esc_html__('Color', "designer"),
                'type'  =>  Controls_Manager::COLOR,
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-item'	=> 'color: {{VALUE}};'
				]
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'general_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector'	=> '{{WRAPPER}} .designer-text-item',
			]
		);

        $this->add_control(
			'text_stroke_effect',
			[
				'label' => esc_html__( 'Text Stroke Effect', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'yes' => esc_html__( 'Yes', 'designer' ),
					'no' => esc_html__( 'No', 'designer' ),
				],
			]
		);

        $this->add_control(
            'stroke_color',
            [
                'label' =>  esc_html__('Text Stroke Color', "designer"),
                'type'  =>  Controls_Manager::COLOR,
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-item'	=> '-webkit-text-stroke-color: {{VALUE}};'
				],
                'condition' => [
                    'text_stroke_effect'    => 'yes'
                ]
            ]
        );

        $this->add_control(
			'stroke_width',
			[
				'label' => esc_html__( 'Text Stroke Width', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
                ],
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-item ' => '-webkit-text-stroke-width: {{SIZE}}px;',
				],
                'condition' => [
                    'text_stroke_effect'    => 'yes'
                ]
			]
		);

        $this->add_control(
            'icon_color',
            [
                'label' =>  esc_html__('Icon Color', "designer"),
                'type'  =>  Controls_Manager::COLOR,
				'selectors'	=> [
					'{{WRAPPER}} .designer-icon-holder' => 'color: {{VALUE}};',
				]
            ]
        );

        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
                        'step'  => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-marquee .designer-icon-holder' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_responsive_control(
			'space_between_items',
			[
				'label' => esc_html__( 'Space Between Items', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
                        'step'  => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-item'	=> 'padding-left : calc({{SIZE}}{{UNIT}}/2); padding-right : calc({{SIZE}}{{UNIT}}/2);',
				]
			]
		);



        $this->end_controls_section();
    }

    public function get_holder_classes( $settings ) {
        $holder_class = array();

        $holder_class[] = 'designer-text-marquee';
        $holder_class[] = ( 'yes' === $settings['text_stroke_effect'] ) ? 'designer-text-stroke-effect' : '';

        return implode(' ', $holder_class);
    }

    protected function render(){
        
        $settings = $this->get_settings_for_display(); 
        ?>
        
        <div class="<?php echo $this->get_holder_classes($settings); ?>">
            <div class="designer-marquee-content">
				<div class="designer-marquee-text designer-text--original">
					<?php
						
						foreach( $settings['list_item'] as $item) { 
							$separator_icon = $item['separator_icon'];
							?>
							<?php
							if ( isset( $separator_icon ) && ! empty( $separator_icon['value'] ) ) { ?>

								<span class="designer-icon-holder">

									<?php \Elementor\Icons_Manager::render_icon( $separator_icon, array( 'aria-hidden' => 'true' ) ); ?>

								</span>


								<?php
							}?>
							<span class= "designer-text-item elementor-repeater-item-<?php echo $item['_id']; ?>" ><?php echo wp_kses( $item['list_text'], array( 'span' => array( 'style' => true ) )  ); ?></span>
							<?php
						}
					?>
				</div>
				<div class="designer-marquee-text designer-text--clone">
					<?php
						foreach( $settings['list_item'] as $item) { 
							$separator_icon = $item['separator_icon'];
							?>
							<?php
							if ( isset( $separator_icon ) && ! empty( $separator_icon['value'] ) ) { ?>

								<span class="designer-icon-holder">

									<?php \Elementor\Icons_Manager::render_icon( $separator_icon, array( 'aria-hidden' => 'true' ) ); ?>
									
								</span>


								<?php
							}?>
							<span class= "designer-text-item elementor-repeater-item-<?php echo $item['_id']; ?>" ><?php echo wp_kses( $item['list_text'], array( 'span' => array( 'style' => true ) )  ); ?></span>
							<?php
						}
					?>
				</div>
                
            </div>
        </div>
        
        <?php


    }


}