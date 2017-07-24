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
		var_dump($data);

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