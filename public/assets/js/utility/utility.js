/*!
 * Minified Utility Resources
 * Theme Core resources.
*/

;
(function ($) {
    var defaults = {
        width: 400,
        height: "65%",
        minimizedWidth: 200,
        gutter: 10,
        poppedOutDistance: "6%",
        title: function() {
            return "";
        },
        dialogClass: "",
        buttons: [], /* id, html, buttonClass, click */
        animationSpeed: 400,
        opacity: 1,
        initialState: 'modal', /* "modal", "docked", "minimized" */

        showClose: true,
        showPopout: true,
        showMinimize: true,

        create: undefined,
        open: undefined,
        beforeClose: undefined,
        close: undefined,
        beforeMinimize: undefined,
        minimize: undefined,
        beforeRestore: undefined,
        restore: undefined,
        beforePopout: undefined,
        popout: undefined
    };
    var dClass = "dockmodal";
    var windowWidth = $(window).width();

    function setAnimationCSS($this, $el) {
        var aniSpeed = $this.options.animationSpeed / 1000;
        $el.css({"transition": aniSpeed + "s right, " + aniSpeed + "s left, " + aniSpeed + "s top, " + aniSpeed + "s bottom, " + aniSpeed + "s height, " + aniSpeed + "s width"});
        return true;
    }

    function removeAnimationCSS($el) {
        $el.css({"transition": "none"});
        return true;
    }

    var methods = {
        init: function (options) {

            return this.each(function () {

                var $this = $(this);

                var data = $this.data('dockmodal');
                $this.options = $.extend({}, defaults, options);

                // Does title a returned function?
                (function titleCheck() {
                    if (typeof $this.options.title == "function") {
                        $this.options.title = $this.options.title.call($this);
                    }
                })();

                // If the plugin has not been initialized yet
                if (!data) {
                    $this.data('dockmodal', $this);
                } else {
                    $("body").append($this.closest("." + dClass).show());
                    methods.refreshLayout();
                    setTimeout(function () {
                        methods.restore.apply($this);
                    }, $this.options.animationSpeed);
                    return;
                }

                // Create modal
                var $body = $("body");
                var $window = $(window);
                var $dockModal = $('<div/>').addClass(dClass).addClass($this.options.dialogClass);
                if ($this.options.initialState == "modal") {
                    $dockModal.addClass("popped-out");
                } else if ($this.options.initialState == "minimized") {
                    $dockModal.addClass("minimized");
                }
                $dockModal.height(0);
                setAnimationCSS($this, $dockModal);

                // Create title
                var $dockHeader = $('<div></div>').addClass(dClass + "-header");

                if ($this.options.showClose) {
                    $('<a href="#" class="header-action action-close" title="Close"><i class="icon-dockmodal-close"></i></a>').appendTo($dockHeader).click(function (e) {
                        methods.destroy.apply($this);
                        return false;
                    });
                }
                if ($this.options.showPopout) {
                    $('<a href="#" class="header-action action-popout" title="Pop out"><i class="icon-dockmodal-popout"></i></a>').appendTo($dockHeader).click(function (e) {
                        if ($dockModal.hasClass("popped-out")) {
                            methods.restore.apply($this);
                        } else {
                            methods.popout.apply($this);
                        }
                        return false;
                    });
                }
                if ($this.options.showMinimize) {
                    $('<a href="#" class="header-action action-minimize" title="Minimize"><i class="icon-dockmodal-minimize"></i></a>').appendTo($dockHeader).click(function (e) {
                        if ($dockModal.hasClass("minimized")) {
                            if ($dockModal.hasClass("popped-out")) {
                                methods.popout.apply($this);
                            } else {
                                methods.restore.apply($this);
                            }
                        } else {
                            methods.minimize.apply($this);
                        }
                        return false;
                    });
                }
                if ($this.options.showMinimize && $this.options.showPopout) {
                    $dockHeader.click(function () {
                        if ($dockModal.hasClass("minimized")) {
                            if ($dockModal.hasClass("popped-out")) {
                                methods.popout.apply($this);
                            } else {
                                methods.restore.apply($this);
                            }
                        } else {
                            methods.minimize.apply($this);
                        }
                        return false;
                    });
                } 


                $dockHeader.append('<div class="title-text">' + ($this.options.title || $this.attr("title")) + '</div>');
                $dockModal.append($dockHeader);

                // Create body
                var $placeholder = $('<div class="modal-placeholder"></div>').insertAfter($this);
                $this.placeholder = $placeholder;
                var $dockBody = $('<div></div>').addClass(dClass + "-body").append($this);
                $dockModal.append($dockBody);

                // Create footer
                if ($this.options.buttons.length) {
                    var $dockFooter = $('<div></div>').addClass(dClass + "-footer");
                    var $dockFooterButtonset = $('<div></div>').addClass(dClass + "-footer-buttonset");
                    $dockFooter.append($dockFooterButtonset);
                    $.each($this.options.buttons, function (indx, el) {
                        var $btn = $('<a href="#" class="btn"></a>');
                        $btn.attr({ "id": el.id, "class": el.buttonClass });
                        $btn.html(el.html);
                        $btn.click(function (e) {
                            el.click(e, $this);
                            return false;
                        });
                        $dockFooterButtonset.append($btn);
                    });
                    $dockModal.append($dockFooter);
                } else {
                    $dockModal.addClass("no-footer");
                }

                // Create overlay
                var $overlay = $("." + dClass + "-overlay");
                if (!$overlay.length) {
                    $overlay = $('<div/>').addClass(dClass + "-overlay");
                }

                if ($.isFunction($this.options.create)) {
                    $this.options.create($this);
                }

                $body.append($dockModal);
                $dockModal.after($overlay);
                $dockBody.focus();

                if ($.isFunction($this.options.open)) {
                    setTimeout(function () {
                        $this.options.open($this);
                    }, $this.options.animationSpeed);
                }

                if ($dockModal.hasClass("minimized")) {
                    $dockModal.find(".dockmodal-body, .dockmodal-footer").hide();
                    methods.minimize.apply($this);
                } else {
                    if ($dockModal.hasClass("popped-out")) {
                        methods.popout.apply($this);
                    } else {
                        methods.restore.apply($this);
                    }
                }

                $body.data("windowWidth", $window.width());

                $window.unbind("resize.dockmodal").bind("resize.dockmodal", function () {
                    if ($window.width() == $body.data("windowWidth")) {
                        return;
                    }

                    $body.data("windowWidth", $window.width());
                    methods.refreshLayout();
                });
            });
        },
        destroy: function () {
            return this.each(function () {

                var $this = $(this).data('dockmodal');
                if (!$this)
                    return;

                if ($.isFunction($this.options.beforeClose)) {
                    if ($this.options.beforeClose($this) === false) {
                        return;
                    }
                }

                try {
                    var $dockModal = $this.closest("." + dClass);

                    if ($dockModal.hasClass("popped-out") && !$dockModal.hasClass("minimized")) {
                        $dockModal.css({
                            "left": "50%",
                            "right": "50%",
                            "top": "50%",
                            "bottom": "50%"
                        });
                    } else {
                        $dockModal.css({
                            "width": "0",
                            "height": "0"
                        });
                    }
                    setTimeout(function () {
                        $this.removeData('dockmodal');
                        $this.placeholder.replaceWith($this);
                        $dockModal.remove();
                        $("." + dClass + "-overlay").hide();
                        methods.refreshLayout();

                        if ($.isFunction($this.options.close)) {
                            $this.options.close($this);
                        }
                    }, $this.options.animationSpeed);

                }
                catch (err) {
                    alert(err.message);
                }

            })
        },
        close: function () {
            methods.destroy.apply(this);
        },
        minimize: function () {
            return this.each(function () {

                var $this = $(this).data('dockmodal');
                if (!$this)
                    return;

                if ($.isFunction($this.options.beforeMinimize)) {
                    if ($this.options.beforeMinimize($this) === false) {
                        return;
                    }
                }

                var $dockModal = $this.closest("." + dClass);
                var headerHeight = $dockModal.find(".dockmodal-header").outerHeight();
                $dockModal.addClass("minimized").css({
                    "width": $this.options.minimizedWidth + "px",
                    "height": headerHeight + "px",
                    "left": "auto",
                    "right": "auto",
                    "top": "auto",
                    "bottom": "0"
                });
                setTimeout(function () {
                    // hide the body and footer
                    $dockModal.find(".dockmodal-body, .dockmodal-footer").hide();

                    if ($.isFunction($this.options.minimize)) {
                        $this.options.minimize($this);
                    }
                }, $this.options.animationSpeed);

                $("." + dClass + "-overlay").hide();
                $dockModal.find(".action-minimize").attr("title", "Restore");

                methods.refreshLayout();
            })
        },
        restore: function () {
            return this.each(function () {

                var $this = $(this).data('dockmodal');
                if (!$this)
                    return;

                if ($.isFunction($this.options.beforeRestore)) {
                    if ($this.options.beforeRestore($this) === false) {
                        return;
                    }
                }

                var $dockModal = $this.closest("." + dClass);
                $dockModal.removeClass("minimized popped-out");
                $dockModal.find(".dockmodal-body, .dockmodal-footer").show();
                $dockModal.css({
                    "width": $this.options.width + "px",
                    "height": $this.options.height,
                    "left": "auto",
                    "right": "auto",
                    "top": "auto",
                    "bottom": "0"
                });

                $("." + dClass + "-overlay").hide();
                $dockModal.find(".action-minimize").attr("title", "Minimize");
                $dockModal.find(".action-popout").attr("title", "Pop-out");

                setTimeout(function () {
                    if ($.isFunction($this.options.restore)) {
                        $this.options.restore($this);
                    }
                }, $this.options.animationSpeed);

                methods.refreshLayout();
            })
        },
        popout: function () {
            return this.each(function () {

                var $this = $(this).data('dockmodal');
                if (!$this)
                    return;

                if ($.isFunction($this.options.beforePopout)) {
                    if ($this.options.beforePopout($this) === false) {
                        return;
                    }
                }

                var $dockModal = $this.closest("." + dClass);
                $dockModal.find(".dockmodal-body, .dockmodal-footer").show();

                removeAnimationCSS($dockModal);
                var offset = $dockModal.position();
                var windowWidth = $(window).width();
                $dockModal.css({
                    "width": "auto",
                    "height": "auto",
                    "left": offset.left + "px",
                    "right": (windowWidth - offset.left - $dockModal.outerWidth(true)) + "px",
                    "top": offset.top + "px",
                    "bottom": 0
                });

                setAnimationCSS($this, $dockModal);
                setTimeout(function () {
                    $dockModal.removeClass("minimized").addClass("popped-out").css({
                        "width": "auto",
                        "height": "auto",
                        "left": $this.options.poppedOutDistance,
                        "right": $this.options.poppedOutDistance,
                        "top": $this.options.poppedOutDistance,
                        "bottom": $this.options.poppedOutDistance
                    });
                    $("." + dClass + "-overlay").show();
                    $dockModal.find(".action-popout").attr("title", "Pop-in");

                    methods.refreshLayout();
                }, 10);

                setTimeout(function () {
                    if ($.isFunction($this.options.popout)) {
                        $this.options.popout($this);
                    }
                }, $this.options.animationSpeed);
            });
        },
        refreshLayout: function () {

            var right = 0;
            var windowWidth = $(window).width();

            $.each($("." + dClass).toArray().reverse(), function (i, val) {
                var $dockModal = $(this);
                var $this = $dockModal.find("." + dClass + "-body > div").data("dockmodal");

                if ($dockModal.hasClass("popped-out") && !$dockModal.hasClass("minimized")) {
                    return;
                }
                right += $this.options.gutter;
                $dockModal.css({ "right": right + "px" });
                if ($dockModal.hasClass("minimized")) {
                    right += $this.options.minimizedWidth;
                } else {
                    right += $this.options.width;
                }
                if (right > windowWidth) {
                    $dockModal.hide();
                } else {
                    setTimeout(function () {
                        $dockModal.show();
                    }, $this.options.animationSpeed);
                }
            });
        }

    };

    $.fn.dockmodal = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.dockmodal');
        }
    };
})(jQuery);


(function($, window, document, undefined) {

   $.fn.allcppanel = function(options) {

      // Plugin options
      var defaults = {
         grid: '.allcp-grid',
         draggable: false,
         mobile: false,
         preserveGrid: false,
         onPanel: function() {
            console.log('callback:', 'onPanel');
         },
         onStart: function() {
            console.log('callback:', 'onStart');
         },
         onSave: function() {
            console.log('callback:', 'onSave');
         },
         onDrop: function() {
            console.log('callback:', 'onDrop');
         },
         onFinish: function() {
            console.log('callback:', 'onFinish');
         }
      };

      // Extend default options
      var options = $.extend({}, defaults, options);

      // Variables
      var plugin = $(this);
      var pluginGrid = options.grid;
      var dragSetting = options.draggable;
      var mobileSetting = options.mobile;
      var preserveSetting = options.preserveGrid;
      var panels = plugin.find('.panel');

      // HTML5 Local Storage Keys
      var settingsKey = 'panel-settings_' + location.pathname;
      var positionsKey = 'panel-positions_' + location.pathname;

      // HTML5 Local Storage Gets
      var settingsGet = localStorage.getItem(settingsKey);
      var positionsGet = localStorage.getItem(positionsKey);

      // Control Menu on Click Handler
      $('.panel').on('click', '.panel-controls > a', function(e) {
         e.preventDefault();

         // Disable clicks while dragging
         if ($('body.ui-drag-active').length) {
            return;
         }

         methods.controlHandlers.call(this, options);
      });

      var methods = {
         init: function(options) {
            var This = $(this);

            if (typeof options.onStart == 'function') {
               options.onStart();
            }

            // Check on load to see if positions key is empty
            if (!positionsGet) {
               localStorage.setItem(positionsKey, methods.findPositions());
            } else {
               methods.setPositions();
            }

            // Check on load to see if settings key is empty
            if (!settingsGet) {
               localStorage.setItem(settingsKey, methods.modifySettings());
            }

            // Add unique ID's to grid elements
            $(pluginGrid).each(function(i, e) {
               $(e).attr('id', 'grid-' + i);
            });

            // Check preserve need using an invisible panel
            if (preserveSetting) {
               var Panel = "<div class='panel preserve-grid'></div>";
               $(pluginGrid).each(function(i, e) {
                  $(e).append(Panel);
               });
            }

            // Prep spec panel/container prior to menu creation
            methods.createControls(options);

            methods.applySettings();

            // Create Mobile Controls
            methods.createMobileControls(options);

            if (dragSetting === true) {
               // Activate sortable on declared grids/panels
               plugin.sortable({
                  items: plugin.find('.panel:not(".sort-disable")'),
                  connectWith: pluginGrid,
                  cursor: 'default',
                  revert: 250,
                  handle: '.panel-heading',
                  opacity: 1,
                  delay: 100,
                  tolerance: "pointer",
                  scroll: true,
                  placeholder: 'panel-placeholder',
                  forcePlaceholderSize: true,
                  forceHelperSize: true,
                  start: function(e, ui) {
                     $('body').addClass('ui-drag-active');
                     ui.placeholder.height(ui.helper.outerHeight() - 4);
                  },
                  beforeStop: function() {
                     if (typeof options.onDrop == 'function') {
                        options.onDrop();
                     }
                  },
                  stop: function() {
                     $('body').removeClass('ui-drag-active');
                  },
                  update: function(event, ui) {
                     // toggle "loading"
                     methods.toggleLoader();

                     // store plugins positions
                     methods.updatePositions(options);
                  }
               });
            }

            // onFinish callback
            if (typeof options.onFinish == 'function') {
               options.onFinish();
            }
         },
         createMobileControls: function(options) {

            var controls = panels.find('.panel-controls');

            var arr = {};

            $.each(controls, function(i, e) {
               var This = $(e);
               var ID = $(e).parents('.panel').attr('id');

               var controlW = This.width();
               var titleW = This.siblings('.panel-title').width();
               var headingW = This.parent('.panel-heading').width();
               var mobile = (controlW + titleW);
               arr[ID] = mobile;
            });

            $.each(arr, function(i, e) {

               var This = $('#' + i);
               var headingW = This.width() - 75;
               var controls = This.find('.panel-controls');

               if (mobileSetting === true || headingW < e) {
                  This.addClass('mobile-controls');
                  var options = {
                     html: true,
                     placement: "left",
                     content: function(e) {
                        var Content = $(this).clone();
                        return Content;
                     },
                     template: '<div data-popover-id="'+i+'" class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
                  };
                  controls.popover(options);
               } else {
                  controls.removeClass('mobile-controls');
               }
            });

            // Toggle panel controls menu open on click
            $('.mobile-controls .panel-heading > .panel-controls').on('click', function() {
               $(this).toggleClass('panel-controls-open');
            });

         },
         applySettings: function(options) {

            var obj = this;
            var localSettings = localStorage.getItem(settingsKey);
            var parseSettings = JSON.parse(localSettings);

            // Panel colors
            var panelColors = "panel-primary panel-success panel-info panel-warning panel-danger panel-alert panel-system panel-dark panel-default";

            $.each(parseSettings, function(i, e) {

               $.each(e, function(i, e) {
                  var panelID = e['id'];
                  var panelTitle = e['title'];
                  var panelCollapsed = e['collapsed'];
                  var panelHidden = e['hidden'];
                  var panelColor = e['color'];
                  var Target = $('#' + panelID);

                  if (panelTitle) {
                     Target.children('.panel-heading').find('.panel-title').text(panelTitle);
                  }
                  if (panelCollapsed === 1) {
                     Target.addClass('panel-collapsed')
                        .children('.panel-body, .panel-menu, .panel-footer').hide();
                  }
                  if (panelColor) {
                     Target.removeClass(panelColors).addClass(panelColor).attr('data-panel-color', panelColor);
                  }
                  if (panelHidden === 1) {
                     Target.addClass('panel-hidden').hide().remove();
                  }
               });
            });
         },
         createControls: function(options) {

         	// List panel controls
            var panelControls = '<span class="panel-controls"></span>';
            var panelTitle = '<a href="#" class="panel-control-title"></a>';
            var panelColor = '';
            var panelCollapse = '<a href="#" class="panel-control-collapse"></a>';
            var panelFullscreen = '<a href="#" class="panel-control-fullscreen"></a>';
            var panelRemove = '<a href="#" class="panel-control-remove"></a>';
            var panelCallback = '<a href="#" class="panel-control-callback"></a>';
            var panelDock = '<a href="#" class="panel-control-dockable" data-toggle="popover" data-content="panelDockContent();"></a>';
            var panelExpose = '<a href="#" class="panel-control-expose"></a>';
            var panelLoader = '<a href="#" class="panel-control-loader"></a>';

            panels.each(function(i, e) {

               var This = $(e);

               var panelHeader = This.children('.panel-heading');

               // Check panel for settings specific attr
               var title = This.attr('data-panel-title');
               var color = This.attr('data-panel-color');
               var collapse = This.attr('data-panel-collapse');
               var fullscreen = This.attr('data-panel-fullscreen');
               var remove = This.attr('data-panel-remove');
               var callback = This.attr('data-panel-callback');
               var paneldock = This.attr('data-panel-dockable');
               var expose = This.attr('data-panel-expose');
               var loader = This.attr('data-panel-loader');

                $(panelControls).appendTo(panelHeader);


               // Attach "loading"
               if (!loader) {
                  var panelMenu = panelHeader.find('.panel-controls');
                  $(panelLoader).appendTo(panelMenu);
               }
               if (expose) {
                  var panelMenu = panelHeader.find('.panel-controls');
                  $(panelExpose).appendTo(panelMenu);
               }
               if (paneldock) {
                  var panelMenu = panelHeader.find('.panel-controls');
                  $(panelDock).appendTo(panelMenu);
               }
               if (callback) {
                  var panelMenu = panelHeader.find('.panel-controls');
                  $(panelCallback).appendTo(panelMenu);
               }
               if (!remove) {
                  var panelMenu = panelHeader.find('.panel-controls');
                  $(panelRemove).appendTo(panelMenu);
               }
               if (!title) {
                  var panelMenu = panelHeader.find('.panel-controls');
                  $(panelTitle).appendTo(panelMenu);
               }
               if (!color) {
                  var panelMenu = panelHeader.find('.panel-controls');
                  $(panelColor).appendTo(panelMenu);
               }
               if (!collapse) {
                  var panelMenu = panelHeader.find('.panel-controls');
                  $(panelCollapse).appendTo(panelMenu);
               }
               if (!fullscreen) {
                  var panelMenu = panelHeader.find('.panel-controls');
                  $(panelFullscreen).appendTo(panelMenu);
               }

            });
         },
         controlHandlers: function(e) {

            var This = $(this);

            // Control btn indentifiers
            var action = This.attr('class');
            var panel = This.parents('.panel');

            // Panel header vars
            var panelHeading = panel.children('.panel-heading');
            var panelTitle = panel.find('.panel-title');

            // Edit Title
            var panelEditTitle = function() {

               // Editbox menu toggle
               var toggleBox = function() {
                  var panelEditBox = panel.find('.panel-editbox');
                  panelEditBox.slideToggle('fast', function() {
                     panel.toggleClass('panel-editbox-open');

                     // Save settings on close
                     if (!panel.hasClass('panel-editbox-open')) {
                        panelTitle.text(panelEditBox.children('input').val());
                        methods.updateSettings(options);
                     }
                  });
               };

               // If editbox not found, create it and attach handlers
               if (!panel.find('.panel-editbox').length) {
                  var editBox = '<div class="panel-editbox"><input type="text" class="form-control" value="' + panelTitle.text() + '"></div>';
                  panelHeading.after(editBox);

                  // New editbox cont
                  var panelEditBox = panel.find('.panel-editbox');

                  // Update panel title on keyup
                  panelEditBox.children('input').on('keyup', function() {
                     panelTitle.text(panelEditBox.children('input').val());
                  });

                  // Save panel title on enter keypress
                  panelEditBox.children('input').on('keypress', function(e) {
                     if (e.which == 13) {
                        toggleBox();
                     }
                  });

                  toggleBox();
               } else {
                  // If found - toggle the menu
                  toggleBox();
               }
            };

            // Panel color definition
            var panelColor = function() {

               // Create editbox if not found
               if (!panel.find('.panel-colorbox').length) {
                  var colorBox = '<div class="panel-colorbox"> <span class="bg-white" data-panel-color="panel-default"></span> <span class="bg-primary" data-panel-color="panel-primary"></span> <span class="bg-info" data-panel-color="panel-info"></span> <span class="bg-success" data-panel-color="panel-success"></span> <span class="bg-warning" data-panel-color="panel-warning"></span> <span class="bg-danger" data-panel-color="panel-danger"></span> <span class="bg-alert" data-panel-color="panel-alert"></span> <span class="bg-system" data-panel-color="panel-system"></span> <span class="bg-dark" data-panel-color="panel-dark"></span> </div>'
                  panelHeading.after(colorBox);
               }

               // Editbox container
               var panelColorBox = panel.find('.panel-colorbox');

               // Update panel context color on click
               panelColorBox.on('click', '> span', function(e) {
                  var dataColor = $(this).data('panel-color');
                  var altColors = 'panel-primary panel-info panel-success panel-warning panel-danger panel-alert panel-system panel-dark panel-default panel-white';
                  panel.removeClass(altColors).addClass(dataColor).data('panel-color', dataColor);
                  methods.updateSettings(options);
               });

               // Toggle given elements visability and ".panel-editbox" class
               // Update settings if closing box
               panelColorBox.slideToggle('fast', function() {
                  panel.toggleClass('panel-colorbox-open');
               });

            };

            // Collapse definition
            var panelCollapse = function() {

               // Toggle class
               panel.toggleClass('panel-collapsed');

               // Toggle given elements visability
               panel.children('.panel-body, .panel-menu, .panel-footer').slideToggle('fast', function() {
                  methods.updateSettings(options);
               });
            };

            // Fullscreen definition
            var panelFullscreen = function() {
               // If fullscreen - remove class and enable panel sorting
               if ($('body.panel-fullscreen-active').length) {
                  $('body').removeClass('panel-fullscreen-active');
                  panel.removeClass('panel-fullscreen');
                  if (dragSetting === true) {
                     plugin.sortable("enable");
                  }
               }
               // if not active - fullscreen classes,  disable panel sorting
               else {
                  $('body').addClass('panel-fullscreen-active');
                  panel.addClass('panel-fullscreen');
                  if (dragSetting === true) {
                     plugin.sortable("disable");
                  }
               }

               // Hide open mobile menus or popovers
               $('.panel-controls').removeClass('panel-controls-open');
               $('.popover').popover('hide');

               // Trigger global window resize to resize plugins that could be
               // in fullscreen conent
               setTimeout(function() {
                  $(window).trigger('resize');
               }, 100);
            };

            // Remove definition
            var panelRemove = function() {

               // Bootbox plugin is a core part
               if (bootbox.confirm) {
                  bootbox.confirm("Are You Sure?!", function(e) {
                     if (e) {
                        setTimeout(function() {
                           panel.addClass('panel-removed').hide();
                           methods.updateSettings(options);
                        }, 200);
                     }

                  });
               } else {
                  panel.addClass('panel-removed').hide();
                  methods.updateSettings(options);
               }
            };

            // Remove definition
            var panelCallback = function() {
               if (typeof options.onPanel == 'function') {
                  options.onPanel();
               }
            };

            // Response
            if ($(this).hasClass('panel-control-collapse')) {
               panelCollapse();
            }
            if ($(this).hasClass('panel-control-title')) {
               panelEditTitle();
            }
            if ($(this).hasClass('panel-control-color')) {
               panelColor();
            }
            if ($(this).hasClass('panel-control-fullscreen')) {
               panelFullscreen();
            }
            if ($(this).hasClass('panel-control-remove')) {
               panelRemove();
            }
            if ($(this).hasClass('panel-control-callback')) {
               panelCallback();
            }
            if ($(this).hasClass('panel-control-dockable')) {
               return
            }
            if ($(this).hasClass('panel-control-loader')) {
               return;
            }

            // Toggle Loader indicator to action response
            methods.toggleLoader.call(this);

         },
         toggleLoader: function(options) {
            var This = $(this);
            var panel = This.parents('.panel');

            // Add loader to panel
            panel.addClass('panel-loader-active');

            // Remove loader after time
            setTimeout(function() {
               panel.removeClass('panel-loader-active');
            }, 650);

         },
         modifySettings: function(options) {

            // Settings obj
            var settingsArr = [];

            // Settings for each panel
            panels.each(function(i, e) {

               var This = $(e);
               var panelObj = {};

               // Settings vars
               var panelID = This.attr('id');
               var panelTitle = This.children('.panel-heading').find('.panel-title').text();
               var panelCollapsed = (This.hasClass('panel-collapsed') ? 1 : 0);
               var panelHidden = (This.is(':hidden') ? 1 : 0);
               var panelColor = This.data('panel-color');

               panelObj['id'] = This.attr('id');
               panelObj['title'] = This.children('.panel-heading').find('.panel-title').text();
               panelObj['collapsed'] = (This.hasClass('panel-collapsed') ? 1 : 0);
               panelObj['hidden'] = (This.is(':hidden') ? 1 : 0);
               panelObj['color'] = (panelColor ? panelColor : null);

               settingsArr.push({
                  'panel': panelObj
               });
            });

            var checkedSettings = JSON.stringify(settingsArr);

            // panel positions array
            return checkedSettings;
         },
         findPositions: function(options) {

            var grids = plugin.find(pluginGrid);
            var gridsArr = [];

            // Find present panels
            grids.each(function(index, ele) {

               var panels = $(ele).find('.panel');
               var panelArr = [];

               $(ele).attr('id', 'grid-' + index);

               panels.each(function(i, e) {
                  var panelID = $(e).attr('id');
                  panelArr.push(panelID);
               });

               gridsArr[index] = panelArr;
            });

            var checkedPosition = JSON.stringify(gridsArr);

            // Panel positions array
            return checkedPosition;

         },
         setPositions: function(options) {

            // Vars
            var obj = this;
            var localPositions = localStorage.getItem(positionsKey);
            var parsePosition = JSON.parse(localPositions);

            // Get gata and set panel's position
            $(pluginGrid).each(function(i, e) {
               var rowID = $(e)
               $.each(parsePosition[i], function(i, ele) {
                  $('#' + ele).appendTo(rowID);
               });
            });
         },
         updatePositions: function(options) {
            localStorage.setItem(positionsKey, methods.findPositions());

            if (typeof options.onSave == 'function') {
               options.onSave();
            }
         },
         updateSettings: function(options) {
            localStorage.setItem(settingsKey, methods.modifySettings());

            if (typeof options.onSave == 'function') {
               options.onSave();
            }
         }
      };

      return this.each(function() {
         methods.init.call(plugin, options);
      });

   };

})(jQuery, window, document);


