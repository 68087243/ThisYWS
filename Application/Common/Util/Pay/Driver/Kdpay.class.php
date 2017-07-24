<?php
namespace Common\Util\Pay\Driver;
use Think\Controller;
use Org\Net;

/**
 * 口袋支付驱动
 */
class Kdpay extends \Common\Util\Pay {
    protected $gateway = 'http://Api.Duqee.Com/pay/Bank.aspx';
	protected $gateway_card = 'http://Api.Duqee.Com/pay/Card.aspx';
    protected $config = array(
        'id' => '1000365',
        'key' => '34d0fa3f61ca4996b4b0ea4ab2fe8d28'
    );
	public $tip= Array(1=>'errCode=0',2=>'errCode=0');
	
	protected $errcode=Array(
		0 => "提交/充值成功",
		101 => "商户ID为空",
		102 => "卡号不合法",
		103 => "卡密不合法",
		104 => "卡号长度错误(太长)",
		105 => "卡密长度错误(太长)",
		106 => "面值数据不合法",
		107 => "充值类型错误",
		108 => "游戏用户名过长",
		109 => "不存在此商户",
		110 => "加密串PostKey错误",
		111 => "此卡号已被使用过",
		112 => "此卡类型不存在",
		113 => "商户未开通此通道或业务",
		114 => "系统配置错误",
		115 => "卡号和卡密或者面值不符",
		116 => "未知错误",
		117 => "无效的充值卡",
		118 => "商户订单号为空",
		119 => "商户订单号字符长度超限",
		120 => "金额为空或不合法",
		121 => "产品名称字符长度超限",
		122 => "产品描述字符长度超限",
		123 => "产品单价不合法(须为数字)",
		124 => "用户自定义信息字符超限",
		125 => "notify_url赋值超限",
		126 => "result_url 赋值超限",
		127 => "订单提交太过频繁，请稍后再试",
		128 => "该银行ID不存在",
	);
	public $sign=false;
	
	
	public function getPayType($type,$paydata=null){
		switch($type){
			case 'zfb':$type=2;break;
			case 'weixin':$type=21;break;
			case 'wyzf':$type=1;break;
			case 'sdykt':$type=5;break;
			case 'wyykt':$type=11;break;
			case 'ltczk':$type=15;break;
			case 'jwykt':$type=6;break;
			case 'ztykt':$type=9;break;
			case 'txqqk':$type=4;break;
			case 'thykt':$type=17;break;
			case 'wmykt':$type=7;break;
			case 'szxczk':
			if(strlen($paydata['paycardid'])==17 && strlen($paydata['paycardpass'])==18){
				$type=14;
			}else{
				$type=22;
			}
			break;
			default:return false;
		}
		return $type;
	}

	public function getPayBackType($type){
		switch($type){
			case 'ICBC':$type=10001;break;
			case 'CCB':$type=10005;break;
			case 'ABC':$type=10002;break;
			case 'CMB':$type=10003;break;
			case 'BOC':$type=10004;break;
			case 'POST':$type=10012;break;
			case 'BCOM':$type=10008;break;
			case 'CEB':$type=10010;break;
			case 'PAB':$type=10014;break;
			case 'CIB':$type=10009;break;
			case 'SPDB':$type=10015;break;
			case 'GDB':$type=10016;break;
			case 'CMBC':$type=10006;break;
			case 'CITIC':$type=10007;break;
			case 'SHB':$type=10023;break;
			case 'NBCB':$type=10019;break;
			default:return false;
		}
		return $type;
	}
	
	
	public function __construct( $pay_data = array()) {
		$this->config['id']=$pay_data['appid'];
		$this->config['key']=$pay_data['appkey'];
    }
	

	


	//发起请求
    public function buildRequestForm($pay_data) {
        $param = array(
            'P_UserId' => $this->config['id'],
            'P_OrderId' => $pay_data['order'],
            'P_CardId' => $pay_data['paycardid'],
			'P_CardPass' => $pay_data['paycardpass'],
            'P_FaceValue' => $pay_data['payamount'],
            'P_ChannelId' => $this->getPayType($pay_data['paytype'],$pay_data),
			'P_Subject' => $pay_data['subject'],
			'P_Price' => $pay_data['payamount'],
			'P_Quantity' => 1,
			'P_Description' => $this->getPayBackType($pay_data['paybank']),
			'P_Notic' =>$pay_data['platform'],
			'P_Result_URL' => $pay_data['notify_url'],
			'P_Notify_URL' => $pay_data['return_url'],
			'P_IsSmart' => ''
        );
		$param['P_PostKey']=md5($param['P_UserId']."|".$param['P_OrderId']."|".$param['P_CardId']."|".$param['P_CardPass']."|".$param['P_FaceValue']."|".$param['P_ChannelId']."|".$this->config['key']);

        ksort($param);
        reset($param);
		
		if($pay_data['paycardid'] && $pay_data['paycardpass']){
			$data=\Org\Net\HttpCurl::get($this->gateway_card,$param);
			
			if($data[0]=="errCode=0"){
				redirect('return/index');
			}else{
				$code=str_replace("errCode=","",$data[0]);
				echo $this->errcode[$code];
			}
		}else{
			 return	$this->_buildForm($param, $this->gateway, 'get');
		}
    }
	
	
	public function notify_echo(){
		echo "success";
	}
	
	//回调验证
	public function signCheck(){
		$OrderId=$_REQUEST["P_OrderId"];
		$CardId=$_REQUEST["P_CardId"];
		$CardPass=$_REQUEST["P_CardPass"];
		$FaceValue=$_REQUEST["P_FaceValue"];
		$ChannelId=$_REQUEST["P_ChannelId"];
		$subject=$_REQUEST["P_Subject"];
		$description=$_REQUEST["P_Description"]; 
		$price=$_REQUEST["P_Price"];
		$quantity=$_REQUEST["P_Quantity"];
		$notic=$_REQUEST["P_Notic"];
		$ErrCode=$_REQUEST["P_ErrCode"];
		$PostKey=$_REQUEST["P_PostKey"];
		$payMoney=$_REQUEST["P_PayMoney"];
		$ErrMsg=$_REQUEST["P_ErrMsg"];
		$preEncodeStr=$this->config['id']."|".$OrderId."|".$CardId."|".$CardPass."|".$FaceValue."|".$ChannelId."|".$this->config['key'];
		$encodeStr=md5($preEncodeStr);
		
		if($PostKey==$encodeStr){
			if($ErrCode=="0"){
				if($CardId && $CardPass){
					$__temp=M('Paylog')->where(Array('order'=>$OrderId))->find();
					if($__temp['payamount']!=intval($FaceValue)){
						return false;
					}
				}
				return true;
			}
		}
		return false;
	}

   
}
