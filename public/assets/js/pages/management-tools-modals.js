'use strict';
//  Author: ThemeREX.com
//  management-tools-modal.html scripts
//

(function ($) {

    $(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        var modalContent = $('#modal-content');

        modalContent.on('click', '.holder-style', function (e) {
            e.preventDefault();

            modalContent.find('.holder-style').removeClass('holder-active');
            $(this).addClass('holder-active');
        });

        function findActive() {
            var activeModal = modalContent.find('.holder-active').attr('href');
            return activeModal;
        }

        // Skin Switcher
        $('#animation-switcher button').on('click', function () {
            $('#animation-switcher').find('button').removeClass('active-animation');
            $(this).addClass('active-animation item-checked');

            $.magnificPopup.open({
                removalDelay: 500,
                items: {
                    src: findActive()
                },
                callbacks: {
                    beforeOpen: function (e) {
                        var Animation = $("#animation-switcher").find('.active-animation').attr('data-effect');
                        this.st.mainClass = Animation;
                    }
                },
                midClick: true
            });

        });
    });

})(jQuery);
