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
 * 后台游戏服务器控制器
 * @author C0de <47156503@qq.com>
 */
class GameserverController extends AdminController{
	
	
	
    /**
     * 服务器列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name|gid|sid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
		
		if(I('id')){
			$map['game']=I('id');
		}
        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Gameserver')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->fetchSql(FALSE)->where($map)->order('sort desc,id desc')->select();
		
        $page = new \Common\Util\Page(D('Gameserver')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as $key=>$val){
            $api_map['id']=$val['game'];
            $api=D('Game')->getColumnByfield('name', $api_map);
            $data_list[$key]['game']=$api[0];
            $line=C('LINE_LIST');
            $data_list[$key]['line']=$line[$val['line']];
            $target=C('TARGET_LIST');
            $data_list[$key]['target']=$target[$val['target']];

        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('服务器列表')  //设置页面标题
        ->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/名称/GID/SID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('name', '服务器名称', 'edit')
            ->addField('game', '游戏', 'text')
            ->addField('gid', 'GID', 'edit')
			->addField('sid', 'SID', 'edit')
            ->addField('line', '线路', 'text')
            ->addField('target', '链接', 'text')
            ->addField('flags', '属性', 'text')
            ->addField('ktime', '开服时间', 'time')
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
     * 新增服务器
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){

            $game=D('Game')->find($_POST['game']);
            if(empty($_POST['gid'])){
                $_POST['gid']=$game['api_id'];
            }
            if(empty($_POST['sid'])){
                $_obj=D('Gameserver')->order('id desc')->find();
                $_POST['sid']=$_obj['id']+1;
            }
            $_POST['ktime']=strtotime($_POST['ktime']);
            $_POST['flags']=implode(',',$_POST['flags']);
            $object = D('Gameserver');
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
            $Game=Array();
            foreach(D('Game')->select() as $val){
                $Game[$val['id']]=$val['name'];
            }
            $data=Array();
            $data['ktime']=time();
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('新增游戏')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('name', 'text', '名称', '服务器名称')
                ->addItem('game', 'select', '游戏', false, $Game)
                ->addItem('ktime', 'time', '开服时间', false)
                ->addItem('gid', 'text', 'GID', '为空则为接口ID')
                ->addItem('sid', 'text', 'SID', '为空则为数据库ID')
                ->addItem('line', 'select', '线路', false, C('LINE_LIST'))
                ->addItem('target', 'select', '打开方式', false, C('TARGET_LIST'))
                ->addItem('flags', 'checkbox', '属性', false, C('ATTRIBUTE_LIST'))
				->addItem('param', 'textarea', '扩展参数')
                ->setFormData($data)
                ->display();
        }
    }
	
	public function batchserver(){
		if(IS_POST){
			$g_obj=D('Game');
			$s_obj=D('Gameserver');
            $arr=explode("\r\n",$_POST['data']);
			if(count($arr) == 1){
				$__arr=explode("|",$arr[0]);
				if(!empty($__arr[1])){
					$new_arr=Array();
					foreach(explode(';',$__arr[0]) as $v){
						$__d=explode('=',$v);
						$__r[$__d[0]]=$__d[1];
					}
					$new_arr[]=$__arr[0];
					unset($arr);
					for($i=1;$i<=$__arr[1];$i++){
						$__r['server_name']++;
						$__r['sid']++;
						$new_arr[]="game_name={$__r['game_name']};server_name={$__r['server_name']};gid={$__r['gid']};sid={$__r['sid']};time={$__r['time']}";
					}
					$arr=$new_arr;
				}
			}
			

			$data=Array();
			foreach($arr as  $val){
				foreach(explode(';',$val) as $v){
					$_d=explode('=',$v);
					$_r[$_d[0]]=$_d[1];
				}
				$gmap['mark']=$_r['game_name'];
				$_G=$g_obj->where($gmap)->cache('GameserverBatchserver_Game',100)->find();
				if(empty($_G)){
					continue;
				}
				$smap['name']='双线'.$_r['server_name'].'区';
				$smap['game']=$_G['id'];
				$_S=$s_obj->where($smap)->cache('GameserverBatchserver_Server',100)->find();
				if(!empty($_S)){
					continue;
				}
				$data[]=Array('game'=>$_G['id'],'name'=>$smap['name'],'gid'=>$_r['gid'],'sid'=>$_r['sid'],'line'=>0,'target'=>0,'ktime'=>strtotime($_r['time']),'ctime'=>time(),'utime'=>time(),'sort'=>0,'status'=>1);
			}
            if($s_obj->addAll($data)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $s_obj->getError());
            }			
        }else{
			$builder = new \Common\Builder\FormBuilder();
			$data['data']='game_name=fyws;server_name=16;gid=10;sid=20;time=2016-01-25 17:00';
				$builder->title('批量配服')  //设置页面标题
				->setUrl(U('batchserver')) //设置表单提交地址
					->addItem('data', 'textarea', '批量配服', '以下列规范为标本 一行一个')
					->setFormData($data)
					->display();
		
		}
	}

    /**
     * 编辑服务器
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            if(empty($_POST['gid'])){
                $game=D('Game')->find($_POST['game']);
                $_POST['gid']=$game['api_id'];
            }
            $_POST['ktime']=strtotime($_POST['ktime']);
            $_POST['flags']=implode(',',$_POST['flags']);
            $object = D('Gameserver');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Gameserver')->find($id);
            $Game=Array();
            foreach(D('Game')->select() as $val){
                $Game[$val['id']]=$val['name'];
            }

            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑服务器')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('name', 'text', '名称', '服务器名称')
                ->addItem('game', 'select', '游戏', false, $Game)
                ->addItem('ktime', 'time', '开服时间', false)
                ->addItem('gid', 'text', 'GID', '为空则为接口ID')
                ->addItem('sid', 'text', 'SID', '*必填')
                ->addItem('line', 'select', '线路', false, C('LINE_LIST'))
                ->addItem('target', 'select', '打开方式', false, C('TARGET_LIST'))
                ->addItem('flags', 'checkbox', '属性', false, C('ATTRIBUTE_LIST'))
				->addItem('param', 'textarea', '扩展参数')
                ->setFormData($data)
                ->display();
        }
    }
}
