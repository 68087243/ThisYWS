<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台CPS结算控制器
 * @author C0de <47156503@qq.com>
 */
class SpreadTxController extends AdminController{
    /**
     * 结算处理列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|mid'] = array($condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
		$map['txstatus'] = array('eq', '0'); //禁用和正常状态
        $data_list = D('SpreadTx')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('SpreadTx')->where($map)->count(), C('ADMIN_PAGE_ROWS'));


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('处理结算')  //设置页面标题
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/MID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('mid', 'MID', 'text')
            ->addField('money', '金额', 'text')
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
	
	
	public function succes(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|mid'] = array($condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
		$map['txstatus'] = array('eq', '1'); //禁用和正常状态
        $data_list = D('SpreadTx')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('SpreadTx')->where($map)->count(), C('ADMIN_PAGE_ROWS'));


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('处理结算')  //设置页面标题
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/MID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('mid', 'MID', 'text')
            ->addField('money', '金额', 'text')
            ->addField('ctime', '申请时间', 'time')
			->addField('utime', '处理时间', 'time')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('delete') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }
	
	/**
     * 新增渠道
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('Spread');
            $data = $object->create();
            if($data){
                $id = $object->add();
                if($id){
                    $this->success('新增成功', U('index'));
                }else{
                    $this->error('新增失败');
                }
            }else{
                $this->error($object->getError());
            }
        }else{
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('渠道添加')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('mid', 'text', 'MID')
                ->addItem('name', 'text', '渠道名')
                ->addItem('pass', 'text', '密码')
                ->addItem('bili', 'text', '比例')
                ->display();
        }
    }
	
	

    /**
     * 处理结算
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
			if($_POST['txstatus']==1){
				M('Spread')->where(Array('mid'=>$_POST['mid']))->setDec('money',$_POST['money']);
				$_POST['utime']=time();
			}
			unset($_POST['pay']);
            $object = D('SpreadTx');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
				echo $object->getError();
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('SpreadTx')->find($id);
			$arr=Array(0=>'未支付',1=>'已支付');
			$__spread=M('Spread')->where(Array('mid'=>$data['mid']))->find();
			$data['pay']=$__spread['payaccount'];
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('处理结算')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('mid', 'text', 'MID', null,null,null,'readonly="readonly"')
                ->addItem('money', 'text', '金额', null,null,null,'readonly="readonly"')
                ->addItem('pay', 'text', '收款账号', null,null,null,'readonly="readonly"')
				->addItem('txstatus', 'select', '支付状态', false, $arr)
                ->setFormData($data)
                ->display();
        }
    }
}