(function (root, factory) {

  "use strict";
  if (typeof define === "function" && define.amd) {
    define(["jquery"], factory);
  } else if (typeof exports === "object") {
    module.exports = factory(require("jquery"));
  } else {
    root.bootbox = factory(root.jQuery);
  }

}(this, function init($, undefined) {

  "use strict";

  // the base DOM structure for adding modal
  var templates = {
    dialog:
      "<div class='bootbox modal' tabindex='-1' role='dialog'>" +
        "<div class='modal-dialog'>" +
          "<div class='modal-content'>" +
            "<div class='modal-body'><div class='bootbox-body'></div></div>" +
          "</div>" +
        "</div>" +
      "</div>",
    header:
      "<div class='modal-header'>" +
        "<h4 class='modal-title'></h4>" +
      "</div>",
    footer:
      "<div class='modal-footer'></div>",
    closeButton:
      "<button type='button' class='bootbox-close-button close' data-dismiss='modal' aria-hidden='true'>&times;</button>",
    form:
      "<form class='bootbox-form'></form>",
    inputs: {
      text:
        "<input class='bootbox-input bootbox-input-text form-control' autocomplete=off type=text />",
      textarea:
        "<textarea class='bootbox-input bootbox-input-textarea form-control'></textarea>",
      email:
        "<input class='bootbox-input bootbox-input-email form-control' autocomplete='off' type='email' />",
      select:
        "<select class='bootbox-input bootbox-input-select form-control'></select>",
      checkbox:
        "<div class='checkbox'><label><input class='bootbox-input bootbox-input-checkbox' type='checkbox' /></label></div>",
      date:
        "<input class='bootbox-input bootbox-input-date form-control' autocomplete=off type='date' />",
      time:
        "<input class='bootbox-input bootbox-input-time form-control' autocomplete=off type='time' />",
      number:
        "<input class='bootbox-input bootbox-input-number form-control' autocomplete=off type='number' />",
      password:
        "<input class='bootbox-input bootbox-input-password form-control' autocomplete='off' type='password' />"
    }
  };

    // Setting Modal
  var defaults = {
    locale: "en",
    backdrop: true,
    animate: true,
    // additional class for top level dialog
    className: null,
    keyboard: false,
    closeButton: true,
    // show dialog immediately by default
    show: true,
    // dialog container
    container: "body"
  };

  // our public object
  var exports = {};

  /* @private  */
  function _t(key) {
    var locale = locales[defaults.locale];
    return locale ? locale[key] : locales.en[key];
  }

  function processCallback(e, dialog, callback) {
    e.stopPropagation();
    e.preventDefault();

    var preserveDialog = $.isFunction(callback) && callback(e) === false;

    if (!preserveDialog) {
      dialog.modal("hide");
    }
  }

  function getKeyLength(obj) {
    var k, t = 0;
    for (k in obj) {
      t ++;
    }
    return t;
  }

  function each(collection, iterator) {
    var index = 0;
    $.each(collection, function(key, value) {
      iterator(key, value, index++);
    });
  }

  function sanitize(options) {
    var buttons;
    var total;

    if (typeof options !== "object") {
      throw new Error("Please supply an object of options");
    }

    if (!options.message) {
      throw new Error("Please specify a message");
    }

    // ensure that supplied options take precedence over defaults
    options = $.extend({}, defaults, options);

    if (!options.buttons) {
      options.buttons = {};
    }

    // Bootstrap's "static" and false backdrop args are supported only
    options.backdrop = options.backdrop ? "static" : false;

    buttons = options.buttons;

    total = getKeyLength(buttons);

    each(buttons, function(key, button, index) {

      if ($.isFunction(button)) {
        button = buttons[key] = {
          callback: button
        };
      }

      // Check if the btn has correct type
      if ($.type(button) !== "object") {
        throw new Error("button with key " + key + " must be an object");
      }

      if (!button.label) {
        button.label = key;
      }

      if (!button.className) {
        if (total <= 2 && index === total-1) {
          // Important: add primary to the main option in a 2 btn dialog
          button.className = "btn-primary";
        } else {
          button.className = "btn-default";
        }
      }
    });

    return options;
  }

  function mapArguments(args, properties) {
    var argn = args.length;
    var options = {};

    if (argn < 1 || argn > 2) {
      throw new Error("Invalid argument length");
    }

    if (argn === 2 || typeof args[0] === "string") {
      options[properties[0]] = args[0];
      options[properties[1]] = args[1];
    } else {
      options = args[0];
    }

    return options;
  }

  /*
   * merge default dialog options with user supplied arguments
   */
  function mergeArguments(defaults, args, properties) {
    return $.extend(
      // deep merge
      true,
      // make sure that the target is an empty, unreferenced object
      {},
      // base options object for this type of dialog (usaully - buttons)
      defaults,
      // args could be an object or array;
      //  if it's array properties - map it to a proper options object
      mapArguments(
        args,
        properties
      )
    );
  }

  /**
   * Take inputs range and return valid options suitable for passing to bootbox.dialog
   */
  function mergeDialogOptions(className, labels, properties, args) {
    //  Create base set of dialog properties
    var baseOptions = {
      className: "bootbox-" + className,
      buttons: createLabels.apply(null, labels)
    };

    // Check generated buttons
    return validateButtons(
      // merge generated base properties with user supplied arguments
      mergeArguments(
        baseOptions,
        args,
        properties
      ),
      labels
    );
  }

  /**
   * Return a suitable object of button labels
   */
  function createLabels() {
    var buttons = {};

    for (var i = 0, j = arguments.length; i < j; i++) {
      var argument = arguments[i];
      var key = argument.toLowerCase();
      var value = argument.toUpperCase();

      buttons[key] = {
        label: _t(value)
      };
    }

    return buttons;
  }

  function validateButtons(options, buttons) {
    var allowedButtons = {};
    each(buttons, function(key, value) {
      allowedButtons[value] = true;
    });

    each(options.buttons, function(key) {
      if (allowedButtons[key] === undefined) {
        throw new Error("button key " + key + " is not allowed (options are " + buttons.join("\n") + ")");
      }
    });

    return options;
  }

  exports.defineLocale = function (name, values) {
      if (values) {
          locales[name] = {
              OK: values.OK,
              CANCEL: values.CANCEL,
              CONFIRM: values.CONFIRM
          };
          return locales[name];
      } else {
          delete locales[name];
          return null;
      }
  };

  exports.alert = function() {
    var options;

    options = mergeDialogOptions("alert", ["ok"], ["message", "callback"], arguments);

    if (options.callback && !$.isFunction(options.callback)) {
      throw new Error("alert requires callback property to be a function when provided");
    }

    /**
     * Some overrides
     */
    options.buttons.ok.callback = options.onEscape = function() {
      if ($.isFunction(options.callback)) {
        return options.callback();
      }
      return true;
    };

    return exports.dialog(options);
  };

  exports.confirm = function() {
    var options;

    options = mergeDialogOptions("confirm", ["cancel", "confirm"], ["message", "callback"], arguments);

    /**
     * More overrides; undo all that user tried to set he shouldn't have
     */
    options.buttons.cancel.callback = options.onEscape = function() {
      return options.callback(false);
    };

    options.buttons.confirm.callback = function() {
      return options.callback(true);
    };

    // Specific validation confirmation
    if (!$.isFunction(options.callback)) {
      throw new Error("confirm requires a callback");
    }

    return exports.dialog(options);
  };

  exports.prompt = function() {
    var options;
    var defaults;
    var dialog;
    var form;
    var input;
    var shouldShow;
    var inputOptions;

    // First of all = we have to create form
    form = $(templates.form);

    defaults = {
      className: "bootbox-prompt",
      buttons: createLabels("cancel", "confirm"),
      value: "",
      inputType: "text"
    };

    options = validateButtons(
      mergeArguments(defaults, arguments, ["title", "callback"]),
      ["cancel", "confirm"]
    );

    shouldShow = (options.show === undefined) ? true : options.show;

    /**
     * Undo all that user tried to set he shouldn't have
     */
    options.message = form;

    options.buttons.cancel.callback = options.onEscape = function() {
      return options.callback(null);
    };

    options.buttons.confirm.callback = function() {
      var value;

      switch (options.inputType) {
        case "text":
        case "textarea":
        case "email":
        case "select":
        case "date":
        case "time":
        case "number":
        case "password":
          value = input.val();
          break;

        case "checkbox":
          var checkedItems = input.find("input:checked");

          value = [];

          each(checkedItems, function(_, item) {
            value.push($(item).val());
          });
          break;
      }

      return options.callback(value);
    };

    options.show = false;

    // Prompt for specific validation
    if (!options.title) {
      throw new Error("prompt requires a title");
    }

    if (!$.isFunction(options.callback)) {
      throw new Error("prompt requires a callback");
    }

    if (!templates.inputs[options.inputType]) {
      throw new Error("invalid prompt type");
    }

    // Add input based on the supplied type
    input = $(templates.inputs[options.inputType]);

    switch (options.inputType) {
      case "text":
      case "textarea":
      case "email":
      case "date":
      case "time":
      case "number":
      case "password":
        input.val(options.value);
        break;

      case "select":
        var groups = {};
        inputOptions = options.inputOptions || [];

        if (!inputOptions.length) {
          throw new Error("prompt with select requires options");
        }

        each(inputOptions, function(_, option) {

          // assume the element to attach to is the input
          var elem = input;

          if (option.value === undefined || option.text === undefined) {
            throw new Error("given options in wrong format");
          }

          // but override that element if this option sits in a group

          if (option.group) {
            // initialise the group if necessary
            if (!groups[option.group]) {
              groups[option.group] = $("<optgroup/>").attr("label", option.group);
            }

            elem = groups[option.group];
          }

          elem.append("<option value='" + option.value + "'>" + option.text + "</option>");
        });

        each(groups, function(_, group) {
          input.append(group);
        });

        // safe to set a select value as per a normal input
        input.val(options.value);
        break;

      case "checkbox":
        var values   = $.isArray(options.value) ? options.value : [options.value];
        inputOptions = options.inputOptions || [];

        if (!inputOptions.length) {
          throw new Error("prompt with checkbox requires options");
        }

        if (!inputOptions[0].value || !inputOptions[0].text) {
          throw new Error("given options in wrong format");
        }

        // Checkboxes should be nested within a containing element
        input = $("<div/>");

        each(inputOptions, function(_, option) {
          var checkbox = $(templates.inputs[options.inputType]);

          checkbox.find("input").attr("value", option.value);
          checkbox.find("label").append(option.text);

          // Check array values for later iteration if needed
          each(values, function(_, value) {
            if (value === option.value) {
              checkbox.find("input").prop("checked", true);
            }
          });

          input.append(checkbox);
        });
        break;
    }

    if (options.placeholder) {
      input.attr("placeholder", options.placeholder);
    }

    if(options.pattern){
      input.attr("pattern", options.pattern);
    }

    // now place it in the form
    form.append(input);

    form.on("submit", function(e) {
      e.preventDefault();
      e.stopPropagation();
      dialog.find(".btn-primary").click();
    });

    dialog = exports.dialog(options);

    // clear existing handler focusing the submit button
    dialog.off("shown.bs.modal");

    // and replace it with the one focusing our input, if possible
    dialog.on("shown.bs.modal", function() {
      input.focus();
    });

    if (shouldShow === true) {
      dialog.modal("show");
    }

    return dialog;
  };

  exports.dialog = function(options) {
    options = sanitize(options);

    var dialog = $(templates.dialog);
    var innerDialog = dialog.find(".modal-dialog");
    var body = dialog.find(".modal-body");
    var buttons = options.buttons;
    var buttonStr = "";
    var callbacks = {
      onEscape: options.onEscape
    };

    if ($.fn.modal === undefined) {
      throw new Error(
        "$.fn.modal is not defined; please ensure you have included " +
        "Bootstrap JS.(http://getbootstrap.com/javascript/)"
      );
    }

    each(buttons, function(key, button) {

      buttonStr += "<button data-bb-handler='" + key + "' type='button' class='btn " + button.className + "'>" + button.label + "</button>";
      callbacks[key] = button.callback;
    });

    body.find(".bootbox-body").html(options.message);

    if (options.animate === true) {
      dialog.addClass("fade");
    }

    if (options.className) {
      dialog.addClass(options.className);
    }

    if (options.size === "large") {
      innerDialog.addClass("modal-lg");
    }

    if (options.size === "small") {
      innerDialog.addClass("modal-sm");
    }

    if (options.title) {
      body.before(templates.header);
    }

    if (options.closeButton) {
      var closeButton = $(templates.closeButton);

      if (options.title) {
        dialog.find(".modal-header").prepend(closeButton);
      } else {
        closeButton.css("margin-top", "-10px").prependTo(body);
      }
    }

    if (options.title) {
      dialog.find(".modal-title").html(options.title);
    }

    if (buttonStr.length) {
      body.after(templates.footer);
      dialog.find(".modal-footer").html(buttonStr);
    }


    dialog.on("hidden.bs.modal", function(e) {
      // Check if we do not accidentally intercept hidden events triggered
      // by children of the current dialog.
      if (e.target === this) {
        dialog.remove();
      }
    });

    dialog.on("shown.bs.modal", function() {
      dialog.find(".btn-primary:first").focus();
    });

    /**
     * Bootbox event listeners
     */

    dialog.on("escape.close.bb", function(e) {
      if (callbacks.onEscape) {
        processCallback(e, dialog, callbacks.onEscape);
      }
    });

    /**
     * Standard jQuery event listeners
     */

    dialog.on("click", ".modal-footer button", function(e) {
      var callbackKey = $(this).data("bb-handler");

      processCallback(e, dialog, callbacks[callbackKey]);

    });

    dialog.on("click", ".bootbox-close-button", function(e) {
      processCallback(e, dialog, callbacks.onEscape);
    });

    dialog.on("keyup", function(e) {
      if (e.which === 27) {
        dialog.trigger("escape.close.bb");
      }
    });

    // Add dialog to the DOM

    $(options.container).append(dialog);

    dialog.modal({
      backdrop: options.backdrop,
      keyboard: options.keyboard || false,
      show: false
    });

    if (options.show) {
      dialog.modal("show");
    }

    return dialog;

  };

  exports.setDefaults = function() {
    var values = {};

    if (arguments.length === 2) {
      // allow passing of single key / value
      values[arguments[0]] = arguments[1];
    } else {
      // and as an object too
      values = arguments[0];
    }

    $.extend(defaults, values);
  };

  exports.hideAll = function() {
    $(".bootbox").modal("hide");

    return exports;
  };


  // Standard locales
  var locales = {
    br : {
      OK      : "OK",
      CANCEL  : "Cancelar",
      CONFIRM : "Sim"
    },
    cs : {
      OK      : "OK",
      CANCEL  : "Zrušit",
      CONFIRM : "Potvrdit"
    },
    da : {
      OK      : "OK",
      CANCEL  : "Annuller",
      CONFIRM : "Accepter"
    },
    de : {
      OK      : "OK",
      CANCEL  : "Abbrechen",
      CONFIRM : "Akzeptieren"
    },
    el : {
      OK      : "Εντάξει",
      CANCEL  : "Ακύρωση",
      CONFIRM : "Επιβεβαίωση"
    },
    en : {
      OK      : "OK",
      CANCEL  : "Cancel",
      CONFIRM : "OK"
    },
    es : {
      OK      : "OK",
      CANCEL  : "Cancelar",
      CONFIRM : "Aceptar"
    },
    et : {
      OK      : "OK",
      CANCEL  : "Katkesta",
      CONFIRM : "OK"
    },
    fi : {
      OK      : "OK",
      CANCEL  : "Peruuta",
      CONFIRM : "OK"
    },
    fr : {
      OK      : "OK",
      CANCEL  : "Annuler",
      CONFIRM : "D'accord"
    },
    he : {
      OK      : "אישור",
      CANCEL  : "ביטול",
      CONFIRM : "אישור"
    },
    hu : {
      OK      : "OK",
      CANCEL  : "Mégsem",
      CONFIRM : "Megerősít"
    },
    hr : {
      OK      : "OK",
      CANCEL  : "Odustani",
      CONFIRM : "Potvrdi"
    },
    id : {
      OK      : "OK",
      CANCEL  : "Batal",
      CONFIRM : "OK"
    },
    it : {
      OK      : "OK",
      CANCEL  : "Annulla",
      CONFIRM : "Conferma"
    },
    ja : {
      OK      : "OK",
      CANCEL  : "キャンセル",
      CONFIRM : "確認"
    },
    lt : {
      OK      : "Gerai",
      CANCEL  : "Atšaukti",
      CONFIRM : "Patvirtinti"
    },
    lv : {
      OK      : "Labi",
      CANCEL  : "Atcelt",
      CONFIRM : "Apstiprināt"
    },
    nl : {
      OK      : "OK",
      CANCEL  : "Annuleren",
      CONFIRM : "Accepteren"
    },
    no : {
      OK      : "OK",
      CANCEL  : "Avbryt",
      CONFIRM : "OK"
    },
    pl : {
      OK      : "OK",
      CANCEL  : "Anuluj",
      CONFIRM : "Potwierdź"
    },
    pt : {
      OK      : "OK",
      CANCEL  : "Cancelar",
      CONFIRM : "Confirmar"
    },
    ru : {
      OK      : "OK",
      CANCEL  : "Отмена",
      CONFIRM : "Применить"
    },
    sv : {
      OK      : "OK",
      CANCEL  : "Avbryt",
      CONFIRM : "OK"
    },
    tr : {
      OK      : "Tamam",
      CANCEL  : "İptal",
      CONFIRM : "Onayla"
    },
    zh_CN : {
      OK      : "OK",
      CANCEL  : "取消",
      CONFIRM : "确认"
    },
    zh_TW : {
      OK      : "OK",
      CANCEL  : "取消",
      CONFIRM : "確認"
    }
  };

  exports.init = function(_$) {
    return init(_$ || $);
  };

  return exports;
}));



