<?php
namespace Pay\Controller;
use Think\Controller;
use Common\Util;

class OrdersController extends PayController {


    protected function _initialize(){
        parent::_initialize();
        $userinfo=session('user_auth');
        if(empty($userinfo)){
            $this->redirect('User/Public/login');
        }
    }

    //创建订单
    public function index(){
        $info=$this->createorders();
        $this->ajax($info);
    }
	

	

    private function createorders(){
        $userinfo=session('user_auth');
        $ajax['msg']='success';
        $save['platform']=I('payto');//充值到
        $save['order']=build_order_no();//订单号
        $save['uid']=$userinfo['id'];//提交订单的UID
        //读取充值用户信息
        $save['paytoname']=I('g_username');//充值的用户名
        $_user=D('User')->where(Array('username'=>$save['paytoname']))->find();//查询用户名
        if(empty($_user)){
            $ajax['msg']='抱歉，用户不存在!';
            return $ajax;
        }
        //读取充值渠道信息
        $save['paytype']=I('paytype');//支付渠道标签
        $_pay=D('Paytype')->where(Array('tag'=>$save['paytype']))->find();//查询支付渠道是否存在
        if(empty($_pay)){
            $ajax['msg']='抱歉，渠道错误!';
            return $ajax;
        }
        //判断是否银行
        if($_pay['bank']){
            $save['paybank']=I('paybank');
			if(empty($save['paybank'])){
				$ajax['msg']='请选择银行!';
				return $ajax;
			}
        }
		//判断是否卡类
		if($_pay['iscard']){
            $save['paycardid']=I('paycardid');
			$save['paycardpass']=I('paycardpass');
			if(empty($save['paycardid']) || empty($save['paycardpass'])){
				$ajax['msg']='请输入完整卡号信息!';
				return $ajax;
			}
        }
        //充值金额判断
        $save['payamount']=intval(I('cash'));//充值金额
        if($_pay['money']){
            $ismoney=false;
            $money=explode("\r\n",$_pay['money']);
            foreach($money as $val){
                if($val == $save['payamount']){
                    $ismoney=true;
                }
            }
            if(!$ismoney){
                $ajax['msg']='禁止擅自篡改金额!';
                return $ajax;
            }
        }
        //最小充值金额判断
        if($_pay['least'] > $save['payamount']){
            $ajax['msg']='最小充值金额为'.$_pay['least'].'!';
            return $ajax;
        }
		
		//最小充值金额判断
        if($_pay['most'] < $save['payamount']){
            $ajax['msg']='最大充值金额为'.$_pay['most'].'!';
            return $ajax;
        }

        //支付渠道手续费判断
        if(empty($_pay['fee'])){
            $_pay['fee']=1;
        }
        switch($save['platform']) {
            case "1":
                //充值到平台币
                //兑换后的虚拟币数量计算
				$obj=new \Common\Util\Pay('Kdpay');
                    if(!$obj->payer->getPayType($save['paytype'])){
                        $ajax['msg']='不适用此支付渠道，请更换!';
                        return $ajax;
                    }
                $save['virtualamount']=$save['payamount'] * (C('CURRENCY_RATE')*$_pay['fee']);
                //手续费计算
                $save['fee']=$save['payamount'] - ($save['payamount'] * $_pay['fee']);
                break;
            case "0":
                //充值到游戏
                $save['gameid']=intval(I('gid'));//充值游戏id
                $save['serverid']=intval(I('sid'));//充值游戏服务器id
                //游戏服务器判断
                $_game=D('Game')->find($save['gameid']);//读取游戏信息
                if(empty($_game)){
                    $ajax['msg']='游戏不存在!';
                    return $ajax;
                }
                $obj=GetApi($_game['api']);
                if(method_exists($obj,'getPayType')){
                    if(!$obj->getPayType($save['paytype'])){
                        $ajax['msg']='此游戏不适用此支付渠道，请更换!';
                        return $ajax;
                    }
                }
				if($save['paytype'] == '_syspay'){
					$_temp_user=D('User')->find($userinfo['id']);
					$_c_money=$save['payamount']*C('CURRENCY_RATE');
					if($_c_money>$_temp_user['money']){
						$ajax['msg']=C('CURRENCY_NAME').'不足，请充值!';
                        return $ajax;
					}
				}
                $_server=D('Gameserver')->where(Array('game'=>$save['gameid'],'id'=>$save['serverid']))->find();
                if(empty($_server)){
                    $ajax['msg']='游戏服务器不存在!';
                    return $ajax;
                }
                //兑换后的虚拟币数量计算
                $save['virtualamount']=$save['payamount'] * ($_game['rate']*$_pay['fee']);
                //手续费计算
                $save['fee']=$save['payamount'] - ($save['payamount'] * $_pay['fee']);
                $save['role']=I('rolename');//角色信息
				$_user['temp_role']=I('rolename');
                S($save['order'].'_paycache',Array($_game,$_server,$_user));
                break;
        }
        $save['ip']=get_client_ip();
        $save['ctime']=time();
        $save['paystatus']=1;
        session('paydata',$save);//将支付数据临时存于session中，将在支付调用中触发写进数据库
        //D('Paylog')->add($save);
        $ajax['id']=$save['order'];
        return $ajax;
    }


