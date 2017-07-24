<?php
namespace Api\Controller;
use Think\Controller;
class UserController extends ApiController
{


    public function getuser()
    {
        $userinfo = session('user_auth');
        if ($userinfo['id']) {
            $data = Array('isGuest' => 0, 'username' => $userinfo['username'], 'id' => is_login(), 'nick' => '', 'external_bind' => 0);
        } else {
            $data = Array('isGuest' => 1, 'username' => '', 'id' => 0, 'nick' => '');
        }
        $this->ajax($data);
    }

    public function userplay()
    {
		$num=I('limit') ?:2;
		$gid=I('gid') ?:false;
        $data = D('Gameplay')->getGameplay($num,$gid);
        $array = Array();
        foreach ($data as $val) {
            $array[] = Array(
                'name' => $val['game_name'],
                's_name' => $val['server_name'],
                'icon' => get_cover($val['icon']),
                'url' => U('Gateway/Game/Play', array('gid' => $val['gid'], 'sid' => $val['sid']))
            );
        }
        $this->ajax($array);
    }

    public function userapi()
    {
        $userinfo = session('user_auth');
        if ($userinfo['id']) {
            $userinfo = D('User')->find(is_login());
            $data = Array(
                'level' => $userinfo['vip'],//控制VIP等级图标的
                'hy' => 1,//不知
                'packs' => D('Card')->getUidcount($userinfo['id']),//礼包数
                'value' => $userinfo['upgrade'],//成长值
                'score' => $userinfo['score'],//积分
                'xlevel' => $userinfo['level'],//不知
                'games' => D('Gameplay')->getCountGameplay($userinfo['id']),//不知
                'avatar' => $userinfo['avatar'],//头像路径
                'id' => $userinfo['id'],
                'username' => $userinfo['username']
            );
        } else {
            $data = Array('isGuest' => 1, 'usernmae' => '',
                'level' => 0,
                'hy' => 0,
                'packs' => 0,
                'value' => 0,
                'score' => 0,
                'xlevel' => 0,
                'games' => 0,
                'avatar' => 0,
                'id' => 0, 'nick' => '');
        }
        $this->ajax($data);
    }

    //签到
    public function usersign()
    {
        $data = array();
        $save = Array();
		$user = D('User');
		$userinfo = session('user_auth');
		$userinfo=$user->find($userinfo['id']);
        if ($userinfo['id']) {
            $save['id'] = $userinfo['id'];
            $date = date("Y-m-d");
            $sign_config = M('UserSignConfig')->find(1);
            if (!empty($sign_config['switch'])) {
                $sign = D('UserSign');
                $map['qtime'] = $date;
                $map['uid'] = $userinfo['id'];
                $sign_obj = $sign->where($map)->find();
                if (empty($sign_obj)) {
                    //今天没有签到
                    $data['code'] = 0;
                    $data['data'] = 3;
                    if (!empty($sign_config['reward_score'])) {
						$score=$sign_config['reward_score'];
                        $save['score'] = $save['total_score'] = $score+$userinfo['score'];
                    }
                    //VIP额外奖励判断
                    if (!empty($userinfo['vip'])) {
                        if (!empty($sign_config['extra_vip_score'])) {
                            if (empty($save['score'])) {
                                $save['score'] = $userinfo['score'];
                                $save['total_score'] = $userinfo['total_score'];
                            }
                            $vip_score = intval($sign_config['extra_vip_score'] * $userinfo['vip']);
                            $save['score'] =  $save['total_score'] = $save['score'] + $vip_score;
                        }
                    }
					$Yesterday=date("Y-m-d",strtotime("-1 day"));//昨天
					$sign_obj = $sign->where(Array('uid'=>$userinfo['id'],'qtime'=>$Yesterday))->order('id desc')->find();
					$map['continuous']=0;
					$map['continuous_num']=1;
					if(!empty($sign_obj['continuous_num']) && !empty($sign_config['continuous'])){
						$map['continuous_num']=$sign_obj['continuous_num']+1;
						//连续签到判断
						$continuousArr=array_filter(explode("\n",$sign_config['continuous']));
						if(is_array($continuousArr)){
							foreach($continuousArr as $val){
								$continuousConfig=explode(':',$val);
								if($continuousConfig[0]==$map['continuous_num']){
									$map['continuous']=$continuousConfig[1];
									$save['score'] =  $save['total_score'] = $save['score'] + $map['continuous'];
									break;
								}
								
							}
						}
					}
					
					D('ScoreLog')->addLog($userinfo['id'],$score+intval($vip_score),"2","+","签到");
					$map['score']=$score;
					$map['vip_score']=intval($vip_score);
					
                    $_level = getlevel($save['total_score']);
                    $save['level'] = $_level['level'];
                    $data['scoreInfo'] = Array();
                    $data['scoreInfo']['score'] = $save['total_score'];
                    $data['scoreInfo']['level'] = $_level['level'];
                    $data['scoreInfo']['max'] = $_level['e'];
                    $data['scoreInfo']['min'] = $_level['s'];
                    $data['scoreInfo']['levelName'] = $_level['title'];
                    if (I('platform')) {
                        $map['platform'] = I('platform');
                    } else {
                        $map['platform'] = 0;
                    }
                    $map['ctime'] = time();
                    $sign->add($map);
                    $user->save($save);
                } else {
                    $_level = getlevel($userinfo['total_score']);
                    $data['code'] = -1;
                    $data['msg'] = '今天已经签到';
                    $data['scoreInfo'] = Array();
                    $data['scoreInfo']['score'] = $userinfo['total_score'];
                    $data['scoreInfo']['level'] = $_level['level'];
                    $data['scoreInfo']['max'] = $_level['e'];
                    $data['scoreInfo']['min'] = $_level['s'];
                    $data['scoreInfo']['levelName'] = $_level['title'];
                }
                $this->ajax($data);
            }
        }
    }
    public function logout()
    {
		$userinfo = session('user_auth');
        cookie(null);
        session(null);
        cookie('remname', $userinfo['username']);
        if (I('get.redirect')) {
            if (domain() == domain(I('get.redirect'))) {
                header("Location: " . I('get.redirect'));
                exit;
            }
            $this->redirect('User/public/login');
        }else if(I('get.refrer')){
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            $this->redirect('Api/User/loginbox');
        }
    }

