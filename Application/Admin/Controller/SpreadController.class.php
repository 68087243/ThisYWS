<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台CPS控制器
 * @author C0de <47156503@qq.com>
 */
class SpreadController extends AdminController{
    /**
     * 渠道列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|mid'] = array($condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Spread')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('Spread')->where($map)->count(), C('ADMIN_PAGE_ROWS'));


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('渠道列表')  //设置页面标题
		->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/MID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('mid', 'MID', 'text')
            ->addField('name', '渠道名', 'text')
            ->addField('pass', '密码', 'text')
            ->addField('bili', '比例', 'text')
			->addField('money', '余额', 'text')
			->addField('total_money', '累计余额', 'text')
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
     * 新增渠道
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('Spread');
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
            $builder->title('渠道添加')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('mid', 'text', 'MID')
                ->addItem('name', 'text', '渠道名')
                ->addItem('pass', 'text', '密码')
                ->addItem('bili', 'text', '比例')
				->addItem('payaccount', 'text', '收款账号')
                ->display();
        }
    }
	
	private function javascript(){
        $ajax_url_carddetail=U('Api/Carddetail/ajaxCarddetailBygid');
        $ajax_url_gameserver=U('Api/Game/ajaxGameServerBygid');
        $js=<<<EOF
id='gid' onchange="var s = $('#sid');$.post('$ajax_url_gameserver',{gid:$('#gid').val()},function(re){s.empty();s.append($('<option>').text('全服').val('0'));s.trigger('chosen:updated');s.chosen();if(re!=''&&re!='[]'){var temp=0;$.each(re,function(index,item){var opt=$('<option>').text(item.name).val(item.id);s.append(opt);s.trigger('chosen:updated');s.chosen()})}});"
EOF;
        return $js;
    }
	
	private function javascript1(){
        $ajax_url=U('Api/Spread/ajaxPurl');
        $js=<<<EOF
id='sid' onchange="$.post('$ajax_url',{gid:$('#gid').val(),sid:$('#sid').val(),mid:$('#mid').val()},function(re){ $('#url').val(re.url);});"
EOF;
        return $js;
    }
	private function javascript2(){
        $ajax_url=U('Api/Spread/ajaxPurl');
        $js=<<<EOF
id='url' onclick="$.post('$ajax_url',{gid:$('#gid').val(),sid:$('#sid').val(),mid:$('#mid').val()},function(re){ $('#url').val(re.url);});"
EOF;
        return $js;
    }
	
	public function make(){
		
            $Game=Array();
            foreach(D('Game')->select() as $val){
                $Game[$val['id']]=$val['name'];
            }

            $Gameserver=Array();
            $Gameserver[0]='全服';
            foreach(D('Gameserver')->select() as $val){
                $Gameserver[$val['id']]=$val['name'];
            }
			$mid=Array();
			foreach(D('Spread')->select() as $val){
                $mid[$val['mid']]=$val['name'];
            }
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('推广链接生成')  //设置页面标题
            ->setUrl() //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('gid', 'select', '游戏', false, $Game,false,$this->javascript())
                ->addItem('sid', 'select', '服务器', false,$Gameserver,false,$this->javascript1())
                ->addItem('mid', 'select', '渠道', false, $mid,false,'id="mid"')
				->addItem('url', 'text', '推广链接',false,false,false,$this->javascript2())
                ->display();
				
	}

    /**
     * 编辑渠道
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('Spread');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Spread')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('渠道编辑')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('mid', 'text', 'MID')
                ->addItem('name', 'text', '渠道名')
                ->addItem('pass', 'text', '密码')
                ->addItem('bili', 'text', '比例')
				->addItem('payaccount', 'text', '收款账号')
                ->setFormData($data)
                ->display();
        }
    }
}
