<?php
namespace Designer\Widgets\Template;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Designer\Includes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Template extends Widget_Base {

    public function get_name() {
		return 'designer-template';
	}

    public function get_title() {
		return esc_html__( 'Template', 'startupx' );
	}

    public function get_icon() {
		return 'designer-icon eicon-document-file';
	}

	public function get_categories() {
		return [ 'designer'];
	}

    public function get_keywords() {
		return [ 'template', 'section template' ];
	}

    protected function register_controls() {
        $this->start_controls_section(
			'_general_settings',
			[
				'label' => esc_html__( 'General', 'designer' ),
			]
		);

        $this->add_control(
			'select_template' ,
			[
				'label'	=> esc_html__( 'Select Template', 'designer' ),
				'type' => 'designer-ajax-select2',
				'options' => 'ajaxselect2/get_elementor_templates',
				'label_block' => true,
			]
		);

		// Restore original Post Data
		wp_reset_postdata();

      

        $this->end_controls_section();

    }

  
    protected function render() {

        $settings = $this->get_settings_for_display();

        if (!empty($settings['select_template'])) {
            $edit_link = '<span class="designer-template-edit-btn" data-permalink="'. esc_url(get_permalink($settings['select_template'])) .'">Edit Template</span>';
		
			$has_css = 'internal' === get_option( 'elementor_css_print_method' );

			echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $settings['select_template'], $has_css ) . $edit_link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

    }



}
