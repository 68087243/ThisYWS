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
<link rel="stylesheet" type="text/css" href="http://static.yiwanshu.com//Public/theme/css/pay.css" />


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


<form action="<?php echo U('Pay/orders/index');?>" method="post" name="form1" id="form1" target="_blank">
	
	<p class="p_tips">您当前选择的是<span id='paytitle'></span>支付方式，通过<span id='business'></span>支付。
			</p>
	<div class="p_conbox clearfix">
		<div class="p_nav">


			<ul class="p_nav_ul clearfix">
				<?php $_paylist=$paylist; ?>
				<?php if(is_array($_paylist)): $i = 0; $__LIST__ = array_slice($_paylist,0,13,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li val="<?php echo ($vo["tag"]); ?>" business="<?php echo ($vo["tagname"]); ?>" url="<?php if(empty($vo["help_url"])): ?>#<?php else: echo ($vo["help_url"]); endif; ?>"><em class="em<?php echo ($vo["icon"]); ?>"><?php echo ($vo["name"]); ?></em></li>
					<?php unset($_paylist[$key]); endforeach; endif; else: echo "" ;endif; ?>
				<li class="p_other">
					<em class="em11">其他方式</em>
				</li>
				<?php if(is_array($_paylist)): $i = 0; $__LIST__ = $_paylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li val="<?php echo ($vo["tag"]); ?>" business="<?php echo ($vo["tagname"]); ?>" url="<?php if(empty($vo["help_url"])): ?>#<?php else: echo ($vo["help_url"]); endif; ?>" class="p_qtli"><?php echo ($vo["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<a href="<?php echo U('User/recharge/index');?>" class="rechargelist">查询充值记录</a>
		</div>
		<div class="p_con" id='chongzhi'>
		
		
			<div class="p_to_type">                	
					 <span class="">
						<label>充值到：：</label>
					<div class="pay_where">
                        <span class="pay_place cicrl_role1"><input type="radio" name="pay_to_temp" value="0" checked="">充值到游戏</span>
						<span class="pay_place cicrl_role2"><input type="radio" name="pay_to_temp" value="1">充值到<?php echo C('CURRENCY_NAME');?></span>
                     </div>
					</span>
			</div>
		
		
		
		
			<div class="p_con_select">
				<ol class="select_ol">
					<li>
						<span class="select_on" id="gamelist"><em id='gname'>选择充值游戏</em><img src="/Public/theme/images/p_img_ok.png" style="display:none"></span>
					</li>
					<li class="li_opacity">
						<span class="select_on select_on2" id="serverlist"><em id='sname'>选择游戏服务器</em><img src="/Public/theme/images/p_img_ok.png" style="display:none"></span>
					</li>
				</ol>
				<i class="select_ico" style="display:none;"></i>
				<div class="p_gsbox hidden">
					<div class="gs_navbg">
						<ul class="gs_nav_ul" id="gametab">
							<li class="gs_first" id='hg'><span>最近玩过</span></li>
							<?php $GAME_INITIALS_LIST=C('GAME_INITIALS_LIST'); ?>
							<?php if(is_array($GAME_INITIALS_LIST)): $i = 0; $__LIST__ = $GAME_INITIALS_LIST;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="ag"><span><?php echo ($vo); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
						<span class="gs_close"></span>
					</div>
					<div class="p_gameslist">
						<ul id="glist">
							<?php if(is_array($gamelist)): $i = 0; $__LIST__ = $gamelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li frist="<?php echo strtoupper(pinyin($vo['name'],true));?>"><a href="#" gid="<?php echo ($vo["id"]); ?>" gamename="<?php echo ($vo["name"]); ?>"><img src="<?php if(empty($vo["pic"]["pic_icon"])): ?>/Public/theme/empty/emptyicon.png<?php else: echo (get_cover($vo["pic"]["pic_icon"])); endif; ?>" alt="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
        				<ul id="history" class="hidden">
						<?php if(!empty($__USER__)): $_result=W('Common/Game/gameplayByuid',array($__USER__['id'],30,'Iplayedrechargecenter'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="#" gid="<?php echo ($vo["gid"]); ?>" gamename="<?php echo ($vo["name"]); ?>"><img src="<?php if(empty($vo["pic"]["pic_icon"])): ?>/Public/theme/empty/emptyicon.png<?php else: echo (get_cover($vo["pic"]["pic_icon"])); endif; ?>" alt="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
		                </ul>
					</div>
				</div>
				<div class="p_gsbox hidden">
					<div class="gs_navbg">
						<ul class="gs_nav_ul" id="sul">
							<li class="gs_first"><span>最近玩过</span></li>
						</ul>
						<span class="gs_close"></span>
					</div>
					<ul class="p_servelist"></ul>
				</div>
			</div>
			<div class="p_account">
								<p class="account_input">
					<span class="account_l">
						<label>充入帐号：</label>
						<input type="text" class="nam_ipt" value="<?php echo ($__USER__["username"]); ?>" maxlength="15">
						<span class="nam_confirm" id="sure">[确定]</span>
					</span>
										<code class="e_tips hidden" id='usererror'></code>
									</p>
				<p class="account_txt hidden">
					<span class="account_l">
						<label>充入帐号：</label>
						<em id='payname'></em>
						<span class="nam_confirm" id="change">[更改]</span>
					</span>
					<code class="e_tips hidden" id='roleerror'></code>
					<input type="hidden" name="g_username" id="g_username">
		            <input type="hidden" name="g_reusername" id="g_reusername">
				</p>
			</div>
			
			<div class="p_money">
				<div class="money_t">充值金额：</div>
				<div class="money_c clearfix">
					<a href="#" value='10'>10元</a>
					<a href="#" value='20'>20元</a>
					<a href="#" value='50'>50元</a>
					<a href="#" value='100'>100元</a>
					<a href="#" value='200'>200元</a>
					<a href="#" value='500'>500元</a>
					<a href="#" value='1000'>1000元</a>
					<a href="#" value='2000'>2000元</a>
					<a href="#" value='5000'>5000元</a>
					<a href="#" value='10000'>10000元</a>
					<a href="#" value='20000'>20000元</a>
					<a href="#" value='50000'>50000元</a>
				</div>
				<div class="money_other">
					<div class="money_l">
						<a href="#" class="other_a">其他：</a>
						<input type="text" class="other_ipt" maxlength='6'>元
					</div>
					<span class="money_tips"></span>
					<code class="e_tips hidden" id='casherror'>请填写1-1000000的整数</code>
				</div>
				<div class="money_exc">
					<span>对应<span id="unit">金币</span>数量:<span id="viewybnum"></span><span class="money_bi">[兑换比例<span id="game_rate">1:10</span>]</span></span>
				</div>
			</div>
			<div class="p_bank">
				

				<div class="bank_c clearfix hidden" id="banklist">
					<div class="bank_t">选择银行：</div>
		            		            	<a href="#" value="ICBC" id="ICBC" title='中国工商银行'><img src="http://static.t3t2.com/Public/theme/images/bank_icbc.gif" alt="中国工商银行"></a>
		            		            	<a href="#" value="CCB" id="CCB" title='中国建设银行'><img src="http://static.t3t2.com/Public/theme/images/bank_ccb.gif" alt="中国建设银行"></a>
		            		            	<a href="#" value="ABC" id="ABC" title='中国农业银行'><img src="http://static.t3t2.com/Public/theme/images/bank_abc.gif" alt="中国农业银行"></a>
		            		            	<a href="#" value="CMB" id="CMB" title='招商银行'><img src="http://static.t3t2.com/Public/theme/images/bank_cmb.gif" alt="招商银行"></a>
		            		            	<a href="#" value="BOC" id="BOC" title='中国银行'><img src="http://static.t3t2.com/Public/theme/images/bank_boc.gif" alt="中国银行"></a>
		            		            	<a href="#" value="POST" id="POST" title='中国邮政'><img src="http://static.t3t2.com/Public/theme/images/bank_post.gif" alt="中国邮政"></a>
		            		            	<a href="#" value="BCOM" id="BCOM" title='交通银行'><img src="http://static.t3t2.com/Public/theme/images/bank_bcom.gif" alt="交通银行"></a>
		            		            	<a href="#" value="CEB" id="CEB" title='中国光大银行'><img src="http://static.t3t2.com/Public/theme/images/bank_ceb.gif" alt="中国光大银行"></a>
		            		            	<a href="#" value="PAB" id="PAB" title='平安银行'><img src="http://static.t3t2.com/Public/theme/images/bank_pab.gif" alt="平安银行"></a>
		            		            	<a href="#" value="CIB" id="CIB" title='兴业银行'><img src="http://static.t3t2.com/Public/theme/images/bank_cib.gif" alt="兴业银行"></a>
		            		            	<a href="#" value="SPDB" id="SPDB" title='浦发银行'><img src="http://static.t3t2.com/Public/theme/images/bank_spdb.gif" alt="浦发银行"></a>
		            		            	<a href="#" value="GDB" id="GDB" title='广东发展银行'><img src="http://static.t3t2.com/Public/theme/images/bank_gdb.gif" alt="广东发展银行"></a>
		            		            	<a href="#" value="CMBC" id="CMBC" title='中国民生银行'><img src="http://static.t3t2.com/Public/theme/images/bank_cmbc.gif" alt="中国民生银行"></a>
		            		            	<a href="#" value="CITIC" id="CITIC" title='中信银行'><img src="http://static.t3t2.com/Public/theme/images/bank_citic.gif" alt="中信银行"></a>
		            		            	<a href="#" value="SHB" id="SHB" title='上海银行'><img src="http://static.t3t2.com/Public/theme/images/bank_shb.gif" alt="上海银行"></a>
		            		            	<a href="#" value="NBCB" id="NBCB" title='宁波银行'><img src="http://static.t3t2.com/Public/theme/images/bank_nbcb.gif" alt="宁波银行"></a>
		        </div>
			</div>
			
			<div class="card_v hidden" id="card_v">
			<span style="color:#525252;">★★★★★警告：充值卡充值务必选择正确的充值卡面额，否则后果请自负！★★★★★</span>
			<div class="p_account">
					<p style="height: 28px;" id="cardid_input">
					<span class="account_l">
						<label>卡号：</label>
						<input type="text" id="cardid_ipt" style="width: 176px;height: 16px;border: 1px solid #B0B0B0;padding: 5px 4px;color: #333;vertical-align: middle;" value="" maxlength="30">
						<span class="nam_confirm" id="sure_cardid">[确定]</span>
					</span>
						<code class="e_tips hidden" id='paycardiderror'></code>
					</p>
					<p class="hidden" style="height: 28px;line-height: 28px;" id="cardid_txt">
						<span class="account_l">
							<label>卡号：</label>
							<em id='paycardid_em'></em>
							<span class="nam_confirm" id="change_cardid">[更改]</span>
						</span>
						<input type="hidden" name="paycardid" id="paycardid">
					</p>
			</div>
			
			<div class="p_account">
					<p style="height: 28px;" id="cardpass_input">
					<span class="account_l">
						<label>卡密：</label>
						<input type="text" id="cardpass_ipt" style="width: 176px;height: 16px;border: 1px solid #B0B0B0;padding: 5px 4px;color: #333;vertical-align: middle;" value="" maxlength="30">
						<span class="nam_confirm" id="sure_cardpass">[确定]</span>
					</span>
						<code class="e_tips hidden" id='paycardpasserror'></code>
					</p>
					<p class="hidden" style="height: 28px;line-height: 28px;" id="cardpass_txt">
						<span class="account_l">
							<label>卡密：</label>
							<em id='paycardpass_em'></em>
							<span class="nam_confirm" id="change_cardpass">[更改]</span>
						</span>
						<input type="hidden" name="paycardpass" id="paycardpass">
					</p>
			</div>
			
			</div>
			<div class="p_confirm">
				<span class="dazhuan" style="display:none"><img src="/Public/theme/images/pay/pay_z.gif" alt="">提交中...</span>
				<input type="button"   class="confirm_btn">
			</div>
			
			
			

			
			<?php if(is_array($paylist)): $i = 0; $__LIST__ = $paylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="p_intro" id='<?php echo ($vo["tag"]); ?>-intro' style="display:none">
		        <div class="p_intro_t"><h5><?php echo ($vo["name"]); ?>充值说明：</h5><span class="all_txt">查看</span></div>
		        <ol>
		            <?php echo ($vo["description"]); ?>
		        </ol>
		    </div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		
		
		<div class="p_con hidden" id='ren'>
		<div class="pay_ren">
			
		</div>
		</div>
		
	</div>
	
	<input class="input_txt select_span_1 hidden" maxlength="6" name="cash" value="10" id="cash" autocomplete="off">
	<input class="input_txt hidden" id="viewybnum" readonly>
    <input type="hidden" id="gid" name="gid" value='<?php echo ($gid); ?>'>
    <input type="hidden" id="sid" name="sid" value=''>
	<input type="hidden" id="paybank" name="paybank">
    <input type="hidden" id="defServerId" name="defServerId" value=''>
    <input type="hidden" id="gamerate" name="gamerate" value=''>
    <input type="hidden" id="payrate" name="payrate" value='1'>
    <input type="hidden" id="ybcn" name="ybcn" value=''>
    <input type="hidden" id="rolename" name="rolename">
    <input type="hidden" id="paytype" name="paytype" value="">
	<input type="hidden" id="payto" name="payto" value="0">
	
	<div class="pay_pop hidden" id="payinfo">
	<div class="pay_pop_t">
		<h5>充值信息确认</h5>
		<span title="关闭" class="close"></span>
	</div>
	<div class="pay_pop_c">
		<ul class="p_info_ul clearfix">
			<li><span>您的充值方式是：</span><em id='payment_tip'>银行卡支付（易宝）</em>&nbsp;<em id='bankname'></em></li>
			<li><span>您的充值游戏是：</span><em id='game_tip'>大闹天宫</em>&nbsp;<em id='server_tip'>双线1区</em></li>
			<li><span>您的充值帐号是：</span><em id='user_tip'>darral</em></li>
			<li><span>您的角色名是：</span><em id='role_tip'>role</em></li>
			<li><span>您的充值金额是：</span><em id='cash_tip'>1</em>&nbsp;元人民币</li>
			<li><span>您收到的<em class='bicn_tip'>点券</em>是：</span><strong class="p_info_coin"><em id='bi_tip'>10</em>&nbsp;<em class='bicn_tip'>金币</em></strong></li>
		</ul>
		<div class="pay_pop_a">
			<a href="#" class="pay_pop_sub">确认提交</a>
			<a href="#" class="close">返回修改</a>
		</div>
	</div>
	</div>
	
	<div id="lriframe"></div> 
	<div class="pay_pop hidden" id="paysuccess">
		<div class="pay_pop_t">
			<h5>提示</h5>
			<span title="关闭" class="close"></span>
		</div>
		<div class="pay_pop_c">
			<p class="pay_pop_p1">请您在新打开的支付页面上完成付款充值！</p>
			<p class="pay_pop_p2">付款完成前请不要关闭或刷新此窗口。<br>完成付款后请根据您的情况点击下面的按钮。</p>
			<div class="pay_pop_a2">
				<a href="<?php echo U('Pay/return/index');?>">查看充值结果</a>
				<a href="#" id="qa">遇到充值问题</a>
				<a href="#" class="pay_a50 close">返回</a>
			</div>
		</div>
	</div>
	<!--<div id="backpng" style="display:none"></div>-->
</form>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('WEB_SITE_QQ');?>&site=qq&menu=yes" class="p_qqkf">在线客服</a>





<div class="w-ftwrap"><div class="w-fnav"><div class="w-fnavbox"><div class="w-fnav-w"><h5 class="w-fnav-z">帐号服务</h5><ul><li><a target="_blank" href="<?php echo U('User/Public/register');?>">帐号注册</a></li><li><a target="_blank" href="<?php echo U('User/safe/index');?>">修改密码</a></li><li><a target="_blank" href="<?php echo U('User/safe/index',array('t'=>'yxyz'));?>">绑定邮箱</a></li><li><a target="_blank" href="<?php echo U('Service/ticket/10');?>">找回帐号</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-k">客服中心</h5><ul><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">客服首页</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">论坛交流</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">常见问题</a></li><li><a target="_blank" href="<?php echo U('Service/Index/Index');?>">在线客服</a></li></ul></div><div class="w-fnav-w"><h5 class="w-fnav-r">热门游戏</h5><ul><?php $_result=W('Common/Game/RecommendedGame',Array('j',4,'IndexFooterRecomme11'));if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ig): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo ($ig["gameurl"]); ?>"><?php echo ($ig["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="w-fnav-w w-fnav-long"><h5 class="w-fnav-c">旗下站点</h5><ul><li><a target="_blank" href="<?php echo U('Home/index/index');?>">网页游戏</a></li><li><a target="_blank" href="<?php echo U('Game/index/index');?>">游戏大全</a></li><li><a target="_blank" href="<?php echo U('Forum/index/index');?>">交流论坛</a></li><li><a target="_blank" href="<?php echo U('Shop/index/index');?>">积分商城</a></li></ul></div></div></div><div class="w-footer">抵制不良游戏，拒绝盗版游戏。 注意自我保护，谨防受骗上当。 适度游戏益脑，沉迷游戏伤身。 合理安排时间，享受健康生活。<p><a href="<?php echo U('Service/Information/about');?>" target="_blank">关于我们</a>|<a href="<?php echo U('Service/Information/lianxi');?>" target="_blank">联系我们</a>|<a href="<?php echo U('Service/Information/cooperation');?>" target="_blank">游戏合作</a>|<a href="<?php echo U('Service/Information/declare');?>" target="_blank">版权声明</a>|<a href="<?php echo U('Service/Information/duty');?>" target="_blank">使用协议</a></p><span>Copyright</span><span>©2015</span><span><?php echo strtoupper(DOMAIN());?></span><span><?php echo C('WEB_SITE_ICP');?></span></div></div>

<div class="hidden">
    <div class="hidden"><?php echo C('WEB_SITE_STATISTICS');?></div>
	<?php if(!empty($gamedata["script_code"])): echo ($gamedata["script_code"]); ?><br><?php endif; ?> 
</div>

<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/pay3.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/gyUser.js"></script>
<script type="text/javascript">
var syusers=0;
var CURRENCY_RATE=<?php echo C('CURRENCY_RATE');?>;
var TOGGLE_CURRENCY=<?php echo (C("TOGGLE_CURRENCY")); ?>;
var _domunet_title=document.title;

var his = <?php if(!empty($__USER__)): echo W('Common/Game/gameplayJsonByuid',array($__USER__['id'],30,'IplayedrechargecenterServer')); else: ?>[]<?php endif; ?>;
var paytype=<?php echo ($json_pay); ?>;
var defname = "<?php echo ($__USER__["username"]); ?>";
var money="<?php echo ($__USER__["money"]); ?>";
(function(){
	if(TOGGLE_CURRENCY != 1){
		$(".p_to_type").slideToggle(1);
		$('.p_nav_ul>li[val="_syspay"]').slideToggle(1);
	}
	if(!defname){
		iframeshow(0);
		return;
	}
	
})();
$("#glist>li>a").bind("click",function(){
	var gid = $(this).attr('gid');
	$("#gname").html($(this).attr('gamename'));
	document.title=$(this).attr('gamename') + " - " +_domunet_title;
	$("#gid").val(gid);
	$("#sid").val('');
	$("#sname").html('选择游戏服务器');
	$("#serverlist").parent().addClass("li_opacity");
	$("#gamelist>img").show();
	$("#serverlist>img").hide();
	showServerDiv();
	return false;
});

$("#history>li>a").bind("click",function(){
	var gid = $(this).attr('gid');
	$("#gname").html($(this).attr('gamename'));
	document.title=$(this).attr('gamename')+" - "+_domunet_title;
	$("#gid").val(gid);
	$("#sid").val('');
	$("#sname").html('选择游戏服务器');
	$("#serverlist").parent().addClass("li_opacity");
	$("#gamelist>img").show();
	$("#serverlist>img").hide();
	showServerDiv();
	return false;
});
	if($("#defServerId").val()){
		var cur_server = 1;
	}
	if($("#gid").val()){
		$("a[gid="+$("#gid").val()+"]").eq(0).trigger("click");
	}
	


$("#gamelist").bind("click",function(){
	$(".select_ico").removeClass("select_ico2");
	$(".select_ico").show();
	$(".p_gsbox").eq(0).show();
	$(".p_gsbox").eq(1).hide();
	return false;
});

$("#serverlist").bind("click",function(){
	$(".select_ico").addClass("select_ico2");
	$(".select_ico").show();
	$(".p_gsbox").eq(1).show();
	$(".p_gsbox").eq(0).hide();
	return false;
});
$(".pay_place").bind("click",function(){
	
	$(".pay_place").removeClass("place_checked");
	$(this).addClass("place_checked");
	$('#payto').val($(this).find('input').val());
	switch($(this).find('input').val()){
		case "1":
			document.title="充值到<?php echo C('CURRENCY_NAME');?> - "+ _domunet_title;
			$('.p_con_select').hide();
			$('#gamerate').val(CURRENCY_RATE);
	        $('#ybcn').val('<?php echo C('CURRENCY_NAME');?>');
			$('.p_nav_ul>li[val="_syspay"]').hide();
			calculateMoney();
		break;
		case "0":
			$('.p_con_select').show();
			$('#gamerate').val('0');
	        $('#ybcn').val('');
			$('.p_nav_ul>li[val="_syspay"]').show();
			calculateMoney();
		break;
	}
	return false;
});

function showServerDiv(){
	getServer();
	$(".select_ico").addClass("select_ico2");
	$(".p_gsbox").eq(0).hide();
	if(cur_server!=1){
		$(".p_gsbox").eq(1).show();
	}else{
		cur_server = 0;
	}
	return false;
}
$(".gs_close").bind("click",function(){
	$(".p_gsbox,.select_ico").hide();
});
$('.ag').bind("click",function(){
	$(this).addClass("cur").siblings().removeClass('cur');
	var letter = $(this).children('span').html().split('');
	$("#glist > li").hide();
	for(var i=0;i<letter.length;i++){
		$("#glist > li[frist="+letter[i]+"]").show();
	}
	$("#glist").show();
	$("#history").hide();
});
$('#hg').bind("click",function(){
	$(this).addClass("cur").siblings().removeClass('cur');
	$("#glist").hide();
	$("#history").show();
});
	$(".gs_nav_ul>li").eq(1).trigger('click');
	Login.aaa = function(){
	window.location = U('Pay/index/index');
	}

	$("#sure").trigger('click');
	function wrapshow(handle){
		var handle_s=$(handle),
		handle_h=handle_s.height(),
		win_oll=$(window).height(),
		doc_top=$(document).scrollTop();
		$("#backpng").show().css({height:$(document.body).height()});
		handle_s.css({'display':'block','z-index':99,'position':'absolute','top':(win_oll-handle_h)/2+doc_top});
		return false;
	}
			
	function close_hide(){
		back_hide();
		return false;
	}
	$(".money_c>a[value=100]").trigger('click');

	$(".all_txt").toggle(function(){

		$(this).html("收起");
	
		$(this).parent().next().show();
	
	},function(){

		$(this).html("查看");
	
		$(this).parent().next().hide();
	
	});
	(function(){
	
		var zjzy = '<?php if(!empty($__USER__)): echo W('Common/Pay/GetPayTypeByUid',array($__USER__['id'])); endif; ?>';
		if(zjzy ==""){
			var paytype = $('.p_nav_ul li:first').attr('val');
			var li = $(".p_nav_ul >li[val="+paytype+"]");
			
		}else{
			var paytype = zjzy;
			var li = $(".p_nav_ul >li[val="+paytype+"]");
			li.children('span').remove();
			li.append('<span class="cz_flag">最近在用</span>');
		}
		li.trigger("click");
		<?php switch($_GET['type']): case "platform": ?>$(".cicrl_role2").trigger("click");<?php break; default: ?>$(".cicrl_role1").trigger("click");<?php endswitch;?>
	})()
</script>

<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/common.js"></script>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/theme/js/t3t2_popup_plus.js"></script>
<script type="text/javascript">
var MODULE_NAME='<?php echo MODULE_NAME;?>'.toUpperCase();
$('#NAV_'+MODULE_NAME).addClass('cur');
</script>
<style>.tb_button {padding:1px;cursor:pointer;border-right: 1px solid #8b8b8b;border-left: 1px solid #FFF;border-bottom: 1px solid #fff;}.tb_button.hover {borer:2px outset #def; background-color: #f8f8f8 !important;}.ws_toolbar {z-index:100000} .ws_toolbar .ws_tb_btn {cursor:pointer;border:1px solid #555;padding:3px}   .tb_highlight{background-color:yellow} .tb_hide {visibility:hidden} .ws_toolbar img {padding:2px;margin:0px}</style>

</body>
</html>