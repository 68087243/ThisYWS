<?php
namespace UrlWorker\Controller;
use Think\Controller;
use Common\Util;

class IndexController extends Controller {
    public function index(){
        $this->show('nginx','utf-8');
    }
	
	public function geturl(){
		if(IS_POST && preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',I("url"))){
			$map['url']=I("url");
			$data=M('Url')->where($map)->find();
			$map['ctime']=time();
			if(empty($data)){
				$id=M('Url')->add($map);
			}else{
				$id=$data['id'];
			}
			$hashids = new \Common\Util\Hashids(md5('t3t2key'), 10);
			$url= "http://url.739wan.cn/".$hashids->encode($id);
			$this->assign('url',I("url"));
			$this->assign('result',$url);
		}
		$this->display();
	}
	
	
	public function decode(){
		
		$hashids = new \Common\Util\Hashids(md5('t3t2key'), 10);
		$ids=$hashids->decode($_GET['id']);
		print_r($ids);
		
	}
	

}
