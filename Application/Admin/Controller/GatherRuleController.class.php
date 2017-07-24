<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 采集规则控制器
 * @author C0de <47156503@qq.com>
 */
class GatherRuleController extends AdminController{
    /**
     * 采集规则列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name'] = array($condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('GatherRule')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('GatherRule')->where($map)->count(), C('ADMIN_PAGE_ROWS'));


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('采集规则列表')  //设置页面标题
		->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/URL', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '名称', 'text')
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
     * 新增转发
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('GatherRule');
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
            $builder->title('采集规则添加')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('name', 'text', '名称')
				->addItem('list_dom', 'text', '列表页链接DOM')
				->addItem('list_body', 'text', '列表页内容DOM')
				->addItem('list_delete', 'text', '列表页剔除规则')
				->addItem('body', 'text', '文章DOM')
				->addItem('title_dom', 'text', '标题DOM')
				->addItem('title_delete', 'text', '标题剔除规则')
				->addItem('content_dom', 'text', '内容DOM')
				->addItem('content_delete', 'text', '内容剔除规则')
                ->display();
        }
    }
	



    /**
     * 采集规则编辑
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('GatherRule');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('GatherRule')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('采集规则编辑')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('name', 'text', '名称')
				->addItem('list_dom', 'text', '列表页链接DOM')
				->addItem('list_body', 'text', '列表页内容DOM')
				->addItem('list_delete', 'text', '列表页剔除规则')
				->addItem('body', 'text', '文章DOM')
				->addItem('title_dom', 'text', '标题DOM')
				->addItem('title_delete', 'text', '标题剔除规则')
				->addItem('content_dom', 'text', '内容DOM')
				->addItem('content_delete', 'text', '内容剔除规则')
                ->setFormData($data)
                ->display();
        }
    }
}
