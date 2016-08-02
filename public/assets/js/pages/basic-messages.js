'use strict';
//  Author: ThemeREX.com
//  basic-messages.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        var msgListing = $('#message-table > tbody > tr > td');
        var msgCheckbox = $('#message-table > tbody > tr input[type=checkbox]');

        // Toggle ".highlight" on click
        msgCheckbox.on('click', function() {
            $(this).parents('tr').toggleClass('highlight');
        });

        // Table row checkbox click
        msgListing.not(":first-child").on('click', function(e) {

            // Stop event if is not a checkbox
            e.stopPropagation();
            e.preventDefault();

            // Redirect to basic-messages-single.html if not checkbox
            window.location = "basic-messages-single.html";
        });

        // Display quick compose on click
        $('#quick-compose').on('click', function() {

            // AllCP Dock Plugin
            $('.quick-compose-form').dockmodal({
                minimizedWidth: 260,
                width: 470,
                height: 480,
                title: 'Compose Message',
                initialState: "docked",
                buttons: [{
                    html: "Send",
                    buttonClass: "btn btn-primary btn-sm",
                    click: function(e, dialog) {
                        dialog.dockmodal("close");

                        // Notification message
                        setTimeout(function() {
                            msgCallback();
                        }, 500);
                    }
                }]
            });
        });

        // Success email compose notification
        function msgCallback() {
            (new PNotify({
                title: 'Message Success!',
                text: 'Your message has been <b>Sent.</b>',
                hide: false,
                type: 'success',
                addclass: "mt50",
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                }
            }));
        }

        // Init Summernote
        $('.summernote-quick').summernote({
            height: 275,
            focus: false,
            toolbar: [
                ['style', ['bold', 'italic', 'underline' ]],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    });

})(jQuery);
