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
 * 后台游戏主题控制器
 * @author C0de <47156503@qq.com>
 */
class GamesiteController extends AdminController{
    /**
     * 游戏主题列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|tag|path'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Gamesite')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Gamesite')->where($map)->count(), C('ADMIN_PAGE_ROWS'));


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('游戏主题列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/名称/标签/标识', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '名称', 'text')
            ->addField('tag', '标签', 'text')
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
     * 新增主题
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('Gamesite');
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
            $builder->title('新增主题')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('name', 'text', '名称', '主题名称')
                ->addItem('tag', 'text', '标签', '*模板目录名称')
                ->addItem('path', 'text', '标识', '主题目录 如/Theme/  可留空')
                ->addItem('remark', 'textarea', '备注',false)
                ->display();
        }
    }

    /**
     * 编辑接口
     * @author 0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Gamesite');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑用户')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('name', 'text', '名称', '主题名称')
                ->addItem('tag', 'text', '标签', '*模板目录名称')
                ->addItem('path', 'text', '标识', '主题目录 如/Theme/  可留空')
                ->addItem('remark', 'textarea', '备注',false)
                ->setFormData(D('Gamesite')->find($id))
                ->display();
        }
    }
}
