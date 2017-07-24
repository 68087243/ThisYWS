<?php

namespace Api\Controller;
use Think\Controller;
/**
 * Api控制器
 */
class ApiController extends Controller{
    /**
     * 初始化方法
     */
    protected function _initialize(){
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: no-cache, must-revalidate");
        set_theme();
        if(!C('TOGGLE_WEB_SITE')){
            $this->error('站点已经关闭，请稍后访问~');
        }

        $this->assign('meta_keywords', C('WEB_SITE_KEYWORD'));
        $this->assign('meta_description', C('WEB_SITE_DESCRIPTION'));
        $__USER__=D('User')->find(is_login());
        $this->assign('__USER__', $__USER__); //用户登录信息
    }

}
