<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="author" content="<?php echo C('WEB_SITE_TITLE');?>">
    <meta name="keywords" content="<?php echo ($meta_keywords); ?>">
    <meta name="description" content="<?php echo ($meta_description); ?>">
    <meta name="generator" content="CoreThink">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="<?php echo C('WEB_SITE_TITLE');?>">
    <meta name="format-detection" content="telephone=no,email=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo ($meta_title); ?>｜<?php echo C('WEB_SITE_TITLE');?>后台管理</title>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/Public/zui/css/zui.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/Application/Admin/View/Public/css/base.css">
    
    <style type="text/css">
        body {
            background-color: #f6f6f6;
        }
        .panel .logo {
            height: 58px;
        }
    </style>

    <link rel="apple-touch-icon" type="image/x-icon" href="/favicon.ico">
    <script type="text/javascript" src="/Public/jquery/jquery-1.11.1.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/Public/zui/js/zui.min.js" charset="utf-8"></script>
    <!--[if lt IE 9]>
        <script type="text/javascript" src=""/Public/ieonly/html5shiv.js" charset="utf-8"></script>
        <script type="text/javascript" src=""/Public/ieonly/respond.js" charset="utf-8"></script>
        <script type="text/javascript" src=""/Public/ieonly/excanvas.js" charset="utf-8"></script>
    <![endif]-->
    <script type="text/javascript" src="/Public/corethink/js/base.js" charset="utf-8"></script>
    <script type="text/javascript">
        $(function(){
            $("[data-toggle='tooltip']").tooltip(); //启用工具提示
        });
    </script>
    
    <script type="text/javascript" src="/Public/highcharts/highcharts.js" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/Public/daterangepicker/daterangepicker-bs3.css" />
    <script type="text/javascript" src="/Public/daterangepicker/moment.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/Public/daterangepicker/daterangepicker.js" charset="utf-8"></script>
    <script>
        $(function (){
            //dashboard
            if($.fn.dashboard) $('#dashboard').dashboard({shadowType: 'normal'});

            $('#user-chart').highcharts({
                chart: {
                    type: "spline",
                    style: {
                        fontFamily: '"Microsoft Yahei", "宋体"'
                    }
                },
                title: {
                    text: '<?php echo ($start_date); ?>－<?php echo ($end_date); ?> <?php echo ($count_day); ?>天用户增长',
                    x: -20 //center
                },
                xAxis: {
                    categories: eval('<?php echo ($user_reg_date); ?>'),
                    title: {
                        text: '当天新注册会员',
                        enabled: false
                    }
                },
                yAxis: {
                    title: '用户数'
                },
                legend: {
                    layout: 'vertical',
                    verticalAlign: 'middle',
                    borderWidth: 0,
                    enabled: false
                },
                series: [{
                    name: '当天新注册会员',
                    data: eval('<?php echo ($user_reg_count); ?>'),
                    enable: true
                }], credits: {enabled: false}
            });

            //图表时间段选择
            var option_set = {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2015',
                maxDate: '12/31/2100',
                dateLimit: { days: 360 },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                   '最近7天': [moment().subtract(6, 'days'), moment()],
                   '这个月': [moment().startOf('month'), moment().endOf('month')],
                   '上个月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-sm btn-primary',
                cancelClass: 'btn-sm',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: '确定',
                    cancelLabel: '清除',
                    fromLabel: '从',
                    toLabel: '到',
                    customRangeLabel: '自定义',
                    daysOfWeek: ['日', '一', '二', '三', '四', '五','六'],
                    monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                    firstDay: 1
                }
            };

            $('#daterange_set').daterangepicker(option_set, function(start, end, label){
                var url = '<?php echo U("Index/index");?>';
                var query  = 'start_date='+start+'&end_date='+end;
                if(url.indexOf('?')>0){
                    url += '&' + query;
                }else{
                    url += '?' + query;
                }
                window.location.href = url;
            });
        });
    </script>

