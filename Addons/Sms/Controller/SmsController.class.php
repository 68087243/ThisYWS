<?php

namespace Addons\Sms\Controller;
use Home\Controller\AddonController;

/**
 * 短信控制器
 * @author C0de <47156503@qq.com>
 */
class SmsController extends AddonController{
    /**
     * 系统短信发送函数
     * @param string $receiver 收件人
     * @param string $body 短信内容
     * @return boolean
     * @author C0de <47156503@qq.com>
     */
    function sendSms($receiver,$body = ''){
        $addon_config = \Common\Controller\Addon::getConfig('Sms');
        if($addon_config['status']){
			//$body_template = $addon_config['default']; //获取短信模版配置
           // $body = str_replace("[EMAILBODY]", $body, $body_template); //使用短信模版
			//$body = str_replace("[WEBTITLE]", C('WEB_SITE_TITLE'), $body);
			//$body = str_replace("[TIME]", date("Y-m-d H:i:s"), $body);
			//初始化必填
			 $client  = new \Addons\Sms\Lib\AlidayuClient($addon_config['APP_KEY'],$addon_config['APP_SECRET'],1);
			 $request = new \Addons\Sms\Lib\Request\SmsNumSend;
			// 短信内容参数
			$smsParams = [
				'code'    => $body,
				'product' => '手机号码'
			];
			// 设置请求参数
			$req = $request->setSmsTemplateCode($addon_config['TEMPLATE_ID'])
				->setRecNum($receiver)
				->setSmsParam(json_encode($smsParams))
				->setSmsFreeSignName($addon_config['APP_SIGN'])
				->setSmsType('normal')
				->setExtend('t3t2');
			$client->execute($req);
			return true;
        }else{
            return false;
        }
    }
}
