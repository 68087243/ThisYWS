<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台访问日志控制器
 * @author C0de <47156503@qq.com>
 */
class UrlLogController extends AdminController{
    /**
     * 访问日志列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|referer|ip|ctime'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $data_list = D('UrlLog')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('UrlLog')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

     

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('推广访问日志列表')  //设置页面标题
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('urlid', 'URL转发ID', 'text')
            ->addField('referer', '来源地址', 'text')
            ->addField('ip', 'IP', 'text')
            ->addField('useragent', '用户UA', 'text')
            ->addField('ctime', '时间', 'time')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('delete') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }



}
