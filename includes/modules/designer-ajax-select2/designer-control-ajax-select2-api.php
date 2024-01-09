<?php

class Designer_Control_Ajax_Select2_Api {

	public function __construct() {
		$this->init();
	}

	public function init() {
		add_action( 'rest_api_init', function() {
			register_rest_route(
				'designeraddons/v1/ajaxselect2',
				'/(?P<action>\w+)/',
				[
					'methods' => 'GET',
					'callback' =>  [$this, 'callback'],
					'permission_callback' => '__return_true'
				]
			);
		} );
	}

	public function callback( $request ) {
		return $this->{$request['action']}( $request );
	}

	public function get_elementor_templates( $request ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;   
		}

		$args = [
			'post_type' => 'elementor_library',
			'post_status' => 'publish',
			'meta_key' => '_elementor_template_type',
			'meta_value' => ['page', 'section', 'container'],
			'numberposts' => 15
		];
		
		if ( isset( $request['s'] ) ) {
			$args['s'] = $request['s'];
		}

		$options = [];
		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$options[] = [
					'id' => get_the_ID(),
					'text' => html_entity_decode(get_the_title()),
				];
			}
		}

		wp_reset_postdata();

		return [ 'results' => $options ];
	}

}

new Designer_Control_Ajax_Select2_Api();
