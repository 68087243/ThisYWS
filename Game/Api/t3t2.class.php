<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class t3t2Api extends Controller{
	
	private $info=Array();//API信息
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
	}
	
	//启动游戏
	public function play($game,$server,$user){
		$start['uid']=$user['id'];
		$start['gid']=$game['api_id'];
		$start['sid']=$server['sid'];
		$start['mid']=$this->info['unid'];
		$start['time']=time();
		$start['sign']=md5($start['uid'].$start['gid'].$start['sid'].$start['mid'].$start['time'].$this->info['login_key']);
		$url=$this->info['login_url'].'?'.http_build_query($start);
		$this->assign('url',trim($url));
		$this->display('default/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$start['uid']=$user['id'];
		$start['gid']=$game['api_id'];
		$start['sid']=$server['sid'];
		$start['mid']=$this->info['unid'];
		$start['time']=time();
		$start['sign']=md5($start['uid'].$start['gid'].$start['sid'].$start['mid'].$start['time'].$this->info['login_key']);
		$start['tp']='role';
		$data=\Org\Net\HttpCurl::get('http://api.t3t2.com/mix/role.html',$start);
		if(strlen($data[0])==1){
			return false;
		}else{
			$json=json_decode($data[0],true);
			return $json['0']['rolename'];
		}
	}
	

	
	
	
	public function getPayType($paytype){
		switch($paytype){
			case "zfb":$type='zfb';break;//支付宝
			case "wyzf":$type='wyzf';break;
			case "weixin":$type='weixin';break;
			default:return false;
		}
		return $type;
	}
	
	public function pay($pay,$game,$server,$user){
		$start['order']=$pay['order'];
		$start['uid']=$user['id'];
		$start['gid']=$game['api_id'];
		$start['sid']=$server['sid'];
		$start['mid']=$this->info['unid'];
		$start['money']=$pay['payamount'];
		$start['pid']=$this->getPayType($pay['paytype']);
		$start['bank']=$pay['paybank'];
		$start['time']=time();
		$start['sign']=md5($start['order'].$start['uid'].$start['gid'].$start['sid'].$start['mid'].$start['money'].$start['pid'].$start['time'].$this->info['pay_key']);
		$config[0]=$start;
		$config[1]=$this->info['pay_url'].'?'.http_build_query($start);
		$config[2]='get';
		new \Common\Util\Pay('Pay_',$config);
	}
	
	public function getPayOrder(){
		return I('order');
	}
	
	public function getPayTip(){
		return Array(1=>'SUCCESS',2=>'error');
	}
	
	//支付回调检查
	public function checkPay($paylog,$sign=false){
		if($_GET['status']==1){
			return true;
		}else{
			return false;
		}
	}
	
	
	
}






?>