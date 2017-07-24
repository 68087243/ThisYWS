<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台新手卡控制器
 * @author C0de <47156503@qq.com>
 */
class ServiceController extends AdminController{




    /**
     *工单列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|sno|type|email'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        $map['status'] = array('neq', '0'); //禁用和正常状态
        $data_list = D('Issue')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('Issue')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
            $val['type']=D('IssueConfig')->getFieldBymap('name', Array('id'=>$val['type']));
            $val['username']=D('User')->getFieldBymap('username', Array('id'=>$val['uid']));
        }
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('工单列表')  //设置页面标题
        ->addDeleteButton('Issue') //添加删除按钮
        ->setSearch('请输入ID/申诉编号/类型ID/邮箱', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('type', '问题类型', 'text')
            ->addField('sno', '申诉编号', 'text')
            ->addField('username', '用户名', 'text')
            ->addField('email', '提交人邮件', 'text')
            ->addField('mobile', '提交人手机', 'text')
            ->addField('ctime', '提交时间', 'time')
            ->addField('adminstatus', '状态', 'text')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('handle')   //添加编辑按钮
            ->addRightButton('delete','Issue') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }


    /**
     * 未处理工单
     * @author C0de <47156503@qq.com>
     */
    public function nochuli(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|sno|type|email'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        $map['status'] = array('neq', '0'); //禁用和正常状态
        $map['adminstatus']='申诉中';
        $data_list = D('Issue')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('Issue')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
            $val['type']=D('IssueConfig')->getFieldBymap('name', Array('id'=>$val['type']));
            $val['username']=D('User')->getFieldBymap('username', Array('id'=>$val['uid']));
        }
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('未处理工单列表')  //设置页面标题
        ->addDeleteButton('Issue') //添加删除按钮
        ->setSearch('请输入ID/申诉编号/类型ID/邮箱', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('type', '问题类型', 'text')
            ->addField('sno', '申诉编号', 'text')
            ->addField('username', '用户名', 'text')
            ->addField('email', '提交人邮件', 'text')
            ->addField('mobile', '提交人手机', 'text')
            ->addField('ctime', '提交时间', 'time')
            ->addField('adminstatus', '状态', 'text')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('handle')   //添加编辑按钮
            ->addRightButton('delete','Issue') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }


    /**
     * 处理工单
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Issue');
            $save['adminstatus']=$_POST['adminstatus'];
            $save['adminreply']=$_POST['adminreply'];
            $save['id']=$_POST['id'];
            $_POST=Array();
            $_POST=$save;
            if($object->save($_POST)){
                $this->success('处理成功', U('index'));
            }else{
                $this->error('处理失败', $object->getError());
            }
        }else{
            $data=D('Issue')->find($id);
            $data['type_rh']=D('IssueConfig')->getFieldBymap('name', Array('id'=>$data['type']));
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('处理工单')->setUrl(U('edit'))->addItem('id', 'hidden', 'ID', 'ID')->addItem('sno', 'text', '申诉编号', false,false,false,'readonly="readonly"')->addItem('type_rh', 'text', '问题类型', false,false,false,'readonly="readonly"');

            $issueconfig=D('IssueConfig')->find($data['type']);
            $issue_field=json_decode($issueconfig['field'],true);
            $form_field=json_decode($data['field'],true);

            //D('Game')->getFieldBymap('name',Array('id'=>$form_field[$val['name']]));
            foreach($issue_field as $vo){
                foreach($vo as $key=>$val){
                    if(isset($data[$val['name']])){
                        $val['name']=$val['name'].'_rh';
                    }
                    if($val['type'] =='select'){
                        $form_field[$val['name']]=D('Game')->getFieldBymap('name',Array('id'=>$form_field[$val['name']]));
                    }
                    $data[$val['name']]=$form_field[$val['name']];
                    $builder->addItem($val['name'], 'textarea', $key, false,false,false,'readonly="readonly"');
                }
            }
            $adminstatus=Array(
                '申诉成功'=>'申诉成功',
                '申诉未通过'=>'申诉未通过',
                '申诉中'=>'申诉中'
            );
            $builder->addItem('email', 'text', '申诉人邮箱', false,false,false,'readonly="readonly"')
                ->addItem('mobile', 'text', '申诉人手机', false,false,false,'readonly="readonly"')
                ->addItem('qq', 'text', '申诉人QQ', false,false,false,'readonly="readonly"')
                ->addItem('ip', 'text', '申诉人IP', false,false,false,'readonly="readonly"')
                ->addItem('note', 'textarea', '补充资料', false,false,false,'readonly="readonly"')
                ->addItem('adminstatus', 'select', '状态', false,$adminstatus)
                ->addItem('adminreply', 'textarea', '处理回复', false)
                ->setFormData($data)
                ->display();
        }
    }


    public function issueconfig(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|field|islogin'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        $map['status'] = array('neq', '0'); //禁用和正常状态
        $data_list = D('IssueConfig')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('IssueConfig')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
            $val['islogin']=$val['islogin']? '是' : '否' ;
        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('工单问题配置')  //设置页面标题
        ->setSearch('请输入ID/名称/字段/是否登录', U('issueconfig'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '名称', 'text')
            ->addField('islogin', '是否登陆', 'text')
            ->dataList($data_list)    //数据列表
            ->setPage($page->show())
            ->display();
    }

}
