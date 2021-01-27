'use strict';
//  Author: ThemeREX.com
//  sale-stats-client.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Select List
        var selectList = $('.allcp-form select');
        selectList.each(function(i, e) {
            $(e).on('change', function() {
                if ($(e).val() == "0") $(e).addClass("empty");
                else $(e).removeClass("empty")
            });
        });
        selectList.each(function(i, e) {
            $(e).change();
        });

        // Init TagsInput
        $("input#tagsinput").tagsinput({
            tagClass: function(item) {
                return 'label label-default';
            }
        });

        $("#datepicker1").datepicker({
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: false,
            beforeShow: function(input, inst) {
                var newclass = 'allcp-form';
                var themeClass = $(this).parents('.allcp-form').attr('class');
                var smartpikr = inst.dpDiv.parent();
                if (!smartpikr.hasClass(themeClass)) {
                    inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
                }
            }
        });

        $("#datepicker2").datepicker({
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: false,
            beforeShow: function(input, inst) {
                var newclass = 'allcp-form';
                var themeClass = $(this).parents('.allcp-form').attr('class');
                var smartpikr = inst.dpDiv.parent();
                if (!smartpikr.hasClass(themeClass)) {
                    inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
                }
            }
        });
    });

})(jQuery);
