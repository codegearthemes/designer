<div class="designer-process-text-wrapper">
    <?php if( !empty( $process['title'])):?>
        <<?php echo esc_attr( $item_title_tag ); ?> class = "designer-process-title"><?php echo esc_html( $process['title'] );?></<?php echo esc_attr( $item_title_tag ); ?>>
    <?php endif;?>

    <?php if( !empty( $process['content'] ) ): ?>
        <p class= "designer-process-text"><?php echo esc_html( $process['content'] ); ?></p>
    <?php endif;?>
</div>