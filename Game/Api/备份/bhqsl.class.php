<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class bhqslApi extends Controller{
	
	private $info=Array();//API信息
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
	}
	
	//启动游戏
	public function play($game,$server,$user){
		$params = array();
		$params['action'] = "gameLogin";
		$params['mark'] = $this->info['unid'];
		$params['server']=$server['sid'];
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 7);
		$params['username']=$hashids->encode($user['id']).".s".$server['sid'];
		$params['isAdult'] = 1;
		$params['time'] = time();
		$params['source'] = "";
		ksort($params);
		$url = http_build_query($params);
		$token = strtolower(md5($url.$this->info['login_key']));//生成token
		$url=$url.'&token='.$token;
		$this->assign('url',$this->info['login_url'].'?'.$url);
		$this->display('default/play');
	}
	
	public function _extend_admin_api(){
		$info['_paytoadmin']='内部充值';
		return $info;
	}
	
	public function _paytoadmin($obj){
		$paylog['serverid']=$obj['sid'];
		$paylog['paytoname']=$obj['username'];
		$paylog['order']="2016213".time();
		$paylog['payamount']=$obj['param'];
		if($this->_pay($paylog)){
			$this->ajax(Array('info'=>'充值成功','status'=>0,'url'=>''));
		}
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$params = array();
		$params['action'] = "playerInfo";
		$params['mark'] = $this->info['unid'];
		$params['server']=$server['sid'];
		$params['nametype']=1;
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 7);
		$params['name']=$hashids->encode($user['id']).".s".$server['sid'];
		$params['isAdult'] = 1;
		$params['time'] = time();
		ksort($params);
		$url = http_build_query($params);
		$token = strtolower(md5($url.$this->info['pay_key']));
		$params['token'] =$token;
		$data=\Org\Net\HttpCurl::get($this->info['pay_url'],$params);
		$data[0]=str_replace(Array('(',')'),'',$data[0]);
		
		
		if(strlen($data[0])==""){
			return false;
		}else{
			$json=json_decode($data[0],true);
			if($json['code']=="200"){
				return $json['data']['basic']['fld_szCharName'];
			}else{
				return false;
			}
		}
	}
	

public function extend($type,$game){
		switch($type){
			case "test":
			$params = array();
		$params['action'] = "gameLogin";
		$params['mark'] = $this->info['unid'];
		$params['server']=1;
		$params['username']="test_buy.s1";
		$params['isAdult'] = 1;
		$params['time'] = time();
		$params['source'] = "";
		ksort($params);
		$url = http_build_query($params);
		$token = strtolower(md5($url.$this->info['login_key']));//生成token
		$url=$url.'&token='.$token;
		echo $this->info['login_url'].'?'.$url;
			
			
			
			break;
		
		
		}

}

	
	
	
	public function getPayType($paytype){
		$obj=new \Common\Util\Pay('Kdpay');
		return $obj->payer->getPayType($paytype);
	}
	
	public function pay($pay,$game,$server,$user){
		$pay['notify_url']=U('Pay/Request/bhqsl_notify');
		$pay['return_url']=U('Pay/Request/bhqsl');
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
		$params = array();
		$params['action'] = "recharge";
		$params['mark'] = $this->info['unid'];
		$params['server']=$server['sid'];
		$params['money']=$pay['payamount'];
		$params['orderid']=$pay['order'];
		$params['payment']="";
		$hashids = new \Common\Util\Hashids(md5('t3t2gamekey'), 7);
		$params['username']=$hashids->encode($user['id']).".s".$server['sid'];
		$params['isAdult'] = 1;
		$params['time'] = time();
		ksort($params);
		$url = http_build_query($params);
		$token = strtolower(md5($url.$this->info['pay_key']));
		$params['token'] =$token;
		$data=\Org\Net\HttpCurl::get($this->info['pay_url'],$params);
		$data[0]=str_replace(Array('(',')'),'',$data[0]);
		if($data[0]==""){
			return false;
		}else{
			$json=json_decode($data[0],TRUE);
			if($json['code']=="200"){
				return true;
			}else{
				return false;
			}
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