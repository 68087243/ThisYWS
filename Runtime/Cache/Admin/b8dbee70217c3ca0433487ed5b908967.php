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
    .builder .toolbar input,
    .builder .toolbar .nav-pills{
        margin-bottom: 10px;
    }
    .builder .toolbar .tab{
        margin:0px 10px;
    }
    .form select,
    .form textarea,
    .form input[type=text],
    .form input[type=password],
    .form .chosen-container,
    .form .token-input-list{
        width: 50% !important;
        max-width: 600px;
        border-color: #ddd;
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
        $(".form .controls select.form-control").chosen({disable_search: true}); //使用chosen插件接管select
        $('.form .chosen-icon').chosenIcons(); //使用chosen插件选择WebFont
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
        <?php if(!empty($tab_list)): ?><div class="tab">
                <ul class="nav nav-pills">
                    <?php if(is_array($tab_list)): $i = 0; $__LIST__ = $tab_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?><li class="<?php if($current_tab == $key) echo 'active'; ?>"><a href="<?php echo U($tab_url, array('tab' => $key));?>"><?php echo ($tab); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div><?php endif; ?>
    </div>
    <form action="<?php echo ($url); ?>" method="post" class="form builder-form">
        <?php if(is_array($form_items)): $i = 0; $__LIST__ = $form_items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$form): $mod = ($i % 2 );++$i;?><div class="form-group item_<?php echo ($form["name"]); ?> <?php echo ($form["extra_class"]); ?>">
                <?php if($form['type'] != 'group' && $form['type'] != 'hidden'): ?>
                    <label class="item-label"><?php echo ($form["title"]); if(!empty($form["tip"])): ?><span class="check-tips">（<?php echo ($form["tip"]); ?>）</span><?php endif; ?></label>
                <?php endif; ?>
                <div class="controls">
                    <?php switch($form["type"]): case "hidden": ?><input type="hidden" class="form-control" name="<?php echo ($form["name"]); ?>" value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>><?php break;?>
                        <!-- 数字 -->
                        <?php case "num": ?><input type="text" class="form-control num" name="<?php echo ($form["name"]); ?>" value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>><?php break;?>
                        <!-- 字符串 -->
                        <?php case "text": ?><input type="text" class="form-control text" name="<?php echo ($form["name"]); ?>" value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>><?php break;?>
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
                        <?php case "select": ?><select name="<?php echo ($form["name"]); ?>" class="form-control" <?php echo ($form["extra_attr"]); ?>>
                                <option value=''>请选择：</option>
                                <?php if(is_array($form["options"])): foreach($form["options"] as $option_key=>$option): ?><option value="<?php echo ($option_key); ?>" <?php if(($form["value"]) == $option_key): ?>selected<?php endif; ?>><?php echo ($option); ?></option><?php endforeach; endif; ?>
                            </select><?php break;?>
                        <!-- 图标 -->
                        <?php case "icon": ?><select class="chosen-icon" name="<?php echo ($form["name"]); ?>" data-value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>></select><?php break;?>
                        <!-- 日期 -->
                        <?php case "date": ?><input type="text" class="form-control date time_<?php echo ($key); ?>" name="<?php echo ($form["name"]); ?>" value="<?php if(!empty($form["value"])): echo (time_format($form["value"],'Y-m-d')); endif; ?>" <?php echo ($form["extra_attr"]); ?>>
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
                        <!-- 时间 -->
                        <?php case "time": ?><input type="text" class="form-control time time_<?php echo ($key); ?>" name="<?php echo ($form["name"]); ?>" value="<?php if(!empty($form["value"])): echo (time_format($form["value"])); endif; ?>" <?php echo ($form["extra_attr"]); ?>>
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
                            </script><?php break;?>
                        <!-- 图片 -->
                        <?php case "picture": ?><div id="upload_<?php echo ($key); ?>" <?php echo ($form["extra_attr"]); ?>></div>
                            <div id="preview_<?php echo ($key); ?>">
                                <input type="hidden" name="<?php echo ($form["name"]); ?>" value="<?php echo ($form["value"]); ?>">
                                <img style="margin-top:8px;max-height:60px;" src="<?php echo (get_cover($form["value"])); ?>">
                            </div>
                            <script type="text/javascript">
                                $(function(){
                                    $('#upload_<?php echo ($key); ?>').Huploadify({
                                        uploader:'<?php echo U("Upload/upload");?>',
                                        fileTypeExts:'*.gif;*.jpg;*.jpeg;*.png;*.bmp',
                                        fileSizeLimit:<?php echo C('UPLOAD_IMAGE_SIZE');?>*1024,
                                        buttonText:'上 传 图 片',
                                        onUploadComplete:function(file, data){
                                            var data = $.parseJSON(data);
                                            $('#preview_<?php echo ($key); ?> img').attr('src', data.url);
                                            $('#preview_<?php echo ($key); ?> input').attr('value', data.id);
                                        }
                                    });
                                });
                            </script><?php break;?>
                        <!-- 编辑器 -->
                        <?php case "kindeditor": ?><textarea id="kindeditor_<?php echo ($key); ?>" name="<?php echo ($form["name"]); ?>" class="form-control" <?php echo ($form["extra_attr"]); ?>><?php echo ($form["value"]); ?></textarea>
                            <script type="text/javascript">
                                $(function(){
                                    var editor_<?php echo ($tab_key); ?>;
                                    KindEditor.ready(function(K) {
                                        kindeditor_<?php echo ($key); ?> = K.create('#kindeditor_<?php echo ($key); ?>', {
                                            allowFileManager : false,
                                            width: '100%',
                                            height: '500px',
                                            cssPath : [
                                                '/Public/zui/css/zui.min.css',
                                                '/Public/kindeditor/plugins/code/prettify.css'
                                            ],
                                            resizeType: 1,
                                            pasteType : 2,
                                            urlType : 'absolute',
                                            fileManagerJson : '<?php echo U("Upload/fileManager");?>',
                                            uploadJson : '<?php echo U("Upload/upload");?>',
                                            remoteImgSaveUrl: '<?php echo U("Upload/downremoteimg");?>',
                                            extraFileUploadParams: {
                                                session_id : '<?php echo session_id();?>'
                                            },
                                            afterBlur: function(){this.sync();},
                                            autoSaveMode:true,
                                            autoSaveInterval:100,
                                            afterCreate: function() {
                                                this.loadPlugin('autosave');
                                            }
                                        });
                                    });
                                });
                            </script><?php break;?>
                        <!-- 标签 -->
                        <?php case "tags": ?><input type="text" class="form-control tag_<?php echo ($key); ?>" name="<?php echo ($form["name"]); ?>" value="<?php echo ($form["value"]); ?>" <?php echo ($form["extra_attr"]); ?>>
                            <script type="text/javascript">
                                $(function(){
                                    //标签自动完成
                                    var tags = $('.tag_<?php echo ($key); ?>'), tagsPre = [];
                                    if (tags.length > 0) {
                                        var items = tags.val().split(','), result = [];
                                        for (var i = 0; i < items.length; i ++) {
                                            var tag = items[i];
                                            if (!tag) {
                                                continue;
                                            }
                                            tagsPre.push({
                                                id      :   tag,
                                                title   :   tag
                                            });
                                        }
                                    }
                                    tags.tokenInput('<?php echo U("Tag/searchTags");?>',{
                                        propertyToSearch    :   'title',
                                        tokenValue          :   'title',
                                        searchDelay         :   0,
                                        tokenLimit          :   5,
                                        preventDuplicates   :   true,
                                        animateDropdown     :   true,
                                        allowFreeTagging    :   true,
                                        hintText            :   '请输入标签名',
                                        noResultsText       :   '此标签不存在, 按回车创建',
                                        searchingText       :   "查找中...",
                                        prePopulate         :   tagsPre,
                                        onAdd: function (item){ //新增系统没有的标签时提交到数据库
                                            $.post('<?php echo U("Tag/add");?>', {'title': item.title});
                                        }
                                    });
                                });
                            </script><?php break;?>
                        <!-- 拖动排序 -->
                        <?php case "board": ?><input type="hidden" name="<?php echo ($form["name"]); ?>" value='<?php echo ($form["value"]); ?>'>
                            <div class="boards boards_<?php echo ($key); ?>" <?php echo ($form["extra_attr"]); ?>>
                                <?php if(is_array($form["options"])): foreach($form["options"] as $option_key=>$option): ?><div class="board panel" data-id="<?php echo ($option_key); ?>" style="position:relative">
                                        <div class="panel-heading">
                                            <strong><?php echo ($option["title"]); ?></strong>
                                        </div>
                                        <div class="panel-body dragsort_<?php echo ($key); ?>" data-group="<?php echo ($option_key); ?>">
                                            <?php if(is_array($option["field"])): foreach($option["field"] as $option_field_key=>$option_field): ?><div class="board-item">
                                                    <em data="<?php echo ($field['id']); ?>"><?php echo ($option_field); ?></em>
                                                    <input type="hidden" name="<?php echo ($form["name"]); ?>[<?php echo ($option_key); ?>][]" value="<?php echo ($option_field_key); ?>"/>
                                                </div><?php endforeach; endif; ?>
                                        </div>
                                    </div><?php endforeach; endif; ?>
                            </div>
                            <script type="text/javascript">
                                //拖曳插件初始化
                                $(function(){
                                    $(".dragsort_<?php echo ($key); ?>").dragsort({
                                         dragSelector:'div',
                                         placeHolderTemplate: '<div class="clearfix draging-place">&nbsp;</div>',
                                         dragBetween:true, //允许拖动到任意地方
                                         dragEnd:function(){
                                             var self = $(this);
                                             self.find('input').attr('name', '<?php echo ($form["name"]); ?>[' + self.closest('.dragsort_<?php echo ($key); ?>').data('group') + '][]');
                                         }
                                     });
                                });
                            </script><?php break;?>
                        <?php case "group": ?><ul class="nav-tabs nav">
                                <?php if(is_array($form["options"])): $i = 0; $__LIST__ = $form["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><li data-tab="tab<?php echo ($i); ?>" <?php if(($i) == "1"): ?>class="active"<?php endif; ?>><a href="#tab<?php echo ($i); ?>" data-toggle="tab"><?php echo ($li["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                            <div class="tab-content">
                                <?php if(is_array($form["options"])): $i = 0; $__LIST__ = $form["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?><div id="tab<?php echo ($i); ?>" class='tab-pane <?php if(($i) == "1"): ?>active<?php endif; ?> tab<?php echo ($i); ?>'>
                                        <div class="controls">
                                            <?php if(is_array($tab["options"])): $tab_key = 0; $__LIST__ = $tab["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab_form): $mod = ($tab_key % 2 );++$tab_key;?><div class="form-group <?php echo ($tab_form["extra_class"]); ?>">
                                                    <label class="item-label"><?php echo ($tab_form["title"]); if(!empty($tab_form["tip"])): ?><span class="check-tips">（<?php echo ($tab_form["tip"]); ?>）</span><?php endif; ?></label>
                                                    <div class="controls">
                                                        <?php switch($tab_form["type"]): case "hidden": ?><input type="hidden" class="form-control" name="<?php echo ($tab_form["name"]); ?>" value="<?php echo ($tab_form["value"]); ?>" <?php echo ($tab_form["extra_attr"]); ?>><?php break;?>
                                                            <!-- 数字 -->
                                                            <?php case "num": ?><input type="text" class="form-control num" name="<?php echo ($tab_form["name"]); ?>" value="<?php echo ($tab_form["value"]); ?>" <?php echo ($tab_form["extra_attr"]); ?>><?php break;?>
                                                            <!-- 字符串 -->
                                                            <?php case "text": ?><input type="text" class="form-control text" name="<?php echo ($tab_form["name"]); ?>" value="<?php echo ($tab_form["value"]); ?>" <?php echo ($tab_form["extra_attr"]); ?>><?php break;?>
                                                            <!-- 文本 -->
                                                            <?php case "textarea": ?><textarea class="form-control textarea" name="<?php echo ($tab_form["name"]); ?>" <?php echo ($tab_form["extra_attr"]); ?>><?php echo ($tab_form["value"]); ?></textarea><?php break;?>
                                                            <!-- 数组 -->
                                                            <?php case "array": ?><textarea class="form-control textarea" name="<?php echo ($form["name"]); ?>" <?php echo ($tab_form["extra_attr"]); ?>><?php echo ($form["value"]); ?></textarea><?php break;?>
                                                            <!-- 密码 -->
                                                            <?php case "password": ?><input type="password" class="form-control password" name="<?php echo ($tab_form["name"]); ?>" value="<?php echo ($tab_form["value"]); ?>" <?php echo ($tab_form["extra_attr"]); ?>><?php break;?>
                                                            <!-- 单选按钮 -->
                                                            <?php case "radio": if(is_array($tab_form["options"])): foreach($tab_form["options"] as $option_key=>$option): ?><label class="radio-inline" for="<?php echo ($form["name"]); echo ($option_key); ?>">
                                                                        <input type="radio" id="<?php echo ($form["name"]); echo ($option_key); ?>" class="checkbox" name="<?php echo ($tab_form["name"]); ?>" value="<?php echo ($option); ?>" <?php if(($tab_form["value"]) == $option_key): ?>checked<?php endif; ?> <?php echo ($tab_form["extra_attr"]); ?>> <?php echo ($option); ?>
                                                                    </label><?php endforeach; endif; break;?>
                                                            <!-- 复选框 -->
                                                            <?php case "checkbox": if(is_array($tab_form["options"])): foreach($tab_form["options"] as $option_key=>$option): ?><label class="checkbox-inline">
                                                                        <input type="checkbox" name="<?php echo ($tab_form["name"]); ?>[]" value="<?php echo ($option_key); ?>" <?php if(in_array(($option_key), is_array($tab_form["value"])?$tab_form["value"]:explode(',',$tab_form["value"]))): ?>checked<?php endif; ?> <?php echo ($tab_form["extra_attr"]); ?>><?php echo ($opt); ?>
                                                                    </label><?php endforeach; endif; break;?>
                                                            <!-- 下拉框 -->
                                                            <?php case "select": ?><select name="<?php echo ($tab_form["name"]); ?>" class="form-control" <?php echo ($tab_form["extra_attr"]); ?>>
                                                                    <option value=''>请选择：</option>
                                                                    <?php if(is_array($tab_form["options"])): foreach($tab_form["options"] as $option_key=>$option): ?><option value="<?php echo ($option_key); ?>" <?php if(($tab_form["value"]) == $option_key): ?>selected<?php endif; ?>><?php echo ($option); ?></option><?php endforeach; endif; ?>
                                                                </select><?php break;?>
                                                            <!-- 图标 -->
                                                            <?php case "icon": ?><select class="chosen-icon" name="<?php echo ($tab_form["name"]); ?>" data-value="<?php echo ($tab_form["value"]); ?>" <?php echo ($tab_form["extra_attr"]); ?>></select><?php break;?>
                                                            <!-- 日期 -->
                                                            <?php case "date": ?><input type="text" class="form-control date time_<?php echo ($tab_key); ?>" name="<?php echo ($tab_form["name"]); ?>" value="<?php if(!empty($tab_form["value"])): echo (time_format($tab_form["value"],'Y-m-d')); endif; ?>" <?php echo ($tab_form["extra_attr"]); ?>>
                                                                <script type="text/javascript">
                                                                    $(function(){
                                                                        $(".time_<?php echo ($tab_key); ?>").daterangepicker({
                                                                            showDropdowns: true,
                                                                            singleDatePicker: true,
                                                                            startDate: moment().subtract(0, 'days'),
                                                                            format: 'YYYY-MM-DD',
                                                                            locale: window.daterangepicker_locale
                                                                        });
                                                                    });
                                                                </script><?php break;?>
                                                            <!-- 时间 -->
                                                            <?php case "time": ?><input type="text" class="form-control time time_<?php echo ($tab_key); ?>" name="<?php echo ($tab_form["name"]); ?>" value="<?php if(!empty($tab_form["value"])): echo (time_format($tab_form["value"])); endif; ?>" <?php echo ($tab_form["extra_attr"]); ?>>
                                                                <script type="text/javascript">
                                                                    $(function(){
                                                                        $(".time_<?php echo ($tab_key); ?>").daterangepicker({
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
                                                            <!-- 图片 -->
                                                            <?php case "picture": ?><div id="upload_<?php echo ($tab_key); ?>" <?php echo ($form["extra_attr"]); ?>></div>
                                                                <div id="preview_<?php echo ($tab_key); ?>">
                                                                    <input type="hidden" name="<?php echo ($tab_form["name"]); ?>" value="<?php echo ($tab_form["value"]); ?>">
                                                                    <img style="margin-top:8px;max-height:60px;" src="<?php echo (get_cover($tab_form["value"])); ?>">
                                                                </div>
                                                                <script type="text/javascript">
                                                                    $(function(){
                                                                        $('#upload_<?php echo ($tab_key); ?>').Huploadify({
                                                                            uploader:'<?php echo U("Upload/upload");?>',
                                                                            fileTypeExts:'*.gif;*.jpg;*.jpeg;*.png;*.bmp',
                                                                            fileSizeLimit:<?php echo C('UPLOAD_IMAGE_SIZE');?>*1024,
                                                                            buttonText:'上 传 图 片',
                                                                            onUploadComplete:function(file, data){
                                                                                var data = $.parseJSON(data);
                                                                                $('#preview_<?php echo ($tab_key); ?> img').attr('src', data.url);
                                                                                $('#preview_<?php echo ($tab_key); ?> input').attr('value', data.id);
                                                                            }
                                                                        });
                                                                    });
                                                                </script><?php break;?>
                                                            <!-- 编辑器 -->
                                                            <?php case "kindeditor": ?><textarea id="kindeditor_<?php echo ($tab_key); ?>" name="<?php echo ($tab_form["name"]); ?>" class="form-control" <?php echo ($tab_form["extra_attr"]); ?>><?php echo ($tab_form["value"]); ?></textarea>
                                                                <script type="text/javascript">
                                                                    $(function(){
                                                                        var kindeditor_<?php echo ($tab_key); ?>;
                                                                        KindEditor.ready(function(K) {
                                                                            kindeditor_<?php echo ($tab_key); ?> = K.create('#kindeditor_<?php echo ($tab_key); ?>', {
                                                                                allowFileManager : false,
																				filterMode: false,
																				width: '100%',
                                                                                height: '500px',
                                                                                cssPath : [
                                                                                    '/Public/zui/css/zui.min.css',
                                                                                    '/Public/kindeditor/plugins/code/prettify.css'
                                                                                ],
                                                                                resizeType: 1,
                                                                                pasteType : 2,
                                                                                urlType : 'absolute',
                                                                                fileManagerJson : '<?php echo U("Upload/fileManager");?>',
                                                                                uploadJson : '<?php echo U("Upload/upload");?>',
                                                                                remoteImgSaveUrl: '<?php echo U("Upload/downremoteimg");?>',
                                                                                extraFileUploadParams: {
                                                                                    session_id : '<?php echo session_id();?>'
                                                                                },
                                                                                afterBlur: function(){this.sync();},
                                                                                autoSaveMode:true,
                                                                                autoSaveInterval:100,
                                                                                afterCreate: function() {
                                                                                    this.loadPlugin('autosave');
                                                                                }
                                                                            });
                                                                        });
                                                                    });
                                                                </script><?php break;?>
                                                            <!-- 标签 -->
                                                            <?php case "tags": ?><input type="text" class="form-control tag_<?php echo ($tab_key); ?>" name="<?php echo ($tab_form["name"]); ?>" value="<?php echo ($tab_form["value"]); ?>" <?php echo ($tab_form["extra_attr"]); ?>>
                                                                <script type="text/javascript">
                                                                    $(function(){
                                                                        //标签自动完成
                                                                        var tags = $('.tag_<?php echo ($tab_key); ?>'), tagsPre = [];
                                                                        if (tags.length > 0) {
                                                                            var items = tags.val().split(','), result = [];
                                                                            for (var i = 0; i < items.length; i ++) {
                                                                                var tag = items[i];
                                                                                if (!tag) {
                                                                                    continue;
                                                                                }
                                                                                tagsPre.push({
                                                                                    id      :   tag,
                                                                                    title   :   tag
                                                                                });
                                                                            }
                                                                        }
                                                                        tags.tokenInput('<?php echo U("Tag/searchTags");?>',{
                                                                            propertyToSearch    :   'title',
                                                                            tokenValue          :   'title',
                                                                            searchDelay         :   0,
                                                                            tokenLimit          :   5,
                                                                            preventDuplicates   :   true,
                                                                            animateDropdown     :   true,
                                                                            allowFreeTagging    :   true,
                                                                            hintText            :   '请输入标签名',
                                                                            noResultsText       :   '此标签不存在, 按回车创建',
                                                                            searchingText       :   "查找中...",
                                                                            prePopulate         :   tagsPre,
                                                                            onAdd: function (item){ //新增系统没有的标签时提交到数据库
                                                                                $.post('<?php echo U("Tag/add");?>', {'title': item.title});
                                                                            }
                                                                        });
                                                                    });
                                                                </script><?php break;?>
                                                            <!-- 拖动排序 -->
                                                            <?php case "board": ?><input type="hidden" name="<?php echo ($tab_form["name"]); ?>" value='<?php echo ($tab_form["value"]); ?>'>
                                                                <div class="boards boards_<?php echo ($tab_key); ?>" <?php echo ($tab_form["extra_attr"]); ?>>
                                                                    <?php if(is_array($tab_form["options"])): foreach($tab_form["options"] as $option_key=>$option): ?><div class="board panel" data-id="<?php echo ($option_key); ?>" style="position:relative">
                                                                            <div class="panel-heading">
                                                                                <strong><?php echo ($option["title"]); ?></strong>
                                                                            </div>
                                                                            <div class="panel-body dragsort_<?php echo ($tab_key); ?>" data-group="<?php echo ($option_key); ?>">
                                                                                <?php if(is_array($option["field"])): foreach($option["field"] as $option_field_key=>$option_field): ?><div class="board-item">
                                                                                        <em data="<?php echo ($option_field_key); ?>"><?php echo ($option_field); ?></em>
                                                                                        <input type="hidden" name="<?php echo ($tab_form["name"]); ?>[<?php echo ($option_key); ?>][]" value="<?php echo ($option_field_key); ?>"/>
                                                                                    </div><?php endforeach; endif; ?>
                                                                            </div>
                                                                        </div><?php endforeach; endif; ?>
                                                                </div>
                                                                <script type="text/javascript">
                                                                    //拖曳插件初始化
                                                                    $(function(){
                                                                        $(".dragsort_<?php echo ($tab_key); ?>").dragsort({
                                                                             dragSelector:'div',
                                                                             placeHolderTemplate: '<div class="clearfix draging-place">&nbsp;</div>',
                                                                             dragBetween:true, //允许拖动到任意地方
                                                                             dragEnd:function(){
                                                                                 var self = $(this);
                                                                                 self.find('input').attr('name', '<?php echo ($tab_form["name"]); ?>[' + self.closest('.dragsort_<?php echo ($tab_key); ?>').data('group') + '][]');
                                                                             }
                                                                         });
                                                                    });
                                                                </script><?php break; endswitch;?>
                                                    </div>
                                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div><?php break; endswitch;?>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <div class="form-group">
            <button class="btn btn-primary submit ajax-post"  type="submit" target-form="builder-form">确 定</button>
            <button class="btn return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
    </form>
    <!-- 额外参数 -->
    <?php switch($extra): case "category": ?><script type="text/javascript">
                //选择模型时页面元素改变
                $(function(){
                    $('input[name="doc_type"]').change(function(){
                        var model_id = $(this).val();
                        if(model_id == 1){ //超链接
                            $('.item_url').removeClass('hidden');
                            $('.item_content').addClass('hidden');
                            $('.item_index_template').addClass('hidden');
                            $('.item_detail_template').addClass('hidden');
                        }else if(model_id == 2){ //单页文档
                            $('.item_url').addClass('hidden');
                            $('.item_content').removeClass('hidden');
                            $('.item_index_template').addClass('hidden');
                            $('.item_detail_template').addClass('hidden');
                        }else{
                            $('.item_url').addClass('hidden');
                            $('.item_content').addClass('hidden');
                            $('.item_index_template').addClass('hidden');
                            $('.item_detail_template').addClass('hidden');
                        }
                    });
                });
            </script><?php break; endswitch;?>
</div>


            </div>
        
    </div>
</body>
</html>