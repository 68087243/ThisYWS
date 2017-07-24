<?php
namespace Api\Controller;
use Think\Controller;
use Common\Util;
class MixController extends ApiController
{
	private $mix_info=Array();//外部传参
	private $mix_data=Array();//商户信息
	private $sign;
	private $login_key;
	private $pay_key;
	
	/*
	1: 游戏编号错误
	2: 服务器编号错误
	3: 商户ID错误
	4: UID格式错误
	5：SIGN错误
	6: 服务器未开放
	
	*/
	protected function _initialize(){
        parent::_initialize();
		$this->mix_info['uid']=intval(I('uid'));
		if(intval(I('uid'))  <0 || strlen(I('uid')) > 10 ){
			exit("4");
		}
		
		$this->mix_info['gid']=intval(I('gid'));
		$this->mix_info['sid']=intval(I('sid'));
		$this->mix_info['mid']=intval(I('mid'));
		$this->mix_info['time']=I('time');
		$_time=time()-$this->mix_info['time'];
		if($_time>300){
			exit("7");
		}
		$this->login_key=MixSignKey($this->mix_info['mid'],"LOGIN");
		$this->pay_key=MixSignKey($this->mix_info['mid'],"PAY");
		
		$this->mix_data=M('MixUser')->find($this->mix_info['mid']);
		if(empty($this->mix_data)){
			exit("3");
		}
				
        switch(ACTION_NAME){
			case "login":
				$this->mix_info['key']=$this->login_key;
				$sign=md5(\Common\Util\Sign::signBuild($this->mix_info));
				if(I('sign') != $sign){
					exit("5");
				}
			break;
			case "pay":
				$this->mix_info['order']=I('order');
				$this->mix_info['money']=intval(I('money'));
				$this->mix_info['pid']=I('pid');
				$this->mix_info['bank']=I('bank');
				$this->mix_info['card_id']=I('card_id');
				$this->mix_info['card_pass']=I('card_pass');
				if($this->mix_info['money']<=0){
					exit("8");
				}
				$this->mix_info['time']=intval(I('time'));
				$sign=md5($this->mix_info['order'].$this->mix_info['uid'].$this->mix_info['gid'].$this->mix_info['sid'].$this->mix_info['mid'].$this->mix_info['money'].$this->mix_info['pid'].$this->mix_info['time'].$this->pay_key);
				if(I('sign') != $sign){
					exit("5");
				}
			break;
			case "role":
				$this->mix_info['key']=$this->login_key;
				$sign=md5(\Common\Util\Sign::signBuild($this->mix_info));
				if(I('sign') != $sign){
					exit("5");
				}
			break;
		}
    }
	
	public function idnex(){
		
		$this->show("T3T2_API");
		
	}
	
	public function login(){
		
		//用户验证
		$username='t3t2_'.$this->mix_data['id'].'_'.$this->mix_info['uid'];//拼接用户名
		$user_obj=D('User');
		$map['username']=$username;
		$map['identification']=$this->mix_data['id'];
		$map['identification_uid']=$this->mix_info['uid'];
		$__user=$user_obj->where($map)->find();
		if(empty($__user)){
			unset($_POST);
			$_POST['reg_type'] = 0;
            $_POST['username'] = $username;
            $_POST['password'] = "T3T2_PASSWORD";
			$_POST['avatar'] = 1;
			$_POST['identification']=$this->mix_data['id'];
			$_POST['identification_uid']=$this->mix_info['uid'];
			if ($user_obj->create()) {
                $id = $user_obj->add();
                if (!$id) {
					exit("7");
                }else{
					$__user=$user_obj->where($map)->find();
				}
            }
		}
		
		
		
		//是否添加了这款游戏验证
		unset($map);
		$map['gid']=$this->mix_info['gid'];
		$map['mid']=$this->mix_info['mid'];
		$mix_user_game_obj=D('MixUserGame');
		$game_obj=D('Game');
		$mix_game_obj=D('MixGame');
		$__mix_user_game=$mix_user_game_obj->where($map)->find();
		$__game=$game_obj->find($this->mix_info['gid']);
		$__mix_game=$mix_game_obj->where(Array('gid'=>$this->mix_info['gid']))->find();
		if(empty($__mix_user_game) || empty($__game) || empty($__mix_game)){
			exit("1");
		}
		
		//服务器是否存在验证
		$gameserver_obj=D('Gameserver');
		$__gameserver=$gameserver_obj->find($this->mix_info['sid']);
		if(empty($__gameserver)){
			exit("2");
		}
		
		if($__gameserver['ktime'] > time() || $__game['status'] ==0 || $__gameserver['status'] == 0 || $__mix_game['status'] == 0){
            exit("6");
        }
		$game_obj->uplog($__game, $__gameserver, $__user);
		C('VIEW_PATH', './Game/Theme/');
		$__user['mix_data']=$this->mix_data;
		GetApi($__game['api'])->play($__game,$__gameserver,$__user);
	}
	
	
	
