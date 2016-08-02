'use strict';
//  Author: ThemeREX.com
//  user-forms-file-uploaders.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Set Dropzone options
        Dropzone.options.dropZone = {
            paramName: "file", // File transfer name
            maxFilesize: 0, // MB

            addRemoveLinks: true,
            dictDefaultMessage: '<i class="fa fa-cloud-upload"></i> \
         <span class="main-text"><b>Drop Files</b> to upload</span> <br /> \
         <span class="sub-text">(or click)</span> \
        ',
            dictResponseError: 'Server not Configured'
        };

        Dropzone.options.dropZone2 = {
            paramName: "file", // File transfer name
            maxFilesize: 0, // MB

            addRemoveLinks: true,
            dictDefaultMessage: '<i class="fa fa-cloud-upload"></i> \
         <span class="main-text"><b>Drop Files</b> to upload</span> <br /> \
         <span class="sub-text">(or click)</span> \
        ',
            dictResponseError: 'Server not Configured'
        };

        // Uploads demo on pageload
        setTimeout(function () {
            var Drop = $('#dropZone2');
            Drop.addClass('dz-started dz-demo');

            setTimeout(function () {
                $('.example-preview').each(function (i, e) {
                    var This = $(e);

                    var thumbOut = setTimeout(function () {
                        Drop.append(This);
                        This.addClass('animated fadeInRight').removeClass('hidden');
                    }, i * 135);

                });
            }, 750);

        }, 800);

        // Demo code
        $('.example-preview').on('click', 'a.dz-remove', function () {
            $(this).parent('.example-preview').remove();
        });
    });

})(jQuery);
