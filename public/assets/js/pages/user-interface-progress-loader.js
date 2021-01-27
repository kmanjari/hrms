'use strict';
//  Author: ThemeREX.com
//  user-interface-progress-loader.html scripts
//

(function ($) {

    $(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Configure Progress Loader
        NProgress.configure({
            minimum: 0.15,
            trickleRate: .07,
            trickleSpeed: 360,
            showSpinner: false,
            barColor: '', // npr-warning
                          // npr-success
                          // npr-primary
                          // npr-...
            barPos: '' // 'null' - default
                       // 'npr-bottom' -  bottom of page header
                       // 'npr-header' -  below header
        });

        // Init NProgress Plugin on click
        var Selector = $('ul.controls').find('button');
        Selector.on('click', function (e) {

            var Target = e.target
            var Node = e.target.nodeName;
            var Selector = $(Target);
            var Setting;

            if (Node === "I") {
                Setting = Selector.parent('button').attr('id');
            }

            if (Node === "BUTTON") {
                Setting = Selector.attr('id');
            }

            switch (Setting) {

                case 'b-0':
                    NProgress.start();
                    break;
                case 'b-50':
                    NProgress.set(0.50);
                    break;
                case 'b-inc':
                    NProgress.inc();
                    break;
                case 'b-100':
                    NProgress.done(true);
                    break;

                // ReConfigure in each case
                case 'p-0':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: ''
                    });
                    NProgress.start();
                    break;
                case 'p-1':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-header'
                    });
                    NProgress.start();
                    break;
                case 'p-2':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-bottom'
                    });
                    NProgress.start();
                    break;

                case 'c-primary':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-primary'
                    });
                    NProgress.start();
                    break;
                case 'c-success':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-success'
                    });
                    NProgress.start();
                    break;
                case 'c-info':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-info'
                    });
                    NProgress.start();
                    break;
                case 'c-warning':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-warning'
                    });
                    NProgress.start();
                    break;

                case 'c-danger':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-danger'
                    });
                    NProgress.start();
                    break;
                case 'c-alert':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-alert'
                    });
                    NProgress.start();
                    break;
                case 'c-system':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-system'
                    });
                    NProgress.start();
                    break;
                case 'c-dark':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-dark'
                    });
                    NProgress.start();
                    break;
                case 'c-light':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-light'
                    });
                    NProgress.start();
                    break;
                case 'c-muted':
                    NProgress.done(true);
                    NProgress.configure({
                        barPos: 'npr-muted'
                    });
                    NProgress.start();
                    break;
            }

        });
    });

})(jQuery);
