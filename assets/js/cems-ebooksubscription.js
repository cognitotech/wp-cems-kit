jQuery(document).ready(function ($) {
// Sending something...

    function CEMSAjaxResponseHandler(data) {
        // Catch response
        var response = new WPDKAjaxResponse(data);
        var $result_form=$('button[type=submit]').closest("form");
        // OK
        if (empty(response.error)) {
            $result_form.empty().append('<div class="alert alert-success" role="alert">'+response.message+'</div>');
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

    function CEMSAjaxCall(button, cems_action, data, callback) {
        $(button).click(function () {
            var btn = $(this);
            btn.button('loading');
            $.post(wpdk_i18n.ajaxURL,
                {
                    action: cems_action,
                    param: data
                },
                function (result) {
                    callback(result);
                }
            ).always(function(){
                    btn.button('reset');
                });
        });
    }

    $('#new-customer-submit').click(function () {
        CEMSAjaxCall(this, 'register_new_customer_ajax_action', $('#customer-register-form').data, CEMSAjaxResponseHandler);
    });
    $('#new-subscription-submit').click(function () {
        var submit_data = {
            'email': $('#subscription-email').val(),
            'list-id': $('#subscription-list-id').val()
        };
        CEMSAjaxCall(this, 'get_book_for_already_customer_ajax_action', submit_data, CEMSAjaxResponseHandler);
    });

    $("form").validate({

        showErrors: function(errorMap, errorList) {

            // Clean up any tooltips for valid elements
            $.each(this.validElements(), function (index, element) {
                var $element = $(element);

                $element.data("title", "") // Clear the title - there is no error associated anymore
                    .removeClass("error")
                    .tooltip("destroy");
            });

            // Create new tooltips for invalid elements
            $.each(errorList, function (index, error) {
                var $element = $(error.element);

                $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                    .data("title", error.message)
                    .addClass("error")
                    .tooltip(); // Create a new tooltip based on the error message we just set in the title
            });
        }
        /*,

        submitHandler: function(form) {
            alert("This is a valid form!");
        }*/
    });
});