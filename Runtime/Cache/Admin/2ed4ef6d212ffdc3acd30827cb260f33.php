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
        
            <div class="col-xs-12 col-sm-2 left">
                <nav class="menu menu-corethink" data-toggle="menu">
                    <!-- 侧边导航 -->
                    <ul class="nav nav-primary">
                        <?php $__SIDEMENU__ = sort_field('SORT_ASC','sort',$__ALLMENULIST__[$__CURRENT_ROOTMENU__]['_child']); ?>
                        <?php if(is_array($__SIDEMENU__)): $i = 0; $__LIST__ = $__SIDEMENU__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="show">
                                <a href="#"><i class="icon-folder-open-alt"></i> <?php echo ($vo["title"]); ?></a>
                                <ul class="nav">
                                    <?php if(is_array($vo["_child"])): $i = 0; $__LIST__ = $vo["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo_child): $mod = ($i % 2 );++$i;?><li <?php if(in_array($vo_child['id'], $__PARENT_MENU_ID__)) echo 'class="active"'; ?> >
                                            <a href="<?php echo U($vo_child['url']);?>"><i class="<?php echo ($vo_child["icon"]); ?>"></i> <?php echo ($vo_child["title"]); ?></a>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-xs-12 col-sm-10 right">
                <div class="title">
                    <ul class="breadcrumb">
                        <li><i class="icon-location-arrow"></i></li>
                        <?php if(is_array($__PARENT_MENU__)): $i = 0; $__LIST__ = $__PARENT_MENU__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U($vo['url']);?>"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                
    <style type="text/css">
    .builder .toolbar>div>.btn{
        margin-right: 5px;
    }
    .builder .toolbar .btn,
    .builder .toolbar .nav-pills{
        margin-bottom: 10px;
    }
    .builder .toolbar .tab{
        margin:0px 10px;
    }
	
	.well {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
}
</style>
<link rel="stylesheet" type="text/css" href="/Public/huploadify/huploadify.css">
<link rel="stylesheet" type="text/css" href="/Public/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="/Public/chosen/chosen.icons.min.css">
<link rel="stylesheet" type="text/css" href="/Public/daterangepicker/daterangepicker-bs3.css" />
<link rel="stylesheet" type="text/css" href="/Public/tokeninput/token-input.css">
<script type="text/javascript" src="/Public/kindeditor/kindeditor-min.js" charset="utf-8"></script>
<script type="text/javascript" src="/Public/huploadify/huploadify.js" charset="utf-8"></script>
<script type="text/javascript" src="/Public/chosen/chosen.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/Public/chosen/chosen.icons.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/Public/daterangepicker/moment.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/Public/daterangepicker/daterangepicker.js" charset="utf-8"></script>
<script type="text/javascript" src="/Public/tokeninput/jquery.tokeninput.min.js"></script>
<script type="text/javascript" src="/Public/jquery/jquery.dragsort.min.js"></script>
<script type="text/javascript">
    $(function(){
        window.daterangepicker_locale = {
            applyLabel: '确定',
            cancelLabel: '取消',
            fromLabel: '从',
            toLabel: '到',
            customRangeLabel: '自定义',
            daysOfWeek: ['日', '一', '二', '三', '四', '五','六'],
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            firstDay: 1
        };
    });
</script>
<div class="builder <?php echo ($builder_class); ?>">
    <div class="row toolbar">
        <?php if(!empty($form_items)): ?><div class="col-xs-12">
             <form action="<?php echo ($url); ?>" method="get" class="form builder-form">
				   <div class="search_type cc mb10"> 
						<div class="mb10 well">
							<span class="mr20">
				<?php if(is_array($form_items)): $i = 0; $__LIST__ = $form_items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$form): $mod = ($i % 2 );++$i; echo ($form["title"]); ?>:
					<?php switch($form["type"]): case "hidden": ?><input type="hidden" class="form-control" name="<?php echo ($form["name"]); ?>" value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>><?php break;?>
                        <!-- 数字 -->
                        <?php case "num": ?><input type="text" class="form-control num" name="<?php echo ($form["name"]); ?>" value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>><?php break;?>
                        <!-- 字符串 -->
                        <?php case "text": ?><input type="text" class="text" name="<?php echo ($form["name"]); ?>" value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>><?php break;?>
                        <!-- 文本 -->
                        <?php case "textarea": ?><textarea class="form-control textarea" name="<?php echo ($form["name"]); ?>" <?php echo ($form["extra_attr"]); ?>><?php echo ($form["value"]); ?></textarea><?php break;?>
                        <!-- 数组 -->
                        <?php case "array": ?><textarea class="form-control textarea" name="<?php echo ($form["name"]); ?>" <?php echo ($form["extra_attr"]); ?>><?php echo ($form["value"]); ?></textarea><?php break;?>
                        <!-- 密码 -->
                        <?php case "password": ?><input type="password" class="form-control password" name="<?php echo ($form["name"]); ?>" value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>><?php break;?>
                        <!-- 单选按钮 -->
                        <?php case "radio": if(is_array($form["options"])): foreach($form["options"] as $option_key=>$option): ?><label class="radio-inline" for="<?php echo ($form["name"]); echo ($option_key); ?>">
                                    <input type="radio" id="<?php echo ($form["name"]); echo ($option_key); ?>" class="checkbox" name="<?php echo ($form["name"]); ?>" value="<?php echo ($option_key); ?>" <?php if(($form["value"]) == $option_key): ?>checked<?php endif; ?> <?php echo ($form["extra_attr"]); ?>> <?php echo ($option); ?>
                                </label><?php endforeach; endif; break;?>
                        <!-- 复选框 -->
                        <?php case "checkbox": if(is_array($form["options"])): foreach($form["options"] as $option_key=>$option): ?><label class="checkbox-inline">
                                    <input type="checkbox" name="<?php echo ($form["name"]); ?>[]" value="<?php echo ($option_key); ?>" <?php if(in_array(($option_key), is_array($form["value"])?$form["value"]:explode(',',$form["value"]))): ?>checked<?php endif; ?> <?php echo ($form["extra_attr"]); ?>><?php echo ($option); ?>
                                </label><?php endforeach; endif; break;?>
                        <!-- 下拉框 -->
                        <?php case "select": ?><select name="<?php echo ($form["name"]); ?>"  <?php echo ($form["extra_attr"]); ?>>
                                <option value=''>请选择：</option>
                                <?php if(is_array($form["options"])): foreach($form["options"] as $option_key=>$option): ?><option value="<?php echo ($option_key); ?>" <?php if(($form["value"]) == $option_key): ?>selected<?php endif; ?>><?php echo ($option); ?></option><?php endforeach; endif; ?>
                            </select><?php break;?>
                        <!-- 图标 -->
                        <?php case "icon": ?><select class="chosen-icon" name="<?php echo ($form["name"]); ?>" data-value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>></select><?php break;?>
                        <!-- 日期 -->
                        <?php case "date": ?><input type="text" class="date time_<?php echo ($key); ?>" name="<?php echo ($form["name"]); ?>" value="<?php if(!empty($form["value"])): echo (time_format($form["value"],'Y-m-d')); endif; ?>" <?php echo ($form["extra_attr"]); ?>>
                            <script type="text/javascript">
                                $(function(){
                                    $(".time_<?php echo ($key); ?>").daterangepicker({
                                        showDropdowns: true,
                                        singleDatePicker: true,
                                        startDate: moment().subtract(0, 'days'),
                                        format: 'YYYY-MM-DD',
                                        locale: window.daterangepicker_locale
                                    });
                                });
                            </script><?php break;?>
						
						 <?php case "timetotime": ?><input type="text" class="time time_<?php echo ($key); ?>" name="<?php echo ($form["name"]); ?>_start" value="<?php echo ($_GET['date_start']); ?>" <?php echo ($form["extra_attr"]); ?>>至 <input type="text" class="time time_<?php echo ($key+100); ?>" name="<?php echo ($form["name"]); ?>_end" value="<?php echo ($_GET['date_end']); ?>" <?php echo ($form["extra_attr"]); ?>>
							
							
                            <script type="text/javascript">
                                $(function(){
                                    $(".time_<?php echo ($key); ?>").daterangepicker({
                                        showDropdowns: true,
                                        singleDatePicker: true,
                                        startDate: moment().subtract(0, 'days'),
                                        timePicker: true,
                                        timePickerIncrement: 5,
                                        format: 'YYYY-MM-DD h:mm',
                                        locale: window.daterangepicker_locale
                                    });
									$(".time_<?php echo ($key+100); ?>").daterangepicker({
                                        showDropdowns: true,
                                        singleDatePicker: true,
                                        startDate: moment().subtract(0, 'days'),
                                        timePicker: true,
                                        timePickerIncrement: 5,
                                        format: 'YYYY-MM-DD h:mm',
                                        locale: window.daterangepicker_locale
                                    });
                                });
                            </script><?php break;?>
                        <!-- 时间 -->
                        <?php case "time": ?><input type="text" class="time time_<?php echo ($key); ?>" name="<?php echo ($form["name"]); ?>" value="<?php if(!empty($form["value"])): echo (time_format($form["value"])); endif; ?>" <?php echo ($form["extra_attr"]); ?>>
                            <script type="text/javascript">
                                $(function(){
                                    $(".time_<?php echo ($key); ?>").daterangepicker({
                                        showDropdowns: true,
                                        singleDatePicker: true,
                                        startDate: moment().subtract(0, 'days'),
                                        timePicker: true,
                                        timePickerIncrement: 5,
                                        format: 'YYYY-MM-DD h:mm',
                                        locale: window.daterangepicker_locale
                                    });
                                });
                            </script><?php break; endswitch;?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
						<input type="submit" class="btn btn-primary" name="submit1" value="搜索">
							</span>
						</div> 
					</div>
				</form>
            </div><?php endif; ?>
        
   
      
    </div>
    <div class="data-table" id="data_table" style="width: 100%;height:800px;"></div>
</div>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/echartsmin.js"></script>
<script type="text/javascript">
$(document).ready(function() {
var myChart = echarts.init(document.getElementById('data_table'));
      var option = {
	  title: {
			show : true,
			text : '<?php echo ($echarts_title); ?>'
	  },
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
	toolbox: {
        feature: {
            dataView: {show: true, readOnly: false},
            magicType: {show: true, type: ['line', 'bar']},
            restore: {show: true},
            saveAsImage: {show: true}
        }
    },
    legend: {
        data:[<?php echo ($echarts_legend); ?>]
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            data : [<?php echo ($echarts_category); ?>]
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
		<?php if(is_array($echarts_field)): $i = 0; $__LIST__ = $echarts_field;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>{
            name:'<?php echo ($vo["name"]); ?>',
            type:'bar',
			label: {
                normal: {
                    show: true
                }
            },
			markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
            markLine : {
                data : [
                    {type : 'average', name: '平均值'}
                ]
            },
            data:[<?php echo ($vo["data"]); ?>]
        },<?php endforeach; endif; else: echo "" ;endif; ?>
    ]
};
myChart.setOption(option);
});
</script>

            </div>
        
    </div>
</body>
</html>