<?php
namespace Pay\Controller;
use Think\Controller;
class ReturnController extends PayController {

    protected function _initialize(){
        parent::_initialize();
        $userinfo=session('user_auth');
        if(empty($userinfo)){
            $this->redirect('User/Public/login');
        }
    }


    public function index($order=0){
        $userinfo=session('user_auth');
        $map['uid']=$userinfo['id'];
        if(empty($order)){
            $data=D('Paylog')->where($map)->order('id desc')->find();
        }else{
            $map['order']=$order;
            $data=D('Paylog')->where($map)->order('id desc')->find();
        }
        if(empty($data)){
            $this->redirect('Pay/index/index');
        }
            switch($data['platform']){

                case 0:
                    $game=D('Game')->where(Array('id'=>$data['gameid']))->find();
                    $data['game_name']=$game['name'];
                    $data['unit']=$game['unit'];
                    $data['server_name']=D('Gameserver')->getFieldBymap('name',Array('game'=>$data['gameid'],'id'=>$data['serverid']));
                    break;
            }
            $data['type_name']=D('Paytype')->getFieldBymap('name',Array('tag'=>$data['paytype']));

        $this->assign('paydata',$data);
        $this->assign('meta_title','充值结果');
        $this->display('index');
    }

    public function _empty($name){
        $this->index($name);
    }


}