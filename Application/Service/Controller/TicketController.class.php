<?php
namespace Service\Controller;
use Think\Controller;
class TicketController extends ServiceController {
    public function index($tid=1){
        //build_order_no();

        $form=M('IssueConfig')->find($tid);

        if(empty($form)){
            $this->redirect('Home/Index/Index');
        }
        $this->assign('tid', $tid);
        $this->assign('meta_title', $form['name']);
        $this->assign('islogin', $form['islogin']);
        $this->assign('form_field', json_decode($form['field'],true));
        $this->display('index');
    }

    public function submit(){
        $type=intval(I('type'));
        $config=D('IssueConfig')->find($type);
        if(!empty($config)){
            $field_config=json_decode($config['field'],true);
            foreach($field_config as $val){
                foreach($val as $v){
                    if($v['required']==1 && empty($_POST['TicketForm'][$v['name']])){
                        $this->ajax(Array('msg'=>'empty'));
                    }
                }
            }
            $userinfo = session('user_auth');
            if($config['islogin'] == 1 && empty($userinfo)){
                $this->ajax(Array('msg'=>'user'));
            }
            if(!empty($userinfo)){
                $save['uid']=$userinfo['id'];
            }
            $save['sno']='S'.build_order_no();
            $save['type']=$type;
            $save['field']=json_encode(I('TicketForm'));
            $save['email']=I('email');
            $save['mobile']=I('mobile');
            if(empty($save['email'])){
                $this->ajax(Array('msg'=>'email'));
            }
            if(empty($save['mobile'])){
                $this->ajax(Array('msg'=>'mobile'));
            }
            $save['qq']=I('qq');
            $save['note']=I('note');
            $save['ctime']=time();
            $save['status']=1;
            $save['adminstatus']='申诉中';
            $save['ip']=get_client_ip();
            D('Issue')->add($save);
            $this->assign('tid', $type);
            $this->assign('sno', $save['sno']);
            $this->assign('meta_title','自助申诉');
            $this->display();
        }
    }

