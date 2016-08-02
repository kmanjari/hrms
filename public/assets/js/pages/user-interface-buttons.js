'use strict';
//  Author: ThemeREX.com
//  user-interface-buttons.html scripts
//

(function($) {

    "use strict";

    // Init Theme Core
    Core.init();

    // Init Demo JS
    Demo.init();

    // Init Ladda Plugin
    Ladda.bind('.ladda-button', {
        timeout: 2000
    });

    // Simulate loading progress on buttons with ".ladda-button" class
    Ladda.bind('.progress-button', {
        callback: function(instance) {
            var progress = 0;
            var interval = setInterval(function() {
                progress = Math.min(progress + Math.random() * 0.1, 1);
                instance.setProgress(progress);

                if (progress === 1) {
                    instance.stop();
                    clearInterval(interval);
                }
            }, 200);
        }
    });

})(jQuery);