;
(function($) {

function defined(a) {
	return typeof a !== 'undefined';
}

function extend(child, parent, prototype) {
    var F = function() {};
    F.prototype = parent.prototype;
    child.prototype = new F();
    child.prototype.constructor = child;
	parent.prototype.constructor = parent;
    child._super = parent.prototype;
    if (prototype) {
        $.extend(child.prototype, prototype);
    }
}

var SUBST = [
    ['', ''],               // specification
    ['exit', 'cancel'],     // Mozilla FF & old webkits expect cancelFullScreen instead of exitFullscreen
    ['screen', 'Screen']    // Mozilla FF expects FullScreen instead of Fullscreen
];

var VENDOR_PREFIXES = ['', 'o', 'ms', 'moz', 'webkit', 'webkitCurrent'];

function native(obj, name) {
    var prefixed;

    if (typeof obj === 'string') {
        name = obj;
        obj = document;
    }

    for (var i = 0; i < SUBST.length; ++i) {
        name = name.replace(SUBST[i][0], SUBST[i][1]);
        for (var j = 0; j < VENDOR_PREFIXES.length; ++j) {
            prefixed = VENDOR_PREFIXES[j];
            prefixed += j === 0 ? name : name.charAt(0).toUpperCase() + name.substr(1);
            if (defined(obj[prefixed])) {
                return obj[prefixed];
            }
        }
    }

    return void 0;
}var ua = navigator.userAgent;
var fsEnabled = native('fullscreenEnabled');
var IS_ANDROID_CHROME = ua.indexOf('Android') !== -1 && ua.indexOf('Chrome') !== -1; 
var IS_NATIVELY_SUPPORTED = 
		!IS_ANDROID_CHROME &&
		 defined(native('fullscreenElement')) && 
		(!defined(fsEnabled) || fsEnabled === true);

var version = $.fn.jquery.split('.');
var JQ_LT_17 = (parseInt(version[0]) < 2 && parseInt(version[1]) < 7);

var FullScreenAbstract = function() {
	this.__options = null;
	this._fullScreenElement = null;
	this.__savedStyles = {};
};

FullScreenAbstract.prototype = {
	_DEFAULT_OPTIONS: {
		styles: {
			'boxSizing': 'border-box',
			'MozBoxSizing': 'border-box',
			'WebkitBoxSizing': 'border-box'
		},
		toggleClass: null
	},
	__documentOverflow: 'visible',
	__htmlOverflow: 'visible',
	_preventDocumentScroll: function() {
		// Disable ability
		this.__documentOverflow = $('body')[0].style.overflow;
		this.__htmlOverflow = $('html')[0].style.overflow;
		
	},
	_allowDocumentScroll: function() {
		$('body')[0].style.overflow = this.__documentOverflow;
		$('html')[0].style.overflow = this.__htmlOverflow;
	},
	_fullScreenChange: function() {
		if (!this.__options)
			return; // We process fullscreenchange events caused by this plugin
		if (!this.isFullScreen()) {
			this._allowDocumentScroll();
			this._revertStyles();
			this._triggerEvents();
			this._fullScreenElement = null;
		} else {
			this._preventDocumentScroll();
			this._triggerEvents();
		}
	},
	_fullScreenError: function(e) {
		if (!this.__options)
			return; // We process fullscreenchange events caused by this plugin
		this._revertStyles();
		this._fullScreenElement = null;
		if (e) {
			$(document).trigger('fscreenerror', [e]);
		}
	},
	_triggerEvents: function() {
		$(this._fullScreenElement).trigger(this.isFullScreen() ? 'fscreenopen' : 'fscreenclose');
		$(document).trigger('fscreenchange', [this.isFullScreen(), this._fullScreenElement]);
	},
	_saveAndApplyStyles: function() {
		var $elem = $(this._fullScreenElement);
		this.__savedStyles = {};
		for (var property in this.__options.styles) {
			// THIS save
			this.__savedStyles[property] = this._fullScreenElement.style[property];
			// THIS apply
			this._fullScreenElement.style[property] = this.__options.styles[property];
		}
		if (this.__options.toggleClass) {
			$elem.addClass(this.__options.toggleClass);
		}
	},
	_revertStyles: function() {
		var $elem = $(this._fullScreenElement);
		for (var property in this.__options.styles) {
			this._fullScreenElement.style[property] = this.__savedStyles[property];
		}
		if (this.__options.toggleClass) {
			$elem.removeClass(this.__options.toggleClass);
		}
	},
	open: function(elem, options) {
		// do nothing if request it's for already fullscreened element
		if (elem === this._fullScreenElement) {
			return;
		}
		// exit active fullscreen before opening another
		if (this.isFullScreen()) {
			this.exit();
		}
		// save fullscreened elem
		this._fullScreenElement = elem;
		// apply options if any
		this.__options = $.extend(true, {}, this._DEFAULT_OPTIONS, options);
		// save current element styles and apply new ones
		this._saveAndApplyStyles();
	},
	exit: null,
	isFullScreen: null,
	isNativelySupported: function() {
		return IS_NATIVELY_SUPPORTED;
	}
};
var FullScreenNative = function() {
	FullScreenNative._super.constructor.apply(this, arguments);
	this.exit = $.proxy(native('exitFullscreen'), document);
	this._DEFAULT_OPTIONS = $.extend(true, {}, this._DEFAULT_OPTIONS, {
		'styles': {
			'width': '100%',
			'height': '100%'
		}
	});
	$(document)
		.bind(this._prefixedString('fullscreenchange') + ' MSFullscreenChange', $.proxy(this._fullScreenChange, this))
		.bind(this._prefixedString('fullscreenerror') + ' MSFullscreenError', $.proxy(this._fullScreenError, this));
};

extend(FullScreenNative, FullScreenAbstract, {
	VENDOR_PREFIXES: ['', 'o', 'moz', 'webkit'],
	_prefixedString: function(str) {
		return $.map(this.VENDOR_PREFIXES, function(s) {
			return s + str;
		}).join(' ');
	},
	open: function(elem, options) {
		FullScreenNative._super.open.apply(this, arguments);
		var requestFS = native(elem, 'requestFullscreen');
		requestFS.call(elem);
	},
	exit: $.noop,
	isFullScreen: function() {
		return native('fullscreenElement') !== null;
	},
	element: function() {
		return native('fullscreenElement');
	}
});
var FullScreenFallback = function() {
	FullScreenFallback._super.constructor.apply(this, arguments);
	this._DEFAULT_OPTIONS = $.extend({}, this._DEFAULT_OPTIONS, {
		'styles': {
			'position': 'fixed',
			'zIndex': '2147483647',
			'left': 0,
			'top': 0,
			'bottom': 0,
			'right': 0
		}
	});
	this.__delegateKeydownHandler();
};

extend(FullScreenFallback, FullScreenAbstract, {
	__isFullScreen: false,
	__delegateKeydownHandler: function() {
		var $doc = $(document);
		$doc.delegate('*', 'keydown.fullscreen', $.proxy(this.__keydownHandler, this));
		var data = JQ_LT_17 ? $doc.data('events') : $._data(document).events;
		var events = data['keydown'];
		if (!JQ_LT_17) {
			events.splice(0, 0, events.splice(events.delegateCount - 1, 1)[0]);
		} else {
			data.live.unshift(data.live.pop());
		}
	},
	__keydownHandler: function(e) {
		if (this.isFullScreen() && e.which === 27) {
			this.exit();
			return false;
		}
		return true;
	},
	_revertStyles: function() {
		FullScreenFallback._super._revertStyles.apply(this, arguments);
		// force redraw
		this._fullScreenElement.offsetHeight;
	},
	open: function(elem) {
		FullScreenFallback._super.open.apply(this, arguments);
		this.__isFullScreen = true;
		this._fullScreenChange();
	},
	exit: function() {
		this.__isFullScreen = false;
		this._fullScreenChange();
	},
	isFullScreen: function() {
		return this.__isFullScreen;
	},
	element: function() {
		return this.__isFullScreen ? this._fullScreenElement : null;
	}
});$.fullscreen = IS_NATIVELY_SUPPORTED 
				? new FullScreenNative() 
				: new FullScreenFallback();

$.fn.fullscreen = function(options) {
	var elem = this[0];

	options = $.extend({
		toggleClass: null,
		overflow: 'hidden'
	}, options);
	options.styles = {
		overflow: options.overflow
	};
	delete options.overflow;

	if (elem) {
		$.fullscreen.open(elem, options);
	}

	return this;
};
})(jQuery);

/*!
 ** hoverIntent v1.8.0 - Copyright 2014 Brian Cherne
 ** http://cherne.net/brian/resources/jquery.hoverIntent.html
 ** You are free to use hoverIntent as long as this header is left intact.
 */

(function($){$.fn.hoverIntent=function(handlerIn,handlerOut,selector){var cfg={interval:100,sensitivity:6,timeout:0};if(typeof handlerIn==="object"){cfg=$.extend(cfg,handlerIn)}else{if($.isFunction(handlerOut)){cfg=$.extend(cfg,{over:handlerIn,out:handlerOut,selector:selector})}else{cfg=$.extend(cfg,{over:handlerIn,out:handlerIn,selector:handlerOut})}}var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if(Math.sqrt((pX-cX)*(pX-cX)+(pY-cY)*(pY-cY))<cfg.sensitivity){$(ob).off("mousemove.hoverIntent",track);ob.hoverIntent_s=true;return cfg.over.apply(ob,[ev])}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=false;return cfg.out.apply(ob,[ev])};var handleHover=function(e){var ev=$.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t)}if(e.type==="mouseenter"){pX=ev.pageX;pY=ev.pageY;$(ob).on("mousemove.hoverIntent",track);if(!ob.hoverIntent_s){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}}else{$(ob).off("mousemove.hoverIntent",track);if(ob.hoverIntent_s){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob)},cfg.timeout)}}};return this.on({"mouseenter.hoverIntent":handleHover,"mouseleave.hoverIntent":handleHover},cfg.selector)}})(jQuery);

/*! Copyright (c) 2011 Brandon Aaron (http://brandonaaron.net)
 ** Licensed under the MIT License (LICENSE.txt).
 ** Version: 3.0.6
 */

!function(a){function d(b){var c=b||window.event,d=[].slice.call(arguments,1),e=0,g=0,h=0;return b=a.event.fix(c),b.type="mousewheel",c.wheelDelta&&(e=c.wheelDelta/120),c.detail&&(e=-c.detail/3),h=e,void 0!==c.axis&&c.axis===c.HORIZONTAL_AXIS&&(h=0,g=-1*e),void 0!==c.wheelDeltaY&&(h=c.wheelDeltaY/120),void 0!==c.wheelDeltaX&&(g=-1*c.wheelDeltaX/120),d.unshift(b,e,g,h),(a.event.dispatch||a.event.handle).apply(this,d)}var b=["DOMMouseScroll","mousewheel"];if(a.event.fixHooks)for(var c=b.length;c;)a.event.fixHooks[b[--c]]=a.event.mouseHooks;a.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var a=b.length;a;)this.addEventListener(b[--a],d,!1);else this.onmousewheel=d},teardown:function(){if(this.removeEventListener)for(var a=b.length;a;)this.removeEventListener(b[--a],d,!1);else this.onmousewheel=null}},a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})}(jQuery);

/*!
 ** jQuery Smooth Scroll - v1.5.4 - 2014-11-17
 ** https://github.com/kswedberg/jquery-smooth-scroll
 ** Copyright (c) 2014 Karl Swedberg
 ** Licensed MIT (https://github.com/kswedberg/jquery-smooth-scroll/blob/master/LICENSE-MIT)
 */

