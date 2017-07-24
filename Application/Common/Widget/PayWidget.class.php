<?php

namespace Common\Widget;
use Think\Controller;

class PayWidget extends Controller {

	public function GetPayTypeByUid($uid){
        $map['uid']=$uid;
        $map['paystatus']=2;
		$data=D('Paylog')->where($map)->order('id desc')->find();
		return $data['paytype'];
	}
}






?>