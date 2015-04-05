(function() {
  if ($ === void 0 || $ === 'undefined') {
    jQuery.noConflict();
  }

  jQuery(document).ready(function($) {
    var CEMSAjaxCall;
    CEMSAjaxCall = function(action, form) {
      var formId, i, submitBtn, waiting_message;
      formId = eval($(form).attr('id'));
      submitBtn = $(form).find('[type="submit"]');
      waiting_message = '';
      if (formId !== void 0 && formId.length > 0) {
        i = 0;
        while (i < formId.length) {
          if (formId[i].custom_key === 'waiting_message') {
            waiting_message = formId[i].custom_msg;
            break;
          }
          i++;
        }
      }
      if (waiting_message.trim().length <= 0) {
        waiting_message = "Wait...";
      }
      submitBtn.attr('data-old-text', submitBtn.val()).val(waiting_message).attr('disabled', 'disabled');
      return $.post(wpdk_i18n.ajaxURL, 'action=' + action + '&' + $(form).serialize(), function(result) {
        var response, textResponse;
        response = new WPDKAjaxResponse(result);
        textResponse = '';
        if (empty(response.error)) {
          if (formId !== void 0 && formId.length > 0) {
            i = 0;
            while (i < formId.length) {
              if (formId[i].custom_key === 'subscription_success') {
                textResponse = formId[i].custom_msg;
                break;
              }
              i++;
            }
          }
          if (textResponse.trim().length <= 0) {
            if (response.message.length > 0) {
              textResponse = response.message;
            } else {
              textResponse = '<p class="success-msg">Subscription successful!.</p>';
            }
          }
          $(form).trigger("reset");
        } else {
          textResponse = response.error;
        }
        $('#wp-cems-kit-alert-box .modal-body').html('<p class="result-message">' + textResponse + '</p>');
        return $('#wp-cems-kit-alert-box').modal('show');
      }).fail(function() {
        $('#wp-cems-kit-alert-box .modal-body').html('<p class="result-message">An error has occurred, please try again or contact to administrator.</p>');
        return $('#wp-cems-kit-alert-box').modal('show');
      }).always(function() {
        return submitBtn.val(submitBtn.attr('data-old-text')).removeAttr('data-old-text').removeAttr('disabled');
      });
    };

    /*
    ==========================================
     */
    return $('.subscriber-form form').submit(function(event) {
      var result_validation;
      result_validation = $(this).trigger("subscriber.callbackValidation").data('result_validation');
      if (result_validation === true || result_validation === void 0) {
        CEMSAjaxCall('new_subscription_action', this);
      }
      return event.preventDefault();
    });
  });

}).call(this);
