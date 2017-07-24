<?php
namespace Service\Controller;
use Think\Controller;
class InformationController extends ServiceController {

  

   
	public function _empty($name){
		$map['tag']=addslashes($name);
		$info=M('Page')->where($map)->find();
		if(empty($info)){
			$this->redirect('index/index');
		}
		$nav=M('Page')->select();
		$this->assign('meta_title',$info['name']);
		$this->assign('info',$info);
		$this->assign('nav',$nav);
		$this->display('info');
	}

}