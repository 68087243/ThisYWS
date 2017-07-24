<?php
namespace Gateway\Controller;
use Think\Controller;
class GameController extends GatewayController {

	
	public function play(){
        $gid=intval(I('gid'));
		$sid=intval(I('sid'));
        $game=D('Game')->find($gid);
        if(empty($game)){
            $this->error('游戏不存在');
        }
        $server=D('Gameserver')->where(Array('game'=>$game['id'],'id'=>$sid))->find();
        if(empty($server)){
            $this->error('服务器不存在');
        }
        $this->assign('game',$game);
        $this->assign('server',$server);
		$this->display();
	}

    public function enter(){
        $userinfo=session('user_auth');
        $gid=intval(I('gid'));
        $sid=intval(I('sid'));
        $game=D('Game')->find($gid);
        if(empty($game)){
            $this->error('游戏不存在');
        }
        $server=D('Gameserver')->where(Array('game'=>$game['id'],'id'=>$sid))->find();
        if(empty($server)){
            $this->error('服务器不存在');
        }
		$obj=GetApi($game['api']);
		$_extend_home_api=Array();
        if(method_exists($obj,'_extend_home_api')){
           $_extend_home_api=$obj->_extend_home_api();
        }
		$this->assign('_extend_home_api',$_extend_home_api);
		$game['pic']=json_decode($game['pic'],true);
		$this->assign('game',$game);
		$this->assign('server',$server);
            if($server['ktime'] > time()){
                $this->display('notime');
            }else {
				if($game['status'] == 0 || $server['status'] == 0 ){
					$this->display('nostatus');
				}else{
					if($userinfo){
					$task_log=D('TaskLog');
					$task=$task_log->isTask($userinfo['id'],13);
					if(!$task){
						 $taskconfig=M('task')->where(Array('id'=>13))->find();
						 D('User')->addScore($userinfo['id'], $taskconfig['config'],false,'玩游戏');
						 $save['uid'] = $userinfo['id'];
						 $save['tid'] = 13;
						 $save['ctime'] = time();
						 $save['utime'] = time();
						 $save['status'] = 1;
						 $task_log->add($save);
					}
						D('Game')->uplog($game, $server, $userinfo);//更新用户游戏记录
					}
					$this->display();
				}
	
				
            }
		
       
    }

    public function bridge(){

        $userinfo=session('user_auth');
        $gid=intval(I('gid'));
        $sid=intval(I('sid'));
        $game=D('Game')->find($gid);
        if(empty($game)){
            $this->error('游戏不存在');
        }
        $server=D('Gameserver')->where(Array('game'=>$game['id'],'id'=>$sid))->find();
		
        if(empty($server)){
            $this->error('服务器不存在');
        }
		$game['pic']=json_decode($game['pic'],true);
        $this->assign('game',$game);
        $this->assign('server',$server);

        if(empty($userinfo)){
			session('redirect',U('Gateway/Game/Play',array('gid'=>$gid,'sid'=>$sid)));
            $this->display('login');//启动登陆
        }else{
            if($server['ktime'] > time()){
                $this->display('notime');
            }else {
				if($game['status'] == 0 || $server['status'] == 0 ){
					$this->display('nostatus');
				}else{
					C('VIEW_PATH', './Game/Theme/');//临时改变模板目录
					GetApi($game['api'])->play($game,$server,$userinfo);//启动游戏
				}
            }
        }
    }
}