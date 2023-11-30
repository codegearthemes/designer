(function( $ ){

	'use strict';

    const collectionSlider = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block-collection__slider').each(function(){
                var id = $(this).data('selector'),
                config = $(this).data('config');
                var $element = $('#block_collection__' + id); 
                // Initialize Swiper
                var swiper = new Swiper('#block_collection__' + id, config);

                var sliderSwiper = document.querySelector('#block_collection__' + id).swiper;
    
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
    
            })
        }
    }

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/collection-slider.default', collectionSlider );
    });

})(jQuery);
