<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台友情链接控制器
 * @author C0de <47156503@qq.com>
 */
class LinkController extends AdminController{
    /**
     * 友情链接列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|url|remark'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Link')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Link')->where($map)->count(), C('ADMIN_PAGE_ROWS'));


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('幻灯片列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/名称/网址/备注', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '名称', 'text')
            ->addField('url', '网址', 'text')
            ->addField('remark', '备注', 'text')
            ->addField('sort', '排序', 'text')
            ->addField('ctime', '添加时间', 'time')
            ->addField('utime', '修改时间', 'time')
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
     * 新增友情链接
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('Link');
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
            $data['sort']=1;
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('新增幻灯片')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('name', 'text', '名称', false)
                ->addItem('sort', 'text', '排序', false)
                ->addItem('url', 'text', '网址', false)
                ->addItem('remark','textarea','备注',false)
                ->setFormData($data)
                ->display();
        }
    }

    /**
     * 编辑友情链接
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Link');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Link')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑友情链接')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('name', 'text', '名称', false)
                ->addItem('sort', 'text', '排序', false)
                ->addItem('url', 'text', '网址', false)
                ->addItem('remark','textarea','备注',false)
                ->setFormData($data)
                ->display();
        }
    }
}
