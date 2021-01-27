'use strict';
//  Author: ThemeREX.com
//  basic-gallery.html scripts
//

(function ($) {

    $(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        var dropdownFilter = {

            // Declare vars
            $filters: null,
            $reset: null,
            groups: [],
            outputArray: [],
            outputString: '',

            init: function () {
                var self = this;

                self.$filters = $('#select-filters');
                self.$reset = $('#mixitup-reset');
                self.$container = $('#mixitup-container');

                self.$filters.find('fieldset').each(function () {
                    self.groups.push({
                        $dropdown: $(this).find('select'),
                        active: ''
                    });
                });

                self.bindHandlers();
            },

            // Listen for select change
            bindHandlers: function () {
                var self = this;

                // Handle select change
                self.$filters.on('change', 'select', function (e) {
                    e.preventDefault();

                    self.parseFilters();
                });

                // Handle reset click
                self.$reset.on('click', function (e) {
                    e.preventDefault();

                    self.$filters.find('select').val('');

                    self.parseFilters();
                });
            },

            // Pull the value of each active select option
            parseFilters: function () {
                var self = this;

                // Get each value
                for (var i = 0, group; group = self.groups[i]; i++) {
                    group.active = group.$dropdown.val();
                }

                self.concatenate();
            },

            // Concatenate needed filters
            concatenate: function () {
                var self = this;

                self.outputString = ''; // Reset output string

                for (var i = 0, group; group = self.groups[i]; i++) {
                    self.outputString += group.active;
                }

                // If empty - init as "all"
                !self.outputString.length && (self.outputString = 'all');

                if (self.$container.mixItUp('isLoaded')) {
                    self.$container.mixItUp('filter', self.outputString);
                }
            }
        };

        var checkboxFilter = {

            // Declare vars
            $filters: null,
            $reset: null,
            groups: [],
            outputArray: [],
            outputString: '',

            init: function () {
                var self = this;

                self.$filters = $('#checkbox-filters');
                self.$reset = $('#mixitup-reset2');
                self.$container = $('#mixitup-container');

                self.$filters.find('fieldset').each(function () {
                    self.groups.push({
                        $inputs: $(this).find('input'),
                        active: [],
                        tracker: false
                    });
                });

                self.bindHandlers();
            },

            // Wait for a form value change
            bindHandlers: function () {
                var self = this;

                self.$filters.on('change', function () {
                    self.parseFilters();
                });

                self.$reset.on('click', function (e) {
                    e.preventDefault();
                    self.$filters[0].reset();
                    self.parseFilters();
                });
            },

            // Checks each group active filter
            parseFilters: function () {
                var self = this;

                // Add active filters to array
                for (var i = 0, group; group = self.groups[i]; i++) {
                    group.active = [];
                    group.$inputs.each(function () {
                        $(this).is(':checked') && group.active.push(this.value);
                    });
                    group.active.length && (group.tracker = 0);
                }

                self.concatenate();
            },

            // Concatenate filters as needed
            concatenate: function () {
                var self = this,
                    cache = '',
                    crawled = false,
                    checkTrackers = function () {
                        var done = 0;

                        for (var i = 0, group; group = self.groups[i]; i++) {
                            (group.tracker === false) && done++;
                        }

                        return (done < self.groups.length);
                    },
                    crawl = function () {
                        for (var i = 0, group; group = self.groups[i]; i++) {
                            group.active[group.tracker] && (cache += group.active[group.tracker]);

                            if (i === self.groups.length - 1) {
                                self.outputArray.push(cache);
                                cache = '';
                                updateTrackers();
                            }
                        }
                    },
                    updateTrackers = function () {
                        for (var i = self.groups.length - 1; i > -1; i--) {
                            var group = self.groups[i];

                            if (group.active[group.tracker + 1]) {
                                group.tracker++;
                                break;
                            } else if (i > 0) {
                                group.tracker && (group.tracker = 0);
                            } else {
                                crawled = true;
                            }
                        }
                    };

                self.outputArray = [];

                do {
                    crawl();
                }
                while (!crawled && checkTrackers());

                self.outputString = self.outputArray.join();

                // If empty - show "all"
                !self.outputString.length && (self.outputString = 'all');

                if (self.$container.mixItUp('isLoaded')) {
                    self.$container.mixItUp('filter', self.outputString);
                }
            }
        };

        // Init multiselect on filter dropdowns
        $('#filter1').multiselect({
            buttonClass: 'btn btn-default'
        });
        $('#filter2').multiselect({
            buttonClass: 'btn btn-default'
        });

        // Init checkboxFilter
        checkboxFilter.init();

        // Init dropdownFilter
        dropdownFilter.init();

        var $container = $('#mixitup-container'),
            $toList = $('.to-list'), // list view button
            $toGrid = $('.to-grid'); // list view button

        // Instantiate MixItUp
        $container.mixItUp({
            controls: {
                enable: false
            },
            animation: {
                duration: 400,
                effects: 'fade translateZ(-360px) stagger(50ms)',
                easing: 'ease'
            },
            callbacks: {
                onMixFail: function () {
                }
            }
        });

        $toList.on('click', function () {
            if ($container.hasClass('list')) {
                return
            }
            $container.mixItUp('changeLayout', {
                display: 'block',
                containerClass: 'list'
            }, function (state) {
            });
        });
        $toGrid.on('click', function () {
            if ($container.hasClass('grid')) {
                return
            }
            $container.mixItUp('changeLayout', {
                display: 'inline-block',
                containerClass: 'grid'
            }, function (state) {
            });
        });

        // Add Gallery Item to Lightbox
        $('.mix img').magnificPopup({
            type: 'image',
            callbacks: {
                beforeOpen: function (e) {
                    // Indicate active overlay
                    $('body').addClass('mfp-bg-open');

                    // Magnific Animation
                    this.st.mainClass = 'mfp-zoomIn';

                    // Animation notify class
                    this.contentContainer.addClass('mfp-with-anim');
                },
                afterClose: function (e) {

                    setTimeout(function () {
                        $('body').removeClass('mfp-bg-open');
                        $(window).trigger('resize');
                    }, 1000)

                },
                elementParse: function (item) {
                    item.src = item.el.attr('src');
                }
            },
            overflowY: 'scroll',
            removalDelay: 200,
            prependTo: $('#content_wrapper')
        });
    });

})(jQuery);
