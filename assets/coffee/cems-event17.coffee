jQuery.noConflict()
(($) ->

  #bootstrap fix noConflict with jquery-ui
  bootstrapButton = $.fn.button.noConflict() # return $.fn.button to previously assigned value
  $.fn.bootstrapBtn = bootstrapButton # give $().bootstrapBtn the Bootstrap functionality

  return
) jQuery
jQuery(document).ready ($) ->

  # Sending something...
  CEMSAjaxCall = (submitBtn, cems_action, form, alert_box) ->
    submitBtn.bootstrapBtn "loading"
    $alert = $(alert_box)
    $alert.fadeOut "slow"

    $.post(wpdk_i18n.ajaxURL, "action=" + cems_action + "&" + $(form).serialize(), (result) ->
      response = new WPDKAjaxResponse(result)
      textResponse = ""
      #TODO: need to refactor below code
      if empty(response.error)
        if cems_action is "get_customer_existed_action"
          textResponse = response.message
          #setup data here
          data = $.parseJSON(response.data)
          $(form).find('#customer-email').prop('readOnly',true)
          $(form).find('#customer-fullname').val(data.full_name).prop('readOnly',true)
          $(form).find('#customer-phone').val(data.phone).prop('readOnly',true)
          $(form).find('#customer-birthday').val(moment(data.birthday, 'YYYY-MM-DD').format('DD-MM-YYYY')).prop('readOnly',true)
        else
          textResponse = response.message + "<br>" + response.data
        $alert.removeClass("alert-danger").addClass "alert-success"
      else
        textResponse = response.error
        $alert.removeClass("alert-success").addClass "alert-danger"
      $alert.children(".error-response").html textResponse
      $alert.fadeIn "slow"
      $.scrollTo $alert, 800,
        offset:-50
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
    CEMSAjaxCall $form.find('[type=submit]:not(.bv-hidden-submit)'), "register_new_event_action", $form, '#cems-alert'
    return

  #birthday validation
  $("#customer-birthday").datepicker(
    autoclose:"true"
  ).on "changeDate show", (e) ->
    # Revalidate the date when user change it
    $("#event17-form").bootstrapValidator "revalidateField", "customer_birthday"
    return

  $("#event17-form .btn-check-exist").click ->
    $form = $("#event17-form")
    bootstrapValidator = $form.data('bootstrapValidator')
    unless bootstrapValidator.isValidField("customer_email")
      bootstrapValidator.revalidateField("customer_email")
      return

    CEMSAjaxCall $form.find('.btn-check-exist'), "get_customer_existed_action", $form, "#cems-notify-customer"

  $("#event17-form .btn-reset").click (e)->
    e.preventDefault()
    $form = $("#event17-form")
    $form.find('.alert').hide()
    $form[0].reset();
    $form.find('input').prop('readOnly',false)
    $form.data('bootstrapValidator').resetForm(true)
    return
  return
