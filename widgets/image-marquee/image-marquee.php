<?php
namespace Designer\Widgets\Image_Marquee;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Marquee extends Widget_Base {

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

        wp_register_style( 'image-marquee', \Designer::plugin_url().'widgets/image-marquee/assets/image-marquee.css', array(), '1.0.0', 'all' );

    }

    public function get_name() {
		return 'designer-image-marquee';
	}

    public function get_title() {
		return esc_html__( 'Image Marquee', 'designer' );
	}

    public function get_icon() {
		return 'designer-icon eicon-image-rollover';
	}

    public function get_categories() {
		return [ 'designer'];
	}

    public function get_keywords() {
		return [ 'designer', 'image marquee', 'image', 'animation' ];
	}

	public function get_style_depends() {
		return ['image-marquee'];
	}


    protected function register_controls() {
        $this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'General', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		); 

        $this->add_control(
			'img_marquee_layout',
			[
				'label' => esc_html__( 'Layout', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'designer' ),
					'vertical' => esc_html__( 'Vertical', 'designer' ),
				],
				'selectors' => [
					
				],
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
			'list_image',
			[
				'label' => esc_html__( 'Choose Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'list_item',
			[
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_image' => Utils::get_placeholder_image_src(),
					],
					[
						'list_image' => Utils::get_placeholder_image_src(),
					],
                    [
						'list_image' => Utils::get_placeholder_image_src(),
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
				'label' => esc_html__( 'Horizontal Reverse Direction', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => '',
				'selectors_dictionary'	=> [
					'yes'	=> 'animation: designer-move-horizontal-reverse-image',
					''		=> 'animation: designer-move-horizontal-normal-image',
				],
				'selectors'	=>	[
					'{{WRAPPER}} .designer-image-marquee .designer-marquee-image.designer-image--original'	=> '{{VALUE}} {{duration.VALUE}}s linear infinite',
					'{{WRAPPER}} .designer-image-marquee .designer-marquee-image.designer-image--clone'	=> '{{VALUE}}-clone {{duration.VALUE}}s linear infinite',
				],
				'condition'	=> [
					'img_marquee_layout' => 'horizontal',
				],
				'prefix_class'	=> 'designer-horizontal-reverse-',

			]
		);

		$this->add_control(
			'Vertical_reverse_direction',
			[
				'label' => esc_html__( 'Vertical Reverse Direction', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => '',
				'selectors_dictionary'	=> [
					'yes'	=> 'animation: designer-move-vertical-reverse-image',
					''		=> 'animation: designer-move-vertical-normal-image',
				],
				'selectors'	=>	[
					'{{WRAPPER}} .designer-image-marquee .designer-marquee-image.designer-image--original'	=> '{{VALUE}} {{duration.VALUE}}s linear infinite',
					'{{WRAPPER}} .designer-image-marquee .designer-marquee-image.designer-image--clone'	=> '{{VALUE}}-clone {{duration.VALUE}}s linear infinite',
				],
				'condition'	=> [
					'img_marquee_layout' => 'vertical',
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
					'{{WRAPPER}} .designer-image-marquee:hover .designer-marquee-image.designer-image--original'	=> '{{VALUE}} ',
					'{{WRAPPER}} .designer-image-marquee:hover .designer-marquee-image.designer-image--clone'	=> '{{VALUE}}',
				]
               
			]
		);

		$this->add_responsive_control(
			'image_vertical_height',
			[
				'label' => esc_html__( 'Vertical Height', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-layout--vertical' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'	=> [
					'img_marquee_layout' => 'vertical'
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

		$this->add_responsive_control(
			'image_gutter',
			[
				'label' => esc_html__( 'Gutter', 'designer' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .designer-layout--horizontal .designer-image-item' => 'margin: 0 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .designer-layout--vertical .designer-image-item' => 'margin: {{SIZE}}{{UNIT}} 0',
				],
			]
		);

		$this->end_controls_section();

    }

	public function get_holder_classes ( $settings ) {

		$holder_classes = array();

		$holder_classes[] = 'designer-image-marquee';

		$holder_classes[] = ( $settings['img_marquee_layout'] ) ? 'designer-layout--'.$settings['img_marquee_layout'] : '';


		return implode( ' ', $holder_classes );
		

	}


	protected function render() {

		$settings = $this->get_settings_for_display(); 
		
		?>

		<div class = "<?php echo $this->get_holder_classes( $settings ); ?>">
			<div class="designer-marquee-content">
				<div class="designer-marquee-image designer-image--original">
					<?php foreach( $settings['list_item'] as $item):
					
						?>

						<div class= "designer-image-item elementor-repeater-item-<?php echo $item['_id']; ?>" >

							<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $item, 'image_size', 'list_image' ); ?>

						</div>

					<?php endforeach;?>
				</div>

				<div class="designer-marquee-image designer-image--clone">
					<?php foreach( $settings['list_item'] as $item):
					
						?>

						<div class= "designer-image-item elementor-repeater-item-<?php echo $item['_id']; ?>" >

							<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $item, 'image_size', 'list_image' ); ?>

						</div>


					<?php endforeach;?>
				</div>

			</div>
		</div>




	<?php

	}

}