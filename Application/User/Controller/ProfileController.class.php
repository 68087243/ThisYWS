<?php

namespace User\Controller;
use Think\Controller;

class ProfileController extends UserController{


    public function index(){

        if(I('qqsign') === session('qqsign')){
            $bindqq=1;
            $User = M("User");
            $data['id'] = is_login();
            $data['qq'] = session('qqtemp');
            $User->save($data);
        }else{
            $bindqq=0;
        }

        if(IS_POST){
            $User = M("User");
            $data['id'] = is_login();
            $data['sex'] = I('post.sex');
            $data['occupation'] = I('post.occupation');
            $data['extend'] = I('post.province').'-'.I('post.city').'-'.I('post.dist');
            $User->save($data);
        }
        $this->assign('bindqq', $bindqq);
        $this->assign('meta_title', "个人资料");
        $this->display();

    }

    public function sendqq()
    {
        $qq = I('qq');
        $userinfo = session('user_auth');
        if (!empty($qq)  && empty($userinfo['qq']) && strlen(intval($qq)) >= 5 && strlen(intval($qq)) <= 11) {
            $map['qq'] = $qq;
            $map['id'] = $userinfo['id'];
            $temp = M('User')->where($map)->find();
            $data = Array();
            if (empty($temp)) {
                $qqsign = md5($qq . $userinfo['id'] . time());
                session('qqsign', $qqsign);
                session('qqtemp', $qq);
                $receiver = $qq . '@qq.com';
                $subject = C('WEB_SITE_TITLE') . '--个人资料验证';
                $url = U('User/profile/index', array('qqsign' => $qqsign));
                $body = <<<EOF
<h2 style="margin: 5px 0px; "><font color="#333333" style="line-height: 20px; "><font style="line-height: 22px; " size="4">亲爱的 {$userinfo['username']}：</font></font></h2>
<p><strong>您正在进行个人资料的腾讯账号验证<em><a href="{$url}" target="_blank" style="text-decoration:underline;color:red;">点击完成验证</a></em></strong></p>
<p>如果上述文字点击无效，请把下面网页地址复制到浏览器地址栏中打开：<a href="{$url}" target="_blank" style="color:#03F; text-decoration:underline;">{$url}</a></p>
<p style="color:red;">(该链接仅在验证发出的网页有效，不能重复使用)</p>
EOF;

                send_mail($receiver, $subject, $body);

                $data['code'] = 1;
            } else {
                $data['code'] = 0;
                $data['msg'] = '您输入的QQ账号已使用!';
            }
            $this->ajax($data);
        }
    }



}
