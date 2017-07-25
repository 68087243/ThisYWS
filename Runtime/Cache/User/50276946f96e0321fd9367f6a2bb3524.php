<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="edge">
<title><?php echo ($meta_title); ?>｜<?php echo C('WEB_SITE_TITLE'); echo C('WEB_SITE_SLOGAN');?></title>
<meta name="keywords" content="<?php echo ($meta_keywords); ?>">
<meta name="description" content="<?php echo ($meta_description); ?>">
<script type="text/javascript"><?php echo W('Common/Public/script');?></script>
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/user/css/logreg.css" />
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jquery183min.js"></script>
<base target='_blank'>
</head>
<body class="login">
	<div class="log_hd">
		<h1 class="lr_logo">
			<a href="<?php echo U('Home/index/index');?>"><?php echo domain();?>国内最大的网页游戏平台,最好玩的游戏尽在<?php echo C('WEB_SITE_TITLE');?></a>
			<i></i>
		</h1>
	</div>
	<div class="log_bd clearfix">
		<span class="hidden">最高人气最酷游戏尽在<?php echo C('WEB_SITE_TITLE');?></span>
		<div class="logbox">
			<h2><?php echo C('WEB_SITE_TITLE');?>用户登录</h2>
			<div class="log_tips" style="display:none;" id="error_handle"><i></i><span>用户名或密码不正确</span></div>
			<ul class="log_ul clearfix">
			    <form target="_self" id="login-form" action="<?php echo U('Api/User/ajaxLogin');?>" method="post">
				<li>
					<span>用户名</span>
					<input class="lr_inupt" name="username" id="LoginForm_username" type="text" maxlength="16" />				</li>
				<li>
					<span>密&nbsp;&nbsp;&nbsp;码</span>
					<input class="lr_inupt" name="password" id="LoginForm_password" type="password" maxlength="20" />				</li>
				<li>
					<label class="label_css"><input checked="checked" name="remname" id="remname" type="checkbox">记住用户名</label>
					<a href="<?php echo U('Service/ticket/password');?>" class="forget_a">忘记密码？</a>
				</li>
				<li>
					<input type="button" class="l_button" onclick='submitLoginInfo()' value="">
				</li>
				<li>
					<a href="<?php echo addons_url('SyncLogin://Login/login', array('type'=>'qq')); ?>" class="lr_qq">使用QQ号登录</a>
				</li>
				</form>		
				</ul>
			<p class="reg_p">还没有<?php echo C('WEB_SITE_TITLE');?>帐号？<a href="<?php echo U('User/public/register');?>">免费注册&gt;&gt;</a></p>
		</div>
	</div>
<script>
function submitLoginInfo(){
	if(jQuery('#LoginForm_username').val().length==0 || jQuery('#LoginForm_password').val().length==0){
        $("#error_handle").show();
		return false;
      }
      $.post(U('Api/User/ajaxLogin','callback=?'),$('#login-form').serialize(),function(data){
          if(data.msg == 'success'){
                $('body').append(data.script);
                window.location.href=U('User/index/index'); 
          }else{
                var msg = data.errors;
                 if(msg == null || msg == undefined || msg=='' || msg.password || msg.username)
                      $("#error_handle").show();
          }
      },'jsonp');
  return false;
}
</script>
</body>
</html>