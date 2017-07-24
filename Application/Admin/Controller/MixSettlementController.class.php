<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台混服结算控制器
 * @author C0de <47156503@qq.com>
 */
class MixSettlementController extends AdminController{
    /**
     * 混服结算列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|mid|money|clstatus'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('MixSettlement')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('MixSettlement')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
			$mixuser=M('MixUser')->find($val['mid']);
			$val['name']=$mixuser['name'].'/'.$val['mid'];
        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('结算列表')  //设置页面标题
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '商户', 'text')
            ->addField('money', '申请金额', 'text')
            ->addField('clstatus', '处理状态', 'text')
            ->addField('ctime', '申请时间', 'time')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('handle')   //添加编辑按钮
            ->addRightButton('forbid') //添加禁用/启用按钮
            ->addRightButton('delete') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }

  
    /**
     * 处理结算审核
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('MixSettlement');
            if($object->save($_POST)){
				if($_POST['clstatus'] == '已处理'){
					$mixuser = D('MixUser')->where(Array('id'=>$_POST['mid']))->setDec('money',$_POST['money']);
				}
                $this->success('处理成功', U('index'));
            }else{
                $this->error('未进行处理', $object->getError());
            }
        }else{
			$adminstatus=Array(
                '已处理'=>'已处理',
                '未处理'=>'未处理'
            );
            $data=D('MixSettlement')->find($id);
			$MixUser=D('MixUser')->find($data['mid']);
			$data['mixname']=$MixUser['name'];
			$PAYMENT_CHANNELS=C('PAYMENT_CHANNELS');
			$data['paytype']=$PAYMENT_CHANNELS[$MixUser['paytype']];
			$data['payinfo']=$MixUser['payinfo'];
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('结算审核处理')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
			->addItem('mid', 'hidden', 'ID', 'ID')
                ->addItem('mixname', 'text', '商户', false,false,false,'readonly="readonly"')
				->addItem('money', 'text', '结算金额', false,false,false,'readonly="readonly"')
				->addItem('paytype', 'text', '收款类型', false,false,false,'readonly="readonly"')
				->addItem('payinfo', 'text', '收款账号', false,false,false,'readonly="readonly"')
				->addItem('ctime', 'time', '申请时间', false,false,false,'readonly="readonly"')
				->addItem('clstatus', 'select', '处理状态', false,$adminstatus)
                ->setFormData($data)
                ->display();
        }
    }
}
