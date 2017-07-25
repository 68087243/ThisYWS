<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7">
<title>login iframe</title>
<meta name="description" content="login iframe">
<meta name="keywords" content="login iframe">
<script type="text/javascript">
<?php echo W('Common/Public/script');?>
</script>
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/user/css/login.css" />
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jquery183min.js"></script>
<style>
#page-loader{
    position: fixed;
    top:0;
    left:0;
    bottom: 0;
    right: 0;
    background: #fff;
    z-index: 99999;
}

#page-loader .page-loader-gif{
    display: block;
    width:100%;
    height:64px;
    position: absolute;
    top:50%;
    left:0;
    margin:-32px 0 0;
    font-size:21px;
    line-height:58px;
    font-family:Raleway;
    font-weight:400;
    text-align: center;
    color:#aaa;
    color:rgba(0,0,0,0.2);
    background-image: url("data:image/gif;base64,R0lGODlhPAA7APcAAP////7+/icnJ/39/fz8/Pv7+/r6+vn5+ff39/j4+Pb29vHx8fT09PPz8+zs7O/v7+jo6Obm5vDw8PX19efn5+Pj4yoqKvLy8jo6OsXFxdXV1UBAQN7e3tLS0urq6srKyu7u7tnZ2TU1NS8vL9bW1t/f30VFRenp6e3t7dPT0+vr6+Tk5NfX12FhYSgoKCwsLNra2tHR0bS0tFZWVtvb26SkpOLi4tjY2Nzc3M/Pz6+vr6mpqdDQ0K6urjAwMFhYWC0tLZmZmeDg4Jubmzg4OOXl5bq6uktLS42NjZ6enrKysjMzM5OTk7i4uISEhLu7u8nJyVFRUcjIyDIyMsDAwGhoaFJSUry8vIuLi7CwsCkpKZ2dnZycnEFBQTY2NsfHx8TExEpKSr+/v2ZmZsbGxnp6eq2trbe3t8PDw15eXnJycrOzszExMVxcXFlZWeHh4bm5uYKCgjk5OX19faCgoD4+Pnl5eYiIiDQ0NKOjo2dnZ0lJSVpaWt3d3YaGhqampm9vb0NDQ9TU1L29vbGxscvLy3V1dU5OTszMzJaWloWFhWtra2RkZHZ2disrK2NjY4+Pj1tbW4GBgXd3d5+fn21tbaurq0hISHx8fH5+fqqqqi4uLoCAgGxsbExMTKKiopCQkIeHh6ioqFVVVWpqamVlZZqamoODg83Nzaenp11dXT09PVRUVHh4eKGhoTc3N1dXV6WlpUJCQkRERE9PT5GRkY6OjmJiYra2tlNTU5SUlH9/f5KSkrW1tb6+vomJiaysrJWVlYyMjF9fX3FxcVBQUHNzc3t7e01NTT8/P2BgYJeXl2lpaXBwcM7OzoqKikZGRsLCwkdHRzw8PHR0dMHBwZiYmDs7O25ubgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/wtYTVAgRGF0YVhNUDw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo5NzNGMTI0OUEwOUZFMzExQUEwREUzM0ZFQjU5QTFGOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo4NzI3QUEzQ0M1OEIxMUUzOTUwMjg5RkYyREQ5MUE2QSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo4NzI3QUEzQkM1OEIxMUUzOTUwMjg5RkYyREQ5MUE2QSIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjdCMzc4NDg5Qzc5RkUzMTE5MDczOENCNTZFMjFEMjk1IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjk3M0YxMjQ5QTA5RkUzMTFBQTBERTMzRkVCNTlBMUY4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Af/+/fz7+vn49/b19PPy8fDv7u3s6+rp6Ofm5eTj4uHg397d3Nva2djX1tXU09LR0M/OzczLysnIx8bFxMPCwcC/vr28u7q5uLe2tbSzsrGwr66trKuqqainpqWko6KhoJ+enZybmpmYl5aVlJOSkZCPjo2Mi4qJiIeGhYSDgoGAf359fHt6eXh3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");    
	background-repeat: no-repeat;
	background-position-x: 50%;
	background-position-y: 0px;
}


