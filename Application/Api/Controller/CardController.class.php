<?php
namespace Api\Controller;
use Think\Controller;

class CardController extends ApiController {



    public function Receivegifts(){
		ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
        $userinfo=session('user_auth');
        $cid=intval(I('cid'));
		$gid=intval(I('gid'));
		$sid=intval(I('sid'));
		$type=I('type');
		$ajax['msg'] = 2;
        if($userinfo && !empty($cid)){
			echo 111;
            $card=D('Card');
            $uid=$userinfo['id'];
            $map['cid']=$cid;
            $map['uid']=$uid;
            $data=$card->where($map)->find();
            if(empty($data)){
                $CardDetail=D('CardDetail')->find($cid);
                if($CardDetail['level'] > $userinfo['vip']){
                    $ajax['msg'] = 2;
                    $ajax['error'] ='抱歉，此礼包只有VIP'.$CardDetail['level'].'的用户可领取!';
                }else {
                    $card_num = $card->where(Array('status' => array('neq', '0'), 'cid' => $cid))->find();
                    $save['status'] = 0;
                    $save['uid'] = $uid;
                    $save['utime'] = time();
                    $card->where(Array('id' => $card_num['id']))->save($save);

                    $ajax['msg'] = 1;
                    $ajax['card'] = $card_num['card'];
                }
            }else{
                $ajax['msg']=0;
                $ajax['card']=$data['card'];
            }
            
        }else if($userinfo && $gid && $sid){
			$_game=D('Game')->find($gid);
			$obj=GetApi($_game['api']);
			if(method_exists($obj,'getCard')){
				$giftlist_mix=D('Mixgift')->where(Array('game'=>$gid,'type'=>$type))->find();
				$_arr=explode("\r\n",$giftlist_mix['parameter']);
				if(is_array($_arr)){
					foreach($_arr as $val){
						$_temp=explode("=",$val);
						$giftlist_mix[$_temp[0]]=$_temp[1];
					}
				}
				if(!empty($giftlist_mix)){
					$_server=D('Gameserver')->find($sid);
					$result=$obj->getCard($_game,$_server,$userinfo,$giftlist_mix);
					if(!$result){
						$ajax['error']='领取失败!可能您已经领取过!';
					}else{
						$ajax['msg'] = 1;
						$ajax['card'] = $result;
					}
				}
            }
			
		}
		$this->ajax($ajax);
    }
}