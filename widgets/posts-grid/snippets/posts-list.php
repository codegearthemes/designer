<?php

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
<div class="block--posts-grid">
    <div class="grid <?php echo esc_attr( $settings['layout'] ); ?>">
        <?php
        while ( $query->have_posts() ) : $query->the_post();
            $categories = get_the_category( get_the_ID() ); ?>
            <div class="grid__item one-whole post-item">
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-grid-list'); ?>>
                    <div class="content">
                        <?php if ( has_post_thumbnail() && $settings['featured_image_default'] == 'yes' ) { ?>
                            <div class="image-left">
                                <a href="<?php echo esc_url( get_permalink() ) ?>" title="<?php get_the_title(); ?>">
                                    <?php the_post_thumbnail( '850x' );  ?>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="post-content content-right text-<?php echo esc_attr( $settings['alignment'] ); ?>">
                            <?php
                                if ( ! empty( $categories ) && $settings['show_cat'] == 'yes' ) { ?>
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
                                        the_excerpt();
                                    echo '</div>';
                                endif;
                            ?>
                        </div>
                    </div>
                </article>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>
