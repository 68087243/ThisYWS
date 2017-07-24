<?php

namespace User\Controller;
use Think\Controller;

class indexController extends UserController{


    public function index(){
		$this->assign('meta_title', "用户中心");
        $this->display();
    }



}
