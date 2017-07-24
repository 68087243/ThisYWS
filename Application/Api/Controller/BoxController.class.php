<?php
namespace Api\Controller;
use Think\Controller;
class BoxController extends ApiController
{
	
	
	public function _empty($name){
		switch($name){
			case "_login":$this->islogin();break;
			case "_tj":$this->hztj();break;
			
			
			
			
			
		}
		
		
		
	}
	
	public function client_index(){
		print_r(cookie());
		$userinfo = session('user_auth');
		if(empty($userinfo)){
			echo "抱歉，没能获取到用户cookie";
		}else{
			print_r($userinfo);
			
		}
		
		
		
		
	}
	
	public function formreg(){
		if (IS_POST) {
			$BoxRegisterForm=I('BoxRegisterForm');
            $username = $BoxRegisterForm['username'];
            $password = $BoxRegisterForm['password'];
            $repassword = $BoxRegisterForm['repassword'];
            $realName =$BoxRegisterForm['realName'];
            $cardId = $BoxRegisterForm['cardId'];
            $agree = $BoxRegisterForm['agree'];
            if (empty($username)) {
                $data['BoxRegisterForm_username'][] = '用户名不能为空!';
            }
            if (strlen($username) > 16 || strlen($username) < 4) {
                $data['BoxRegisterForm_username'][] = '用户名长度4-16!';
            }
            if (empty($password)) {
                $data['BoxRegisterForm_password'][] = '密码不能为空!';
            }
            if (strlen($password) > 20 || strlen($password) < 6) {
                $data['BoxRegisterForm_password'][] = '密码长度6-20!';
            }
            if (empty($repassword)) {
                $data['BoxRegisterForm_repassword'][] = '重复密码不能为空!';
            }
            if (empty($realName)) {
                $data['BoxRegisterForm_realName'][] = '姓名不能为空!';
            }
            if (empty($cardId)) {
                $data['BoxRegisterForm_cardId'][] = '身份证不能为空!';
            }
            if (empty($agree)) {
                $data['BoxRegisterForm_agree'][] = '请阅读用户协议!';
            }
            if (!empty($cardId) && !isCreditNo($cardId)) {
                $data['BoxRegisterForm_cardId'][] = '请填写正确的身份证号码!';
            }
            if (!preg_match_all("/^[\x{4e00}-\x{9fa5}]+$/u", $realName, $match)) {
                $data['BoxRegisterForm_realName'][] = '请填写真实姓名!';
            }
            if ($password != $repassword) {
                $data['BoxRegisterForm_repassword'][] = '重复密码和密码不一致!';
            }
			$__USER=D('User')->where(Array('username'=>$username))->find();
			if(!empty($__USER)){
				$data['BoxRegisterForm_username'][] = '用户名已被注册!';
			}
            if (!empty($data)) {
                $this->ajax($data);
            }
            if (I('ajax')) {
                $save = 0;
            } else {
                $save = 1;
            }
            unset($_POST);
            $_POST['reg_type'] = 0;
            $_POST['username'] = $username;
            $_POST['password'] = $password;
            $_POST['avatar'] = 1;
            $_POST['realname'] = $realName;
            $_POST['idcard_no'] = $cardId;
            $_arr = getAgeByID($cardId);
            $_POST['age'] = $_arr['age'];
            $_POST['birthday'] = $_arr['birthday'];
            $user_object = D('User');
            $data = $user_object->create();
            if ($data) {
                if ($save) {
                    $id = $user_object->add();
                    if ($id) {
						$user_object->login($username, $password);
$html= <<<EOF
<html><head><meta charset="utf-8"></head><body><script>window.external.CB_UserRegister('{$username}','{$password}');</script></body></html>
EOF;
						exit($html);
                    }
                }
            } else {
                $data['BoxRegisterForm_agree'][] = $user_object->getError();
            }
            $this->ajax($data);
        }else{
			$this->display();
		}
		
		
		
	}
	public function s_p(){
		$this->redirect('Service/Ticket/password');
	}
	
