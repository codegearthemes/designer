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
            'button-advanced',
            'pricing-table',
            'promo-box',
            'image-hotspots',
            'text-marquee',
            'image-marquee',
            'countdown',
            'contact',
            'process',
            'pricing-list',
            'video-popup',
            'progress-bar',
           
        ];

        if ( class_exists('woocommerce') ) {

            $woo_widgets = [
                'products',
                'products-slider',
                'collection',
                'collection-slider',
            ];

            $widgets = array_merge( $widgets, $woo_widgets );
        }

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
