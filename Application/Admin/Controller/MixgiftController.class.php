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
 * 后台混服礼包控制器
 * @author C0de <47156503@qq.com>
 */
class MixgiftController extends AdminController{


    private function javascript(){
        $ajax_url_carddetail=U('Api/Carddetail/ajaxCarddetailBygid');
        $ajax_url_gameserver=U('Api/Game/ajaxGameServerBygid');
        $js=<<<EOF
id='gid' onchange="var s = $('#sid');$.post('$ajax_url_gameserver',{gid:$('#gid').val()},function(re){s.empty();s.append($('<option>').text('全服').val('0'));s.trigger('chosen:updated');s.chosen();if(re!=''&&re!='[]'){var temp=0;$.each(re,function(index,item){var opt=$('<option>').text(item.name).val(item.id);s.append(opt);s.trigger('chosen:updated');s.chosen()})}});"
EOF;
        return $js;
    }

    /**
     * 混服礼包列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|game|name|type'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
//USER_VIP_LEVEL
        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Mixgift')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('Mixgift')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
            $game_map['id']=$val['game'];
            $val['game']=D('Game')->getFieldBymap('name', $game_map);
        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('混服礼包')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/游戏ID/名称/类别', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('game', '游戏', 'text')
            ->addField('name', '名称', 'text')
            ->addField('type', '标识', 'text')
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
     * 新增混服礼包
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('Mixgift');
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
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('新增混服礼包')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('game', 'select', '游戏', false, $Game)
                ->addItem('name', 'text', '名称', '礼包名称')
                ->addItem('type', 'text', '标识', '参考混服文档')
                ->addItem('parameter', 'textarea', '额外参数', '一行一个')
				->addItem('describe', 'textarea', '礼包描述', false)
                ->addItem('introduce', 'kindeditor', '领取方法', false)
                ->display();
        }
    }

    /**
     * 编辑游戏
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Mixgift');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Mixgift')->find($id);
            $Game=Array();
            foreach(D('Game')->select() as $val){
                $Game[$val['id']]=$val['name'];
            }
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑混服礼包')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
               ->addItem('game', 'select', '游戏', false, $Game)
                ->addItem('name', 'text', '名称', '礼包名称')
                ->addItem('type', 'text', '标识', '参考混服文档')
                ->addItem('parameter', 'textarea', '额外参数', '一行一个')
				->addItem('describe', 'textarea', '礼包描述', false)
                ->addItem('introduce', 'kindeditor', '领取方法', false)
                ->setFormData($data)
                ->display();
        }
    }
}
