<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="edge">
<meta name="keywords" content="<?php echo ($meta_keywords); ?>">
<meta name="description" content="<?php echo ($meta_description); ?>">
<title><?php echo ($meta_title); ?>｜<?php echo C('WEB_SITE_TITLE'); echo C('WEB_SITE_SLOGAN');?></title>
<script type="text/javascript"><?php echo W('Common/Public/script');?></script>
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/user/css/common.css" />
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/user/css/personal.css" />
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jquery183min.js"></script>
 

<base target="_blank">
</head>
<body>
<div class="p-top">
	<div class="w980">
		<div class="p-tl">
			<a href="<?php echo U('Home/index/index');?>" target="_blank">首页</a>|<a href="<?php echo U('Game/index/index');?>" target="_blank">游戏中心</a>|<a href="<?php echo U('Shop/index/index');?>" target="_blank">积分商城</a>
		</div>
		<div class="p-tr">
			<a href="<?php echo U('User/vip/index');?>" target="_blank">VIP专区</a>|<a href="<?php echo U('Pay/index/index');?>" target="_blank">游戏充值</a>|<<a href="<?php echo U('Service/index/index');?>" target="_blank">客服中心 </a>|<a href="<?php echo U('Forum/index/index');?>" target="_blank">玩家论坛</a>|<?php if(isset($__USER__)): ?><span class="p-trname"><?php echo ($__USER__["username"]); ?></span><a href="<?php echo U('Api/User/logout',Array('refrer'=>1));?>" target="_self">[&nbsp;退出&nbsp;]</a><?php else: ?><span onclick="tan();" class="p-tologin">登录</span><?php endif; ?>

			
		</div>
	</div>
</div>
<div class="p-header">
	<div class="w980">
			<h1 class="p-sitename"><a href="/"><?php echo C('WEB_SITE_TITLE');?>游戏个人中心</a></h1>
			<div class="p-rbananer">
							<a href="<?php echo U('Gift/index/index');?>" target="_blank"><img src="/Public/theme/ad/nlacmpum.jpg" alt="banner"></a>
			</div>
	</div>
</div>

