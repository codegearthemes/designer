<?php

namespace Designer\Includes;

use Elementor\Plugin;
use Designer\Traits\Singleton;

if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

class Widget_Lists {

    use Singleton;

    public function register_widget( $widgets_manager ) {

        $widgets = [
            'social',
            'slider',
            'images',
            'clients',
            'popup',
            'gallery',
            'team-card',
            'typewriter',
            'posts-grid',
            'posts-cards',
            'posts-carousel',
            'before-after',
            'testimonial',
            'dual-header',
            'scroll-down',
            'breadcrumb',
            'testimonial-slider',
            'business-hours',
            'tabs-horizontal',
            'tabs-vertical',
        ];

        foreach ( $widgets as $widget ) {

            $class_name = str_replace( '-', '_', $widget );
            $class_name = str_replace( ' ', '', ucwords( $class_name ) );
            $class_name = '\\Designer\\Widgets\\'.$class_name.'\\'.$class_name;

            if( class_exists($class_name) ){
				$widgets_manager->register( new $class_name() );
			}
        }
    }

}
