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
			__( '<span class="date-label"> </span>%s', 'designer' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$raw = '<span class="posted-on">';
            if( $icon == 'yes' ):
                $raw .= '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>';
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
}

