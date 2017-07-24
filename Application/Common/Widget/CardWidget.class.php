<?php

namespace Common\Widget;
use Think\Controller;
class CardWidget extends Controller {

    public function RandGift($num,$cache='RandGift'){
        $cache=md5($cache.'_'.$num);
        $obj=D('CardDetail');
        $map['status']=array('eq',1);
        $data=$obj->distinct(true)->where($map)->order('rand(),flags desc,id desc')->field('gid')->limit($num)->cache($cache,2000)->select();
        foreach($data as &$val){
            $val=D('Game')->where(Array('id'=>$val['gid']))->find();
            $val['pic']=json_decode($val['pic'],true);
            $val['gameurl']=U('Gift/'.$val['mark'].'/index');
        }
        return $data;
    }

    public function GetGift($num=3,$flags=false,$cache='TopGift'){
        $cache=md5($cache.'_'.$flags.$num);
        $obj=D('CardDetail');
        $map['status']=array('eq',1);
        if(!empty($flags)){
            $flags="FIND_IN_SET('{$flags}',flags)";
            $map[$flags]=array('exp','');
        }
        $data=$obj->where($map)->order('flags desc,id desc')->limit($num)->group('gid')->cache($cache,2000)->select();
        foreach($data as &$val){
            $game=D('Game')->where(Array('id'=>$val['gid']))->find();
            $temp['pic']=json_decode($game['pic'],true);
            $temp['gameurl']=U('Gift/'.$game['mark'].'/index');
            $temp['flags']=flags($game['flags']);
            $temp['name']=$game['name'];
            $val=array_merge($val,$temp);
        }
		$giftlist_mix=D('Mixgift')->limit($num)->order('sort desc,id desc')->cache($cache."_Mixgiflist",2000)->select();
		foreach($giftlist_mix as &$val){
			$game=D('Game')->where(Array('id'=>$val['game']))->find();
            $temp['pic']=json_decode($game['pic'],true);
            $temp['gameurl']=U('Gift/'.$game['mark'].'/index');
            $temp['flags']=flags($game['flags']);
            $temp['name']=$game['name'];
			$val['description']=$val['describe'];
            $val=array_merge($val,$temp);
		}
		$datas=array_merge($data,$giftlist_mix);
        return $datas;
    }



}






?>