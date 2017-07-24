<?php

namespace User\Controller;
use Think\Controller;

class ScoreController extends UserController{


    public function index(){
		$this->assign('meta_title', "积分等级");
        $this->display();
    }



}
