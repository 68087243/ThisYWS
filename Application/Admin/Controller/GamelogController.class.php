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
 * 后台游戏日志控制器
 * @author C0de <47156503@qq.com>
 */
class GamelogController extends AdminController{
    /**
     * 游戏日志列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|uid|gid|sid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Gamelog')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Gamelog')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        foreach($data_list as $key=>$val){
			$data_list[$key]['uid']=get_user_info($val['uid'],'username');

            $game_map['id']=$val['gid'];
            $game=D('Game')->getColumnByfield('name', $game_map);
            $data_list[$key]['gid']=$game[0];

            $gameserver_map['id']=$val['sid'];
            $gameserver=D('Gameserver')->getColumnByfield('name', $gameserver_map);
            $data_list[$key]['sid']=$gameserver[0];

            $source=C('SOURCE_LIST');
            $data_list[$key]['source']=$source[$val['source']];



        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('游戏日志列表')  //设置页面标题
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('uid', '玩家', 'text')
            ->addField('gid', '游戏', 'text')
            ->addField('sid', '服务器', 'text')
            ->addField('ip', '用户IP', 'text')
            //->addField('useragent', '用户UA', 'text')
            ->addField('source', '来源', 'text')
            ->addField('ctime', '游戏时间', 'time')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('delete') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }



}
