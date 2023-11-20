(function ($) {

    const blockHorizontalTabs = ($scope, $) => {
      if ($scope.length > 0) {
  
        $(document).ready(function () {
          designerTabsHorizontal.init();
        });
  
        var designerTabsHorizontal = {
          init: function () {
            this.holder = $('.designer-tabs-horizontal');
  
            if (this.holder.length) {
              this.holder.each(function () {
                designerTabsHorizontal.initItems($(this));
              });
            }
          },
          initItems: function ($tabs) {
            $tabs.children('.designer-tabs-horizontal-content').each(function (index) {
              index = index + 1;
  
              var $that = $(this),
                link = $that.attr('id'),
                $navItem = $that.parent().find('.designer-tabs-horizontal-navigation li:nth-child(' + index + ') a'),
                navLink = $navItem.attr('href');
  
              link = '#' + link;
  
              if (link.indexOf(navLink) > -1) {
                $navItem.attr('href', link);
              }
            });
  
            $tabs.addClass('designer--init').tabs();
  
            // Add click event to the "designer-next-tab-button" element
            $tabs.find('.designer-next-tab-button').on('click', function () {
              var currentTab = $tabs.tabs('option', 'active');
              var totalTabs = $tabs.find('.designer-tabs-horizontal-navigation li').length;
              var nextTab = (currentTab + 1) % totalTabs;
  
              $tabs.tabs('option', 'active', nextTab);
            });
          }
        };
  
      }
    }
  
    $(window).on('elementor/frontend/init', function () {
      elementorFrontend.hooks.addAction('frontend/element_ready/tabs-horizontal.default', blockHorizontalTabs);
    });
  
})(jQuery);
  