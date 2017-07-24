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
 * 后台充值控制器
 * @author C0de <47156503@qq.com>
 */
class PayController extends AdminController{
    /**
     * 充值列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|order|uid|gameid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

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
            ->addRightButton('edit')   //添加编辑按钮
            ->addRightButton('forbid','Paylog') //添加禁用/启用按钮
            ->addRightButton('delete','Paylog') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }

    /**
     * 编辑充值
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
			$_POST['utime']=time();
            $object = D('Paylog');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Paylog')->find($id);
			$_userinfo=D('User')->where(Array('id'=>$data['uid']))->find();
            $_paytype=D('Paytype')->where(Array('tag'=>$data['paytype']))->find();
			$data['userinfo']='UID:'.$_userinfo['id'].'/'.$_userinfo['username'];
			$data['paytype_']=$_paytype['name'];
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑充值订单')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('order', 'text', '订单号', null,null,null,'readonly="readonly"')
				->addItem('userinfo', 'text', '充值用户', null,null,null,'readonly="readonly"')
				->addItem('paytoname', 'text', '充值到用户', null,null,null,'readonly="readonly"')
				->addItem('paytype_', 'text', '渠道', null,null,null,'readonly="readonly"');
				if($data['paybank']){
					 $builder->addItem('paybank', 'text', '银行', null,null,null,'readonly="readonly"');
				}
				if($data['gameid'] && $data['serverid']){
					$__gametemp=D('Game')->where(Array('id'=>$data['gameid']))->find();
					$data['game']=$__gametemp['name'];
					$builder->addItem('game', 'text', '游戏', null,null,null,'readonly="readonly"');
					$__servertemp=D('Gameserver')->where(Array('id'=>$data['serverid']))->find();
					$data['server']=$__servertemp['name'];
					$builder->addItem('server', 'text', '服务器', null,null,null,'readonly="readonly"');
					$builder->addItem('role', 'text', '角色', null,null,null,'readonly="readonly"');
				}
                $builder->addItem('payamount', 'text', '充值金额', null,null,null,'readonly="readonly"')
				->addItem('virtualamount', 'text', '到账游戏币', null,null,null,'readonly="readonly"')
				->addItem('fee', 'text', '手续费', null,null,null,'readonly="readonly"')
				->addItem('paystatus', 'select', '支付状态', false, C('PAY_STATUS'))
                ->addItem('remark', 'textarea', '备注', false)
                ->setFormData($data)
                ->display();
        }
    }
}
