(function( $ ){

	'use strict';

    const productSlider = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block-products__carousel').each(function(){
                var id = $(this).data('selector'),
                    config = $(this).data('config');
                    var $element = $('#products_slider_' + id); 
                    // Initialize Swiper
                    var swiper = new Swiper('#products_slider_' + id, config);
                    var sliderSwiper = document.querySelector('#products_slider_' + id).swiper;
    
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
        elementorFrontend.hooks.addAction( 'frontend/element_ready/products-slider.default', productSlider );
    });

})(jQuery);
