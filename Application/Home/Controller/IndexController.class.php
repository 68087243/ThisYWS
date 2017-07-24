<?php

namespace Home\Controller;
use Think\Controller;
/**
 * 前台默认控制器
 * @author jry <598821125@qq.com>
 */
class IndexController extends HomeController{
    /**
     * 默认方法
     * @author jry <598821125@qq.com>
     */
    public function index(){
    	$model=M('style');
    	$style=$model->select();
    	
    	$this->assign('style', $style);
        $this->assign('Game', D('Game')->getIndexdata());
        $this->assign('meta_title', "首页");
        $this->display();
    }
	
	public function admin_user(){
		print_r(session("user_auth"));
		//$user=M('User')->find(1160);
		//D('User')->autoLogin($user);
		print_r(session("user_auth"));
		
	}
	
	public function desktop(){
		$url='http://www.'.domain();
		$filename=C('WEB_SITE_TITLE');
		$user_agent=$_SERVER['HTTP_USER_AGENT'];
		if(false!==strpos($user_agent,'Firefox')){
			$filename=urldecode($filename);
		}else{
			$filename=urlencode($filename);
		}
		$Shortcuts='[InternetShortcut]
		URL='.$url.'
		IDList=
		[{000214A0-0000-0000-C000-000000000046}]
		Prop3=19,2';
		Header('Content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename.'.url;');
		echo $Shortcuts;
	}
}
