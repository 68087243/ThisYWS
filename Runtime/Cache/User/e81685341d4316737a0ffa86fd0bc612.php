<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="edge">
<meta name="keywords" content="<?php echo ($meta_keywords); ?>">
<meta name="description" content="<?php echo ($meta_description); ?>">
<title><?php echo ($meta_title); ?>｜<?php echo C('WEB_SITE_TITLE'); echo C('WEB_SITE_SLOGAN');?></title>
<script type="text/javascript"><?php echo W('Common/Public/script');?></script>
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/user/css/logreg.css" />
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jquery183min.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jqueryyiiactiveform.js"></script>
<style>
.input_error {
    color: #FF2200;
    display: inline-block;
}
</style>
</head>
<body class="register">

	<div class="log_hd">
		<h1 class="lr_logo">
			<a href="<?php echo U('Home/index/index');?>"><?php echo domain();?>国内最大的网页游戏平台,最好玩的游戏尽在<?php echo C('WEB_SITE_TITLE');?></a>
			<i></i>
		</h1>
	</div>
	<div class="regbox">
		<div class="reg_tit">
			<h2><?php echo C('WEB_SITE_TITLE');?>用户注册</h2>
			<p>已有<?php echo C('WEB_SITE_TITLE');?>帐号？<a href="<?php echo U('User/public/login');?>">直接登陆&gt;&gt;</a></p>
		</div>
				<ul class="regis_info">
		    <form id="register-form" action="<?php echo U('Api/User/formRegister');?>" method="post">	
			<li>
				<span class="w1">用户名</span>
				<span class="w2"><input class="login_txt" name="username" id="RegisterForm_username" type="text" maxlength="15" /></span>
				<span class="w3">请保持在4-16位字符内（仅限数字，英文）</span>
				<div class="input_error" id="RegisterForm_username_em_" style="display:none"></div>			<li>
				<span class="w1">密码</span>
				<span class="w2"><input class="login_txt" name="password" id="RegisterForm_password" type="password" maxlength="20" /></span>
				<span class="w3">请保持在6-20个字符内，推荐使用英文加数字或符号的组合密码</span>
				<div class="input_error" id="RegisterForm_password_em_" style="display:none"></div> 
			<li>
				<span class="w1">重复密码</span>
				<span class="w2"><input class="login_txt" name="repassword" id="RegisterForm_repassword" type="password" /></span>
				<span class="w3">请再次输入密码</span>
				<div class="input_error" id="RegisterForm_repassword_em_" style="display:none"></div>			<li>
				<span class="w1">姓名</span>
				<span class="w2"><input class="login_txt" name="realName" id="RegisterForm_realName" type="text" maxlength="5" /></span>
				<span class="w3"></span>
				<div class="input_error" id="RegisterForm_realName_em_" style="display:none"></div>			<li>
				<span class="w1">身份证号码</span>
				<span class="w2"><input class="login_txt" name="cardId" id="RegisterForm_cardId" type="text" maxlength="18" /></span>
				<span class="w3"></span>
				<div class="input_error" id="RegisterForm_cardId_em_" style="display:none"></div>			<li>
				<span class="w4"><label class="labelcss"><input class="checkboxcsss" checked="checked" name="obj" id="RegisterForm_obj" value="1" type="checkbox" />我已阅读并同意<a href="<?php echo U('Service/Information/yhxy');?>" target='_blank'>《<?php echo C('WEB_SITE_TITLE');?>用户协议》</a>
				<div class="input_error" id="RegisterForm_obj_em_" style="display:none"></div> 
				</label></span>
			<li><input class="r_button" value="" type="submit" name="yt0" />      
						</form>		</ul>	
	</div>
	<div style="height:400px"></div>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/user/script/register.js"></script>
</body>
</html>