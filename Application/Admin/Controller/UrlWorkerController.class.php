<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台URL转发控制器
 * @author C0de <47156503@qq.com>
 */
class UrlWorkerController extends AdminController{
    /**
     * 转发列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|url'] = array($condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Url')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('Url')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		$hashids = new \Common\Util\Hashids(md5('t3t2key'), 10);
		foreach($data_list as &$val){
			$val['zfurl']="http://url.gamea5.com/".$hashids->encode($val['id']).'.html';
		}


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('转发列表')  //设置页面标题
		->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/URL', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('url', 'URL', 'text')
			->addField('zfurl', '转发URL', 'text')
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
			$_POST['ctime']=time();
            $object = D('Url');
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
            $builder->title('转发添加')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('url', 'text', 'Url')
                ->display();
        }
    }
	



    /**
     * 编辑转发
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Url');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Url')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('转发编辑')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('url', 'text', 'URL')
                ->setFormData($data)
                ->display();
        }
    }
}