    public function save(){
        $sno=I('sno');
        $data=D('Issue')->where(Array('sno'=>$sno))->find();
        if(!empty($data)) {
            $filename = C('WEB_SITE_TITLE') . "自助申诉单.txt";
            $encoded_filename = urlencode($filename);
            $encoded_filename = str_replace("+", "%20", $encoded_filename);
            header("Content-Type: application/octet-stream");
            if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
                header('Content-Disposition:  attachment; filename="' . $encoded_filename . '"');
            } elseif (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])) {
                header('Content-Disposition: attachment; filename*="utf8' . $filename . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $filename . '"');
            }
            $config=D('IssueConfig')->find($data['type']);
            echo C('WEB_SITE_TITLE') . "自助申诉 \r\n您的自助申诉单号为：{$sno} \r\n申诉类型：{$config['name']} \r\n查询地址：".U('Service/ticket/query')." \r\n我们将在3个工作日尽快答复。";
        }
    }

    public function query(){
        $userinfo = session('user_auth');
        if(IS_POST){
            $sno=I('sno');
            $map['sno']=$sno;
            $data=D('Issue')->where($map)->select();
        }else{
            $map['uid']=$userinfo['id'];
            $data=D('Issue')->where($map)->order('id desc')->select();
        }
        $this->assign('meta_title','进度查询');
        $this->assign('datalist', $data);
        $this->display();
    }

    public function details(){
        $sno=I('sno');
        $map['sno']=$sno;
        if(I('grade')){
            $data=D('Issue')->where($map)->find();
            if(empty($data['grade']) && I('grade')>0 && I('grade')<=5){
                $save['grade'] = I('grade');
                D('Issue')->where($map)->save($save);
                $this->ajax(Array('msg'=>'评价成功','status'=>1));
            }
        }
        $data=D('Issue')->where($map)->find();
        $issueconfig=D('IssueConfig')->find($data['type']);
        $this->assign('issue', $data);
        $this->assign('issueconfig', $issueconfig);
        $this->assign('form_field', json_decode($data['field'],true));
        $this->assign('issue_field', json_decode($issueconfig['field'],true));
        $this->assign('meta_title','自助申诉详情');
        $this->display();
    }


    public function password(){
        $form=M('IssueConfig')->find(11);
        $this->assign('meta_title', $form['name']);
        $this->assign('form_field', json_decode($form['field'],true));
        $this->assign('meta_title','忘记密码');
        $this->display();
    }

    public function sendEmail(){
        $username=I('username');
        $email=I('email');
        if($username && $email){
            $map['username']=$username;
            $map['email']=$email;
            $data=D('User')->where($map)->find();
            if(!empty($data)){
                $sign = md5($email . $data['id'] . time());
                $subject = C('WEB_SITE_TITLE') . '--找回密码';
                $url = U('Service/ticket/password', array('pwdsign' => $sign));
                session('pwdsign', $sign);
                session('password_username',$data['username']);
                $body = <<<EOF
<h2 style="margin: 5px 0px; "><font color="#333333" style="line-height: 20px; "><font style="line-height: 22px; " size="4">亲爱的 {$data['username']}：</font></font></h2>
<p><strong>您正在进行找回密码验证<em><a href="{$url}" target="_blank" style="text-decoration:underline;color:red;">点击完成验证</a></em></strong></p>
<p>如果上述文字点击无效，请把下面网页地址复制到浏览器地址栏中打开：<a href="{$url}" target="_blank" style="color:#03F; text-decoration:underline;">{$url}</a></p>
<p style="color:red;">(该链接仅在验证发出的网页有效，不能重复使用)</p>
EOF;
                send_mail($email, $subject, $body);
                $ajax['status']=0;
                $ajax['msg']='邮件已发送，请登陆邮箱查收';
            }else{
                $ajax['status']=1;
                $ajax['msg']='邮箱填写错误';
            }
            $this->ajax($ajax);
        }
    }


    public function sendsms(){
        $time_t=session('smstime');
        if(!empty($time_t)){
            $time=time()-$time_t;
        }else{
            $time=100;
        }
        if(I('phone') && I('username') && $time > 60 ) {
            $map['username']=I('username');
            $data=D('User')->where($map)->find();
            if(!empty($data) && $data['mobile'] === I('phone')){
                $pattern='1234567890';
                $key="";
                for($i=0;$i<4;$i++)
                {
                    $key.= $pattern{mt_rand(0,9)};    //生成php随机数
                }
                $phone=I('phone');
                $sign = md5($phone . $data['id'] . time());
                session('pwdsign', $sign);
                session('smskey',$key);
                session('smsphone',$phone);
                session('smstime',time());
                session('password_username',$data['username']);
                send_mobile_message($phone,$key);
                $ajax['status']=0;
                $ajax['msg']='手机号码正确';
            }else{
                $ajax['status']=1;
                $ajax['msg']='手机号码错误';
            }
        }else{
            $ajax['status']=1;
            $ajax['msg']='短信发送失败';
        }
        $this->ajax($ajax);
    }

    public function smscode(){
        if(I('username')  && I('code') && session('smskey') && I('code') === session('smskey')){
            session('smskey',null);
            session('smsphone',null);
            session('smstime',null);
            $ajax['status']=0;
            $ajax['sign']=session('pwdsign');
        }else{
            $ajax['status']=1;
            $ajax['msg']='验证码错误';
        }
        $this->ajax($ajax);
    }

    public function setpw(){

        $password=I('password');
        $username=session('password_username');
        if(I('pwdsign') === session('pwdsign') && !empty($password) && !empty($username) ) {
            $new_pw = user_md5($password);
            $map['username'] = $username;
            $data['password'] = $new_pw;
            M('User')->where($map)->save($data);
            session('pwdsign',null);
            session('password_username',null);
            $ajax['status']=0;
        }else{
            $ajax['status']=1;
            $ajax['msg']='修改密码失败';
        }
        $this->ajax($ajax);
    }

    public function _empty($name){
        $tid=intval(addslashes($name));
        $this->index($tid);
    }
}