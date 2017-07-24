<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class qiluwanApi extends Controller{
	
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
		$start['platform']=$this->info['unid'];
		$start['gameid']=$game['api_id'];
		$start['serverid']=$server['sid'];
		$start['openid']=$user['id'];
		ksort($start);
		$start['sig']=md5($this->info['login_key'].http_build_query($start));
		$url=$this->info['login_url'].'?'.http_build_query($start);
		$this->assign('url',$url);
		$this->display('default/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$start['platform']=$this->info['unid'];
		$start['gameid']=$game['api_id'];
		$start['serverid']=$server['sid'];
		$start['openid']=$user['id'];
		ksort($start);
		$start['sig']=md5($this->info['login_key'].http_build_query($start));
		$data=\Org\Net\HttpCurl::get('http://115.159.37.182/player.php',$start);
		if(strlen($data[0])==""){
			return false;
		}else{
			$json=json_decode($data[0]);
			if($json['ret']=="-1"){
				return false;
			}else{
				return $json->data->name;
			}
		}
	}
	

	
	
	
	public function getPayType($paytype){
		$obj=new \Common\Util\Pay('Kdpay');
		return $obj->payer->getPayType($paytype);
	}
	
	public function pay($pay,$game,$server,$user){
		$pay['notify_url']=U('Pay/Request/qiluwan_notify');
		$pay['return_url']=U('Pay/Request/qiluwan');
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
		
		$start['platform']=$this->info['unid'];
		$start['gameid']=$game['api_id'];
		$start['serverid']=$server['sid'];
		$start['openid']=$user['id'];
		$start['payitem']=$pay['payamount'];
		$start['token']=$pay['order'];
		ksort($start);
		$start['sig']=md5($this->info['pay_key'].http_build_query($start));
		
		$data=\Org\Net\HttpCurl::get($this->info['pay_url'],$start);
		if($data[0]==""){
			return false;
		}else{
			$json=json_decode($data[0]);
			if($json['ret']=="0"){
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