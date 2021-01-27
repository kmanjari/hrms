'use strict';
/*
 * http://themerex.com/
 * Copyright (c) 2015 ThemeREX;
*/

/*
 * Demo theme functions.
 * Required for Settings Pane and
 * misc functions
*/
var Demo = function() {

  // Demo AllCPForm Functions
  var runDemoForms = function() {

    // Prevents directory response when submitting a demo form
    $('.allcp-form').on('submit', function(e) {

      if ($('body.basic-timeline').length || $('body.forms-validation').length) {
        return;
      }
      /*e.preventDefault;
      alert('Your form has submitted!');
      return false;*/
    });

    // give file-upload preview onclick functionality
    var fileUpload = $('.fileupload-preview');
    if (fileUpload.length) {

      fileUpload.each(function(i, e) {
        var fileForm = $(e).parents('.fileupload').find('.btn-file > input');
        $(e).on('click', function() {
          fileForm.click();
        });
      });
    }

  }

  // Demo Header Functions
  var runDemoTopbar = function() {

    // Init jQuery Multi-Select
    if ($("#topbar-multiple").length) {
      $('#topbar-multiple').multiselect({
        buttonClass: 'btn btn-default btn-bordered ph15',
        dropRight: true
      });
    }

  }

  // Demo AllCPForm Functions
  var runDemoSourceCode = function() {

    var bsElement = $(".bs-component");

    if (bsElement.length) {

      // allow caching of demo resources
      $.ajaxSetup({
        cache: true
      });

      $("<link/>", {
        rel: "stylesheet",
        type: "text/css",
        href: window.location.protocol + '//' + window.location.hostname + '/assets/js/plugins/highlight/styles/github.css'
      }).appendTo("head");

      $.getScript(window.location.protocol + '//' + window.location.hostname + '/assets/js/plugins/highlight/highlight.pack.js');

      // Define Source code modal
      var modalSource = '<div class="modal fade" id="source-modal" tabindex="-1" role="dialog">  ' +
        '<div class="modal-dialog modal-lg"> ' +
        '<div class="modal-content"> ' +
        '<div class="modal-header"> ' +
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' +
        '<h4 class="modal-title" id="myModalLabel">Source Code HTML</h4> ' +
        '</div> ' +
        '<div class="modal-body"> ' +
        '<div class="highlight"> ' +
        '<pre> ' +
        '<code class="language-html" data-lang="html"></code> ' +
        '</pre> ' +
        '</div> </div> ' +
        '<div class="modal-footer"> ' +
        '<button type="button" class="btn btn-primary btn-clipboard">Highlight Source</button> ' +
        '</div> </div> </div> </div> </div>';


      // Append modal to body
      $(modalSource).appendTo('body');

      // Code btn definition
      var codeBtn = $("<div id='source-button' class='btn btn-system btn-xs'>&lt; &gt;</div>")
      codeBtn.click(function() {
        var html = $(this).parent().html();
        html = cleanSource(html);
        $("#source-modal pre").text(html);
        $("#source-modal").modal();

        // Init Highlight.js plugin after delay
        var source = $("#source-modal").find('pre');
        setTimeout(function() {
          source.each(function(i, block) {
            hljs.highlightBlock(block);
          });
        }, 250);

        // Highlight code text on click     
        $('.btn-clipboard').on('click', function() {
          var selection = $(this).parents('.modal-dialog').find('pre');
          selection.selectText();
        });

        $(document).keypress(function(e) {
          if (e.which == 99) {
            console.log('go')
              // highlight source code if user preses "c" key
            $('.btn-clipboard').click();
          }
        });

      });

      // Show code btn on hover
      bsElement.hover(function() {
        $(this).append(codeBtn);
        codeBtn.show();
      }, function() {
        codeBtn.hide();
      });

      // Show code modal on click
      var cleanSource = function(html) {
        var lines = html.split(/\n/);

        lines.shift();
        lines.splice(-1, 1);

        var indentSize = lines[0].length - lines[0].trim().length,
          re = new RegExp(" {" + indentSize + "}");

        lines = lines.map(function(line) {
          if (line.match(re)) {
            line = line.substring(indentSize);
          }
          return line;
        });

        lines = lines.join("\n");
        return lines;
      }

      // Helper function to highlight code text
      jQuery.fn.selectText = function() {
        var doc = document,
          element = this[0],
          range, selection;
        if (doc.body.createTextRange) {
          range = document.body.createTextRange();
          range.moveToElementText(element);
          range.select();
        } else if (window.getSelection) {
          selection = window.getSelection();
          range = document.createRange();
          range.selectNodeContents(element);
          selection.removeAllRanges();
          selection.addRange(range);
        }
      };

    }

  }

  // DEMO FUNCTIONS - primarily trash
  var runDemoSettings = function() {

    if ($('#customizer').length) {

      // Toggles Theme Settings Chute
      $('#customizer .panel-heading').on('click', function() {
        $('#customizer').toggleClass('customizer-open');
      });
      // Disable text selection
      $('#customizer .panel-heading').disableSelection();

      // Cache component elements
      var Body = $('body');
      var Breadcrumbs = $('#topbar');
      var Sidebar = $('#sidebar_left');
      var Footer = $('#content-footer');
      var Header = $('.navbar');
      var HeaderLogo = Header.children('.navbar-logo-wrapper');

      // Possible Component Skins
      var headerSkins = "bg-primary bg-success bg-info bg-warning bg-danger bg-alert bg-system bg-dark";
      var sidebarSkins = "sidebar-light light dark";
      var footerSkins = "footer-light";

      // Theme Settings
      var settingsObj = {
        // 'headerTone': true,
        'headerSkin': '',
        'footerSkin': '',
        'sidebarSkin': 'sidebar-default',
        'headerState': 'navbar-fixed-top',
        'sidebarState': 'affix',
        'sidebarAlign': '',
        'breadcrumbState': 'relative',
        'breadcrumbHidden': 'visible'
      };

      // Local Storage Theme Key
      var themeKey = 'allcp-settings1';

      // Local Storage Theme Get
      var themeGet = localStorage.getItem(themeKey);

      // Set new key if one doesn't exist
      if (themeGet === null) {
        localStorage.setItem(themeKey, JSON.stringify(settingsObj));
        themeGet = localStorage.getItem(themeKey);
      }

      // Restore Theme Settings onload from Local Storage Key
      (function() {

        var settingsParse = JSON.parse(themeGet);
        settingsObj = settingsParse;

        $.each(settingsParse, function(i, e) {
          switch (i) {
            case 'headerSkin':
              Header.removeClass(headerSkins).addClass(e);
              if (e === '') Header.removeClass(headerSkins).addClass(e + 'bg-dark');
              HeaderLogo.removeClass(headerSkins).addClass(e + ' dark');
              if (e === "bgc-light") {
                HeaderLogo.removeClass(headerSkins);
              } else {
                HeaderLogo.removeClass(headerSkins).addClass(e);
                if (e === '') HeaderLogo.addClass('bg-dark');
              }
              $('#customizer-header-skin input[value="bg-light"]').prop('checked', false);
              $('#customizer-header-skin input[value="' + e + '"]').prop('checked', true);
              break;
            case 'footerSkin':
              Footer.removeClass(footerSkins).addClass(e);
              $('#customizer-footer-skin input[value="bg-light"]').prop('checked', false);
              $('#customizer-footer-skin input[value="' + e + '"]').prop('checked', true);
              break;
            case 'sidebarSkin':
              Sidebar.removeClass(sidebarSkins).addClass(e);
              $('#customizer-sidebar-skin input[value="bg-light"]').prop('checked', false);
              $('#customizer-sidebar-skin input[value="' + e + '"]').prop('checked', true);
              break;
            case 'headerState':
              if (e === "navbar-fixed-top") {
                Header.addClass('navbar-fixed-top');
                $('#header-option').prop('checked', true);
              } else {
                Header.removeClass('navbar-fixed-top');
                $('#header-option').prop('checked', false);

                // Remove left over inline styles from nanoscroller plugin
                Sidebar.nanoScroller({
                  destroy: true
                });
                Sidebar.find('.nano-content').attr('style', '');
                Sidebar.removeClass('affix');
                $('#sidebar-option').prop('checked', false);
              }
              break;
            case 'sidebarState':
              if (e === "affix") {
                Sidebar.addClass('affix');
                $('#sidebar-option').prop('checked', true);
              } else {
                // Remove left over inline styles from nanoscroller plugin
                Sidebar.nanoScroller({
                  destroy: true
                });
                Sidebar.find('.nano-content').attr('style', '');
                Sidebar.removeClass('affix');
                $('#sidebar-option').prop('checked', false);
              }
              break;
            case 'sidebarAlign':
              if (e === "sb-top") {
                Body.addClass('sb-top');
                $('#sidebar-align').prop('checked', true);
              } else {
                Body.removeClass('sb-top');
                $('#sidebar-align').prop('checked', false);
              }
              break;
            case 'breadcrumbState':
              if (e === "affix") {
                Breadcrumbs.addClass('affix');
                $('#breadcrumb-option').prop('checked', true);
              } else {
                Breadcrumbs.removeClass('affix');
                $('#breadcrumb-option').prop('checked', false);
              }   
              break;
            case 'breadcrumbHidden':
              if (Breadcrumbs.hasClass('hidden')) {
                $('#breadcrumb-hidden').prop('checked', true);
              }
              else {
                if (e === "hidden") {
                  Breadcrumbs.addClass('hidden');
                  $('#breadcrumb-hidden').prop('checked', true);
                } else {
                  Breadcrumbs.removeClass('hidden');
                  $('#breadcrumb-hidden').prop('checked', false);
                }
              }
              break;
          }
        });

      })();

      // Header Skin Switcher
      $('#customizer-header-skin input').on('click', function() {
        var This = $(this);
        var Val = This.val();
        var ID = This.attr('id');

        // Swap Header Skin
        Header.removeClass(headerSkins).addClass(Val);
        HeaderLogo.removeClass(headerSkins).addClass(Val + ' dark');

        // Save new Skin to Settings Key
        settingsObj['headerSkin'] = Val;
        localStorage.setItem(themeKey, JSON.stringify(settingsObj));

        // Init jQuery Multi-Select for navbar user dropdowns
        var btnClasses = "btn-default btn-dark";
        var btnClass = "";
        if ($("header.navbar").hasClass("bg-dark")) {
          btnClass = "btn-dark";
        } else btnClass = "btn-default";
      });

      // Footer Skin Switcher
      $('#customizer-footer-skin input').on('click', function() {
        var Val = $(this).val();

        // Swap Footer Skin
        Footer.removeClass(footerSkins).addClass(Val);

        // Save new Skin to Settings Key
        settingsObj['footerSkin'] = Val;
        localStorage.setItem(themeKey, JSON.stringify(settingsObj));
      });
      // Sidebar Skin Switcher
      $('#customizer-sidebar-skin input').on('click', function() {
        var Val = $(this).val();

        // Swap Sidebar Skin
        Sidebar.removeClass(sidebarSkins).addClass(Val);

        // Save new Skin to Settings Key
        settingsObj['sidebarSkin'] = Val;
        localStorage.setItem(themeKey, JSON.stringify(settingsObj));
      });

      // Fixed Header Switcher
      $('#header-option').on('click', function() {
        var headerState = "navbar-fixed-top";

        if (Header.hasClass('navbar-fixed-top')) {
          Header.removeClass('navbar-fixed-top');
          headerState = "relative";

          // Remove Fixed Sidebar option if navbar isnt fixed
          Sidebar.removeClass('affix');

          // Remove left over inline styles from nanoscroller plugin
          Sidebar.nanoScroller({
            destroy: true
          });
          Sidebar.find('.nano-content').attr('style', '');
          Sidebar.removeClass('affix');
          $('#sidebar-option').prop('checked', false);

          $('#sidebar-option').parent('.checkbox-custom').addClass('checkbox-disabled').end().prop('checked', false).attr('disabled', true);
          settingsObj['sidebarState'] = "";
          localStorage.setItem(themeKey, JSON.stringify(settingsObj));

          // Remove Fixed Breadcrumb option if navbar isnt fixed
          Breadcrumbs.removeClass('affix');
          $('#breadcrumb-option').parent('.checkbox-custom').addClass('checkbox-disabled').end().prop('checked', false).attr('disabled', true);
          settingsObj['breadcrumbState'] = "";
          localStorage.setItem(themeKey, JSON.stringify(settingsObj));

        } else {
          Header.addClass('navbar-fixed-top');
          headerState = "navbar-fixed-top";
          // Enable fixed sidebar and breadcrumb options
          $('#sidebar-option').parent('.checkbox-custom').removeClass('checkbox-disabled').end().attr('disabled', false);
          $('#breadcrumb-option').parent('.checkbox-custom').removeClass('checkbox-disabled').end().attr('disabled', false);
        }

        // Save new setting to Settings Key
        settingsObj['headerState'] = headerState;
        localStorage.setItem(themeKey, JSON.stringify(settingsObj));
      });

      // Fixed Sidebar Switcher
      $('#sidebar-option').on('click', function() {
        var sidebarState = "";

        if (Sidebar.hasClass('affix')) {

          // Remove left over inline styles from nanoscroller plugin
          Sidebar.nanoScroller({
            destroy: true
          });
          Sidebar.find('.nano-content').attr('style', '');
          Sidebar.removeClass('affix');

          sidebarState = "";
        } else {
          Sidebar.addClass('affix');
          // If sidebar is fixed init nano scrollbar plugin

          if ($('.nano.affix').length) {
            $(".nano.affix").nanoScroller({
              preventPageScrolling: true
            });
          }
          sidebarState = "affix";

        }

        $(window).trigger('resize');

        // Save new setting to Settings Key
        settingsObj['sidebarState'] = sidebarState;
        localStorage.setItem(themeKey, JSON.stringify(settingsObj));
      });

      // Sidebar Horizontal Setting Switcher
      $('#sidebar-align').on('click', function() {

        var sidebarAlign = "";

        if (Body.hasClass('sb-top')) {
          Body.removeClass('sb-top');
          sidebarAlign = "";
        } else {
          Body.removeClass('sb-top');
          sidebarAlign = "sb-top";
        }

        // Save new setting to Settings Key
        settingsObj['sidebarAlign'] = sidebarAlign;
        localStorage.setItem(themeKey, JSON.stringify(settingsObj));
      });   

      // Fixed Breadcrumb Switcher
      $('#breadcrumb-option').on('click', function() {

        var breadcrumbState = "";

        if (Breadcrumbs.hasClass('affix')) {
          Breadcrumbs.removeClass('affix');
          breadcrumbState = "";
        } else {
          Breadcrumbs.addClass('affix');
          breadcrumbState = "affix";
        }

        // Save new setting to Settings Key
        settingsObj['breadcrumbState'] = breadcrumbState;
        localStorage.setItem(themeKey, JSON.stringify(settingsObj));
      });

      // Hidden Breadcrumb Switcher
      $('#breadcrumb-hidden').on('click', function() {
        var breadcrumbState = "";

        if (Breadcrumbs.hasClass('hidden')) {
          Breadcrumbs.removeClass('hidden');
          breadcrumbState = "";
        } else {
          Breadcrumbs.addClass('hidden');
          breadcrumbState = "hidden";
        }

        // Save new setting to Settings Key
        settingsObj['breadcrumbHidden'] = breadcrumbState;
        localStorage.setItem(themeKey, JSON.stringify(settingsObj));
      });

      // Clear local storage button and confirm dialog
      $("#clearAll").on('click', function() {

        // check for Bootbox plugin - should be in core
        if (bootbox.confirm) {
          bootbox.confirm("This will clear all your custom settings. Clear now?", function(e) {

            // e returns true if user clicks "accept"
            // false if "cancel" or dismiss icon are clicked
            if (e) {
              // Timeout simply gives the user a second for the modal to
              // fade away so they can visibly see the options reset
              setTimeout(function() {
                localStorage.clear();
                location.reload();
              }, 200);
            } else {
              return;
            }
          });

        }

      });

    }
  }

  var runFullscreenDemo = function() {

    // If browser is IE we need to pass the fullsreen plugin the 'html' selector
    // rather than the 'body' selector. Fixes a fullscreen overflow bug
    var selector = $('html');

    var ua = window.navigator.userAgent;
    var old_ie = ua.indexOf('MSIE ');
    var new_ie = ua.indexOf('Trident/');
    if ((old_ie > -1) || (new_ie > -1)) { selector = $('body'); }

    // Fullscreen Functionality
    var screenCheck = $.fullscreen.isNativelySupported();

    // Attach handler to navbar fullscreen button
    $('.navbar-fullscreen').on('click', function() {

      // Check for fullscreen browser support
      if (screenCheck) {
        if ($.fullscreen.isFullScreen()) {
          $.fullscreen.exit();
        } 
        else {
          selector.fullscreen({
            overflow: 'auto'
          });
        }
      } else {
        alert('Your browser does not support fullscreen mode.')
      }
    });

  }

  return {
    init: function() {
      runDemoForms();
      runDemoTopbar();
      runDemoSourceCode();
      runDemoSettings();
      runFullscreenDemo();
    }
  }
}();
