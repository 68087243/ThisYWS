<?php
namespace Api\Controller;
use Think\Controller;
use Common\Util;
class IndexController extends Controller {
    public function index(){
        $this->show('nginx','utf-8');
    }
	
	
}