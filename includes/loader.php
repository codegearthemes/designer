<?php

namespace Designer\Includes;

use Designer\Traits\Singleton;
use Designer\Includes\Widget_Lists;

class Loader
{

    use Singleton;

   /**
	* Constructor
	*
	* @since 1.0.0
	* @access public
	*/
    public function __construct() {
        add_action( 'elementor/controls/register', array( $this, 'register_elementor_control' ), 10 );
		$this->_includes();
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
        add_action( 'elementor/widgets/register', [ $this, 'register_elementor_widgets'] );
        add_action( 'elementor/widgets/register', [ $this, 'unregister_widgets' ] );

        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_panel_scripts' ] );
        add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_panel_styles' ]);

        add_action( 'wp_enqueue_scripts', [ $this, 'register_fold_styles' ]);
        add_action( 'wp_footer', [ $this, 'register_styles' ]);
    }

    /**
	 * Elementor Categories
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function add_elementor_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'designer',
            [
                'title' => esc_html__( 'Designer', 'designer' ),
                'icon' => 'fa fa-cube',
            ]
        );

		$elements_manager->add_category(
            'designer-woocommerce',
            [
                'title' => esc_html__( 'Designer - WooCommerce', 'designer' ),
                'icon' => 'fa fa-cube',
            ]
        );

    }

    /**
	 * Elementor Control
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function register_elementor_control( $controls_manager ) {
		$controls_manager->register( new \Designer\Includes\Modules\Image_Select() );
		$controls_manager->register( new \Designer\Includes\Modules\DesignerAjaxSelect2\Designer_Control_Ajax_Select2() );
	}

	private function _includes() {
		// Custom Controls
		require plugin_dir_path( __FILE__ ) . 'modules/designer-ajax-select2/designer-control-ajax-select2-api.php';
	}

    /**
	 * Enqueue Editor Scripts.
	 *
	 * Enqueues required scripts in Elementor edit mode.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
    public function enqueue_editor_scripts(){
        wp_enqueue_script(
			'designer-template-script',
			\Designer::plugin_url().'assets/admin/js/template.script.js',
			[
				'jquery',
				'backbone-radio',
				'elementor-dialog',
				'backbone-marionette',
				'elementor-common-modules'
			],
			'1.0.0',
			true
		);

		wp_enqueue_script('designer-addons-library-editor-js',\Designer::plugin_url().'assets/admin/js/editor.js',['jquery',],'1.0.0',true);

		wp_localize_script( 'designer-template-script', 'designer_templates_library', array(
			'logo'	=> \Designer::plugin_url().'assets/admin/src/logo.svg',
		) );
    }

	public function enqueue_panel_scripts(){
		wp_enqueue_script('designer-addons-library-editor-js',\Designer::plugin_url().'assets/admin/js/editor.js',['jquery',],'1.0.0',true);
    }

    /**
	 * Enqueue Editor Styles.
	 *
	 * Enqueues required styles in Elementor edit mode.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
    public function enqueue_editor_styles(){
        wp_enqueue_style( 'designer-template-style', \Designer::plugin_url().'assets/admin/css/template.style.css', array(), '1.0.0', 'all' );
    }

    public function enqueue_panel_styles(){
        wp_enqueue_style( 'designer-addons-library-editor-css', \Designer::plugin_url().'assets/admin/css/editor.css', array(), '1.0.0', 'all' );
    }

    /**
	 * Fold Style
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function register_fold_styles(){
        wp_enqueue_style( 'designer-fold-style', \Designer::plugin_url().'assets/public/css/fold.style.css', array(), '1.0.0', 'all' );
    }

    /**
	 * Footer Style
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function register_styles(){
        wp_enqueue_style( 'designer-style', \Designer::plugin_url().'assets/public/css/main.css', array(), '1.0.0', 'all' );
    }

    /**
	 * Elementor Widgets
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function register_elementor_widgets( $widgets_manager ) {

        Widget_Lists::instance()->register_widget( $widgets_manager );

    }


    /**
     * Unregister Elementor widgets.
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
     * @return void
     */
    public function unregister_widgets( $widgets_manager ) {

        $widgets_manager->unregister( 'element--promotion' );

    }
}
