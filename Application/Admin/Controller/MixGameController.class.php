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
class MixGameController extends AdminController{
    /**
     * 混服游戏列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|gid|is_sc|is_money'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('MixGame')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('MixGame')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
			$gamedata=M('Game')->find($val['gid']);
			$val['gamename']=$gamedata['name'];
			$val['mark']=$gamedata['mark'];
			$val['unit']=$gamedata['unit'];
            $type=C('GAME_TYPE_LIST');
            $val['type']=$type[$gamedata['type']];
        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('混服游戏列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('gamename', '游戏名称', 'text')
            ->addField('mark', '标识', 'text')
            ->addField('unit', '单位', 'text')
            ->addField('type', '类型', 'text')
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
            $object = D('MixGame');
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
			$sc=Array('0'=>'不允许','1'=>'允许');
			$mix_level=C('MIX_LEVEL');
			$mix_level[0]='无等级限制';
            $data=D('MixGame')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('添加混服游戏')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('gid', 'select', '游戏', false, $Game)
				->addItem('is_sc', 'select', '是否可申请首冲/扶持', false, $sc)
				->addItem('is_money', 'text', '多少流水可申请本游戏', '0和空无限制')
				->addItem('is_level', 'select', '多少等级可申请', false, $mix_level)
                ->addItem('proportion', 'text', '分成比例', '如6,6.5')
				->addItem('parameters', 'textarea', '额外说明')
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
            $object = D('MixGame');
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
			$sc=Array('0'=>'不允许','1'=>'允许');
			$mix_level=C('MIX_LEVEL');
			$mix_level[0]='无等级限制';
            $data=D('MixGame')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑混服游戏')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('gid', 'select', '游戏', false, $Game)
				->addItem('is_sc', 'select', '是否可申请首冲/扶持', false, $sc)
				->addItem('is_money', 'text', '多少流水可申请本游戏', '0和空无限制')
				->addItem('is_level', 'select', '多少等级可申请', false, $mix_level)
                ->addItem('proportion', 'text', '分成比例', '如6,6.5')
				->addItem('parameters', 'textarea', '额外说明')
                ->setFormData($data)
                ->display();
        }
    }
}
