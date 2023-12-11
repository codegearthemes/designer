<div class="designer-icon-wrapper">
    <div class="designer-icon-holder">
        <?php \Elementor\Icons_Manager::render_icon( $settings['icon_type'], [ 'aria-hidden' => 'true' ] );  ?>
    </div>
</div>
<div class="designer-content">
    <?php if ( ! empty( $settings['title']  ) ) : ?>
        <<?php echo esc_attr( $settings['title_tag'] ); ?> class="designer-title">
            <?php if ( ! empty( $link_url ) ) : ?>
                <a <?php echo $this->get_render_attribute_string( 'link_attribute' ); ?> >
            <?php endif; ?>
                <span class="designer-title-text"><?php echo esc_html( $settings['title'] ); ?></span>
            <?php if ( ! empty( $link_url ) ) : ?>
                </a>
            <?php endif; ?>
        </<?php echo esc_attr( $settings['title_tag'] ); ?>>
    <?php endif;?>
    <?php if( 'yes' === $settings['enable_separator']):?>
        <div class="designer-separator designer-clear">
            <div class="<?php echo $this->get_separator_classes($settings);?>">

                <?php if( 'standard' === $settings['separator_layout']):?>
                    <div class="designer-line"></div>
                <?php endif;?>

                <?php if( 'border-image' === $settings['separator_layout']):
                    $border_image_src = $settings['separator_border_image']['url'];   
                ?>
                    <div class="designer-line" <?php if( $border_image_src ) { echo 'style="background-image:url('.$border_image_src.')"'; } ?> ></div>
                <?php endif;?>

                <?php if( 'with-icon' === $settings['separator_layout']):?>
                    <div class="designer-line">
                        <div class="designer-inner-line"></div>
                        <?php if ( isset( $settings['separator_icon'] ) && ! empty( $settings['separator_icon']['value'] ) ) : ?>
                            <div class="designer-separator-icon">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['separator_icon'], [ 'aria-hidden' => 'true' ] );  ?>
                            </div>
                        <?php endif;?>
                            
                        <div class="designer-inner-line"></div>
                    </div>
                <?php endif;?>
                
            </div>

        </div>
    <?php endif;?>
    

    <?php if ( ! empty( $settings['text'] ) ) : ?>
	    <div class="designer-text"><?php echo wp_kses_post( $settings['text'] ); ?></div>
    <?php endif; ?>

    <div class="block-action__advanced">
        <a <?php echo $this->get_render_attribute_string('button_attribute');?> >
            <?php if( $settings['button_label'] != '' ): ?>
                <span class="label">
                    <?php echo esc_html( $settings['button_label'] ) ?>
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
                <?php echo \Designer\Includes\Helper::instance()->render_button_inner_border($settings); ?>
            <?php endif;?>
        </a>
    </div>


</div>