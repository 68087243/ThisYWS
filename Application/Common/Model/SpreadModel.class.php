<?php

namespace Common\Model;
use Think\Model;
/**
 * CPS模型
 * @author C0de <47156503@qq.com>
 */
class SpreadModel extends Model{
	
	
	//添加推广记录
    public function AddSpreadUser($mid,$uid,$gid,$sid,$aid){
		if(empty($mid) || empty($uid) || empty($gid)){
			return false;
		}
		
		$data['mid']=$mid;
		$midinfo=$this->where($data)->find();
		if(empty($midinfo)){
			return false;
		}
		$data['uid']=$uid;
		$data['gid']=$gid;
		$spreaduser=M('SpreadUser')->where($data)->find();
		if(empty($spreaduser)){
			$data['sid']=$sid;
			$data['aid']=$aid;
			$data['ctime']=time();
			M('SpreadUser')->add($data);
			return true;
		}else{
			return false;
		}
    }
	
	public function AddSpreadPay($uid,$order,$money){
		$data['uid']=$uid;
		$SpreadUser=M('SpreadUser')->where($data)->find();
		if(empty($SpreadUser)){
			return false;
		}
		$data['mid']=$SpreadUser['mid'];
		$data['aid']=$SpreadUser['aid'];
		$midinfo=$this->where(Array('mid'=>$data['mid']))->find();
		if(empty($midinfo)){
			return false;
		}
		
		$data['order']=$order;
		$data['money']=$money;
		$data['bili_money']=($moeny*$midinfo['bili'])  *  0.01;
		$this->where(Array('mid'=>$data['mid']))->setInc('money',$data['bili_money']);
		$this->where(Array('mid'=>$data['mid']))->setInc('total_money',$data['bili_money']);
		$data['ctime']=time();
		M('SpreadPay')->add($data);
	}

}
