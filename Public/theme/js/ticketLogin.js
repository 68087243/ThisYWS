$(document).ready(function(){
	$(".upsubs").click(function(){
		if(!checksubmit()){
			return;
		}
		$.post(U('Api/User/ajaxLogin'),$('#yw0').serialize(),function(data){
					  if(data.msg=='success')
					  {
						 if(typeof(logonSuccess)!='undefined'){
							logonSuccess($('#login-username').val() ,$('#login-password').val());
							return;
						 }
						 $('body').append(data.script);
						 location.reload();
					  }
					  else
					  {
						  $("#LoginForm_password_em_").html("密码错误");
						  $("#LoginForm_password_em_").css("display","inline-block");
					  }
			},'jsonp');
	}); 
	
function checksubmit(){
	var username=$('#LoginForm_username').val();
	var password=$('#LoginForm_password').val();
	if(jQuery.trim(username)=='') {
        $("#LoginForm_username_em_").html("请输入用户名");
        $("#LoginForm_username_em_").css("display","inline-block");
		return false;
	}else{
		if(username.length<4) {
			$("#LoginForm_username_em_").html("用户名 太短 (最小值为 4 字符串)");
			$("#LoginForm_username_em_").css("display","inline-block");
			return false;
		}else{
			$("#LoginForm_username_em_").css("display","none");
			return true
		}
	}
	
	if(jQuery.trim(password)=='') {
        $("#LoginForm_password_em_").html("请输入密码");
        $("#LoginForm_password_em_").css("display","inline-block");
		return false;
	}else{
		if(password.length<6) {
			$("#LoginForm_password_em_").html("密码 太短 (最小值为 6 字符串)");
			$("#LoginForm_password_em_").css("display","inline-block");
			return false;
		}else{
			$("#LoginForm_password_em_").css("display","none");
			return true
		}
	}
}

}); 