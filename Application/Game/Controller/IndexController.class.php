<?php
namespace Game\Controller;
use Think\Controller;
class IndexController extends GameController {
    public function index(){

        $gameall=D('Game')->getList();
        $gametj=D('Game')->getGamedata();
        $this->assign('gametj',$gametj);
        $this->assign('gameall',$gameall);
        $this->assign('meta_title', "游戏中心");
        $this->display();
    }
}