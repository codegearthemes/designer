(function( $ ){

	'use strict';

    const blockImageHotspots = ( $scope, $) => {
        if( $scope.length > 0){
            var $imgHotspots = $scope.find( '.designer-image-hotspots' ),
            hotspotsOptions = $imgHotspots.data('options'),
            $hotspotItem = $imgHotspots.find('.designer-hotspot-item'),
            tooltipTrigger = hotspotsOptions.tooltipTrigger;

            if ( 'click' === tooltipTrigger ) {
                $hotspotItem.on( 'click', function(event) {
                    if ( $(this).hasClass('designer-tooltip-active') ) {
                        $(this).removeClass('designer-tooltip-active');
                    } else {
                        $hotspotItem.removeClass('designer-tooltip-active');
                        $(this).addClass('designer-tooltip-active');
                    }
                    event.stopPropagation();
                });

                $(window).on( 'click', function () {
                    $hotspotItem.removeClass('designer-tooltip-active');
                });
        
            } else if ( 'hover' === tooltipTrigger ) {
                $hotspotItem.hover(function () {
                    $(this).toggleClass('designer-tooltip-active');
                });

            } else {
                $hotspotItem.addClass('designer-tooltip-active');
            }

        }

    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/designer-image-hotspots.default', blockImageHotspots );
    });

})(jQuery);