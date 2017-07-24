<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
use Common\Util\Pay\Driver;
class i91wanApi extends Controller{
	
	private $info=Array();//API信息
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
	}
	
	
	//启动游戏
	public function play($game,$server,$user){
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 5);
		$start['uid']=$this->info['unid'];
		$start['player']=$hashids->encode($user['id']);
		$start['gid']=$server['gid'];
		$start['time']=time();
		$start['key']=$this->info['login_key'];
		$start['sign']=md5(\Common\Util\Sign::signBuild($start,'#'));
		$start['sid']=$server['sid'];
		unset($start['key']);
		$this->assign('url',$this->info['login_url'].'?'.http_build_query($start));
		$this->display('default/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		return false;
	}
	
	//游戏支付
	public function getPayType($paytype){
		switch($paytype){
			case "zfb":$type='1';break;//支付宝
			case "weixin":$type='1';break;//支付宝
			case "wyzf":$type='1';break;//支付宝
			default:return false;
		}
		return $type;
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
		$start['orderno']=$pay['order'];
		$start['addgold']=$pay['virtualamount'];
		$start['paytime']=time();
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
	

	//支付回调检查
	public function checkPay($sign=false){
		$order=I('P_OrderId');
		$tip=Array(1=>'errCode=0',2=>'errCode=0');
		$map['order']=$order;
		$map['paystatus']=1;
		$data['utime']=time();
		$status=3;
		$obj=new \Common\Util\Pay('Kdpay');
		if($obj->payer->signCheck()){
			$paylog=D('Paylog')->where($map)->find();
			if(empty($paylog)){
				$status=-1;
			}else{
				if($this->_pay($paylog)){
					$data['remark']='游戏已到账';
				}
			    $status = $paylog['paystatus'];
			}
			$data['paystatus']=2;
		}
		return Array('map'=>$map,'data'=>$data,'paylog'=>$paylog,'status'=>$status,'sign'=>$sign,'tip'=>$tip);
	}
	
	
	
	
}






?>