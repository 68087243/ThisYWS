<?php
namespace Shop\Controller;
use Think\Controller;
class IndexController extends ShopController {
    public function index(){
		echo "nginx";exit;
        $this->display();
    }
}