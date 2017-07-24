    function Step1(data) {
        if (data.status == 0) {
            $('.step1').hide();
            $('.step2').show();
            $('.kfstep ').removeClass('kfstep01');
            $('.kfstep ').addClass('kfstep02');

            if (!data.email) {
                $('.email').hide();
                $('.mail').hide();
            } else {
                $('#emailbindtip').html("该帐号已绑定邮箱：" + data.email + "<br>填写正确后即可重置新密码。");
            }
            if (!data.phone) {
                $('.phone').hide();
                $('.phones').hide();
            }
            else {
                $('#phone').html("该帐号已绑定手机：" + data.phone + "<br>填写正确后即可重置新密码。");
                if (!data.email)
                    $('.phones').show();
            }

            if (!data.phone && !data.email)
                $('.onliness').show();
        } else {
            for (key in data.error) {
                var id = "#TicketPwdValidateForm_" + key + "_em_";
                $(id).html(data.error[key]);
                $(id).show();
            }
        }
    }

    function online(data) {
        if (data.status == 0) {
            $("#sno").html(data.sno);
            $(".step2").hide();
            $("#info").show();
            $('.kfstep ').removeClass('kfstep02');
            $('.kfstep ').addClass('kfstep03');
        }
        else if (data.status == 1) {
            for (var i in data.errors) {
                var node = "#TicketPwdForm_" + i + "_em_";
                $(node).html(data.errors[i]);
                $(node).show();
            }
        }
        else if(data.status == 2) {
            $(".step2").hide();
            $("#submitFailed").show();
            $('.kfstep ').removeClass('kfstep02');
            $('.kfstep ').addClass('kfstep03');
            $('#errorInfo').html(data.error);
        }
    }


	var email_button=false;
    $('#checkEmail').click(function () {
        var email = $('#bindingEmail').val();
        if (email == "") {
            $('#emailError').html('请填写邮箱');
            return;
        }
		if(email_button){
			$('#emailError').html('不要重复点击');
            return;
		}
		
		email_button=true;
		
        $.getJSON(U('Service/ticket/sendEmail','callback=?&email=' + email+'&username='+$('#TicketPwdValidateForm_username').val()), function (data) {
			email_button=false;
            if (data.status == 0) {
                var html = '<span class="winners" id="emailSuccess">' + data.msg + '</span>';
                $('#emailError').html(data.msg);
                $('#emailError').removeClass('errors');
                $('#emailError').addClass('winners');
                $('#emailError').show();
            }
            else {
                $('#emailError').html(data.msg);
                $('#emailError').show();
                $('#emailError').addClass('errors');
                $('#emailError').removeClass('winners');
            }
        }, 'jsonp');
    })

    $('.sendyzm').click(function () {
        if($(this).attr('class').indexOf('sendyzmdb')>=0)
            return;
        var phone = $('#bindingphone').val();
        var node = $(this);
        $.getJSON(U('Service/ticket/sendsms','callback=?&phone='+phone+'&username='+$('#TicketPwdValidateForm_username').val()), function (data) {
            if (data.status == 0) {
                $('#phoneError').html(data.msg);
                $('#phoneError').addClass('winners');
                $('#phoneError').removeClass('errors');
                node.addClass('sendyzmdb');
                node.removeClass('sendyzm');
            }
            else {
                $('#phoneError').html(data.msg);
                $('#phoneError').show();
                $('#phoneError').removeClass('winners');
                $('#phoneError').addClass('errors');
            }
        },'jsonp');
    })

    $('#checkphone').click(function () {
        var code = $('#code').val();
        $.getJSON(U('Service/ticket/smscode','callback=?&code='+code+'&username='+$('#TicketPwdValidateForm_username').val()),function (data) {
            if (data.status == 0) {
				$('#modifyway').val(data.sign);
                $('.kfstep ').removeClass('kfstep02');
                $('.kfstep ').addClass('kfstep03');
                $('.step2').hide();
                $('.step3').show();
            }
            else {
                $('#phoneError').html(data.msg);
                $('#phoneError').show();
                $('#phoneError').removeClass('winners');
                $('#phoneError').addClass('errors');
            }
        },'jsonp');
    })

    $('#modifyPwd').click(function () {
        var pwd = $('#pwd').val();
        var pwd1 = $('#pwd1').val();

        if (pwd.length < 6 || pwd.length > 20) {
            $('#pwdError').html('密码长度请保持在6-20个字符');
            return;
        }
        $('#pwdError').html('');
        if (pwd1 != pwd) {
            $('#pwd1Error').html('两次输入密码不一致');
            return;
        }
        $('#pwd1Error').html('');

        $.getJSON(U('Service/ticket/setpw','callback=?&password='+$('#pwd').val()+'&pwdsign='+$('#modifyway').val()), function (data) {
            if (data.status == 0) {
                $('.winners').html('密码修改成功');
                $('#pwdError').html('');
                $('#pwd1Error').html('');
				$('.step1').hide();
				$('.step2').hide();
				$('.step3').hide();
				$('#info').show();
            }
            else {
                $('#pwdError').html(data.msg);
                $('.winners').hide();
            }
        }, 'jsonp');
    })

