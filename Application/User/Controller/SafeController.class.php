<?php

namespace User\Controller;
use Think\Controller;

class SafeController extends UserController{


    public function index(){
        $signtype=session('signtype');
        $userinfo = session('user_auth');
        if($signtype == 'bindemil'){
            if(I('emailsign') === session('emailsign')){
                $User = M("User");
                $data['id'] = $userinfo['id'];
                $data['email'] = session('emailtemp');
                $User->save($data);
                $this->assign('save_mail', 1);
            }
        }

        if($signtype == 'check'){
            if(I('emailsign') === session('emailsign')){
                $this->assign('check_mail', 1);
            }
        }

        if($signtype == 'modify'){
            if(I('emailsign') === session('emailsign')){
                $User = M("User");
                $data['id'] = $userinfo['id'];
                $data['email'] = session('emailtemp');
                $User->save($data);
                $this->assign('modify_mail', 1);
            }
        }
		
		$_qq=M('AddonSyncLogin')->where(Array('uid'=>$userinfo['id']))->find();
		if(!empty($_qq)){
			$this->assign('_qq', "1");
		}



		$this->assign('meta_title', "账号安全");
        $this->display();
    }


    public function sendsms(){
        $userinfo = session('user_auth');
        $time_t=session('smstime');
        if(!empty($time_t)){
            $time=time()-$time_t;
        }else{
            $time=100;
        }
        if(I('phone') && $time > 60 ) {
            $pattern='1234567890';
            $key="";
            for($i=0;$i<4;$i++)
            {
                $key.= $pattern{mt_rand(0,9)};    //生成php随机数
            }
            $phone=I('phone');
            session('smskey',$key);
            session('smsphone',$phone);
            session('smstime',time());
            send_mobile_message($phone,$key);
            $data['code']=1;
        }else{
            $data['code']=0;
        }
        $this->ajax($data);
    }

    public function VerifyMessage(){
        $userinfo = session('user_auth');
        $code=I('code');
        $s_code=session('smskey');
        if($code == $s_code){
            $map['id']=$userinfo['id'];
            $map['mobile']=session('smsphone');
            M('User')->save($map);
            session('smstime',null);
            session('smskey',null);
            $data['code']=1;
        }else{
            $data['code']=0;
        }
        $this->ajax($data);
    }

    public function setnewpw(){
        $userinfo = session('user_auth');
        if($userinfo['id']) {
            $old_pw = user_md5(I('old_pw'));
            if ($old_pw == $userinfo['password']) {
                $new_pw = user_md5(I('new_pw'));
                $data['id'] = $userinfo['id'];
                $data['password'] = $new_pw;
                M('User')->save($data);
                unset($data);
                $data['code'] = 1;
            } else {
                $data['code'] = 0;
            }
            $this->ajax($data);
        }
    }

    public function sendemail()
    {
        $type = I('type');
        switch ($type) {
            case 'safe':session('signtype','bindemil');break;
            case 'check':session('signtype','check');$map['id']='-1';break;
            case 'modify':session('signtype','modify');break;
        }
        $userinfo = session('user_auth');
        $email = I('email');
        $map['email'] = $email;
        $temp = M('User')->where($map)->find();
        $data = Array();
        if (empty($temp)) {
            $sign = md5($email . $userinfo['id'] . time());
            session('emailsign', $sign);
            session('emailtemp', $email);
            $subject = C('WEB_SITE_TITLE') . '--密保邮箱验证';
            $url = U('User/safe/index', array('emailsign' => $sign));
            $body = <<<EOF
<h2 style="margin: 5px 0px; "><font color="#333333" style="line-height: 20px; "><font style="line-height: 22px; " size="4">亲爱的 {$userinfo['username']}：</font></font></h2>
<p><strong>您正在进行个人资料的密保邮箱验证<em><a href="{$url}" target="_blank" style="text-decoration:underline;color:red;">点击完成验证</a></em></strong></p>
<p>如果上述文字点击无效，请把下面网页地址复制到浏览器地址栏中打开：<a href="{$url}" target="_blank" style="color:#03F; text-decoration:underline;">{$url}</a></p>
<p style="color:red;">(该链接仅在验证发出的网页有效，不能重复使用)</p>
EOF;
            send_mail($email, $subject, $body);
            $data['code'] = 1;
        } else {
            $data['code'] = 0;
            $data['msg'] = '您输入的密保邮箱已被他人使用!';
        }
        $this->ajax($data);
    }

    public function sfz()
    {
        $userinfo = session('user_auth');
        if ($userinfo['id'] && empty($userinfo['idcard_no'])) {
            $realname = I('fullname');
            $idcard_no = I('id_card');
            if (empty($realname) || utf8_strlen($realname) > 4 || !isCreditNo($idcard_no)) {
                $data['code'] = 0;
                $data['msg'] = '请填写正确的身份证号码和姓名!';
            } else {
                $data['code'] = 1;
                $map['id'] = $userinfo['id'];
                $map['realname'] = $realname;
                $map['idcard_no'] = $idcard_no;
                $_arr = getAgeByID($idcard_no);
                $map['age'] = $_arr['age'];
                $map['birthday'] = $_arr['birthday'];
                M('User')->save($map);
            }
            $this->ajax($data);
        }
    }


    public function VerifyCaptcha(){
        $captcha_code=I('captcha_code');
        $verify = new \Think\Verify();
        if($verify->check($captcha_code)){
            $data['code']=1;
        }else{
            $data['code']=0;
        }
        $this->ajax($data);
    }




}
