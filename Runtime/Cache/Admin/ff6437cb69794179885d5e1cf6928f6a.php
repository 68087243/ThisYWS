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
</style>

<div class="builder <?php echo ($builder_class); ?>">
    <div class="row toolbar">
        <?php if(!empty($button_list)): ?><div class="col-xs-12 col-sm-9">
                <?php if(is_array($button_list)): $i = 0; $__LIST__ = $button_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$button): $mod = ($i % 2 );++$i;?><a <?php echo ($button["attr"]); ?>><?php echo (htmlspecialchars($button["title"])); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </div><?php endif; ?>
        <?php if(!empty($search)): ?><div class="col-xs-12 col-sm-3">
                <div class="input-group search-form">
                    <input type="text" name="keyword" class="search-input form-control" value="<?php echo ($_GET["keyword"]); ?>" placeholder="<?php echo ($search["title"]); ?>">
                    <span class="input-group-btn"><a class="btn btn-default" href="javascript:;" id="search" url="<?php echo ($search["url"]); ?>"><i class="icon-search"></i></a></span>
                </div>
            </div><?php endif; ?>
        <?php if(!empty($tab_list)): ?><div class="tab">
                <ul class="nav nav-pills">
                    <?php if(is_array($tab_list)): $i = 0; $__LIST__ = $tab_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?><li class="<?php if($current_tab == $key) echo 'active'; ?>"><a href="<?php echo U($tab_url, array('tab' => $key));?>"><?php echo ($tab); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div><?php endif; ?>
        <!-- 额外参数 -->
        <?php switch($extra): case "move": ?><!-- 设置移动（文档模型专用） -->
                <div class="modal fade" id="moveModal">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                                <p class="modal-title">移动至</p>
                            </div>
                            <div class="modal-body">
                                <?php $map['status'] = array('eq', 1); $category_list = D('Category')->where($map)->select(); $tree = new \Common\Util\Tree(); $category_list = $tree->toFormatTree($category_list); ?>
                                <form action="<?php echo U('Document/move');?>" method="post" class="form">
                                    <div class="form-group">
                                        <select name="to_cid" class="form-control">
                                            <?php if(is_array($category_list)): $i = 0; $__LIST__ = $category_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title_show"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="ids">
                                        <input type="hidden" name="from_cid" value="<?php echo ($_GET["cid"]); ?>">
                                        <button class="btn btn-primary btn-block submit ajax-post" type="submit" target-form="form">确 定</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    function move(){
                        var ids = '';
                        $('input[name="ids[]"]:checked').each(function(){
                           ids += ',' + $(this).val();
                        });
                        if(ids != ''){
                            ids = ids.substr(1);
                            $('input[name="ids"]').val(ids);
                            $('.modal-title').html('移动选中的的文章至：');
                            $('#moveModal').modal('show', 'fit')
                        }else{
                            alertMessager('请选择需要移动的文章', 'danger');
                        }
                    }
                </script><?php break; endswitch;?>
        <!-- 额外参数 -->
    </div>
    <div class="data-table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input class="check-all" type="checkbox"></th>
                    <?php if(is_array($field_list)): $i = 0; $__LIST__ = $field_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;?><th><?php echo (htmlspecialchars($field["title"])); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($data_list)): $i = 0; $__LIST__ = $data_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                        <td><input class="ids" type="checkbox" value="<?php echo ($data['id']); ?>" name="ids[]"></td>
                        <?php if(is_array($field_list)): $i = 0; $__LIST__ = $field_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;?><td><?php echo ($data[$field['name']]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <ul class="pager pager-loose pager-pills"><?php if(!empty($page)): echo ($page); endif; ?></ul>
    </div>
</div>
<script type="text/javascript" src="http://static.yiwanshu.com//Public/jquery/jeditable.js"></script>
<script type="text/javascript">
$(document).ready(function() {
      $('.edit_plug').editable('<?php echo U(CONTROLLER_NAME.'/setStatus', array('status' => 'update', 'model' =>CONTROLLER_NAME));?>');
});
</script>

            </div>
        
    </div>
</body>
</html>