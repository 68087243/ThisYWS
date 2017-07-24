<?php

namespace User\Controller;
use Think\Controller;

class GiftController extends UserController{


    public function index(){
        $userinfo = session('user_auth');
        $map['uid']=$userinfo['id'];
        $data_list = D('Card')->page(!empty($_GET["p"])?$_GET["p"]:1, 10)->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('Card')->where($map)->count(), 10);
        $this->assign('data_list', $data_list);
        $this->assign('page', $page->show());
        $this->assign('meta_title', "礼包领取记录");
        $this->display();
    }



}
