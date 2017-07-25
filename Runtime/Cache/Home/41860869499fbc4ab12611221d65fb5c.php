<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="edge">
<meta name="keywords" content="<?php echo ($meta_keywords); ?>">
<meta name="description" content="<?php echo ($meta_description); ?>">
<title><?php echo C('WEB_SITE_TITLE'); echo C('WEB_SITE_SLOGAN');?></title>
<?php echo hook("PageHeader");?>

<script type="text/javascript">
<?php echo W('Common/Public/script');?>
</script>
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/common.css" />
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jquery183min.js"></script>

<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/index.css" />


<base target="_blank">
</head>
<body>
<div class="w-topbar">
	<div class="w-topbarm">
		<div class="w-tl">
			<a href="<?php echo U('Game/index/index');?>" target="_blank">游戏首页</a>|<a href="<?php echo U('News/Read/2');?>" target="_blank">长期招募</a>|<a href="<?php echo U('News/Read/1');?>" target="_blank">免费福利</a>|<a href="<?php echo U('Forum/index/index');?>" target="_blank">游戏社区</a>
		</div>
		<div class="w-tr" id="w-baright">
			<div class="w-favall">
				<a href="#" target="_self" id="sitefav">加入收藏</a>|<a target="_blank" href="<?php echo U('Home/index/desktop');?>">保存到桌面</a>
			</div>
			<div class="w-twrap" id="w-thotId">
				<span class="w-twrapbtn">热门游戏</span>
				<div class="w-twrapsub">
					<div class="w-twrapbox">
						<ul class="w-thotgames">
						</ul>
					</div>
					<div class="w-thotico">
					</div>
				</div>
			</div>
			<div id="w-tmyplayId" class="w-twrap w-tmypb">
				<span class="w-twrapbtn">我玩过的</span>
				<div class="w-twrapsub">
					<div class="w-twrapbox">
						<?php if(isset($__USER__)): ?><div class="w-myplay">
						</div>
						<a href="<?php echo U('User/record/index');?>" class="w-mpmore" target="_blank">查看更多</a>
						<?php else: ?>
						<div class="w-pno_tp">
							<span>请<a href="#" target="_self" id="w-tplog">登录</a>后查看游戏记录</span>
						</div><?php endif; ?>
					</div>
					<div class="w-thotico">
					</div>
				</div>
			</div>
			<div class="w-favall" id="w-favall">
				<?php if(!isset($__USER__)): ?><a href="#" target="_self" id="w-log">登录</a>|<a href="#" target="_self" id="w-reg">注册</a>|<?php endif; ?>
			</div>
			<div id="w-tmyId" class="w-twrap w-tmypb">
				<?php if(isset($__USER__)): ?><span class="w-twrapbtn"><?php echo ($__USER__["username"]); ?></span>
				<div class="w-twrapsub">
					<div class="w-twrapbox">
						<div class="w-nameinfo">
						</div>
						<ul class="w-infosub">
						</ul>
					</div>
					<div class="w-thotico">
					</div>
				</div><?php endif; ?>
			</div>
		</div>
	</div>
</div>
<div class="w-nav">
        <div class="w-navwrap">
                <h1><a href="<?php echo U('Home/index/index');?>" class="w-logo"><?php echo C('WEB_SITE_TITLE');?></a></h1>
                <div class="w-navcon">
                        <div class="w-nav_a">
                                                <a target="_self" id="NAV_HOME" href="<?php echo U('Home/index/index');?>">首页</a>    
                                                <a target="_self" id="NAV_GAME" href="<?php echo U('Game/index/index');?>">游戏中心</a>    
                                                <a target="_blank" id="NAV_USER" href="<?php echo U('User/index/index');?>">个人中心</a>    
                                                <a target="_self" id="NAV_PAY" href="<?php echo U('Pay/index/index');?>">充值</a>    
                                                <a target="_self" id="NAV_NEWS" href="<?php echo U('News/index/index');?>">资讯</a>    
                                                <a target="_self" id="NAV_GIFT" href="<?php echo U('Gift/index/index');?>">礼包</a>    
                                                <a target="_self" id="NAV_SERVICE" href="<?php echo U('Service/index/index');?>">客服</a>    
                                                </div>
                        <div class="w-navdonw" id="w-navdown">
                            <span class="w-navtxtp">下载客户端</span>
                            <div class="w-navdrop">
                                <a href="javascript:alert('工程师努力开发中');" class="w-n-pc">PC客户端</a>
                                <a href="javascript:alert('工程师努力开发中');" class="w-n-mb">移动客户端</a>
                            </div>
                        </div>
                </div>
        </div>
