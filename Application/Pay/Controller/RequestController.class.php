<?php
namespace Pay\Controller;
use Think\Controller;
use Common\Util;
use Common\Util\Pay\Driver;
class RequestController extends PayController {


    public function notify($type){
		//\Think\Log::write(http_build_query($_GET),'WARN');
		if(strstr($type,"platform")){
			$map['order']=getOrder();
			$map['paystatus']=1;
			$paylog=D('Paylog')->where($map)->find();
			$paytype=M('Paytype')->where(Array('tag'=>$paylog['paytype']))->find();
			$obj=Payapi($paytype['payapi']);
			if($obj->payer->signCheck() && $paylog['paystatus']==1){
				$datas['utime']=time();
				$datas['paystatus']=2;
				$user=D('User');
				$userinfo=$user->where(Array('username'=>$paylog['paytoname']))->find();
				$user->numEdit(Array('username'=>$paylog['paytoname']),'money',$paylog['virtualamount'],'+');
				D('ScoreLog')->addLog($userinfo['id'],$paylog['payamount'],"1","+",'充值');
				D('Paylog')->callback_($datas,$map,$paylog);
			}

			switch($type){
					case 'platform':
						$this->redirect('Pay/return/index');
					break;
					case 'platform_notify':
						$obj->payer->notify_echo();
					break;
			}
		}else{
			$type=explode("_",$type);
			$api=M('Gameapi')->where(Array('tag'=>$type[0]))->find();
			if(empty($api)){
				$this->redirect('Pay/index/index');
				die('error');
			}
			$obj=Getapi($api['id']);
			if(method_exists($obj,'checkPay')){
				 $data=$this->payCheck($obj,$type[1]);
				 switch($data['status']){
					 case 1:$tip=$data['tip'][1];break;
					 default:$tip=$data['tip'][2];break;
					 }
				if($data['sign']){
					if(!empty($data['paylog']['identification'])){
						$this->mix_callback_notify($data['paylog']);
					}
					echo $tip;
					
				}else{
					if(!empty($data['paylog']['identification'])){
						$this->mix_callback_result($data['paylog']);
					}else{
						$this->redirect('Pay/return/index');
					}
					
				}
			}else{
				$this->redirect('Pay/return/index');
			}
		}
    }
	
	//混服异步回调通知对方
	private function mix_callback_notify($paylog){
		$mixuser_obj=M('MixUser');
		$mixuser=$mixuser_obj->find($paylog['identification']);
		if(empty($mixuser['notify_pay'])){
			return true;
		}
		$start['order']=$paylog['identification_order'];
		$start['money']=intval($paylog['payamount']);
		$start['time']=time();
		$start['status']=1;
		$pay_key=MixSignKey($paylog['identification'],"PAY");
		$start['sign']=md5($start['order'].$start['money'].$start['time'].$start['status'].$pay_key);
		
		$mixuser_obj->where(Array('id'=>$paylog['identification']))->setInc('money',$paylog['identification_money']);
		$mixuser_obj->where(Array('id'=>$paylog['identification']))->setInc('total_money',$paylog['identification_money']);
		$mixuser_obj->where(Array('id'=>$paylog['identification']))->setInc('recharge',$paylog['payamount']);
		$mixuser_obj->where(Array('id'=>$paylog['identification']))->setInc('total_recharge',$paylog['payamount']);
		$data=\Org\Net\HttpCurl::get($mixuser['notify_pay'],$start);
		
	}
	
	//混服跳转
	private function mix_callback_result($paylog){
		$mixuser=D('MixUser')->find($paylog['identification']);
		if(empty($mixuser['notify_pay'])){
			return true;
		}
		$start['order']=$paylog['identification_order'];
		$start['money']=intval($paylog['payamount']);
		$start['time']=time();
		$start['status']=1;
		$pay_key=MixSignKey($paylog['identification'],"PAY");
		$start['sign']=md5($start['order'].$start['money'].$start['time'].$start['status'].$pay_key);
		header("Location:".$mixuser['notify_pay'].'?'.http_build_query($start)); 
	}
	
	private function payCheck($obj,$sign=false){
		$map['order']=$obj->getPayOrder();
		$map['paystatus']=1;
		$save['utime']=time();
		$status=3;
		//上锁
		$lock = new \Common\Util\CacheLock($map['order'],LOCK_PATH);
		$lock->lock();
		$paylog=D('Paylog')->where($map)->cache(false)->find();
		if(empty($paylog)){
			//状态为1的订单已不存在
			$status=-1;
		}else{
			//状态为1的订单存在
			$save['paystatus']=2;
			//第三方SIGN验证
			$result=$obj->checkPay($paylog,$sign);
			if($result){
				//支付检查成功，更新订单
				$status =1;
				$save['remark']=$result;
				D('Paylog')->callback_($save,$map,$paylog);
			}
		}
		$lock->unlock();
		//解锁
		$tip=$obj->getPayTip($paylog);
		return Array('status'=>$status,'sign'=>$sign,'tip'=>$tip,'paylog'=>$paylog);
	}
	
	public function jump(){
		$this->redirect('Pay/return/index');
	}
	
	public function _empty($type){
		$this->notify($type);
	}

   


}