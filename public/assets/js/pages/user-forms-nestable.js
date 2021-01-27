'use strict';
//  Author: ThemeREX.com
//  user-forms-nestable.html scripts
//

(function ($) {

    $(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Output
        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // Init Nestable
        $('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);

        // Init Nestable Alt
        $('#nestable-alt').nestable({
            group: 2
        }).on('change', updateOutput);

        // Init Nestable Contextual
        $('#nestable-contextual').nestable({
            group: 3
        }).on('change', updateOutput);

        // Nestable serialized output
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        updateOutput($('#nestable-alt').data('output', $('#nestable-output2')));
        updateOutput($('#nestable-contextual').data('output', $('#nestable-output3')));

        // Nestable menu functionality
        $('#nestable-menu').on('change', function (e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
    });

})(jQuery);
