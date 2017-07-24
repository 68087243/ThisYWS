<?php
namespace Game\Api;
use Think\Controller;
use Org\Net;
use Common\Util;
class mszjApi extends Controller{
	
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
		$userid="10001";
		$username=$user['username'];
		$serverid="S".$server['sid'];
		$time=time();
		$key=$this->info['login_key'];

		$md5=$userid.urlEncode($username).$time.$serverid.$key;

		$flag=md5($md5);
		$cm ='1';
		$server_name = urlEncode('魔神战记'.$serverid) ;
		

		$loginurl="userid=".$userid."&username=".$username."&time=".$time."&server_id=".$serverid."&cm=".$cm."&server_name=".$server_name."&flag=".$flag;
		$url=$this->info['login_url'].'?'.$loginurl;
		
		$this->assign('url',$url);
		$this->display('default/play');
	}
	

	//获取角色名
	public function checkRole($game,$server,$user){
		$start['server_id']="S".$server['sid'];
		$start['username']=$user['username'];
		$start['time']=time();
		$sign=$start['username'].$start['server_id']."ECB54224C43022CB0383EC518ED079E3";		
		$start['sign']=md5($sign);				
		$url="http://42.159.143.161:8899/checkAccount.jsp?".http_build_query($start);
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	    $output0 = curl_exec($ch);
	    $output =urlDecode( $output0 );
		return $output;
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
		/*查询角色名称*/
		$gameid   = $game['id'];
		$userid   = $user['id'];
		$serverid = $server['id'];
		$gameplay = M('Gameplay')->field("rolename")->where("gid=$gameid and uid=$userid and sid=$serverid")->select();
		$rolename = $gameplay[0]['rolename'];
		/*查询角色名称end*/

		$start['orderid']=$pay['order'];
		$start['type']=urlEncode($this->getPayType($pay['paytype']));
		$start['payname']='haowan321';
		$start['passport']=urlEncode($user['username']);
		$start['money']=$pay['payamount'];
		$start['gold']=$start['money']*500;
		$start['coin']=0;
		$start['role']=$rolename;
		$start['server_id']="S".$server['sid'];
		$md5=$start['orderid'].$start['type'].$start['payname'].$start['passport'].$start['role'].$start['money'].$start['gold'].$start['coin'].$this->info['pay_key'];
		$sign     =md5(strtolower($md5));
		$start['sign']=strtolower($sign);

		$url=$this->info['pay_url']."?"."p=".$start['orderid']."|".$start['type']."|".$start['payname']."|".$start['passport']."|".$start['money']."|".$start['gold']."|".$start['sign']."|".$start['coin']."|".$start['role']."&server_id=".$start['server_id'];
		
		

		$data=\Org\Net\HttpCurl::get($this->info['pay_url'],$start);
		$myfile = fopen("3.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $url);                    
        $txt = "\n";
        fwrite($myfile, $txt);
        fclose($myfile);
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
	
	/*public function pay($pay,$game,$server,$user){
		//角色名称
		$zfb=$this->getPayType($pay['paytype']);
		$gameid   = $game['id'];
		$userid   = $user['id'];
		$serverid = $server['id'];
		$gameplay = M('Gameplay')->field("rolename")->where("gid=$gameid and uid=$userid and sid=$serverid")->select();
		$rolename = $gameplay[0]['rolename'];
		$orderid  = $pay['order'];//流水号，不能重复，相当于平台的定单号
		$type     = urlEncode($this->getPayType($pay['paytype']));//充值类型，由合作商确定提供要urlEncode(type)
		$payname  ='haowan321';//充值来源 填写合作商户的名称，如：17pk
		$passport =urlEncode($user['username']);//在合作商户注册用户的通行证,则平台通行证帐号,要urlEncode
		$money    =$pay['payamount'];//充值金额 要求大于0的整数
		$gold	   =$money*500;//充值得到的魔晶数量要求大于0的整数
		$role     =urlEncode($rolename);//充值对应的角色名,要求urlEncode(role)
		$coin     ="0";//充值时赠送的礼券数，如无设置为0	
		$md5=$orderid.$type.$payname.$passport.$role.$money.$gold.$coin.'6D21F34B75021DB25D77CAE071ABA08D';
		$sign     =md5(strtolower($md5));
		$sign     =strtolower($sign);
		$server_id="S".$server['sid'];//表示充值的服务器ID。不用加入验证串

		$url=$this->info['pay_url']."?"."p=".$orderid."|".$type."|".$payname."|".$passport."|".$money."|".$gold."|".$sign."|".$coin."|".$role."&server_id=".$server_id;
		$config[0]=$orderid.$type.$payname.$passport.$money.$gold.$sign.$coin.$role.$server_id;
		$config[1]=$url;
		$config[2]='post';
		new \Common\Util\Pay('Pay_',$config);
	}*/
	
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