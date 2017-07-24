<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台充值接口控制器
 * @author C0de <47156503@qq.com>
 */
class PayapiController extends AdminController{
    /**
     * 充值接口列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|class|appid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Payapi')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('Payapi')->where($map)->count(), C('ADMIN_PAGE_ROWS'));


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('充值接口列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/名称/类/APPID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '名称', 'text')
            ->addField('class', '接口类名', 'text')
            ->addField('appid', 'APPID', 'text')
            ->addField('appkey', 'APPKEY', 'text')
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
     * 新增接口
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('Payapi');
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
            $builder->title('新增接口')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('name', 'text', '名称', false)
                ->addItem('class', 'text', '接口名', '*接口文件的class名')
                ->addItem('appid', 'text', 'APPID')
                ->addItem('appkey', 'text', 'APPKEY')
                ->addItem('parameter', 'textarea', '其他参数', '一行一个,可留空')
                ->display();
        }
    }

    /**
     * 编辑接口
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Payapi');
            $data = $object->create();
            if($data){
                $id = $object->save();
                if($id){
                    $this->success('更新成功', U('index'));
                }else{
                    $this->error('更新失败');
                }
            }else{
                $this->error($object->getError());
            }
        }else{
            $data=D('Payapi')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑接口')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('name', 'text', '名称', false)
                ->addItem('class', 'text', '接口名', '*接口文件的class名')
                ->addItem('appid', 'text', 'APPID')
                ->addItem('appkey', 'text', 'APPKEY')
                ->addItem('parameter', 'textarea', '其他参数', '一行一个,可留空')
                ->setFormData($data)
                ->display();
        }
    }
}
