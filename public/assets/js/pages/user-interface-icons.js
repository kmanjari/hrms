'use strict';
//  Author: ThemeREX.com
//  user-interface-icons.html scripts
//

(function ($) {

    $(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Filter Icons
        function iconHide(iconVal) {
            $(".tab-pane.active .icons-list > li").hide();
            $('.tab-pane.active .icons-list > li > span[class*="' + iconVal + '"]').parent().show();
        }

        $("#icon-filter").keyup(function () {
            var iconVal = $.trim(this.value);
            if (iconVal === "") {
                return
            } else {
                iconHide(iconVal);
            }
        });
        $("#icon-tabs > li > a").on('click', function () {
            $("#icon-filter").val('');
            $(".icons-list > li").show();
        });
    });

})(jQuery);
