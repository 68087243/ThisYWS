<?php

namespace User\Controller;
use Think\Controller;

class PublicController extends Controller{

    protected function _initialize(){
        set_theme();
        if(!C('TOGGLE_WEB_SITE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
        $this->assign('meta_keywords', C('WEB_SITE_KEYWORD'));
        $this->assign('meta_description', C('WEB_SITE_DESCRIPTION'));
    }

    public function login(){
        $uid=is_login();
        if(!empty($uid)){
            $this->redirect('User/index/index');
        }
		$this->assign('meta_title', "用户登陆");
        $this->display();
    }

    public function register(){
        $uid=is_login();
        if(!empty($uid)){
            $this->redirect('User/index/index');
        }
        $this->assign('meta_title', "用户注册");
        $this->display();
    }


    public function vcode(){
        $config =    array(
            'fontSize'    =>    20,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
        );
        session('');
        $Verify =     new \Think\Verify($config);
        $Verify->entry();
    }

    public function VerifyCaptcha(){
        $captcha_code=strtolower(I('captcha_code'));
        $verify = new \Think\Verify();
        if($verify->check($captcha_code)){
            $data['code']=1;
        }else{
            $data['code']=0;
        }
        $this->ajax($data);
    }

    public function validateUser(){
        $map['username'] = addslashes($_GET['TicketPwdValidateForm']['username']);
        $verify = new \Think\Verify();
        $captcha_code=$_GET['TicketPwdValidateForm']['verifyCode'];
        if($verify->check($captcha_code)){
            $data = D('User')->where($map)->find();
            if(!empty($data)){
                $ajax['status']=0;
                if(!empty($data['email'])){
                   $ajax['email']= half_replace($data['email']);
                }
                if(!empty($data['mobile'])){
                    $ajax['phone']= half_replace($data['mobile']);
                }
            }else{
                $ajax['status']=1;
                $ajax['error']=Array('username'=>'帐号不存在');
            }
        }else{
            $ajax['status']=1;
            $ajax['error']=Array('verifyCode'=>'验证码不正确');
        }
        $this->ajax($ajax);
    }

}
