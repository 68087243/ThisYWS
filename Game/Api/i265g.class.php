<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class i265gApi extends Controller{
	
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
		$start['dateline']=time();
		$start['pc']=0;
		$start['fcm']=D('User')->isFcm($user)?1:1;
		$start['sign']=md5($start['uid'].$start['gid'].$start['sid'].$start['mid'].$start['dateline'].$this->info['login_key']);
		$url=$this->info['login_url'].'&'.http_build_query($start);
		$data=\Org\Net\HttpCurl::get($url);
		$this->assign('url',trim($data[0]));
		$this->display('default/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$start['uid']=$user['id'];
		$start['gid']=$game['api_id'];
		$start['sid']=$server['sid'];
		$start['mid']=$this->info['unid'];
		$start['dateline']=time();
		$start['sign']=md5($start['uid'].$start['gid'].$start['sid'].$start['mid'].$start['dateline'].$this->info['login_key']);
		$start['tp']='role';
		$data=\Org\Net\HttpCurl::get('http://yylm.265g.com/',$start);
		if(strlen($data[0])==1){
			return false;
		}else{
			$json=json_decode($data[0]);
			return $json->role;
		}
	}
	

	
	public function getCard($game,$server,$user,$gift){
		$start['tp']='card';
		$start['gid']=$server['gid'];
		$start['sid']=$server['sid'];
		$start['uid']=$user['id'];
		$start['mid']=$this->info['unid'];
		$start['type']=$gift['type'];
		$start['p']=$gift['p'] ?: 'false';
		$start['cate']=$gift['cate'] ?: '0';
		$start['sign']=md5($start['uid'].$start['gid'].$start['sid'].$start['mid'].$start['type'].$start['p'].$start['cate'].$this->info['login_key']);
		$data=\Org\Net\HttpCurl::get('http://yylm.265g.com/',$start);
		return '签名错误';
	}
	
	public function getPayType($paytype){
		switch($paytype){
			case "zfb":$type='1';break;//支付宝
			case "wyzf":$type='2';break;
			case "weixin":$type='10';break;
			default:return false;
		}
		return $type;
	}
	
	public function pay($pay,$game,$server,$user){
		$start['oid']=$pay['order'];
		$start['uid']=$user['id'];
		$start['gid']=$game['api_id'];
		$start['sid']=$server['sid'];
		$start['mid']=$this->info['unid'];
		$start['money']=$pay['payamount'];
		$start['pid']=$this->getPayType($pay['paytype']);
		$start['bank']=$pay['paybank'];
		$start['sign']=md5($start['oid'].$start['uid'].$start['gid'].$start['sid'].$start['mid'].$start['money'].$start['pid'].$start['bank'].$this->info['pay_key']);
		$config[0]=$start;
		$config[1]=$this->info['pay_url'].'&'.http_build_query($start);
		$config[2]='post';
		new \Common\Util\Pay('Pay_',$config);
	}
	
	public function getPayOrder(){
		return I('oid');
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