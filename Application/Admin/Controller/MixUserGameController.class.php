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
 * 后台混服游戏控制器
 * @author C0de <47156503@qq.com>
 */
class MixUserGameController extends AdminController{
    /**
     * 商户接入游戏列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|gid|mid|home_url'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('MixUserGame')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('MixUserGame')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
			$gamedata=M('Game')->find($val['gid']);
			$val['gamename']=$gamedata['name'];
			$mixuser=M('MixUser')->find($val['mid']);
			$val['name']=$mixuser['name'].'/'.$val['mid'];
            $type=C('GAME_TYPE_LIST');
            $val['type']=$type[$gamedata['type']];
        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('商户接入的游戏')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/MID/GID/游戏主页', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('gamename', '游戏名称', 'text')
            ->addField('name', '商户', 'text')
            ->addField('home_url', '游戏主页', 'text')
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
     * 新增游戏
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('MixUserGame');
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
			$Game=Array();
            foreach(D('Game')->select() as $val){
                $Game[$val['id']]=$val['name'];
            }
			$MixUser=Array();
			foreach(D('MixUser')->select() as $val){
                $MixUser[$val['id']]=$val['name'];
            }
            $data=D('MixUserGame')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('添加混服游戏')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('gid', 'select', '游戏', false, $Game)
				->addItem('mid', 'select', '商户', false, $MixUser)
				->addItem('home_url', 'text', '游戏主页地址', false)
				->addItem('pay_url', 'text', '游戏充值地址', false)
				->addItem('gift_url', 'text', '游戏礼包地址', false)
				->addItem('bbs_url', 'text', '游戏论坛地址', false)
				->addItem('service_url', 'text', '游戏客服地址', false)
				->addItem('client_url', 'text', '游戏微端地址', false)
                ->setFormData()
                ->display();
        }
    }

    /**
     * 编辑游戏
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('MixUserGame');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
			$Game=Array();
            foreach(D('Game')->select() as $val){
                $Game[$val['id']]=$val['name'];
            }
			$MixUser=Array();
			foreach(D('MixUser')->select() as $val){
                $MixUser[$val['id']]=$val['name'];
            }
            $data=D('MixUserGame')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑混服游戏')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('gid', 'select', '游戏', false, $Game)
				->addItem('mid', 'select', '商户', false, $MixUser)
				->addItem('home_url', 'text', '游戏主页地址', false)
				->addItem('pay_url', 'text', '游戏充值地址', false)
				->addItem('gift_url', 'text', '游戏礼包地址', false)
				->addItem('bbs_url', 'text', '游戏论坛地址', false)
				->addItem('service_url', 'text', '游戏客服地址', false)
				->addItem('client_url', 'text', '游戏微端地址', false)
                ->setFormData($data)
                ->display();
        }
    }
}
