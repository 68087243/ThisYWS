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
class CardController extends AdminController{




    /**
     * 新手卡列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|card|uid|cid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('neq', '0'); //禁用和正常状态
        $data_list = D('Card')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Card')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
            $card_detail_map['id']=$val['cid'];
            $card_detail=D('CardDetail')->getColumnByfield('name', $card_detail_map);
            $val['cid']=$card_detail[0];

            $game_map['id']=$val['gid'];
            $game=D('Game')->getColumnByfield('name', $game_map);
            $val['gid']=$game[0];
        }
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('游戏列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/新手卡/GID/CID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('card', '新手卡', 'text')
            ->addField('cid', '名称', 'text')
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
     * 已使用新手卡列表
     * @author C0de <47156503@qq.com>
     */
    public function old(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|card|uid|cid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('eq', '0'); //禁用和正常状态
        $data_list = D('Card')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Card')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
            $card_detail_map['id']=$val['cid'];
            $val['cid']=D('CardDetail')->getFieldBymap('name', $card_detail_map);

            $game_map['id']=$val['gid'];
            $val['gid']=D('Game')->getFieldBymap('name', $game_map);


            $val['uid']=D('User')->getFieldBymap('username',Array('id'=>$val['uid']));


        }
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('已使用新手卡列表')  //设置页面标题
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/新手卡/GID/CID', U('old'))
            ->addField('id', 'ID', 'text')
            ->addField('card', '新手卡', 'text')
            ->addField('cid', '名称', 'text')
            ->addField('uid', '领取人', 'text')
            ->addField('utime', '领取时间', 'time')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('forbid') //添加禁用/启用按钮
            ->addRightButton('delete') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }
    /**
     * 新增新手卡
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $card=explode("\r\n",$_POST['card']);
            $_POST['ctime']=time();
            foreach($card as $val){
                $_POST['card']=$val;
                $dataList[] = $_POST;

            }

            $object = D('Card');
            $id = $object->addAll($dataList);
            if($id){
                $this->success('新增成功', U('index'));
            }else{
                $this->error('新增失败');
            }


        }else{
            $CardDetail=Array();
            foreach(D('CardDetail')->select() as $val){
                $CardDetail[$val['id']]=$val['name'];
            }


            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('新增新手卡')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('cid', 'select', '新手卡类别', false,$CardDetail)
                ->addItem('card', 'textarea', '新手卡', '每张卡一行，为考虑性能,每次最好添加<500张')
                ->display();
        }
    }

    /**
     * 编辑新手卡
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Card');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Card')->find($id);

            $CardDetail=Array();
            foreach(D('CardDetail')->select() as $val){
                $CardDetail[$val['id']]=$val['name'];
            }

            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑新手卡')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('cid', 'select', '新手卡类别', false,$CardDetail)
                ->addItem('card', 'text', '新手卡', '每张卡一行，为考虑性能,每次最好添加<500张')
                ->setFormData($data)
                ->display();
        }
    }
}
