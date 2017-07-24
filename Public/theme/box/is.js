jQuery(function($) {
jQuery('#register-form').yiiactiveform({'validateOnSubmit':true,'afterValidateAttribute':function(form,attribute,data,hasError){
		             $("#"+attribute.id).parent().next("span.er_tps").remove();
		           },'attributes':[{'id':'BoxRegisterForm_username','inputID':'BoxRegisterForm_username','errorID':'BoxRegisterForm_username_em_','model':'BoxRegisterForm','name':'username','enableAjaxValidation':true,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u7528\u6237\u540d \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length<4) {
	messages.push("\u7528\u6237\u540d \u592a\u77ed (\u6700\u5c0f\u503c\u4e3a 4 \u5b57\u7b26\u4e32).");
}

if(value.length>15) {
	messages.push("\u7528\u6237\u540d \u592a\u957f (\u6700\u5927\u503c\u4e3a 15 \u5b57\u7b26\u4e32).");
}

}


if(jQuery.trim(value)!='' && !value.match(/^[a-zA-Z0-9]{1}([a-zA-Z0-9]|[_]){3,14}$/)) {
	messages.push("\u53ea\u80fd\u4e3a\u6570\u5b57\u4e0e\u5b57\u6bcd\u6216\u4e0b\u5212\u7ebf");
}

}},{'id':'BoxRegisterForm_password','inputID':'BoxRegisterForm_password','errorID':'BoxRegisterForm_password_em_','model':'BoxRegisterForm','name':'password','enableAjaxValidation':true,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u5bc6\u7801 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length<6) {
	messages.push("\u5bc6\u7801 \u592a\u77ed (\u6700\u5c0f\u503c\u4e3a 6 \u5b57\u7b26\u4e32).");
}

if(value.length>20) {
	messages.push("\u5bc6\u7801 \u592a\u957f (\u6700\u5927\u503c\u4e3a 20 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'BoxRegisterForm_repassword','inputID':'BoxRegisterForm_repassword','errorID':'BoxRegisterForm_repassword_em_','model':'BoxRegisterForm','name':'repassword','enableAjaxValidation':true,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u91cd\u590d\u5bc6\u7801 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(value!=jQuery('#BoxRegisterForm_password').val()) {
	messages.push("\u4e24\u5904\u8f93\u5165\u7684\u5bc6\u7801\u5e76\u4e0d\u4e00\u81f4".replace('{compareValue}', jQuery('#BoxRegisterForm_password').val()));
}

}},{'id':'BoxRegisterForm_realName','inputID':'BoxRegisterForm_realName','errorID':'BoxRegisterForm_realName_em_','model':'BoxRegisterForm','name':'realName','enableAjaxValidation':true,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u771f\u5b9e\u59d3\u540d \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length<2) {
	messages.push("\u771f\u5b9e\u59d3\u540d \u592a\u77ed (\u6700\u5c0f\u503c\u4e3a 2 \u5b57\u7b26\u4e32).");
}

if(value.length>5) {
	messages.push("\u771f\u5b9e\u59d3\u540d \u592a\u957f (\u6700\u5927\u503c\u4e3a 5 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'BoxRegisterForm_cardId','inputID':'BoxRegisterForm_cardId','errorID':'BoxRegisterForm_cardId_em_','model':'BoxRegisterForm','name':'cardId','enableAjaxValidation':true,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("\u8eab\u4efd\u8bc1 \u4e0d\u53ef\u4e3a\u7a7a\u767d.");
}


if(jQuery.trim(value)!='') {
	
if(value.length<15) {
	messages.push("\u8eab\u4efd\u8bc1 \u592a\u77ed (\u6700\u5c0f\u503c\u4e3a 15 \u5b57\u7b26\u4e32).");
}

if(value.length>18) {
	messages.push("\u8eab\u4efd\u8bc1 \u592a\u957f (\u6700\u5927\u503c\u4e3a 18 \u5b57\u7b26\u4e32).");
}

}

}},{'id':'BoxRegisterForm_agree','inputID':'BoxRegisterForm_agree','errorID':'BoxRegisterForm_agree_em_','model':'BoxRegisterForm','name':'agree','enableAjaxValidation':true,'clientValidation':function(value, messages, attribute) {

if(value!=true) {
	messages.push("\u60a8\u5fc5\u987b\u540c\u610f T3T2 \u7528\u6237\u670d\u52a1\u534f\u8bae\u624d\u80fd\u8fdb\u884c\u6ce8\u518c".replace('{compareValue}', true));
}

}}],'focus':'#BoxRegisterForm_username','errorCss':'error'});
});