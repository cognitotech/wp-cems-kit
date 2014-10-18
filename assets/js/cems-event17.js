(function() {
  jQuery.noConflict();

  (function($) {
    var bootstrapButton;
    bootstrapButton = $.fn.button.noConflict();
    $.fn.bootstrapBtn = bootstrapButton;
  })(jQuery);

  jQuery(document).ready(function($) {
    var CEMSAjaxCall;
    CEMSAjaxCall = function(submitBtn, cems_action, form, alert_box) {
      var $alert;
      submitBtn.bootstrapBtn("loading");
      $alert = $(alert_box);
      $alert.fadeOut("slow");
      $.post(wpdk_i18n.ajaxURL, "action=" + cems_action + "&" + $(form).serialize(), function(result) {
        var data, response, textResponse;
        response = new WPDKAjaxResponse(result);
        textResponse = "";
        if (empty(response.error)) {
          if (cems_action === "get_customer_existed_action") {
            textResponse = response.message;
            data = $.parseJSON(response.data);
            $(form).find('#customer-email').prop('readOnly', true);
            $(form).find('#customer-fullname').val(data.full_name).prop('readOnly', true);
            $(form).find('#customer-phone').val(data.phone).prop('readOnly', true);
            $(form).find('#customer-birthday').val(moment(data.birthday, 'YYYY-MM-DD').format('DD-MM-YYYY')).prop('readOnly', true);
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
        $.scrollTo($alert, 800, {
          offset: -50
        });
      }).always(function() {
        submitBtn.bootstrapBtn("reset");
      });
    };
    $("#event17-form").bootstrapValidator({
      fields: {
        customer_birthday: {
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
    }).on('success.form.bv', function(e) {
      var $form;
      e.preventDefault();
      $form = $(e.target);
      CEMSAjaxCall($form.find('[type=submit]:not(.bv-hidden-submit)'), "register_new_event_action", $form, '#cems-alert');
    });
    $("#customer-birthday").datepicker({
      autoclose: "true"
    }).on("changeDate show", function(e) {
      $("#event17-form").bootstrapValidator("revalidateField", "customer_birthday");
    });
    $("#event17-form .btn-check-exist").click(function() {
      var $form, bootstrapValidator;
      $form = $("#event17-form");
      bootstrapValidator = $form.data('bootstrapValidator');
      if (!bootstrapValidator.isValidField("customer_email")) {
        bootstrapValidator.revalidateField("customer_email");
        return;
      }
      return CEMSAjaxCall($form.find('.btn-check-exist'), "get_customer_existed_action", $form, "#cems-notify-customer");
    });
    $("#event17-form .btn-reset").click(function(e) {
      var $form;
      e.preventDefault();
      $form = $("#event17-form");
      $form.find('.alert').hide();
      $form[0].reset();
      $form.find('input').prop('readOnly', false);
      $form.data('bootstrapValidator').resetForm(true);
    });
  });

}).call(this);
