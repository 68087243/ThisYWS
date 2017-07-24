<?php

namespace Common\Widget;
use Think\Controller;
class GameWidget extends Controller {
    public function RandGame($num,$cache='RandGame'){
        $cache=md5($cache.'_'.$num);
        $obj=D('Game');
        $map['status']=array('eq',1);
        $data=$obj->where($map)->order('rand(),flags desc,id desc')->limit($num)->cache($cache,2000)->select();
        foreach($data as &$val){
            $val['pic']=json_decode($val['pic'],true);
            $val['gameurl']=$obj->getGameUrl($val['id']);
        }
        return $data;
    }
	
	public function isGameCollects($uid,$gid){
		$map['uid']=$uid;
		$map['gid']=$gid;
		if(empty($uid)){
			return false;
		}
		$data=D('GameCollect')->where($map)->find();
		if(empty($data)){
			return false;
		}
		echo 'favok';
	}

    public function Recommendedserver($gid,$num=3,$cache='Recommendedserver'){
        $cache=md5($cache.'_'.$gid.$num);
        $obj=D('Gameserver');
        $map['game']=$gid;
        $map['status']=array('eq',1);
		$map['ktime']=array('lt',time());
        $map['FIND_IN_SET(\'t\',flags)']=array('exp','');
        $data=$obj->where($map)->order('flags desc,id desc')->limit($num)->cache($cache,2000)->select();
        return $data;
    }
	
	//获取某游戏正常且已开服的最新服务器
	public function getNewServerBygid($gid,$num=3,$cache='getNewServerBygid'){
        $cache=md5($cache.'_'.$gid.$num);
        $obj=D('Gameserver');
        $map['game']=$gid;
        $map['status']=array('eq',1);
		$map['ktime']=array('lt',time());
        $data=$obj->where($map)->order('flags desc,id desc')->limit($num)->cache($cache,2000)->select();
		foreach($data as &$val){
            $val['gameurl']=U('Gateway/Game/Play',array('gid'=>$gid,'sid'=>$val['id']));;
            $val['flags']=flags($val['flags']);
        }
        return $data;
    }
	
	//获取某游戏正常的最新服务器
	public function getServerBygid($gid,$num=3,$cache='getServerBygid'){
        $cache=md5($cache.'_'.$gid.$num);
        $obj=D('Gameserver');
        $map['game']=$gid;
        $map['status']=array('eq',1);
        $data=$obj->where($map)->order('flags desc,id desc')->limit($num)->cache($cache,2000)->select();
		foreach($data as &$val){
            $val['gameurl']=U('Gateway/Game/Play',array('gid'=>$gid,'sid'=>$val['id']));;
            $val['flags']=flags($val['flags']);
        }
        return $data;
    }

    //热门游戏
    public function RecommendedGame($flag,$num=3,$cache='RecommendedGame'){
        $cache=md5($cache.'_'.$flag.$num);
        $obj=D('Game');
        $map['status']=array('eq',1);
        $flags="FIND_IN_SET('{$flag}',flags)";
        $map[$flags]=array('exp','');
        $data=$obj->where($map)->order('flags desc,id desc')->limit($num)->cache($cache,2000)->select();
        foreach($data as &$val){
            $val['pic']=json_decode($val['pic'],true);
            $val['gameurl']=$obj->getGameUrl($val['id']);
            $val['flags']=flags($val['flags']);
        }
        return $data;
    }

    public function GameNews($gid,$num=3,$cache='GameNews'){
        $cache=md5($cache.'_'.$gid.$num);
        $obj=D('DocumentExtendArticle');
        $map['typegame']=$gid;
        $map['status']=array('eq',1);
        return $obj->where($map)->order('id desc')->limit($num)->cache($cache,2000)->select();
    }


    public function gameplayByuid($uid,$num,$cache='gameplayByuid'){
        $cache=md5($cache.'_'.$uid.$num);
        $map['uid']=$uid;
        $obj=D('Gameplay');
        $play=$obj->where($map)->order('ztime desc,id desc')->limit($num)->group('gid')->cache($cache,2000)->select();
        foreach($play as &$val){
            $data=D('Game')->where(Array('id'=>$val['gid']))->find();
            $val['name']=$data['name'];
            $val['pic']=json_decode($data['pic'],true);
            $val['gid']=$data['id'];
        }
        return $play;
    }


    public function gameplayJsonByuid($uid,$num,$cache='gameplayJsonByuid'){
        $cache=md5($cache.'_'.$uid.$num);
        $map['uid']=$uid;
        $obj=D('Gameplay');
        $play=$obj->where($map)->order('ztime desc,id desc')->limit($num)->cache($cache,2000)->select();
        $array=Array();
        foreach($play as &$val){
            $data['_id']=$val['id'];
            $data['sid']=$val['sid'];
            $data['gid']=$val['gid'];
            $array[$val['gid']][]=$data;
        }
        return json_encode($array);
    }

}






?>