    public function pay(){
        $userinfo=session('user_auth');
        $order=I('orders');
        $map['uid']=$userinfo['id'];
        $map['order']=$order;
        $data=D('Paylog')->where($map)->find();
        if(!empty($data)){
            if($data['paystatus'] != 1){
                $this->redirect('Pay/index/index',Array('_p=p1'));
            }
        }else{
            $data=session('paydata');
            if($data['order'] != $order){
                $this->redirect('Pay/index/index',Array('_p=p2'));
            }

            if($data['paytype'] == '_syspay' && $data['platform']==1 || $data['paytype'] == '_sysrgpay' ){
                $this->redirect('Pay/index/index',Array('_p=p3'));
            }
            D('Paylog')->add($data);
        }
        switch($data['platform']){
            case "1":
                $this->paytoplatform($data);
                break;
            case "0":
                $this->pattogame($data);
                break;
        }
    }

    //充值到平台调用
    private function paytoplatform($data){
		$paytype=M('Paytype')->where(Array('tag'=>$data['paytype']))->find();
		$data['notify_url']=U('Pay/Request/platform_notify');
		$data['return_url']=U('Pay/Request/platform');
		$data['subject']=C('CURRENCY_NAME').'充值';
		echo Payapi($paytype['payapi'])->payer->buildRequestForm($data);
    }


    //充值到游戏调用
    private  function pattogame($data){
		$userinfo=session('user_auth');
        $cache=S($data['order'].'_paycache');
		$obj=GetApi($cache[0]['api']);
		if($data['paytype']== '_syspay' ){
			if(method_exists($obj,'_pay')){
			  $map['order']=$data['order'];
			  $map['paystatus']=1;
			  $datas['utime']=time();
			  $paylog=D('Paylog')->where($map)->find();
			  if($paylog['paystatus']==1){
				  if($obj->_pay($data,$cache[0],$cache[1],$cache[2])){
					  $datas['paystatus']=2;
					  $datas['remark']='已到账';
					  D('User')->numEdit(Array('id'=>$userinfo['id']),'money',$data['payamount'],'-');
					  D('ScoreLog')->addLog($userinfo['id'],$data['payamount'],"1","-",'充值');
				  }else{
					  $datas['remark']='未到账';
					  $datas['paystatus']=2;
				  }
				D('Paylog')->callback_($datas,$map,$paylog);
			  }
			  $this->redirect('Pay/return/index');
            }else{
				die('obj error');
			}
		}else{
			if(method_exists($obj,'pay')){
			  $data['subject']=$cache[0]['name'].'充值'.$data['payamount'].'元'.$cache[0]['unit'];
              $obj->pay($data,$cache[0],$cache[1],$cache[2]);
            }else{
				die('obj error');
			}
		}
    }


}