	public function bindstatus(){
		$userinfo = session('user_auth');
		if($userinfo){
			$safe_level=0;
			if($userinfo['email']){
				$safe_level+=1;
			}
			if($userinfo['mobile']){
				$safe_level+=1;
			}
			if($userinfo['idcard_no']){
				$safe_level+=1;
			}
			$arr['safe_level']=$safe_level;
			$arr['vip_level']=$userinfo['vip']?:0;
			$arr['vip_active']=$userinfo['vip']?1:0;
			$arr['bind_email']=$userinfo['email']?1:0;
			$arr['bind_mobile']=$userinfo['mobile']?1:0;
			$arr['bind_idcard']=$userinfo['idcard_no']?1:0;
			$arr['bind_sms_protected']=$userinfo['mobile']?1:0;
			$this->ajax($arr);
		}
	}
	
	public function xxx(){
		
		$user_sns_info['name']="t3t2_1455427754";
		$user_sns_info['name']=str_replace(" ","",trim($user_sns_info['name']));
			if(strlen($user_sns_info['name'])<4 || !preg_match("/^(?!.*?_$)[\w\一-\龥]+$/",$user_sns_info['name'])){
				$user_sns_info['name']='t3t2_'.time();
			}
			
			echo $user_sns_info['name'];
		
	//	echo addons_url('Changyan://Changyan/getuser');
		
		exit;
		//print_r($_SERVER);
		$user_sns_info['name']="东 方未明";
		//$user_sns_info['name']=preg_replace("/[^a-zA-Z0-9]+/","_", str_replace(" ","_",trim($user_sns_info['name'])))
		
		$user_sns_info['name']=str_replace(" ","",trim($user_sns_info['name']));
		if(strlen($user_sns_info['name'])<4){
			$user_sns_info['name']='T3T2_'.$user_sns_info['name'];
		}
		echo $user_sns_info['name'];
		exit;
		$stooges = array('Moe','Larry','Curly');
$new = serialize($stooges);
print_r($new);
		echo 11;
		$A='a:4:{i:0;s:9:"518734569";i:1;s:15:"dsdsdsasdadsads";i:2;i:259200;i:3;a:2:{s:6:"__salt";s:32:"105e3be9bce81659bee6fb98fb9ce639";s:4:"__ip";s:15:"123.150.205.250";}}';
		print_r(unserialize($A));
		
		
	}
	
	public function hztj(){
		$map['FIND_IN_SET(\'t\',flags)']=array('exp','');
		$map['status']=array('eq',1);
		$obj=D('Game');
		$data=$obj->where($map)->order('rand(),flags desc,id desc')->limit(7)->cache('hztj',60)->select();
		$array=Array();
		foreach($data as $val){
            $_data=Array();
            $_data['gid']=$val['id'];
			$_data['name']=$val['name'];
			
			$_server=D('Gameserver')->getNewServerBygid($val['id']);
			$_data['sid']=$_server['sid'];
			$_data['id']=$_server['id'];
			$_data['s_name']=$_server['name'];
			
            $_data['url']=U('Gateway/Game/bridge',array('gid'=>$val['id'],'sid'=>$_server['id']));
            $array[]=$_data;
        }
		$this->ajax($array);
	}
	
	public function login(){
		$userinfo = session('user_auth');
		if($userinfo['id']){
		$html=<<<EOF
<html><head><meta charset="utf-8"></head><body><script>window.external.CB_LoginGameInfo('{$userinfo['username']}','{$userinfo['id']}');</script></body></html>
EOF;
		}else{
			$html=<<<EOF
<html><head><meta charset="utf-8"></head><body>failed</body></html>
EOF;
		}
		echo $html;
	}
	
	public function login_url(){
		switch(I('type')){
			case "qq":
			session("boxlogin",1);
			redirect(addons_url('SyncLogin://Login/login', array('type'=>'qq')));
			break;
		}
	}

    public function islogin()
    {
        $userinfo = session('user_auth');
        if ($userinfo['id']) {
            $data = Array('msg' => 'success','uid' => $userinfo['id'], 'username' => $userinfo['username']);
        } else {
            $data = Array('msg' => 'failed');
        }
        $this->ajax($data);
    }













}