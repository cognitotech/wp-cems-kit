jQuery.noConflict()
(($) ->

  #bootstrap fix noConflict with jquery-ui
  bootstrapButton = $.fn.button.noConflict() # return $.fn.button to previously assigned value
  $.fn.bootstrapBtn = bootstrapButton # give $().bootstrapBtn the Bootstrap functionality
  datepicker = $.fn.datepicker.noConflict() # return $.fn.datepicker to previously assigned value
  $.fn.bootstrapDP = datepicker

  return
) jQuery
jQuery(document).ready ($) ->

  # Sending something...
  CEMSAjaxCall = (submitBtn, cems_action, form) ->
    submitBtn.bootstrapBtn "loading"
    $alert = $("#cems-alert")
    $alert.fadeOut "slow"

    # OK

    # Error
    $.post(wpdk_i18n.ajaxURL, "action=" + cems_action + "&" + $(form).serialize(), (result) ->
      response = new WPDKAjaxResponse(result)
      textResponse = ""
      if empty(response.error)
        textResponse = response.message + "<br>" + response.data
        $alert.removeClass("alert-danger").addClass "alert-success"
      else
        textResponse = response.error
        $alert.removeClass("alert-success").addClass "alert-danger"
      $alert.children(".error-response").html textResponse
      $alert.fadeIn "slow"
      return
    ).always ->
      submitBtn.bootstrapBtn "reset"
      return

    return

  $("#event17-form").bootstrapValidator
    message: "Giá trị không hợp lệ"

    submitHandler: (validator, form, submitButton) ->
      CEMSAjaxCall submitButton, "register_new_event_action", form
      return

  return
