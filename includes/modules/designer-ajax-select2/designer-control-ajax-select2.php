<?php
namespace Designer\Includes\Modules\DesignerAjaxSelect2;

use Elementor\Base_Data_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Designer_Control_Ajax_Select2 extends Base_Data_Control {
	public function get_type() {
		return 'designer-ajax-select2';
	}

	public function enqueue() {
		wp_register_script( 'designer-control-ajax-select2', \Designer::plugin_url() . 'includes/modules/designer-ajax-select2/js/designer-control-ajax-select2.js' );
		wp_enqueue_script( 'designer-control-ajax-select2' );
	}

	protected function get_default_settings() {
		return [
			'options' => [],
			'multiple' => false,
			'select2options' => [],
			'query_slug' => '',
		];
	}

	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr($control_uid); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select id="<?php echo esc_attr($control_uid); ?>" class="elementor-control-type-designer-ajaxselect2" {{ multiple }} data-query-slug="{{data.query_slug}}" data-setting="{{ data.name }}" data-rest-url="<?php echo esc_attr( get_rest_url(). 'designeraddons/v1' . '/{{data.options}}/' ); ?>">
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