</head>
<body>
    <nav class="navbar navbar-corethink" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse-top">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php if(C('WEB_SITE_LOGO')): ?>
                <a class="navbar-brand" target="_blank" href="/"><img class="logo" src="<?php echo (get_cover(C("WEB_SITE_LOGO"),'path')); ?>"></a>
            <?php else: ?>
                <a class="navbar-brand" target="_blank" href="/"><?php echo C('WEB_SITE_TITLE');?></a>
            <?php endif; ?>
        </div>
        <div class="collapse navbar-collapse navbar-collapse-top">
            <!-- 顶部主导航 -->
            <ul class="nav navbar-nav">
                <?php if(is_array($__ALLMENULIST__)): $i = 0; $__LIST__ = $__ALLMENULIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li <?php if($vo['id'] == $__CURRENT_ROOTMENU__) echo 'class="active"'; ?> >
                        <a href="<?php echo U($vo['url']);?>"><i class="<?php echo ($vo["icon"]); ?>"></i> <?php echo ($vo["title"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo U('Index/rmdirr');?>" class="ajax-get"><i class="icon-trash"></i> 清空缓存</a></li>
                <li><a target="_blank" href="http://www<?php echo DOMAIN;?>/"><i class="icon-copy"></i> 打开前台</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i> <?php echo ($__USER__["username"]); ?> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo U('User/edit', array('id' => is_login()));?>"><i class="icon-user"></i> 修改昵称</a></li>
                        <li><a href="<?php echo U('User/edit', array('id' => is_login()));?>"><i class="icon-lock"></i> 修改密码</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo U('Public/logout');?>" class="ajax-get"><i class="icon-signout"></i> 退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="wrap">
        
    <div class="container">
        <div id="dashboard" class="dashboard dashboard-draggable" data-height="300">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 " data-id="1">
                    <div class="panel" id="panel1" data-id="1">
                        <div class="panel-heading">
                            <div class="panel-actions"></div>
                            <i class="icon-list-ul"></i> 关于我们
                        </div>
                        <div class="panel-body">
<p>一玩速网页游戏运营平台成立于2016年01月01日,隶属于山东雷云网络科技有限公司</p>
<p>什么是目标?朝思暮想,做梦都想,时刻都想,而且一想就热血沸腾,那才叫目标</p>
<p>什么是团队?一起经历风雨,跌宕起伏,浴血奋战,荣辱与共,艰难困境,依然迎难而上,创造奇迹,那才叫团队</p> 
<p>什么是事业?一群志同道合的人一起干一件一生都干不完的有意义的事,顺便挣点一生都花不完的钱,那才叫事业</p> 
<p>有目标的人在奔跑,没目标的人在流浪;有目标的人在感恩,没目标的人在抱怨;有目标的人睡不着;没目标的人睡不醒</p> 
<p>我们的目标:磨剑三载,把一玩速打造成为中国最知名的网页游戏平台</p>
<p>最后,这在祝愿大家工作愉快,身体健康,(By:江水)</p>         
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 " data-id="2">
                    <div class="panel" id="panel2" data-id="2">
                        <div class="panel-heading">
                            <div class="panel-actions"></div>
                            <i class="icon-list-ul"></i> 系统信息
                        </div>
                        <div class="panel-body">
                            <table class="table table-condensed">
                                <tbody>
                                        <tr>
                                            <td>Game版本</td>
                                            <td><?php echo C('CORETHINK_VERSION');?></td>
                                        </tr>
                                        <tr>
                                            <td>ThinkPHP版本</td>
                                            <td><?php echo (THINK_VERSION); ?></td>
                                        </tr>
                                        <tr>
                                            <td>服务器操作系统</td>
                                            <td><?php echo (PHP_OS); ?></td>
                                        </tr>
                                        <tr>
                                            <td>运行环境</td>
                                            <td><?php echo ($_SERVER['SERVER_SOFTWARE']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>MYSQL版本</td>
                                            <td><?php $system_info_mysql = M()->query("select version() as v;"); echo ($system_info_mysql["0"]["v"]); ?></td>
                                        </tr>
                                        <tr>
                                            <td>上传限制</td>
                                            <td><?php echo ini_get('upload_max_filesize');?></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 " data-id="3">
                    <div class="panel" id="panel3" data-id="3">
                        <div class="panel-heading">
                            <div class="panel-actions"></div>
                            <i class="icon-list-ul"></i> 产品团队
                        </div>
                        <div class="panel-body">
                            <table class="table table-condensed">
                                <tbody>
                                        <tr>
                                            <td>总策划</td>
                                            <td>尚涛</td>
                                        </tr>
                                        <tr>
                                            <td>产品设计及研发团队</td>
                                            <td>荣航</td>
                                        </tr>
                                        <tr>
                                            <td>界面及用户体验团队</td>
                                            <td>荣航</td>
                                        </tr>
                                        <tr>
                                            <td>官方网址</td>
                                            <td><a href="#">http://www.qiluwan.com</a></td>
                                        </tr>
                                        <tr>
                                            <td>官方QQ群</td>
                                            <td><a target="_blank" href="#" title=""></a>182313516</td>
                                        </tr>
                                        <tr>
                                            <td>联系我们</td>
                                            <td>282966003@qq.com</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-12 " data-id="4">
                    <div class="panel" id="panel4" data-id="4">
                        <div class="panel-heading">
                            <div class="panel-actions">
                                <button id="daterange_set" class="btn btn-mini"><span class="icon-cog"></span></button>
                            </div>
                            <i class="icon-user"></i> 用户增长统计
                        </div>
                        <div class="panel-body" id="user-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>
</html>