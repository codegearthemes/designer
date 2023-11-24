(function( $ ){

	'use strict';

    const blockProgressBar = ( $scope, $) => {
        if( $scope.length > 0){
            var $progressBar = $scope.find( '.designer-progress-bar' ),
            prBarCircle = $scope.find( '.designer-prbar-circle' ),
            $prBarCircleSvg = prBarCircle.find('.designer-prbar-circle-svg'),
            $prBarCirclePrline = $scope.find( '.designer-prbar-circle-prline' ),
            prBarHrLine = $progressBar.find('.designer-prbar-hr-line-inner'),
            prBarVrLine = $progressBar.find('.designer-prbar-vr-line-inner'),
            prBarOptions = $progressBar.data('options'),
            prBarCircleOptions = prBarCircle.data('circle-options'),
            prBarCounter = $progressBar.find('.designer-prbar-counter-value'),
            prBarCounterValue = prBarOptions.counterValue,
            prBarCounterValuePercent = prBarOptions.counterValuePercent,
            prBarAnimDuration = prBarOptions.animDuration,
            prBarAnimDelay = prBarOptions.animDelay,
            prBarLoopDelay = +prBarOptions.loopDelay,
            numeratorData = {
                toValue: prBarCounterValue,
                duration: prBarAnimDuration,
            };

            if ( 'yes' === prBarOptions.counterSeparator ) {
				numeratorData.delimiter = ',';
			}

            function isInViewport( $selector ) {
				if ( $selector.length ) {
					var elementTop = $selector.offset().top,
					elementBottom = elementTop + $selector.outerHeight(),
					viewportTop = $(window).scrollTop(),
					viewportBottom = viewportTop + $(window).height();

					if ( elementTop > $(window).height() ) {
						elementTop += 50;
					}

					return elementBottom > viewportTop && elementTop < viewportBottom;
				}
			};

            function progressBar() {

				if ( isInViewport( prBarVrLine ) ) {
					prBarVrLine.css({
						'height': prBarCounterValuePercent + '%'
					});
				}

				if ( isInViewport( prBarHrLine ) ) {
					prBarHrLine.css({
						'width': prBarCounterValuePercent + '%'
					});
				}

				if ( isInViewport( prBarCircle ) ) {
					var circleDashOffset = prBarCircleOptions.circleOffset;
					
					$prBarCirclePrline.css({
						'stroke-dashoffset': circleDashOffset
					});
				}

				// Set Delay
				if ( isInViewport( prBarVrLine ) || isInViewport( prBarHrLine ) || isInViewport( prBarCircle ) ) {
					setTimeout(function() {
						prBarCounter.numerator( numeratorData );
					}, prBarAnimDelay );
				}
			
			}

			progressBar();

			if (prBarOptions.loop === 'yes') {
				setInterval(function() {

					if ( isInViewport( prBarVrLine ) ) {
						prBarVrLine.css({
							'height': 0 + '%'
						});
					}
	
					if ( isInViewport( prBarHrLine ) ) {
						prBarHrLine.css({
							'width': 0 + '%'
						});
					}
	
					if ( isInViewport( prBarCircle ) ) {
						var circleDashOffset = prBarCircleOptions.circleOffset;
						
						$prBarCirclePrline.css({
							'stroke-dashoffset': $prBarCirclePrline.css('stroke-dasharray')
						});
					}

					// Set Delay
					if ( isInViewport( prBarVrLine ) || isInViewport( prBarHrLine ) || isInViewport( prBarCircle ) ) {
						setTimeout(function() {
							prBarCounter.numerator( {
								toValue: 0,
								duration: prBarAnimDuration,
							} );
						}, prBarAnimDelay);
					}

					setTimeout(function() {
						progressBar();
					}, prBarAnimDuration + prBarAnimDelay);
				}, (prBarAnimDuration + prBarAnimDelay) * prBarLoopDelay);
			}

			$(window).on('scroll', function() {
				progressBar();
			});

        }
    }




    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/progress-bar.default', blockProgressBar );
    });

})(jQuery);
