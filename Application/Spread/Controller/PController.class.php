<?php

namespace Spread\Controller;
use Think\Controller;
use Common\Util;

class PController extends SpreadController{

    public function index($key=''){
		if(empty($key)){
			$this->redirect('Game/Index/index');
		}
		$hashids = new \Common\Util\Hashids(md5('t3t2key'), 20);
		$ids = $hashids->decode(strtolower($key));
		
		if(!is_array($ids)){
			$this->redirect('Game/Index/index',Array("_error"=>1));
		}
		$mid=M('Spread')->where(Array('mid'=>$ids[0]))->find();
		if(empty($mid)){
			$this->redirect('Game/Index/index',Array("_error"=>2));
		}
		$game=M('Game')->find($ids[1]);
		if(empty($game) || empty($game['spread'])){
			$this->redirect('Game/Index/index',Array("_error"=>3));
		}
		if(!empty($ids[3])){
			$_temp=M('SpreadLower')->where(Array('mid'=>$ids[0],'id'=>$ids[3]))->find();
			if(empty($_temp)){
				$this->redirect('Game/Index/index',Array("_error"=>4));
			}
		}
		
		$xy=explode(",",$game['spread']);
		if(empty($ids[2])){
			$map['status']=array('eq',1);
			$map['game']=$ids[1];
			$data= M('Gameserver')->where($map)->order('id desc')->find();
			$url=U('Gateway/Game/Play',array('gid'=>$data['game'],'sid'=>$data['id']));
			$ids[2]=$data['id'];
		}else{
			$url=U('Gateway/Game/Play',array('gid'=>$ids[1],'sid'=>$ids[2]));
		}
		session('redirect',$url);
		$this->assign('xy', $xy);
		$this->assign('ids', $ids);
		$this->assign('mid', $mid);
		$this->assign('game', $game);
		$this->assign('url', $url);
		$this->display('index');
    }
	
	public function _empty($name){
		$this->index($name);
	}




}
