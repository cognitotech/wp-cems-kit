if ($ == undefined || $ == 'undefined')
    jQuery.noConflict(); # change to use $ replacement for jQuery

#

jQuery(document).ready(($) ->
    #register function CEMS
    CEMSAjaxCall = (action, form) ->
        formId = eval($(form).attr('id')) # Get form id
        submitBtn = $(form).find('[type="submit"]') # disable and change submit button to waiting
        
        waiting_message = ''
        if formId != undefined && formId.length > 0
            # Find and replace waiting_message
            i = 0
            while i < formId.length
                if formId[i].custom_key == 'waiting_message'
                    waiting_message = formId[i].custom_msg
                    break
                i++
            
        #re-check waiting message
        if (waiting_message.trim().length <= 0)
            waiting_message = "Wait..."
        
        #Change text
        submitBtn.attr('data-old-text',submitBtn.val()).val(waiting_message).attr('disabled','disabled')
        
            
            
        # send post request
        $.post(wpdk_i18n.ajaxURL, 'action=' + action + '&' + $(form).serialize(), (result) ->
            response = new WPDKAjaxResponse(result)
            textResponse = ''
            if empty(response.error)
                # OK
                if formId != undefined && formId.length > 0
                    i = 0
                    while i < formId.length
                        if formId[i].custom_key == 'subscription_success'
                            textResponse = formId[i].custom_msg
                            break
                        i++

                #re-check waiting message
                if (textResponse.trim().length <= 0)
                    if (response.message.length > 0)
                        textResponse = response.message
                    else
                        textResponse = '<p class="success-msg">Subscription successful!.</p>';
                
                #reset form
                $(form).trigger("reset");
            else
                textResponse = response.error
            
            # append message to form
            $('#wp-cems-kit-alert-box .modal-body').html('<p class="result-message">' + textResponse + '</p>')
            $('#wp-cems-kit-alert-box').modal('show')
        ).fail(() ->
            # Warning or send error if fail
            $('#wp-cems-kit-alert-box .modal-body').html('<p class="result-message">An error has occurred, please try again or contact to administrator.</p>')
            $('#wp-cems-kit-alert-box').modal('show')
        ).always(() ->
            # if done
            # re-enable and restore submit button text
            submitBtn.val(submitBtn.attr('data-old-text')).removeAttr('data-old-text').removeAttr('disabled')
        )

    ###
    ==========================================
    ###

    #register event for subscription form
    $('.subscriber-form form').submit (event) ->
        #raise event validation and get boolen
        result_validation = $(this).trigger( "subscriber.callbackValidation" ).data('result_validation') #get return value
        if ( result_validation == true || result_validation == undefined )
            CEMSAjaxCall('new_subscription_action', this) # call ajax register
        event.preventDefault() # disable reload page
)