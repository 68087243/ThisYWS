<?php
namespace Api\Controller;
use Think\Controller;
class ToolController extends ApiController{
	
	public function qun(){
		$num=intval(I('num'));
		$qun_url='http://shang.qq.com/wpa/qunwpa?idkey=';
		if($num<=10000){
			die('error');
		}
		$headers = array(
			'Host: shang.qq.com',
			'Connection: keep-alive',
			'Cache-Control: max-age=0',
			'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.80 Safari/537.36',
			'Content-Type: utf-8',
			'Accept: */*',
			'Referer: http://shang.qq.com/proxy.html?callback=1&id=1',
			'Accept-Encoding: gzip, deflate, sdch',
			'Accept-Language: zh-CN,zh;q=0.8',
		);
		$ch = curl_init('http://shang.qq.com/wpa/g_wpa_get?guin='.$num.'&t='.time().'002');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		curl_close($ch);
		$json=json_decode($result,true);
		if(empty($json['result']['data'][0]['key'])){
			$this->error('请手动加群:'.$num);
			die();
		}
		$qun_url.=$json['result']['data'][0]['key'];
		header("Location:".$qun_url);
	}



}