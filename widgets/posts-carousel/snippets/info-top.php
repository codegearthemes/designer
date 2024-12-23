<article id="post-<?php the_ID(); ?>" <?php post_class('post-grid-list'); ?>>
    <div class="content">
    <div class="post-content">
            <?php
                if ( ! empty( $categories ) && $settings['show_cat'] == 'yes' ) { ?>
                    <div class="categories">
                        <?php 
                            foreach( $categories as $key => $category ) {
                                if( $key < $settings['cat_limit'] ){
                                    $meta = get_term_meta( $category->term_id, '_taxonomy_options', true );
                                    // Translators: %s is the category name ?>
                                    <a class="entry-term" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'designer' ), esc_html( $category->name ) ) ); ?>">
                                        <?php echo esc_html( $category->name ); ?>
                                    </a>
                                <?php 
                                }
                            } 
                        ?>
                    </div>
                    <?php
                }
                the_title( '<h3 class="entry-title h4"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
            ?>
            <?php if( $settings['date'] || $settings['author'] ): ?>
                <div class="meta-data">
                    <?php
                        $icon = isset( $settings['meta_icons'] ) ? $settings['meta_icons'] : 'no';
                        if( $settings['author'] == 'yes' ){
                            \Designer\Includes\Helper::instance()->author( $icon );
                        }

                        if( $settings['date'] == 'yes' ){
                            \Designer\Includes\Helper::instance()->posted_on( $icon );
                        }
                    ?>
                </div>
            <?php endif; ?>
            <?php
                if( $settings['show_excerpt'] == 'yes' ):
                    echo '<div class="entry-content">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        echo wp_trim_words( get_the_excerpt(), $excerpt_length );
                    echo '</div>';
                endif;
            ?>
            <?php if('yes' === $settings['show_button']):?>
                <div class="block-action__advanced">
                    <a <?php echo $this->get_render_attribute_string('button_attribute');?> href="<?php echo esc_url( get_permalink() ) ?>" >
                        <?php if( $readmore__button_label ): ?>
                            <span class="label">
                                <?php echo esc_html( $readmore__button_label ) ?>
                            </span>
                        <?php endif; ?>
                        <?php if( 'yes'	===	$settings['show_icon_sidebar']):?>
                            <span class="designer-m-border"></span>
                        <?php endif; ?>
                        <?php if ( $settings['button_icon_enable'] == 'yes' ): ?>
                            <span class="designer-m-icon" <?php echo esc_attr($icon_box_style);?> >
                                <span class="designer-m-icon-inner">
                                    <?php
                                        \Elementor\Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] );
                                        if($settings['button_icon_move'] !== 'move-horizontal-short' && $settings['button_icon_move'] !== ''){
                                            \Elementor\Icons_Manager::render_icon( $settings['button_arrow_icon'], [ 'aria-hidden' => 'true' ] );
                                        }
                                    ?>
                                </span>
                            </span>
                        <?php endif; ?>

                        <?php if( $settings['button_type'] === 'inner-border'):?>
                            <?php echo \Designer\Includes\Helper::instance()->render_button_inner_border($settings);?>
                        <?php endif;?>
                    </a>
                </div>
            <?php endif;?>
        </div>
        <?php if ( has_post_thumbnail() && $settings['featured_image_default'] == 'yes' ) { ?>
            <div class="media-image">
                <a href="<?php echo esc_url( get_permalink() ) ?>" title="<?php get_the_title(); ?>">
                    <?php the_post_thumbnail( 'full' );  ?>
                </a>
            </div>
        <?php } ?>
    </div>
</article>
 


