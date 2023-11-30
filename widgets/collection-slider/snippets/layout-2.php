<?php
use Designer\Includes\Helper;
foreach ( $settings['collections'] as $collection ):
    if( !empty( $collection['collection'] ) ):
        $term = get_term_by( 'slug', $collection['collection'], 'product_cat' );
        $product_count = $term->count;
        $thumbnail_id = get_term_meta( $collection['collection'], 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id );
        $image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );

        if( $collection['image'] ):
            $this->add_render_attribute( 'image', 'src', $collection['image']['url'] );
            $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $collection['image'] ) );
            $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $collection['image'] ) );
            $this->add_render_attribute( 'image', 'class', 'image' );
        endif;


        if( $collection['image_hover_enable'] && $collection['image_hover'] ):
            $this->add_render_attribute( 'image_hover', 'src', $collection['image_hover']['url'] );
            $this->add_render_attribute( 'image_hover', 'alt', \Elementor\Control_Media::get_image_alt( $collection['image_hover'] ) );
            $this->add_render_attribute( 'image_hover', 'title', \Elementor\Control_Media::get_image_title( $settings['image_hover'] ) );
            $this->add_render_attribute( 'image_hover', [ 'class' => ['image_hover'] ] );
        endif; 
        
        ?>
        <div class="collection-slide swiper-slide">
            <div class="collection-inner">
                <div class="collection-image__text">
                    <a class="block-collection__link <?php if( $collection['image_hover_enable'] ){ echo 'has-hover__image'; } ?>" href="<?php echo esc_url( get_term_link( $collection['collection'], 'product_cat' ) ); ?>">
                        <?php if ($collection['image'] ): ?>
                            <div class="collection-image">
                                <?= \Elementor\Group_Control_Image_Size::get_attachment_image_html($collection, 'thumbnail', 'image'); ?>
                                <?php if( $collection['image_hover_enable'] && $collection['image_hover'] ): ?>
                                    <?= \Elementor\Group_Control_Image_Size::get_attachment_image_html($collection, 'thumbnail', 'image_hover'); ?>
                                <?php endif; ?>
                            </div>
                        <?php else : ?>
                            <?php if (!empty($image)) : ?>
                                <div class="collection-image">
                                    <img class="image" loading="lazy" src="<?php echo esc_url($image); ?>" srcset="<?php echo esc_attr($image_srcset); ?>" title="<?php echo esc_html($term->name); ?>" alt="<?php echo esc_html($term->name); ?>" />
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="caption">
                            <div class="caption-inner">
                                <?php if('no' === $settings['link_label_category_title']):?>
                                    <h2 class="title"><?php echo esc_html($term->name); ?></h2>
                                <?php endif;?>

                                <div class="block-action__advanced">
                                    <span <?php echo $this->get_render_attribute_string('button_attribute');?> >
                           
                                        <span class="label">
                                            <?php if('yes' === $settings['link_label_category_title']):?>
                                                <?php echo esc_html($term->name); ?>
                                            <?php else: ?>
                                                <?php echo esc_html( $collection['button_label'] ) ?>
                                            <?php endif;?>
                                        </span>
                           
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
                                            <?php echo Helper::instance()->render_button_inner_border($settings); ?>
                                        <?php endif;?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <?php
    endif;
endforeach;