window.locale = {'fileupload':{'errors':{'maxFileSize':'File is too big','minFileSize':'File is too small','acceptFileTypes':'Filetype not allowed','maxNumberOfFiles':'Max number of files exceeded','uploadedBytes':'Uploaded bytes exceed file size','emptyResult':'Empty file upload result'},'error':'Error','start':'Start','cancel':'Cancel','destroy':'Delete'}}

jQuery(document).on('click', '#yw0', function(){
	jQuery('#yw0').attr('src', U('User/Public/vcode'));	
});

jQuery('#step1-form').yiiactiveform({'validateOnSubmit':true,'afterValidate':function(form,data,hasError){
                if(!hasError){
                  $.ajax({  
                    "type":"POST",  
                    "url":U('User/Public/validateUser','callback=?'),
                    "dataType":"jsonp",  
                    "data":$("#step1-form").serialize(),  
                    "success":function(data){Step1(data)}
                  })
                }  
              },'attributes':[{'id':'TicketPwdValidateForm_username','inputID':'TicketPwdValidateForm_username','errorID':'TicketPwdValidateForm_username_em_','model':'TicketPwdValidateForm','name':'username','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u7528\u6237\u540d \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length<4) {
	messages.push("\u7528\u6237\u540d \u592a\u77ed (\u6700\u5c0f\u503c\u4e3a 4 \u5b57\u7b26\u4e32).");
}

if(value.length>30) {
	messages.push("\u7528\u6237\u540d \u592a\u957f (\u6700\u5927\u503c\u4e3a 30 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'TicketPwdValidateForm_verifyCode','inputID':'TicketPwdValidateForm_verifyCode','errorID':'TicketPwdValidateForm_verifyCode_em_','model':'TicketPwdValidateForm','name':'verifyCode','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(value.length<4) {
	messages.push("\u9a8c\u8bc1\u7801\u4e0d\u6b63\u786e.");
}
if(value.length>4) {
	messages.push("\u9a8c\u8bc1\u7801\u4e0d\u6b63\u786e.");
}
}}],'focus':'#TicketPwdValidateForm_username','errorCss':'error'});
jQuery('#TicketPwdForm_loginTime').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['zh-CN'],{'dateFormat':'yy-mm-dd'}));
jQuery('#ticket-form').yiiactiveform({'validateOnSubmit':true,'afterValidate':function(form,data,hasError){
                if(!hasError){
                  $.ajax({
                    "type":"POST",
                    "url":$("#ticket-form").attr("action"),
                    "dataType":"json",
                    "data":$("#ticket-form").serialize(),
                    "success":function(data){online(data)}
                  });
                }
              },'attributes':[{'id':'TicketPwdForm_userName','inputID':'TicketPwdForm_userName','errorID':'TicketPwdForm_userName_em_','model':'TicketPwdForm','name':'userName','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u7528\u6237\u540d \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length>255) {
	messages.push("\u7528\u6237\u540d \u592a\u957f (\u6700\u5927\u503c\u4e3a 255 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'TicketPwdForm_gid','inputID':'TicketPwdForm_gid','errorID':'TicketPwdForm_gid_em_','model':'TicketPwdForm','name':'gid','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u7ecf\u5e38\u73a9\u7684\u6e38\u620f \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(!value.match(/^\s*[+-]?\d+\s*$/)) {
	messages.push("\u7ecf\u5e38\u73a9\u7684\u6e38\u620f \u5fc5\u987b\u4e3a\u6574\u6570.");
}

}

}},{'id':'TicketPwdForm_sid','inputID':'TicketPwdForm_sid','errorID':'TicketPwdForm_sid_em_','model':'TicketPwdForm','name':'sid','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u533a\u670d \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length>255) {
	messages.push("\u533a\u670d \u592a\u957f (\u6700\u5927\u503c\u4e3a 255 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'TicketPwdForm_roleName','inputID':'TicketPwdForm_roleName','errorID':'TicketPwdForm_roleName_em_','model':'TicketPwdForm','name':'roleName','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u89d2\u8272\u540d \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length>255) {
	messages.push("\u89d2\u8272\u540d \u592a\u957f (\u6700\u5927\u503c\u4e3a 255 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'TicketPwdForm_regCity','inputID':'TicketPwdForm_regCity','errorID':'TicketPwdForm_regCity_em_','model':'TicketPwdForm','name':'regCity','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u6ce8\u518c\u57ce\u5e02 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length>255) {
	messages.push("\u6ce8\u518c\u57ce\u5e02 \u592a\u957f (\u6700\u5927\u503c\u4e3a 255 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'TicketPwdForm_loginTime','inputID':'TicketPwdForm_loginTime','errorID':'TicketPwdForm_loginTime_em_','model':'TicketPwdForm','name':'loginTime','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u6700\u540e\u767b\u5f55\u65f6\u95f4 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length>255) {
	messages.push("\u6700\u540e\u767b\u5f55\u65f6\u95f4 \u592a\u957f (\u6700\u5927\u503c\u4e3a 255 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'TicketPwdForm_cardNo','inputID':'TicketPwdForm_cardNo','errorID':'TicketPwdForm_cardNo_em_','model':'TicketPwdForm','name':'cardNo','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u8eab\u4efd\u8bc1\u53f7 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length>255) {
	messages.push("\u8eab\u4efd\u8bc1\u53f7 \u592a\u957f (\u6700\u5927\u503c\u4e3a 255 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'TicketPwdForm_total','inputID':'TicketPwdForm_total','errorID':'TicketPwdForm_total_em_','model':'TicketPwdForm','name':'total','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u5145\u503c\u603b\u989d \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(!value.match(/^\s*[+-]?\d+\s*$/)) {
	messages.push("\u5145\u503c\u603b\u989d \u5fc5\u987b\u4e3a\u6574\u6570.");
}

}

}},{'id':'TicketPwdForm_chargeWay','inputID':'TicketPwdForm_chargeWay','errorID':'TicketPwdForm_chargeWay_em_','model':'TicketPwdForm','name':'chargeWay','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u5e38\u7528\u5145\u503c\u65b9\u5f0f \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length>255) {
	messages.push("\u5e38\u7528\u5145\u503c\u65b9\u5f0f \u592a\u957f (\u6700\u5927\u503c\u4e3a 255 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'TicketPwdForm_email','inputID':'TicketPwdForm_email','errorID':'TicketPwdForm_email_em_','model':'TicketPwdForm','name':'email','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u90ae\u7bb1\u5730\u5740 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}



if(jQuery.trim(value)!='' && !value.match(/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/)) {
	messages.push("\u90ae\u7bb1\u5730\u5740 \u4e0d\u662f\u6709\u6548\u7684\u7535\u5b50\u90ae\u4ef6\u5730\u5740.");
}

}},{'id':'TicketPwdForm_mobile','inputID':'TicketPwdForm_mobile','errorID':'TicketPwdForm_mobile_em_','model':'TicketPwdForm','name':'mobile','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u624b\u673a\u53f7\u7801 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(!value.match(/^\s*[+-]?\d+\s*$/)) {
	messages.push("\u624b\u673a\u53f7\u7801 \u5fc5\u987b\u4e3a\u6574\u6570.");
}

}

}},{'id':'TicketPwdForm_qq','inputID':'TicketPwdForm_qq','errorID':'TicketPwdForm_qq_em_','model':'TicketPwdForm','name':'qq','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)!='') {
	
if(!value.match(/^\s*[+-]?\d+\s*$/)) {
	messages.push("QQ \u5fc5\u987b\u4e3a\u6574\u6570.");
}

}

}},{'id':'TicketPwdForm_note','inputID':'TicketPwdForm_note','errorID':'TicketPwdForm_note_em_','model':'TicketPwdForm','name':'note','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)!='') {
	
if(value.length>65535) {
	messages.push("\u5907\u6ce8\u8bf4\u660e \u592a\u957f (\u6700\u5927\u503c\u4e3a 65535 \u5b57\u7b26\u4e32).");
}

}

}}],'errorCss':'error'});
/*]]>*/