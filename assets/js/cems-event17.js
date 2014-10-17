(function() {
  jQuery.noConflict();

  (function($) {
    var bootstrapButton;
    bootstrapButton = $.fn.button.noConflict();
    $.fn.bootstrapBtn = bootstrapButton;
  })(jQuery);

  jQuery(document).ready(function($) {
    var CEMSAjaxCall;
    CEMSAjaxCall = function(submitBtn, cems_action, form) {
      var $alert;
      submitBtn.bootstrapBtn("loading");
      $alert = $("#cems-alert");
      $alert.fadeOut("slow");
      $.post(wpdk_i18n.ajaxURL, "action=" + cems_action + "&" + $(form).serialize(), function(result) {
        var response, textResponse;
        response = new WPDKAjaxResponse(result);
        textResponse = "";
        if (empty(response.error)) {
          textResponse = response.message + "<br>" + response.data;
          $alert.removeClass("alert-danger").addClass("alert-success");
        } else {
          textResponse = response.error;
          $alert.removeClass("alert-success").addClass("alert-danger");
        }
        $alert.children(".error-response").html(textResponse);
        $alert.fadeIn("slow");
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
      CEMSAjaxCall($form.find('[type=submit]:not(.bv-hidden-submit)'), "register_new_event_action", $form);
    });
    $("#customer-birthday").datepicker({
      autoclose: "true"
    }).on("changeDate show", function(e) {
      $("#event17-form").bootstrapValidator("revalidateField", "customer_birthday");
    });
  });

}).call(this);
