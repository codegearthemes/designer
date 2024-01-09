(function($){
    'use strict';
    const videoPopup = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block--video-popup-wrapper').each(function(){
                var id = $(this).data('selector');
                var lightbox = GLightbox({
                    touchNavigation: true,
                    loop: false,
                    autoplayVideos: true,
                    selector: '#block_video_popup_'+ id + ' ' + '.video-glightbox',

                });
            })
        }
    }

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/designer-video-popup.default', videoPopup );
    });

})(jQuery);
