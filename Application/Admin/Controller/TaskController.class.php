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
 * 后台任务控制器
 * @author C0de <47156503@qq.com>
 */
class TaskController extends AdminController{
    /**
     * 任务列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|config'] = array($condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Task')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Task')->where($map)->count(), C('ADMIN_PAGE_ROWS'));



        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('任务列表')  //设置页面标题
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->setSearch('请输入ID/任务名称/奖励', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '任务名', 'text')
            ->addField('config', '奖励', 'text')
            ->addField('ctime', '添加时间', 'time')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('edit')   //添加编辑按钮
            ->addRightButton('forbid') //添加禁用/启用按钮
            ->setPage($page->show())
            ->display();
    }

    /**
     * 编辑任务
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
			$_POST['utime']=time();
            $object = D('Task');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Task')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('任务编辑')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('name', 'text', '任务名')
				->addItem('config', 'text', '奖励')
                ->setFormData($data)
                ->display();
        }
    }
}
