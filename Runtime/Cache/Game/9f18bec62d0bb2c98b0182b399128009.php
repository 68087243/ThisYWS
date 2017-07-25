<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="edge">
<meta name="keywords" content="<?php echo ($meta_keywords); ?>">
<meta name="description" content="<?php echo ($meta_description); ?>">
<title><?php echo ($meta_title); ?>｜<?php echo C('WEB_SITE_TITLE');?>－<?php echo C('WEB_SITE_SLOGAN');?></title>
<?php echo hook("PageHeader");?>

<script type="text/javascript">
<?php echo W('Common/Public/script');?>
</script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jquery183min.js"></script>
	<style type="text/css">
		.topbox{
			background: -moz-linear-gradient(top, rgba(255,255,255,0) 80%, #EFEFEF),url(<?php echo (get_cover($gamedata["pic"]["pic_site_bg"])); ?>) no-repeat center;
			background: -webkit-linear-gradient(top, rgba(255,255,255,0) 80%, #EFEFEF),url(<?php echo (get_cover($gamedata["pic"]["pic_site_bg"])); ?>) no-repeat center;
			background: -o-linear-gradient(top, rgba(255,255,255,0) 80%, #EFEFEF),url(<?php echo (get_cover($gamedata["pic"]["pic_site_bg"])); ?>) no-repeat center;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/index.css" />
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/common.css" />



	<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/game.css" />
	<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/allstyle.css" />



</head>
<body>
<div class="w-topbar">
	<div class="w-topbarm">
		<div class="w-tl">
			<a href="<?php echo U('Game/index/index');?>" target="_blank">游戏首页</a>|<a href="<?php echo U('User/Vip/index');?>" target="_blank">VIP中心</a>|<a href="<?php echo U('Shop/index/index');?>" target="_blank">积分商城</a>|<a href="<?php echo U('Forum/index/index');?>" target="_blank">游戏论坛</a>
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
<div class="w-nav" style="display:none;">
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
                                <a href="#" class="w-n-pc">PC客户端</a>
                                <a href="#" class="w-n-mb">移动客户端</a>
                            </div>
                        </div>
                </div>
        </div>
</div>


<div class="topbox">

</div>
<div class="conbox">
	<div class="leftbox">
		<div class="start">
			<object height="100%" width="100%" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" id="abcdef">
				<param value="/Public/theme/images/start.swf" name="movie">
				<param value="high" name="quality">
				<param value="transparent" name="wmode">
				<param value="always" name="allowScriptAccess">
				<embed height="100%" width="100%" name="abcdef" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" quality="high" src="/Public/theme/images/start.swf">
			</object>
		</div>
		<div class="twobtn">
			<a href="<?php echo ($gamedata["clienturl"]); ?>"><i></i>微端下载</a>
			<a href="<?php echo U('Pay/index/'.$gamedata['id']);?>"><i class="i02"></i>游戏充值</a>
		</div>
		<div class="userbox">
			<iframe width="300px" height="140px" scrolling="no" framemargin="0" frameborder="0" allowtransparency="true" src="<?php echo U('Api/User/Gamebox',Array('gid'=>$gamedata['id']));?>"></iframe>
		</div>
		<div class="infolup">
			<p class="infop1">游戏简介</p>
			<p class="infop2"><?php echo strip_tags($gamedata['description']); ?></p>
		</div>
		<div class="bc">
			<div class="kf_tt">
				<h2>贴心客服</h2>
			</div>
			<div class="kf_cc">
				<p class="kf_p">
					客服热线：<?php echo C('WEB_SITE_MOBILE');?><br>
					客服QQ：<?php echo C('WEB_SITE_QQ');?><br>
					<?php if(!empty($gamedata["qqgroup"])): ?>QQ群：<?php echo ($gamedata["qqgroup"]); ?><br><?php endif; ?> 
					服务时间：7×24小时<br>
					客服：<a href="<?php echo U('Service/Index/index');?>">在线客服</a>
				</p>
			</div>
		</div>
	</div>

	<div class="rightbox">
		

	<div class="serves">
		<div class="recmend">
			<p class="p3">推荐服务器</p>
			<span id="favg" class="favg <?php echo W('Common/Game/isGameCollects',array($__USER__['id'],$gamedata['id']));?>" data-gid="<?php echo ($gamedata["id"]); ?>" title="收藏"></span>
			<div class="servesenter">
				<a href="<?php echo U($gamedata['mark'].'/server');?>"  class="enter">更多服务器</a>
			</div>
		</div>
		<div class="recmendserv">
			<ul class="J_hot_server">
			<?php $_result=W('Common/Game/getNewServerBygid',Array($gamedata['id'],3,'PublicTheme_num4_getNewServerBygid_2016'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ig): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($ig["gameurl"]); ?>" target="_blank"><em class="fb">火爆</em><?php echo ($ig["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul>
		</div>
		<div class="choice"></div>

		<div class="infom">
			<div class="infonav">
				<ul class="navtitle clearfix">
					<li>
						<a href="javascript:void(0);">综合</a>
					</li>
					<?php $__CATEGORYLIST__ = D('Category')->getCategoryTree(0, 1,false,1 ,3 ); if(is_array($__CATEGORYLIST__)): $i = 0; $__LIST__ = $__CATEGORYLIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$side_category): $mod = ($i % 2 );++$i;?><li>
							<a href="javascript:void(0);"><?php echo (mb_substr($side_category["title"],2,2,'utf-8')); ?></a>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<div class="slide">
					<div class="list"></div>
				</div>
				<div class="tab_more">
					<a href="<?php echo U($gamedata['mark'].'/news_list');?>">更多+</a>
				</div>
			</div>

			<div class="infonavcon">
				<ul>
					<?php $_result=W('Common/Document/getNewsListByGid',Array($gamedata['id'],false,5,'PublicTheme_getNewsListByGid_2016_5_false_1'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
						<?php if(($i) == "1"): ?><a target="_blank" class="gonggaotopone" href="<?php echo U($gamedata['mark'].'/news_read',Array('id'=>$vo['id']));?>">
								<font style="color:#FF0000;"><?php echo ($vo["title"]); ?></font></a>
						<?php else: ?>
							<a target="_blank" href="<?php echo U($gamedata['mark'].'/news_read',Array('id'=>$vo['id']));?>">
								<font><?php echo ($vo["title"]); ?></font></a>
							<i><?php echo (date("m-d",$vo["ctime"])); ?></i><?php endif; ?>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<?php $__CATEGORYLIST__ = D('Category')->getCategoryTree(0, 1,false,1 ,3 ); if(is_array($__CATEGORYLIST__)): $i = 0; $__LIST__ = $__CATEGORYLIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$side_category): $mod = ($i % 2 );++$i;?><div class="infonavcon">
					<ul>
						<?php $_result=W('Common/Document/getNewsListByGid',Array($gamedata['id'],$side_category['id'],5,'PublicTheme_getNewsListByGid_2016_5_false_2'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
								<a target="_blank" href="<?php echo U($gamedata['mark'].'/news_read',Array('id'=>$vo['id']));?>">
									<font style="color:#FF0000;"><?php echo ($vo["title"]); ?></font>
								</a>
								<i><?php echo (date("m-d",$vo["ctime"])); ?></i>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>

		<div class="infor">
			<ul>
				<li>
					<a href="<?php echo U('Service/Index/index');?>">
						<i class="nav1 navli"></i>
						<p class="navword">在线客服</p>
					</a>
				</li>
				<li>
					<a href="<?php echo U('Pay/index/'.$gamedata['id']);?>">
						<i class="nav2 navli"></i>
						<p class="navword">在线充值</p>
					</a>
				</li>
				<li>
					<a href="<?php echo U($gamedata['mark'].'/news_list',Array('cid'=>6));?>">
						<i class="nav3 navli"></i>
						<p class="navword">游戏公告</p>
					</a>
				</li>
				<li>
					<a href="<?php echo U($gamedata['mark'].'/server');?>">
						<i class="nav4 navli"></i>
						<p class="navword">开服排期</p>
					</a>
				</li>
				<li>
					<a href="<?php echo U('Forum/'.$gamedata['mark'].'/index');?>">
						<i class="nav5 navli"></i>
						<p class="navword">论坛交流</p>
					</a>
				</li>
				<li>
					<a href="<?php echo U($gamedata['mark'].'/news_list',Array('cid'=>5));?>">
						<i class="nav5 navli"></i>
						<p class="navword">游戏攻略</p>
					</a>
				</li>
			</ul>
		</div>

		<div class="inforbanr">
			<ul>
				<li>
					<div class="btncolor1 btncolor" target="_blank" style="background:url(http://static.qiluwan.com/Public/theme/images/14534353623735.jpg) no-repeat;">
						<a class="ibtn ibtn1" target="_blank" href="<?php echo U($gamedata['mark'].'/news_list',Array('cid'=>7));?>">查看详情</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="tag_li">
		<div class="tag_eg">
			<div class="tag_til"></div>
			<div class="tag_con">
				<ul>
					 <?php $_result=W('Common/Document/getNewsListByGid',Array($gamedata['id'],9,8,'PublicTheme_getNewsListByGid_2016_5_false_3'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U($gamedata['mark'].'/news_read',Array('id'=>$vo['id']));?>"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>   <div class="clear"></div>
				</ul>
			</div>
		</div>
		<div class="tag_eg">
			<div class="tag_til tag_til2"></div>
			<div class="tag_con">
				<ul>
				  <?php $_result=W('Common/Document/getNewsListByGid',Array($gamedata['id'],11,8,'PublicTheme_getNewsListByGid_2016_5_false_3'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U($gamedata['mark'].'/news_read',Array('id'=>$vo['id']));?>"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>   
				  <div class="clear"></div>
				</ul>
			</div>
		</div>
		<div class="tag_eg">
			<div class="tag_til tag_til3"></div>
			<div class="tag_con">
				<ul>
					 <?php $_result=W('Common/Document/getNewsListByGid',Array($gamedata['id'],10,8,'PublicTheme_getNewsListByGid_2016_5_false_3'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U($gamedata['mark'].'/news_read',Array('id'=>$vo['id']));?>"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>                                 <div class="clear"></div>
				</ul>
			</div>
		</div>
	</div>
	<div style="width: 830px;margin: 0 auto;">	<div id="SOHUCS" sid="<?php echo ($gamedata["id"]); ?>"></div>
<?php echo hook("ChangyanCode");?></div>


	</div>
</div>





<div class="w-ftwrap"><div class="w-fnav"><div class="w-fnavbox"><div class="w-fnav-w"><h5 class="w-fnav-z">帐号服务</h5><ul><li><a target="_blank" href="<?php echo U('User/Public/register');?>">帐号注册</a></li><li><a target="_blank" href="<?php echo U('User/safe/index');?>">修改密码</a></li><li><a target="_blank" href="<?php echo U('User/safe/index',array('t'=>'yxyz'));?>">绑定邮箱</a></li><li><a target="_blank" href="<?php echo U('Service/ticket/10');?>">找回帐号</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-k">客服中心</h5><ul><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">客服首页</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">论坛交流</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">常见问题</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">在线客服</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-r">热门游戏</h5><ul><?php $_result=W('Common/Game/RecommendedGame',Array('j',4,'IndexFooterRecomme11'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ig): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo ($ig["gameurl"]); ?>"><?php echo ($ig["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="w-fnav-w w-fnav-long"><h5 class="w-fnav-c">旗下站点</h5><ul><li><a target="_blank" href="<?php echo U('Home/index/index');?>">网页游戏</a></li><li><a target="_blank" href="<?php echo U('Game/index/index');?>">游戏大全</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">交流论坛</a></li><li><a target="_blank" href="<?php echo U('Shop/index/index');?>">积分商城</a></li></ul></div></div></div><div class="w-footer">抵制不良游戏，拒绝盗版游戏。 注意自我保护，谨防受骗上当。 适度游戏益脑，沉迷游戏伤身。 合理安排时间，享受健康生活。<p><a href="<?php echo U('Service/Information/about');?>" target="_blank">关于我们</a>|<a href="<?php echo U('Service/Information/lianxi');?>" target="_blank">联系我们</a>|<a href="<?php echo U('Service/Information/cooperation');?>" target="_blank">游戏合作</a>|<a href="<?php echo U('Service/Information/declare');?>" target="_blank">版权声明</a>|<a href="<?php echo U('Service/Information/duty');?>" target="_blank">使用协议</a></p><span>Copyright</span><span>©2015</span><span><?php echo strtoupper(DOMAIN());?></span><span><?php echo C('WEB_SITE_ICP');?></span></div></div>

<div class="hidden">
    <div class="hidden"><?php echo C('WEB_SITE_STATISTICS');?></div>
	<?php if(!empty($gamedata["script_code"])): echo ($gamedata["script_code"]); ?><br><?php endif; ?> 
</div>

<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/game.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/index.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/layer/layer.js"></script>
<script type="text/javascript">
	var gid = <?php echo ($gamedata["id"]); ?>;
    var navNode = ".server_nav>.d-server_nav";
    var serverListNode = ".server_wrap";
	var latestLimit="<?php echo ($__USER__["id"]); ?>";
    var latestNode = ".server_zui";
	layer.config({
		skin:'layer-ext-moon',
		extend: ['skin/moon/style.css', 'extend/layer.ext.js']
	});
	$(document).ready(function(){
	
		$("#searchG").click(function(){
			var obj=$('#searchTxt');
			if(obj.val()==""){
				layer.alert('请输入正确的服务器ID', {icon: 2,title: '提示'});
				return;
			}
			var input=parseInt(obj.val());
			var server=$('#server_'+input);
			if(server.size()>0){
				event.preventDefault();
				event.stopPropagation();
				window.open(server.attr('href'), '_blank');
			}else{
				layer.alert('服务器不存在', {icon: 2,title: '提示'});
				return;
			}
		});
	});
	//if($(ID).size()>0){
   // 存在

//}
</script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/dbgw.js"></script>

<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/common.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/t3t2_popup_plus.js"></script>

<script type="text/javascript">
var topboxbg_url = '<?php echo (get_cover($gamedata["pic"]["pic_site_bg"])); ?>';
var topboxbg_img = new Image();
topboxbg_img.src = topboxbg_url;
topboxbg_img.onload = function(){
	$('.topbox').css('height',topboxbg_img.height + 'px');
};
var MODULE_NAME='<?php echo MODULE_NAME;?>'.toUpperCase();
$('#NAV_'+MODULE_NAME).addClass('cur');

function getServerListUrlByRh(){
	return "<?php echo U($gamedata['mark'].'/server');?>";
}
</script>

<style>.tb_button {padding:1px;cursor:pointer;border-right: 1px solid #8b8b8b;border-left: 1px solid #FFF;border-bottom: 1px solid #fff;}.tb_button.hover {borer:2px outset #def; background-color: #f8f8f8 !important;}.ws_toolbar {z-index:100000} .ws_toolbar .ws_tb_btn {cursor:pointer;border:1px solid #555;padding:3px}   .tb_highlight{background-color:yellow} .tb_hide {visibility:hidden} .ws_toolbar img {padding:2px;margin:0px}</style>

</body>
</html>