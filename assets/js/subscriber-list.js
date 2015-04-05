(function() {
  if ($ === void 0 || $ === 'undefined') {
    jQuery.noConflict();
  }

  jQuery(document).ready(function($) {

    /*
     * Function:
    
    2. get_list_id
     */

    /*
     * Function get list id from HTML code
     * @param html_str : url string
     * @return list_id : list_id from action_url
     */
    var get_list_id;
    get_list_id = function(action_url) {

      /*
       * set result default is -1
       * run test pattern
       * => get result & check result is not null
       * ==> get list_id
       */
      var result;
      result = -1;
      if (action_url.length > 0) {
        result = /\/\d.\//ig.exec(action_url);
        if (result !== null && result !== "null" && /\d./ig.test(result[0])) {
          return /\d./ig.exec(result[0]);
        } else {
          result = -1;
        }
      }
      return result;
    };

    /*
     */
    $('#check_edit_html_code, #check_new_html_code').on('click', function() {
      var form, html_code, is_new, list_id;
      html_code = null;
      is_new = true;
      if ($(this).attr('id') === 'check_new_html_code') {
        html_code = $.parseHTML($('#wpcems_new_html_code').val());
        is_new = true;
      } else {
        html_code = $.parseHTML($('#wpcems_edit_html_code').val());
        is_new = false;
      }
      if (html_code !== null) {
        form = $(html_code);
        if (!form.is('[action]')) {
          if (is_new) {
            $('#check_new_html_code_text').html('Can\'t check, don\'t have action attribute on form element!.');
            setTimeout(function() {
              return $('#check_new_html_code_text').html('');
            }, 2000);
          } else {
            $('#check_edit_html_code_text').html('Can\'t check, don\'t have action attribute on form element!.');
            setTimeout(function() {
              return $('#check_edit_html_code_text').html('');
            }, 2000);
          }
          return;
        }

        /*
        - get ID of subscriber list
        - add input element list_id
        - set value for textbox list_id
        - set value for textbox name if null or empty is form<list_id>
        - add attribulte id form<list_id> to form + remove action
        - remove script customer_source if exists -> auto remove when parse to Object
        - check exists input customer_source
         */
        list_id = get_list_id(form.attr('action'));
        if ((list_id + '').length <= 0 || parseInt(list_id + '') <= 0) {
          if (is_new) {
            $('#check_new_html_code_text').html('Can\'t check, can\'t get list_id or list_id is not a number!.');
            setTimeout(function() {
              return $('#check_new_html_code_text').html('');
            }, 2000);
          } else {
            $('#check_edit_html_code_text').html('Can\'t check, can\'t get list_id or list_id is not a number!.');
            setTimeout(function() {
              return $('#check_edit_html_code_text').html('');
            }, 2000);
          }
          return;
        }

        /*
         */
        form.removeAttr('action').attr('id', 'form' + list_id);
        if (is_new) {
          $('#wpcems_new_form_id').val(list_id);
          if (($('#wpcems_new_form_name').val() + '').trim().length <= 0) {
            $('#wpcems_new_form_name').val('form' + list_id);
          }
        } else {
          $('#wpcems_edit_form_id').val(list_id);
          if (($('#wpcems_edit_form_name').val() + '').trim().length <= 0) {
            $('#wpcems_edit_form_name').val('form' + list_id);
          }
        }
        if (form.children('div:first-child').length === 1) {
          form.children('div:first-child').append('<input type="hidden" name="list_id" value="' + list_id + '"/>');
        } else {
          form.append('<input type="hidden" name="list_id" value="' + list_id + '"/>');
        }
        if (is_new) {
          $('#wpcems_new_html_code').val($('<div>').append(form.clone()).html());
          $('#check_new_html_code_text').html('Checking done!.');
          return setTimeout(function() {
            return $('#check_new_html_code_text').html('');
          }, 2000);
        } else {
          $('#wpcems_edit_html_code').val($('<div>').append(form.clone()).html());
          $('#check_edit_html_code_text').html('Checking done!.');
          return setTimeout(function() {
            return $('#check_edit_html_code_text').html('');
          }, 2000);
        }
      } else {
        if (is_new) {
          $('#check_new_html_code_text').html('HTML code is null or empty!.');
          return setTimeout(function() {
            return $('#check_new_html_code_text').html('');
          }, 2000);
        } else {
          $('#check_edit_html_code_text').html('HTML code is null or empty!.');
          return setTimeout(function() {
            return $('#check_edit_html_code_text').html('');
          }, 2000);
        }
      }
    });

    /*
     */
    return $('#convert_edit_bootstrap, #convert_new_bootstrap').on('click', function() {
      var form, html_code, is_new;
      html_code = null;
      is_new = true;
      if ($(this).attr('id') === 'convert_new_bootstrap') {
        html_code = $.parseHTML($('#wpcems_new_html_code').val());
        is_new = true;
      } else {
        html_code = $.parseHTML($('#wpcems_edit_html_code').val());
        is_new = false;
      }
      if (html_code !== null) {
        form = $(html_code);
        if (form.hasClass('is-bootstrap3')) {
          if (is_new) {
            $('#check_new_html_code_text').html('This form has been converted to bootstrap3!.');
            setTimeout(function() {
              return $('#check_new_html_code_text').html('');
            }, 2000);
          } else {
            $('#check_edit_html_code_text').html('This form has been converted to bootstrap3!.');
            setTimeout(function() {
              return $('#check_edit_html_code_text').html('');
            }, 2000);
          }
          return;
        }
        $.each(form.find('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], input[type="password"], textarea, select'), function(index, item) {
          return $(item).addClass('form-control');
        });
        $.each(form.find('input[type="submit"], button[type="submit"]'), function(index, item) {
          return $(item).addClass('btn');
        });
        $.each(form.find('label'), function(index, label) {
          var form_group, input_id;
          form_group = $('<div class="form-group"></div>');
          form_group.append($(label).clone());
          if ($(label).is('[for]')) {
            input_id = $(label).attr('for');
            if ($(label).hasClass('required')) {
              form.find('#' + input_id).attr('required', 'required');
            }
            form_group.append(form.find('#' + input_id).detach());
          }
          return $(label).replaceWith(form_group);
        });
        $.each(form.find('input[type="checkbox"]'), function(index, item) {
          var div_checkbox;
          div_checkbox = $('<div class="checkbox"></div>').append($('<label></labe>').append($(item).clone()).append(item.nextSibling));
          return $(item).replaceWith(div_checkbox);
        });
        $.each(form.find('input[type="radio"]'), function(index, item) {
          var div_radio;
          div_radio = $('<div class="radio"></div>').append($('<label></labe>').append($(item).clone()).append(item.nextSibling));
          return $(item).replaceWith(div_radio);
        });
        form.addClass('is-bootstrap3');
        if (is_new) {
          $('#wpcems_new_html_code').val($('<div>').append(form.clone()).html());
          $('#check_new_html_code_text').html('Convert to bootstrap3 done!.');
          return setTimeout(function() {
            return $('#check_new_html_code_text').html('');
          }, 2000);
        } else {
          $('#wpcems_edit_html_code').val($('<div>').append(form.clone()).html());
          $('#check_edit_html_code_text').html('Convert to bootstrap3 done!.');
          return setTimeout(function() {
            return $('#check_edit_html_code_text').html('');
          }, 2000);
        }
      } else {
        if (is_new) {
          $('#check_new_html_code_text').html('HTML code is null or empty!.');
          return setTimeout(function() {
            return $('#check_new_html_code_text').html('');
          }, 2000);
        } else {
          $('#check_edit_html_code_text').html('HTML code is null or empty!.');
          return setTimeout(function() {
            return $('#check_edit_html_code_text').html('');
          }, 2000);
        }
      }
    });
  });

}).call(this);
