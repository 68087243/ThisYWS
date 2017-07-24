<?php

namespace User\Controller;
use Think\Controller;

class RechargeController extends UserController{


    public function index(){
        $userinfo = session('user_auth');
        $map['uid']=$userinfo['id'];
        $map['utime'] = array('NEQ','');
        $data_list = D('Paylog')->page(!empty($_GET["p"])?$_GET["p"]:1, 10)->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('Paylog')->where($map)->count(), 10);
		foreach($data_list as &$val){
			if($val['gameid'] && $val['serverid']){
				$game=D('Game')->where(Array('id'=>$val['gameid']))->find();
				$server=D('Gameserver')->where(Array('id'=>$val['serverid']))->find();
				$val['gameinfo']=$game['name'].'/'.$server['name'].'/'.$val['role'];
			}else{
				$val['gameinfo']='平台币';
			}
			$paytype=D('Paytype')->where(Array('tag'=>$val['paytype']))->find();
			$val['paytype']=$paytype['name'];
			if(!empty($val['bank'])){
				$val['paytype'].='/'.$val['bank'];
			}
		}

        $this->assign('data_list', $data_list);
        $this->assign('page', $page->show());
        $this->assign('meta_title', "充值记录");
        $this->display();
    }



}