<div class="p-content">
	<?php $score=getlevel($__USER__['total_score']); $vip=getlevel($__USER__['upgrade'],true); ?>
	<div class="p-cl">
			<div class="p-ltop">
					<div class="p-userinfo">
							<div class="p-userimg"><a href="<?php echo U('User/setAvatar/index');?>"><img src="<?php echo get_cover($__USER__['avatar'],'avatar');?>" alt="<?php echo ($__USER__["username"]); ?>"><i>修改头像</i></a></div>
														<div class="p-userof">
								<div class="p-username"><a href="<?php echo U('User/profile/index');?>"><?php echo ($__USER__["username"]); ?></a></div>
																<a href="<?php echo U('User/score/index');?>" title="当前等级：LV<?php echo ($__USER__["level"]); ?>&nbsp;&nbsp;;&nbsp;&nbsp;积分：<?php echo ($__USER__["score"]); ?>" class="lv_<?php echo ($__USER__["level"]); ?>" target="_blank">LV<?php echo ($score["level"]); ?></a>
																<a href="<?php echo U('User/vip/index');?>" class="level_ico lv<?php echo ($__USER__["vip"]); ?>" title="<?php echo ($vip["title"]); ?>" target="_blank"><?php echo ($vip["title"]); ?></a>
																<?php if(!empty(C("TOGGLE_CURRENCY"))): echo C('CURRENCY_NAME');?>：<span><?php echo ($__USER__["money"]); endif; ?></span>
															</div>
					</div>
					<div class="p-check">
					<?php if(empty($__USER__["sign"])): ?><div class="p-checkb" ><em><?php echo date('m.d');?></em><span>每日签到</span></div><?php else: ?><div class="p-checka"><em><?php echo date('m.d');?></em><span>已签到</span></div><?php endif; ?>
					</div>


					<ul class="p-lnav">
						<li>
								<a href="/" class="nav0" id="CONTROLLER_INDEX" target="_self"><i class="p-nico"></i>我的首页<i class="p-rj"></i></a>
								<a href="<?php echo U('User/record/index');?>" class="nav1" id="CONTROLLER_RECORD" target="_self"><i class="p-nico"></i>游戏记录<?php if(!empty($__USER__["gameplay"])): ?><i class="p-nums"><?php echo ($__USER__["gameplay"]); ?></i><?php endif; ?><i class="p-rj"></i></a>
								<a href="<?php echo U('User/recharge/index');?>" class="nav2" id="CONTROLLER_RECHARGE" target="_self"><i class="p-nico"></i>充值记录<i class="p-rj"></i></a>
								<a href="<?php echo U('User/vip/index');?>" class="nav3" id="CONTROLLER_VIP" target="_self"><i class="p-nico"></i>我的VIP<i class="p-new"></i><i class="p-rj"></i></a>
								<a href="<?php echo U('User/score/index');?>" class="nav5" id="CONTROLLER_SCORE" target="_self"><i class="p-nico"></i>积分等级<i class="p-rj"></i></a>
					</ul>
					<ul class="p-lnav">
						<li>
								<a href="<?php echo U('User/profile/index');?>" class="nav6" id="CONTROLLER_PROFILE" target="_self"><i class="p-nico"></i>个人资料<i class="p-rj"></i></a>
								<a href="<?php echo U('User/safe/index');?>" class="nav7" id="CONTROLLER_SAFE" target="_self"><i class="p-nico"></i>帐号安全<i class="p-rj"></i></a>
						</li>
					</ul>
			</div>

			<div class="p-tit">
				<h3>快捷入口</h3>
			</div>
			<div class="p-kjwrap">
				<a target="_blank" href="<?php echo U('Service/index/index');?>" class="p-kj0">客服中心</a>
				<a target="_blank" href="<?php echo U('Shop/index/index');?>" class="p-kj1">积分游戏</a>
				<a target="_blank" href="<?php echo U('Forum/index/index');?>" class="p-kj2">火爆论坛</a>
				<a target="_blank" href="<?php echo U('Pay/index/index');?>" class="p-kj3">游戏充值</a>
			</div>
	</div>



	<div class="p-cr">
		<?php if(empty($__USER__["mobile"])): ?><div class="p-rtips">
				<div class="p-rtips-l">为了您的帐号安全，请尽快绑定手机。<a href="<?php echo U('User/safe/index');?>" target="_blank">立即绑定</a></div>
				<span class="p-rtips-c" data-type="mobile">关闭提示</span>
			</div><?php endif; ?>

             
      <div class="clearfix">
          <div class="p-w458">
              <div class="p-tit">
                  <h3>积分信息</h3>
                  <a href="<?php echo U('User/score/index');?>" class="pilinks">什么是积分？</a>
              </div>
			  
			  <?php $score=getlevel($__USER__['total_score']); ?>
              <div class="p-jfwrap">
                  <div class="p-slidetop"><a href="<?php echo U('User/score/index');?>" class="p-kscz">加速成长</a>我的等级：<span>LV<?php echo ($score["level"]); ?></span>我的积分：<span><?php echo ($__USER__["score"]); ?></span></div>
                  <div class="p-slides"><span class="p-islide" style="width:<?php echo ($score["bfb"]); ?>%" title="当前等级：LV<?php echo ($score["level"]); ?>&nbsp;&nbsp;;&nbsp;&nbsp;累计积分：<?php echo ($__USER__["total_score"]); ?>"></span></div>
                  <div class="p-slidel"><span>LV<?php echo ($score["x"]); ?> (<?php echo ($score["e"]); ?>)</span>LV<?php echo ($score["level"]); ?> (<?php echo ($score["s"]); ?>)</div>
              </div>
          </div>
          <div class="p-w265">
              <div class="p-tit">
                  <h3>VIP信息</h3>
              </div>
              <div class="p-vipwrap">
                  <div class="p-vipings">
                    <p>
                      <a target="_blank" href="<?php echo U('User/vip/index');?>" title="VIP等级：<?php echo ($vip["title"]); ?>">VIP等级<span><?php echo ($__USER__["vip"]); ?></span></a>
					  <a target="_blank" href="<?php echo U('User/vip/index');?>" title="VIP成长值：<?php echo ($__USER__["upgrade"]); ?>">成长值<span><?php echo ($__USER__["upgrade"]); ?></span></a>
                    </p>
                  </div>
                  <a target="_blank" href="<?php echo U('User/vip/index');?>" class="pilinks">如何获取VIP成长值？</a>
              </div>
          </div>
      </div>

	  <?php $_user_qiandao=D('UserSignConfig')->find(1); $taskconfig=M('Task')->select(); $task2=D('TaskLog')->isTask($__USER__['id'],13); $task3=D('TaskLog')->isTask($__USER__['id'],14); $gameurl=D('Game')->randGame(); $gameurlf=D('Game')->randGame(); ?>
      <div class="clearfix">
          <div class="p-w458">
              <div class="p-tit">
                  <h3>每日任务</h3>
                  <span class="p-subtit" title="">(<span></span>/4)</span>
              </div>
              <div class="p-task">
                  <p>
    <?php if(empty($__USER__["sign"])): ?><a href="#" id="sign-task" target="_self"><img src="/Public/theme/user/images/qd.jpg" alt="">每日签到 +<?php echo ($_user_qiandao["reward_score"]); ?>积分<span>去完成</span></a><?php else: ?><i><img src="/Public/theme/user/images/qd.jpg" alt="">每日签到 +<?php echo ($_user_qiandao["reward_score"]); ?>积分<span class="task-complete">已完成</span></i><?php endif; ?>
	
	<?php if(empty($task2)): ?><a href="<?php echo ($gameurl); ?>" target="_blank"><img src="/Public/theme/user/images/wxy.jpg" alt="">玩1款游戏 +<?php echo ($taskconfig["12"]["config"]); ?>积分<span>去完成</span></a><?php else: ?><a href="<?php echo ($gameurl); ?>" target="_blank"><img src="/Public/theme/user/images/wyx.jpg" alt="">玩1款游戏 +<?php echo ($taskconfig["12"]["config"]); ?>积分<span class="p-ywch task-complete">已完成</span></a><?php endif; ?>
	
	<?php if(empty($task3)): ?><a href="<?php echo ($gameurlf); ?>" target="_blank"><img src="/Public/theme/user/images/dp.jpg" alt="">点评1款游戏 +<?php echo ($taskconfig["13"]["config"]); ?>积分<span>去完成</span></a><?php else: ?><a href="<?php echo ($gameurlf); ?>" target="_blank"><img src="/Public/theme/user/images/dp.jpg" alt="">点评1款游戏 +<?php echo ($taskconfig["13"]["config"]); ?>积分<span class="p-ywch task-complete">已完成</span><?php endif; ?>
																					
																					
	<?php if(empty($__USER__["pay"])): ?><a href="<?php echo U('Pay/index/index');?>" target="_blank"><img src="/Public/theme/user/images/cz.jpg" alt="">每日充值+VIP成长值<span>去完成</span></a><?php else: ?><i><img src="/Public/theme/user/images/cz.jpg" alt="">每日充值+VIP成长值<span class="task-complete">已完成</span></i><?php endif; ?>	
                               
                          
                  </p>
                  
              </div>
          </div>

          <div class="p-w265">
              <div class="p-tit">
                  <h3>论坛热点</h3>
              </div>
              <div class="p-bbs">
				<?php $_result=W('Common/Game/RandGame',array(1,'UserIndexBBs'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vx): $mod = ($i % 2 );++$i;?><div class="p-bbshot"><a href="<?php echo ($vx["gameurl"]); ?>" target="_blank"><img src="<?php echo (get_cover($vx["pic"]["pic_j"])); ?>" style="height: 85px;width: 250px;" alt="<?php echo ($vx["name"]); ?>"></a></div><?php endforeach; endif; else: echo "" ;endif; ?>
                                 
                  <ul class="p-bbslist"></ul>
              </div>
          </div>
      </div>


      <div class="p-tit">
          <h3>我玩过的游戏</h3>
          <span class="p-subtit" id="myplaynums"></span>
          <a href="<?php echo U('User/record/index');?>" class="p-mores">更多</a>
      </div>
      <div class="p-pf" id="myplaybox">
          <div  class="tmycon"><ul></ul></div>
      </div>

<div class="p-tit">
          <h3>我收藏的游戏</h3>
          <span class="p-subtit" id="myfavnums"></span>
          <a href="/record" class="p-mores">更多</a>
      </div>
      <div class="p-pf" id="myfavbox">

          <div class="tmycon"><ul></ul></div>
      </div>

  </div>
	
	
	
	
	
	
	
	





</div>

<div class="p-footer">
	<p>
		<a href="<?php echo U('Service/Information/about');?>">关于我们</a>|<a href="<?php echo U('Service/Information/lianxi');?>">联系我们</a>|<a href="<?php echo U('Service/Information/cooperation');?>">游戏合作</a>|<a href="<?php echo U('Service/Information/declare');?>">版权声明</a>|<a href="<?php echo U('Service/Information/duty');?>">使用协议</a>
	</p>
	Copyright&nbsp;&nbsp;&nbsp;©2015 <?php echo strtoupper(DOMAIN());?>&nbsp;&nbsp;&nbsp;<?php echo C('WEB_SITE_ICP');?>&nbsp;&nbsp;&nbsp;
</div>

<div class="hidden">
    <div class="hidden"><?php echo C('WEB_SITE_STATISTICS');?></div>
</div>
<script type="text/JavaScript">
var CONTROLLER_NAME="<?php echo CONTROLLER_NAME;?>".toLocaleUpperCase();
var CONTROLLER_OBJ=$("#CONTROLLER_"+CONTROLLER_NAME);
var CONTROLLER_CLASS=CONTROLLER_OBJ.attr('class');
var _CLASS=CONTROLLER_CLASS+"_cur";
CONTROLLER_OBJ.addClass(_CLASS);
</script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/user/js/common.js"></script>

<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/user/js/index.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/user/js/task.js"></script>


</body>
</html>