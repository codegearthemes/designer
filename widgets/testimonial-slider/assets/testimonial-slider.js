(function ($) {

    'use strict';

    const testimonialSlider = ($scope, $) => {
        if ($scope.length > 0) {
            $('.block--testimonial-slider').each(function () {
                var id = $(this).data('selector'),
                    config = $(this).data('config');

                if ( $(this).hasClass('testimonial-number-pagination')) {
                    config.pagination = {
                        el: '.swiper-pagination-' + id,
                        clickable: true,
                        renderBullet: function (index, className) {
                            return '<span class="' + className + '">' + (index + 1) + "</span>";
                        },
                    };
                }

                // Initialize Swiper
                var swiper = new Swiper('#testimonial_slider_' + id, config);
            });
        }
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/testimonial-slider.default', testimonialSlider);
    });

})(jQuery);
