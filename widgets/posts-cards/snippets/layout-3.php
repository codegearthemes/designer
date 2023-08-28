<?php

$count = 0;
$categories = $settings['categories'];
$args = [
    'posts_per_page' => $settings['post_per_page'],
];
if( !empty(  $categories ) && is_array( $categories ) ){
	$args = [
		'posts_per_page' => $settings['post_per_page'],
		'category_name' => implode( ',', $categories )
	];
}

$query = new \WP_Query($args);

?>
<div class="block--posts-items">
    <div class="grid <?php echo esc_attr( $settings['layout'] ); ?>">
        <?php
            while ( $query->have_posts() ) : $query->the_post();
                $categories = get_the_category( get_the_ID() ); ?>
                    <div class="grid__item <?php if( $count == 0 ){ echo esc_attr( 'one-whole alpha-block '.$settings['featured_style'] ); }else{ echo esc_attr( 'large--one-half medium--one-half small--one-whole omega-block' ); } ?>">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-grid'); ?>>
                            <div class="content">
                                <?php if( $count < 1 ): ?>
                                    <?php if ( $settings['featured_image'] == 'yes' && has_post_thumbnail() ) { ?>
                                        <div class="media-image">
                                            <a href="<?php echo esc_url( get_permalink() ) ?>" title="<?php get_the_title(); ?>">
                                                <?php the_post_thumbnail( 'large' );  ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                <?php else: ?>
                                    <?php if ( $settings['featured_image_general'] == 'yes' && has_post_thumbnail() ) { ?>
                                        <div class="media-image">
                                            <a href="<?php echo esc_url( get_permalink() ) ?>" title="<?php get_the_title(); ?>">
                                                <?php the_post_thumbnail( 'large' );  ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                <?php endif; ?>
                                <div class="post-content">
                                    <div class="entry-header">
                                        <?php
                                            if ( ! empty( $categories ) && $settings['show_cat_general'] == 'yes' && $count > 0 ) { ?>
                                                <div class="categories">
                                                    <?php
                                                        foreach( $categories as $key => $category ) {
                                                            if( $key < $settings['cat_limit_general'] ){
                                                                $meta = get_term_meta( $category->term_id, '_taxonomy_options', true ); ?>
                                                                <a class="entry-term" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'designer' ), $category->name ) ); ?>">
                                                                    <?php echo esc_html( $category->name ); ?>
                                                                </a>
                                                            <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            <?php
                                            }elseif( !empty( $categories ) && $settings['show_cat'] == 'yes' ) { ?>
                                                <div class="categories">
                                                    <?php
                                                        foreach( $categories as $key => $category ) {
                                                            if( $key < $settings['cat_limit'] ){
                                                                $meta = get_term_meta( $category->term_id, '_taxonomy_options', true ); ?>
                                                                <a class="entry-term" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'designer' ), $category->name ) ); ?>">
                                                                    <?php echo esc_html( $category->name ); ?>
                                                                </a>
                                                            <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
                                        ?>
                                        <?php if( $count < 1 ): ?>
                                            <?php if( $settings['date'] == 'yes'|| $settings['author'] == 'yes' ): ?>
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
                                        <?php else: ?>
                                            <?php if( $settings['date_general'] == 'yes' || $settings['author_general'] == 'yes' ): ?>
                                                <div class="meta-data">
                                                    <?php
                                                        $icon = isset( $settings['meta_icons_general'] ) ? $settings['meta_icons_general'] : 'no';
                                                        if( $settings['author_general'] == 'yes' ){
                                                            \Designer\Includes\Helper::instance()->author( $icon );
                                                        }

                                                        if( $settings['date_general'] == 'yes' ){
                                                            \Designer\Includes\Helper::instance()->posted_on( $icon );
                                                        }
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if( $count < 1 ): ?>
                                        <?php
                                            if( $settings['show_excerpt'] == 'yes' ):
                                                echo '<div class="entry-content">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                    the_excerpt();
                                                echo '</div>';
                                            endif;
                                        ?>
                                    <?php else: ?>
                                        <?php
                                            if( $settings['show_excerpt_general'] == 'yes' ):
                                                echo '<div class="entry-content">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                    the_excerpt();
                                                echo '</div>';
                                            endif;
                                        ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php
                $count++;
            endwhile;
        wp_reset_postdata(); ?>
    </div>
</div>
