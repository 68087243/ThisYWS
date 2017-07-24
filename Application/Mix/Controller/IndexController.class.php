<?php
namespace Mix\Controller;
use Think\Controller;
class IndexController extends MixController {
    public function index(){
        $this->show('nginx','utf-8');
    }
}