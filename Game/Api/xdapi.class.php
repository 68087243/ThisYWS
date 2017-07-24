<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class xdapiApi extends Controller{
	
	private $info=Array();//API信息
	public function __construct($info){
		parent::__construct();
		$this->info=$info;
	}
	
	//启动游戏
	public function play($game,$server,$user){
		$start['uid']=$user['id'];
		$start['game_id']=$game['api_id'];
		$start['serverNo']=$server['sid'];
		$start['agent_id']=$this->info['unid'];
		$start['time']=time();
		$start['sign']=md5($start['agent_id'].$start['game_id'].$start['serverNo'].$start['uid'].$start['time'].$this->info['login_key']);
		$url=$this->info['login_url'].'?'.http_build_query($start);
		$this->assign('url',$url);
		$this->display('default/play');
	}
	
	//获取角色名
	public function checkRole($game,$server,$user){
		$start['uid']=$user['id'];
		$start['game_id']=$game['api_id'];
		$start['serverNo']=$server['sid'];
		$start['agent_id']=$this->info['unid'];
		$start['time']=time();
		$start['sign']=md5($start['agent_id'].$start['game_id'].$start['serverNo'].$start['uid'].$start['time'].$this->info['pay_key']);
		$data=\Org\Net\HttpCurl::get('http://www.ufojoy.com/auth/dengji.phtml',$start);
		
		$json=json_decode($data[0]);
		if($json->code == 1){
			return urldecode($json->msg[0]->rolename);
		}else{
			return false;
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
			case "zfb":$type='alipay';break;//支付宝
			case "wyzf":$type='wyzf';break;
			//case "weixin":$type='weixin';break;
			default:return false;
		}
		return $type;
	}
	public function getPayBank($type){
		switch($type){
			case "POST":$type='PSBC';break;
			case "BCOM":$type='COMM';break;
			case "PAB":$type='SZPAB';break;
			case "SHB":$type='BOS';break;
		}
		return $type;
	}
	public function pay($pay,$game,$server,$user){
		$start['OrderID']=$pay['order'];
		$start['uid']=$user['id'];
		$start['game_id']=$game['api_id'];
		$start['serverNo']=$server['sid'];
		$start['agent_id']=$this->info['unid'];
		$start['amount']=$pay['payamount'];
		$start['paytype']=$this->getPayType($pay['paytype'])!='wyzf'?$this->getPayType($pay['paytype']):$this->getPayBank($pay['paybank']);
		$start['rel']=urlencode(U('Pay/Request/xdapi'));
		$start['time']=time();
		$start['sign']=md5($start['agent_id'].$start['game_id'].$start['serverNo'].$start['uid'].$start['OrderID'].$start['amount'].$start['paytype'].$start['rel'].$this->info['pay_key']);
		$start['charname']=$user['temp_role'];
		$config[0]=$start;
		$config[1]=$this->info['pay_url'];
		$config[2]='post';
		new \Common\Util\Pay('Pay_',$config);
	}
	
	public function getPayOrder(){
		return I('OrderID');
	}
	
	public function getPayTip(){
		return Array(1=>'SUCCESS',2=>'error');
	}
	
	public function checkPay($paylog,$sign=false){
		$order=I('OrderID');
		$sign_=md5($_GET['uid'].$order.$_GET['amount'].$_GET['time'].$this->info['pay_key']);
		if($sign_==$_GET['sign']){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	
}






?>