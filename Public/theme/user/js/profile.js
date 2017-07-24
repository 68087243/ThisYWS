function isQQ(qq) {
    var filter = /^[1-9]{1}[0-9]{4,11}$/;
    if (!filter.test(qq)) {
        return false;
    } else {
        return true;
    }
}


var checkingQq = {

          step1 : function(){

                var titles = "验证QQ",

					cons = '        <!-- 第一步 -->'+

			        '<div class="pset3">'+
			            '<span class="one">填写QQ号码</span>'+
			            '<span class="two">登录QQ邮箱激活</span>'+
			            '<span class="three">完成</span>'+
			        '</div>'+

			        '<div class="p-pdphone">'+
			            '<table>'+
			                '<tr>'+
			                    '<th width="118px">输入QQ号码</th>'+
			                    '<td>'+
			                        '<input id="new_qq" class="p-alertxt">@qq.com<span id="pusheoor"></span>'+
			                    '</td>'+
			                '</tr>'+
			                
			                '<tr>'+
			                    '<th></th>'+
			                    '<td>'+
			                      '<span id="qq_div_step1_sub" class="p-subbtn">确定</span>'+
			                    '</td>'+
			                '</tr>'+
			            '</table>'+
			        '</div>'+

			        '<div class="p-alertbs">'+
			            '提示：请先确认您的QQ已开通邮箱服务，以免导致无法收到激活邮件而验证失败。'+
			        '</div>';

                    gy_person.oppWrap.popShow(titles,cons);

                    var captcha_code = $("#new_qq");

                   	captcha_code[0].focus();

              },

          step2 : function(){
                var titles = "验证QQ",
                  cons = '        <!-- 第二步 -->'+
    '<div class="pset3 pset3-2">'+
        '<span class="one">填写QQ号码</span>'+
        '<span class="two">登录QQ邮箱激活</span>'+
        '<span class="three">完成</span>'+
    '</div>'+

    '<div class="p-pdphone">'+
        '<div class="p-mbemail">'+
            '<em>验证邮件已发送至您的邮箱：<span id="user_qq"></span></em>请您尽快登录邮箱，按邮箱中指示完成验证<br><a target="_blank" id="login_qq" href="https://mail.qq.com/" class="p-subbtn">登录邮箱</a>'+
        '</div>'+
    '</div>'+

    '<div class="p-alertbs">'+
        '提示：系统已向该邮箱发送了一封验证激活邮件，请查收邮件并进行激活，如果没有收到验证邮件，请检查邮箱的反垃圾箱设置，并到垃圾邮箱查看是否收到，或者更换一个邮箱重新验证'+
    '</div>';

                gy_person.oppWrap.popShow(titles,cons);
              },


          step3 : function(value){
                var titles = "验证QQ",
                  cons = '        <!-- 第三步 -->'+
    '<div class="pset3 pset3-cur">'+
        '<span class="one">填写QQ号码</span>'+
        '<span class="two">登录QQ邮箱激活</span>'+
        '<span class="three">完成</span>'+
    '</div>'+

    '<div class="p-phonend p-qqend">'+
        '<i class="p-secio-2"></i>'+
        '<p>您已验证QQ：'+value+'<a style="margin-left:10px;" target="_blank" href="'+U('User/vip/index')+'" class="p-grrenlink">点此领取30个VIP成长值</a></p>'+
    '</div>'+

    '<div class="p-alertbs">'+
        '提示：完成QQ验证后，您可以使用已验证的QQ邮箱来找回密码'+
    '</div>';
				//$.get('/site/addlog',{url:window.location.href.toString(),refurl:document.referrer,type:1});
                gy_person.oppWrap.popShow(titles,cons);

              },


          init : function(){
                

                  $(document).delegate("#checkqq","click",function(){

                      checkingQq.step1();


                  }).delegate("#new_qq","keypress",function(){

                      var text = $(this).val(),

						ele = $("#pusheoor");
						if ( !isQQ(text)){
							ele.html('<span class="p-error">请填写正确的QQ号码</span>');
						}else{
							ele.html('');
						}


                  }).delegate("#qq_div_step1_sub","click",function(){

                        var text = $('#new_qq').val(),

                            ele = $("#pusheoor");

						if ( !isQQ(text)){

							ele.html('<span class="p-error">请填写正确的QQ号码</span>');

							return;

						}else{

							ele.html('');

						}
                
                        

            

                        $("#user_qq").text(text + '@qq.com');

						$.getJSON(U('User/Profile/sendqq','callback=?'),{qq:text},function(result){
							if(result.code == 1){
								gy_person.oppWrap.popHidden();
								checkingQq.step2();
							}else{
								alert(result.msg);
								return;
							}
						});

                  }).delegate(".p-alertclose","click",function(){
	                      gy_person.oppWrap.popHidden();
	              });
          }
        };

checkingQq.init();

$(function(){

	//QQ号码
/**	
	$('.qq').blur(function(){
		var text = $(this).val();
		if ( !isQQ(text))
		{
			$(this).next().attr('class','p-eorrfont');
		}
		else
		{
			$(this).next().attr('class','p-eorrfont hidden');
		}
	});	
*/
	if(bindqq)
	{
		checkingQq.step3(qq);
	}


    
	/**
	 * 表单提交
	 */
	$('.p-subbtn').click(function(){
		$('form[name="ProfileForm"]').submit();
	});

});