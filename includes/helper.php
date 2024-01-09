<?php

namespace Designer\Includes;

use Designer\Traits\Singleton;

class Helper{

    use Singleton;

    public function posted_on( $icon = 'no' ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
		$posted_on = sprintf(
			/* translators: %s: post date */
			__( '<span class="date-label">%s</span>', 'designer' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$raw = '<span class="posted-on">';
            if( $icon == 'yes' ):
                $raw .= '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>';
            endif;
            $raw .= $posted_on;
		$raw .= '</span>';

		echo $raw; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

    public function author( $icon ) {
		$byline = sprintf(
			/* translators: %s: post author */
			__( '<span class="author-label screen-reader-text">By</span>%s', 'editorx' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		$raw = '<span class="byline">';
            if( $icon == 'yes' ):
                $raw .= '<svg width="15" height="14" version="1.1" fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 512 512">
                            <path d="M437.02,330.98c-27.883-27.882-61.071-48.523-97.281-61.018C378.521,243.251,404,198.548,404,148
                            C404,66.393,337.607,0,256,0S108,66.393,108,148c0,50.548,25.479,95.251,64.262,121.962
                            c-36.21,12.495-69.398,33.136-97.281,61.018C26.629,379.333,0,443.62,0,512h40c0-119.103,96.897-216,216-216s216,96.897,216,216
                            h40C512,443.62,485.371,379.333,437.02,330.98z M256,256c-59.551,0-108-48.448-108-108S196.449,40,256,40
                            c59.551,0,108,48.448,108,108S315.551,256,256,256z"/>
                        </svg>';
            endif;
            $raw .=  $byline;
		$raw .=  '</span>';

		echo $raw; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

    /**
     * Post Category
     * @return array
     */
    public function categories(){

        $terms = get_categories( array(
            'hide_empty' => true,
        ));

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $options[ $term->slug ] = $term->name;
            }
            return $options;
        }

    }


    /**
     * Contact
     * @return array
     */
    public function contact(){

        $contact = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

        $contact_forms = array();
        if ( $contact ) {
            foreach ( $contact as $form ) {
                $contact_forms[$form->ID] = $form->post_title;
            }
        } else {
            $contact_forms[ __( 'No contact forms found', 'designer' ) ] = 0;
        }

        return $contact_forms;

    }

    /**
     * WooCommerce Product Query
     * @return array
     */
    public function woocommerce_product_categories(){
        $terms = get_categories( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
        ));

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $options[ $term->slug ] = $term->name;
            }
            return $options;
        }
    }

    public function column_controls( $device = 'large', $column = 2 ){

        switch( $column ){
            case '1':
                $classes = 'one-whole';
                break;
            case '2':
                $classes = 'one-half';
                break;
            case '3':
                $classes = 'one-third';
                break;
            case '4':
                $classes = 'one-quarter';
                break;
            case '5':
                $classes = 'one-fifth';
                break;
            case '6':
                $classes = 'one-sixth';
                break;
            default:
                $classes = 'one-half';
                break;
        }

        return $device.'--'.$classes;
    }

    /**
     * Button Hover Reveal Background
     * More options to add in future
     */

     public function button_hover_background_reveal() {
        return [
            '' => esc_html__( 'None', 'designer' ),
            'reveal-horizontal' => esc_html__( 'Horizontal', 'designer' ),
            'reveal-vertical' => esc_html__( 'Vertical', 'designer' ),
            'shutter-out' => esc_html__( 'Shutter Out', 'designer' ),
        ];
    }

    /**
     * Button Classes
     * @return array
     */
    public function get_button_classes( $settings ){
		$button_classes = array();

		$button_classes[]	= 'block-advanced__btn';
		$button_classes[]	= 'btn-link__text';
		$button_classes[]	= !empty($settings['button_layout'])? 'designer-layout--' .$settings['button_layout'] : '';
		$button_classes[]	= !empty($settings['button_type']) ? 'designer-type--'	.$settings['button_type']	: '';
		$button_classes[]	=  !empty($settings['button_size']) ? 'designer-size--'.$settings['button_size']	: '';
		$button_classes[]	= !empty($settings['button_hover_reveal'])? 'designer-hover--reveal designer--'.$settings['button_hover_reveal'] : '';
		$button_classes[]	=  !empty($settings['button_icon_align']) ? 'designer-icon--' .$settings['button_icon_align']: '';
		$button_classes[]	= !empty($settings['button_icon_move'])? 'designer-hover--icon-' .$settings['button_icon_move'] : '';
		$button_classes[]	= !empty($settings['inner_border_hover_animation'])? 'designer-inner-border-hover--' .$settings['inner_border_hover_animation'] : '';
		$button_classes[]	= 'yes'	=== $settings['show_underline']? 'designer-text-underline' : '';
		$button_classes[]	= !empty($settings['underline_alignment'])? 'designer-underline--'.$settings['underline_alignment'] : '';
		$button_classes[]	= 'yes'	=== $settings['show_hover_underline_draw'] ? 'designer-button-underline-draw' : '';

		$button_classes = array_filter($button_classes, function($class) {
			return !empty($class);
		});

		return implode(' ', $button_classes );
	}

    /**
     * Button Inner Border
     */

	public function render_button_inner_border( $settings ){
		$inner_border = '';

		$inner_border .= '<div class="designer-m-inner-border">';

			if('move-outer-edge' !== $settings['inner_border_hover_animation']){
				$inner_border .= '<span class="designer-m-border-top"></span>';
				$inner_border .= '<span class="designer-m-border-right"></span>';
				$inner_border .= '<span class="designer-m-border-bottom"></span>';
				$inner_border .= '<span class="designer-m-border-left"></span>';
			}
		$inner_border .= '</div>';

		if ( ! empty( $settings['inner_border_hover_animation'] ) && ( ( 'draw d-draw-center' == $settings['inner_border_hover_animation'] ) || ( 'draw d-draw-one-point' == $settings['inner_border_hover_animation'] ) || ( 'draw d-draw-two-points' == $settings['inner_border_hover_animation'] ) ) ) {
			$inner_border .= '<div class="designer-m-inner-border designer-m-inner-border-copy">';
				$inner_border .= '<span class="designer-m-border-top"></span>';
				$inner_border .= '<span class="designer-m-border-right"></span>';
				$inner_border .= '<span class="designer-m-border-bottom"></span>';
				$inner_border .= '<span class="designer-m-border-left"></span>';
			$inner_border .= '</div>';
		}

		return $inner_border;

	}

     /**
     * Column Options
     * @return array
     */
    public function column_options() {
        $columns_options = [];
        $numberWords = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight'];

       for( $i = 1; $i <= 8; $i++) {
            $columns_options[$i] = __($numberWords[$i-1], 'designer');
       }

        return $columns_options;
    }


}
