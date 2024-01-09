(function( $ ){

	'use strict';

    const postCarousel = ($scope, $) => {
        if ($scope.length > 0) {
            $('.block--posts-carousel').each(function () {
                var id = $(this).data('selector'),
                config = $(this).data('config');
                var $element = $('#block_postscarousel_' + id); 
                // Initialize Swiper
                var swiper = new Swiper('#block_postscarousel_' + id, config);

                var sliderSwiper = document.querySelector('#block_postscarousel_' + id).swiper;
    
                if (config.pauseOnHover === true) {
                    $element.mouseenter(function () {
                        sliderSwiper.autoplay.stop();
                    });
    
                    $element.mouseleave(function () {
                        sliderSwiper.autoplay.start();
                    });
                }
    
                // Add the 'designer-swiper-initialized' class after Swiper initialization
                $element.addClass('designer-swiper--initialized');
    
            });
        }
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/designer-posts-carousel.default', postCarousel );
    });

})(jQuery);
