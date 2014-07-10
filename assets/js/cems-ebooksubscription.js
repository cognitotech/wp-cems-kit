jQuery.noConflict();
(function($) {
    //bootstrap fix noConflict with jquery-ui
    var bootstrapButton = $.fn.button.noConflict(); // return $.fn.button to previously assigned value
    $.fn.bootstrapBtn = bootstrapButton;            // give $().bootstrapBtn the Bootstrap functionality
})(jQuery);

jQuery(document).ready(function ($) {

    $(".chosen-select").chosen({width: "100%"});
    // Sending something...
    function CEMSAjaxCall(submitBtn, cems_action, form) {
        submitBtn.bootstrapBtn('loading');
        $.post(wpdk_i18n.ajaxURL,
            "action="+cems_action+"&"+$(form).serialize(),
            function (result) {
                var response = new WPDKAjaxResponse(result);
                var $alert=$('#cems-alert');
                $alert.empty();

                var textResponse='';
                if (empty(response.error)) {
                    // OK
                    textResponse=response.message;
                }
                // Error
                else {
                    if ($(form).attr('name')=== 'subscription-form' )
                    {
                        $('#collapseCustomerForm').collapse('show');
                    }
                    textResponse=response.error;
                }
                $alert.append('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Đóng</span></button>'+textResponse+'</div>');
            }
        ).always(function(){
            submitBtn.bootstrapBtn('reset');
        });
    }

    $("#subscription-form").bootstrapValidator({
        message:"Giá trị không hợp lệ",
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {
            CEMSAjaxCall(submitButton, 'get_book_for_already_customer_action', form);
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
    $("#customer-form").bootstrapValidator({
        message:"Giá trị không hợp lệ",
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {
            CEMSAjaxCall(submitButton, 'register_new_customer_action', form);
        },
        fields: {
            customerName: {
                validators: {
                    notEmpty:{
                        message:'Họ và tên không được để trống'
                    }
                }
            },
            customerEmail: {
                validators: {
                    emailAddress: {
                        message:'Địa chỉ email không hợp lệ'
                    },
                    notEmpty: {
                        message:'Email không được để trống'
                    }
                }
            },
            customerPhone: {
                validators: {
                    notEmpty:{
                        message:'Số điện thoại không được để trống'
                    }
                }
            }
        }
    });
});