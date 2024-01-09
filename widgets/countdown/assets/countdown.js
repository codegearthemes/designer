(function($){
    'use strict';
    const countDownTimer = ($scope, $) => {
        if( $scope.length > 0 ){

            $( document ).ready(
                function () {
                    designerCountdown.init();
                }
            );
           
            var designerCountdown = {
                init: function () {
                    this.countdowns = $( '.block--countdown-wrapper' );
        
                    if ( this.countdowns.length ) {
                        this.countdowns.each(
                            function () {
                                designerCountdown.initItem( $( this ) );
                            }
                        );
                    }
                },
                initItem: function( $currentItem ) {
                    var $countdownElement = $currentItem.find( '.designer-countdown' ),
                        options           = designerCountdown.generateOptions( $currentItem );
        
                        designerCountdown.initCountdown(
                        $countdownElement,
                        options
                    );
                },
                generateOptions: function ( $countdown ) {
                    var options  = {};
                    options.date = typeof $countdown.data( 'date' ) !== 'undefined' ? $countdown.data( 'date' ) : null;
                    options.hide = typeof $countdown.data( 'hide' ) !== 'undefined' ? $countdown.data( 'hide' ) : null;
        
                    options.monthLabel        = typeof $countdown.data( 'month-label' ) !== 'undefined' ? $countdown.data( 'month-label' ) : 'Month';
                    options.monthLabelPlural  = typeof $countdown.data( 'month-label-plural' ) !== 'undefined' ? $countdown.data( 'month-label-plural' ) : 'Months';
                    options.dayLabel          = typeof $countdown.data( 'day-label' ) !== 'undefined' ? $countdown.data( 'day-label' ) : 'Day';
                    options.dayLabelPlural    = typeof $countdown.data( 'day-label-plural' ) !== 'undefined' ? $countdown.data( 'day-label-plural' ) : 'Days';
                    options.hourLabel         = typeof $countdown.data( 'hour-label' ) !== 'undefined' ? $countdown.data( 'hour-label' ) : 'Hour';
                    options.hourLabelPlural   = typeof $countdown.data( 'hour-label-plural' ) !== 'undefined' ? $countdown.data( 'hour-label-plural' ) : 'Hours';
                    options.minuteLabel       = typeof $countdown.data( 'minute-label' ) !== 'undefined' ? $countdown.data( 'minute-label' ) : 'Minute';
                    options.minuteLabelPlural = typeof $countdown.data( 'minute-label-plural' ) !== 'undefined' ? $countdown.data( 'minute-label-plural' ) : 'Minutes';
                    options.secondLabel       = typeof $countdown.data( 'second-label' ) !== 'undefined' ? $countdown.data( 'second-label' ) : 'Second';
                    options.secondLabelPlural = typeof $countdown.data( 'second-label-plural' ) !== 'undefined' ? $countdown.data( 'second-label-plural' ) : 'Seconds';
        
                    return options;
                },
                initCountdown: function ( $countdownElement, options ) {
                    var countDownDate = new Date( options.date ).getTime();
        
                    // Update the count down every 1 second
                    var x = setInterval(
                        function () {
        
                            // Get today's date and time
                            var now = new Date().getTime();
        
                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;

        
                            // Time calculations for days, hours, minutes and seconds
                            var months  = Math.floor( distance / (1000 * 60 * 60 * 24 * 30) );
                            var days    = Math.floor( (distance % (1000 * 60 * 60 * 24 * 30)) / (1000 * 60 * 60 * 24) );
                            var hours   = Math.floor( (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60) );
                            var minutes = Math.floor( (distance % (1000 * 60 * 60)) / (1000 * 60) );
                            var seconds = Math.floor( (distance % (1000 * 60)) / 1000 );
        
                            if ( 'hide-months' === options.hide ) {
                                days = Math.floor( distance / (1000 * 60 * 60 * 24) );
                            }

                            var $monthsHolder  = $countdownElement.find( '.digit-months' );
                            var $daysHolder    = $countdownElement.find( '.digit-days' );
                            var $hoursHolder   = $countdownElement.find( '.digit-hours' );
                            var $minutesHolder = $countdownElement.find( '.digit-minutes' );
                            var $secondsHolder = $countdownElement.find( '.digit-seconds' );
        
                            $monthsHolder.find( '.designer-label' ).html( ( 1 === months ) ? options.monthLabel : options.monthLabelPlural );
                            $daysHolder.find( '.designer-label' ).html( ( 1 === days ) ? options.dayLabel : options.dayLabelPlural );
                            $hoursHolder.find( '.designer-label' ).html( ( 1 === hours ) ? options.hourLabel : options.hourLabelPlural );
                            $minutesHolder.find( '.designer-label' ).html( ( 1 === minutes ) ? options.minuteLabel : options.minuteLabelPlural );
                            $secondsHolder.find( '.designer-label' ).html( ( 1 === seconds ) ? options.secondLabel : options.secondLabelPlural );
        
                            months  = (months < 10) ? '0' + months : months;
                            days    = (days < 10) ? '0' + days : days;
                            hours   = (hours < 10) ? '0' + hours : hours;
                            minutes = (minutes < 10) ? '0' + minutes : minutes;
                            seconds = (seconds < 10) ? '0' + seconds : seconds;
        
                            $monthsHolder.find( '.designer-digit' ).html( months );
                            $daysHolder.find( '.designer-digit' ).html( days );
                            $hoursHolder.find( '.designer-digit' ).html( hours );
                            $minutesHolder.find( '.designer-digit' ).html( minutes );
                            $secondsHolder.find( '.designer-digit' ).html( seconds );
        
                            // If the count down is finished, write some text
                            if ( distance < 0 ) {
                                clearInterval( x );
                                $monthsHolder.find( '.designer-label' ).html( options.monthLabelPlural );
                                $daysHolder.find( '.designer-label' ).html( options.dayLabelPlural );
                                $hoursHolder.find( '.designer-label' ).html( options.hourLabelPlural );
                                $minutesHolder.find( '.designer-label' ).html( options.minuteLabelPlural );
                                $secondsHolder.find( '.designer-label' ).html( options.secondLabelPlural );
        
                                $monthsHolder.find( '.designer-digit' ).html( '00' );
                                $daysHolder.find( '.designer-digit' ).html( '00' );
                                $hoursHolder.find( '.designer-digit' ).html( '00' );
                                $minutesHolder.find( '.designer-digit' ).html( '00' );
                                $secondsHolder.find( '.designer-digit' ).html( '00' );

                                // Actions
                                expiredActions();
                            }
                        },
                        1000
                    );

                    function expiredActions(){
                        var countDownWrap = $scope.children('.elementor-widget-container').children('.block--countdown-wrapper');
                        var dataExpiredActions = countDownWrap.data('actions');
                        
                        if(dataExpiredActions.hasOwnProperty('hide-timer')){
                            countDownWrap.hide();
                        }

                        if(dataExpiredActions.hasOwnProperty('hide-element')){
                            $( dataExpiredActions['hide-element'] ).hide();
                        }

                        if ( dataExpiredActions.hasOwnProperty( 'message' ) ) {
                            if ( ! $scope.children( '.elementor-widget-container' ).children( '.designer-countdown-message' ).length ) {
                                countDownWrap.after( '<div class="designer-countdown-message">'+ dataExpiredActions['message'] +'</div>' );
                            }
                        }
                    
                        if ( dataExpiredActions.hasOwnProperty( 'redirect' ) ) {
                            window.location.href = dataExpiredActions['redirect'];
                        }

                    }
                }
            };

        }
    }
    
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/designer-countdown.default', countDownTimer );
    });

})(jQuery);