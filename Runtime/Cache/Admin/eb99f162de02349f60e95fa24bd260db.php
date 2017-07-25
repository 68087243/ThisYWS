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
    
    <script type="text/javascript">
        $(function(){
            var $form = $("#export-form"), $export = $("#export"), tables, $optimize = $("#optimize"), $repair = $("#repair");
            $optimize.add($repair).click(function(){
                $.post(this.href, $form.serialize(), function(data){
                    if(data.status){
                        alertMessager(data.info, 'success');
                    }else{
                        alertMessager(data.info, 'danger');
                    }
                    setTimeout(function(){
                        $(that).removeClass('disabled').prop('disabled',false);
                    },1000);
                }, "json");
                return false;
            });

            $export.click(function(){
                $export.parent().children().addClass("disabled");
                $export.html("正在发送备份请求...");
                $.post(
                    $form.attr("action"),
                    $form.serialize(),
                    function(data){
                        if(data.status){
                            tables = data.tables;
                            $export.html(data.info + "开始备份，请不要关闭本页面！");
                            backup(data.tab);
                            window.onbeforeunload = function(){ return "正在备份数据库，请不要关闭！" }
                        }else{
                            alertMessager(data.info, 'danger');
                            $export.parent().children().removeClass("disabled");
                            $export.html("立即备份");
                            setTimeout(function(){
                                $(that).removeClass('disabled').prop('disabled',false);
                            },2000);
                        }
                    },"json");
                return false;
            });

            function backup(tab, status){
                status && showmsg(tab.id, "开始备份...(0%)");
                $.get($form.attr("action"), tab, function(data){
                    if(data.status){
                        showmsg(tab.id, data.info);
                        if(!$.isPlainObject(data.tab)){
                            $export.parent().children().removeClass("disabled");
                            $export.html("备份完成，点击重新备份");
                            window.onbeforeunload = function(){ return null }
                            return;
                        }
                        backup(data.tab, tab.id != data.tab.id);
                    }else{
                        alertMessager(data.info, 'danger');
                        $export.parent().children().removeClass("disabled");
                        $export.html("立即备份");
                        setTimeout(function(){
                            $(that).removeClass('disabled').prop('disabled',false);
                        },2000);
                    }
                }, "json");
            }

            function showmsg(id, msg){
                $form.find("input[value=" + tables[id] + "]").closest("tr").find(".info").html(msg);
            }
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
                
    <div class="toolbar">
        <a id="export" class="btn" href="javascript:;" autocomplete="off">立即备份</a>
        <a id="optimize" class="btn" href="<?php echo U('optimize');?>">优化表</a>
        <a id="repair" class="btn" href="<?php echo U('repair');?>">修复表</a>
    </div>
    <!-- 数据列表 -->
    <div class="data-table">
        <form id="export-form" method="post" action="<?php echo U('do_export');?>">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><input class="check-all" checked="chedked" type="checkbox" value=""></th>
                        <th>表名</th>
                        <th class="hidden-xs">数据量</th>
                        <th class="hidden-xs"">数据大小</th>
                        <th class="hidden-xs">创建时间</th>
                        <th width="160">备份状态</th>
                        <th width="120">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$table): $mod = ($i % 2 );++$i;?><tr>
                            <td class="num"><input class="ids" checked="chedked" type="checkbox" name="tables[]" value="<?php echo ($table["name"]); ?>"></td>
                            <td><?php echo ($table["name"]); ?></td>
                            <td class="hidden-xs"><?php echo ($table["rows"]); ?></td>
                            <td class="hidden-xs"><?php echo ($table["data_length"]); ?></td>
                            <td class="hidden-xs"><?php echo ($table["create_time"]); ?></td>
                            <td class="info">未备份</td>
                            <td class="action">
                                <a class="ajax-get no-refresh" href="<?php echo U('optimize?tables='.$table['name']);?>">优化表</a>&nbsp;
                                <a class="ajax-get no-refresh" href="<?php echo U('repair?tables='.$table['name']);?>">修复表</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </form>
    </div>
    <!-- /数据列表 -->

            </div>
        
    </div>
</body>
</html>