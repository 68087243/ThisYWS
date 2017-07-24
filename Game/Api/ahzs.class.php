<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class ahzsApi extends Controller{
	
	private $info=Array();//API信息
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
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
		}else{
			$this->ajax(Array('info'=>'充值失败','status'=>0,'url'=>''));
		}
	}
	
	
	//启动游戏
	public function play($game,$server,$user){
		$start['StationId']=$this->info['unid'];
		$start['GameId']=$game['api_id'];
		$start['ServerId']=$server['sid'];
		$start['UserId']=$user['id'];
		$start['Time']=time();
		$start['Sign']=md5($start['StationId'].'&'.$start['UserId'].'&'.$start['GameId'].'&'.$start['ServerId'].'&'.$this->info['login_key'].'_'.$start['Time']);
		/*
		$start['pay_url']=U('Pay/index/'.$game['id']);
		if($user['identification']){
			$mix=M('MixUserGame')->where(Array('mid'=>$user['identification'],'gid'=>$game['id']))->find();
			$start['pay_url']=$mix['pay_url'];
		}
		*/
		$url=trim($this->info['login_url'].'?'.http_build_query($start));
		$this->assign('url',$url);
		$this->display('default/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$start['StationId']=$this->info['unid'];
		$start['GameId']=$game['api_id'];
		$start['ServerId']=$server['sid'];
		$start['UserId']=$user['id'];
		$start['Time']=time();
		ksort($start);
		$start['Sign']=md5($start['StationId'].'&'.$start['UserId'].'&'.$start['GameId'].'&'.$start['ServerId'].'&'.$this->info['login_key'].'&'.$start['Time']);
		$url='http://182.92.7.76/query.php?'.http_build_query($start);
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	    $output = curl_exec($ch);
		$jsondata=json_decode($output,true);
		if($json['code']="200"){
				return $jsondata['data'][0]['uName'];
			}else{
				return false;
			}
	}
	

	
	
	
	public function getPayType($paytype){
		switch($paytype){
			case "_syspay":return true;break;
			default:return Payapi(1)->payer->getPayType($paytype);break;
		}
	}
	
	public function pay($pay,$game,$server,$user){
		$paytype=M('Paytype')->where(Array('tag'=>$pay['paytype']))->cache(false)->find();
		$pay['notify_url']=U('Pay/Request/ahzs_notify');
		$pay['return_url']=U('Pay/Request/ahzs');
		echo Payapi($paytype['payapi'])->payer->buildRequestForm($pay);
	}
	
	//游戏充值
	public function _pay($pay,$game=false,$server=false,$user=false){
		if(!$game){
			$game=M('Game')->find($pay['gameid']);
		}
		if(!$server){
			$server=M('Gameserver')->find($pay['serverid']);
		}
		if(!$user){
			$user=D('User')->where(Array('username'=>$pay['paytoname']))->find();;
		}
		
		$start['StationId']=$this->info['unid'];
		$start['GameId']=$game['api_id'];
		$start['ServerId']=$server['sid'];
		$start['UserId']=$user['id'];
		$start['orderId']=$pay['order'];
		$start['payMoney']=intval($pay['payamount']);
		$start['Time']=time();
		$start['Sign']=md5($start['UserId'].'&'.$start['StationId'].'&'.$start['GameId'].'&'.$start['ServerId'].'&'.$this->info['pay_key'].'&'.$start['orderId'].'&'.$start['payMoney'].'&'.$start['Time']);
		$data=\Org\Net\HttpCurl::get($this->info['pay_url'],$start);
		if($data[0]==""){
			return false;
		}else{
			//$json=json_decode(trim($data[0], "\xEF\xBB\xBF"),true);
			if($data[0]=="0"){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function getPayOrder(){
		return getOrder();
	}
	
	public function getPayTip($paylog){
		$paytype=M('Paytype')->where(Array('tag'=>$paylog['paytype']))->find();
		$obj=Payapi($paytype['payapi']);
		return $obj->payer->tip;
	}
	
	//支付回调检查
	public function checkPay($paylog,$sign=false){
		$paytype=M('Paytype')->where(Array('tag'=>$paylog['paytype']))->find();
		$obj=Payapi($paytype['payapi']);
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