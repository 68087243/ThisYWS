<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台混服结算控制器
 * @author C0de <47156503@qq.com>
 */
class MixLnchargeController extends AdminController{
    /**
     * 混服结算列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|gid|sid|mid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('MixLncharge')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('MixLncharge')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
			$gamedata=M('Game')->find($val['gid']);
			$val['gamename']=$gamedata['name'];
			$mixuser=M('MixUser')->find($val['mid']);
			$val['name']=$mixuser['name'].'/'.$val['mid'];
            $serverdata=M('Gameserver')->find($val['sid']);
			$val['servername']=$serverdata['name'];
			$val['count']=count(explode("\r\n",$val['userlist']));
        }
		

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('内充申请列表')  //设置页面标题
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('gamename', '游戏', 'text')
            ->addField('servername', '服务器', 'text')
            ->addField('name', '商户', 'text')
			->addField('count', '账号数量', 'text')
			->addField('money', '金额', 'text')
			->addField('clstatus', '处理状态', 'text')
            ->addField('ctime', '添加时间', 'time')
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
     * 处理内充
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
			$_POST['utime']=time();
            $object = D('MixLncharge');
            if($object->save($_POST)){
                $this->success('已处理成功', U('index'));
            }else{
                $this->error('未处理', $object->getError());
            }
        }else{
			$adminstatus=Array(
                '已处理'=>'已处理',
                '未处理'=>'未处理'
            );
			
            $data=D('MixLncharge')->find($id);
			$Game=D('Game')->find($data['gid']);
			$Server=D('Gameserver')->find($data['gid']);
			$MixUser=D('MixUser')->find($data['mid']);
			$data['gamename']=$Game['name'];
			$data['servername']=$Server['name'];
			$data['mixname']=$MixUser['name'];
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('内充申请处理')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('gamename', 'text', '游戏', false,false,false,'readonly="readonly"')
				->addItem('servername', 'text', '服务器', false,false,false,'readonly="readonly"')
				->addItem('mixname', 'text', '商户', false,false,false,'readonly="readonly"')
				->addItem('money', 'text', '充值金额', false,false,false,'readonly="readonly"')
				->addItem('userlist', 'textarea', '充值账号', false,false,false,'readonly="readonly"')
				->addItem('remark', 'textarea', '留言', false,false,false,'readonly="readonly"')
				->addItem('clstatus', 'select', '处理状态', false,$adminstatus)
                ->setFormData($data)
                ->display();
        }
    }
}
