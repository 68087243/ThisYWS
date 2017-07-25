<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="edge">
<meta name="keywords" content="<?php echo ($meta_keywords); ?>">
<meta name="description" content="<?php echo ($meta_description); ?>">
<title>【<?php echo ($meta_title); ?>官网】-<?php echo C('WEB_SITE_TITLE');?></title>
<?php echo hook("PageHeader");?>
<script type="text/javascript">
<?php echo W('Common/Public/script');?>
</script>
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/common_theme.css" />
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jquery183min.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jquerySuperSlide.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/theme_yxi5/css/game.css" />




<base target="_blank">
</head>
<body>
<div class="headerbox">
	<div class="hd960">
		<h1 class="hd_logo">
			<a href="<?php echo U('Home/Index/Index');?>"><?php echo C('WEB_SITE_TITLE');?></a>
		</h1>
		<div class="tips188">本游戏仅适合18岁以上玩家</div>
	<div class="hd_ico">
	<?php $_result=W('Common/Game/RecommendedGame',Array('z',4,'PublicTheme_num4_2016'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ig): $mod = ($i % 2 );++$i;?><a href="<?php echo ($ig["gameurl"]); ?>"><img src="<?php echo (get_cover($ig["pic"]["pic_icon"])); ?>" alt="<?php echo ($ig["name"]); ?>"><?php echo ($ig["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="hd_right">
		<div class="hd_a">
			<a href="<?php echo U('Pay/Index/'.$gamedata['id']);?>" style="color:#f60">充值</a>|<a href="<?php echo U('Service/Index/index');?>">客服</a>|<a href="#">家长监护</a><a href="#this" id="all_a" target="_self">全部网页游戏</a></div>
			<div class="hd_pop" id="hd_pop" style="display: none;">
				<i class="hd_jiao"></i>
					<ul class="pop_ul">
						<?php $_result=W('Common/Game/RandGame',Array(32,'PublicTheme_num32_2016'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ig): $mod = ($i % 2 );++$i; $_flags=flags($ig['flags']);?>
						<li><a href="<?php echo ($ig["gameurl"]); ?>" <?php if(isset($_flags["r"])): ?>style="color:#f60"<?php endif; ?>><?php echo ($ig["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
			</div>
		</div>
	</div>
</div>
<div class="main">
<div class="banner" style="background:url(<?php echo (get_cover($gamedata["pic"]["pic_site_bg"])); ?>) no-repeat center top;"></div>


<div class="conwrap area">
    	<div class="left">
        	<div class="login">
            	<a href="<?php echo U($gamedata['mark'].'/server');?>" class="game_star">开始游戏</a>
                        <iframe width="305px" height="133px" scrolling="no" framemargin="0" frameborder="0" allowtransparency="true" src="<?php echo U('Api/User/Gamebox',Array('bcolor'=>333,'gid'=>$gamedata['id']));?>"></iframe>
            </div>
            <div class="kefu">
            	<div class="title"><span class="tit">客服中心</span><img src="http://static.yiwanshu.com//Public/theme/theme_yxi5/images/help.png"></div>
                <div class="con">
                	<div class="pic"><img src="http://static.yiwanshu.com//Public/theme/theme_yxi5/images/kefu.png"></div>
                    <ul class="info">
                    	<li>客服电话：<?php echo C('WEB_SITE_MOBILE');?></li>
                        <li>客服时间：9:00-22:00</li>
                        <li>游戏咨询：<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('WEB_SITE_QQ');?>&site=qq&menu=yes" target="_blank" class="cOrange">在线客服</a></li>
                        <li>充值咨询：<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('WEB_SITE_QQ');?>&site=qq&menu=yes" target="_blank" class="cOrange">在线客服</a></li>
                    </ul>
					<div style="width:290px;text-overflow: -o-ellipsis-lastline;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 4;-webkit-box-orient: vertical;"><?php echo (strip_tags($gamedata["description"])); ?></div>
                </div>
            </div>
        </div>   
		
		
<div class="middle">
        	<div class="news">
            	<div class="hd">
            		<ul>
              <li class="on"><a href="#">新闻</a></li>
              <li class=""><a href="#">攻略</a></li>
            </ul>
         		</div>
      			<div class="bd items">
            		<ul style="display: block;">
  <?php $_result=W('Common/Document/getNewsListByGid',Array($gamedata['id'],false,8,'PublicTheme_getNewsListByGid_2016_5_false_1'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><span class="tit"><a href="<?php echo U($gamedata['mark'].'/news_read',Array('id'=>$vo['id']));?>" target="_blank" title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a></span><span class="date"><?php echo (date("m-d",$vo["ctime"])); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?>						                        
						 
                        <div class="more"><a href="<?php echo U($gamedata['mark'].'/news_list');?>" target="_blank">查看更多+</a></div>
           			</ul>
                    <ul style="display: none;">
 <?php $_result=W('Common/Document/getNewsListByGid',Array($gamedata['id'],5,5,'PublicTheme_getNewsListByGid_2016_5_false_3'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><span class="tit"><a href="<?php echo U($gamedata['mark'].'/news_read',Array('id'=>$vo['id']));?>" target="_blank" title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a></span><span class="date"><?php echo (date("m-d",$vo["ctime"])); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
  <div class="more"><a href="<?php echo U($gamedata['mark'].'/news_list',Array('cid'=>5));?>" target="_blank">查看更多+</a></div>
           			</ul>
            	</div>
            </div>
            <div class="server">
            	<div class="title"><span class="tit">服务器推荐</span><img src="http://static.yiwanshu.com//Public/theme/theme_yxi5/images/serverlist.png"><span class="more"><a href="<?php echo U($gamedata['mark'].'/server');?>" target="_blank">更多+</a></span></div>
                <div class="con">
                    <ul>
<?php $_result=W('Common/Game/getNewServerBygid',Array($gamedata['id'],8,'PublicTheme_num4_getNewServerBygid_2016'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ig): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo ($ig["gameurl"]); ?>" title="<?php echo ($ig["name"]); ?>"><i></i><?php echo ($ig["name"]); if(in_array(($i), explode(',',"1,2,3,4"))): ?><span class="hot">火爆开启</span><?php endif; ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				                 
                    </ul>
                </div>
            </div>
        </div>
<div class="right">
        	<div class="focus">
            	<div class="hd">
            		<ul>
                  
		
						<li class="on"></li>
				   
              
             
            </ul>
         		</div>
      			<div class="bd">
            		<div class="tempWrap" style="overflow:hidden; position:relative; width:360px"><ul style="width: 360px; left: 0px; position: relative; overflow: hidden; padding: 0px; margin: 0px;">
                    <li style="float: left; width: 360px;"><a href=""><img src="<?php echo (get_cover($gamedata["pic"]["pic_t_max"])); ?>" width="360" height="315"></a></li>
           			</ul></div>
            	</div>
            </div>
            <div class="quick">
            	<div class="title"><span class="tit">快捷入口</span><img src="http://static.yiwanshu.com//Public/theme/theme_yxi5/images/quick.png"></div>
                <div class="con">
                   <div class="q_btns">
					<a href="<?php echo U('Gift/'.$gamedata['mark'].'/index');?>" class="q_gift" style="width:348px;">领取礼包</a>
                    <!--<a class="q_weiduan">微端下载</a>-->
                    <a href="<?php echo U('Pay/index/'.$gamedata['id']);?>" rel="nofollow" target="_blank" class="q_chongzhi">游戏充值</a>
                   </div>
                </div>
            </div>
        </div>

		   </div>
		   <div class="link">
    	<div class="title">友情链接</div>
        <ul>
       
                </ul>
        <div class="clear"></div>
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
<script type="text/javascript">
function enterGame(){
	var sid=parseInt($("#fu_txt").val());
	var _sid=parseInt($("#ser_con_1").attr('data-sid'));
	if(sid>_sid || sid == 0 || isNaN(sid)){
		alert("区服不存在");
		return;
	}
	$.ajax({
    type: "get",
    async: true,
    url: U("Api/Game/getGameserverUrl","gid=<?php echo ($gamedata["id"]); ?>&sid="+sid),
    dataType: "jsonp",
    jsonp: "callback",
    success: function(data){
		window.location=data.url;
    }
});



}

function getServerListUrlByRh(){
	return "<?php echo U($gamedata['mark'].'/server');?>";
}

</script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/common_theme.js"></script>

<script type="text/javascript">
jQuery(".news").slide();
jQuery(".focus").slide({mainCell:".bd ul",effect:"left",delayTime:"500",autoPlay:true});
</script>



</body>
</html>