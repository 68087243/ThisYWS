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

<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/game.css" />
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/others.css" />


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


<?php $gameurl=D('Game')->getGameUrl($gametj[0]['id']); ?>
<div class="w-wrap">
        <div class="w-section">
                <div class="w-tit">
                  <h2 class="w-tit-tjyx">推荐游戏</h2>
                    <ul class="w-notice" id="w-notices">
                        <?php $_result=W('Common/Horn/getHorn',array(5,'Smallspeakers'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
                </div>
				
                <div class="w-tuigames">
                                <div class="w-tuifirst">
                                    <div class="w-tuifcon">
                                            <a href="<?php echo ($gameurl); ?>" class="w-tuifcon-a"><img src="<?php echo (get_cover($gametj["0"]["pic"]["pic_t_max"])); ?>" alt="<?php echo ($gametj["0"]["name"]); ?>">
											<?php if(!empty($gametj["0"]["flags"]["r"])): ?><i class="w-jqyxicoh"></i><?php else: if(!empty($gametj["0"]["flags"]["x"])): ?><i class="w-jqyxicon"></i><?php endif; endif; ?></a>
                                            <div class="w-jqyxb">
                                                    <a href="<?php echo ($gameurl); ?>" class="w-jqyxplay"><i></i>开始游戏</a>
                                                    <a href="<?php echo ($gameurl); ?>"><?php echo ($gametj["0"]["name"]); ?></a>
                                            </div>
                                    </div>
                                    <i class="w-jpyxpngbg"></i>
									
                                </div>
								<?php unset($gametj[0]); ?>
                                <div class="w-tuilist">
                                <ul class="w-agames-ul">
                                             <?php if(is_array($gametj)): $i = 0; $__LIST__ = $gametj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $gameurl=D('Game')->getGameUrl($vo['id']); ?>
                                            <li>
                                                <div class="w-agamescon">
                                                    <a href="<?php echo ($gameurl); ?>" class="w-agamescon-a"><img src="<?php echo (get_cover($vo["pic"]["pic_r"])); ?>" alt="<?php echo ($vo["name"]); ?>"><?php if(!empty($vo["flags"]["r"])): ?><i class="w-jqyxicoh"></i><?php else: if(!empty($vo["flags"]["x"])): ?><i class="w-jqyxicon"></i><?php endif; endif; ?></a>
                                                    <div class="w-jqyxb">
                                                            <a href="<?php echo ($gameurl); ?>" class="w-jqyxplay"><i></i>开始游戏</a>
                                                            <a href="<?php echo ($gameurl); ?>"><?php echo ($vo["name"]); ?></a>
                                                    </div>
                                                </div>
                                                <i class="w-agamesbg"></i>
                                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
											
                                </ul>
                        </div>
                </div>
				
                <div class="w-tit">
                    <h2 class="w-tit-sort">游戏筛选</h2>
                    <div class="w-paixu">
                        <input type="text" placeholder="搜索游戏名称" class="w-pais" id="searchTxt">
                        <input type="button" class="w-paib" id="searchG">
                    </div>
                </div>
                <div class="w-nav-sort">
                    <ul class="w-nav-ul">
                        <li id="class-key-w">
                            游戏类型：
                            <span class="cur" data-key="不限">不限</span>
							<?php $GAME_TYPE_LIST=C('GAME_TYPE_LIST'); ?>
							<?php if(is_array($GAME_TYPE_LIST)): $i = 0; $__LIST__ = $GAME_TYPE_LIST;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span data-key="<?php echo ($vo); ?>"><?php echo ($vo); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
                        </li>
                        <li id="initial-key-w">
                            按首字母：
                            <span class="cur" data-key="不限">不限</span>
							<?php $GAME_INITIALS_LIST=C('GAME_INITIALS_LIST'); ?>
							<?php if(is_array($GAME_INITIALS_LIST)): $i = 0; $__LIST__ = $GAME_INITIALS_LIST;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span data-key="<?php echo ($vo); ?>"><?php echo ($vo); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
                        </li>
                        <li id="tag-key-w">
                            热门标签：
                            <span class="cur" data-key="不限">不限</span>
                            <span data-key="三国">三国</span>
                            <span data-key="玄幻">玄幻</span>
                            <span data-key="西游">西游</span>
                            <span data-key="武侠">武侠</span>
                            <span data-key="体育">体育</span>
                            <span data-key="动漫">动漫</span>
                            <span data-key="休闲">休闲</span>
                        </li>
                    </ul>
                </div>
                <div class="w-con-sort">
                    <ul class="w-agames-ul" id="w-allgames">
							<?php if(is_array($gameall)): $i = 0; $__LIST__ = $gameall;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-main="<?php echo strtolower(pinyin($vo['name'],true));?>|<?php echo $GAME_TYPE_LIST[$vo['type']]; ?>|<?php echo (get_cover($vo["pic"]["pic_r"])); ?>|<?php echo getexplode($vo['tag'],0);?>"><a href="<?php echo D('Game')->getGameUrl($vo['id']); ?>"><?php echo ($vo["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <div class="pages-w hidden" id="ztpage">
                    </div>

                    <div class="bgames" id="bgames">
                            <p>
								<?php $_result=W('Common/Game/RandGame',array(30,'GamesicoRecommended'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href='<?php echo ($vo["gameurl"]); ?>'><img alt='<?php echo ($vo["name"]); ?>' a='<?php echo (get_cover($vo["pic"]["pic_icon"])); ?>'><?php echo ($vo["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
							</p>
                    </div>

                    <div class="w-con-none hidden" id="w-con-none">
                        <p class="w-con-tp">哎呀，未找到符合条件的结果~</p>
                        <div class="w-fav-t">
                            您可能喜欢
                        </div>
                        <div class="w-fav-c">
                            <ul class="w-agames-ul">
								<?php $_result=W('Common/Game/RandGame',array(4,'Youmightlike'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><div class="w-agamescon"><a href="<?php echo ($vo["gameurl"]); ?>" class="w-agamescon-a"><img src="<?php echo (get_cover($vo["pic"]["pic_r"])); ?>" alt="<?php echo ($vo["name"]); ?>"></a><div class="w-jqyxb"><a href="<?php echo ($vo["gameurl"]); ?>" class="w-jqyxplay"><i></i>开始游戏</a><a href="<?php echo ($vo["gameurl"]); ?>"><?php echo ($vo["name"]); ?></a></div></div><i class="w-agamesbg"></i></li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
                        </div>
                    </div>
                </div>
        </div>
        <div class="w-article">

                <div class="w-tit">
                        <h2 class="w-tit-newkf">最新开服</h2>
                        <div class="w-kfitemtab" id="newkfbtns"></div>
                </div>
                <div class="w-jjkflist" id="newkfcons">
				
                </div>

                <div class="w-tit">
                        <h2 class="w-tit-xyx">精品游戏</h2>
                </div>
                <div class="w-tit-xyx-c">
				<?php $_result=W('Common/Game/RandGame',array(6,'ToysGames'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href='<?php echo ($vo["gameurl"]); ?>'><img alt='<?php echo ($vo["name"]); ?>' src='<?php echo (get_cover($vo["pic"]["pic_icon_max"])); ?>'><?php echo ($vo["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
        </div>
</div>





<div class="w-ftwrap"><div class="w-fnav"><div class="w-fnavbox"><div class="w-fnav-w"><h5 class="w-fnav-z">帐号服务</h5><ul><li><a target="_blank" href="<?php echo U('User/Public/register');?>">帐号注册</a></li><li><a target="_blank" href="<?php echo U('User/safe/index');?>">修改密码</a></li><li><a target="_blank" href="<?php echo U('User/safe/index',array('t'=>'yxyz'));?>">绑定邮箱</a></li><li><a target="_blank" href="<?php echo U('Service/ticket/10');?>">找回帐号</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-k">客服中心</h5><ul><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">客服首页</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">论坛交流</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">常见问题</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">在线客服</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-r">热门游戏</h5><ul><?php $_result=W('Common/Game/RecommendedGame',Array('j',4,'IndexFooterRecomme11'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ig): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo ($ig["gameurl"]); ?>"><?php echo ($ig["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="w-fnav-w w-fnav-long"><h5 class="w-fnav-c">旗下站点</h5><ul><li><a target="_blank" href="<?php echo U('Home/index/index');?>">网页游戏</a></li><li><a target="_blank" href="<?php echo U('Game/index/index');?>">游戏大全</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">交流论坛</a></li><li><a target="_blank" href="<?php echo U('Shop/index/index');?>">积分商城</a></li></ul></div></div></div><div class="w-footer">抵制不良游戏，拒绝盗版游戏。 注意自我保护，谨防受骗上当。 适度游戏益脑，沉迷游戏伤身。 合理安排时间，享受健康生活。<p><a href="<?php echo U('Service/Information/about');?>" target="_blank">关于我们</a>|<a href="<?php echo U('Service/Information/lianxi');?>" target="_blank">联系我们</a>|<a href="<?php echo U('Service/Information/cooperation');?>" target="_blank">游戏合作</a>|<a href="<?php echo U('Service/Information/declare');?>" target="_blank">版权声明</a>|<a href="<?php echo U('Service/Information/duty');?>" target="_blank">使用协议</a></p><span>Copyright</span><span>©2015</span><span><?php echo strtoupper(DOMAIN());?></span><span><?php echo C('WEB_SITE_ICP');?></span></div></div>

<div class="hidden">
    <div class="hidden"><?php echo C('WEB_SITE_STATISTICS');?></div>
	<?php if(!empty($gamedata["script_code"])): echo ($gamedata["script_code"]); ?><br><?php endif; ?> 
</div>

<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/game.js"></script>
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