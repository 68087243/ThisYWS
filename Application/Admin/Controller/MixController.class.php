<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台联运配置控制器
 * @author C0de <47156503@qq.com>
 */
class MixController extends AdminController{
    /**
     * 配置
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        if(IS_POST){
            $object = D('Mix');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Mix')->find(1);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('配置')  //设置页面标题
            ->setUrl(U('index')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
				->addItem('main_html', 'kindeditor', '首页页面')
                ->setFormData($data)
                ->display();
        }
    }

   
}
