<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
use Common\Util\Pay\Driver;
class jzApi extends Controller{
	
	private $info=Array();//API信息
	
	private $db=array(
						'db_type'  => 'mysql',
						'db_user'  => 't3t2',
						'db_pwd'   => '654321dsa',
						'db_host'  => '115.238.249.54',
						'db_port'  => '3306',
						'db_name'  => 'jzweb'
					);
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
	}
	
	public function _extend_admin_api(){
		$info['_paytoadmin']='内部充值';
		$info['_jieka']='解卡';
		return $info;
	}
	
	
	public function _jieka($obj){
		$server=M('Gameserver')->find($obj['sid']);
		$user=M('User')->where(Array('username'=>$obj['username']))->find();
		$this->db['db_name']='jianzong'.$server['sid'];
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 8);
		$AccountName=$hashids->encode($user['id']);
		$rolesfirst=M('rolesfirst',' ',$this->db)->where(Array('AccountName'=>$AccountName))->find();
		$pet=M('pet',' ',$this->db);
		$pet_data=$pet->where(Array('MasterUniqueId'=>$rolesfirst['dwuniqueid']))->find();


		if(empty($rolesfirst) || empty($pet_data)){
			$this->ajax(Array('info'=>'账号不存在','status'=>0,'url'=>''));
		}
		if($pet_data['online'] > 0){
			$this->ajax(Array('info'=>'您要解卡的角色当前在线，请退出游戏后再操作！','status'=>0,'url'=>''));
		}else{
			$data['SkillList'] = '';
			$temp=$pet->where(Array('MasterUniqueId'=>$rolesfirst['dwuniqueid']))->fetchSql(true)->save($data);
			if($temp){
				$this->ajax(Array('info'=>'解卡成功','status'=>0,'url'=>''));
			}else{
				$this->ajax(Array('info'=>'解卡失败','status'=>0,'url'=>''));
			}
			
		}
	}
	

	
	public function _paytoadmin($obj){
		$paylog['serverid']=$obj['sid'];
		$paylog['paytoname']=$obj['username'];
		$paylog['order']="2016213".time();
		$paylog['virtualamount']=$obj['param'];
		$pay['payamount']="1";
		if($this->_pay($paylog)){
			$this->ajax(Array('info'=>'充值成功','status'=>0,'url'=>''));
		}
	}
	
	
	public function extend($type,$game){
		switch($type){
			case "notice":
				C('VIEW_PATH', './Game/Theme/');//临时改变模板目录
				$this->assign('game',$game);
				$this->display('jz/notice');
			break;
			case "login":
				if (I('username') && I('password')) {
					$Ephp= new \Common\Util\Ephp();
					$username = I('username');
					$password = I('password');
					$user_object = D('User');
					$uid = $user_object->login($username, $password);
					if (0 < $uid) {
						$sid=intval(I('sid'));
						$server=M('Gameserver')->find($sid);
						if(!empty($server) && $server['game']==$game['id']){
							D('Game')->uplog($game, $server, session('user_auth'),1);
						}
						$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 8);
						$AccountName=$hashids->encode($uid);
						$account = M('Account',' ',$this->db);
						$account_data = $account->where(Array('AccountName'=>$AccountName))->find();
						$password=$account_data['password'];
						if(empty($account_data)){
							$password=time();
							$add['AccountName']=$AccountName;
							$add['password']=$password;
							$add['Golds']=2000000;
							$add['tg']=0;
							$add['tgnum']=0;
							$add['last_login_time']=date('Y-m-d H:i:s');
							$add['last_login_ip']=get_client_ip();
							$account->add($add);
						}
						
						$str = $AccountName."|".$password;
					} else {
						$str = "user_error|password_error";
					}
					
					echo $Ephp->rc4a($str);
				}
			break;
			case "serverlist":
				$Ephp= new \Common\Util\Ephp();
				$Gameserver=D('Gameserver');
				$map['game']=$game['id'];
				$map['status']=array('eq',1);
				$map['ktime']=array('lt',time());
				$data=$Gameserver->where($map)->order('id desc')->select();
				$str='&&&';
				foreach($data as $val){
					$str.=$val['name'].'|'.$val['gid'].'|8100|'.$val['gid'].'|'.($val['sid']+8100).'|'.$val['id'].'&&&';
				}
				echo $Ephp->rc4a(mb_convert_encoding($str, "GBK", "utf-8"));
			break;
			case "topay":
				$serverid	= I('serverid');
				$orderno	= I('orderno');
				$passprot=I('passport');
				$addgold	= I('addgold');
				$paytime	= I('paytime');
				$sign		= I('sign');
				$String = md5($orderno.$passprot.$serverid.$addgold.$paytime.$this->info['pay_key']);
				if( $sign != $String){
					exit("-1");
				}
				$account = M('Account',' ',$this->db);
				$user_data=$account->where(Array('AccountName'=>$passprot))->find();
				if(empty($user_data)){
					exit("-2");
				}
				$account->where(Array('AccountName'=>$passprot))->setInc('Golds',$addgold);
				echo "1";
			break;
			
			
		}
		
	}
	
	//启动游戏
	public function play($game,$server,$user){
		$this->assign('game',$game);
		$this->display('jz/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 8);
		$AccountName=$hashids->encode($user['id']);
		$this->db['db_name']='jianzong'.$server['sid'];
		$rolesfirst=M('rolesfirst',' ',$this->db)->where(Array('AccountName'=>$AccountName))->find();
		if(empty($rolesfirst)){
			return false;
		}else{
			return trim($rolesfirst['rolename']);
		}
	}
	
	//游戏支付
	public function getPayType($paytype){
		switch($paytype){
			case "_syspay":return true;break;
			default:$obj=new \Common\Util\Pay('Kdpay');return $obj->payer->getPayType($paytype);break;
		}
	}
	
	//发起支付
	public function pay($pay,$game,$server,$user){
		$pay['notify_url']=U('Pay/Request/jz_notify');
		$pay['return_url']=U('Pay/Request/jz');
		new \Common\Util\Pay('Kdpay',$pay);
	}
	
	//游戏充值
	public function _pay($pay,$game=false,$server=false,$user=false){
		if(!$server){
			$server=M('Gameserver')->find($pay['serverid']);
		}
		if(!$user){
			$user=D('User')->where(Array('username'=>$pay['paytoname']))->find();;
		}
		$start['orderno']=$pay['order'];
		$start['addgold']=$pay['virtualamount'];
		$start['paytime']=time();
		$start['serverid']=$server['sid'];
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 8);
		$start['passport']=$hashids->encode($user['id']);
		$start['sign'] = md5($start['orderno'].$start['passport'].$start['serverid'].$start['addgold'].$start['paytime'].$this->info['pay_key']); 
		$data=\Org\Net\HttpCurl::get($this->info['pay_url'],$start);
		if($data[0]=="1"){
			return true;
		}else{
			return false;
		}
	}
	
	public function getPayOrder(){
		return I('P_OrderId');
	}
	
	public function getPayTip(){
		return Array(1=>'errCode=0',2=>'errCode=0');
	}

	//支付回调检查
	public function checkPay($paylog,$sign=false){
		$obj=new \Common\Util\Pay('Kdpay');
		if($obj->payer->signCheck()){
		    if($this->_pay($paylog)){
					$remark='游戏已到账';
			}else{
					$remark='游戏未到账';
			}
			return $remark;
		}else{
			return false;
		}
	}
	
}






?>