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
 * 后台游戏玩家控制器
 * @author C0de <47156503@qq.com>
 */
class GameplayController extends AdminController{
    /**
     * 游戏玩家列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|uid|gid|sid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Gameplay')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('Gameplay')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        foreach($data_list as $key=>$val){
			
			$userinfo=D('User')->where(Array('id'=>$val['uid']))->find();
			$data_list[$key]['uid']=$userinfo['username'];

            $game_map['id']=$val['gid'];
            $game=D('Game')->where($game_map)->find();
            $data_list[$key]['gid']=$game['name'];

            $gameserver_map['id']=$val['sid'];
            $gameserver=D('Gameserver')->where($gameserver_map)->find();
            $data_list[$key]['sid']=$gameserver['name'];
			if(empty($val['rolename'])){
				$obj=GetApi($game['api']);
				if(method_exists($obj,'checkRole')){
					$rolename=$obj->checkRole($game,$gameserver,$userinfo);
					if($rolename){
						M('Gameplay')->where(Array('id'=>$val['id']))->save(Array('rolename'=>$rolename));
						$data_list[$key]['rolename']=$rolename;
					}else{
						$data_list[$key]['rolename']='未查到';
					}
				}
			}else{
				$data_list[$key]['rolename']=$val['rolename'];
			}
			
        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('游戏玩家列表')  //设置页面标题
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('uid', '玩家', 'text')
            ->addField('gid', '游戏', 'text')
            ->addField('sid', '服务器', 'text')
			->addField('rolename', '角色名', 'text')
            ->addField('ctime', '首次游戏时间', 'time')
            ->addField('ztime', '最后登录时间', 'time')
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
     * 编辑游戏玩家
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){

            $object = D('Gameplsy');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('Gameplay')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑游戏玩家')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('uid', 'text', '游戏用户ID', false)
                ->addItem('gid', 'text', '游戏ID', false)
                ->addItem('sid', 'text', '服务器ID', false)
                ->setFormData($data)
                ->display();
        }
    }
}
