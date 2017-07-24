<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 积分日志控制器
 * @author C0de <47156503@qq.com>
 */
class ScoreLogController extends AdminController{
    /**
     * 积分列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|uid|score_type'] = array($condition, $condition, $condition,'_multi'=>true);

        $data_list = D('ScoreLog')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('ScoreLog')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		
		foreach($data_list as &$val){
			$userinfo=D('User')->find($val['uid']);
			$val['username']=$userinfo['username'];
			$taskinfo=D('Task')->find($val['tid']);
			$score_type=C('SCORE_TYPE');
			$val['score_type']=$score_type[$val['score_type']];
		}

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('积分日志')  //设置页面标题
        ->setSearch('请输入ID/UID/SCoreType', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('username', '用户名', 'text')
            ->addField('score_type', '积分', 'text')
			->addField('type', '类型', 'text')
			->addField('num', '数额', 'text')
			->addField('remark', '说明', 'text')
            ->addField('ctime', '时间', 'time')
            ->dataList($data_list)    //数据列表
            ->setPage($page->show())
            ->display();
    }

}
