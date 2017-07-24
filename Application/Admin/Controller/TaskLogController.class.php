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
 * 后台任务控制器
 * @author C0de <47156503@qq.com>
 */
class TaskLogController extends AdminController{
    /**
     * 任务列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|uid|tid'] = array($condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('TaskLog')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('TaskLog')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		
		foreach($data_list as &$val){
			$userinfo=D('User')->find($val['uid']);
			$val['username']=$userinfo['username'];
			$taskinfo=D('Task')->find($val['tid']);
			$val['taskname']=$taskinfo['name'];
		}

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('任务日志')  //设置页面标题
        ->setSearch('请输入ID/UID/TID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('username', '用户名', 'text')
            ->addField('taskname', '任务', 'text')
            ->addField('ctime', '完成时间', 'time')
            ->dataList($data_list)    //数据列表
            ->setPage($page->show())
            ->display();
    }

}
