<?php

namespace Game\Controller;
use Think\Controller;

class GameController extends Controller{

    protected function _initialize(){
        set_theme();
        if(!C('TOGGLE_WEB_SITE')){
            $this->error('站点已经关闭，请稍后访问~');
        }

        $this->assign('meta_keywords', C('WEB_SITE_KEYWORD'));
        $this->assign('meta_description', C('WEB_SITE_DESCRIPTION'));
        $this->assign('__USER__', session('user_auth')); //用户登录信息
    }

}