	public function recharge(){
		
		//用户验证
		$username='t3t2_'.$this->mix_data['id'].'_'.$this->mix_info['uid'];//拼接用户名
		$user_obj=D('User');
		$map['username']=$username;
		$map['identification']=$this->mix_data['id'];
		$map['identification_uid']=$this->mix_info['uid'];
		$__user=$user_obj->where($map)->find();
		if(empty($__user)){
			exit("4");
		}
		
		//是否添加了这款游戏验证
		unset($map);
		$map['gid']=$this->mix_info['gid'];
		$map['mid']=$this->mix_info['mid'];
		$mix_user_game_obj=D('MixUserGame');
		$game_obj=D('Game');
		$mix_game_obj=D('MixGame');
		$__mix_user_game=$mix_user_game_obj->where($map)->find();
		$__game=$game_obj->find($this->mix_info['gid']);
		$__mix_game=$mix_game_obj->where(Array('gid'=>$this->mix_info['gid']))->find();
		if(empty($__mix_user_game) || empty($__game) || empty($__mix_game)){
			exit("1");
		}
		
		//服务器是否存在验证
		$gameserver_obj=D('Gameserver');
		$__gameserver=$gameserver_obj->find($this->mix_info['sid']);
		if(empty($__gameserver)){
			exit("2");
		}
		
		if($__gameserver['ktime'] > time() || $__game['status'] ==0 || $__gameserver['status'] == 0 || $__mix_game['status'] == 0){
            exit("6");
        }
		
		
		//创建订单
		$save['platform']=0;//充值到游戏
        $save['order']=build_order_no();//系统订单号
		$save['identification']=$this->mix_data['id'];
		$save['identification_uid']=$this->mix_info['uid'];
		$save['identification_money']=$this->mix_info['money']*($__mix_game['proportion']/10);//在这里根据游戏分成计算分成金额
		$save['identification_order']=$this->mix_info['order'];//外部订单号
        $save['uid']=$__user['id'];//提交订单的UID
		$save['paytoname']=$__user['username'];
		$save['paytype']=$this->mix_info['pid'];
		$_pay=D('Paytype')->where(Array('tag'=>$save['paytype']))->find();//查询支付渠道是否存在
        if(empty($_pay)){
            exit("10");
        }
		
		//判断是否银行
        if($_pay['bank']){
            $save['paybank']=$this->mix_info['bank'];
			if(empty($save['paybank'])){
				exit("9");
			}
        }
		
		//判断是否卡类
		if($_pay['iscard']){
            $save['paycardid']=$this->mix_info['card_id'];
			$save['paycardpass']=$this->mix_info['card_pass'];
			if(empty($save['paycardid']) || empty($save['paycardpass'])){
				exit("12");
			}
        }
		
		//充值金额判断
        $save['payamount']=$this->mix_info['money'];//充值金额
        if($_pay['money']){
            $ismoney=false;
            $money=explode("\r\n",$_pay['money']);
            foreach($money as $val){
                if($val == $save['payamount']){
                    $ismoney=true;
                }
            }
            if(!$ismoney){
                exit("13");
            }
        }
		
		if(empty($_pay['fee'])){
            $_pay['fee']=1;
        }
		
		$save['gameid']=$this->mix_info['gid'];
        $save['serverid']=$this->mix_info['sid'];
		$obj=GetApi($__game['api']);
		if(method_exists($obj,'getPayType')){
           if(!$obj->getPayType($save['paytype'])){
			   exit("14");
           }
        }
		if($save['paytype'] == '_syspay'){exit("15");}
		
		//兑换后的虚拟币数量计算
        $save['virtualamount']=$save['payamount'] * ($__game['rate']*$_pay['fee']);
		$save['fee']=$save['payamount'] - ($save['payamount'] * $_pay['fee']);
		
		//最后角色信息在确认一遍
		unset($map);
		$map['uid']=$this->mix_info['uid'];
        $map['gid']=$this->mix_info['gid'];
        $map['sid']=$this->mix_info['sid'];
		$gameplay=D('Gameplay');
        $data=$gameplay->where($map)->find();
        if(!empty($data)){
			if(empty($data['rolename'])){
				if(method_exists($obj,'checkRole')){
					$role=$obj->checkRole($__game,$__gameserver,$__user);
					if(!$role){
						exit("4");
					}else{
						$gameplay->where($map)->save(Array('rolename'=>$role));
						$__role=$role;
					}
				}
			}else{
				$__role=$data['rolename'];
			}
        }else{
			exit("4");
        }
        $save['role']=$__role;//角色信息
		$save['ip']=get_client_ip();
        $save['ctime']=time();
        $save['paystatus']=1;
		D('Paylog')->add($save);//将订单存入数据库
		if(method_exists($obj,'pay')){
			$save['subject']=$__game['name'].'充值'.$save['payamount'].'元'.$__game['unit'];
            $obj->pay($save,$__game,$__gameserver,$__user);
        }else{
			die('obj error');
		}
		
		
	}
	
	public function role(){
		//用户验证
		$username='t3t2_'.$this->mix_data['id'].'_'.$this->mix_info['uid'];//拼接用户名
		$user_obj=D('User');
		$map['username']=$username;
		$map['identification']=$this->mix_data['id'];
		$map['identification_uid']=$this->mix_info['uid'];
		$__user=$user_obj->where($map)->find();
		if(empty($__user)){
			exit("4");
		}
		$game_obj=D('Game');
		$gameserver_obj=D('Gameserver');
		$__game=$game_obj->find($this->mix_info['gid']);
		$__gameserver=$gameserver_obj->find($this->mix_info['sid']);
		unset($map);
		$map['uid']=$this->mix_info['uid'];
        $map['gid']=$this->mix_info['gid'];
        $map['sid']=$this->mix_info['sid'];
		$gameplay=D('Gameplay');
        $data=$gameplay->where($map)->find();
        if(!empty($data)){
			if(empty($data['rolename'])){
				$obj=GetApi($__game['api']);
				if(method_exists($obj,'checkRole')){
					$role=$obj->checkRole($__game,$__gameserver,$__user);
					if(!$role){
						exit("4");
					}else{
						$gameplay->where($map)->save(Array('rolename'=>$role));
						$__role=$role;
					}
				}
			}else{
				$__role=$data['rolename'];
			}
        }else{
			exit("4");
        }
		$ajax['0']['rolename']=$__role;
		$this->ajax($ajax);
	}
}