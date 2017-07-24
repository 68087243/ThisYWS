<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class wan95Api extends Controller{
	
	private $info=Array();//API信息
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
	}
	
	//启动游戏
	public function play($game,$server,$user){
		$start['uid']=$user['id'];
		$start['serverid']=$server['sid'];
		$start['agentid']=$this->info['unid'];
		$start['time']=time();
		$start['json']=0;
		$start['fcm']=D('User')->isFcm($user)?1:1;
		$start['sign']=md5($start['agentid'].$start['uid'].$start['serverid'].$start['time'].$this->info['login_key']);
		$url=$this->info['login_url'].'?'.http_build_query($start);
		$this->assign('url',$url);
		$this->display('default/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$start['uid']=$user['id'];
		$start['serverid']=$server['sid'];
		$start['agentid']=$this->info['unid'];
		$start['time']=time();
		$start['sign']=md5($start['agentid'].$start['uid'].$start['serverid'].$start['time'].$this->info['login_key']);
		$data=\Org\Net\HttpCurl::get('http://hf.wan95.com/api/getrole',$start);
		if(strlen($data[0])==""){
			return false;
		}else{
			$json=json_decode($data[0]);
			if($json->status == 1){
				return $json->data->rolename;
			}else{
				return false;
			}
			
		}
	}
	

	
	public function getCard($game,$server,$user,$gift){
		$start['uid']=$user['id'];
		$start['serverid']=$server['sid'];
		$start['agentid']=$this->info['unid'];
		$start['time']=time();
		$start['sign']=md5($start['agentid'].$start['uid'].$start['serverid'].$start['time'].$this->info['login_key']);
		$data=\Org\Net\HttpCurl::get('http://hf.wan95.com/api/getcard',$start);
		if(strlen($data[0])==""){
			return false;
		}else{
			$json=json_decode($data[0]);
			if($json->status == 1){
				return $json->data;
			}else{
				return false;
			}
			
		}
	}
	
	public function getPayType($paytype){
		switch($paytype){
			case "zfb":$type='alipay';break;//支付宝
			case "wyzf":$type='sdopay';break;
			case "jwykt":$type='jcard';break;
			case "txqqk":$type='qbi';break;
			case "ztykt":$type='zhengtu';break;
			case "sdykt":$type='shengda';break;
			case "ltczk":$type='shenzhou';break;
			case "szxczk":$type='shenzhou';break;
			default:return false;
		}
		return $type;
	}
	
	public function getPayBackType($paytype,$back){
		switch($paytype){
			case "zfb":$type='alipay';break;//支付宝
			case "wyzf":
			switch($back){
				case "POST":$type="PSBC";break;
				case "BCOM":$type="COMM";break;
				case "PAB":$type="SZPAB";break;
				case "SHB":$type="BOS";break;
				default:$type=$back;
			}
			break;
			case "jwykt":$type='60';break;
			case "txqqk":$type='66';break;
			case "ztykt":$type='61';break;
			case "sdykt":$type='03';break;
			case "ltczk":$type='76';break;
			case "szxczk":$type='75';break;
			default:return false;
		}
		return $type;
	}
	
	public function pay($pay,$game,$server,$user){
		$start['ordernum']=$pay['order'];
		$start['uid']=$user['id'];
		$start['serverid']=$server['sid'];
		$start['agentid']=$this->info['unid'];
		$start['amount']=intval($pay['payamount']);
		$start['paytype']=$this->getPayType($pay['paytype']);
		$start['banktype']==$this->getPayBackType($pay['paytype'],$pay['paybank']); 
		$start['time']=time();
		$start['sign']=md5($start['agentid'].$start['uid'].$start['serverid'].$start['ordernum'].$start['paytype'].$start['banktype'].$start['amount'].$start['time'].$this->info['pay_key']);
		$config[0]=$start;
		$config[1]=$this->info['pay_url'].'?'.http_build_query($start);
		$config[2]='get';
		new \Common\Util\Pay('Pay_',$config);
	}
	
	public function getPayOrder(){
		return I('ordernum');
	}
	
	public function getPayTip(){
		return Array(1=>'OK',2=>'OK');
	}
	
	//支付回调检查
	public function checkPay($paylog,$sign=false){
		if($_GET['status']=='success'){
			$sign=md5($_GET['agentid'].$_GET['ordernum'].$_GET['amount'].$_GET['status'].$_GET['time'].$this->info['pay_key']);
			if($sign == $_GET['sign']){
				return true;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}
	
	
	
}






?>