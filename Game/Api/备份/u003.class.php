<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class u003Api extends Controller{
	
	private $info=Array();//API信息
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
	}

	//启动游戏
	public function play($game,$server,$user){
		$start['platform']=$this->info['unid'];
		$start['username']=$user['username'];
		$start['game']=$game['api_id'];
		$start['server']=$server['sid'];
		$start['client']=0;
		$start['time']=time();
		$start['sign']=md5($start['platform'].$start['username'].$start['game'].$start['server'].$start['client'].$start['time'].$this->info['login_key']);
		$url=$this->info['login_url'].'?'.http_build_query($start);
		$this->assign('url',$url);
		$this->display('default/play');
	}
	
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$start['platform']=$this->info['unid'];
		$start['username']=$user['username'];
		$start['game']=$game['api_id'];
		$start['server']=$server['sid'];
		$start['time']=time();
		$start['sign']=md5($start['platform'].$start['username'].$start['game'].$start['server'].$start['time'].$this->info['login_key']);
		$data=\Org\Net\HttpCurl::get('http://api.u003.com/api/role',$start);
		if(strlen($data[0])==2){
			return false;
		}else{
			$json=json_decode($data[0]);
			return $json[0]->rolename;
		}
	}
	
	
	//充值渠道
	public function getPayType($paytype){
		switch($paytype){
			case "jwykt":$type='7';break;//骏网一卡通
			case "sdk":$type='9';break;//盛大卡
			case "wmk":$type='12';break;//完美卡
			case "wyk":$type='14';break;//网易卡
			case "wyzf":$type='17';break;//网银支付
			case "zfb":$type='1';break;//支付宝
			case "szx":$type='21';break;//神州行
			case "ltk":$type='24';break;//联通卡
			case "txykt":$type='11';break;//天下一卡通
			case "dxk":$type='25';break;//天下一卡通
			case "_syspay":$type=1;break;
			default:return false;
		}
		return $type;
	}
	
	
	//充值跳转
	public function pay($pay,$game,$server,$user){
		$start['platform']=$this->info['unid'];
		$start['username']=$user['username'];
		$start['game']=$game['api_id'];
		$start['server']=$server['sid'];
		$start['order']=$pay['order'];
		$start['money']=$pay['payamount'];
		$start['type']=$this->getPayType($pay['paytype']);
		$start['return']=U('Pay/Request/Jump');
		$start['notify']=U('Pay/Request/u003');
		$start['method']='request';
		$start['bank']='';
		if($pay['paybank']){
			$start['bank']=$pay['paybank'].'-NET-B2C';
		}
		$start['time']=time();
		$start['sign']=md5($start['platform'].$start['username'].$start['game'].$start['server'].$start['order'].$start['money'].$start['type'].$start['return'].$start['notify'].$start['method'].$start['time'].$this->info['pay_key']);
		$config[0]=$start;
		$config[1]=$this->info['pay_url'];
		$config[2]='post';
		new \Common\Util\Pay('Pay_',$config);
	}
	
	
	//异步充值回调
	//-1订单号不存在
	//1 OK
	//2 订单已处理
	//3 支付失败
	public function checkPay($sign=false){
		$order=I('order');
		$tip=Array(1=>'SUCCESS',2=>'error');
		$map['order']=$order;
		$map['paystatus']=1;
		$data['utime']=time();
		$status=3;
		if($_GET['status']==1){
			$paylog=D('Paylog')->where($map)->find();
			if(empty($paylog)){
				$status=-1;
			}else{
			    $status = $paylog['paystatus'];
			}
			$data['paystatus']=2;
			$data['remark']='gamestatus:'.I('gamestatus');
		}
		return Array('map'=>$map,'data'=>$data,'paylog'=>$paylog,'status'=>$status,'sign'=>$sign,'tip'=>$tip);
	}
	
	
	
	
	
}






?>