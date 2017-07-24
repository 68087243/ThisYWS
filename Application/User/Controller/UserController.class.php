<?php

namespace User\Controller;
use Think\Controller;
/**
 * 用户公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 * @author C0de <47156503@qq.com>
 */
class UserController extends Controller{
    /**
     * 初始化方法
     * @author jry <598821125@qq.com>
     */
    protected function _initialize(){
        set_theme();
        if(!C('TOGGLE_WEB_SITE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
        $uid=is_login();
        if(empty($uid)){
            $this->redirect('User/public/login');
        }
        $this->assign('meta_keywords', C('WEB_SITE_KEYWORD'));
        $this->assign('meta_description', C('WEB_SITE_DESCRIPTION'));
        $__USER__=D('User')->find(is_login());
        $map['uid']=$__USER__['id'];
        $map['qtime']=date("Y-m-d");
        $sign=M('UserSign')->where($map)->find();
        if(empty($sign)){
            $__USER__['sign']=0;
        }else{
            $__USER__['sign']=1;
        }
		
        $pay=M('Paylog')->where("uid = '{$__USER__['id']}' and FROM_UNIXTIME(utime,'%Y-%m-%d') = curdate()")->find();
        if(empty($pay)){
            $__USER__['pay']=0;
        }else{
            $__USER__['pay']=1;
        }
        $__USER__['gameplay']=D('Gameplay')->getCountGameplay($__USER__['id']);
        $this->assign('__USER__', $__USER__); //用户登录信息
    }

}
