(function( $ ){

	'use strict';

    const postCarousel = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block--posts-carousel').each(function(){
                var id = $(this).data('selector'),
                config = $(this).data('config');
                new Swiper( '#block_postscarousel_'+id, config );
            })
        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/posts-carousel.default', postCarousel );
    });

})(jQuery);
