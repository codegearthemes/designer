<?php

use Designer\Includes\Helper;

$collection = $settings['collection'];

$term = get_term_by( 'slug', $collection, 'product_cat' );
$product_count = $term->count;
$thumbnail_id = get_term_meta( $collection, 'thumbnail_id', true );
$image = wp_get_attachment_url( $thumbnail_id );
$image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );

if( $settings['image'] ):
    $this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
    $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image'] ) );
    $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $settings['image'] ) );
    $this->add_render_attribute( 'image', 'class', 'image' );
endif;


if( $settings['image_hover_enable'] && $settings['image_hover'] ):
    $this->add_render_attribute( 'image_hover', 'src', $settings['image_hover']['url'] );
    $this->add_render_attribute( 'image_hover', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image_hover'] ) );
    $this->add_render_attribute( 'image_hover', 'title', \Elementor\Control_Media::get_image_title( $settings['image_hover'] ) );
    $this->add_render_attribute( 'image_hover', [ 'class' => ['image_hover'] ] );
endif;

?>

<div class="collection-inner">
    <div class="collection-image__text">
        <a class="block-collection__link <?php if( $settings['image_hover_enable'] ){ echo 'has-hover__image'; } ?>" href="<?php echo esc_url( get_term_link( $collection, 'product_cat' ) ); ?>">
            <?php if ($settings['image'] ): ?>
                <div class="collection-image">
                    <?= \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image'); ?>
                    <?php if( $settings['image_hover_enable'] && $settings['image_hover'] ): ?>
                        <?= \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image_hover'); ?>
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
                                    <?php echo esc_html( $settings['button_label'] ) ?>
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
