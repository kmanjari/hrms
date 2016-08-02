'use strict';
//  Author: ThemeREX.com
//  widgets-tools.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";

        // Init Demo JS
        Demo.init();


        // Init Theme Core
        Core.init();

        // Init D3Charts
        D3Charts.init();

        // Init Spec Panels on widgets inside the ".spec-panels" container
        $('.allcp-panels').allcppanel({
            grid: '.allcp-grid',
            callback: function() {
                bootbox.confirm('<h3>Custom Callback!</h3>', function() {});
            },
            onFinish: function() {
                $('.allcp-panels').addClass('animated fadeIn').removeClass('fade-onload');

                // Now add all rest functionality
                demoHighCharts.init();
                runVectorMaps();
            },
            onSave: function() {
                $(window).trigger('resize');
            }
        });

        // Init VectorMap
        function runVectorMaps() {

            var runJvectorMap = function() {
                // Set Data
                var mapData = [900, 700, 350, 500];
                $('#WidgetMap').vectorMap({
                    map: 'us_lcc_en',
                    backgroundColor: 'transparent',
                    series: {
                        markers: [{
                            attribute: 'r',
                            scale: [3, 7],
                            values: mapData
                        }]
                    },
                    regionStyle: {
                        initial: {
                            fill: '#E5E5E5'
                        },
                        hover: {
                            "fill-opacity": 0.3
                        }
                    },
                    markers: [{
                        latLng: [36, -119],
                        name: 'California,CA'
                    },{
                        latLng: [30, -100],
                        name: 'Texas,TX'
                    }, {
                        latLng: [27, -81],
                        name: 'Florida,Fl'
                    }],
                    markerStyle: {
                        initial: {
                            fill: '#a288d5',
                            stroke: '#b49ae0',
                            "fill-opacity": 1,
                            "stroke-width": 10,
                            "stroke-opacity": 0.3,
                            r: 3
                        },
                        hover: {
                            stroke: 'black',
                            "stroke-width": 2
                        },
                        selected: {
                            fill: 'blue'
                        },
                        selectedHover: {}
                    }
                });
                // Add needed data
                var states = ['US-CA', 'US-TX', 'US-FL'];
                var colors = [bgSuccessLr, bgWarningLr, bgPrimaryLr];
                var colors2 = [bgSuccess, bgWarning, bgPrimary];
                $.each(states, function(i, e) {
                    $("#WidgetMap path[data-code=" + e + "]").css({
                        fill: colors[i]
                    });
                });
                $('#WidgetMap').find('.jvectormap-marker')
                    .each(function(i, e) {
                        $(e).css({
                            fill: colors2[i],
                            stroke: colors2[i]
                        });
                    });
            };

            if ($('#WidgetMap').length) {
                runJvectorMap();
            }
        }

    });

})(jQuery);
