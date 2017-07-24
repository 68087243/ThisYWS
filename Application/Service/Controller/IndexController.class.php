<?php
namespace Service\Controller;
use Think\Controller;
class IndexController extends ServiceController {
    public function index(){
        //build_order_no();

        $this->assign('meta_title', "客服中心");
        $this->display();
    }
}