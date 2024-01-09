(function ($) {
    const blockPromoBox = ($scope, $) => {
        if ($scope.length > 0) {
            $(document).ready(function () {
                designerPromoBoxReveal.init();
            });

            var designerPromoBoxReveal = {
                init: function () {
                    this.holder = $('.designer-promo-box');

                    if (this.holder.length) {
                        this.holder.each(function () {
                            designerPromoBoxReveal.initItem($(this));
                        });
                    }
                },
                initItem: function ($currentItem) {
                    if ($currentItem.hasClass('designer--reveal-content')) {
                        var $text = $currentItem.find('.designer-promo-box-content');
                        var $description = $currentItem.find('.designer-promo-box-content > .designer-promo-box-description');
                        var $button = $currentItem.find('.designer-promo-box-btn-wrap');
                        var textHeight = $description.outerHeight(true);
                        $text.css(
                            'transform',
                            'translateY(' + textHeight + 'px) translateZ(0)'
                        );
                        if ($button.length > 0) { 
                            var totalHeight = $description.outerHeight(true) + $button.outerHeight(true);
                            $text.css(
                                'transform',
                                'translateY(' + totalHeight + 'px) translateZ(0)'
                            );
                        }
                       
                    }
                }
            };
        }
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/designer-promo-box.default', blockPromoBox);
    });
})(jQuery);
