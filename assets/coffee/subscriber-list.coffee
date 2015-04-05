if ($ == undefined || $ == 'undefined')
    jQuery.noConflict(); # change to use $ replacement for jQuery

#

jQuery(document).ready(($) ->
    ###
    # Function:

    2. get_list_id

    ###

    
    #-- Start - get_list_id
    ###
    # Function get list id from HTML code
    # @param html_str : url string
    # @return list_id : list_id from action_url
    ###
    get_list_id = ( action_url ) ->
        ###
        # set result default is -1
        # run test pattern
        # => get result & check result is not null
        # ==> get list_id
        ###
        result = -1 # set default result
        if (action_url.length > 0) # check action_url length
            result = (/\/\d.\//ig).exec(action_url) # get result /<number>/
            if (result != null && result != "null" && (/\d./ig).test(result[0])) # re-check value not null && contain number
                return (/\d./ig).exec(result[0]);
            else
                result = -1 # re-set result

        return result
    #-- End - get_list_id

    ###

    ###
    # register event button check html code
    $('#check_edit_html_code, #check_new_html_code').on 'click', () ->
        html_code = null # Variable to get all code and parse to html
        is_new = true # variable to discrimination edit or create new
        #
        # Get HTML string
        if ($(this).attr('id') == 'check_new_html_code')
            html_code = $.parseHTML( $('#wpcems_new_html_code').val() )
            is_new = true
        else
            html_code = $.parseHTML( $('#wpcems_edit_html_code').val() )
            is_new = false
        #
        # html_code is not null
        if (html_code != null)
            #
            form = $(html_code) #parse html_code to Object
            
            # check is exists attribute action
            if (!form.is('[action]'))
                if (is_new)
                    $('#check_new_html_code_text').html('Can\'t check, don\'t have action attribute on form element!.')
                    setTimeout(() ->
                        $('#check_new_html_code_text').html('')
                    ,2000)
                else
                    $('#check_edit_html_code_text').html('Can\'t check, don\'t have action attribute on form element!.')
                    setTimeout(() ->
                        $('#check_edit_html_code_text').html('')
                    ,2000)
                return
            
            
            ###
            - get ID of subscriber list
            - add input element list_id
            - set value for textbox list_id
            - set value for textbox name if null or empty is form<list_id>
            - add attribulte id form<list_id> to form + remove action
            - remove script customer_source if exists -> auto remove when parse to Object
            - check exists input customer_source
            ###
            
            list_id = get_list_id(form.attr('action')) # get list id
            # re-check list_id not exists -> stop -> return
            if ( (list_id+'').length <= 0 || parseInt(list_id+'') <= 0)
                if (is_new)
                    $('#check_new_html_code_text').html('Can\'t check, can\'t get list_id or list_id is not a number!.')
                    setTimeout(() ->
                        $('#check_new_html_code_text').html('')
                    ,2000)
                else
                    $('#check_edit_html_code_text').html('Can\'t check, can\'t get list_id or list_id is not a number!.')
                    setTimeout(() ->
                        $('#check_edit_html_code_text').html('')
                    ,2000)
                return
                
            ###
            ###
            form.removeAttr('action').attr('id','form'+list_id) # remove action + add attribute id to form
            # add list_id to textbox & set textbox name
            if (is_new) # for create new
                $('#wpcems_new_form_id').val(list_id)
                if (($('#wpcems_new_form_name').val()+'').trim().length <= 0)
                    $('#wpcems_new_form_name').val('form'+list_id)
            else # for edit
                $('#wpcems_edit_form_id').val(list_id)
                if (($('#wpcems_edit_form_name').val()+'').trim().length <= 0)
                    $('#wpcems_edit_form_name').val('form'+list_id)
            
            # Append input hidden list_id
            # check is code containt fisrt div -> append to this
            # else append to form
            if (form.children('div:first-child').length == 1)
                form.children('div:first-child').append('<input type="hidden" name="list_id" value="'+list_id+'"/>')
            else
                form.append('<input type="hidden" name="list_id" value="'+list_id+'"/>')
            
            
            
            #
            # Parse Object to html string
            # Alert done
            #
            if (is_new)
                $('#wpcems_new_html_code').val($('<div>').append(form.clone()).html())
                $('#check_new_html_code_text').html('Checking done!.')
                setTimeout(() ->
                    $('#check_new_html_code_text').html('')
                ,2000)
            else
                $('#wpcems_edit_html_code').val($('<div>').append(form.clone()).html())
                $('#check_edit_html_code_text').html('Checking done!.')
                setTimeout(() ->
                    $('#check_edit_html_code_text').html('')
                ,2000)
        else
            if (is_new)
                $('#check_new_html_code_text').html('HTML code is null or empty!.')
                setTimeout(() ->
                    $('#check_new_html_code_text').html('')
                ,2000)
            else
                $('#check_edit_html_code_text').html('HTML code is null or empty!.')
                setTimeout(() ->
                    $('#check_edit_html_code_text').html('')
                ,2000)

    ###
    
    ###
    # Jquery catch event click button convert to bootstrap
    $('#convert_edit_bootstrap, #convert_new_bootstrap').on 'click', () ->
        html_code = null # Variable to get all code and parse to html
        is_new = true # variable to discrimination edit or create new
        #
        # Get HTML string
        if ($(this).attr('id') == 'convert_new_bootstrap')
            html_code = $.parseHTML( $('#wpcems_new_html_code').val() )
            is_new = true
        else
            html_code = $.parseHTML( $('#wpcems_edit_html_code').val() )
            is_new = false
            
            
        #
        # html_code is not null
        if (html_code != null)
            #
            form = $(html_code) #parse html_code to Object
            
            # check is exists attribute action
            if (form.hasClass('is-bootstrap3'))
                if (is_new)
                    $('#check_new_html_code_text').html('This form has been converted to bootstrap3!.')
                    setTimeout(() ->
                        $('#check_new_html_code_text').html('')
                    ,2000)
                else
                    $('#check_edit_html_code_text').html('This form has been converted to bootstrap3!.')
                    setTimeout(() ->
                        $('#check_edit_html_code_text').html('')
                    ,2000)
                return
        
            #
            # Convert to bootstrap3
            #
            # Add class form-control to input:type
            $.each(form.find('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], input[type="password"], textarea, select'), (index, item) ->
                $(item).addClass('form-control')
            )
            
            # Add btn to input:submit
            $.each(form.find('input[type="submit"], button[type="submit"]'), (index, item) ->
                $(item).addClass('btn')
            )
            
            # Add form-group section with label and input
            $.each(form.find('label'), (index, label) ->
                # create form-group
                form_group = $('<div class="form-group"></div>')
                form_group.append($(label).clone())
            
                # check have attribute for
                if ( $(label).is('[for]') )
                    # get value of for -> id
                    input_id = $(label).attr('for')
                    if ($(label).hasClass('required'))
                        form.find('#'+input_id).attr('required','required')
                    form_group.append(form.find('#'+input_id).detach())
                    
                # replace current label with form-group
                $(label).replaceWith(form_group);
            )
            
            # Change checkbox and radio button
            # change checkbox
            $.each(form.find('input[type="checkbox"]'), (index, item) ->
                div_checkbox = $('<div class="checkbox"></div>').append($('<label></labe>').append($(item).clone()).append(item.nextSibling))
                $(item).replaceWith(div_checkbox)
            )
            # change radio
            $.each(form.find('input[type="radio"]'), (index, item) ->
                div_radio = $('<div class="radio"></div>').append($('<label></labe>').append($(item).clone()).append(item.nextSibling))
                $(item).replaceWith(div_radio);
            )
            
            #
            # Set class is-bootstrap3
            form.addClass('is-bootstrap3')
            
            #
            # Parse Object to html string
            # Alert done
            #
            if (is_new)
                $('#wpcems_new_html_code').val($('<div>').append(form.clone()).html())
                $('#check_new_html_code_text').html('Convert to bootstrap3 done!.')
                setTimeout(() ->
                    $('#check_new_html_code_text').html('')
                ,2000)
            else
                $('#wpcems_edit_html_code').val($('<div>').append(form.clone()).html())
                $('#check_edit_html_code_text').html('Convert to bootstrap3 done!.')
                setTimeout(() ->
                    $('#check_edit_html_code_text').html('')
                ,2000)
        else
            if (is_new)
                $('#check_new_html_code_text').html('HTML code is null or empty!.')
                setTimeout(() ->
                    $('#check_new_html_code_text').html('')
                ,2000)
            else
                $('#check_edit_html_code_text').html('HTML code is null or empty!.')
                setTimeout(() ->
                    $('#check_edit_html_code_text').html('')
                ,2000)
)