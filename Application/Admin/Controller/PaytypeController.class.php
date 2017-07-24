<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台充值渠道控制器
 * @author C0de <47156503@qq.com>
 */
class PaytypeController extends AdminController{
    /**
     * 充值渠道列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|tag|description'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Paytype')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Paytype')->where($map)->count(), C('ADMIN_PAGE_ROWS'));


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('充值渠道列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/名称/标签/描述', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '名称', 'text')
            ->addField('tagname', '标签名', 'text')
            ->addField('tag', '标签', 'text')
            ->addField('least', '最小充值金额', 'text')
			->addField('most', '最大充值金额', 'text')
            ->addField('ctime', '充值时间', 'time')
			->addField('iscard', '是否卡类', 'status')
			->addField('sort', '排序', 'edit')
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
     * 新增渠道
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('Paytype');
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
			$payapi=Array();
			foreach(M('Payapi')->select() as $val){
				$payapi[$val['id']]=$val['name'];
			}

            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('新增渠道')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('name', 'text', '名称', false)
                ->addItem('tagname', 'text', '标签名', '渠道标签名')
                ->addItem('tag', 'text', '标签', '渠道标签')
				->addItem('payapi', 'select', '支付接口', false, $payapi)
                ->addItem('help_url', 'text', '帮助网址', '充值遇到问题链接')
				->addItem('iscard', 'radio', '是否卡类', false, Array('1'=>'是','0'=>'否'))
                ->addItem('bank', 'select', '开启银行列表', false, Array('1'=>'是','0'=>'否'))
                ->addItem('fee', 'text', '手续费', '留空和0则无手续费，填写百分比')
                ->addItem('icon', 'text', 'ICON图片ID', false)
                ->addItem('least', 'text', '最少充值金额', false)
				->addItem('most', 'text', '最大充值金额', false)
                ->addItem('money', 'textarea', '充值金额', '一行一个,可留空')
                ->addItem('description', 'kindeditor', '充值说明', false)
                ->display();
        }
    }

    /**
     * 编辑游戏
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Paytype');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
			$payapi=Array();
			foreach(M('Payapi')->select() as $val){
				$payapi[$val['id']]=$val['name'];
			}
            $data=D('Paytype')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑渠道')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('name', 'text', '名称', false)
                ->addItem('tagname', 'text', '标签名', '渠道标签名')
                ->addItem('tag', 'text', '标签', '渠道标签')
				->addItem('payapi', 'select', '支付接口', false, $payapi)
                ->addItem('help_url', 'text', '帮助网址', '充值遇到问题链接')
				->addItem('iscard', 'radio', '是否卡类', false, Array('1'=>'是','0'=>'否'))
                ->addItem('bank', 'select', '开启银行列表', false, Array('1'=>'是','0'=>'否'))
                ->addItem('fee', 'text', '手续费', '留空和0则无手续费，填写百分比')
                ->addItem('icon', 'text', 'ICON图片ID', false)
                ->addItem('least', 'text', '最少充值金额', false)
				->addItem('most', 'text', '最大充值金额', false)
                ->addItem('money', 'textarea', '充值金额', '一行一个,可留空')
                ->addItem('description', 'kindeditor', '充值说明', false)
                ->setFormData($data)
                ->display();
        }
    }
}
