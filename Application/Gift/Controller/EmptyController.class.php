<?php

namespace Gift\Controller;
use Think\Controller;

class EmptyController extends GiftController{

    public function index(){

        $Name = addslashes(CONTROLLER_NAME);//当前控制器
        $map['mark']=$Name;
        $map['status']=array('eq',1);
        $game=D('Game')->where($map)->find();
        if(empty($game)){
            //游戏不存在 跳回主页
            $this->redirect('Home/Index/Index');
        }
		$obj=GetApi($game['api']);
        if(method_exists($obj,'getCard')){
			$giftlist_mix=D('Mixgift')->where(Array('game'=>$game['id']))->select();
			if(!empty($giftlist_mix)){
				$_server = D('Gameserver')->where(Array('game'=>$game['id']))->select();
				$this->assign('api_giftlist', $giftlist_mix);
				$this->assign('server', $_server);
			}
		}
        $giftlist=D('CardDetail')->where(Array('gid'=>$game['id'],'status'=>Array('neq',0)))->order('id desc')->select();
        $this->assign('giftlist', $giftlist);
        $this->assign('giftgame', $game);
        $this->assign('meta_title', $game['name'].'礼包列表');
        $this->display('Card/index');
    }







}
