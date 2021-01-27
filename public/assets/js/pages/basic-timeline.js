'use strict';
//  Author: ThemeREX.com
//  basic-timeline.html scripts
//

(function ($) {

    $(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();


        // Initialize Gmap
        if ($('#map_canvas1').length) {
            $('#map_canvas1').gmap({
                'center': '40.7127837,-74.00594130000002',
                'zoom': 10,
                'disableDefaultUI': true,
                'callback': function () {
                    var self = this;
                    self.addMarker({
                        'position': this.get('map').getCenter()
                    }).click(function () {
                        self.openInfoWindow({
                            'content': 'Welcome to New York!'
                        }, this);
                    });
                }
            });
        }

        function runVectorMaps() {

            // Jvector Map
            var runJvectorMap = function () {
                // Set data
                var mapData = [900, 700, 350, 500];
                // Init map
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
                    }, {
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
                // Add demo countries
                var states = ['US-CA', 'US-TX', 'US-FL'];
                var colors = [bgSuccessLr, bgWarningLr, bgPrimaryLr];
                var colors2 = [bgSuccess, bgWarning, bgPrimary];
                $.each(states, function (i, e) {
                    $("#WidgetMap path[data-code=" + e + "]").css({
                        fill: colors[i]
                    });
                });
                $('#WidgetMap').find('.jvectormap-marker')
                    .each(function (i, e) {
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

        runVectorMaps();

        // Timeline toggle
        $('#timeline-toggle').on('click', function () {
            $('#timeline').toggleClass('timeline-single');
            Holder.run();
        });

        // Attach debounced resize handler
        var rescale = function () {
            if ($(window).width() < 1250) {
                $('#timeline').addClass('timeline-single');
                $('#timeline-toggle').hide();
            } else {
                $('#timeline').removeClass('timeline-single');
                $('#timeline-toggle').show();
            }
            Holder.run();
        };
        var lazyLayout = _.debounce(rescale, 300);

        // Rebuild on resize
        $(window).resize(lazyLayout);
        rescale();

        // Summernote
        $('.summernote-quick').summernote({
            height: 179,
            focus: false,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });

        // Init Magnific Popup
        $('a.gallery-item').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });

})(jQuery);
