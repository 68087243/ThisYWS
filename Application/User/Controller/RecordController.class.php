<?php

namespace User\Controller;
use Think\Controller;

class RecordController extends UserController{


    public function index(){
        $this->assign('meta_title', "游戏记录");
        $this->display();
    }



}
