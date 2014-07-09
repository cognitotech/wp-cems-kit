jQuery.noConflict();
(function($) {
    //bootstrap fix noConflict with jquery-ui
    var bootstrapButton = $.fn.button.noConflict(); // return $.fn.button to previously assigned value
    $.fn.bootstrapBtn = bootstrapButton;            // give $().bootstrapBtn the Bootstrap functionality
})(jQuery);

jQuery(document).ready(function ($) {
// Sending something...

    function CEMSAjaxCall(submitBtn, cems_action, form) {
        submitBtn.bootstrapBtn('loading');
        $.post(wpdk_i18n.ajaxURL,
            {
                action: cems_action,
                param: $(form).serialize()
            },
            function (result) {
                var response = new WPDKAjaxResponse(result);
                var $result_form=$(form);
                // OK
                if (empty(response.error)) {
                    $result_form.parent('.panel-body').empty().append('<div class="alert alert-success" role="alert">'+response.message+'</div>');
                }
                // Error
                else {
                    if ($result_form.attr('name')=== 'subscription-form' )
                    {
                        $('#ebook-subscription #collapseCustomerForm').collapse('show').children('form').prepend('<div class="alert alert-danger" role="alert">'+response.error+'</div>');
                    }
                    else
                        $result_form.append('<div class="alert alert-danger" role="alert">'+response.error+'</div>');
                }
            }
        ).always(function(){
            submitBtn.bootstrapBtn('reset');
        });
    }

    $('#btn-new-customer-submit').click(function () {
        CEMSAjaxCall(this, 'register_new_customer_ajax_action', $('#customer-register-form').serialize());
    });
    $("#subscription-form").bootstrapValidator({
        message:"Giá trị không hợp lệ",
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {
            CEMSAjaxCall(submitButton, 'get_book_for_already_customer_ajax_action', form);
        },
        fields: {
            subscriptionEmail: {
                validators: {
                    emailAddress: {
                        message:'Địa chỉ email không hợp lệ'
                    },
                    notEmpty: {
                        message:'Email không được để trống'
                    }
                }
            }
        }
    });
    $("#customer-form").bootstrapValidator();
});