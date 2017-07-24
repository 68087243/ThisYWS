<?php
namespace Common\Util\Pay\Driver;
/**
 * 支付宝驱动
 */
class Alipay extends \Common\Util\Pay {
    protected $gateway = 'https://mapi.alipay.com/gateway.do';
    protected $verify_url = 'http://notify.alipay.com/trade/notify_query.do';
    protected $config = array(
        'email' => '',
        'key' => '',
        'partner' => ''
    );
	
	public $tip= Array(1=>'success',2=>'success');
	public function __construct( $pay_data = array()) {
		$this->config['partner']=$pay_data['appid'];
		$this->config['key']=$pay_data['appkey'];
		$this->config['email']=$pay_data['parameter'];
    }
	

    public function buildRequestForm($pay_data) {
        $param = array(
            'service' => 'create_direct_pay_by_user',
            'payment_type' => '1',
            '_input_charset' => 'utf-8',
            'seller_email' => $this->config['email'],
            'partner' => $this->config['partner'],
            'notify_url' => $pay_data['notify_url'],
            'return_url' => $pay_data['return_url'],
            'out_trade_no' => $pay_data['order'],
            'subject' => $pay_data['subject'],
            'body' => $pay_data['subject'],
            'total_fee' => $pay_data['payamount']
        );

        ksort($param);
        reset($param);

        $arg = '';
        foreach ($param as $key => $value) {
            if ($value) {
                $arg .= "$key=$value&";
            }
        }

        $param['sign'] = md5(substr($arg, 0, -1) . $this->config['key']);
        $param['sign_type'] = 'MD5';

        $sHtml = $this->_buildForm($param, $this->gateway, 'get');

        return $sHtml;
    }

    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
    protected function getSignVeryfy($param, $sign) {
        //除去待签名参数数组中的空值和签名参数
        $param_filter = array();
        while (list ($key, $val) = each($param)) {
            if ($key == "sign" || $key == "sign_type" || $val == "") {
                continue;
            } else {
                $param_filter[$key] = $param[$key];
            }
        }

        ksort($param_filter);
        reset($param_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = "";
        while (list ($key, $val) = each($param_filter)) {
            $prestr.=$key . "=" . $val . "&";
        }
        //去掉最后一个&字符
        $prestr = substr($prestr, 0, -1);

        $prestr = $prestr . $this->config['key'];
        $mysgin = md5($prestr);

        if ($mysgin == $sign) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    public function signCheck() {
        //生成签名结果
        $isSign = $this->getSignVeryfy($_GET, $_GET["sign"]);
        //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
        $responseTxt = 'true';
        if (!empty($_GET["notify_id"])) {
            $responseTxt = $this->getResponse($_GET["notify_id"]);
        }
		
        if ($isSign) {
			$status = ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') ? true : false;
            return $status;
        } else {
            return false;
        }
    }

}
