<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台混服游戏服务器控制器
 * @author C0de <47156503@qq.com>
 */
class MixGameServerController extends AdminController{
    /**
     * 混服服务器列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|gid|ctime'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
        $map['status'] = array('egt', '0'); //禁用和正常状态
		$mix_game=D('MixGame')->field('gid')->select();
		$mix_game_tmp=Array();
		foreach($mix_game as $_val){
			$mix_game_tmp[]=$_val['gid'];
		}
		$in=implode(',',$mix_game_tmp);
		$map['game'] = array('in',$in);
		$data_list = D('Gameserver')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order("FROM_UNIXTIME(`ktime`,'%Y-%m-%d') desc,sort desc,id desc")->fetchSql(FALSE)->select();
        $page = new \Common\Util\Page(D('Gameserver')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
            $val['game']=D('Game')->getFieldBymap('name', Array('id'=>$val['game']));
        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('混服服务器列表')  //设置页面标题
        ->AddNewButton("Gameserver/add")    //添加新增按钮
        ->addResumeButton("Gameserver") //添加启用按钮
        ->addForbidButton("Gameserver") //添加禁用按钮
        ->addDeleteButton("Gameserver") //添加删除按钮
        ->setSearch('请输入ID/名称/GID/SID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '服务器名称', 'text')
            ->addField('game', '游戏', 'text')
            ->addField('ktime', '开服时间', 'time')
            ->addField('ctime', '添加时间', 'time')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('edit','Gameserver')   //添加编辑按钮
            ->addRightButton('forbid','Gameserver') //添加禁用/启用按钮
            ->addRightButton('delete','Gameserver') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }



}