</div>


<div class="w-focus" id="w-focusimg">
	<ul>
		<?php $Slidelist=D('Slide')->Slidelist(4); ?>
		<?php if(is_array($Slidelist)): $i = 0; $__LIST__ = $Slidelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="background-image:url(<?php if(empty($vo["pic"])): echo ($vo["url"]); else: echo (get_cover($vo["pic"])); endif; ?>)">
		<a title="<?php echo ($vo["name"]); ?>" href="<?php echo ($vo["onclick_url"]); ?>"></a><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
	<div class="w-focusbtn">
		<i class="cur"></i>
		<i></i>
		<i></i>
		<i></i>
	</div>
</div>
<div class="w-block">
        <div class="w-log" id="pop-wrap">
                <iframe width="266px" height="288px" scrolling="no" framemargin="0" frameborder="0" allowtransparency="true" src="<?php echo U('Api/User/loginbox');?>"></iframe>
        </div>
</div>
<div class="w-wrap">
	<div class="w-section">
		<div class="w-tit">
			<h2 class="w-tit-tjyx">推荐游戏</h2>
			<ul class="w-notice" id="w-notices">
				<?php $_result=W('Common/Horn/getHorn',array(5,'Smallspeakers'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="w-tjyxwrap" id="w-tjyxbox">
			<div class="w-slides">
				<ul>
					<?php if(is_array($Game["tjyx"])): $i = 0; $__LIST__ = $Game["tjyx"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
					<div class="w-slidecon">
						<a href="<?php echo D('Game')->getGameUrl($vo['id']); ?>" class="w-slideimg"><img src="<?php if(empty($vo["pic"]["pic_t"])): ?>/Public/theme/empty/empty250.png<?php else: echo (get_cover($vo["pic"]["pic_t"])); endif; ?>"></a>
						<div class="w-slidebcon">
							<a class="w-jqyxplay" href="<?php echo D('Gameserver')->getNewServerUrlBygid($vo['id']);?>"><i></i>进入新区</a>
							<h3><a href="<?php echo D('Game')->getGameUrl($vo['id']); ?>"><?php echo ($vo["name"]); ?></a></h3>
							<p><?php if(empty($vo["summary"])): $_rand=rand(0,1); if(empty($_rand)): echo ($vo["name"]); ?> 霸业再现<?php else: echo ($vo["name"]); ?> 经典再现<?php endif; else: echo ($vo["summary"]); endif; ?></p>
						</div>
						<?php if(!empty($vo["flags"]["r"])): ?><i class="w-jqyxicoh"></i><?php else: if(!empty($vo["flags"]["x"])): ?><i class="w-jqyxicon"></i><?php endif; endif; ?>
					</div>
					<div class="w-slidebg">
					</div>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<a target="_self" class="w-leftbtn" href="#"></a><a target="_self" class="w-rightbtn" href="#"></a>
		</div>
		<div class="w-tit mtop15">
			<h2 class="w-tit-jpyx">精品游戏</h2>
			<a href="<?php echo U('Game/index/index');?>" class="w-rmore">更多</a>
		</div>
		<ul class="w-jpyxitem">
			<?php if(is_array($Game["jpyx"])): $i = 0; $__LIST__ = $Game["jpyx"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
			<div class="w-jpyxbg">
				<a href="<?php echo D('Game')->getGameUrl($vo['id']); ?>" class="w-imglink">
				<img a="<?php if(empty($vo["pic"]["pic_j"])): ?>/Public/theme/empty/empty250.png<?php else: echo (get_cover($vo["pic"]["pic_j"])); endif; ?>" alt="<?php echo ($vo["name"]); ?>">
				<?php if(!empty($vo["flags"]["r"])): ?><i class="w-jqyxicoh"></i><?php else: if(!empty($vo["flags"]["x"])): ?><i class="w-jqyxicon"></i><?php endif; endif; ?>
				</a>
				<div class="w-jqyxb">
					<a href="<?php echo D('Game')->getGameUrl($vo['id']); ?>" class="w-jqyxplay"><i></i>开始游戏</a>
					<a href="<?php echo D('Game')->getGameUrl($vo['id']); ?>"><?php echo ($vo["name"]); ?></a>
				</div>
			</div>
			<i class="w-jpyxpngbg"></i>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div class="w-article">
		<div class="w-tit">
                        <h2 class="w-tit-jjkf">即将开服</h2>
                        <div class="w-kfitemtab" id="jjkfbtns"></div>
        </div>
		<div class="w-jjkflist" id="jjkfcons">
         </div>
		<div class="w-tit">
                        <h2 class="w-tit-newkf">最新开服</h2>
                        <div class="w-kfitemtab" id="newkfbtns"></div>
        </div>
		<div class="w-jjkflist" id="newkfcons">
		</div>
	</div>
</div>


<div class="w-indexm">
        <div class="w-section"><div class="w-tit"><h2 class="w-tit-rmyx">热门游戏</h2><a href="<?php echo U('Game/index/index');?>" class="w-rmore">更多</a></div><ul class="w-rmyx"><?php if(is_array($Game["rmyx"])): $i = 0; $__LIST__ = $Game["rmyx"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo D('Game')->getGameUrl($vo['id']); ?>" class="w-rmyxg"><img a="<?php if(empty($vo["pic"]["pic_r"])): ?>/Public/theme/empty/empty123.png<?php else: echo (get_cover($vo["pic"]["pic_r"])); endif; ?>" alt="<?php echo ($vo["name"]); ?>"><em><?php echo ($vo["name"]); ?></em></a>
                                <div class="w-rmyxbtns"><a href="<?php echo D('Game')->getGameUrl($vo['id']); ?>" class="w-rmyxplay"><span>开始游戏</span><i></i></a><p><a href="<?php echo U('Gift/'.$vo['mark'].'/index');?>">新手卡</a><a href="<?php echo U('Forum/'.$vo['mark'].'/index');?>">游戏论坛</a></p></div></li><?php endforeach; endif; else: echo "" ;endif; ?></ul>
        </div>

        <div class="w-article">
                <div class="w-tit">
                        <h3 class="w-tit-bzzx" id="w-bzzxtab">
                            <span class="cur">新闻公告</span>
                            <span>常见问题</span>
                        </h3>
                        <a href="<?php echo U('News/index/index');?>" class="w-rmore">更多</a>
                </div>
                <div class="w-artcons">
                        <div class="w-bzzx">
                                <div class="w-bzzxitem" id="w-bzzxcon">
									<p>
										<?php $_result=W('Common/Document/getListByCid',array(6,false,'HomePlatformNews'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('News/Read/'.$vo['id']);?>"><span><i><?php echo ($i); ?></i></span><?php echo ($vo["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </p>
                                    <p class="hidden">
										<?php $_result=W('Common/Document/getListByCid',array(6,4,'HomeHelpCenter'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('News/Read/'.$vo['id']);?>"><span><i><?php echo ($i); ?></i></span><?php echo ($vo["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
									</p>
                                </div>
                               <div class="w-kflianxi">
                                        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('WEB_SITE_QQ');?>&site=qq&menu=yes" class="w-kfonline">联系在线客服</a>
                                        <div class="w-kr">
                                                <b class="w-kqq"><?php echo C('WEB_SITE_QQ');?></b>
                                                <b class="w-kiphoe"><?php echo C('WEB_SITE_MOBILE');?></b>
                                                <p>周一到周日 9:00至21:00</p>
                                        </div>
                                </div>
                        </div>

                       <ul class="w-rbanans">
                       			<?php $bgad=M('Bgad')->select(); ?>
                                <li><a href="<?php echo ($bgad["2"]["url"]); ?>"><img src="<?php echo (get_cover($bgad["2"]["pic"])); ?>" style="width:300px;height:95px;"></a>
                        </li>
                </div>
        </div>
</div>

<div class="w-tit w-gtit"><h2 class="w-tit-selectyx">游戏列表</h2><a href="<?php echo U('Game/index/index');?>"class="w-rmore">更多</a><div class="w-selgames">按首字母：<span id="selecthand"><i class="cur">不限</i><?php $GAME_INITIALS_LIST=C('GAME_INITIALS_LIST'); if(is_array($GAME_INITIALS_LIST)): $i = 0; $__LIST__ = $GAME_INITIALS_LIST;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><i><?php echo ($vo); ?></i><?php endforeach; endif; else: echo "" ;endif; ?></span></div></div>
<ul class="w-allgames" id="allGames">
<?php $GAME_TYPE_LIST=C('GAME_TYPE_LIST'); ?>
<?php if(is_array($GAME_TYPE_LIST)): $k = 0; $__LIST__ = $GAME_TYPE_LIST;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li><h3><?php echo ($vo); ?></h3><div class="gcons"><p><?php if(is_array($Game["all"])): $i = 0; $__LIST__ = $Game["all"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vog): $mod = ($i % 2 );++$i; if(in_array(($vog["type"]), is_array($k)?$k:explode(',',$k))): ?><a href="<?php echo D('Game')->getGameUrl($vog['id']); ?>" v="<?php echo strtolower(pinyin($vog['name'],true));?>"><img alt="<?php echo ($vog["name"]); ?>"a="<?php if(empty($vog["pic"]["pic_icon"])): ?>/Public/theme/empty/emptyicon.png<?php else: echo (get_cover($vog["pic"]["pic_icon"])); endif; ?>"><?php echo ($vog["name"]); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; ?></p></div></li><?php endforeach; endif; else: echo "" ;endif; ?>
							
</ul>

<script type="text/JavaScript">
//解决allGame错位
$("#allGames>li>.gcons>p").each(function(i,n){
    if(n.innerHTML =="" || n.innerHTML==null ){
	  n.innerHTML="&nbsp;";
	}
})
</script>
<div class="w-tit w-gtit">
        <h2 class="w-tit-wjfc">合作联盟</h2>
        <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('WEB_SITE_QQ');?>&site=qq&menu=yes" class="w-rmore">互换</a>
        <a class="w-myup" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('WEB_SITE_QQ');?>&site=qq&menu=yes">排名不分先后</a>
</div>

	<div class="w-wjfc" id="w-wjfcbox">
        <div class="w-wjfcwrap">
            <ul>
            				
            				<?php if(is_array($style)): $i = 0; $__LIST__ = $style;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
								<a href="<?php echo ($vo["url"]); ?>"><img alt=" 1区 无痕" a="<?php echo (get_cover($vo["pic"])); ?>"><span><?php echo ($vo["name"]); ?> </span></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>

                              </ul>
        </div>
<a target="_self" class="w-leftbtn" href="#"></a><a target="_self" class="w-rightbtn" href="#"></a></div>

<!-- 右下角弹窗广告  -->
<style>
*{ margin:0; padding:0; list-style:none; text-align:left;}
a{font-size:12px; color:#666; text-decoration:none;}

.lanrenzhijia{ width:260px; height:160px;   position:fixed; right:-300px; bottom:10px;}
.lanrenzhijia .close{ width:30px; height:22px; line-height:22px;display:block; float:right;}
</style>
<script src="js/jquery.min.js"></script>
<script>
$(function (){
$('.lanrenzhijia').animate({right:'10px'},1000);
$('.lanrenzhijia .close').click(function(){
   $('.lanrenzhijia').hide();
});
});
</script>  

<div class="lanrenzhijia"><a href="<?php echo ($bgad["5"]["url"]); ?>"><img src="<?php echo (get_cover($bgad["5"]["pic"])); ?>" wdith="260px" height="160px" /></a><a href="javascript:" style="position: absolute;top:-0px;right:0px;" class="close">关闭</a></div>
<!-- 右下角弹窗广告end  -->

<!-- 分享  -->
<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>




<div class="w-friends"><p><strong>友情链接：</strong><?php echo W('Common/Public/link');?></p></div>
<?php $bgad=M('Bgad')->select(); ?>
<a href="<?php echo ($bgad["0"]["url"]); ?>" class="bgad_l"><img src="<?php echo (get_cover($bgad["0"]["pic"])); ?>" alt="<?php echo ($bgad["0"]["name"]); ?>"></a><a href="<?php echo ($bgad["1"]["url"]); ?>" class="bgad_r"><img src="<?php echo (get_cover($bgad["1"]["pic"])); ?>" alt="<?php echo ($bgad["1"]["name"]); ?>"></a>  



<div class="w-ftwrap"><div class="w-fnav"><div class="w-fnavbox"><div class="w-fnav-w"><h5 class="w-fnav-z">帐号服务</h5><ul><li><a target="_blank" href="<?php echo U('User/Public/register');?>">帐号注册</a></li><li><a target="_blank" href="<?php echo U('User/safe/index');?>">修改密码</a></li><li><a target="_blank" href="<?php echo U('User/safe/index',array('t'=>'yxyz'));?>">绑定邮箱</a></li><li><a target="_blank" href="<?php echo U('Service/ticket/10');?>">找回帐号</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-k">客服中心</h5><ul><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">客服首页</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">论坛交流</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">常见问题</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">在线客服</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-r">热门游戏</h5><ul><?php $_result=W('Common/Game/RecommendedGame',Array('j',4,'IndexFooterRecomme11'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ig): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo ($ig["gameurl"]); ?>"><?php echo ($ig["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="w-fnav-w w-fnav-long"><h5 class="w-fnav-c">旗下站点</h5><ul><li><a target="_blank" href="<?php echo U('Home/index/index');?>">网页游戏</a></li><li><a target="_blank" href="<?php echo U('Game/index/index');?>">游戏大全</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">交流论坛</a></li><li><a target="_blank" href="<?php echo U('Shop/index/index');?>">积分商城</a></li></ul></div></div></div><div class="w-footer">抵制不良游戏，拒绝盗版游戏。 注意自我保护，谨防受骗上当。 适度游戏益脑，沉迷游戏伤身。 合理安排时间，享受健康生活。<p><a href="<?php echo U('Service/Information/about');?>" target="_blank">关于我们</a>|<a href="<?php echo U('Service/Information/lianxi');?>" target="_blank">联系我们</a>|<a href="<?php echo U('Service/Information/cooperation');?>" target="_blank">游戏合作</a>|<a href="<?php echo U('Service/Information/declare');?>" target="_blank">版权声明</a>|<a href="<?php echo U('Service/Information/duty');?>" target="_blank">使用协议</a></p><span>Copyright</span><span>©2015</span><span><?php echo strtoupper(DOMAIN());?></span><span><?php echo C('WEB_SITE_ICP');?></span></div></div>

<div class="hidden">
    <div class="hidden"><?php echo C('WEB_SITE_STATISTICS');?></div>
	<?php if(!empty($gamedata["script_code"])): echo ($gamedata["script_code"]); ?><br><?php endif; ?> 
</div>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/index.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/common.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/t3t2_popup_plus.js"></script>
<script type="text/javascript">
var MODULE_NAME='<?php echo MODULE_NAME;?>'.toUpperCase();
$('#NAV_'+MODULE_NAME).addClass('cur');
</script>
<style>.tb_button {padding:1px;cursor:pointer;border-right: 1px solid #8b8b8b;border-left: 1px solid #FFF;border-bottom: 1px solid #fff;}.tb_button.hover {borer:2px outset #def; background-color: #f8f8f8 !important;}.ws_toolbar {z-index:100000} .ws_toolbar .ws_tb_btn {cursor:pointer;border:1px solid #555;padding:3px}   .tb_highlight{background-color:yellow} .tb_hide {visibility:hidden} .ws_toolbar img {padding:2px;margin:0px}</style>

</body>
</html>