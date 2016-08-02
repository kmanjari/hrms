/**
 * Created by Kanak on 2/8/16.
 */

'use strict';
//  Author: ThemeREX.com
//  forms-wizard.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Form Wizard
        var form = $("#custom-form-wizard");
        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            rules: {
                confirm: {
                    equalTo: "#password"
                }
            }
        });
        form.children(".wizard").steps({
            headerTag: ".wizard-section-title",
            bodyTag: ".wizard-section",
            onStepChanging: function(event, currentIndex, newIndex) {
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                event.preventDefault();
                var emp_name = $('#emp_name').val();
                var emp_code = $('#emp_code').val();
                var emp_status = $('#emp_status').val();
                var role = $('#role').val();
                var gender = $('#gender').val();
                var datepicker1 = $('#datepicker1').val();
                var datepicker2 = $('#datepicker2').val();
                var mobile_phone = $('#mobile_phone').val();
                var qualification = $('#qualification').val();
                var emergency_number = $('#emergency_number').val();
                var pan_number = $('#pan_number').val();
                var father_name = $('#father_name').val();
                var address = $('#address').val();
                var permanent_address = $('#permanent_address').val();
                var formalities = $('#formalities').val();
                var offer_acceptance = $('#offer_acceptance').val();
                var probation_period = $('#probation_period').val();
                var datepicker3 = $('#datepicker3').val();
                var department = $('#department').val();
                var salary = $('#salary').val();
                var bank_account_number = $('#bank_account_number').val();
                var bank_name = $('#bank_name').val();
                var ifsc_code = $('#ifsc_code').val();
                var pf_account_number = $('#pf_account_number').val();
                var pf_status = $('#pf_status').val();
                var datepicker4 = $('#datepicker4').val();
                var notice_period = $('#notice_period').val();
                var datepicker5 = $('#datepicker5').val();
                var full_final = $('#full_final').val();
                var token = $('#token').val();

                var photo = document.getElementById('photo_upload');
                var formData = new FormData();

                formData.append('photo', photo.files[0], photo.value);
                formData.append('emp_name', emp_name);
                formData.append('emp_code', emp_code);
                formData.append('emp_status', emp_status);
                formData.append('role', role);
                formData.append('gender', gender);
                formData.append('dob', datepicker1);
                formData.append('doj', datepicker2);
                formData.append('mob_number', mobile_phone);
                formData.append('qualification', qualification);
                formData.append('emer_number', emergency_number);
                formData.append('pan_number', pan_number);
                formData.append('address', address);
                formData.append('permanent_address', permanent_address);
                formData.append('formalities', formalities);
                formData.append('offer_acceptance', offer_acceptance);
                formData.append('prob_period', probation_period);
                formData.append('doc', datepicker3);
                formData.append('department', department);
                formData.append('salary', salary);
                formData.append('account_number', bank_account_number);
                formData.append('bank_name', bank_name);
                formData.append('ifsc_code', ifsc_code);
                formData.append('pf_account_number', pf_account_number);
                formData.append('pf_status', pf_status);
                formData.append('dor', datepicker4);
                formData.append('notice_period', notice_period);
                formData.append('last_working_day', datepicker5);
                formData.append('full_final', full_final);

                $.ajax({
                        type: 'POST',
                        url: '/add-employee',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            var parsed = JSON.parse(data);
                            //var html = 'title '+parsed.title+' desc '+parsed.story+ ' photo '+parsed.photo;
                            var html = '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-info-sign"></i><strong>Your blog titled ' + parsed.title + ' has been published successully you can view it <a href="/blog/' + parsed.id + '/' + parsed.slug + '.html">here</a>.  Want to write more blogs? Click <a href="/writeblog">here</a></strong></div>';
                            console.log(html);
                            $('#extraComments').append(html);
                            $('#newform').hide();
                        }
                });

                /*$.post('/add-employee', {
                    'emp_code' : emp_code,
                    'emp_name' : emp_name,
                    'emp_something' : emp_something
                }, function(data)
                {
                    var parsed = JSON.parse(data);

                    if(parsed == 'success')
                    {
                        //do something
                    }
                    else
                    {
                        //do something else
                    }
                });*/
            }
        });

        // Init Wizard
        var formWizard = $('.wizard');
        var formSteps = formWizard.find('.steps');

        $('.wizard-options .holder-style').on('click', function(e) {
            e.preventDefault();

            var stepStyle = $(this).data('steps-style');

            var stepRight = $('.holder-style[data-steps-style="steps-right"]');
            var stepLeft = $('.holder-style[data-steps-style="steps-left"]');
            var stepJustified = $('.holder-style[data-steps-style="steps-justified"]');

            if (stepStyle === "steps-left") {
                stepRight.removeClass('holder-active');
                stepJustified.removeClass('holder-active');
                formWizard.removeClass('steps-right steps-justified');
            }
            if (stepStyle === "steps-right") {
                stepLeft.removeClass('holder-active');
                stepJustified.removeClass('holder-active');
                formWizard.removeClass('steps-left steps-justified');
            }
            if (stepStyle === "steps-justified") {
                stepLeft.removeClass('holder-active');
                stepRight.removeClass('holder-active');
                formWizard.removeClass('steps-left steps-right');
            }

            if ($(this).hasClass('holder-active')) {
                formWizard.removeClass(stepStyle);
            } else {
                formWizard.addClass(stepStyle);
            }

            $(this).toggleClass('holder-active');
        });
    });

})(jQuery);