    public function loginframe()
    {
        $this->assign('meta_title', "用户登录注册");
        $this->display();
    }


    public function loginbox(){
        $userinfo = D('User')->find(is_login());
        $this->assign('userinfo', $userinfo);
        $this->display();
    }
	
	public function gamebox(){
		
		if(I('gid')){
			session('redirect',D('Game')->getGameUrl(intval(I('gid'))));
		}
		$userinfo = D('User')->find(is_login());
        $this->assign('userinfo', $userinfo);
        $this->display();
	}

    public function ajaxLogin()
    {
        if (I('username') && I('password')) {
            $username = I('username');
            $password = I('password');
            $user_object = D('User');
            $uid = $user_object->login($username, $password);
            if (0 < $uid) {
                $array = Array('msg' => 'success', 'script' => '', 'uid' => $uid);
            } else {
                $array = Array('msg' => '密码不正确');
            }
            $this->ajax($array);
        }else if(I('LoginForm')){
			$ajax['msg']='failed';
			$LoginForm=I('LoginForm');
			$username= $LoginForm['username'];
			$password= $LoginForm['password'];
			if(strlen($username)<4){
				$ajax['errors']['username'][]='用户名太短，必须大于4位';
			}else{
				if(strlen($password)<6){
				$ajax['errors']['password'][]='密码不能小于6位';
				}else{
					$user_object = D('User');
					$uid = $user_object->login($username, $password);
					if (0 < $uid) {
						$ajax = Array('msg' => 'success', 'script' => '', 'uid' => $uid);
					} else {
						$ajax['errors']['password'][] ='密码不正确';
					}
				}
			}
			$this->ajax($ajax);
		}
		
    }


    public function ajaxRegister()
    {
            $username = I('username');
            $password = I('password');
        if ($username && $password) {
            $_POST['reg_type'] = 0;
            $_POST['username'] = $username;
            $_POST['password'] = $password;
            $ajax = false;
            if (!I('acceptterms')) {
                $ajax = Array('msg' => '请阅读用户协议');
            }

            $user_object = D('User');
            $data = $user_object->create();
            if (!$ajax) {
                if ($data) {
                    $id = $user_object->add();
                    if ($id) {
						$mid=intval(I('mid'));
						$gid=intval(I('gid'));
						$sid=intval(I('sid'));
						$aid=intval(I('aid'));
                        $uid = $user_object->login($username, $password);
						D('Spread')->AddSpreadUser($mid,$uid,$gid,$sid,$aid);
                        $ajax = Array('msg' => 'success', 'script' => '', 'uid' => $uid);
                    } else {
                        $ajax = Array('msg' => '注册失败');
                    }
                } else {
                    $ajax = Array('msg' => $user_object->getError());
                }
            }
            $this->ajax($ajax);
        }

    }

    public function formRegister()
    {
        $data = Array();
        if (IS_POST) {
            $username = I('username');
            $password = I('password');
            $repassword = I('repassword');
            $realName = I('realName');
            $cardId = I('cardId');
            $agree = I('obj');
            if (empty($username)) {
                $data['RegisterForm_username'][] = '用户名不能为空!';
            }
            if (strlen($username) > 16 || strlen($username) < 4) {
                $data['RegisterForm_username'][] = '用户名长度4-16!';
            }
            if (empty($password)) {
                $data['RegisterForm_password'][] = '密码不能为空!';
            }
            if (strlen($password) > 20 || strlen($password) < 6) {
                $data['RegisterForm_password'][] = '密码长度6-20!';
            }

            if (empty($repassword)) {
                $data['RegisterForm_repassword'][] = '重复密码不能为空!';
            }
            if (empty($realName)) {
                $data['RegisterForm_realName'][] = '姓名不能为空!';
            }
            if (empty($cardId)) {
                $data['RegisterForm_cardId'][] = '身份证不能为空!';
            }
            if (empty($agree)) {
                $data['RegisterForm_obj'][] = '请阅读用户协议!';
            }
            if (!empty($cardId) && !isCreditNo($cardId)) {
                $data['RegisterForm_cardId'][] = '请填写正确的身份证号码!';
            }
            if (!preg_match_all("/^([\x81-\xfe][\x40-\xfe][\x40-\xfe])+$/", $realName, $match)) {
                $data['RegisterForm_realName'][] = '请填写真实姓名!';
            }
            if ($password != $repassword) {
                $data['RegisterForm_repassword'][] = '重复密码和密码不一致!';
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
                        $this->redirect('User/index/index');
                    }
                }
            } else {
                $data['RegisterForm_obj'][] = $user_object->getError();
            }
            $this->ajax($data);
        }
    }

    public function checkdata()
    {
            $str = I('str');
            $type = I('type');
            switch ($type) {
                case "username":
                    $map['username'] = $str;
                    $data = D('User')->where($map)->find();
                    $msg = '用户名';
                    break;
                case "email":
                    $map['email'] = $str;
                    $data = D('User')->where($map)->find();
                    $msg = '邮箱';
                    break;
            }

            if (empty($data)) {
                $data = Array('msg' => 'success');
            } else {
                $data = Array('msg' => $msg . '已被使用');
            }
            $this->ajax($data);
    }













}