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
                var gender = $('#gender:checked').val();
                var datepicker1 = $('#datepicker1').val();
                var datepicker4 = $('#datepicker4').val();
                var mobile_phone = $('#mobile_phone').val();
                var qualification = $('.qualification_select').val();
                if(qualification == 'Other')
                {
                    qualification = $('.qualification_text').val();
                    console.log('my qualification' +qualification);
                }
                console.log('gender '+ gender);
                var emergency_number = $('#emergency_number').val();
                var pan_number = $('#pan_number').val();
                var father_name = $('#father_name').val();
                var address = $('#address').val();
                var permanent_address = $('#permanent_address').val();
                var formalities = $('#formalities').val();
                var offer_acceptance = $('#offer_acceptance').val();
                var probation_period = $('#probation_period').val();
                if(probation_period == 'Other')
                {
                    probation_period = $('.probation_text').val();
                }
                var datepicker5 = $('#datepicker5').val();
                var department = $('#department').val();
                var salary = $('#salary').val();
                var bank_account_number = $('#bank_account_number').val();
                var bank_name = $('#bank_name').val();
                var ifsc_code = $('#ifsc_code').val();
                var pf_account_number = $('#pf_account_number').val();
                var un_number = $('#un_number').val();
                var pf_status = $('#pf_status').val();
                var datepicker6 = $('#datepicker6').val();
                var notice_period = $('#notice_period').val();
                var datepicker7 = $('#datepicker7').val();
                var full_final = $('#full_final').val();
                var token = $('#token').val();

                var photo = document.getElementById('photo_upload');
                var formData = new FormData();

                if(photo.value != '') {
                    formData.append('photo', photo.files[0], photo.value);
                }
                formData.append('emp_name', emp_name);
                formData.append('emp_code', emp_code);
                formData.append('emp_status', emp_status);
                formData.append('role', role);
                formData.append('gender', gender);
                formData.append('date_of_birth', datepicker1);
                formData.append('date_of_joining', datepicker4);
                formData.append('number', mobile_phone);
                formData.append('qualification', qualification);
                formData.append('emergency_number', emergency_number);
                formData.append('pan_number', pan_number);
                formData.append('current_address', address);
                formData.append('permanent_address', permanent_address);
                formData.append('formalities', formalities);
                formData.append('offer_acceptance', offer_acceptance);
                formData.append('probation_period', probation_period);
                formData.append('date_of_confirmation', datepicker5);
                formData.append('father_name', father_name);
                formData.append('department', department);
                formData.append('salary', salary);
                formData.append('account_number', bank_account_number);
                formData.append('bank_name', bank_name);
                formData.append('ifsc_code', ifsc_code);
                formData.append('pf_account_number', pf_account_number);
                formData.append('un_number', un_number);
                formData.append('pf_status', pf_status);
                formData.append('date_of_resignation', datepicker6);
                formData.append('notice_period', notice_period);
                formData.append('last_working_day', datepicker7);
                formData.append('full_final', full_final);
                formData.append('_token', token);


                var url = $('#url').val();
                $.ajax({
                        type: 'POST',
                        url: '/'+ url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            var parsed = JSON.parse(data);
                            $('#modal-header').attr('class', 'modal-header '+parsed.class);
                            $('.modal-title').append(parsed.title);
                            $('.modal-body').append(parsed.message);
                            $('#notification-modal').modal('show');
                        }
                });

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
