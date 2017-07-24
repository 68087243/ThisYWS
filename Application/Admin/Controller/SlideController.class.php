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
 * 后台幻灯片控制器
 * @author C0de <47156503@qq.com>
 */
class SlideController extends AdminController{
    /**
     * 幻灯片列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|pic|url'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Slide')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Slide')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		$SOURCE_LIST=C('SOURCE_LIST');
		foreach($data_list as &$val){
			
			$val['platform']=$SOURCE_LIST[$val['platform']];
			
		}


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('幻灯片列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '名称', 'text')
            ->addField('sort', '排序', 'edit')
			->addField('platform', '所属', 'text')
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
     * 新增幻灯片
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('Slide');
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
                ->addItem('pic', 'picture', '图片', '如留空则可填写远程图片')
                ->addItem('url', 'text', '远程图片', false)
                ->addItem('onclick_url','text','点击链接',false)
				->addItem('platform', 'select', '所属', false , C('SOURCE_LIST'))
                ->setFormData($data)
                ->display();
        }
    }

    /**
     * 编辑幻灯片
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Slide');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Slide')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑幻灯片')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('name', 'text', '名称', false)
                ->addItem('sort', 'text', '排序', false)
                ->addItem('pic', 'picture', '图片', '如留空则可填写远程图片')
                ->addItem('url', 'text', '远程图片', false)
                ->addItem('onclick_url','text','点击链接',false)
				->addItem('platform', 'select', '所属', false , C('SOURCE_LIST'))
                ->setFormData($data)
                ->display();
        }
    }
}
