<?php
namespace Api\Controller;
use Think\Controller;
use Common\Util;

class SpreadController extends ApiController {



    public function ajaxPurl(){
		$hashids = new \Common\Util\Hashids(md5('t3t2key'), 20);
		if(!I('aid')){
			$aid=0;
		}else{
			$aid=I('aid');
		}
		$ids = array(I('mid'),I('gid'),I('sid'),$aid);
		$str = $hashids->encode($ids);
		$map['url']=U('Spread/p/'.$str);
		$data=M('Url')->where($map)->find();
		$map['ctime']=time();
		if(empty($data)){
		  $id=M('Url')->add($map);
		}else{
		  $id=$data['id'];
		}
		$hashids_ = new \Common\Util\Hashids(md5('t3t2key'), 10);
		$url['url']= "http://url.739wan.cn/".$hashids_->encode($id).".html";
		$this->ajax($url);
    }
}
