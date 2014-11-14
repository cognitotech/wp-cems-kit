(function() {
  jQuery.noConflict();

  (function($) {
    var bootstrapButton;
    bootstrapButton = $.fn.button.noConflict();
    return $.fn.bootstrapBtn = bootstrapButton;
  })(jQuery);

  jQuery(document).ready(function($) {
    var CEMSAjaxCall;
    $('input, textarea').placeholder();
    CEMSAjaxCall = function(submitBtn, cems_action, form, alert_box) {
      var $alert;
      submitBtn.bootstrapBtn("loading");
      $alert = $(form).find(alert_box);
      $alert.fadeOut("slow");
      return $.post(wpdk_i18n.ajaxURL, "action=" + cems_action + "&" + $(form).serialize(), function(result) {
        var data, response, textResponse;
        response = new WPDKAjaxResponse(result);
        textResponse = "";
        if (empty(response.error)) {
          if (cems_action === "get_customer_existed_action") {
            textResponse = response.message;
            data = $.parseJSON(response.data);
            $(form).find("input[name$='[email]']").prop('readOnly', true);
            $(form).find("input[name$='[full_name]']").val(data.full_name).prop('readOnly', true);
            $(form).find("input[name$='[phone]']").val(data.phone).prop('readOnly', true);
            $(form).find("input[name$='[birthday]']").val(moment(data.birthday, 'YYYY-MM-DD').format('DD-MM-YYYY')).prop('readOnly', true);
          } else {
            textResponse = response.message + "<br>" + response.data;
          }
          $alert.removeClass("alert-danger").addClass("alert-success");
        } else {
          textResponse = response.error;
          $alert.removeClass("alert-success").addClass("alert-danger");
        }
        $alert.children(".error-response").html(textResponse);
        $alert.fadeIn("slow");
        return $.scrollTo($alert, 800, {
          offset: -50
        });
      }).always(function() {
        return submitBtn.bootstrapBtn("reset");
      });
    };
    $("#event17-form,.subscriptionForm").bootstrapValidator({
      fields: {
        'customer[birthday]': {
          validators: {
            trigger: 'change keyup',
            callback: {
              message: "Bạn phải ít nhất 10 tuổi",
              callback: function(value, validator) {
                var age, m;
                m = new moment(value, "DD-MM-YYYY", true);
                if (!m.isValid()) {
                  return false;
                }
                age = moment().diff(m, 'years');
                return age >= 10;
              }
            }
          }
        }
      }
    });
    $("#event17-form").bootstrapValidator().on('success.form.bv', function(e) {
      var $form;
      e.preventDefault();
      $form = $(e.target);
      return CEMSAjaxCall($form.find('[type=submit]:not(.bv-hidden-submit)'), "register_new_event_action", $form, '#cems-alert');
    });
    $("#customer-birthday").datepicker({
      autoclose: "true"
    }).on("changeDate show", function(e) {
      return $(this).closest("form").bootstrapValidator("revalidateField", "customer[birthday]");
    });
    $(".btn-check-exist").click(function() {
      var $form, bootstrapValidator;
      $form = $(this).closest('form');
      bootstrapValidator = $form.data('bootstrapValidator');
      if (!bootstrapValidator.isValidField("customer[email]")) {
        bootstrapValidator.revalidateField("customer[email]");
        return;
      }
      return CEMSAjaxCall($form.find('.btn-check-exist'), "get_customer_existed_action", $form, ".cems-notify-customer");
    });
    $(".btn-reset").click(function(e) {
      var $form;
      e.preventDefault();
      $form = $(this).closest("form");
      $form.find('.alert').hide();
      $form[0].reset();
      $form.find('input').prop('readOnly', false);
      return $form.data('bootstrapValidator').resetForm(true);
    });
    $(".subscriptionForm").bootstrapValidator().on('success.form.bv', function(e) {
      var $form;
      e.preventDefault();
      $form = $(e.target);
      return CEMSAjaxCall($form.find('[type=submit]:not(.bv-hidden-submit)'), "new_subscription_action", $form, '.cems-alert');
    });
    return $("input[name$='birthday']").datepicker({
      autoclose: "true"
    }).on("changeDate show", function(e) {
      return $(this).closest("form").bootstrapValidator("revalidateField", "customer[birthday]");
    });
  });

}).call(this);
