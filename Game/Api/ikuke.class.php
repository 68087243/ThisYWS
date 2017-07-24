<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class ikukeApi extends Controller{
	
	private $info=Array();//API信息
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
	}
	
	//启动游戏
	public function play($game,$server,$user){
		$start['uid']=$user['id'];
		$start['pid']=$this->info['unid'];
		$start['gid']=$game['api_id'];
		$start['sid']=$server['sid'];
		$start['time']=time();
		$start['sign']=md5($start['uid'].$start['pid'].$start['gid'].$start['sid'].$start['time'].$this->info['login_key']);
		$url=$this->info['login_url'].'&'.http_build_query($start);
		$data=\Org\Net\HttpCurl::get($url);
		$this->assign('url',$url);
		$this->display('default/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$start['uid']=$user['id'];
		$start['pid']=$this->info['unid'];
		$start['gid']=$game['api_id'];
		$start['sid']=$server['sid'];
		$start['time']=time();
		$start['sign']==md5($start['uid'].$start['pid'].$start['gid'].$start['sid'].$start['time'].$this->info['login_key']);
		$start['tp']='role';
		$data=\Org\Net\HttpCurl::get('http://mix.kukewan.com/interface/getrole',$start);
		if(strlen($data[0])==1){
			return false;
		}else{
			$json=json_decode($data[0]);
			return $json->role;
		}
	}
	

	
	public function getCard($game,$server,$user,$gift){
		$start['uid']=$user['id'];
		$start['pid']=$this->info['unid'];
		$start['gid']=$server['gid'];
		$start['sid']=$server['sid'];
		$start['time']=time();
		$start['sign']=md5($start['uid'].$start['pid'].$start['gid'].$start['sid'].$this->info['login_key']);
		$data=\Org\Net\HttpCurl::get('http://mix.kukewan.com/interface/getrole',$start);
		return '签名错误';
	}
	
	public function getPayType($paytype){
		switch($paytype){
			case "zfb":$type='2';break;//支付宝
			case "wyzf":$type='2';break;
			case "weixin":$type='2';break;
			default:return false;
		}
		return $type;
	}
	
	public function pay($pay,$game,$server,$user){
		$start['uid']=$user['id'];
		$start['pid']=$this->info['unid'];
		$start['gid']=$game['api_id'];
		$start['sid']=$server['sid'];
		$start['orderid']=$pay['order'];
		$start['money']=$pay['payamount'];
		$start['mid']=$this->getPayType($pay['paytype']);
		$start['bank']=$pay['paybank'];
		$start['time']=time();
		$start['sign']=md5($start['orderid'].$start['uid'].$start['gid'].$start['sid'].$start['money'].$start['time'].$start['mid'].$start['bank'].$start['pid'].$this->info['pay_key']);
		$config[0]=$start;
		$config[1]=$this->info['pay_url'].'&'.http_build_query($start);
		$config[2]='post';
		new \Common\Util\Pay('Pay_',$config);
	}
	
	public function getPayOrder(){
		return I('orderid');
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