(function(t){"function"==typeof define&&define.amd?define(["jquery"],t):t(jQuery)})(function(t){function e(t){return t.replace(/(:|\.|\/)/g,"\\$1")}var l="1.5.4",o={},n={exclude:[],excludeWithin:[],offset:0,direction:"top",scrollElement:null,scrollTarget:null,beforeScroll:function(){},afterScroll:function(){},easing:"swing",speed:400,autoCoefficient:2,preventDefault:!0},s=function(e){var l=[],o=!1,n=e.dir&&"left"===e.dir?"scrollLeft":"scrollTop";return this.each(function(){if(this!==document&&this!==window){var e=t(this);e[n]()>0?l.push(this):(e[n](1),o=e[n]()>0,o&&l.push(this),e[n](0))}}),l.length||this.each(function(){"BODY"===this.nodeName&&(l=[this])}),"first"===e.el&&l.length>1&&(l=[l[0]]),l};t.fn.extend({scrollable:function(t){var e=s.call(this,{dir:t});return this.pushStack(e)},firstScrollable:function(t){var e=s.call(this,{el:"first",dir:t});return this.pushStack(e)},smoothScroll:function(l,o){if(l=l||{},"options"===l)return o?this.each(function(){var e=t(this),l=t.extend(e.data("ssOpts")||{},o);t(this).data("ssOpts",l)}):this.first().data("ssOpts");var n=t.extend({},t.fn.smoothScroll.defaults,l),s=t.smoothScroll.filterPath(location.pathname);return this.unbind("click.smoothscroll").bind("click.smoothscroll",function(l){var o=this,r=t(this),i=t.extend({},n,r.data("ssOpts")||{}),c=n.exclude,a=i.excludeWithin,f=0,h=0,u=!0,d={},p=location.hostname===o.hostname||!o.hostname,m=i.scrollTarget||t.smoothScroll.filterPath(o.pathname)===s,S=e(o.hash);if(i.scrollTarget||p&&m&&S){for(;u&&c.length>f;)r.is(e(c[f++]))&&(u=!1);for(;u&&a.length>h;)r.closest(a[h++]).length&&(u=!1)}else u=!1;u&&(i.preventDefault&&l.preventDefault(),t.extend(d,i,{scrollTarget:i.scrollTarget||S,link:o}),t.smoothScroll(d))}),this}}),t.smoothScroll=function(e,l){if("options"===e&&"object"==typeof l)return t.extend(o,l);var n,s,r,i,c,a=0,f="offset",h="scrollTop",u={},d={};"number"==typeof e?(n=t.extend({link:null},t.fn.smoothScroll.defaults,o),r=e):(n=t.extend({link:null},t.fn.smoothScroll.defaults,e||{},o),n.scrollElement&&(f="position","static"===n.scrollElement.css("position")&&n.scrollElement.css("position","relative"))),h="left"===n.direction?"scrollLeft":h,n.scrollElement?(s=n.scrollElement,/^(?:HTML|BODY)$/.test(s[0].nodeName)||(a=s[h]())):s=t("html, body").firstScrollable(n.direction),n.beforeScroll.call(s,n),r="number"==typeof e?e:l||t(n.scrollTarget)[f]()&&t(n.scrollTarget)[f]()[n.direction]||0,u[h]=r+a+n.offset,i=n.speed,"auto"===i&&(c=u[h]-s.scrollTop(),0>c&&(c*=-1),i=c/n.autoCoefficient),d={duration:i,easing:n.easing,complete:function(){n.afterScroll.call(n.link,n)}},n.step&&(d.step=n.step),s.length?s.stop().animate(u,d):n.afterScroll.call(n.link,n)},t.smoothScroll.version=l,t.smoothScroll.filterPath=function(t){return t=t||"",t.replace(/^\//,"").replace(/(?:index|default).[a-zA-Z]{3,4}$/,"").replace(/\/$/,"")},t.fn.smoothScroll.defaults=n});

/*
 ** jQuery UI Touch Punch 0.2.3
 */

!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);

/*
 ** https://github.com/douglascrockford/JSON-js/blob/master/json2.js
 */

var JSON;if(!JSON){JSON={}}(function(){function f(a){return a<10?"0"+a:a}function quote(a){escapable.lastIndex=0;return escapable.test(a)?'"'+a.replace(escapable,function(a){var b=meta[a];return typeof b==="string"?b:"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+a+'"'}function str(a,b){var c,d,e,f,g=gap,h,i=b[a];if(i&&typeof i==="object"&&typeof i.toJSON==="function"){i=i.toJSON(a)}if(typeof rep==="function"){i=rep.call(b,a,i)}switch(typeof i){case"string":return quote(i);case"number":return isFinite(i)?String(i):"null";case"boolean":case"null":return String(i);case"object":if(!i){return"null"}gap+=indent;h=[];if(Object.prototype.toString.apply(i)==="[object Array]"){f=i.length;for(c=0;c<f;c+=1){h[c]=str(c,i)||"null"}e=h.length===0?"[]":gap?"[\n"+gap+h.join(",\n"+gap)+"\n"+g+"]":"["+h.join(",")+"]";gap=g;return e}if(rep&&typeof rep==="object"){f=rep.length;for(c=0;c<f;c+=1){if(typeof rep[c]==="string"){d=rep[c];e=str(d,i);if(e){h.push(quote(d)+(gap?": ":":")+e)}}}}else{for(d in i){if(Object.prototype.hasOwnProperty.call(i,d)){e=str(d,i);if(e){h.push(quote(d)+(gap?": ":":")+e)}}}}e=h.length===0?"{}":gap?"{\n"+gap+h.join(",\n"+gap)+"\n"+g+"}":"{"+h.join(",")+"}";gap=g;return e}}"use strict";if(typeof Date.prototype.toJSON!=="function"){Date.prototype.toJSON=function(a){return isFinite(this.valueOf())?this.getUTCFullYear()+"-"+f(this.getUTCMonth()+1)+"-"+f(this.getUTCDate())+"T"+f(this.getUTCHours())+":"+f(this.getUTCMinutes())+":"+f(this.getUTCSeconds())+"Z":null};String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(a){return this.valueOf()}}var cx=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,escapable=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,gap,indent,meta={"\b":"\\b"," ":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},rep;if(typeof JSON.stringify!=="function"){JSON.stringify=function(a,b,c){var d;gap="";indent="";if(typeof c==="number"){for(d=0;d<c;d+=1){indent+=" "}}else if(typeof c==="string"){indent=c}rep=b;if(b&&typeof b!=="function"&&(typeof b!=="object"||typeof b.length!=="number")){throw new Error("JSON.stringify")}return str("",{"":a})}}if(typeof JSON.parse!=="function"){JSON.parse=function(text,reviver){function walk(a,b){var c,d,e=a[b];if(e&&typeof e==="object"){for(c in e){if(Object.prototype.hasOwnProperty.call(e,c)){d=walk(e,c);if(d!==undefined){e[c]=d}else{delete e[c]}}}}return reviver.call(a,b,e)}var j;text=String(text);cx.lastIndex=0;if(cx.test(text)){text=text.replace(cx,function(a){return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})}if(/^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,""))){j=eval("("+text+")");return typeof reviver==="function"?walk({"":j},""):j}throw new SyntaxError("JSON.parse")}}})();

/*!
 ** Scroll Lock v1.1.1
 ** https://github.com/MohammadYounes/jquery-scrollLock
 */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a(jQuery)}(function(a){function e(a){var b=a.prop("clientWidth"),c=a.prop("offsetWidth"),d=parseInt(a.css("border-right-width"),10),e=parseInt(a.css("border-left-width"),10);return c>b+e+d}var b="onmousewheel"in window?"ActiveXObject"in window?"wheel":"mousewheel":"DOMMouseScroll",c=".scrollLock",d=a.fn.scrollLock;a.fn.scrollLock=function(d,f,g){return"string"!=typeof f&&(f=null),void 0!==d&&!d||"off"===d?this.each(function(){a(this).off(c)}):this.each(function(){a(this).on(b+c,f,function(b){if(!b.ctrlKey){var c=a(this);if(g===!0||e(c)){b.stopPropagation();var d=c.scrollTop(),f=c.prop("scrollHeight"),h=c.prop("clientHeight"),i=b.originalEvent.wheelDelta||-1*b.originalEvent.detail||-1*b.originalEvent.deltaY,j=0;if("wheel"===b.type){var k=c.height()/a(window).height();j=b.originalEvent.deltaY*k}(i>0&&0>=d+j||0>i&&d+j>=f-h)&&(b.preventDefault(),j&&c.scrollTop(d+j))}}})})},a.fn.scrollLock.noConflict=function(){return a.fn.scrollLock=d,this}});




! function($) {

   "use strict"; // js hint

   if (typeof ko !== 'undefined' && ko.bindingHandlers && !ko.bindingHandlers.multiselect) {
      ko.bindingHandlers.multiselect = {

         init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {

            var listOfSelectedItems = allBindingsAccessor().selectedOptions;
            var config = ko.utils.unwrapObservable(valueAccessor());

            $(element).multiselect(config);

            if (isObservableArray(listOfSelectedItems)) {

               // Set initial selection state on the multiselect list
               $(element).multiselect('select', ko.utils.unwrapObservable(listOfSelectedItems));

               // Subscribe to selectedOptions: ko.observableArray
               listOfSelectedItems.subscribe(function(changes) {
                  var addedArray = [],
                     deletedArray = [];
                  forEach(changes, function(change) {
                     switch (change.status) {
                        case 'added':
                           addedArray.push(change.value);
                           break;
                        case 'deleted':
                           deletedArray.push(change.value);
                           break;
                     }
                  });

                  if (addedArray.length > 0) {
                     $(element).multiselect('select', addedArray);
                  }

                  if (deletedArray.length > 0) {
                     $(element).multiselect('deselect', deletedArray);
                  }
               }, null, "arrayChange");
            }
         },

         update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {

            var listOfItems = allBindingsAccessor().options,
               ms = $(element).data('multiselect'),
               config = ko.utils.unwrapObservable(valueAccessor());

            if (isObservableArray(listOfItems)) {
               // Subscribe to the options: ko.observableArray if it changes later
               listOfItems.subscribe(function(theArray) {
                  $(element).multiselect('rebuild');
               });
            }

            if (!ms) {
               $(element).multiselect(config);
            } else {
               ms.updateOriginalOptions();
            }
         }
      };
   }

   function isObservableArray(obj) {
      return ko.isObservable(obj) && !(obj.destroyAll === undefined);
   }

   function forEach(array, callback) {
      for (var index = 0; index < array.length; ++index) {
         callback(array[index]);
      }
   }

   /**
    * Constructor - create new multiselect from the given select
    *
    * @param {jQuery} select
    * @param {Object} options
    * @returns {Multiselect}
    */
   function Multiselect(select, options) {

      this.$select = $(select);
      this.options = this.mergeOptions($.extend({}, options, this.$select.data()));

      // Initialization (we have to clone it for a new reference)
      this.originalOptions = this.$select.clone()[0].options;
      this.query = '';
      this.searchTimeout = null;

      this.options.multiple = this.$select.attr('multiple') === "multiple";
      this.options.onChange = $.proxy(this.options.onChange, this);
      this.options.onDropdownShow = $.proxy(this.options.onDropdownShow, this);
      this.options.onDropdownHide = $.proxy(this.options.onDropdownHide, this);
      this.options.onDropdownShown = $.proxy(this.options.onDropdownShown, this);
      this.options.onDropdownHidden = $.proxy(this.options.onDropdownHidden, this);

      // Build select all if enabled
      this.buildContainer();
      this.buildButton();
      this.buildDropdown();
      this.buildSelectAll();
      this.buildDropdownOptions();
      this.buildFilter();

      this.updateButtonText();
      this.updateSelectAll();

      if (this.options.disableIfEmpty && $('option', this.$select).length <= 0) {
         this.disable();
      }

      this.$select.hide().after(this.$container);
   };

   Multiselect.prototype = {

      defaults: {
         /**
          * Default text function will print 'None selected' in case no
          * option is selected or a list of selected options with max
          * 3 selected options.
          *
          * @param {jQuery} options
          * @param {jQuery} select
          * @returns {String}
          */
         buttonText: function(options, select) {
            if (options.length === 0) {
               return this.nonSelectedText + ' <b class="caret"></b>';
            } else if (options.length == $('option', $(select)).length) {
               return this.allSelectedText + ' <b class="caret"></b>';
            } else if (options.length > this.numberDisplayed) {
               return options.length + ' ' + this.nSelectedText + ' <b class="caret"></b>';
            } else {
               var selected = '';
               options.each(function() {
                  var label = ($(this).attr('label') !== undefined) ? $(this).attr('label') : $(this).html();

                  selected += label + ', ';
               });

               return selected.substr(0, selected.length - 2) + ' <b class="caret"></b>';
            }
         },
         /**
          * Updates the title of the button similar to the buttonText function
          *
          * @param {jQuery} options
          * @param {jQuery} select
          * @returns '/'@exp;selected@call;substr}
          */
         buttonTitle: function(options, select) {
            if (options.length === 0) {
               return this.nonSelectedText;
            } else {
               var selected = '';
               options.each(function() {
                  selected += $(this).text() + ', ';
               });
               return selected.substr(0, selected.length - 2);
            }
         },
         /**
          * Create a label
          *
          * @param {jQuery} element
          * @returns {String}
          */
         label: function(element) {
            return $(element).attr('label') || $(element).html();
         },
         /**
          * Triggered on change of the multiselect
          *
          * Not triggered when selecting / deselecting options manually
          *
          * @param {jQuery} option
          * @param {Boolean} checked
          */
         onChange: function(option, checked) {

         },
         /**
          * Triggered when the dropdown is shown
          *
          * @param {jQuery} event
          */
         onDropdownShow: function(event) {

         },
         /**
          * Triggered when the dropdown is hidden
          *
          * @param {jQuery} event
          */
         onDropdownHide: function(event) {

         },
         /**
          * Triggered after the dropdown is shown
          *
          * @param {jQuery} event
          */
         onDropdownShown: function(event) {

         },
         /**
          * Triggered after the dropdown is hidden
          *
          * @param {jQuery} event
          */
         onDropdownHidden: function(event) {

         },
         buttonClass: 'btn btn-default',
         buttonWidth: 'auto',
         buttonContainer: '<div class="btn-group" />',
         dropRight: false,
         selectedClass: 'active',
         maxHeight: false,
         checkboxName: false,
         includeSelectAllOption: false,
         includeSelectAllIfMoreThan: 0,
         selectAllText: ' Select all',
         selectAllValue: 'multiselect-all',
         selectAllName: false,
         enableFiltering: false,
         enableCaseInsensitiveFiltering: false,
         enableClickableOptGroups: false,
         filterPlaceholder: 'Search',
         filterBehavior: 'text', //  'text', 'value', 'both'
         includeFilterClearBtn: true,
         preventInputChangeEvent: false,
         nonSelectedText: 'None selected',
         nSelectedText: 'selected',
         allSelectedText: 'All selected',
         numberDisplayed: 3,
         disableIfEmpty: false,
         templates: {
            button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"></button>',
            ul: '<ul class="multiselect-container dropdown-menu"></ul>',
            filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
            filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default multiselect-clear-filter" type="button"><i class="glyphicon glyphicon-remove"></i></button></span>',
            li: '<li><a href="javascript:void(0);"><label></label></a></li>',
            divider: '<li class="multiselect-item divider"></li>',
            liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'
         }
      },

      constructor: Multiselect,

      /**
       * Builds multiselect container
       */
      buildContainer: function() {
         this.$container = $(this.options.buttonContainer);
         this.$container.on('show.bs.dropdown', this.options.onDropdownShow);
         this.$container.on('hide.bs.dropdown', this.options.onDropdownHide);
         this.$container.on('shown.bs.dropdown', this.options.onDropdownShown);
         this.$container.on('hidden.bs.dropdown', this.options.onDropdownHidden);
      },

      /**
       * Builds multiselect button
       */
      buildButton: function() {
         this.$button = $(this.options.templates.button).addClass(this.options.buttonClass);

         // Adopt active state
         if (this.$select.prop('disabled')) {
            this.disable();
         } else {
            this.enable();
         }

         // Manually add button width if set
         if (this.options.buttonWidth && this.options.buttonWidth !== 'auto') {
            this.$button.css({
               'width': this.options.buttonWidth
            });
            this.$container.css({
               'width': this.options.buttonWidth
            });
         }

         // Keep the tab index from the select
         var tabindex = this.$select.attr('tabindex');
         if (tabindex) {
            this.$button.attr('tabindex', tabindex);
         }

         this.$container.prepend(this.$button);
      },

      /**
       * Builds "ul" representing dropdown menu
       */
      buildDropdown: function() {

         // Build ul
         this.$ul = $(this.options.templates.ul);

         if (this.options.dropRight) {
            this.$ul.addClass('pull-right');
         }

         // Set dropdown menu max height to activate auto scrollbar
         if (this.options.maxHeight) {
            this.$ul.css({
               'max-height': this.options.maxHeight + 'px',
               'overflow-y': 'auto',
               'overflow-x': 'hidden'
            });
         }

         this.$container.append(this.$ul);
      },

      /**
       * Build dropdown options and bind all nessecary events
       *
       * Uses createDivider and createOptionValue to create necessary options
       */
      buildDropdownOptions: function() {

         this.$select.children().each($.proxy(function(index, element) {

            var $element = $(element);
            // Support optgroups and options without a group simultaneously
            var tag = $element.prop('tagName')
               .toLowerCase();

            if ($element.prop('value') === this.options.selectAllValue) {
               return;
            }

            if (tag === 'optgroup') {
               this.createOptgroup(element);
            } else if (tag === 'option') {

               if ($element.data('role') === 'divider') {
                  this.createDivider();
               } else {
                  this.createOptionValue(element);
               }

            }

            // Ignore illegal tags
         }, this));

         // Bind change event on the dropdown elements
         $('li input', this.$ul).on('change', $.proxy(function(event) {
            var $target = $(event.target);

            var checked = $target.prop('checked') || false;
            var isSelectAllOption = $target.val() === this.options.selectAllValue;

            // Apply or unapply configured selected class
            if (this.options.selectedClass) {
               if (checked) {
                  $target.closest('li')
                     .addClass(this.options.selectedClass);
               } else {
                  $target.closest('li')
                     .removeClass(this.options.selectedClass);
               }
            }

            // Get corresponding option
            var value = $target.val();
            var $option = this.getOptionByValue(value);

            var $optionsNotThis = $('option', this.$select).not($option);
            var $checkboxesNotThis = $('input', this.$container).not($target);

            if (isSelectAllOption) {
               if (checked) {
                  this.selectAll();
               } else {
                  this.deselectAll();
               }
            }

            if (!isSelectAllOption) {
               if (checked) {
                  $option.prop('selected', true);

                  if (this.options.multiple) {
                     // Select additional option
                     $option.prop('selected', true);
                  } else {
                     // Unselect all other options and corresponding checkboxes
                     if (this.options.selectedClass) {
                        $($checkboxesNotThis).closest('li').removeClass(this.options.selectedClass);
                     }

                     $($checkboxesNotThis).prop('checked', false);
                     $optionsNotThis.prop('selected', false);

                     // If single selection - close
                     this.$button.click();
                  }

                  if (this.options.selectedClass === "active") {
                     $optionsNotThis.closest("a").css("outline", "");
                  }
               } else {
                  // Unselect option
                  $option.prop('selected', false);
               }
            }

            this.$select.change();

            this.updateButtonText();
            this.updateSelectAll();

            this.options.onChange($option, checked);

            if (this.options.preventInputChangeEvent) {
               return false;
            }
         }, this));

         $('li a', this.$ul).on('touchstart click', function(event) {
            event.stopPropagation();

            var $target = $(event.target);

            if (document.getSelection().type === 'Range') {
               var $input = $(this).find("input:first");

               $input.prop("checked", !$input.prop("checked"))
                  .trigger("change");
            }

            if (event.shiftKey) {
               var checked = $target.prop('checked') || false;

               if (checked) {
                  var prev = $target.closest('li')
                     .siblings('li[class="active"]:first');

                  var currentIdx = $target.closest('li')
                     .index();
                  var prevIdx = prev.index();

                  if (currentIdx > prevIdx) {
                     $target.closest("li").prevUntil(prev).each(
                        function() {
                           $(this).find("input:first").prop("checked", true)
                              .trigger("change");
                        }
                     );
                  } else {
                     $target.closest("li").nextUntil(prev).each(
                        function() {
                           $(this).find("input:first").prop("checked", true)
                              .trigger("change");
                        }
                     );
                  }
               }
            }

            $target.blur();
         });

         // Keyboard support
         this.$container.off('keydown.multiselect').on('keydown.multiselect', $.proxy(function(event) {
            if ($('input[type="text"]', this.$container).is(':focus')) {
               return;
            }

            if (event.keyCode === 9 && this.$container.hasClass('open')) {
               this.$button.click();
            } else {
               var $items = $(this.$container).find("li:not(.divider):not(.disabled) a").filter(":visible");

               if (!$items.length) {
                  return;
               }

               var index = $items.index($items.filter(':focus'));

               // Navigation up
               if (event.keyCode === 38 && index > 0) {
                  index--;
               }
               // Navigate down
               else if (event.keyCode === 40 && index < $items.length - 1) {
                  index++;
               } else if (!~index) {
                  index = 0;
               }

               var $current = $items.eq(index);
               $current.focus();

               if (event.keyCode === 32 || event.keyCode === 13) {
                  var $checkbox = $current.find('input');

                  $checkbox.prop("checked", !$checkbox.prop("checked"));
                  $checkbox.change();
               }

               event.stopPropagation();
               event.preventDefault();
            }
         }, this));

         if (this.options.enableClickableOptGroups && this.options.multiple) {
            $('li.multiselect-group', this.$ul).on('click', $.proxy(function(event) {
               event.stopPropagation();

               var group = $(event.target).parent();

               // Search all options in optgroup
               var $options = group.nextUntil('li.multiselect-group');

               // check or uncheck needed items
               var allChecked = true;
               var optionInputs = $options.find('input');
               optionInputs.each(function() {
                  allChecked = allChecked && $(this).prop('checked');
               });

               optionInputs.prop('checked', !allChecked).trigger('change');
            }, this));
         }
      },

      /**
       * Create option using given select option
       * @param {jQuery} element
       */
      createOptionValue: function(element) {
         var $element = $(element);
         if ($element.is(':selected')) {
            $element.prop('selected', true);
         }

         // Support label attribute on options
         var label = this.options.label(element);
         var value = $element.val();
         var inputType = this.options.multiple ? "checkbox" : "radio";

         var $li = $(this.options.templates.li);
         var $label = $('label', $li);
         $label.addClass(inputType);

         var $checkbox = $('<input/>').attr('type', inputType);

         if (this.options.checkboxName) {
            $checkbox.attr('name', this.options.checkboxName);
         }
         $label.append($checkbox);

         var selected = $element.prop('selected') || false;
         $checkbox.val(value);

         if (value === this.options.selectAllValue) {
            $li.addClass("multiselect-item multiselect-all");
            $checkbox.parent().parent()
               .addClass('multiselect-all');
         }

         $label.append(" " + label);
         $label.attr('title', $element.attr('title'));

         this.$ul.append($li);

         if ($element.is(':disabled')) {
            $checkbox.attr('disabled', 'disabled')
               .prop('disabled', true)
               .closest('a')
               .attr("tabindex", "-1")
               .closest('li')
               .addClass('disabled');
         }

         $checkbox.prop('checked', selected);

         if (selected && this.options.selectedClass) {
            $checkbox.closest('li')
               .addClass(this.options.selectedClass);
         }
      },

      /**
       * Creates a divider using given select option
       * @param {jQuery} element
       */
      createDivider: function(element) {
         var $divider = $(this.options.templates.divider);
         this.$ul.append($divider);
      },

      /**
       * Creates optgroup
       * @param {jQuery} group
       */
      createOptgroup: function(group) {
         var groupName = $(group).prop('label');

         // Add a group header
         var $li = $(this.options.templates.liGroup);
         $('label', $li).text(groupName);

         if (this.options.enableClickableOptGroups) {
            $li.addClass('multiselect-group-clickable');
         }

         this.$ul.append($li);

         if ($(group).is(':disabled')) {
            $li.addClass('disabled');
         }

         // Add group options
         $('option', group).each($.proxy(function(index, element) {
            this.createOptionValue(element);
         }, this));
      },

      /**
       * Build "Selct All"
       * Checks if a "Select All" has already been created
       */
      buildSelectAll: function() {
         if (typeof this.options.selectAllValue === 'number') {
            this.options.selectAllValue = this.options.selectAllValue.toString();
         }

         var alreadyHasSelectAll = this.hasSelectAll();

         if (!alreadyHasSelectAll && this.options.includeSelectAllOption && this.options.multiple && $('option', this.$select).length > this.options.includeSelectAllIfMoreThan) {

            // Check whether to add divider after "Select All"
            if (this.options.includeSelectAllDivider) {
               this.$ul.prepend($(this.options.templates.divider));
            }

            var $li = $(this.options.templates.li);
            $('label', $li).addClass("checkbox");

            if (this.options.selectAllName) {
               $('label', $li).append('<input type="checkbox" name="' + this.options.selectAllName + '" />');
            } else {
               $('label', $li).append('<input type="checkbox" />');
            }

            var $checkbox = $('input', $li);
            $checkbox.val(this.options.selectAllValue);

            $li.addClass("multiselect-item multiselect-all");
            $checkbox.parent().parent()
               .addClass('multiselect-all');

            $('label', $li).append(" " + this.options.selectAllText);

            this.$ul.prepend($li);

            $checkbox.prop('checked', false);
         }
      },

      /**
       * Builds filter
       */
      buildFilter: function() {

         if (this.options.enableFiltering || this.options.enableCaseInsensitiveFiltering) {
            var enableFilterLength = Math.max(this.options.enableFiltering, this.options.enableCaseInsensitiveFiltering);

            if (this.$select.find('option').length >= enableFilterLength) {

               this.$filter = $(this.options.templates.filter);
               $('input', this.$filter).attr('placeholder', this.options.filterPlaceholder);

               // Adds optional filter "Clear" button
               if (this.options.includeFilterClearBtn) {
                  var clearBtn = $(this.options.templates.filterClearBtn);
                  clearBtn.on('click', $.proxy(function(event) {
                     clearTimeout(this.searchTimeout);
                     this.$filter.find('.multiselect-search').val('');
                     $('li', this.$ul).show().removeClass("filter-hidden");
                     this.updateSelectAll();
                  }, this));
                  this.$filter.find('.input-group').append(clearBtn);
               }

               this.$ul.prepend(this.$filter);

               this.$filter.val(this.query).on('click', function(event) {
                  event.stopPropagation();
               }).on('input keydown', $.proxy(function(event) {
                  // Disable enter key default behaviour
                  if (event.which === 13) {
                     event.preventDefault();
                  }

                  // Useful to catch "keydown" events after browser has updated the control
                  clearTimeout(this.searchTimeout);

                  this.searchTimeout = this.asyncFunction($.proxy(function() {

                     if (this.query !== event.target.value) {
                        this.query = event.target.value;

                        var currentGroup, currentGroupVisible;
                        $.each($('li', this.$ul), $.proxy(function(index, element) {
                           var value = $('input', element).val();
                           var text = $('label', element).text();

                           var filterCandidate = '';
                           if ((this.options.filterBehavior === 'text')) {
                              filterCandidate = text;
                           } else if ((this.options.filterBehavior === 'value')) {
                              filterCandidate = value;
                           } else if (this.options.filterBehavior === 'both') {
                              filterCandidate = text + '\n' + value;
                           }

                           if (value !== this.options.selectAllValue && text) {
                              // Default value we want
                              var showElement = false;

                              if (this.options.enableCaseInsensitiveFiltering && filterCandidate.toLowerCase().indexOf(this.query.toLowerCase()) > -1) {
                                 showElement = true;
                              } else if (filterCandidate.indexOf(this.query) > -1) {
                                 showElement = true;
                              }

                              // Toggle current element according to showElement boolean
                              $(element).toggle(showElement).toggleClass('filter-hidden', !showElement);

                              // Differentiate groups and group items
                              if ($(element).hasClass('multiselect-group')) {
                                 // Remember group status
                                 currentGroup = element;
                                 currentGroupVisible = showElement;
                              } else {
                                 // Show group name when at least one of its items is visible
                                 if (showElement) {
                                    $(currentGroup).show().removeClass('filter-hidden');
                                 }

                                 // Show all group items when group name satisfies filter
                                 if (!showElement && currentGroupVisible) {
                                    $(element).show().removeClass('filter-hidden');
                                 }
                              }
                           }
                        }, this));
                     }

                     this.updateSelectAll();
                  }, this), 300, this);
               }, this));
            }
         }
      },

      /**
       * Unbinds whole plugin
       */
      destroy: function() {
         this.$container.remove();
         this.$select.show();
         this.$select.data('multiselect', null);
      },

      /**
       * Refreshs multiselect based on the select selected options
       */
      refresh: function() {
         $('option', this.$select).each($.proxy(function(index, element) {
            var $input = $('li input', this.$ul).filter(function() {
               return $(this).val() === $(element).val();
            });

            if ($(element).is(':selected')) {
               $input.prop('checked', true);

               if (this.options.selectedClass) {
                  $input.closest('li')
                     .addClass(this.options.selectedClass);
               }
            } else {
               $input.prop('checked', false);

               if (this.options.selectedClass) {
                  $input.closest('li')
                     .removeClass(this.options.selectedClass);
               }
            }

            if ($(element).is(":disabled")) {
               $input.attr('disabled', 'disabled')
                  .prop('disabled', true)
                  .closest('li')
                  .addClass('disabled');
            } else {
               $input.prop('disabled', false)
                  .closest('li')
                  .removeClass('disabled');
            }
         }, this));

         this.updateButtonText();
         this.updateSelectAll();
      },

      /**
       * Select all matching options
       *
       * If triggerOnChange is "true" => "onChange" event is triggered
       * only if one value is passed
       *
       * @param {Array} selectValues
       * @param {Boolean} triggerOnChange
       */
      select: function(selectValues, triggerOnChange) {
         if (!$.isArray(selectValues)) {
            selectValues = [selectValues];
         }

         for (var i = 0; i < selectValues.length; i++) {
            var value = selectValues[i];

            if (value === null || value === undefined) {
               continue;
            }

            var $option = this.getOptionByValue(value);
            var $checkbox = this.getInputByValue(value);

            if ($option === undefined || $checkbox === undefined) {
               continue;
            }

            if (!this.options.multiple) {
               this.deselectAll(false);
            }

            if (this.options.selectedClass) {
               $checkbox.closest('li')
                  .addClass(this.options.selectedClass);
            }

            $checkbox.prop('checked', true);
            $option.prop('selected', true);
         }

         this.updateButtonText();
         this.updateSelectAll();

         if (triggerOnChange && selectValues.length === 1) {
            this.options.onChange($option, true);
         }
      },

      /**
       * Clears all selected items
       */
      clearSelection: function() {
         this.deselectAll(false);
         this.updateButtonText();
         this.updateSelectAll();
      },

      /**
       * Deselects all matching options
       *
       * If triggerOnChange is "true" => "onChange" event is triggered
       * only if one value is passed.
       *
       * @param {Array} deselectValues
       * @param {Boolean} triggerOnChange
       */
      deselect: function(deselectValues, triggerOnChange) {
         if (!$.isArray(deselectValues)) {
            deselectValues = [deselectValues];
         }

         for (var i = 0; i < deselectValues.length; i++) {
            var value = deselectValues[i];

            if (value === null || value === undefined) {
               continue;
            }

            var $option = this.getOptionByValue(value);
            var $checkbox = this.getInputByValue(value);

            if ($option === undefined || $checkbox === undefined) {
               continue;
            }

            if (this.options.selectedClass) {
               $checkbox.closest('li')
                  .removeClass(this.options.selectedClass);
            }

            $checkbox.prop('checked', false);
            $option.prop('selected', false);
         }

         this.updateButtonText();
         this.updateSelectAll();

         if (triggerOnChange && deselectValues.length === 1) {
            this.options.onChange($option, false);
         }
      },

      /**
       * Selects all enabled and visible options
       *
       * If justVisible is true or not specified - only visible options are selected
       *
       * @param {Boolean} justVisible
       */
      selectAll: function(justVisible) {
         var justVisible = typeof justVisible === 'undefined' ? true : justVisible;
         var allCheckboxes = $("li input[type='checkbox']:enabled", this.$ul);
         var visibleCheckboxes = allCheckboxes.filter(":visible");
         var allCheckboxesCount = allCheckboxes.length;
         var visibleCheckboxesCount = visibleCheckboxes.length;

         if (justVisible) {
            visibleCheckboxes.prop('checked', true);
            $("li:not(.divider):not(.disabled)", this.$ul).filter(":visible").addClass(this.options.selectedClass);
         } else {
            allCheckboxes.prop('checked', true);
            $("li:not(.divider):not(.disabled)", this.$ul).addClass(this.options.selectedClass);
         }

         if (allCheckboxesCount === visibleCheckboxesCount || justVisible === false) {
            $("option:enabled", this.$select).prop('selected', true);
         } else {
            var values = visibleCheckboxes.map(function() {
               return $(this).val();
            }).get();

            $("option:enabled", this.$select).filter(function(index) {
               return $.inArray($(this).val(), values) !== -1;
            }).prop('selected', true);
         }
      },

      /**
       * Deselects all options
       *
       * If justVisible is true or not specified - only visible options are deselected
       *
       * @param {Boolean} justVisible
       */
      deselectAll: function(justVisible) {
         var justVisible = typeof justVisible === 'undefined' ? true : justVisible;

         if (justVisible) {
            var visibleCheckboxes = $("li input[type='checkbox']:enabled", this.$ul).filter(":visible");
            visibleCheckboxes.prop('checked', false);

            var values = visibleCheckboxes.map(function() {
               return $(this).val();
            }).get();

            $("option:enabled", this.$select).filter(function(index) {
               return $.inArray($(this).val(), values) !== -1;
            }).prop('selected', false);

            if (this.options.selectedClass) {
               $("li:not(.divider):not(.disabled)", this.$ul).filter(":visible").removeClass(this.options.selectedClass);
            }
         } else {
            $("li input[type='checkbox']:enabled", this.$ul).prop('checked', false);
            $("option:enabled", this.$select).prop('selected', false);

            if (this.options.selectedClass) {
               $("li:not(.divider):not(.disabled)", this.$ul).removeClass(this.options.selectedClass);
            }
         }
      },

      /**
       * Rebuild plugin
       *
       * Rebuild the dropdown, filter and the "Select all" option
       */
      rebuild: function() {
         this.$ul.html('');

         // Distinguish between radios and checkboxes
         this.options.multiple = this.$select.attr('multiple') === "multiple";

         this.buildSelectAll();
         this.buildDropdownOptions();
         this.buildFilter();

         this.updateButtonText();
         this.updateSelectAll();

         if (this.options.disableIfEmpty && $('option', this.$select).length <= 0) {
            this.disable();
         }

         if (this.options.dropRight) {
            this.$ul.addClass('pull-right');
         }
      },

      /**
       * Provided data will be used to build dropdown
       */
      dataprovider: function(dataprovider) {
         var optionDOM = "";
         var groupCounter = 0;
         var tags = $('');

         $.each(dataprovider, function(index, option) {
            var tag;
            if ($.isArray(option.children)) { // create option group tag
               groupCounter++;
               tag = $('<optgroup/>').attr({
                  label: option.label || 'Group ' + groupCounter
               });
               forEach(option.children, function(subOption) { // add children option tag or tags
                  tag.append($('<option/>').attr({
                     value: subOption.value,
                     label: subOption.label || subOption.value,
                     title: subOption.title,
                     selected: !!subOption.selected
                  }));
               });

               optionDOM += '</optgroup>';
            } else { // create option tag
               tag = $('<option/>').attr({
                  value: option.value,
                  label: option.label || option.value,
                  title: option.title,
                  selected: !!option.selected
               });
            }

            tags = tags.add(tag);
         });

         this.$select.empty().append(tags);
         this.rebuild();
      },

      /**
       * Enable multiselect
       */
      enable: function() {
         this.$select.prop('disabled', false);
         this.$button.prop('disabled', false)
            .removeClass('disabled');
      },

      /**
       * Disable multiselect
       */
      disable: function() {
         this.$select.prop('disabled', true);
         this.$button.prop('disabled', true)
            .addClass('disabled');
      },

      /**
       * Set options
       *
       * @param {Array} options
       */
      setOptions: function(options) {
         this.options = this.mergeOptions(options);
      },

      /**
       * Merges given options with the default options
       *
       * @param {Array} options
       * @returns {Array}
       */
      mergeOptions: function(options) {
         return $.extend(true, {}, this.defaults, options);
      },

      /**
       * Checks whether "Select all" checkbox is present
       *
       * @returns {Boolean}
       */
      hasSelectAll: function() {
         return $('li.' + this.options.selectAllValue, this.$ul).length > 0;
      },

      /**
       * Updates the "Select all" checkbox depending on the currently displayed and selected checkboxes
       */
      updateSelectAll: function() {
         if (this.hasSelectAll()) {
            var allBoxes = $("li:not(.multiselect-item):not(.filter-hidden) input:enabled", this.$ul);
            var allBoxesLength = allBoxes.length;
            var checkedBoxesLength = allBoxes.filter(":checked").length;
            var selectAllLi = $("li." + this.options.selectAllValue, this.$ul);
            var selectAllInput = selectAllLi.find("input");

            if (checkedBoxesLength > 0 && checkedBoxesLength === allBoxesLength) {
               selectAllInput.prop("checked", true);
               selectAllLi.addClass(this.options.selectedClass);
            } else {
               selectAllInput.prop("checked", false);
               selectAllLi.removeClass(this.options.selectedClass);
            }
         }
      },

      /**
       * Update button text and its title depending on the currently selected options
       */
      updateButtonText: function() {
         var options = this.getSelected();

         // Update the displayed button text first
         $('.multiselect', this.$container).html(this.options.buttonText(options, this.$select));

         // Now update button title attribute
         $('.multiselect', this.$container).attr('title', this.options.buttonTitle(options, this.$select));
      },

      /**
       * Get all selected options
       *
       * @returns {jQUery}
       */
      getSelected: function() {
         return $('option', this.$select).filter(":selected");
      },

      /**
       * Gets a select option by its value
       *
       * @param {String} value
       * @returns {jQuery}
       */
      getOptionByValue: function(value) {

         var options = $('option', this.$select);
         var valueToCompare = value.toString();

         for (var i = 0; i < options.length; i = i + 1) {
            var option = options[i];
            if (option.value === valueToCompare) {
               return $(option);
            }
         }
      },

      /**
       * Get the input (radio / checkbox) by its value
       *
       * @param {String} value
       * @returns {jQuery}
       */
      getInputByValue: function(value) {

         var checkboxes = $('li input', this.$ul);
         var valueToCompare = value.toString();

         for (var i = 0; i < checkboxes.length; i = i + 1) {
            var checkbox = checkboxes[i];
            if (checkbox.value === valueToCompare) {
               return $(checkbox);
            }
         }
      },

      /**
       * Knockout integration
       */
      updateOriginalOptions: function() {
         this.originalOptions = this.$select.clone()[0].options;
      },

      asyncFunction: function(callback, timeout, self) {
         var args = Array.prototype.slice.call(arguments, 3);
         return setTimeout(function() {
            callback.apply(self || window, args);
         }, timeout);
      }
   };

   $.fn.multiselect = function(option, parameter, extraOptions) {
      return this.each(function() {
         var data = $(this).data('multiselect');
         var options = typeof option === 'object' && option;

         // Initialize multiselect
         if (!data) {
            data = new Multiselect(this, options);
            $(this).data('multiselect', data);
         }

         // Call multiselect method
         if (typeof option === 'string') {
            data[option](parameter, extraOptions);

            if (option === 'destroy') {
               $(this).data('multiselect', false);
            }
         }
      });
   };

   $.fn.multiselect.Constructor = Multiselect;

   $(function() {
      $("select[data-role=multiselect]").multiselect();
   });

}(window.jQuery);



!function(a){return"function"==typeof define&&define.amd?define(["jquery"],function(b){return a(b,window,document)}):a(jQuery,window,document)}(function(a,b,c){"use strict";var d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H;z={paneClass:"nano-pane",sliderClass:"nano-slider",contentClass:"nano-content",iOSNativeScrolling:!1,preventPageScrolling:!1,disableResize:!1,alwaysVisible:!1,flashDelay:1500,sliderMinHeight:20,sliderMaxHeight:41,documentContext:null,windowContext:null},u="scrollbar",t="scroll",l="mousedown",m="mouseenter",n="mousemove",p="mousewheel",o="mouseup",s="resize",h="drag",i="enter",w="up",r="panedown",f="DOMMouseScroll",g="down",x="wheel",j="keydown",k="keyup",v="touchmove",d="Microsoft Internet Explorer"===b.navigator.appName&&/msie 7./i.test(b.navigator.appVersion)&&b.ActiveXObject,e=null,D=b.requestAnimationFrame,y=b.cancelAnimationFrame,F=c.createElement("div").style,H=function(){var a,b,c,d,e,f;for(d=["t","webkitT","MozT","msT","OT"],a=e=0,f=d.length;f>e;a=++e)if(c=d[a],b=d[a]+"ransform",b in F)return d[a].substr(0,d[a].length-1);return!1}(),G=function(a){return H===!1?!1:""===H?a:H+a.charAt(0).toUpperCase()+a.substr(1)},E=G("transform"),B=E!==!1,A=function(){var a,b,d;return a=c.createElement("div"),b=a.style,b.position="absolute",b.width="100px",b.height="100px",b.overflow=t,b.top="-9999px",c.body.appendChild(a),d=a.offsetWidth-a.clientWidth,c.body.removeChild(a),d},C=function(){var a,c,d;return c=b.navigator.userAgent,(a=/(?=.+Mac OS X)(?=.+Firefox)/.test(c))?(d=/Firefox\/\d{2}\./.exec(c),d&&(d=d[0].replace(/\D+/g,"")),a&&+d>23):!1},q=function(){function j(d,f){this.el=d,this.options=f,e||(e=A()),this.$el=a(this.el),this.doc=a(this.options.documentContext||c),this.win=a(this.options.windowContext||b),this.body=this.doc.find("body"),this.$content=this.$el.children("."+f.contentClass),this.$content.attr("tabindex",this.options.tabIndex||0),this.content=this.$content[0],this.previousPosition=0,this.options.iOSNativeScrolling&&null!=this.el.style.WebkitOverflowScrolling?this.nativeScrolling():this.generate(),this.createEvents(),this.addEvents(),this.reset()}return j.prototype.preventScrolling=function(a,b){if(this.isActive)if(a.type===f)(b===g&&a.originalEvent.detail>0||b===w&&a.originalEvent.detail<0)&&a.preventDefault();else if(a.type===p){if(!a.originalEvent||!a.originalEvent.wheelDelta)return;(b===g&&a.originalEvent.wheelDelta<0||b===w&&a.originalEvent.wheelDelta>0)&&a.preventDefault()}},j.prototype.nativeScrolling=function(){this.$content.css({WebkitOverflowScrolling:"touch"}),this.iOSNativeScrolling=!0,this.isActive=!0},j.prototype.updateScrollValues=function(){var a,b;a=this.content,this.maxScrollTop=a.scrollHeight-a.clientHeight,this.prevScrollTop=this.contentScrollTop||0,this.contentScrollTop=a.scrollTop,b=this.contentScrollTop>this.previousPosition?"down":this.contentScrollTop<this.previousPosition?"up":"same",this.previousPosition=this.contentScrollTop,"same"!==b&&this.$el.trigger("update",{position:this.contentScrollTop,maximum:this.maxScrollTop,direction:b}),this.iOSNativeScrolling||(this.maxSliderTop=this.paneHeight-this.sliderHeight,this.sliderTop=0===this.maxScrollTop?0:this.contentScrollTop*this.maxSliderTop/this.maxScrollTop)},j.prototype.setOnScrollStyles=function(){var a;B?(a={},a[E]="translate(0, "+this.sliderTop+"px)"):a={top:this.sliderTop},D?(y&&this.scrollRAF&&y(this.scrollRAF),this.scrollRAF=D(function(b){return function(){return b.scrollRAF=null,b.slider.css(a)}}(this))):this.slider.css(a)},j.prototype.createEvents=function(){this.events={down:function(a){return function(b){return a.isBeingDragged=!0,a.offsetY=b.pageY-a.slider.offset().top,a.slider.is(b.target)||(a.offsetY=0),a.pane.addClass("active"),a.doc.bind(n,a.events[h]).bind(o,a.events[w]),a.body.bind(m,a.events[i]),!1}}(this),drag:function(a){return function(b){return a.sliderY=b.pageY-a.$el.offset().top-a.paneTop-(a.offsetY||.5*a.sliderHeight),a.scroll(),a.contentScrollTop>=a.maxScrollTop&&a.prevScrollTop!==a.maxScrollTop?a.$el.trigger("scrollend"):0===a.contentScrollTop&&0!==a.prevScrollTop&&a.$el.trigger("scrolltop"),!1}}(this),up:function(a){return function(){return a.isBeingDragged=!1,a.pane.removeClass("active"),a.doc.unbind(n,a.events[h]).unbind(o,a.events[w]),a.body.unbind(m,a.events[i]),!1}}(this),resize:function(a){return function(){a.reset()}}(this),panedown:function(a){return function(b){return a.sliderY=(b.offsetY||b.originalEvent.layerY)-.5*a.sliderHeight,a.scroll(),a.events.down(b),!1}}(this),scroll:function(a){return function(b){a.updateScrollValues(),a.isBeingDragged||(a.iOSNativeScrolling||(a.sliderY=a.sliderTop,a.setOnScrollStyles()),null!=b&&(a.contentScrollTop>=a.maxScrollTop?(a.options.preventPageScrolling&&a.preventScrolling(b,g),a.prevScrollTop!==a.maxScrollTop&&a.$el.trigger("scrollend")):0===a.contentScrollTop&&(a.options.preventPageScrolling&&a.preventScrolling(b,w),0!==a.prevScrollTop&&a.$el.trigger("scrolltop"))))}}(this),wheel:function(a){return function(b){var c;if(null!=b)return c=b.delta||b.wheelDelta||b.originalEvent&&b.originalEvent.wheelDelta||-b.detail||b.originalEvent&&-b.originalEvent.detail,c&&(a.sliderY+=-c/3),a.scroll(),!1}}(this),enter:function(a){return function(b){var c;if(a.isBeingDragged)return 1!==(b.buttons||b.which)?(c=a.events)[w].apply(c,arguments):void 0}}(this)}},j.prototype.addEvents=function(){var a;this.removeEvents(),a=this.events,this.options.disableResize||this.win.bind(s,a[s]),this.iOSNativeScrolling||(this.slider.bind(l,a[g]),this.pane.bind(l,a[r]).bind(""+p+" "+f,a[x])),this.$content.bind(""+t+" "+p+" "+f+" "+v,a[t])},j.prototype.removeEvents=function(){var a;a=this.events,this.win.unbind(s,a[s]),this.iOSNativeScrolling||(this.slider.unbind(),this.pane.unbind()),this.$content.unbind(""+t+" "+p+" "+f+" "+v,a[t])},j.prototype.generate=function(){var a,c,d,f,g,h,i;return f=this.options,h=f.paneClass,i=f.sliderClass,a=f.contentClass,(g=this.$el.children("."+h)).length||g.children("."+i).length||this.$el.append('<div class="'+h+'"><div class="'+i+'" /></div>'),this.pane=this.$el.children("."+h),this.slider=this.pane.find("."+i),0===e&&C()?(d=b.getComputedStyle(this.content,null).getPropertyValue("padding-right").replace(/[^0-9.]+/g,""),c={right:-14,paddingRight:+d+14}):e&&(c={right:-e},this.$el.addClass("has-scrollbar")),null!=c&&this.$content.css(c),this},j.prototype.restore=function(){this.stopped=!1,this.iOSNativeScrolling||this.pane.show(),this.addEvents()},j.prototype.reset=function(){var a,b,c,f,g,h,i,j,k,l,m,n;return this.iOSNativeScrolling?void(this.contentHeight=this.content.scrollHeight):(this.$el.find("."+this.options.paneClass).length||this.generate().stop(),this.stopped&&this.restore(),a=this.content,f=a.style,g=f.overflowY,d&&this.$content.css({height:this.$content.height()}),b=a.scrollHeight+e,l=parseInt(this.$el.css("max-height"),10),l>0&&(this.$el.height(""),this.$el.height(a.scrollHeight>l?l:a.scrollHeight)),i=this.pane.outerHeight(!1),k=parseInt(this.pane.css("top"),10),h=parseInt(this.pane.css("bottom"),10),j=i+k+h,n=Math.round(j/b*j),n<this.options.sliderMinHeight?n=this.options.sliderMinHeight:null!=this.options.sliderMaxHeight&&n>this.options.sliderMaxHeight&&(n=this.options.sliderMaxHeight),g===t&&f.overflowX!==t&&(n+=e),this.maxSliderTop=j-n,this.contentHeight=b,this.paneHeight=i,this.paneOuterHeight=j,this.sliderHeight=n,this.paneTop=k,this.slider.height(n),this.events.scroll(),this.pane.show(),this.isActive=!0,a.scrollHeight===a.clientHeight||this.pane.outerHeight(!0)>=a.scrollHeight&&g!==t?(this.pane.hide(),this.isActive=!1):this.el.clientHeight===a.scrollHeight&&g===t?this.slider.hide():this.slider.show(),this.pane.css({opacity:this.options.alwaysVisible?1:"",visibility:this.options.alwaysVisible?"visible":""}),c=this.$content.css("position"),("static"===c||"relative"===c)&&(m=parseInt(this.$content.css("right"),10),m&&this.$content.css({right:"",marginRight:m})),this)},j.prototype.scroll=function(){return this.isActive?(this.sliderY=Math.max(0,this.sliderY),this.sliderY=Math.min(this.maxSliderTop,this.sliderY),this.$content.scrollTop(this.maxScrollTop*this.sliderY/this.maxSliderTop),this.iOSNativeScrolling||(this.updateScrollValues(),this.setOnScrollStyles()),this):void 0},j.prototype.scrollBottom=function(a){return this.isActive?(this.$content.scrollTop(this.contentHeight-this.$content.height()-a).trigger(p),this.stop().restore(),this):void 0},j.prototype.scrollTop=function(a){return this.isActive?(this.$content.scrollTop(+a).trigger(p),this.stop().restore(),this):void 0},j.prototype.scrollTo=function(a){return this.isActive?(this.scrollTop(this.$el.find(a).get(0).offsetTop),this):void 0},j.prototype.stop=function(){return y&&this.scrollRAF&&(y(this.scrollRAF),this.scrollRAF=null),this.stopped=!0,this.removeEvents(),this.iOSNativeScrolling||this.pane.hide(),this},j.prototype.destroy=function(){return this.stopped||this.stop(),!this.iOSNativeScrolling&&this.pane.length&&this.pane.remove(),d&&this.$content.height(""),this.$content.removeAttr("tabindex"),this.$el.hasClass("has-scrollbar")&&(this.$el.removeClass("has-scrollbar"),this.$content.css({right:""})),this},j.prototype.flash=function(){return!this.iOSNativeScrolling&&this.isActive?(this.reset(),this.pane.addClass("flashed"),setTimeout(function(a){return function(){a.pane.removeClass("flashed")}}(this),this.options.flashDelay),this):void 0},j}(),a.fn.nanoScroller=function(b){return this.each(function(){var c,d;if((d=this.nanoscroller)||(c=a.extend({},z,b),this.nanoscroller=d=new q(this,c)),b&&"object"==typeof b){if(a.extend(d.options,b),null!=b.scrollBottom)return d.scrollBottom(b.scrollBottom);if(null!=b.scrollTop)return d.scrollTop(b.scrollTop);if(b.scrollTo)return d.scrollTo(b.scrollTo);if("bottom"===b.scroll)return d.scrollBottom(0);if("top"===b.scroll)return d.scrollTop(0);if(b.scroll&&b.scroll instanceof a)return d.scrollTo(b.scroll);if(b.stop)return d.stop();if(b.destroy)return d.destroy();if(b.flash)return d.flash()}return d.reset()})},a.fn.nanoScroller.Constructor=q});



(function ($, window) {
	"use strict";

	var namespace = "scroller",
		$body = null,
		classes = {
			base: "scroller",
			content: "scroller-content",
			bar: "scroller-bar",
			track: "scroller-track",
			handle: "scroller-handle",
			isHorizontal: "scroller-horizontal",
			isSetup: "scroller-setup",
			isActive: "scroller-active"
		},
		events = {
			start: "touchstart." + namespace + " mousedown." + namespace,
			move: "touchmove." + namespace + " mousemove." + namespace,
			end: "touchend." + namespace + " mouseup." + namespace
		};

	/**
	 * @options
	 * @param customClass [string] <''> "Class applied to instance"
	 * @param duration [int] <0> "Scroll animation length"
	 * @param handleSize [int] <0> "Handle size; 0 to auto size"
	 * @param horizontal [boolean] <false> "Scroll horizontally"
	 * @param trackMargin [int] <0> "Margin between track and handle edge”
	 */
	var options = {
		customClass: "",
		duration: 0,
		handleSize: 20,
		horizontal: false,
		trackMargin: 0
	};

	var pub = {

		/**
		 * @method
		 * @name defaults
		 * @description Sets default plugin options
		 * @param opts [object] <{}> "Options object"
		 * @example $.scroller("defaults", opts);
		 */
		defaults: function(opts) {
			options = $.extend(options, opts || {});
			return (typeof this === 'object') ? $(this) : true;
		},

		/**
		 * @method
		 * @name destroy
		 * @description Removes instance of plugin
		 * @example $(".target").scroller("destroy");
		 */
		destroy: function() {
			return $(this).each(function(i, el) {
				var data = $(el).data(namespace);

				if (data) {
					data.$scroller.removeClass( [data.customClass, classes.base, classes.isActive].join(" ") );

					data.$bar.remove();
					data.$content.contents().unwrap();

					data.$content.off( classify(namespace) );
					data.$scroller.off( classify(namespace) )
								  .removeData(namespace);
				}
			});
		},

		/**
		 * @method
		 * @name scroll
		 * @description Scrolls instance of plugin to element or position
		 * @param pos [string || int] <null> "Target element selector or static position"
		 * @param duration [int] <null> "Optional scroll duration"
		 * @example $.scroller("scroll", pos, duration);
		 */
		scroll: function(pos, dur) {
			return $(this).each(function(i) {
				var data = $(this).data(namespace),
	                duration = dur || options.duration;

				if (typeof pos !== "number") {
					var $el = $(pos);
					if ($el.length > 0) {
						var offset = $el.position();
						if (data.horizontal) {
							pos = offset.left + data.$content.scrollLeft();
						} else {
							pos = offset.top + data.$content.scrollTop();
						}
					} else {
						pos = data.$content.scrollTop();
					}
				}

				var styles = data.horizontal ? { scrollLeft: pos } : { scrollTop: pos };

				data.$content.stop().animate(styles, duration);
			});
		},

		/**
		 * @method
		 * @name reset
		 * @description Resets layout on instance of plugin
		 * @example $.scroller("reset");
		 */
		reset: function()  {
			return $(this).each(function(i) {
				var data = $(this).data(namespace);

				if (data) {
					data.$scroller.addClass(classes.isSetup);

					var barStyles = {},
						trackStyles = {},
						handleStyles = {},
						handlePosition = 0,
						isActive = true;

					if (data.horizontal) {
						// Horizontal
						data.barHeight = data.$content[0].offsetHeight - data.$content[0].clientHeight;
						data.frameWidth = data.$content.outerWidth();
						data.trackWidth = data.frameWidth - (data.trackMargin * 2);
						data.scrollWidth = data.$content[0].scrollWidth;
						data.ratio = data.trackWidth / data.scrollWidth;
						data.trackRatio = data.trackWidth / data.scrollWidth;
						data.handleWidth = (data.handleSize > 0) ? data.handleSize : data.trackWidth * data.trackRatio;
						data.scrollRatio = (data.scrollWidth - data.frameWidth) / (data.trackWidth - data.handleWidth);
						data.handleBounds = {
							left: 0,
							right: data.trackWidth - data.handleWidth
						};

						data.$content.css({
							paddingBottom: data.barHeight + data.paddingBottom
						});

						var scrollLeft = data.$content.scrollLeft();

						handlePosition = scrollLeft * data.ratio;
						isActive = (data.scrollWidth <= data.frameWidth);

						barStyles = {
							width: data.frameWidth
						};

						trackStyles = {
							width: data.trackWidth,
							marginLeft: data.trackMargin,
							marginRight: data.trackMargin
						};

						handleStyles = {
							width: data.handleWidth
						};
					} else {
						// Vertical
						data.barWidth = data.$content[0].offsetWidth - data.$content[0].clientWidth;
						data.frameHeight = data.$content.outerHeight();
						data.trackHeight = data.frameHeight - (data.trackMargin * 2);
						data.scrollHeight = data.$content[0].scrollHeight;
						data.ratio = data.trackHeight / data.scrollHeight;
						data.trackRatio = data.trackHeight / data.scrollHeight;
						data.handleHeight = (data.handleSize > 0) ? data.handleSize : data.trackHeight * data.trackRatio;
						data.scrollRatio = (data.scrollHeight - data.frameHeight) / (data.trackHeight - data.handleHeight);
						data.handleBounds = {
							top: 0,
							bottom: data.trackHeight - data.handleHeight
						};

						var scrollTop = data.$content.scrollTop();

						handlePosition = scrollTop * data.ratio;
						isActive = (data.scrollHeight <= data.frameHeight);

						barStyles = {
							height: data.frameHeight
						};

						trackStyles = {
							height: data.trackHeight,
							marginBottom: data.trackMargin,
							marginTop: data.trackMargin
						};

						handleStyles = {
							height: data.handleHeight
						};
					}

					if (isActive) {
						data.$scroller.removeClass(classes.isActive);
					} else {
						data.$scroller.addClass(classes.isActive);
					}

					data.$bar.css(barStyles);
					data.$track.css(trackStyles);
					data.$handle.css(handleStyles);

					position(data, handlePosition);

					data.$scroller.removeClass(classes.isSetup);
				}
			});
		}
	};

	/**
	 * @method private
	 * @name init
	 * @description Initializes plugin
	 * @param opts [object] "Initialization options"
	 */
	function init(opts) {
		// Local options
		opts = $.extend({}, options, opts || {});

		// Check for Body tag
		if ($body === null) {
			$body = $("body");
		}

		// Apply to each elem
		var $items = $(this);
		for (var i = 0, count = $items.length; i < count; i++) {
			build($items.eq(i), opts);
		}
		return $items;
	}

	/**
	 * @method private
	 * @name build
	 * @description Builds each instance
	 * @param $scroller [jQuery object] "Target jQuery object"
	 * @param opts [object] <{}> "Options object"
	 */
	function build($scroller, opts) {
		if (!$scroller.hasClass(classes.base)) {
			// EXTEND OPTIONS
			opts = $.extend({}, opts, $scroller.data(namespace + "-options"));

			var html = '';

			html += '<div class="' + classes.bar + '">';
			html += '<div class="' + classes.track + '">';
			html += '<div class="' + classes.handle + '">';
			html += '</div></div></div>';

			opts.paddingRight = parseInt($scroller.css("padding-right"), 10);
			opts.paddingBottom = parseInt($scroller.css("padding-bottom"), 10);

			$scroller.addClass( [classes.base, opts.customClass].join(" ") )
					 .wrapInner('<div class="' + classes.content + '" />')
					 .prepend(html);

			if (opts.horizontal) {
				$scroller.addClass(classes.isHorizontal);
			}

			var data = $.extend({
				$scroller: $scroller,
				$content: $scroller.find( classify(classes.content) ),
				$bar: $scroller.find( classify(classes.bar) ),
				$track: $scroller.find( classify(classes.track) ),
				$handle: $scroller.find( classify(classes.handle) )
			}, opts);

			data.trackMargin = parseInt(data.trackMargin, 10);

			data.$content.on("scroll." + namespace, data, onScroll);
			data.$scroller.on(events.start, classify(classes.track), data, onTrackDown)
						  .on(events.start, classify(classes.handle), data, onHandleDown)
						  .data(namespace, data);

			pub.reset.apply($scroller);

			$(window).one("load", function() {
				pub.reset.apply($scroller);
			});
		}
	}

	/**
	 * @method private
	 * @name onScroll
	 * @description Handles scroll event
	 * @param e [object] "Event data"
	 */
	function onScroll(e) {
		e.preventDefault();
		e.stopPropagation();

		var data = e.data,
			handleStyles = {};

		if (data.horizontal) {
			// Horizontal
			var scrollLeft = data.$content.scrollLeft();

			if (scrollLeft < 0) {
				scrollLeft = 0;
			}

			var handleLeft = scrollLeft / data.scrollRatio;

			if (handleLeft > data.handleBounds.right) {
				handleLeft = data.handleBounds.right;
			}

			handleStyles = {
				left: handleLeft
			};
		} else {
			// Vertical
			var scrollTop = data.$content.scrollTop();

			if (scrollTop < 0) {
				scrollTop = 0;
			}

			var handleTop = scrollTop / data.scrollRatio;

			if (handleTop > data.handleBounds.bottom) {
				handleTop = data.handleBounds.bottom;
			}

			handleStyles = {
				top: handleTop
			};
		}

		data.$handle.css(handleStyles);
	}

	/**
	 * @method private
	 * @name onTrackDown
	 * @description Handles mousedown event on track
	 * @param e [object] "Event data"
	 */
	function onTrackDown(e) {
		e.preventDefault();
		e.stopPropagation();

		var data = e.data,
			oe = e.originalEvent,
			offset = data.$track.offset(),
			touch = (typeof oe.targetTouches !== "undefined") ? oe.targetTouches[0] : null,
			pageX = (touch) ? touch.pageX : e.clientX,
			pageY = (touch) ? touch.pageY : e.clientY;

		if (data.horizontal) {
			// Horizontal
			data.mouseStart = pageX;
			data.handleLeft = pageX - offset.left - (data.handleWidth / 2);

			position(data, data.handleLeft);
		} else {
			// Vertical
			data.mouseStart = pageY;
			data.handleTop  = pageY - offset.top - (data.handleHeight / 2);

			position(data, data.handleTop);
		}

		onStart(data);
	}

	/**
	 * @method private
	 * @name onHandleDown
	 * @description Handles mousedown event on handle
	 * @param e [object] "Event data"
	 */
	function onHandleDown(e) {
		e.preventDefault();
		e.stopPropagation();

		var data = e.data,
			oe = e.originalEvent,
			touch = (typeof oe.targetTouches !== "undefined") ? oe.targetTouches[0] : null,
			pageX = (touch) ? touch.pageX : e.clientX,
			pageY = (touch) ? touch.pageY : e.clientY;

		if (data.horizontal) {
			// Horizontal
			data.mouseStart = pageX;
			data.handleLeft = parseInt(data.$handle.css("left"), 10);
		} else {
			// Vertical
			data.mouseStart = pageY;
			data.handleTop = parseInt(data.$handle.css("top"), 10);
		}

		onStart(data);
	}

	/**
	 * @method private
	 * @name onStart
	 * @description Handles touch.mouse start
	 * @param data [object] "Instance data"
	 */
	function onStart(data) {
		data.$content.off( classify(namespace) );

		$body.on(events.move, data, onMouseMove)
			 .on(events.end, data, onMouseUp);
	}

	/**
	 * @method private
	 * @name onMouseMove
	 * @description Handles mousemove event
	 * @param e [object] "Event data"
	 */
	function onMouseMove(e) {
		e.preventDefault();
		e.stopPropagation();

		var data = e.data,
			oe = e.originalEvent,
			pos = 0,
			delta = 0,
			touch = (typeof oe.targetTouches !== "undefined") ? oe.targetTouches[0] : null,
			pageX = (touch) ? touch.pageX : e.clientX,
			pageY = (touch) ? touch.pageY : e.clientY;

		if (data.horizontal) {
			// Horizontal
			delta = data.mouseStart - pageX;
			pos = data.handleLeft - delta;
		} else {
			// Vertical
			delta = data.mouseStart - pageY;
			pos = data.handleTop - delta;
		}

		position(data, pos);
	}

	/**
	 * @method private
	 * @name onMouseUp
	 * @description Handles mouseup event
	 * @param e [object] "Event data"
	 */
	function onMouseUp(e) {
		e.preventDefault();
		e.stopPropagation();

		var data = e.data;

		data.$content.on("scroll.scroller", data, onScroll);
		$body.off(".scroller");
	}

	/**
	 * @method private
	 * @name onTouchEnd
	 * @description Handles mouseup event
	 * @param e [object] "Event data"
	 */
	function onTouchEnd(e) {
		e.preventDefault();
		e.stopPropagation();

		var data = e.data;

		data.$content.on("scroll.scroller", data, onScroll);
		$body.off(".scroller");
	}

	/**
	 * @method private
	 * @name position
	 * @description Position handle based on scroll
	 * @param data [object] "Instance data"
	 * @param pos [int] "Scroll position"
	 */
	function position(data, pos) {
		var handleStyles = {};

		if (data.horizontal) {
			// Horizontal
			if (pos < data.handleBounds.left) {
				pos = data.handleBounds.left;
			}

			if (pos > data.handleBounds.right) {
				pos = data.handleBounds.right;
			}

			var scrollLeft = Math.round(pos * data.scrollRatio);

			handleStyles = {
				left: pos
			};

			data.$content.scrollLeft( scrollLeft );
		} else {
			// Vertical
			if (pos < data.handleBounds.top) {
				pos = data.handleBounds.top;
			}

			if (pos > data.handleBounds.bottom) {
				pos = data.handleBounds.bottom;
			}

			var scrollTop = Math.round(pos * data.scrollRatio);

			handleStyles = {
				top: pos
			};

			data.$content.scrollTop( scrollTop );
		}

		data.$handle.css(handleStyles);
	}

	/**
	 * @method private
	 * @name classify
	 * @description Create class selector from text
	 * @param text [string] "Text to convert"
	 * @return [string] "New class name"
	 */
	function classify(text) {
		return "." + text;
	}

	$.fn[namespace] = function(method) {
		if (pub[method]) {
			return pub[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return init.apply(this, arguments);
		}
		return this;
	};

	$[namespace] = function(method) {
		if (method === "defaults") {
			pub.defaults.apply(this, Array.prototype.slice.call(arguments, 1));
		}
	};
})(jQuery);


;
(function(){var n=this,t=n._,r=Array.prototype,e=Object.prototype,u=Function.prototype,i=r.push,a=r.slice,o=r.concat,l=e.toString,c=e.hasOwnProperty,f=Array.isArray,s=Object.keys,p=u.bind,h=function(n){return n instanceof h?n:this instanceof h?void(this._wrapped=n):new h(n)};"undefined"!=typeof exports?("undefined"!=typeof module&&module.exports&&(exports=module.exports=h),exports._=h):n._=h,h.VERSION="1.7.0";var g=function(n,t,r){if(t===void 0)return n;switch(null==r?3:r){case 1:return function(r){return n.call(t,r)};case 2:return function(r,e){return n.call(t,r,e)};case 3:return function(r,e,u){return n.call(t,r,e,u)};case 4:return function(r,e,u,i){return n.call(t,r,e,u,i)}}return function(){return n.apply(t,arguments)}};h.iteratee=function(n,t,r){return null==n?h.identity:h.isFunction(n)?g(n,t,r):h.isObject(n)?h.matches(n):h.property(n)},h.each=h.forEach=function(n,t,r){if(null==n)return n;t=g(t,r);var e,u=n.length;if(u===+u)for(e=0;u>e;e++)t(n[e],e,n);else{var i=h.keys(n);for(e=0,u=i.length;u>e;e++)t(n[i[e]],i[e],n)}return n},h.map=h.collect=function(n,t,r){if(null==n)return[];t=h.iteratee(t,r);for(var e,u=n.length!==+n.length&&h.keys(n),i=(u||n).length,a=Array(i),o=0;i>o;o++)e=u?u[o]:o,a[o]=t(n[e],e,n);return a};var v="Reduce of empty array with no initial value";h.reduce=h.foldl=h.inject=function(n,t,r,e){null==n&&(n=[]),t=g(t,e,4);var u,i=n.length!==+n.length&&h.keys(n),a=(i||n).length,o=0;if(arguments.length<3){if(!a)throw new TypeError(v);r=n[i?i[o++]:o++]}for(;a>o;o++)u=i?i[o]:o,r=t(r,n[u],u,n);return r},h.reduceRight=h.foldr=function(n,t,r,e){null==n&&(n=[]),t=g(t,e,4);var u,i=n.length!==+n.length&&h.keys(n),a=(i||n).length;if(arguments.length<3){if(!a)throw new TypeError(v);r=n[i?i[--a]:--a]}for(;a--;)u=i?i[a]:a,r=t(r,n[u],u,n);return r},h.find=h.detect=function(n,t,r){var e;return t=h.iteratee(t,r),h.some(n,function(n,r,u){return t(n,r,u)?(e=n,!0):void 0}),e},h.filter=h.select=function(n,t,r){var e=[];return null==n?e:(t=h.iteratee(t,r),h.each(n,function(n,r,u){t(n,r,u)&&e.push(n)}),e)},h.reject=function(n,t,r){return h.filter(n,h.negate(h.iteratee(t)),r)},h.every=h.all=function(n,t,r){if(null==n)return!0;t=h.iteratee(t,r);var e,u,i=n.length!==+n.length&&h.keys(n),a=(i||n).length;for(e=0;a>e;e++)if(u=i?i[e]:e,!t(n[u],u,n))return!1;return!0},h.some=h.any=function(n,t,r){if(null==n)return!1;t=h.iteratee(t,r);var e,u,i=n.length!==+n.length&&h.keys(n),a=(i||n).length;for(e=0;a>e;e++)if(u=i?i[e]:e,t(n[u],u,n))return!0;return!1},h.contains=h.include=function(n,t){return null==n?!1:(n.length!==+n.length&&(n=h.values(n)),h.indexOf(n,t)>=0)},h.invoke=function(n,t){var r=a.call(arguments,2),e=h.isFunction(t);return h.map(n,function(n){return(e?t:n[t]).apply(n,r)})},h.pluck=function(n,t){return h.map(n,h.property(t))},h.where=function(n,t){return h.filter(n,h.matches(t))},h.findWhere=function(n,t){return h.find(n,h.matches(t))},h.max=function(n,t,r){var e,u,i=-1/0,a=-1/0;if(null==t&&null!=n){n=n.length===+n.length?n:h.values(n);for(var o=0,l=n.length;l>o;o++)e=n[o],e>i&&(i=e)}else t=h.iteratee(t,r),h.each(n,function(n,r,e){u=t(n,r,e),(u>a||u===-1/0&&i===-1/0)&&(i=n,a=u)});return i},h.min=function(n,t,r){var e,u,i=1/0,a=1/0;if(null==t&&null!=n){n=n.length===+n.length?n:h.values(n);for(var o=0,l=n.length;l>o;o++)e=n[o],i>e&&(i=e)}else t=h.iteratee(t,r),h.each(n,function(n,r,e){u=t(n,r,e),(a>u||1/0===u&&1/0===i)&&(i=n,a=u)});return i},h.shuffle=function(n){for(var t,r=n&&n.length===+n.length?n:h.values(n),e=r.length,u=Array(e),i=0;e>i;i++)t=h.random(0,i),t!==i&&(u[i]=u[t]),u[t]=r[i];return u},h.sample=function(n,t,r){return null==t||r?(n.length!==+n.length&&(n=h.values(n)),n[h.random(n.length-1)]):h.shuffle(n).slice(0,Math.max(0,t))},h.sortBy=function(n,t,r){return t=h.iteratee(t,r),h.pluck(h.map(n,function(n,r,e){return{value:n,index:r,criteria:t(n,r,e)}}).sort(function(n,t){var r=n.criteria,e=t.criteria;if(r!==e){if(r>e||r===void 0)return 1;if(e>r||e===void 0)return-1}return n.index-t.index}),"value")};var m=function(n){return function(t,r,e){var u={};return r=h.iteratee(r,e),h.each(t,function(e,i){var a=r(e,i,t);n(u,e,a)}),u}};h.groupBy=m(function(n,t,r){h.has(n,r)?n[r].push(t):n[r]=[t]}),h.indexBy=m(function(n,t,r){n[r]=t}),h.countBy=m(function(n,t,r){h.has(n,r)?n[r]++:n[r]=1}),h.sortedIndex=function(n,t,r,e){r=h.iteratee(r,e,1);for(var u=r(t),i=0,a=n.length;a>i;){var o=i+a>>>1;r(n[o])<u?i=o+1:a=o}return i},h.toArray=function(n){return n?h.isArray(n)?a.call(n):n.length===+n.length?h.map(n,h.identity):h.values(n):[]},h.size=function(n){return null==n?0:n.length===+n.length?n.length:h.keys(n).length},h.partition=function(n,t,r){t=h.iteratee(t,r);var e=[],u=[];return h.each(n,function(n,r,i){(t(n,r,i)?e:u).push(n)}),[e,u]},h.first=h.head=h.take=function(n,t,r){return null==n?void 0:null==t||r?n[0]:0>t?[]:a.call(n,0,t)},h.initial=function(n,t,r){return a.call(n,0,Math.max(0,n.length-(null==t||r?1:t)))},h.last=function(n,t,r){return null==n?void 0:null==t||r?n[n.length-1]:a.call(n,Math.max(n.length-t,0))},h.rest=h.tail=h.drop=function(n,t,r){return a.call(n,null==t||r?1:t)},h.compact=function(n){return h.filter(n,h.identity)};var y=function(n,t,r,e){if(t&&h.every(n,h.isArray))return o.apply(e,n);for(var u=0,a=n.length;a>u;u++){var l=n[u];h.isArray(l)||h.isArguments(l)?t?i.apply(e,l):y(l,t,r,e):r||e.push(l)}return e};h.flatten=function(n,t){return y(n,t,!1,[])},h.without=function(n){return h.difference(n,a.call(arguments,1))},h.uniq=h.unique=function(n,t,r,e){if(null==n)return[];h.isBoolean(t)||(e=r,r=t,t=!1),null!=r&&(r=h.iteratee(r,e));for(var u=[],i=[],a=0,o=n.length;o>a;a++){var l=n[a];if(t)a&&i===l||u.push(l),i=l;else if(r){var c=r(l,a,n);h.indexOf(i,c)<0&&(i.push(c),u.push(l))}else h.indexOf(u,l)<0&&u.push(l)}return u},h.union=function(){return h.uniq(y(arguments,!0,!0,[]))},h.intersection=function(n){if(null==n)return[];for(var t=[],r=arguments.length,e=0,u=n.length;u>e;e++){var i=n[e];if(!h.contains(t,i)){for(var a=1;r>a&&h.contains(arguments[a],i);a++);a===r&&t.push(i)}}return t},h.difference=function(n){var t=y(a.call(arguments,1),!0,!0,[]);return h.filter(n,function(n){return!h.contains(t,n)})},h.zip=function(n){if(null==n)return[];for(var t=h.max(arguments,"length").length,r=Array(t),e=0;t>e;e++)r[e]=h.pluck(arguments,e);return r},h.object=function(n,t){if(null==n)return{};for(var r={},e=0,u=n.length;u>e;e++)t?r[n[e]]=t[e]:r[n[e][0]]=n[e][1];return r},h.indexOf=function(n,t,r){if(null==n)return-1;var e=0,u=n.length;if(r){if("number"!=typeof r)return e=h.sortedIndex(n,t),n[e]===t?e:-1;e=0>r?Math.max(0,u+r):r}for(;u>e;e++)if(n[e]===t)return e;return-1},h.lastIndexOf=function(n,t,r){if(null==n)return-1;var e=n.length;for("number"==typeof r&&(e=0>r?e+r+1:Math.min(e,r+1));--e>=0;)if(n[e]===t)return e;return-1},h.range=function(n,t,r){arguments.length<=1&&(t=n||0,n=0),r=r||1;for(var e=Math.max(Math.ceil((t-n)/r),0),u=Array(e),i=0;e>i;i++,n+=r)u[i]=n;return u};var d=function(){};h.bind=function(n,t){var r,e;if(p&&n.bind===p)return p.apply(n,a.call(arguments,1));if(!h.isFunction(n))throw new TypeError("Bind must be called on a function");return r=a.call(arguments,2),e=function(){if(!(this instanceof e))return n.apply(t,r.concat(a.call(arguments)));d.prototype=n.prototype;var u=new d;d.prototype=null;var i=n.apply(u,r.concat(a.call(arguments)));return h.isObject(i)?i:u}},h.partial=function(n){var t=a.call(arguments,1);return function(){for(var r=0,e=t.slice(),u=0,i=e.length;i>u;u++)e[u]===h&&(e[u]=arguments[r++]);for(;r<arguments.length;)e.push(arguments[r++]);return n.apply(this,e)}},h.bindAll=function(n){var t,r,e=arguments.length;if(1>=e)throw new Error("bindAll must be passed function names");for(t=1;e>t;t++)r=arguments[t],n[r]=h.bind(n[r],n);return n},h.memoize=function(n,t){var r=function(e){var u=r.cache,i=t?t.apply(this,arguments):e;return h.has(u,i)||(u[i]=n.apply(this,arguments)),u[i]};return r.cache={},r},h.delay=function(n,t){var r=a.call(arguments,2);return setTimeout(function(){return n.apply(null,r)},t)},h.defer=function(n){return h.delay.apply(h,[n,1].concat(a.call(arguments,1)))},h.throttle=function(n,t,r){var e,u,i,a=null,o=0;r||(r={});var l=function(){o=r.leading===!1?0:h.now(),a=null,i=n.apply(e,u),a||(e=u=null)};return function(){var c=h.now();o||r.leading!==!1||(o=c);var f=t-(c-o);return e=this,u=arguments,0>=f||f>t?(clearTimeout(a),a=null,o=c,i=n.apply(e,u),a||(e=u=null)):a||r.trailing===!1||(a=setTimeout(l,f)),i}},h.debounce=function(n,t,r){var e,u,i,a,o,l=function(){var c=h.now()-a;t>c&&c>0?e=setTimeout(l,t-c):(e=null,r||(o=n.apply(i,u),e||(i=u=null)))};return function(){i=this,u=arguments,a=h.now();var c=r&&!e;return e||(e=setTimeout(l,t)),c&&(o=n.apply(i,u),i=u=null),o}},h.wrap=function(n,t){return h.partial(t,n)},h.negate=function(n){return function(){return!n.apply(this,arguments)}},h.compose=function(){var n=arguments,t=n.length-1;return function(){for(var r=t,e=n[t].apply(this,arguments);r--;)e=n[r].call(this,e);return e}},h.after=function(n,t){return function(){return--n<1?t.apply(this,arguments):void 0}},h.before=function(n,t){var r;return function(){return--n>0?r=t.apply(this,arguments):t=null,r}},h.once=h.partial(h.before,2),h.keys=function(n){if(!h.isObject(n))return[];if(s)return s(n);var t=[];for(var r in n)h.has(n,r)&&t.push(r);return t},h.values=function(n){for(var t=h.keys(n),r=t.length,e=Array(r),u=0;r>u;u++)e[u]=n[t[u]];return e},h.pairs=function(n){for(var t=h.keys(n),r=t.length,e=Array(r),u=0;r>u;u++)e[u]=[t[u],n[t[u]]];return e},h.invert=function(n){for(var t={},r=h.keys(n),e=0,u=r.length;u>e;e++)t[n[r[e]]]=r[e];return t},h.functions=h.methods=function(n){var t=[];for(var r in n)h.isFunction(n[r])&&t.push(r);return t.sort()},h.extend=function(n){if(!h.isObject(n))return n;for(var t,r,e=1,u=arguments.length;u>e;e++){t=arguments[e];for(r in t)c.call(t,r)&&(n[r]=t[r])}return n},h.pick=function(n,t,r){var e,u={};if(null==n)return u;if(h.isFunction(t)){t=g(t,r);for(e in n){var i=n[e];t(i,e,n)&&(u[e]=i)}}else{var l=o.apply([],a.call(arguments,1));n=new Object(n);for(var c=0,f=l.length;f>c;c++)e=l[c],e in n&&(u[e]=n[e])}return u},h.omit=function(n,t,r){if(h.isFunction(t))t=h.negate(t);else{var e=h.map(o.apply([],a.call(arguments,1)),String);t=function(n,t){return!h.contains(e,t)}}return h.pick(n,t,r)},h.defaults=function(n){if(!h.isObject(n))return n;for(var t=1,r=arguments.length;r>t;t++){var e=arguments[t];for(var u in e)n[u]===void 0&&(n[u]=e[u])}return n},h.clone=function(n){return h.isObject(n)?h.isArray(n)?n.slice():h.extend({},n):n},h.tap=function(n,t){return t(n),n};var b=function(n,t,r,e){if(n===t)return 0!==n||1/n===1/t;if(null==n||null==t)return n===t;n instanceof h&&(n=n._wrapped),t instanceof h&&(t=t._wrapped);var u=l.call(n);if(u!==l.call(t))return!1;switch(u){case"[object RegExp]":case"[object String]":return""+n==""+t;case"[object Number]":return+n!==+n?+t!==+t:0===+n?1/+n===1/t:+n===+t;case"[object Date]":case"[object Boolean]":return+n===+t}if("object"!=typeof n||"object"!=typeof t)return!1;for(var i=r.length;i--;)if(r[i]===n)return e[i]===t;var a=n.constructor,o=t.constructor;if(a!==o&&"constructor"in n&&"constructor"in t&&!(h.isFunction(a)&&a instanceof a&&h.isFunction(o)&&o instanceof o))return!1;r.push(n),e.push(t);var c,f;if("[object Array]"===u){if(c=n.length,f=c===t.length)for(;c--&&(f=b(n[c],t[c],r,e)););}else{var s,p=h.keys(n);if(c=p.length,f=h.keys(t).length===c)for(;c--&&(s=p[c],f=h.has(t,s)&&b(n[s],t[s],r,e)););}return r.pop(),e.pop(),f};h.isEqual=function(n,t){return b(n,t,[],[])},h.isEmpty=function(n){if(null==n)return!0;if(h.isArray(n)||h.isString(n)||h.isArguments(n))return 0===n.length;for(var t in n)if(h.has(n,t))return!1;return!0},h.isElement=function(n){return!(!n||1!==n.nodeType)},h.isArray=f||function(n){return"[object Array]"===l.call(n)},h.isObject=function(n){var t=typeof n;return"function"===t||"object"===t&&!!n},h.each(["Arguments","Function","String","Number","Date","RegExp"],function(n){h["is"+n]=function(t){return l.call(t)==="[object "+n+"]"}}),h.isArguments(arguments)||(h.isArguments=function(n){return h.has(n,"callee")}),"function"!=typeof/./&&(h.isFunction=function(n){return"function"==typeof n||!1}),h.isFinite=function(n){return isFinite(n)&&!isNaN(parseFloat(n))},h.isNaN=function(n){return h.isNumber(n)&&n!==+n},h.isBoolean=function(n){return n===!0||n===!1||"[object Boolean]"===l.call(n)},h.isNull=function(n){return null===n},h.isUndefined=function(n){return n===void 0},h.has=function(n,t){return null!=n&&c.call(n,t)},h.noConflict=function(){return n._=t,this},h.identity=function(n){return n},h.constant=function(n){return function(){return n}},h.noop=function(){},h.property=function(n){return function(t){return t[n]}},h.matches=function(n){var t=h.pairs(n),r=t.length;return function(n){if(null==n)return!r;n=new Object(n);for(var e=0;r>e;e++){var u=t[e],i=u[0];if(u[1]!==n[i]||!(i in n))return!1}return!0}},h.times=function(n,t,r){var e=Array(Math.max(0,n));t=g(t,r,1);for(var u=0;n>u;u++)e[u]=t(u);return e},h.random=function(n,t){return null==t&&(t=n,n=0),n+Math.floor(Math.random()*(t-n+1))},h.now=Date.now||function(){return(new Date).getTime()};var _={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","`":"&#x60;"},w=h.invert(_),j=function(n){var t=function(t){return n[t]},r="(?:"+h.keys(n).join("|")+")",e=RegExp(r),u=RegExp(r,"g");return function(n){return n=null==n?"":""+n,e.test(n)?n.replace(u,t):n}};h.escape=j(_),h.unescape=j(w),h.result=function(n,t){if(null==n)return void 0;var r=n[t];return h.isFunction(r)?n[t]():r};var x=0;h.uniqueId=function(n){var t=++x+"";return n?n+t:t},h.templateSettings={evaluate:/<%([\s\S]+?)%>/g,interpolate:/<%=([\s\S]+?)%>/g,escape:/<%-([\s\S]+?)%>/g};var A=/(.)^/,k={"'":"'","\\":"\\","\r":"r","\n":"n","\u2028":"u2028","\u2029":"u2029"},O=/\\|'|\r|\n|\u2028|\u2029/g,F=function(n){return"\\"+k[n]};h.template=function(n,t,r){!t&&r&&(t=r),t=h.defaults({},t,h.templateSettings);var e=RegExp([(t.escape||A).source,(t.interpolate||A).source,(t.evaluate||A).source].join("|")+"|$","g"),u=0,i="__p+='";n.replace(e,function(t,r,e,a,o){return i+=n.slice(u,o).replace(O,F),u=o+t.length,r?i+="'+\n((__t=("+r+"))==null?'':_.escape(__t))+\n'":e?i+="'+\n((__t=("+e+"))==null?'':__t)+\n'":a&&(i+="';\n"+a+"\n__p+='"),t}),i+="';\n",t.variable||(i="with(obj||{}){\n"+i+"}\n"),i="var __t,__p='',__j=Array.prototype.join,"+"print=function(){__p+=__j.call(arguments,'');};\n"+i+"return __p;\n";try{var a=new Function(t.variable||"obj","_",i)}catch(o){throw o.source=i,o}var l=function(n){return a.call(this,n,h)},c=t.variable||"obj";return l.source="function("+c+"){\n"+i+"}",l},h.chain=function(n){var t=h(n);return t._chain=!0,t};var E=function(n){return this._chain?h(n).chain():n};h.mixin=function(n){h.each(h.functions(n),function(t){var r=h[t]=n[t];h.prototype[t]=function(){var n=[this._wrapped];return i.apply(n,arguments),E.call(this,r.apply(h,n))}})},h.mixin(h),h.each(["pop","push","reverse","shift","sort","splice","unshift"],function(n){var t=r[n];h.prototype[n]=function(){var r=this._wrapped;return t.apply(r,arguments),"shift"!==n&&"splice"!==n||0!==r.length||delete r[0],E.call(this,r)}}),h.each(["concat","join","slice"],function(n){var t=r[n];h.prototype[n]=function(){return E.call(this,t.apply(this._wrapped,arguments))}}),h.prototype.value=function(){return this._wrapped},"function"==typeof define&&define.amd&&define("underscore",[],function(){return h})}).call(this);


/*!
 * Bootstrap v3.3.1 (http://getbootstrap.com)
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
*/

if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(a){var b=a.fn.jquery.split(" ")[0].split(".");if(b[0]<2&&b[1]<9||1==b[0]&&9==b[1]&&b[2]<1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")}(jQuery),+function(a){"use strict";function b(){var a=document.createElement("bootstrap"),b={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var c in b)if(void 0!==a.style[c])return{end:b[c]};return!1}a.fn.emulateTransitionEnd=function(b){var c=!1,d=this;a(this).one("bsTransitionEnd",function(){c=!0});var e=function(){c||a(d).trigger(a.support.transition.end)};return setTimeout(e,b),this},a(function(){a.support.transition=b(),a.support.transition&&(a.event.special.bsTransitionEnd={bindType:a.support.transition.end,delegateType:a.support.transition.end,handle:function(b){return a(b.target).is(this)?b.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var c=a(this),e=c.data("bs.alert");e||c.data("bs.alert",e=new d(this)),"string"==typeof b&&e[b].call(c)})}var c='[data-dismiss="alert"]',d=function(b){a(b).on("click",c,this.close)};d.VERSION="3.3.1",d.TRANSITION_DURATION=150,d.prototype.close=function(b){function c(){g.detach().trigger("closed.bs.alert").remove()}var e=a(this),f=e.attr("data-target");f||(f=e.attr("href"),f=f&&f.replace(/.*(?=#[^\s]*$)/,""));var g=a(f);b&&b.preventDefault(),g.length||(g=e.closest(".alert")),g.trigger(b=a.Event("close.bs.alert")),b.isDefaultPrevented()||(g.removeClass("in"),a.support.transition&&g.hasClass("fade")?g.one("bsTransitionEnd",c).emulateTransitionEnd(d.TRANSITION_DURATION):c())};var e=a.fn.alert;a.fn.alert=b,a.fn.alert.Constructor=d,a.fn.alert.noConflict=function(){return a.fn.alert=e,this},a(document).on("click.bs.alert.data-api",c,d.prototype.close)}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.button"),f="object"==typeof b&&b;e||d.data("bs.button",e=new c(this,f)),"toggle"==b?e.toggle():b&&e.setState(b)})}var c=function(b,d){this.$element=a(b),this.options=a.extend({},c.DEFAULTS,d),this.isLoading=!1};c.VERSION="3.3.1",c.DEFAULTS={loadingText:"loading..."},c.prototype.setState=function(b){var c="disabled",d=this.$element,e=d.is("input")?"val":"html",f=d.data();b+="Text",null==f.resetText&&d.data("resetText",d[e]()),setTimeout(a.proxy(function(){d[e](null==f[b]?this.options[b]:f[b]),"loadingText"==b?(this.isLoading=!0,d.addClass(c).attr(c,c)):this.isLoading&&(this.isLoading=!1,d.removeClass(c).removeAttr(c))},this),0)},c.prototype.toggle=function(){var a=!0,b=this.$element.closest('[data-toggle="buttons"]');if(b.length){var c=this.$element.find("input");"radio"==c.prop("type")&&(c.prop("checked")&&this.$element.hasClass("active")?a=!1:b.find(".active").removeClass("active")),a&&c.prop("checked",!this.$element.hasClass("active")).trigger("change")}else this.$element.attr("aria-pressed",!this.$element.hasClass("active"));a&&this.$element.toggleClass("active")};var d=a.fn.button;a.fn.button=b,a.fn.button.Constructor=c,a.fn.button.noConflict=function(){return a.fn.button=d,this},a(document).on("click.bs.button.data-api",'[data-toggle^="button"]',function(c){var d=a(c.target);d.hasClass("btn")||(d=d.closest(".btn")),b.call(d,"toggle"),c.preventDefault()}).on("focus.bs.button.data-api blur.bs.button.data-api",'[data-toggle^="button"]',function(b){a(b.target).closest(".btn").toggleClass("focus",/^focus(in)?$/.test(b.type))})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.carousel"),f=a.extend({},c.DEFAULTS,d.data(),"object"==typeof b&&b),g="string"==typeof b?b:f.slide;e||d.data("bs.carousel",e=new c(this,f)),"number"==typeof b?e.to(b):g?e[g]():f.interval&&e.pause().cycle()})}var c=function(b,c){this.$element=a(b),this.$indicators=this.$element.find(".carousel-indicators"),this.options=c,this.paused=this.sliding=this.interval=this.$active=this.$items=null,this.options.keyboard&&this.$element.on("keydown.bs.carousel",a.proxy(this.keydown,this)),"hover"==this.options.pause&&!("ontouchstart"in document.documentElement)&&this.$element.on("mouseenter.bs.carousel",a.proxy(this.pause,this)).on("mouseleave.bs.carousel",a.proxy(this.cycle,this))};c.VERSION="3.3.1",c.TRANSITION_DURATION=600,c.DEFAULTS={interval:5e3,pause:"hover",wrap:!0,keyboard:!0},c.prototype.keydown=function(a){if(!/input|textarea/i.test(a.target.tagName)){switch(a.which){case 37:this.prev();break;case 39:this.next();break;default:return}a.preventDefault()}},c.prototype.cycle=function(b){return b||(this.paused=!1),this.interval&&clearInterval(this.interval),this.options.interval&&!this.paused&&(this.interval=setInterval(a.proxy(this.next,this),this.options.interval)),this},c.prototype.getItemIndex=function(a){return this.$items=a.parent().children(".item"),this.$items.index(a||this.$active)},c.prototype.getItemForDirection=function(a,b){var c="prev"==a?-1:1,d=this.getItemIndex(b),e=(d+c)%this.$items.length;return this.$items.eq(e)},c.prototype.to=function(a){var b=this,c=this.getItemIndex(this.$active=this.$element.find(".item.active"));return a>this.$items.length-1||0>a?void 0:this.sliding?this.$element.one("slid.bs.carousel",function(){b.to(a)}):c==a?this.pause().cycle():this.slide(a>c?"next":"prev",this.$items.eq(a))},c.prototype.pause=function(b){return b||(this.paused=!0),this.$element.find(".next, .prev").length&&a.support.transition&&(this.$element.trigger(a.support.transition.end),this.cycle(!0)),this.interval=clearInterval(this.interval),this},c.prototype.next=function(){return this.sliding?void 0:this.slide("next")},c.prototype.prev=function(){return this.sliding?void 0:this.slide("prev")},c.prototype.slide=function(b,d){var e=this.$element.find(".item.active"),f=d||this.getItemForDirection(b,e),g=this.interval,h="next"==b?"left":"right",i="next"==b?"first":"last",j=this;if(!f.length){if(!this.options.wrap)return;f=this.$element.find(".item")[i]()}if(f.hasClass("active"))return this.sliding=!1;var k=f[0],l=a.Event("slide.bs.carousel",{relatedTarget:k,direction:h});if(this.$element.trigger(l),!l.isDefaultPrevented()){if(this.sliding=!0,g&&this.pause(),this.$indicators.length){this.$indicators.find(".active").removeClass("active");var m=a(this.$indicators.children()[this.getItemIndex(f)]);m&&m.addClass("active")}var n=a.Event("slid.bs.carousel",{relatedTarget:k,direction:h});return a.support.transition&&this.$element.hasClass("slide")?(f.addClass(b),f[0].offsetWidth,e.addClass(h),f.addClass(h),e.one("bsTransitionEnd",function(){f.removeClass([b,h].join(" ")).addClass("active"),e.removeClass(["active",h].join(" ")),j.sliding=!1,setTimeout(function(){j.$element.trigger(n)},0)}).emulateTransitionEnd(c.TRANSITION_DURATION)):(e.removeClass("active"),f.addClass("active"),this.sliding=!1,this.$element.trigger(n)),g&&this.cycle(),this}};var d=a.fn.carousel;a.fn.carousel=b,a.fn.carousel.Constructor=c,a.fn.carousel.noConflict=function(){return a.fn.carousel=d,this};var e=function(c){var d,e=a(this),f=a(e.attr("data-target")||(d=e.attr("href"))&&d.replace(/.*(?=#[^\s]+$)/,""));if(f.hasClass("carousel")){var g=a.extend({},f.data(),e.data()),h=e.attr("data-slide-to");h&&(g.interval=!1),b.call(f,g),h&&f.data("bs.carousel").to(h),c.preventDefault()}};a(document).on("click.bs.carousel.data-api","[data-slide]",e).on("click.bs.carousel.data-api","[data-slide-to]",e),a(window).on("load",function(){a('[data-ride="carousel"]').each(function(){var c=a(this);b.call(c,c.data())})})}(jQuery),+function(a){"use strict";function b(b){var c,d=b.attr("data-target")||(c=b.attr("href"))&&c.replace(/.*(?=#[^\s]+$)/,"");return a(d)}function c(b){return this.each(function(){var c=a(this),e=c.data("bs.collapse"),f=a.extend({},d.DEFAULTS,c.data(),"object"==typeof b&&b);!e&&f.toggle&&"show"==b&&(f.toggle=!1),e||c.data("bs.collapse",e=new d(this,f)),"string"==typeof b&&e[b]()})}var d=function(b,c){this.$element=a(b),this.options=a.extend({},d.DEFAULTS,c),this.$trigger=a(this.options.trigger).filter('[href="#'+b.id+'"], [data-target="#'+b.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()};d.VERSION="3.3.1",d.TRANSITION_DURATION=350,d.DEFAULTS={toggle:!0,trigger:'[data-toggle="collapse"]'},d.prototype.dimension=function(){var a=this.$element.hasClass("width");return a?"width":"height"},d.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var b,e=this.$parent&&this.$parent.find("> .panel").children(".in, .collapsing");if(!(e&&e.length&&(b=e.data("bs.collapse"),b&&b.transitioning))){var f=a.Event("show.bs.collapse");if(this.$element.trigger(f),!f.isDefaultPrevented()){e&&e.length&&(c.call(e,"hide"),b||e.data("bs.collapse",null));var g=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[g](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;var h=function(){this.$element.removeClass("collapsing").addClass("collapse in")[g](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!a.support.transition)return h.call(this);var i=a.camelCase(["scroll",g].join("-"));this.$element.one("bsTransitionEnd",a.proxy(h,this)).emulateTransitionEnd(d.TRANSITION_DURATION)[g](this.$element[0][i])}}}},d.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var b=a.Event("hide.bs.collapse");if(this.$element.trigger(b),!b.isDefaultPrevented()){var c=this.dimension();this.$element[c](this.$element[c]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;var e=function(){this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};return a.support.transition?void this.$element[c](0).one("bsTransitionEnd",a.proxy(e,this)).emulateTransitionEnd(d.TRANSITION_DURATION):e.call(this)}}},d.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()},d.prototype.getParent=function(){return a(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(a.proxy(function(c,d){var e=a(d);this.addAriaAndCollapsedClass(b(e),e)},this)).end()},d.prototype.addAriaAndCollapsedClass=function(a,b){var c=a.hasClass("in");a.attr("aria-expanded",c),b.toggleClass("collapsed",!c).attr("aria-expanded",c)};var e=a.fn.collapse;a.fn.collapse=c,a.fn.collapse.Constructor=d,a.fn.collapse.noConflict=function(){return a.fn.collapse=e,this},a(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(d){var e=a(this);e.attr("data-target")||d.preventDefault();var f=b(e),g=f.data("bs.collapse"),h=g?"toggle":a.extend({},e.data(),{trigger:this});c.call(f,h)})}(jQuery),+function(a){"use strict";function b(b){b&&3===b.which||(a(e).remove(),a(f).each(function(){var d=a(this),e=c(d),f={relatedTarget:this};e.hasClass("open")&&(e.trigger(b=a.Event("hide.bs.dropdown",f)),b.isDefaultPrevented()||(d.attr("aria-expanded","false"),e.removeClass("open").trigger("hidden.bs.dropdown",f)))}))}function c(b){var c=b.attr("data-target");c||(c=b.attr("href"),c=c&&/#[A-Za-z]/.test(c)&&c.replace(/.*(?=#[^\s]*$)/,""));var d=c&&a(c);return d&&d.length?d:b.parent()}function d(b){return this.each(function(){var c=a(this),d=c.data("bs.dropdown");d||c.data("bs.dropdown",d=new g(this)),"string"==typeof b&&d[b].call(c)})}var e=".dropdown-backdrop",f='[data-toggle="dropdown"]',g=function(b){a(b).on("click.bs.dropdown",this.toggle)};g.VERSION="3.3.1",g.prototype.toggle=function(d){var e=a(this);if(!e.is(".disabled, :disabled")){var f=c(e),g=f.hasClass("open");if(b(),!g){"ontouchstart"in document.documentElement&&!f.closest(".navbar-nav").length&&a('<div class="dropdown-backdrop"/>').insertAfter(a(this)).on("click",b);var h={relatedTarget:this};if(f.trigger(d=a.Event("show.bs.dropdown",h)),d.isDefaultPrevented())return;e.trigger("focus").attr("aria-expanded","true"),f.toggleClass("open").trigger("shown.bs.dropdown",h)}return!1}},g.prototype.keydown=function(b){if(/(38|40|27|32)/.test(b.which)&&!/input|textarea/i.test(b.target.tagName)){var d=a(this);if(b.preventDefault(),b.stopPropagation(),!d.is(".disabled, :disabled")){var e=c(d),g=e.hasClass("open");if(!g&&27!=b.which||g&&27==b.which)return 27==b.which&&e.find(f).trigger("focus"),d.trigger("click");var h=" li:not(.divider):visible a",i=e.find('[role="menu"]'+h+', [role="listbox"]'+h);if(i.length){var j=i.index(b.target);38==b.which&&j>0&&j--,40==b.which&&j<i.length-1&&j++,~j||(j=0),i.eq(j).trigger("focus")}}}};var h=a.fn.dropdown;a.fn.dropdown=d,a.fn.dropdown.Constructor=g,a.fn.dropdown.noConflict=function(){return a.fn.dropdown=h,this},a(document).on("click.bs.dropdown.data-api",b).on("click.bs.dropdown.data-api",".dropdown form",function(a){a.stopPropagation()}).on("click.bs.dropdown.data-api",f,g.prototype.toggle).on("keydown.bs.dropdown.data-api",f,g.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="menu"]',g.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="listbox"]',g.prototype.keydown)}(jQuery),+function(a){"use strict";function b(b,d){return this.each(function(){var e=a(this),f=e.data("bs.modal"),g=a.extend({},c.DEFAULTS,e.data(),"object"==typeof b&&b);f||e.data("bs.modal",f=new c(this,g)),"string"==typeof b?f[b](d):g.show&&f.show(d)})}var c=function(b,c){this.options=c,this.$body=a(document.body),this.$element=a(b),this.$backdrop=this.isShown=null,this.scrollbarWidth=0,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,a.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};c.VERSION="3.3.1",c.TRANSITION_DURATION=300,c.BACKDROP_TRANSITION_DURATION=150,c.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},c.prototype.toggle=function(a){return this.isShown?this.hide():this.show(a)},c.prototype.show=function(b){var d=this,e=a.Event("show.bs.modal",{relatedTarget:b});this.$element.trigger(e),this.isShown||e.isDefaultPrevented()||(this.isShown=!0,this.checkScrollbar(),this.setScrollbar(),this.$body.addClass("modal-open"),this.escape(),this.resize(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',a.proxy(this.hide,this)),this.backdrop(function(){var e=a.support.transition&&d.$element.hasClass("fade");d.$element.parent().length||d.$element.appendTo(d.$body),d.$element.show().scrollTop(0),d.options.backdrop&&d.adjustBackdrop(),d.adjustDialog(),e&&d.$element[0].offsetWidth,d.$element.addClass("in").attr("aria-hidden",!1),d.enforceFocus();var f=a.Event("shown.bs.modal",{relatedTarget:b});e?d.$element.find(".modal-dialog").one("bsTransitionEnd",function(){d.$element.trigger("focus").trigger(f)}).emulateTransitionEnd(c.TRANSITION_DURATION):d.$element.trigger("focus").trigger(f)}))},c.prototype.hide=function(b){b&&b.preventDefault(),b=a.Event("hide.bs.modal"),this.$element.trigger(b),this.isShown&&!b.isDefaultPrevented()&&(this.isShown=!1,this.escape(),this.resize(),a(document).off("focusin.bs.modal"),this.$element.removeClass("in").attr("aria-hidden",!0).off("click.dismiss.bs.modal"),a.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",a.proxy(this.hideModal,this)).emulateTransitionEnd(c.TRANSITION_DURATION):this.hideModal())},c.prototype.enforceFocus=function(){a(document).off("focusin.bs.modal").on("focusin.bs.modal",a.proxy(function(a){this.$element[0]===a.target||this.$element.has(a.target).length||this.$element.trigger("focus")},this))},c.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",a.proxy(function(a){27==a.which&&this.hide()},this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")},c.prototype.resize=function(){this.isShown?a(window).on("resize.bs.modal",a.proxy(this.handleUpdate,this)):a(window).off("resize.bs.modal")},c.prototype.hideModal=function(){var a=this;this.$element.hide(),this.backdrop(function(){a.$body.removeClass("modal-open"),a.resetAdjustments(),a.resetScrollbar(),a.$element.trigger("hidden.bs.modal")})},c.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},c.prototype.backdrop=function(b){var d=this,e=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var f=a.support.transition&&e;if(this.$backdrop=a('<div class="modal-backdrop '+e+'" />').prependTo(this.$element).on("click.dismiss.bs.modal",a.proxy(function(a){a.target===a.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus.call(this.$element[0]):this.hide.call(this))},this)),f&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!b)return;f?this.$backdrop.one("bsTransitionEnd",b).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION):b()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");var g=function(){d.removeBackdrop(),b&&b()};a.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",g).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION):g()}else b&&b()},c.prototype.handleUpdate=function(){this.options.backdrop&&this.adjustBackdrop(),this.adjustDialog()},c.prototype.adjustBackdrop=function(){this.$backdrop.css("height",0).css("height",this.$element[0].scrollHeight)},c.prototype.adjustDialog=function(){var a=this.$element[0].scrollHeight>document.documentElement.clientHeight;this.$element.css({paddingLeft:!this.bodyIsOverflowing&&a?this.scrollbarWidth:"",paddingRight:this.bodyIsOverflowing&&!a?this.scrollbarWidth:""})},c.prototype.resetAdjustments=function(){this.$element.css({paddingLeft:"",paddingRight:""})},c.prototype.checkScrollbar=function(){this.bodyIsOverflowing=document.body.scrollHeight>document.documentElement.clientHeight,this.scrollbarWidth=this.measureScrollbar()},c.prototype.setScrollbar=function(){var a=parseInt(this.$body.css("padding-right")||0,10);this.bodyIsOverflowing&&this.$body.css("padding-right",a+this.scrollbarWidth)},c.prototype.resetScrollbar=function(){this.$body.css("padding-right","")},c.prototype.measureScrollbar=function(){var a=document.createElement("div");a.className="modal-scrollbar-measure",this.$body.append(a);var b=a.offsetWidth-a.clientWidth;return this.$body[0].removeChild(a),b};var d=a.fn.modal;a.fn.modal=b,a.fn.modal.Constructor=c,a.fn.modal.noConflict=function(){return a.fn.modal=d,this},a(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(c){var d=a(this),e=d.attr("href"),f=a(d.attr("data-target")||e&&e.replace(/.*(?=#[^\s]+$)/,"")),g=f.data("bs.modal")?"toggle":a.extend({remote:!/#/.test(e)&&e},f.data(),d.data());d.is("a")&&c.preventDefault(),f.one("show.bs.modal",function(a){a.isDefaultPrevented()||f.one("hidden.bs.modal",function(){d.is(":visible")&&d.trigger("focus")})}),b.call(f,g,this)})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.tooltip"),f="object"==typeof b&&b,g=f&&f.selector;(e||"destroy"!=b)&&(g?(e||d.data("bs.tooltip",e={}),e[g]||(e[g]=new c(this,f))):e||d.data("bs.tooltip",e=new c(this,f)),"string"==typeof b&&e[b]())})}var c=function(a,b){this.type=this.options=this.enabled=this.timeout=this.hoverState=this.$element=null,this.init("tooltip",a,b)};c.VERSION="3.3.1",c.TRANSITION_DURATION=150,c.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1,viewport:{selector:"body",padding:0}},c.prototype.init=function(b,c,d){this.enabled=!0,this.type=b,this.$element=a(c),this.options=this.getOptions(d),this.$viewport=this.options.viewport&&a(this.options.viewport.selector||this.options.viewport);for(var e=this.options.trigger.split(" "),f=e.length;f--;){var g=e[f];if("click"==g)this.$element.on("click."+this.type,this.options.selector,a.proxy(this.toggle,this));else if("manual"!=g){var h="hover"==g?"mouseenter":"focusin",i="hover"==g?"mouseleave":"focusout";this.$element.on(h+"."+this.type,this.options.selector,a.proxy(this.enter,this)),this.$element.on(i+"."+this.type,this.options.selector,a.proxy(this.leave,this))}}this.options.selector?this._options=a.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},c.prototype.getDefaults=function(){return c.DEFAULTS},c.prototype.getOptions=function(b){return b=a.extend({},this.getDefaults(),this.$element.data(),b),b.delay&&"number"==typeof b.delay&&(b.delay={show:b.delay,hide:b.delay}),b},c.prototype.getDelegateOptions=function(){var b={},c=this.getDefaults();return this._options&&a.each(this._options,function(a,d){c[a]!=d&&(b[a]=d)}),b},c.prototype.enter=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget).data("bs."+this.type);return c&&c.$tip&&c.$tip.is(":visible")?void(c.hoverState="in"):(c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c)),clearTimeout(c.timeout),c.hoverState="in",c.options.delay&&c.options.delay.show?void(c.timeout=setTimeout(function(){"in"==c.hoverState&&c.show()},c.options.delay.show)):c.show())},c.prototype.leave=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget).data("bs."+this.type);return c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c)),clearTimeout(c.timeout),c.hoverState="out",c.options.delay&&c.options.delay.hide?void(c.timeout=setTimeout(function(){"out"==c.hoverState&&c.hide()},c.options.delay.hide)):c.hide()},c.prototype.show=function(){var b=a.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){this.$element.trigger(b);var d=a.contains(this.$element[0].ownerDocument.documentElement,this.$element[0]);if(b.isDefaultPrevented()||!d)return;var e=this,f=this.tip(),g=this.getUID(this.type);this.setContent(),f.attr("id",g),this.$element.attr("aria-describedby",g),this.options.animation&&f.addClass("fade");var h="function"==typeof this.options.placement?this.options.placement.call(this,f[0],this.$element[0]):this.options.placement,i=/\s?auto?\s?/i,j=i.test(h);j&&(h=h.replace(i,"")||"top"),f.detach().css({top:0,left:0,display:"block"}).addClass(h).data("bs."+this.type,this),this.options.container?f.appendTo(this.options.container):f.insertAfter(this.$element);var k=this.getPosition(),l=f[0].offsetWidth,m=f[0].offsetHeight;if(j){var n=h,o=this.options.container?a(this.options.container):this.$element.parent(),p=this.getPosition(o);h="bottom"==h&&k.bottom+m>p.bottom?"top":"top"==h&&k.top-m<p.top?"bottom":"right"==h&&k.right+l>p.width?"left":"left"==h&&k.left-l<p.left?"right":h,f.removeClass(n).addClass(h)}var q=this.getCalculatedOffset(h,k,l,m);this.applyPlacement(q,h);var r=function(){var a=e.hoverState;e.$element.trigger("shown.bs."+e.type),e.hoverState=null,"out"==a&&e.leave(e)};a.support.transition&&this.$tip.hasClass("fade")?f.one("bsTransitionEnd",r).emulateTransitionEnd(c.TRANSITION_DURATION):r()}},c.prototype.applyPlacement=function(b,c){var d=this.tip(),e=d[0].offsetWidth,f=d[0].offsetHeight,g=parseInt(d.css("margin-top"),10),h=parseInt(d.css("margin-left"),10);isNaN(g)&&(g=0),isNaN(h)&&(h=0),b.top=b.top+g,b.left=b.left+h,a.offset.setOffset(d[0],a.extend({using:function(a){d.css({top:Math.round(a.top),left:Math.round(a.left)})}},b),0),d.addClass("in");var i=d[0].offsetWidth,j=d[0].offsetHeight;"top"==c&&j!=f&&(b.top=b.top+f-j);var k=this.getViewportAdjustedDelta(c,b,i,j);k.left?b.left+=k.left:b.top+=k.top;var l=/top|bottom/.test(c),m=l?2*k.left-e+i:2*k.top-f+j,n=l?"offsetWidth":"offsetHeight";d.offset(b),this.replaceArrow(m,d[0][n],l)},c.prototype.replaceArrow=function(a,b,c){this.arrow().css(c?"left":"top",50*(1-a/b)+"%").css(c?"top":"left","")},c.prototype.setContent=function(){var a=this.tip(),b=this.getTitle();a.find(".tooltip-inner")[this.options.html?"html":"text"](b),a.removeClass("fade in top bottom left right")},c.prototype.hide=function(b){function d(){"in"!=e.hoverState&&f.detach(),e.$element.removeAttr("aria-describedby").trigger("hidden.bs."+e.type),b&&b()}var e=this,f=this.tip(),g=a.Event("hide.bs."+this.type);return this.$element.trigger(g),g.isDefaultPrevented()?void 0:(f.removeClass("in"),a.support.transition&&this.$tip.hasClass("fade")?f.one("bsTransitionEnd",d).emulateTransitionEnd(c.TRANSITION_DURATION):d(),this.hoverState=null,this)},c.prototype.fixTitle=function(){var a=this.$element;(a.attr("title")||"string"!=typeof a.attr("data-original-title"))&&a.attr("data-original-title",a.attr("title")||"").attr("title","")},c.prototype.hasContent=function(){return this.getTitle()},c.prototype.getPosition=function(b){b=b||this.$element;var c=b[0],d="BODY"==c.tagName,e=c.getBoundingClientRect();null==e.width&&(e=a.extend({},e,{width:e.right-e.left,height:e.bottom-e.top}));var f=d?{top:0,left:0}:b.offset(),g={scroll:d?document.documentElement.scrollTop||document.body.scrollTop:b.scrollTop()},h=d?{width:a(window).width(),height:a(window).height()}:null;return a.extend({},e,g,h,f)},c.prototype.getCalculatedOffset=function(a,b,c,d){return"bottom"==a?{top:b.top+b.height,left:b.left+b.width/2-c/2}:"top"==a?{top:b.top-d,left:b.left+b.width/2-c/2}:"left"==a?{top:b.top+b.height/2-d/2,left:b.left-c}:{top:b.top+b.height/2-d/2,left:b.left+b.width}},c.prototype.getViewportAdjustedDelta=function(a,b,c,d){var e={top:0,left:0};if(!this.$viewport)return e;var f=this.options.viewport&&this.options.viewport.padding||0,g=this.getPosition(this.$viewport);if(/right|left/.test(a)){var h=b.top-f-g.scroll,i=b.top+f-g.scroll+d;h<g.top?e.top=g.top-h:i>g.top+g.height&&(e.top=g.top+g.height-i)}else{var j=b.left-f,k=b.left+f+c;j<g.left?e.left=g.left-j:k>g.width&&(e.left=g.left+g.width-k)}return e},c.prototype.getTitle=function(){var a,b=this.$element,c=this.options;return a=b.attr("data-original-title")||("function"==typeof c.title?c.title.call(b[0]):c.title)},c.prototype.getUID=function(a){do a+=~~(1e6*Math.random());while(document.getElementById(a));return a},c.prototype.tip=function(){return this.$tip=this.$tip||a(this.options.template)},c.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},c.prototype.enable=function(){this.enabled=!0},c.prototype.disable=function(){this.enabled=!1},c.prototype.toggleEnabled=function(){this.enabled=!this.enabled},c.prototype.toggle=function(b){var c=this;b&&(c=a(b.currentTarget).data("bs."+this.type),c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c))),c.tip().hasClass("in")?c.leave(c):c.enter(c)},c.prototype.destroy=function(){var a=this;clearTimeout(this.timeout),this.hide(function(){a.$element.off("."+a.type).removeData("bs."+a.type)})};var d=a.fn.tooltip;a.fn.tooltip=b,a.fn.tooltip.Constructor=c,a.fn.tooltip.noConflict=function(){return a.fn.tooltip=d,this}}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.popover"),f="object"==typeof b&&b,g=f&&f.selector;(e||"destroy"!=b)&&(g?(e||d.data("bs.popover",e={}),e[g]||(e[g]=new c(this,f))):e||d.data("bs.popover",e=new c(this,f)),"string"==typeof b&&e[b]())})}var c=function(a,b){this.init("popover",a,b)};if(!a.fn.tooltip)throw new Error("Popover requires tooltip.js");c.VERSION="3.3.1",c.DEFAULTS=a.extend({},a.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),c.prototype=a.extend({},a.fn.tooltip.Constructor.prototype),c.prototype.constructor=c,c.prototype.getDefaults=function(){return c.DEFAULTS},c.prototype.setContent=function(){var a=this.tip(),b=this.getTitle(),c=this.getContent();a.find(".popover-title")[this.options.html?"html":"text"](b),a.find(".popover-content").children().detach().end()[this.options.html?"string"==typeof c?"html":"append":"text"](c),a.removeClass("fade top bottom left right in"),a.find(".popover-title").html()||a.find(".popover-title").hide()},c.prototype.hasContent=function(){return this.getTitle()||this.getContent()},c.prototype.getContent=function(){var a=this.$element,b=this.options;return a.attr("data-content")||("function"==typeof b.content?b.content.call(a[0]):b.content)},c.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")},c.prototype.tip=function(){return this.$tip||(this.$tip=a(this.options.template)),this.$tip};var d=a.fn.popover;a.fn.popover=b,a.fn.popover.Constructor=c,a.fn.popover.noConflict=function(){return a.fn.popover=d,this}}(jQuery),+function(a){"use strict";function b(c,d){var e=a.proxy(this.process,this);this.$body=a("body"),this.$scrollElement=a(a(c).is("body")?window:c),this.options=a.extend({},b.DEFAULTS,d),this.selector=(this.options.target||"")+" .nav li > a",this.offsets=[],this.targets=[],this.activeTarget=null,this.scrollHeight=0,this.$scrollElement.on("scroll.bs.scrollspy",e),this.refresh(),this.process()}function c(c){return this.each(function(){var d=a(this),e=d.data("bs.scrollspy"),f="object"==typeof c&&c;e||d.data("bs.scrollspy",e=new b(this,f)),"string"==typeof c&&e[c]()})}b.VERSION="3.3.1",b.DEFAULTS={offset:10},b.prototype.getScrollHeight=function(){return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)},b.prototype.refresh=function(){var b="offset",c=0;a.isWindow(this.$scrollElement[0])||(b="position",c=this.$scrollElement.scrollTop()),this.offsets=[],this.targets=[],this.scrollHeight=this.getScrollHeight();var d=this;this.$body.find(this.selector).map(function(){var d=a(this),e=d.data("target")||d.attr("href"),f=/^#./.test(e)&&a(e);return f&&f.length&&f.is(":visible")&&[[f[b]().top+c,e]]||null}).sort(function(a,b){return a[0]-b[0]}).each(function(){d.offsets.push(this[0]),d.targets.push(this[1])})},b.prototype.process=function(){var a,b=this.$scrollElement.scrollTop()+this.options.offset,c=this.getScrollHeight(),d=this.options.offset+c-this.$scrollElement.height(),e=this.offsets,f=this.targets,g=this.activeTarget;if(this.scrollHeight!=c&&this.refresh(),b>=d)return g!=(a=f[f.length-1])&&this.activate(a);if(g&&b<e[0])return this.activeTarget=null,this.clear();for(a=e.length;a--;)g!=f[a]&&b>=e[a]&&(!e[a+1]||b<=e[a+1])&&this.activate(f[a])},b.prototype.activate=function(b){this.activeTarget=b,this.clear();var c=this.selector+'[data-target="'+b+'"],'+this.selector+'[href="'+b+'"]',d=a(c).parents("li").addClass("active");d.parent(".dropdown-menu").length&&(d=d.closest("li.dropdown").addClass("active")),d.trigger("activate.bs.scrollspy")},b.prototype.clear=function(){a(this.selector).parentsUntil(this.options.target,".active").removeClass("active")};var d=a.fn.scrollspy;a.fn.scrollspy=c,a.fn.scrollspy.Constructor=b,a.fn.scrollspy.noConflict=function(){return a.fn.scrollspy=d,this},a(window).on("load.bs.scrollspy.data-api",function(){a('[data-spy="scroll"]').each(function(){var b=a(this);c.call(b,b.data())})})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.tab");e||d.data("bs.tab",e=new c(this)),"string"==typeof b&&e[b]()})}var c=function(b){this.element=a(b)};c.VERSION="3.3.1",c.TRANSITION_DURATION=150,c.prototype.show=function(){var b=this.element,c=b.closest("ul:not(.dropdown-menu)"),d=b.data("target");if(d||(d=b.attr("href"),d=d&&d.replace(/.*(?=#[^\s]*$)/,"")),!b.parent("li").hasClass("active")){var e=c.find(".active:last a"),f=a.Event("hide.bs.tab",{relatedTarget:b[0]}),g=a.Event("show.bs.tab",{relatedTarget:e[0]});if(e.trigger(f),b.trigger(g),!g.isDefaultPrevented()&&!f.isDefaultPrevented()){var h=a(d);this.activate(b.closest("li"),c),this.activate(h,h.parent(),function(){e.trigger({type:"hidden.bs.tab",relatedTarget:b[0]}),b.trigger({type:"shown.bs.tab",relatedTarget:e[0]})
})}}},c.prototype.activate=function(b,d,e){function f(){g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),b.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0),h?(b[0].offsetWidth,b.addClass("in")):b.removeClass("fade"),b.parent(".dropdown-menu")&&b.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!0),e&&e()}var g=d.find("> .active"),h=e&&a.support.transition&&(g.length&&g.hasClass("fade")||!!d.find("> .fade").length);g.length&&h?g.one("bsTransitionEnd",f).emulateTransitionEnd(c.TRANSITION_DURATION):f(),g.removeClass("in")};var d=a.fn.tab;a.fn.tab=b,a.fn.tab.Constructor=c,a.fn.tab.noConflict=function(){return a.fn.tab=d,this};var e=function(c){c.preventDefault(),b.call(a(this),"show")};a(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',e).on("click.bs.tab.data-api",'[data-toggle="pill"]',e)}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.affix"),f="object"==typeof b&&b;e||d.data("bs.affix",e=new c(this,f)),"string"==typeof b&&e[b]()})}var c=function(b,d){this.options=a.extend({},c.DEFAULTS,d),this.$target=a(this.options.target).on("scroll.bs.affix.data-api",a.proxy(this.checkPosition,this)).on("click.bs.affix.data-api",a.proxy(this.checkPositionWithEventLoop,this)),this.$element=a(b),this.affixed=this.unpin=this.pinnedOffset=null,this.checkPosition()};c.VERSION="3.3.1",c.RESET="affix affix-top affix-bottom",c.DEFAULTS={offset:0,target:window},c.prototype.getState=function(a,b,c,d){var e=this.$target.scrollTop(),f=this.$element.offset(),g=this.$target.height();if(null!=c&&"top"==this.affixed)return c>e?"top":!1;if("bottom"==this.affixed)return null!=c?e+this.unpin<=f.top?!1:"bottom":a-d>=e+g?!1:"bottom";var h=null==this.affixed,i=h?e:f.top,j=h?g:b;return null!=c&&c>=i?"top":null!=d&&i+j>=a-d?"bottom":!1},c.prototype.getPinnedOffset=function(){if(this.pinnedOffset)return this.pinnedOffset;this.$element.removeClass(c.RESET).addClass("affix");var a=this.$target.scrollTop(),b=this.$element.offset();return this.pinnedOffset=b.top-a},c.prototype.checkPositionWithEventLoop=function(){setTimeout(a.proxy(this.checkPosition,this),1)},c.prototype.checkPosition=function(){if(this.$element.is(":visible")){var b=this.$element.height(),d=this.options.offset,e=d.top,f=d.bottom,g=a("body").height();"object"!=typeof d&&(f=e=d),"function"==typeof e&&(e=d.top(this.$element)),"function"==typeof f&&(f=d.bottom(this.$element));var h=this.getState(g,b,e,f);if(this.affixed!=h){null!=this.unpin&&this.$element.css("top","");var i="affix"+(h?"-"+h:""),j=a.Event(i+".bs.affix");if(this.$element.trigger(j),j.isDefaultPrevented())return;this.affixed=h,this.unpin="bottom"==h?this.getPinnedOffset():null,this.$element.removeClass(c.RESET).addClass(i).trigger(i.replace("affix","affixed")+".bs.affix")}"bottom"==h&&this.$element.offset({top:g-b-f})}};var d=a.fn.affix;a.fn.affix=b,a.fn.affix.Constructor=c,a.fn.affix.noConflict=function(){return a.fn.affix=d,this},a(window).on("load",function(){a('[data-spy="affix"]').each(function(){var c=a(this),d=c.data();d.offset=d.offset||{},null!=d.offsetBottom&&(d.offset.bottom=d.offsetBottom),null!=d.offsetTop&&(d.offset.top=d.offsetTop),b.call(c,d)})})}(jQuery);


