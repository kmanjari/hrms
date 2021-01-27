'use strict';
//  Author: ThemeREX.com
//  user-forms-file-notifications.html scripts
//

(function ($) {

    $(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo
        Demo.init();

        // Stack directions/positions array
        var Stacks = {
            stack_top_right: {
                "dir1": "down",
                "dir2": "left",
                "push": "top",
                "spacing1": 10,
                "spacing2": 10
            },
            stack_top_left: {
                "dir1": "down",
                "dir2": "right",
                "push": "top",
                "spacing1": 10,
                "spacing2": 10
            },
            stack_bottom_left: {
                "dir1": "right",
                "dir2": "up",
                "push": "top",
                "spacing1": 10,
                "spacing2": 10
            },
            stack_bottom_right: {
                "dir1": "left",
                "dir2": "up",
                "push": "top",
                "spacing1": 10,
                "spacing2": 10
            },
            stack_bar_top: {
                "dir1": "down",
                "dir2": "right",
                "push": "top",
                "spacing1": 0,
                "spacing2": 0
            },
            stack_bar_bottom: {
                "dir1": "up",
                "dir2": "right",
                "spacing1": 0,
                "spacing2": 0
            },
            stack_context: {
                "dir1": "down",
                "dir2": "left",
                "context": $("#stack-context")
            }
        };

        // Init PNotify
        $('.notification').on('click', function (e) {
            var noteStyle = $(this).data('note-style');
            var noteShadow = $(this).data('note-shadow');
            var noteOpacity = $(this).data('note-opacity');
            var noteStack = $(this).data('note-stack');
            var width = "290px";

            // Define var if not defined yet
            noteStack = noteStack ? noteStack : "stack_top_right";
            noteOpacity = noteOpacity ? noteOpacity : "1";

            // Change width if fullwidth on
            function findWidth() {
                if (noteStack == "stack_bar_top") {
                    return "100%";
                }
                if (noteStack == "stack_bar_bottom") {
                    return "70%";
                } else {
                    return "290px";
                }
            }

            // Create new Notification
            new PNotify({
                title: 'My Notification!',
                text: 'My notification text.',
                shadow: noteShadow,
                opacity: noteOpacity,
                addclass: noteStack,
                type: noteStyle,
                stack: Stacks[noteStack],
                width: findWidth(),
                delay: 1400
            });

        });
    });

})(jQuery);
