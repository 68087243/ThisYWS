$('.r_button').bind("click",
function() {
    $(".w3").remove();
});
/*<![CDATA[*/
jQuery(function($) {
    jQuery('#register-form').yiiactiveform({
        'validateOnSubmit': true,
        'afterValidateAttribute': function(form, attribute, data, hasError) {
            $("#" + attribute.id).parent().next("span.w3").remove();
        },
        'attributes': [{
            'id': 'RegisterForm_username',
            'inputID': 'RegisterForm_username',
            'errorID': 'RegisterForm_username_em_',
            'model': 'RegisterForm',
            'name': 'username',
            'enableAjaxValidation': true,
            'clientValidation': function(value, messages, attribute) {

                if (jQuery.trim(value) == '') {
                    messages.push("\u7528\u6237\u540d \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
                }

                if (jQuery.trim(value) != '') {

                    if (value.length < 4) {
                        messages.push("\u7528\u6237\u540d \u592a\u77ed (\u6700\u5c0f\u503c\u4e3a 4 \u5b57\u7b26\u4e32).");
                    }

                    if (value.length > 15) {
                        messages.push("\u7528\u6237\u540d \u592a\u957f (\u6700\u5927\u503c\u4e3a 15 \u5b57\u7b26\u4e32).");
                    }

                }

                if (jQuery.trim(value) != '' && !value.match(/^[a-zA-Z0-9]{1}([a-zA-Z0-9]|[_]){3,14}$/)) {
                    messages.push("\u53ea\u80fd\u4e3a\u6570\u5b57\u4e0e\u5b57\u6bcd\u6216\u4e0b\u5212\u7ebf");
                }

            }
        },
        {
            'id': 'RegisterForm_password',
            'inputID': 'RegisterForm_password',
            'errorID': 'RegisterForm_password_em_',
            'model': 'RegisterForm',
            'name': 'password',
            'enableAjaxValidation': true,
            'clientValidation': function(value, messages, attribute) {

                if (jQuery.trim(value) == '') {
                    messages.push("\u5bc6\u7801 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
                }

                if (jQuery.trim(value) != '') {

                    if (value.length < 6) {
                        messages.push("\u5bc6\u7801 \u592a\u77ed (\u6700\u5c0f\u503c\u4e3a 6 \u5b57\u7b26\u4e32).");
                    }

                    if (value.length > 20) {
                        messages.push("\u5bc6\u7801 \u592a\u957f (\u6700\u5927\u503c\u4e3a 20 \u5b57\u7b26\u4e32).");
                    }

                }

            }
        },
        {
            'id': 'RegisterForm_repassword',
            'inputID': 'RegisterForm_repassword',
            'errorID': 'RegisterForm_repassword_em_',
            'model': 'RegisterForm',
            'name': 'repassword',
            'enableAjaxValidation': true,
            'clientValidation': function(value, messages, attribute) {

                if (jQuery.trim(value) == '') {
                    messages.push("\u91cd\u590d\u5bc6\u7801 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
                }

                if (value != jQuery('#RegisterForm_password').val()) {
                    messages.push("\u4e24\u5904\u8f93\u5165\u7684\u5bc6\u7801\u5e76\u4e0d\u4e00\u81f4".replace('{compareValue}', jQuery('#RegisterForm_password').val()));
                }

            }
        },
        {
            'id': 'RegisterForm_realName',
            'inputID': 'RegisterForm_realName',
            'errorID': 'RegisterForm_realName_em_',
            'model': 'RegisterForm',
            'name': 'realName',
            'enableAjaxValidation': true,
            'clientValidation': function(value, messages, attribute) {

                if (jQuery.trim(value) == '') {
                    messages.push("\u771f\u5b9e\u59d3\u540d \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
                }

                if (jQuery.trim(value) != '') {

                    if (value.length < 2) {
                        messages.push("\u771f\u5b9e\u59d3\u540d \u592a\u77ed (\u6700\u5c0f\u503c\u4e3a 2 \u5b57\u7b26\u4e32).");
                    }

                    if (value.length > 5) {
                        messages.push("\u771f\u5b9e\u59d3\u540d \u592a\u957f (\u6700\u5927\u503c\u4e3a 5 \u5b57\u7b26\u4e32).");
                    }

                }

            }
        },
        {
            'id': 'RegisterForm_cardId',
            'inputID': 'RegisterForm_cardId',
            'errorID': 'RegisterForm_cardId_em_',
            'model': 'RegisterForm',
            'name': 'cardId',
            'enableAjaxValidation': true,
            'clientValidation': function(value, messages, attribute) {

                if (jQuery.trim(value) == '') {
                    messages.push("\u8eab\u4efd\u8bc1 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
                }

                if (jQuery.trim(value) != '') {

                    if (value.length < 15) {
                        messages.push("\u8eab\u4efd\u8bc1 \u592a\u77ed (\u6700\u5c0f\u503c\u4e3a 15 \u5b57\u7b26\u4e32).");
                    }

                    if (value.length > 18) {
                        messages.push("\u8eab\u4efd\u8bc1 \u592a\u957f (\u6700\u5927\u503c\u4e3a 18 \u5b57\u7b26\u4e32).");
                    }

                }

            }
        },
		{
            'id': 'RegisterForm_obj',
            'inputID': 'RegisterForm_obj',
            'errorID': 'RegisterForm_obj_em_',
            'model': 'RegisterForm',
            'name': 'obj',
            'enableAjaxValidation': true,
            'clientValidation': function(value, messages, attribute) {

                if (jQuery.trim(value) == '') {
                    messages.push("\u8bf7\u9605\u8bfb\u7528\u6237\u534f\u8bae.");
                }

            }
        }],
        'focus': '#RegisterForm_username',
        'errorCss': 'error'
    });
});
/*]]>*/
