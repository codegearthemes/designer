<div class="team-inner">  
    <div class="image-wrapper">

        <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>

        <?php

        if( 'yes' === $settings['show_secondary_image']):?>
            <div class="secondary-image">
                <?php  
                    // Secondary Image
                    echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'secondary_image' ); 
                ?>
            </div>
        <?php endif;?>
    </div>
    <?php
    if ($settings['name'] || $settings['position']) : ?>
        <div class="rte-content">
            <?php if (!empty($settings['name'])) : ?>
                <h3 class="name"><?php echo esc_attr($settings['name']); ?></h3>
            <?php endif; ?>
            <?php if (!empty($settings['position'])) : ?>
                <p class="position"><?php echo esc_attr($settings['position']); ?></p>
            <?php endif; ?>

            <?php if (!empty($settings['profiles'])) : ?>
                <ul class="profiles">
                    <?php foreach ($settings['profiles'] as $profile) : ?>
                        <li class="social-item">
                            <a class="icon-link" href="<?php echo esc_url($profile['link']['url']); ?>" title="<?php echo esc_attr($profile['title']); ?>" target="_blank">
                                <?php \Elementor\Icons_Manager::render_icon($profile['icon'], ['aria-hidden' => 'true']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    <?php endif; ?>
</div>


