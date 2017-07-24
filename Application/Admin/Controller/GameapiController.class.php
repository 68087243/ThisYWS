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
 * 后台游戏控制器
 * @author C0de <47156503@qq.com>
 */
class GameapiController extends AdminController{
    /**
     * 游戏接口列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|tag|unid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Gameapi')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Gameapi')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('游戏接口列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/名称/标签/标识', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '名称', 'text')
            ->addField('tag', '标签', 'text')
            ->addField('unid', '标识', 'text')
            ->addField('login_url', '登陆地址', 'text')
            ->addField('pay_url', '充值地址', 'text')
            ->addField('ctime', '添加时间', 'time')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
			->addRightButton('self',Array('href'=>'Admin/gameapi/extend','title'=>'接口操作'))
            ->addRightButton('edit')   //添加编辑按钮
            ->addRightButton('forbid') //添加禁用/启用按钮
            ->addRightButton('delete') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }
	private function javascript(){
        $ajax_url_gameserver=U('Api/Game/ajaxGameServerBygid');
        $js=<<<EOF
id='gid' onchange="var s = $('#sid');$.post('$ajax_url_gameserver',{gid:$('#gid').val()},function(re){s.empty();s.append($('<option>').text('全服').val('0'));s.trigger('chosen:updated');s.chosen();if(re!=''&&re!='[]'){var temp=0;$.each(re,function(index,item){var opt=$('<option>').text(item.name).val(item.id);s.append(opt);s.trigger('chosen:updated');s.chosen()})}});"
EOF;
        return $js;
    }
	public function extend($id){
		if(IS_POST){
            $obj=GetApi($_POST['id']);
            if(method_exists($obj,$_POST['action'])){
				unset($_POST['id']);
				$_POST['ctime']=time();
				M('GameapiLog')->add($_POST);
                $obj->$_POST['action']($_POST);
            }
        }else{
            $Game=Array();
            foreach(D('Game')->where(Array('api'=>$id))->select() as $val){
                $Game[$val['id']]=$val['name'];
            }
			$obj=GetApi($id);
			$action=Array();
            if(method_exists($obj,'_extend_admin_api')){
				
                $action=$obj->_extend_admin_api();
            }
			$data['id']=$id;
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('接口操作')  //设置页面标题
            ->setUrl(U('extend')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
				->addItem('action', 'select', '方法', false, $action,false)
                ->addItem('gid', 'select', '游戏', false, $Game,false,$this->javascript())
                ->addItem('sid', 'select', '服务器', false,false,false,'id="sid"')
                ->addItem('username', 'text', '用户名', false)
                ->addItem('param', 'textarea', '参数', false)
                ->setFormData($data)
                ->display();
        }
		
		
	}

    /**
     * 新增接口
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('Gameapi');
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
                ->addItem('name', 'text', '名称', '接口名称')
                ->addItem('tag', 'text', '标签', '*接口文件必须以此命名')
                ->addItem('unid', 'text', '标识', '接口标识(混服)')
                ->addItem('login_url', 'text', '登陆地址', '接口混服地址')
                ->addItem('pay_url', 'text', '充值地址', '接口充值地址')
                ->addItem('login_key', 'text', '登陆KEY', '接口登陆KEY')
                ->addItem('pay_key', 'text', '充值KEY', '接口充值KEY')
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
            $object = D('Gameapi');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑接口')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('name', 'text', '名称', '接口名称')
                ->addItem('tag', 'text', '标签', '*接口文件必须以此命名')
                ->addItem('unid', 'text', '标识', '接口标识(混服)')
                ->addItem('login_url', 'text', '登陆地址', '接口混服地址')
                ->addItem('pay_url', 'text', '充值地址', '接口充值地址')
                ->addItem('login_key', 'text', '登陆KEY', '接口登陆KEY')
                ->addItem('pay_key', 'text', '充值KEY', '接口充值KEY')
                ->addItem('remark', 'textarea', '备注',false)
                ->setFormData(D('Gameapi')->find($id))
                ->display();
        }
    }
}
