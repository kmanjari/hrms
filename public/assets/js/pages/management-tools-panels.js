'use strict';
//  Author: ThemeREX.com
//  management-tools-panels.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();


        // Init Spec Panels
        $('.allcp-panels').allcppanel({
            grid: '.allcp-grid',
            draggable: true,
            mobile: false,
            callback: function() {
                bootbox.confirm('<h3>A Custom Callback!</h3>', function() {});
            },
            onFinish: function() {
                $('.allcp-panels').addClass('animated fadeIn').removeClass('fade-onload');

                $('#p1 .panel-control-title').click();

                // Add example spec panel filter
                $('#allcp-panel-filter a').on('click', function() {
                    var This = $(this);
                    var Value = This.attr('data-filter');

                    // Toggle matching elements by attr
                    $('.allcp-filter-panels').find($(Value)).each(function(i, e) {
                        if (This.hasClass('active')) {
                            $(this).slideDown('fast').removeClass('panel-filtered');
                        } else {
                            $(this).slideUp().addClass('panel-filtered');
                        }
                    });
                    This.toggleClass('active');
                });

            },
            onSave: function() {
                $(window).trigger('resize');
            }
        });
    });

})(jQuery);
