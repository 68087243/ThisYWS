<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
use Common\Util\Pay\Driver;
class mysjApi extends Controller{
	
	private $info=Array();//API信息
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
	}
	
	public function _extend_admin_api(){
		$info['_paytoadmin']='内部充值';
		$info['_payshop']='发送邮件';
		$info['_clearbag']='清空 0装备/1背包/2仓库';
		return $info;
	}
	
	public function _extend_home_api(){
		$info['sclb']='首冲礼包';
		return $info;
	}
	
	public function _paytoadmin($obj){
		$paylog['serverid']=$obj['sid'];
		$paylog['paytoname']=$obj['username'];
		$paylog['order']="2016213".time();
		$paylog['virtualamount']=$obj['param'];
		$pay['payamount']="1";
		if($this->_pay($paylog)){
			$this->ajax(Array('info'=>'充值成功','status'=>0,'url'=>''));
		}else{
			$this->ajax(Array('info'=>'充值失败','status'=>0,'url'=>''));
		}
	}
	
	public function _clearbag($obj){
		$server=M('Gameserver')->find($obj['sid']);
		$user=M('User')->where(Array('username'=>$obj['username']))->find();
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 5);
		$passprot=$hashids->encode($user['id']).".S".$server['sid'];
		$param=$this->textExplode($server['param']);
		$dbname='S'.$param['db'];
		$db=array(
			'db_type'  => 'mysql',
			'db_user'  => 'root',
			'db_pwd'   => '654321dsa',
			'db_host'  => '115.159.150.180',
			'db_port'  => '3306',
			'db_name'  => $dbname
		);
		$_user = M('User','sys_',$db);
		$_user_data=$_user->where(Array('passport'=>$passprot))->find();
		$character = M('Character','mem_',$db);
		$character_data=$character->where(Array('uid'=>$_user_data['uid']))->find();
		$Bag = M('ChrBag','mem_',$db);
		$data=$Bag->where(Array('bag'=>$obj['param'],'cid'=>$character_data['cid']))->delete(); 
		if($data){
			$this->ajax(Array('info'=>'清空成功','status'=>0,'url'=>''));
		}else{
			$this->ajax(Array('info'=>'清空失败','status'=>0,'url'=>''));
		}
	}
	
	
	
	public function _payshop($obj){
		$server=M('Gameserver')->find($obj['sid']);
		$user=M('User')->where(Array('username'=>$obj['username']))->find();
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 5);
		$passprot=$hashids->encode($user['id']).".S".$server['sid'];
		$param=$this->textExplode($server['param']);
		$dbname='S'.$param['db'];
		$db=array(
			'db_type'  => 'mysql',
			'db_user'  => 'root',
			'db_pwd'   => '654321dsa',
			'db_host'  => '115.159.150.180',
			'db_port'  => '3306',
			'db_name'  => $dbname
		);
		$_user = M('User','sys_',$db);
		$_user_data=$_user->where(Array('passport'=>$passprot))->find();
		$character = M('Character','mem_',$db);
		$character_data=$character->where(Array('uid'=>$_user_data['uid']))->find();
		$new_mail=M('NewMail','mem_',$db);
		$arr=explode("\r\n",$obj['param']);
		foreach($arr as $val){
			$data['SysMailId']=0;
			$data['SenderId']=0;
			$data['SenderName']='';
			$data['ReceiveId']=$character_data['cid'];
			$data['ReceiveName']='';
			$data['SendTime']=time();
			$data['HasRead']=0;
			$data['Extract']=1;
			$data['MailTitle']='物品发送完毕';
			$data['MailContent']='物品发送完毕';
			$data['Item1']=$val;
			$data['Item2']='';
			$data['Item3']='';
			$data['Item4']='';
			$data['Item5']='';
			$data['Item6']='';
			$data['Param']='';
			$new_mail->add($data);
		}
		$this->ajax(Array('info'=>'发送成功','status'=>0,'url'=>''));
	}
	
	public function extend($type,$game){
		switch($type){
			case "sclb":
			$user=session('user_auth');
			if(empty($user)){
				$this->error("请登录");
			}
			if(I('gid') != $game['id']){
				exit;
			}
			$sid=intval(I('sid'));
			$server=M('Gameserver')->where(Array('game'=>$game['id'],'id'=>$sid))->find();
			if(empty($server)){
				$this->error("失败!");
			}
			if(!$this->checkRole($game,$server,$user)){
				$this->error("请创建角色!");
			}
			$map['extend']=$type;$map['uid']=$user['id'];$map['gid']=$game['id'];$map['sid']=$sid;
			$extendLog=M('GameextendLog')->where($map)->find();
			if(!empty($extendLog)){
				$this->error("此区您已领取过，不可重复领取!");
			}
			$paylog['serverid']=$sid;
			$paylog['paytoname']=$user['username'];
			$paylog['order']="2016213".time();
			$paylog['virtualamount']=50000;
			$pay['payamount']="1";
			$map['ctime']=time();
			if($this->_pay($paylog)){
				M('GameextendLog')->add($map);
				$this->success('50000魔石领取成功，请刷新游戏查看!');
			}else{
				$this->error("失败!");
			}
			
			break;
			case "to":
				$serverid	= I('serverid');
				$orderno	= I('orderno');
				$passprot=I('passport');
				$addgold	= I('addgold');
				$paytime	= I('paytime');
				$sign		= I('sign');
				$do		= I('do');
				$String = md5($orderno.$passprot.$serverid.$addgold.$paytime.$this->info['pay_key']);
				if( $sign != $String){
					exit("-1");
				}
				$dbname='S'.I('db');
				$db=array(
					'db_type'  => 'mysql',
					'db_user'  => 'root',
					'db_pwd'   => '654321dsa',
					'db_host'  => '115.159.150.180',
					'db_port'  => '3306',
					'db_name'  => $dbname
				);
				$user = M('User','sys_',$db);
				$user_data=$user->where(Array('passport'=>$passprot,'sid'=>$serverid))->find();
				if(empty($user_data)){
					exit("-2");
				}
				$character = M('Character','mem_',$db);
				$character_data=$character->where(Array('uid'=>$user_data['uid'],'sid'=>$serverid))->find();
				if(empty($character_data)){
						exit("-3");
				}
				if($do=='name'){
					exit($character_data['name']);
				}
				$pay = M('Pay','log_',$db);
				$pay_data=$pay->where(Array('oid'=>$orderno))->find();
				if(!empty($pay_data)){
					exit("-4");
				}
				$user->where(Array('passport'=>$passprot,'sid'=>$serverid))->setInc('gold_pay',$addgold);
				$pay_data_save=Array('sid'=>$serverid,'uid'=>$user_data['uid'],'oid'=>$orderno,'passport'=>$passport,'amount'=>$addgold,'time'=>time(),'level'=>$character_data['level']);
				$pay->add($pay_data_save);
				set_time_limit(0);
				$commonProtocol = getprotobyname("tcp");
				$socket = socket_create(AF_INET, SOCK_STREAM, $commonProtocol) or die("Could not createsocket/n");
				$connection=socket_connect($socket,"115.238.247.207",$serverid*100+5900+1);
				if (!$connection)
				{
					exit("1");
				}
				$txt="";
				$Type=1;
				$txt.=pack("c",$Type);
				$proc1=25001;
				$txt.=pack("v",$proc1);
				$datalen=8;
				$txt.=pack("l",$datalen);
				$data1=$uid;
				$txt.=pack("l",$data1);
				$data2=$serverid;
				$txt.=pack("l",$data2);
				$Socket_logintext="<policy-file-request/> ".$txt;
				$sended = socket_send($socket,$Socket_logintext,strlen($Socket_logintext),0x4);
				echo "1";
			break;
			
			
		}
		
	}
	
	
	//启动游戏
	public function play($game,$server,$user){
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 5);
		$start['username']=$hashids->encode($user['id']).".S".$server['sid'];
		$start['serverid']=$server['sid'];
		$start['time']=time();
		$start['isadult']=0;
		$start['host']=$server['gid'];
		$start['pay']=U('Pay/index/'.$game['id']);
		$start['giftUrl']=U('Gift/'.$game['mark'].'/index');
		$param=$this->textExplode($server['param']);
		$this->assign('url',$this->info['login_url'].'?username='.$start['username'].'&serverid='.$start['serverid'].'&host='.$start['host'].'&gateServerPort='.($param['port']).'&pay='.$start['pay'].'&giftUrl='.$start['giftUrl']);
		$this->display('default/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 5);
		$start['passport']=$hashids->encode($user['id']).".S".$server['sid'];
		$start['serverid']=$server['sid'];
		$start['orderno']=0;
		$start['addgold']=0;
		
		$start['paytime']=time();
		$start['sign'] = md5($start['orderno'].$start['passport'].$start['serverid'].$start['addgold'].$start['paytime'].$this->info['pay_key']); 
		$start['do']='name';
		$param=$this->textExplode($server['param']);
		$start['db']=$param['db'];
		$data=\Org\Net\HttpCurl::get($this->info['pay_url'],$start);
		if($data[0]=="" || empty($data[0]) || $data[0]=="-2" || $data[0]=="-3"){
			return false;
		}else{
			return trim($data[0]);
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
		$pay['notify_url']=U('Pay/Request/mysj_notify');
		$pay['return_url']=U('Pay/Request/mysj');
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
		$param=$this->textExplode($server['param']);
		$start['orderno']=$pay['order'];
		$start['addgold']=$pay['virtualamount'];
		$start['paytime']=time();
		$start['db']=$param['db'];
		$start['serverid']=$server['sid'];
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 5);
		$start['passport']=$hashids->encode($user['id']).".S".$server['sid'];
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