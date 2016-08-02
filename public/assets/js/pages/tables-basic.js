'use strict';
//  Author: ThemeREX.com
//  tablse-basic.html scripts
//

(function($) {

    $(document).ready(function() {



        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Init Sparklines
        $('.inlinesparkline').sparkline('html', {
            type: 'line',
            height: 30,
            width: 100,

            lineColor: bgPrimary,
            fillColor: bgPrimaryLr,

            spotColor: bgPrimary,
            minSpotColor: bgPrimary,
            maxSpotColor: bgPrimary,

            highlightSpotColor: bgWarningDr,
            highlightLineColor: bgWarningLr
        });

        var barColors = $.range_map({
            '1:6': bgPrimary,
            '7:11': bgSuccess,
            '12:': bgInfo
        })

        $('.inlinesparkbar').sparkline('html', {
            type: 'bar',
            height: 25,
            barWidth: 4,
            barSpacing: 1,

            barColor: bgPrimary,
            fillColor: bgInfoLr,
            colorMap: barColors,

            spotColor: bgPrimary,
            minSpotColor: bgPrimary,
            maxSpotColor: bgPrimary,

            highlightSpotColor: bgWarningDr,
            highlightLineColor: bgWarningLr
        });

        $('.inlinesparkpie').sparkline('html', {
            type: 'pie',
            width: 30,
            height: 23,
            offset: 90,
            sliceColors: [bgPrimary, bgInfo, bgWarning, bgAlert, bgDanger]
        });
        $('.inlinesparkpie2').sparkline('html', {
            type: 'pie',
            width: 23,
            height: 23,
            offset: -90,
            sliceColors: [bgPrimary, bgSuccess, bgAlert, bgDark, bgDanger]
        });
    });

})(jQuery);
