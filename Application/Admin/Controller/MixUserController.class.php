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
 * 后台联运商户控制器
 * @author C0de <47156503@qq.com>
 */
class MixUserController extends AdminController{
    /**
     * 商户列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|email|realname'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('MixUser')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('MixUser')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		foreach($data_list as &$val){
			$mix_level=C('MIX_LEVEL');
			$val['level']=$mix_level[$val['level']];
		}

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('商户列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/用户名/邮箱/姓名', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '账号', 'text')
			->addField('level', '等级', 'text')
            ->addField('email', '邮箱', 'text')
            ->addField('realname', '姓名', 'text')
            ->addField('mobile', '手机', 'text')
			->addField('money', '余额', 'text')
			->addField('total_money', '总收益', 'text')
			->addField('last_login_time', '最后登陆', 'time')
            ->addField('ctime', '添加时间', 'time')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('edit')   //添加编辑按钮
            ->addRightButton('forbid') //添加禁用/启用按钮
            ->addRightButton('delete') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }

    /**
     * 新增商户
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
			$_POST['ctime']=time();
            $object = D('MixUser');
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
            $builder->title('新增商户')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('name', 'text', '账号')
                ->addItem('pass', 'text', '密码')
				->addItem('level', 'select', '等级', false, C('MIX_LEVEL'))
                ->addItem('email', 'text', '邮箱')
				->addItem('realname', 'text', '姓名')
				->addItem('idcard', 'text', '身份证')
				->addItem('mobile', 'text', '手机')
				->addItem('qq', 'text', 'QQ')
				->addItem('paytype', 'select', '收款类型', false, C('PAYMENT_CHANNELS'))
				->addItem('payinfo', 'text', '收款账号','*收款账号姓名必须与上方姓名相同')
				->addItem('webname', 'text', '网站名')
				->addItem('icp', 'text', '备案号')
				->addItem('weburl', 'text', '网站地址')
				->addItem('payurl', 'text', '充值地址')
				->addItem('result_pay', 'text', '充值回调地址')
				->addItem('notify_pay', 'text', '充值异步回调地址')
                ->setFormData()
                ->display();
        }
    }

    /**
     * 编辑商户
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('MixUser');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('MixUser')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑商户')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                 ->addItem('name', 'text', '账号')
                ->addItem('pass', 'text', '密码')
				->addItem('level', 'select', '等级', false, C('MIX_LEVEL'))
                ->addItem('email', 'text', '邮箱')
				->addItem('realname', 'text', '姓名')
				->addItem('idcard', 'text', '身份证')
				->addItem('mobile', 'text', '手机')
				->addItem('qq', 'text', 'QQ')
				->addItem('paytype', 'select', '收款类型', false, C('PAYMENT_CHANNELS'))
				->addItem('payinfo', 'text', '收款账号','*收款账号姓名必须与上方姓名相同')
				->addItem('webname', 'text', '网站名')
				->addItem('icp', 'text', '备案号')
				->addItem('weburl', 'text', '网站地址')
				->addItem('payurl', 'text', '充值地址')
				->addItem('result_pay', 'text', '充值回调地址')
				->addItem('notify_pay', 'text', '充值异步回调地址')
                ->setFormData($data)
                ->display();
        }
    }
}
