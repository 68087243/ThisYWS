<?php
namespace Gift\Controller;
use Think\Controller;
class IndexController extends GiftController {
    public function index(){

        $this->assign('giftGame',D('CardDetail')->getAllgiftByGame());
        $this->assign('meta_title','礼包中心');
        $this->display();
    }
}