</style>
<base target="_blank">
</head>
<body>
<div id="page-loader"><span class="page-loader-gif">Loading...</span></div>
<?php if(isset($__USER__)): ?><div class="toubox">
        <a href="<?php echo U('User/Index/Index');?>" class="tou-a"><img src="<?php echo get_cover($__USER__['avatar'],'avatar');?>"></a>
        <div class="p-namebox">
                <div class="p-name">
                        <a href="<?php echo U('Api/User/logout');?>" class="tuichu" target="_self">退出</a>
                                                <a href="<?php echo U('User/Index/Index');?>" class="u-name"><?php echo ($__USER__["username"]); ?></a>
                </div>
                <div class="p-vip">
                        <a href="<?php echo U('User/score/index');?>" class="lv_ico"></a>
                        <a href="<?php echo U('User/vip/index');?>"  class="level_ico"></a>
                        <a href="<?php echo U('User/vip/index');?>" class="lvalinks" id="info">加速成长</a>
                </div>
        </div>
</div>
<ul class="p-infos">
        <li><a href="<?php echo U('User/record/index');?>"  id="gamesShow"><span>0</span>游戏记录</a>
        <li><a href="<?php echo U('User/vip/index');?>" id="valueShow"><span>0</span>VIP成长值</a>
        <li class="bgnone"><a href="<?php echo U('User/gift/index');?>" id="packsShow"><span>0</span>礼包数</a>
</ul>
<div class="ser-tit">
        <a href="<?php echo U('User/record/index');?>">更多</a>上次玩过的区服
</div>
<div class="ser-con">

</div>
<?php if(empty($userinfo["email"])): ?><div class="band-tp" id="band-tp">
		<div class="band-tt">
			<i id="band_close"></i>
		</div>
		<div class="band-tx">
			<p><i></i>您尚未绑定密保邮箱，</p>
			<p>帐号安全存在风险，建议您尽快<a href="<?php echo U('User/safe/index',array('t'=>'yxyz'));?>">绑定邮箱</a>。</p>
		</div>
	</div><?php endif; ?>
<div class="p-btns">
        <a href="<?php echo U('User/index/index');?>" class="profiles">个人中心</a>
        <i></i>
        <a href="<?php echo U('Game/index/index');?>" class="gamehome">游戏大厅</a>
</div>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/user/script/after.js"></script>


<?php else: ?>

<form target="_self" id="login-form" action="<?php echo U('Api/User/ajaxLogin');?>" method="post">            <div class="nambox">
                    <input name="username" id="LoginForm_username" type="text" maxlength="16" value="<?php if(isset($_COOKIE['CT_remname'])): echo (cookie('remname')); else: ?>请输入用户名<?php endif; ?>" />
           </div>
            <div class="pasbox">
                <input class="password" name="password" id="LoginForm_password" type="password" maxlength="20" />                <span id="passtips">请输入密码</span>
                <input type="hidden" checked name="remember" id="cook" value='1'>
            </div>
            <div class="npbox">
                    <a href="<?php echo U('Service/ticket/password');?>">找回密码？</a>
                    <label><input checked type="checkbox" value="0" name="remname" id="remname">记住用户名</label>
            </div>
            <div class="login-tips"></div>
            <div class="subbox">
                <input type='button' id='submit_login' class='sub-css' value='立即登录' onclick='submitLoginInfo()'>
                <p class="hidden"><img src="/Public/theme/user/images/loading.gif">正在登陆...</p>
            </div>
            <div class="mianfei"><a href="<?php echo U('User/Public/register');?>" class="mian-btn">免费注册</a><a href="<?php echo addons_url('SyncLogin://Login/login', array('type'=>'qq')); ?>" class="qq-btn">使用QQ号登录</a></div>
            <div class="login-tips hidden"><i></i><span>用户名或密码错误</span></div>
            </form>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/user/script/login.js"></script><?php endif; ?>
<script>
$(document).ready(function() {
	$(window).load(function(){
		$('#page-loader').fadeOut(500);
	});	
});
</script>	
</body>
</html>