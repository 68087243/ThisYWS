<?php
namespace UrlWorker\Controller;
use Think\Controller;
use Common\Util;

class EmptyController extends Controller {
    public function index(){
		$encode = strtolower(CONTROLLER_NAME);
		$hashids = new \Common\Util\Hashids(md5('t3t2key'), 10);
		$ids = $hashids->decode($encode);
		$data=M('Url')->find($ids[0]);
		if(empty($data)){
			$data['url']=U('Game/index/index');
		}
		$html= <<<EOF
<html>
<head>
<meta http-equiv="refresh" content="1;url={$data['url']}"> 
</head>
</html>
EOF;



		
		if(!empty($data)){
			$datas['urlid']=$data['id'];
			$datas['useragent']=get_useragent();
			$datas['referer']=addslashes($_SERVER['HTTP_REFERER'])?:'QQ/直接打开';
			$datas['ip']=get_client_ip();
			$_TEMP=M('UrlLog')->where($datas)->order('id desc')->find();
			$datas['ctime']=time();
			if(empty($_TEMP)){
				M('UrlLog')->add($datas);
			}else{
				$cle = $datas['ctime'] - $_TEMP['ctime'];
				if(ceil($cle/60) > 1){
					M('UrlLog')->add($datas);
				}
			}
		}
		echo $html;
    }
	
}