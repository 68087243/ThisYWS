<?php

namespace Home\Controller;
use Think\Controller;

class ErrorController extends HomeController{
   
    public function index(){
		header("HTTP/1.1 404 Not Found");  
		header("Status: 404 Not Found");  
        $this->assign('meta_title', "系统错误");
        $this->display();
    }
	
	
}
