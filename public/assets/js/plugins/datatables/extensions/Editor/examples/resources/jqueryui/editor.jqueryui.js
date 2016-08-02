(function () {

    var Editor = $.fn.dataTable.Editor;

    Editor.defaults.display = "jqueryui";

    Editor.display.jqueryui = $.extend(true, {}, Editor.models.displayController, {
        "init": function (dte) {
            dte.__dialouge = $('<div></div>')
                .css('display', 'none')
                .appendTo('body')
                .dialog($.extend(true, Editor.display.jqueryui.modalOptions, {
                    autoOpen: false,
                    buttons: {
                        "A": function () {
                        }
                    } // fake button so the button container is created
                }));

            // Need to know when the dialogue is closed using its own trigger
            // so we can reset the form
            $(dte.__dialouge).on('dialogclose', function (e) {
                dte.close('icon');
            });

            $(dte.dom.formError).appendTo(
                dte.__dialouge.parent().find('div.ui-dialog-buttonpane')
            );

            return Editor.display.jqueryui;
        },

        "open": function (dte, append, callback) {
            dte.__dialouge
                .append(append)
                .dialog('open');

            dte.__dialouge.parent().find('.ui-dialog-title').html(dte.dom.header.innerHTML);

            // Modify the Editor buttons to be jQuery UI suitable
            var buttons = $(dte.dom.buttons)
                .children()
                .addClass('ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')
                .each(function () {
                    $(this).wrapInner('<span class="ui-button-text" />');
                });

            // Move the buttons into the jQuery UI button set
            dte.__dialouge.parent().find('div.ui-dialog-buttonset')
                .empty()
                .append(buttons);

            if (callback) {
                callback();
            }
        },

        "close": function (dte, callback) {
            if (dte.__dialouge) {
                dte.__dialouge.dialog('close');
            }

            if (callback) {
                callback();
            }
        }
    });

    Editor.display.jqueryui.modalOptions = {
        width: 600,
        modal: true
    };

})();
