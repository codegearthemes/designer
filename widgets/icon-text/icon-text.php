<?php

namespace Designer\Widgets\Icon_Text;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Designer\Includes\Helper;

class Icon_Text extends Widget_Base
{

	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'designer-icon-text';
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
	public function get_title()
	{
		return esc_html__('Icon text', 'designer');
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
	public function get_icon()
	{
		return 'designer-icon eicon-icon-box';
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
	public function get_custom_help_url()
	{
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
	public function get_categories()
	{
		return ['designer'];
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
	public function get_keywords()
	{
		return [
			'Icon Box',
			'Icon Text'
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
	protected function register_controls()
	{
		$this->start_controls_section(
			'_general_settings',
			[
				'label' => esc_html__('General', 'designer'),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => __('Layout', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'before-content',
				'options' => [
					'before-content'	=> __('Before Content', 'designer'),
					'before-title'		=> __('Before Title', 'designer'),
					'top'		=> __('Top', 'designer'),
				]

			]
		);

		$this->add_control(
			'link',
			[
				'type' => Controls_Manager::URL,
				'label' => esc_html__('Link', 'designer'),
				'placeholder' => esc_html__('https://your-link.com', 'designer'),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label' => esc_html__('Icon Type', 'designer'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-paper-plane',
					'library' => 'fa-regular',
				],
			]
		);

		$this->add_control(
			'enable_separator',
			[
				'label'   => __('Enable Separator', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'yes'	=> __('Yes', 'designer'),
					'no'		=> __('No', 'designer'),
				]

			]
		);

		$this->add_control(
			'before_content_column_responsive',
			[
				'label'   => __('Enable Column Responsive', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'never',
				'options' => [
					'never'	=> __('Never', 'designer'),
					'768'		=> __('Under 768px', 'designer'),
					'680'		=> __('Under 680px', 'designer'),
					'480'		=> __('Under 480px', 'designer'),
				],
				'condition' => [
					'layout' => 'before-content',
				],

			]
		);


		$this->end_controls_section();

		$this->content_settings_control();
		$this->__button_settings_control();
		$this->__separator_settings_control();
		$this->__separator_border_image_control();
		$this->__separator_border_icon_control();

		// Styles Control
		$this->__title_styles_control();
		$this->spacing_styles_control();
		$this->icon_styles_control();
		$this->__button_style_controls();
		$this->__icon_style_controls();
		$this->__inner_border_style_controls();
		$this->__underline_style_controls();
		$this->__separator_style_controls();
		$this->__separator_icon_style_controls();
	}

	protected function content_settings_control()
	{
		$this->start_controls_section(
			'_content_settings',
			[
				'label' => esc_html__('Content', 'designer'),
			]
		);

		$this->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __('Title', 'designer'),
				'default' => __('Sample Title', 'designer'),
			]
		);

		$this->add_control(
			'text',
			[
				'type' => Controls_Manager::WYSIWYG,
				'label' => __('Text', 'designer'),
				'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 'designer'),
			]
		);

		$this->end_controls_section();
	}

	protected function __button_settings_control()
	{
		$this->start_controls_section(
			'_button_settings',
			[
				'label' => esc_html__('Button', 'designer'),
			]
		);

		$this->add_control(
			'button_layout',
			[
				'label'   => __('Button Layout', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'btn-link',
				'options' => [
					'btn-link'   => __('Filled', 'designer'),
					'text-link'  	 => __('Text', 'designer'),
					'outlined'		 => __('Outlined', 'designer'),
				]

			]
		);

		$this->add_control(
			'button_type',
			[
				'label'   => __('Button Type', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'options' => [
					'standard'   	=> __('Standard', 'designer'),
					'inner-border' 	=> __('Inner Border', 'designer'),
					'icon-boxed'		=> __('Icon Boxed', 'designer'),
				],
				'condition'	=> [
					'button_layout!'	=>	'text-link',
				]


			]
		);

		$this->add_control(
			'show_underline',
			[
				'label' => esc_html__('Show Underline', 'designer'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'designer'),
				'label_off' => esc_html__('Hide', 'designer'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);


		$this->add_control(
			'button_size',
			[
				'label'   => __('Size', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'	=> __('Normal', 'designer'),
					'small'		=> __('Small', 'designer'),
					'large'		=> __('Large', 'designer'),
				]

			]
		);

		$this->add_control(
			'button_label',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __('Button label', 'designer'),
				'default' => __('Click Here', 'designer')
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => __('Button Link', 'designer'),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://example.com',
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_icon_enable',
			[
				'label' => esc_html__('Icon enable', 'designer'),
				'type' =>  Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'designer'),
				'label_off' => esc_html__('No', 'designer'),
				'return_value' => 'yes',
				'default' => 'no',
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'button_arrow_icon',
			[
				'label' => __('Button icon', 'designer'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-long-arrow-alt-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'button_icon_enable' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_icon_align',
			[
				'label'   => __('Icon position', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
					'row-reverse'   => __('Before', 'designer'),
					'row'           => __('After', 'designer'),
				],
				'condition' => [
					'button_icon_enable' => 'yes',
				],

			]
		);

		$this->add_control(
			'show_icon_sidebar',
			[
				'label' => esc_html__('Enable Icon Side Border', 'designer'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'designer'),
				'label_off' => esc_html__('No', 'designer'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'	=> [
					'button_type'	=> 'icon-boxed',
				]
			]

		);

		$this->add_control(
			'accessibility',
			[
				'label' => esc_html__('Accessibility', 'designer'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __('Button title', 'designer'),
				'description' => __('Button title text for accessibility.', 'designer'),
			]
		);

		$this->end_controls_section();
	}

	protected function __separator_settings_control()
	{
		$this->start_controls_section(
			'_separator_settings',
			[
				'label' => esc_html__('Separator', 'designer'),
			]
		);

		$this->add_control(
			'separator_layout',
			[
				'label'   => __('Layout', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'options' => [
					'border-image'	=> __('Border Image', 'designer'),
					'standard'		=> __('Standard', 'designer'),
					'with-icon'		=> __('With Icon', 'designer'),
				],

			]
		);

		$this->add_control(
			'position',
			[
				'label'   => __('Position', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __('Default', 'designer'),
					'center'	=> __('Center', 'designer'),
					'left'		=> __('Left', 'designer'),
					'right'		=> __('Right', 'designer'),
				],

			]
		);



		$this->end_controls_section();
	}

	protected function __separator_border_image_control()
	{

		$this->start_controls_section(
			'_separator_border_image_settings',
			[
				'label' => esc_html__('Separator Border Image', 'designer'),
			]
		);

		$this->add_control(
			'separator_border_image',
			[
				'label' => esc_html__('Border Image', 'designer'),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'separator_layout' => 'border-image',
				],
			]
		);

		$this->add_control(
			'separator_border_image_size',
			[
				'label'   => __('Border Image Size', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => [
					'auto'	=> __('Auto', 'designer'),
					'cover'		=> __('Cover', 'designer'),
					'contain'		=> __('Contain', 'designer'),
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
				'label'   => __('Border Image Position', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'	=> __('Left', 'designer'),
					'center'		=> __('Center', 'designer'),
					'right'		=> __('Right', 'designer'),
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
				'label'   => __('Border Image Repeat', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'round',
				'options' => [
					'round'	=> __('Round', 'designer'),
					'repeat'		=> __('Repeat', 'designer'),
					'space'		=> __('Space', 'designer'),
					'no-repeat'		=> __('None', 'designer'),
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

	protected function __separator_border_icon_control()
	{

		$this->start_controls_section(
			'_separator_border_icon_settings',
			[
				'label' => esc_html__('Separator Icon', 'designer'),
			]
		);

		$this->add_control(
			'separator_icon',
			[
				'label' => __('Separator Icon', 'designer'),
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

	protected function __title_styles_control()
	{
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__('Style', 'designer'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__('Title Tag', 'designer'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => esc_html__('H1', 'designer'),
					'h2' => esc_html__('H2', 'designer'),
					'h3' => esc_html__('H3', 'designer'),
					'h4' => esc_html__('H4', 'designer'),
					'h5' => esc_html__('H5', 'designer'),
					'h6' => esc_html__('H6', 'designer'),
					'div' => esc_html__('div', 'designer'),
					'span' => esc_html__('span', 'designer'),
					'p' => esc_html__('p', 'designer'),
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Title Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-title .designer-title-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Title Hover Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-title:hover .designer-title-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__('Title Typography', 'designer'),
				'selector' => '{{WRAPPER}} .designer-title .designer-title-text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__('Text Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-content .designer-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => esc_html__('Text Typography', 'designer'),
				'selector' => '{{WRAPPER}} .designer-content .designer-text',
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'     => __('Content Alignment', 'designer'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => __('Left', 'designer'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'designer'),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'designer'),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .designer-icon-text.designer-layout--top' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'layout' => 'top',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function spacing_styles_control()
	{
		$this->start_controls_section(
			'section_spacing_style',
			[
				'label' => esc_html__('Spacing Style', 'designer'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'title_margin_top',
			[
				'label' => esc_html__('Title Margin Top', 'designer'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .designer-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin_top',
			[
				'label' => esc_html__('Text Margin Top', 'designer'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .designer-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label' => esc_html__('Icon Margin', 'designer'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .designer-icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin_top',
			[
				'label' => esc_html__('Button Margin Top', 'designer'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function icon_styles_control()
	{

		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__('Icon Style', 'designer'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_boxed',
			[
				'label' => esc_html__('Icon Boxed', 'designer'),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => esc_html__('No', 'designer'),
					'yes' => esc_html__('Yes', 'designer'),
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__('Icon Size', 'designer'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .designer-icon-holder' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_tabs_icon_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs('_tabs_icon');

		// Icon color
		$this->start_controls_tab(
			'_tab_icon_normal',
			[
				'label' => __('Normal', 'designer'),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__('Icon Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-icon-holder' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_background_color',
			[
				'label' => esc_html__('Icon Background Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-icon-holder' => 'background-color: {{VALUE}}',
				],
				'condition'	=> [
					'icon_boxed' => ['yes']
				]
			]
		);

		$this->add_control(
			'icon_border_color',
			[
				'label' => esc_html__('Icon Border Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-icon-holder' => 'border-color: {{VALUE}}',
				],
				'condition'	=> [
					'icon_boxed' => ['yes']
				]
			]
		);

		$this->add_control(
			'icon_stroke_color',
			[
				'label' => esc_html__('Icon Stroke  Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-icon-holder svg' => 'stroke: {{VALUE}}',
				],
				'condition' => [
					'icon_type[library]' => 'svg',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_icon_hover',
			[
				'label' => __('Hover', 'designer'),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__('Icon Hover Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-icon-text:hover .designer-icon-holder' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_background_hover_color',
			[
				'label' => esc_html__('Icon Background Hover Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-icon-text:hover .designer-icon-holder' => 'background-color: {{VALUE}}',
				],
				'condition'	=> [
					'icon_boxed' => ['yes']
				]
			]
		);

		$this->add_control(
			'icon_border_hover_color',
			[
				'label' => esc_html__('Icon Border Hover Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-icon-text:hover .designer-icon-holder' => 'border-color: {{VALUE}}',
				],
				'condition'	=> [
					'icon_boxed' => ['yes']
				]
			]
		);

		$this->add_control(
			'icon_stroke_hover_color',
			[
				'label' => esc_html__('Icon Stroke Hover Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .designer-icon-text:hover .designer-icon-holder svg' => 'stroke: {{VALUE}}',
				],
				'condition' => [
					'icon_type[library]' => 'svg',
				],
			]
		);

		$this->add_control(
			'icon_hover_move',
			[
				'label' => esc_html__('Icon Hover', 'designer'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__('None', 'designer'),
					'move-horizontal' => esc_html__('Move Horizontal', 'designer'),
					'move-vertical' => esc_html__('Move Vertical', 'designer'),
					'scale' => esc_html__('Scale', 'designer'),
				],
			]
		);




		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'_tabs_icon_after_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'icon_box_size',
			[
				'label' => esc_html__('Icon Box Size', 'designer'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'vw'],
				'selectors' => [
					'{{WRAPPER}} .designer-icon-holder' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_border_size',
			[
				'label' => esc_html__('Icon Border Size', 'designer'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'vw'],
				'selectors' => [
					'{{WRAPPER}} .designer-icon-holder' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label' => esc_html__('Icon Border Radius', 'designer'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .designer-icon-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_stroke_width',
			[
				'label' => esc_html__('Icon Stroke Width', 'designer'),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'condition' => [
					'icon_type[library]' => 'svg',
				],
				'selectors' => [
					'{{WRAPPER}} .designer-icon-holder svg' => 'stroke-width: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __button_style_controls()
	{

		$this->start_controls_section(
			'_section_style_button',
			[
				'label' => __('Button', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label',
				'selector' => '{{WRAPPER}} .block-action__advanced .btn-link__text',
			]
		);

		$this->add_control(
			'_button_style_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __('Button color', 'designer'),
				'show_label' => false,
			]
		);

		$this->start_controls_tabs('_tabs_button');

		// Button color
		$this->start_controls_tab(
			'_tab_button_normal',
			[
				'label' => __('Normal', 'designer'),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __('Button color', 'designer'),
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
				'label' => __('Background color', 'designer'),
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
				'label' => __('Border color', 'designer'),
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
				'label' => __('Hover', 'designer'),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => __('Button hover color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .block-advanced__btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background',
			[
				'label' => __('Button hover background', 'designer'),
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
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __('Button Hover Border color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'default' => '#003d20',
				'condition'	=> [
					'button_layout!'	=> 'text-link',
				],
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .block-advanced__btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_reveal',
			[
				'label' => esc_html__('Background Reveal', 'designer'),
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
				'label' => esc_html__('Border Width', 'designer'),
				'size_units' => ['px'],
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
				'label' => esc_html__('Padding', 'designer'),
				'size_units' => ['px', 'em', 'rem'],
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
				'label' => __('Border Radius', 'designer'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
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

	protected function __icon_style_controls()
	{
		$this->start_controls_section(
			'_section_style_icon',
			[
				'label' => esc_html__('Button Icon Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'button_icon_enable'	=> 'yes',
				]
			]

		);

		$this->add_responsive_control(
			'button_icon_size',
			[
				'label' => __('Icon Size', 'designer'),
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
				'label' => esc_html__('Normal', 'designer'),
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'label' => esc_html__('Icon Color', 'designer'),
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
				'label' => esc_html__('Icon Background Color', 'designer'),
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
				'label' => esc_html__('Hover', 'designer'),
			]
		);

		$this->add_control(
			'icon_bg_hover_color',
			[
				'label' => esc_html__('Icon Background Hover Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner:hover' => 'background-color: {{VALUE}};'
				],
				'condition'	=> [
					'button_type'	=> 'icon-boxed'
				],
			]
		);


		$this->add_control(
			'button_icon_move',
			[
				'label'   => __('Move Icon', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'move-horizontal-short',
				'options' => [
					'move-horizontal-short'   => __('Horizontal Short', 'designer'),
					'move-horizontal'           => __('Horizontal', 'designer'),
					'move-vertical'           => __('Vertical', 'designer'),
					'move-diagonal'           => __('Diagonal', 'designer'),
					''           => __('None', 'designer'),
				],

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'margin',
			[
				'label' => esc_html__('Margin', 'designer'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em',],
				'separator'	=> 'before',
				'selectors' => [
					'{{WRAPPER}} .block-action__advanced .btn-link__text .designer-m-icon-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_side_border_color',
			[
				'label' => esc_html__('Icon Side Border Color', 'designer'),
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
				'label' => esc_html__('Icon Side Border Hover Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-advanced__btn.designer-type--icon-boxed:hover .designer-m-border' => 'background-color:{{VALUE}};',
				],
				'condition'	=> [
					'show_icon_sidebar' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'button_icon_border_height',
			[
				'label' => __('Icon Side Border Height', 'designer'),
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
				'label' => __('Icon Side Border Width', 'designer'),
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

	protected function __inner_border_style_controls()
	{
		$this->start_controls_section(
			'_section_inner_border_style',
			[
				'label' => esc_html__('Inner Border Style', 'designer'),
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
				'label' => esc_html__('Normal', 'designer'),
			]
		);

		$this->add_control(
			'inner_border_color',
			[
				'label' => esc_html__('Inner Border Color', 'designer'),
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
				'label' => esc_html__('Hover', 'designer'),
			]
		);

		$this->add_control(
			'inner_border_hover_color',
			[
				'label' => esc_html__('Inner Border Hover Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-advanced__btn.designer-type--inner-border:not(.designer-inner-border-hover--draw):hover .designer-m-inner-border:not(.designer-m-inner-border-copy)'	=> 'color:{{VALUE}};',
					'{{WRAPPER}} .block-advanced__btn.designer-type--inner-border .designer-m-inner-border.designer-m-inner-border-copy' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'inner_border_hover_animation',
			[
				'label'   => __('Hover', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''   => __('Change Color', 'designer'),
					'draw d-draw-center'          => __('Draw From Center', 'designer'),
					'draw d-draw-one-point'       => __('Draw From One Point', 'designer'),
					'draw d-draw-two-points'      => __('Draw From Two Points', 'designer'),
					'remove d-remove-center'      => __('Remove To Center', 'designer'),
					'remove d-remove-one-point'   => __('Remove To One Point', 'designer'),
					'remove d-remove-two-points'  => __('Remove To Two Points', 'designer'),
					'move-outer-edge'           => __('Move To Outer Edge', 'designer'),
				],

			]
		);

		$this->end_controls_tab();


		$this->end_controls_tabs();

		$this->add_responsive_control(
			'inner_border_offset',
			[
				'label' => __('Inner Border Offset', 'designer'),
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
				'label' => __('Inner Border Width', 'designer'),
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

	protected function __underline_style_controls()
	{
		$this->start_controls_section(
			'_section_underline_style',
			[
				'label' => esc_html__('Underline Style', 'designer'),
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
				'label' => esc_html__('Normal', 'designer'),
			]
		);

		$this->add_control(
			'underline_color',
			[
				'label' => esc_html__('Underline Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-underline .label:after' => 'background-color:{{VALUE}}',
				]
			]
		);


		$this->add_responsive_control(
			'underline_width',
			[
				'label' => __('Underline Width', 'designer'),
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
				'label' => esc_html__('Hover', 'designer'),
			]
		);

		$this->add_control(
			'underline_hover_color',
			[
				'label' => esc_html__('Underline Hover Color', 'designer'),
				'type' => Controls_Manager::COLOR,
				'selectors'	=> [
					'{{WRAPPER}} .designer-text-underline:hover .label:after' => 'background-color:{{VALUE}}',
				]
			]
		);

		$this->add_responsive_control(
			'underline_hover_width',
			[
				'label' => __('Underline Hover Width', 'designer'),
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
				]
			]
		);

		$this->add_control(
			'show_hover_underline_draw',
			[
				'label' => esc_html__('Enable Hover Underline Draw', 'designer'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'designer'),
				'label_off' => esc_html__('No', 'designer'),
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
				'label' => __('Underline Offset', 'designer'),
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
				'label' => __('Underline Thickness', 'designer'),
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
				'label' => esc_html__('Underline Alignment', 'designer'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'designer'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'designer'),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'designer'),
						'icon' => 'eicon-h-align-right',
					]
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __separator_style_controls()
	{
		$this->start_controls_section(
			'_section_separator_style',
			[
				'label' => esc_html__('Separator Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]

		);

		$this->add_control(
			'separator_color',
			[
				'label' => esc_html__('Color', 'designer'),
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
				'label'   => __('Border Style', 'designer'),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''	=> 	esc_html__('Default', 'designer'),
					'solid'  => esc_html__('Solid', 'designer'),
					'dashed' => esc_html__('Dashed', 'designer'),
					'dotted' => esc_html__('Dotted', 'designer'),
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
				'label' => esc_html__('Width', 'designer'),
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
				'label' => esc_html__('Thickness', 'designer'),
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
				'label' => esc_html__('Margin Top', 'designer'),
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
				'label' => esc_html__('Margin Bottom', 'designer'),
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

	protected function __separator_icon_style_controls()
	{

		$this->start_controls_section(
			'_section_separator_icon_style',
			[
				'label' => esc_html__('Separator Icon Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]

		);

		$this->add_control(
			'separator_icon_color',
			[
				'label' => esc_html__('Icon Color', 'designer'),
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
				'label' => esc_html__('Icon Font Size', 'designer'),
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
				'label' => esc_html__('Icon Margin', 'designer'),
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

	private function get_holder_classes($settings)
	{

		$holder_classes[] = 'designer-icon-text';
		$holder_classes[] = ! empty($settings['layout']) ? 'designer-layout--' . $settings['layout'] : '';
		$holder_classes[] = ! empty($settings['before_content_column_responsive']) ? 'designer-column-responsive--' . $settings['before_content_column_responsive'] : '';
		$holder_classes[] = ('yes' === $settings['icon_boxed']) ? 'designer-icon-boxed' : '';
		$holder_classes[] = ! empty($settings['icon_hover_move']) ? 'designer-icon--hover-' . $settings['icon_hover_move'] : '';

		if ('top' === $settings['layout']) {
			$holder_classes[] = ! empty($settings['content_alignment']) ? 'designer-alignment--' . $settings['content_alignment'] : 'designer-alignment--center';
		}

		$icon_class = '';

		if (! empty($settings['icon_type']['value'])) {
			if (is_string($settings['icon_type']['value'])) {
				$icon_class = 'icon-pack';
			} else {
				$icon_class = 'custom-icon';
			}
		}

		$holder_classes[] = 'designer--' . $icon_class;

		return implode(' ', $holder_classes);
	}

	private function get_separator_classes($settings)
	{

		$holder_classes[] = 'designer-separator';
		$holder_classes[] = ! empty($settings['separator_layout']) ? 'designer-separator--' . $settings['separator_layout'] : '';
		$holder_classes[] = ! empty($settings['position']) ? 'designer-position--' . $settings['position'] : '';

		return implode(' ', $holder_classes);
	}


	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{

		// Get Settings
		$settings = $this->get_settings();

		$icon_box_style = '';

		if ($settings['button_type'] === 'icon-boxed') {
			$icon_box_style = 'style=width:54px;';
		}

		$link_url = $settings['link']['url'];
		$this->add_render_attribute('link_attribute', 'itemprop', 'url');

		if ('' !== $link_url) {
			$this->add_render_attribute('link_attribute', 'href', $settings['link']['url']);

			if ($settings['link']['is_external']) {
				$this->add_render_attribute('link_attribute', 'target', '_blank');
			}

			if ($settings['link']['nofollow']) {
				$this->add_render_attribute('link_attribute', 'rel', 'nofollow');
			}
		}

		$this->add_render_attribute('button_attribute', 'class', Helper::instance()->get_button_classes($settings));
		$button_url = $settings['button_link']['url'];

		if ('' !== $button_url) {
			$this->add_render_attribute('button_attribute', 'href', $settings['button_link']['url']);

			if ($settings['button_link']['is_external']) {
				$this->add_render_attribute('button_attribute', 'target', '_blank');
			}

			if ($settings['button_link']['nofollow']) {
				$this->add_render_attribute('button_attribute', 'rel', 'nofollow');
			}

			if (!empty($settings['button_title'])) {
				$this->add_render_attribute('button_attribute', 'title', $settings['button_title']);
			}
		}

?>
		<div class="<?php echo $this->get_holder_classes($settings); ?>">
			<?php
				// Define allowed layouts
				$allowed_layouts = ['before-content', 'before-title', 'top'];

				// Validate layout input
				$layout = isset($settings['layout']) ? sanitize_text_field($settings['layout']) : 'before-content';

				if (in_array($layout, $allowed_layouts)) {
					$file_path = \Designer::plugin_dir() . 'widgets/icon-text/snippets/' . $layout . '.php';
					if (file_exists($file_path)) {
						require $file_path;
					} else {
						echo esc_html__('Invalid layout.', 'designer');
					}
				} else {
					echo esc_html__('Invalid layout.', 'designer');
				}
			?>
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
	protected function content_template() {}
}
