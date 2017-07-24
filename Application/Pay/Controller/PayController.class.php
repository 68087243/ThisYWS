<?php

namespace Pay\Controller;
use Think\Controller;
/**
 * 充值控制器
 * @author C0de <47156503@qq.com>
 */
class PayController extends Controller{
    /**
     * 初始化方法
     * @author jry <598821125@qq.com>
     */
    protected function _initialize(){
        set_theme();
        if(!C('TOGGLE_WEB_SITE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
		$userinfo=session('user_auth');
		if(!empty($userinfo)){
			$__USER__=D('User')->find($userinfo['id']);
			$this->assign('__USER__', $__USER__); //用户登录信息
		}
        $this->assign('meta_keywords', C('WEB_SITE_KEYWORD'));
        $this->assign('meta_description', C('WEB_SITE_DESCRIPTION'));
        
    }

}
