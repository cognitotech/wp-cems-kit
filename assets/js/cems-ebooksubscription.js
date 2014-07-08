jQuery(document).ready(function($) {
// Sending something...

    function CEMSAjaxResponseHandler ( data ) {
        // Catch response
        var response = new WPDKAjaxResponse( data );

        // OK
        if ( empty( response.error ) ) {
            console.log( response );
        }
        // Error
        else {
            alert( response.error );
        }
    }

    function CEMSAjaxCall(button,cems_action,data,callback)
    {
        $(button).click(function(){
            $.post( wpdk_i18n.ajaxURL,
                {
                    action  : cems_action,
                    param   : data
                },
                function (result){
                    callback(result);
                }
            );
        });
    }

    $('.customer-register-new').click(function(){
        CEMSAjaxCall(this,'register_new_customer_ajax_action',$('.customer-register-form').data,CEMSAjaxResponseHandler);
    });
    $('.customer-subscription').click(function() {
        var submit_data={
            'email':$('.cems-plugin-customer-email').val(),
            'list-id':$('.cems-plugin-list-id').val()
        };
        CEMSAjaxCall(this,'get_book_for_already_customer_ajax_action',submit_data,CEMSAjaxResponseHandler);
    });
});