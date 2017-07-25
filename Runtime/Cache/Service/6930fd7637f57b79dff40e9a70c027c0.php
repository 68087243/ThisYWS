<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="edge">
<meta name="keywords" content="<?php echo ($meta_keywords); ?>">
<meta name="description" content="<?php echo ($meta_description); ?>">
<title><?php echo ($meta_title); ?>｜<?php echo C('WEB_SITE_TITLE'); echo C('WEB_SITE_SLOGAN');?></title>
<?php echo hook("PageHeader");?>

<script type="text/javascript">
<?php echo W('Common/Public/script');?>
</script>
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/common.css" />
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jquery183min.js"></script>

<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/index.css" />
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/kf.css" />
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/style.css" />



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


<div class="kfwrap">
    <div class="kfbtit"><h2 class="kft5">自助申诉</h2></div>
    <div class="kfbigwrap">
        <div class="artificial">
            <div class="kftit"><h2>人工客服</h2></div>
            <ul class="artlist">
                <li>客服热线：<b><?php echo C('WEB_SITE_MOBILE');?></b>
                </li><li>客服QQ：<b><?php echo C('WEB_SITE_QQ');?></b>
                </li>
            </ul>
            <div class="linekf">
                <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('WEB_SITE_QQ');?>&site=qq&menu=yes" target="_blank" class="okf">在线客服</a>

                <p>在线时间：每天9：00~21：00</p>
            </div>
        </div>

        <div class="appealist">
            <a href="<?php echo U('Service/ticket/3');?>" class="kf1"><i></i>游戏问题</a>
            <a href="<?php echo U('Service/ticket/6');?>" class="kf2"><i></i>充值问题</a>
            <a href="<?php echo U('Service/ticket/10');?>" class="kf3"><i></i>账号问题</a>
            <a href="<?php echo U('Service/ticket/1');?>" class="kf6"><i></i>装备找回</a>
            <a href="<?php echo U('Service/ticket/query');?>" class="kf5"><i></i>进度查询</a>
            <a href="<?php echo U('Service/ticket/5');?>" class="kf7"><i></i>充值未到账</a>
            <a href="<?php echo U('User/safe/index');?>" class="kf8"><i></i>安全中心</a>
            <a href="<?php echo U('Service/ticket/password');?>" class="kf9"><i></i>忘记密码</a>
            <a href="<?php echo U('Service/ticket/7');?>" class="kf10"><i></i>投诉建议</a>
            <a class="kf4"><i></i>更多服务 敬请期待</a>
        </div>
    </div>

    <div class="kfbigwrap">
        <div class="upromise">
            <div class="kfbtit"><h2 class="kft4">用户承诺</h2></div>
            <div class="allpromise">
                <ul>
                    <li>
                        <a href="<?php echo U('News/Read/9');?>" class="pr0"> 《齐鲁玩》用户守则<i></i></a>
                        <a href="<?php echo U('News/Read/10');?>" class="pr1">《齐鲁玩》交易纠纷处理<i></i></a>
                        <a href="<?php echo U('News/Read/11');?>" class="pr2">《齐鲁玩》防沉迷系统问题<i></i></a>
                        <a href="<?php echo U('News/Read/12');?>" class="pr3">《齐鲁玩》充值规则<i></i></a>
                </ul>
            </div>
        </div>

        <div class="kfrequest">
            <div class="kfbtit"><h2 class="kft3">常见问题</h2></div>
            <div class="kfreqbox">
                <div class="kfreqtab">
                    <ul><li class="cur">全部</li></ul>
                </div>
                <div class="kfreqlist">
                                            <div class="kfrequl ">
											<ul>
												<?php $_result=W('Common/Document/getListByCid',array(8,4,'CustomerServiceFrequentlyAskedQuestions'));if(is_array($_result)): $i = 0; $__LIST__ = array_slice($_result,0,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('News/Read/'.$vo['id']);?>">[常见问题] <?php echo ($vo["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
											</ul>
											<ul>
												<?php $_result=W('Common/Document/getListByCid',array(8,4,'CustomerServiceFrequentlyAskedQuestions'));if(is_array($_result)): $i = 0; $__LIST__ = array_slice($_result,4,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('News/Read/'.$vo['id']);?>">[常见问题] <?php echo ($vo["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
											</ul>	
												
                        </div>
                                        </div>
            </div>
        </div>
    </div>
</div>






<div class="w-ftwrap"><div class="w-fnav"><div class="w-fnavbox"><div class="w-fnav-w"><h5 class="w-fnav-z">帐号服务</h5><ul><li><a target="_blank" href="<?php echo U('User/Public/register');?>">帐号注册</a></li><li><a target="_blank" href="<?php echo U('User/safe/index');?>">修改密码</a></li><li><a target="_blank" href="<?php echo U('User/safe/index',array('t'=>'yxyz'));?>">绑定邮箱</a></li><li><a target="_blank" href="<?php echo U('Service/ticket/10');?>">找回帐号</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-k">客服中心</h5><ul><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">客服首页</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">论坛交流</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">常见问题</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">在线客服</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-r">热门游戏</h5><ul><?php $_result=W('Common/Game/RecommendedGame',Array('j',4,'IndexFooterRecomme11'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ig): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo ($ig["gameurl"]); ?>"><?php echo ($ig["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="w-fnav-w w-fnav-long"><h5 class="w-fnav-c">旗下站点</h5><ul><li><a target="_blank" href="<?php echo U('Home/index/index');?>">网页游戏</a></li><li><a target="_blank" href="<?php echo U('Game/index/index');?>">游戏大全</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">交流论坛</a></li><li><a target="_blank" href="<?php echo U('Shop/index/index');?>">积分商城</a></li></ul></div></div></div><div class="w-footer">抵制不良游戏，拒绝盗版游戏。 注意自我保护，谨防受骗上当。 适度游戏益脑，沉迷游戏伤身。 合理安排时间，享受健康生活。<p><a href="<?php echo U('Service/Information/about');?>" target="_blank">关于我们</a>|<a href="<?php echo U('Service/Information/lianxi');?>" target="_blank">联系我们</a>|<a href="<?php echo U('Service/Information/cooperation');?>" target="_blank">游戏合作</a>|<a href="<?php echo U('Service/Information/declare');?>" target="_blank">版权声明</a>|<a href="<?php echo U('Service/Information/duty');?>" target="_blank">使用协议</a></p><span>Copyright</span><span>©2015</span><span><?php echo strtoupper(DOMAIN());?></span><span><?php echo C('WEB_SITE_ICP');?></span></div></div>

<div class="hidden">
    <div class="hidden"><?php echo C('WEB_SITE_STATISTICS');?></div>
	<?php if(!empty($gamedata["script_code"])): echo ($gamedata["script_code"]); ?><br><?php endif; ?> 
</div>



<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/common.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/t3t2_popup_plus.js"></script>
<script type="text/javascript">
var MODULE_NAME='<?php echo MODULE_NAME;?>'.toUpperCase();
$('#NAV_'+MODULE_NAME).addClass('cur');
</script>
<style>.tb_button {padding:1px;cursor:pointer;border-right: 1px solid #8b8b8b;border-left: 1px solid #FFF;border-bottom: 1px solid #fff;}.tb_button.hover {borer:2px outset #def; background-color: #f8f8f8 !important;}.ws_toolbar {z-index:100000} .ws_toolbar .ws_tb_btn {cursor:pointer;border:1px solid #555;padding:3px}   .tb_highlight{background-color:yellow} .tb_hide {visibility:hidden} .ws_toolbar img {padding:2px;margin:0px}</style>

</body>
</html>