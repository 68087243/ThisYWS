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
 * 后台新手卡控制器
 * @author C0de <47156503@qq.com>
 */
class CarddetailController extends AdminController{


    private function javascript(){
        $ajax_url_gameserver=U('Api/Game/ajaxGameServerBygid');
        $js=<<<EOF
id='gid' onchange="var s = $('#sid');$.post('$ajax_url_gameserver',{gid:$('#gid').val()},function(re){s.empty();s.append($('<option>').text('全服').val('0'));s.trigger('chosen:updated');s.chosen();if(re!=''&&re!='[]'){var temp=0;$.each(re,function(index,item){var opt=$('<option>').text(item.name).val(item.id);s.append(opt);s.trigger('chosen:updated');s.chosen()})}});"
EOF;
        return $js;
    }

    /**
     * 新手卡列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|gid|description'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
//USER_VIP_LEVEL
        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('CardDetail')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        
        $page = new \Common\Util\Page(D('CardDetail')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){

            $game_map['id']=$val['gid'];
            $val['gid']=D('Game')->getFieldBymap('name', $game_map);

            $level=C('VIP_LEVEL_LIST');
            $val['level']= '=>'.$level[$val['level']]['title'];
            $Card_map['status'] = array('neq', '0');
            $Card_map['cid'] = $val['id'];
            $game=D('Card')->where($Card_map)->count();
            $val['count']=$game;

            if(empty($val['sid'])){
                $val['sid']='全服';
            }else {
                $game_server_map['id'] = $val['sid'];
                $val['sid'] = D('Gameserver')->getFieldBymap('name', $game_server_map);
            }

        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('新手卡分类')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/名称/GID/描述', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('gid', '游戏', 'text')
            ->addField('sid', '服务器', 'text')
            ->addField('name', '名称', 'text')
            ->addField('count', '剩余', 'text')
            ->addField('level', '领取等级', 'text')
            ->addField('flags', '属性', 'text')
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
     * 新增新手卡类别
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('CardDetail');
            $_POST['flags']=implode(',',$_POST['flags']);
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
            $vip=Array();
            foreach(C('VIP_LEVEL_LIST') as $key=>$val){
                $vip[$key]=$val['title'];
            }
            $ATTRIBUTE=C('ATTRIBUTE_LIST');
            unset($ATTRIBUTE['x']);
            unset($ATTRIBUTE['j']);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('新增新手卡类别')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('gid', 'select', '游戏', false, $Game,false,$this->javascript())
                ->addItem('sid', 'select', '服务器', false,false,false,'id="sid"')
                ->addItem('name', 'text', '名称', '新手卡名称')
                ->addItem('level', 'select', '领取等级', '等级大于设置的等级都可领取', $vip)
                ->addItem('flags', 'checkbox', '属性', false, $ATTRIBUTE)
                ->addItem('description', 'textarea', '新手卡介绍', false)
                ->addItem('method', 'kindeditor', '兑换方法', false)
                ->display();
        }
    }

    /**
     * 编辑游戏
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('CardDetail');
            $_POST['flags']=implode(',',$_POST['flags']);
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('CardDetail')->find($id);
            $Game=Array();
            foreach(D('Game')->select() as $val){
                $Game[$val['id']]=$val['name'];
            }

            $gameserver_map['game']=$data['gid'];
            $Gameserver=Array();
            $Gameserver[0]='全服';
            foreach(D('Gameserver')->where($gameserver_map)->select() as $val){
                $Gameserver[$val['id']]=$val['name'];
            }

            $vip=Array();
            foreach(C('VIP_LEVEL_LIST') as $key=>$val){
                $vip[$key]=$val['title'];
            }
            $ATTRIBUTE=C('ATTRIBUTE_LIST');
            unset($ATTRIBUTE['x']);
            unset($ATTRIBUTE['j']);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑新手卡')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('gid', 'select', '游戏', false, $Game,false,$this->javascript())
                ->addItem('sid', 'select', '服务器', false,$Gameserver,false,'id="sid"')
                ->addItem('name', 'text', '名称', '新手卡名称')
                ->addItem('level', 'select', '领取等级', false, $vip)
                ->addItem('flags', 'checkbox', '属性', false, $ATTRIBUTE)
                ->addItem('description', 'textarea', '新手卡介绍', false)
                ->addItem('method', 'kindeditor', '兑换方法', false)
                ->setFormData($data)
                ->display();
        }
    }
}
