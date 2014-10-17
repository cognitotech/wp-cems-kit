jQuery.noConflict()
(($) ->

  #bootstrap fix noConflict with jquery-ui
  bootstrapButton = $.fn.button.noConflict() # return $.fn.button to previously assigned value
  $.fn.bootstrapBtn = bootstrapButton # give $().bootstrapBtn the Bootstrap functionality

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

  #form validation
  $("#event17-form").bootstrapValidator(
    fields:
      customer_birthday:
        validators:
          trigger: 'change keyup'
          callback:
            message: "Bạn phải ít nhất 10 tuổi",
            callback: (value,validator) ->
              m = new moment(value,"DD-MM-YYYY",true)
              return false unless m.isValid()
              age = moment().diff(m, 'years')
              age >= 10

  ).on 'success.form.bv', (e) ->

    e.preventDefault()
    $form = $(e.target)
    CEMSAjaxCall $form.find('[type=submit]:not(.bv-hidden-submit)'), "register_new_event_action", $form
    return
  $("#customer-birthday").datepicker(
    autoclose:"true"
  ).on "changeDate show", (e) ->
    # Revalidate the date when user change it
    $("#event17-form").bootstrapValidator "revalidateField", "customer_birthday"
    return

  return
