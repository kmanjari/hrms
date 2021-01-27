'use strict';
//  Author: ThemeREX.com
//  email-layouts.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Switch Email Template
        $('ul.chute-nav > li > a').on('click', function(e) {
            e.preventDefault();

            // Change active elem
            $(this).parents('.chute-nav').children('li').removeClass('active');
            $(this).parent('li').addClass('active');

            // Change active template
            $('.template-chute').children('.email-template').removeClass('active');

            var btnHref = $(this).attr('href');
            $(btnHref).addClass('active');
        });
    });

})(jQuery);
