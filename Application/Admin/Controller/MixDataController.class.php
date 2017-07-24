<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台混服数据统计控制器
 * @author C0de <47156503@qq.com>
 */
class MixDataController extends AdminController{
    /**
     * 混服用户列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|username|email|mobile'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
		
		$map['identification'] = array('exp','is not null');

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('User')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('User')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		
	

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('用户列表')  //设置页面标题
                ->AddNewButton("User/add")    //添加新增按钮
                ->addResumeButton("User") //添加启用按钮
                ->addForbidButton("User") //添加禁用按钮
                ->addDeleteButton("User") //添加删除按钮
                ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
                ->addField('id', 'UID', 'text')
                ->addField('username', '用户名', 'text')
                ->addField('identification', 'Mid', 'text')
                ->addField('status', '状态', 'status')
                ->addField('right_button', '操作', 'btn')
                ->dataList($data_list)    //数据列表
                ->addRightButton('edit','User')   //添加编辑按钮
                ->addRightButton('forbid','User') //添加禁用/启用按钮
                ->addRightButton('delete','User') //添加删除按钮
                ->setPage($page->show())
                ->display();
    }
	
	/**
     * 混服充值列表
     * @author C0de <47156503@qq.com>
     */
    public function pay(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|order|uid|gameid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
		$map['identification'] = array('exp','is not null');
        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Paylog')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Paylog')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        foreach($data_list as $key=>$val){
            $game_map['id']=$val['gameid'];
            $game=D('Game')->getColumnByfield('name', $game_map);
            $data_list[$key]['gameid']=$game[0];

            $gameserver_map['id']=$val['serverid'];
            $gameserver=D('Gameserver')->getColumnByfield('name', $gameserver_map);
            $data_list[$key]['serverid']=$gameserver[0];

            $pay=C('PAY_LIST');
            $data_list[$key]['platform']=$pay[$val['platform']];

            $data_list[$key]['uid']=get_user_info($val['uid'],'username');

            $paytype_map['tag']=$val['paytype'];
            $paytype=D('Paytype')->getColumnByfield('name', $paytype_map);
            $data_list[$key]['paytype']=$paytype[0];
			$paystatus=C('PAY_STATUS');

			if($val['paystatus'] == 1 ){
				$data_list[$key]['utime']=$paystatus[$val['paystatus']];
			}else{
				$data_list[$key]['utime']=$paystatus[$val['paystatus']].'/'.date('Y-m-d H:i:s',$val['utime']);
			}

        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('充值列表')  //设置页面标题
        ->addResumeButton("Paylog") //添加启用按钮
        ->addForbidButton("Paylog") //添加禁用按钮
        ->addDeleteButton("Paylog") //添加删除按钮
        ->setSearch('请输入ID/订单号/用户ID/游戏ID', U('pay'))
            ->addField('id', 'ID', 'text')
            ->addField('order', '订单号', 'text')
            ->addField('uid', '充值用户', 'text')
            ->addField('gameid', '游戏', 'text')
            ->addField('serverid', '服务器', 'text')
            ->addField('paytype', '充值渠道', 'text')
            ->addField('payamount', '金额', 'text')
            ->addField('ctime', '充值时间', 'time')
            ->addField('utime', '交易状态', 'text')
            ->addField('ip', 'ip', 'text')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('edit','Paylog')   //添加编辑按钮
            ->addRightButton('forbid','Paylog') //添加禁用/启用按钮
            ->addRightButton('delete','Paylog') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }



}
