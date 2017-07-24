<?php
namespace Forum\Controller;
use Think\Controller;
class IndexController extends ForumController {
    public function index(){
		$game=M('Game')->order('sort desc')->select();
		var_dump($game);
		if(is_array($game)){
			foreach($game as &$val){
				$val['pic']=json_decode($val['pic'],true);
			}
		}
	
		$this->assign('game',$game);
        $this->display('Index/Main');
    }
}