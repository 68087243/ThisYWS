<?php
namespace Api\Controller;
use Think\Controller;

class GameController extends ApiController {


	public function mysj(){
		//exit;
	  $paylog['serverid']="559";
	  $paylog['paytoname']="转身☆已是过去°";
	  $paylog['order']="2016213".time();
	  $paylog['virtualamount']="80000000";
	  $pay['payamount']="1";
	  $obj=GetApi(3);
	var_dump($obj->_pay($paylog));
	
	
	
	}
	
	public function api(){
		if(IS_POST){
            $obj=GetApi(intval($_POST['id']));
            if(method_exists($obj,$_POST['action'])){
				unset($_POST['id']);
				$_POST['ctime']=time();
				M('GameapiLog')->add($_POST);
                $obj->$_POST['action']($_POST);
            }
			echo "OK";
        }else{
			$id=intval(I('id'));

			if($id){
				
				$obj=GetApi($id);
				$action=Array();
				if(method_exists($obj,'_extend_admin_api')){
					$action=$obj->_extend_admin_api();
				}else{
					die("exit;");
				}
				$Game=Array();
				foreach(D('Game')->where(Array('api'=>$id))->select() as $val){
					$Game[$val['id']]=$val['name'];
				}
				$this->assign("game",$Game);
				$this->assign("action",$action);
				$this->display("api");
			}
			
		}
		
		
	}
	
	

    public function GetPlayedList(){
        //我玩过的接口  表 Gamelog
        $userinfo=session('user_auth');
        if(session('user_auth')){
            $array=Array();
            $array['code']=0;
            $map['uid']=$userinfo['id'];
            $map['status']=array('eq',1);
            $obj=D('Gameplay');
            $play=$obj->where($map)->order('ztime desc,id desc')->select();
            $array['data']=Array();
            foreach($play as $key=>$val){
                $data=Array();
                $_obj_game=M('Game')->where(Array('id'=>$val['gid']))->find();
                $_obj_game_pic=json_decode($_obj_game['pic'],true);
                $data['gpic']=get_cover($_obj_game_pic['pic_icon_max']);
                $data['gname']=$_obj_game['name'];
                $data['glink']=D('Game')->getGameUrl($_obj_game['id']);
                $data['gid']=$val['gid'];
                $data['sid']=D('Gameserver')->getGameServerIdByGidSid($val['gid'],$val['sid']);
                $data['play_time']=$val['ztime'];
                $data['server_url']=U('Gateway/Game/Play',array('gid'=>$val['gid'],'sid'=>$val['sid']));
                $data['playNums']=1;
                $data['likeNums']=1;
                $data['sortid']=14;
                $data['sortname']='RPG';
                $data['isWebGame']=1;
                $array['data'][]=$data;
            }
            $this->ajax($array);
        }
    }

    public function GetServer(){
        $gid=intval(I('gid'));
        if($gid){
            $game=D('Game')->find($gid);
            if(!empty($game)){
                $array['id']=$gid;
                $array['game_name']=$game['name'];
                $array['currency']=$game['rate'];
                $array['money_cn']=$game['unit'];
                $array['servers']=Array();
                $map['game']=$gid;
                $map['status']=array('eq',1);
				$map['ktime']  = array('elt',time());
                $server=D('Gameserver')->where($map)->order('id desc')->select();
                foreach($server as $val){
                    $array['servers'][]=Array(
                        'sid'=>$val['id'],
                        's_name'=>$val['name']
                    );
                }
                $this->ajax($array);
            }
        }
    }

    public function GetRole(){
        $gid=intval(I('gid'));
        $sid=intval(I('sid'));
        $username=I('username');
        $userinfo=session('user_auth');
        if($userinfo['username'] == $username){
            $uid=$userinfo['id'];
        }else{
			$userinfo=D('User')->where(Array('username'=>$username))->find();
			if(empty($userinfo)){
				$userinfo['id']=false;
			}
        }
		$uid=$userinfo['id'];
        if($gid && $sid && $uid){
            $map['uid']=$uid;
            $map['gid']=$gid;
            $map['sid']=$sid;
			$gameplay=D('Gameplay');
            $data=$gameplay->where($map)->find();
            if(!empty($data)){
				$game=D('Game')->find($gid);
				$server=D('Gameserver')->where(Array('game'=>$game['id'],'id'=>$sid))->find();
				$ajax['error']=0;
				$ajax['name']=$game['mark'];
				if(empty($data['rolename'])){
				$obj=GetApi($game['api']);
					if(method_exists($obj,'checkRole')){
						$role=$obj->checkRole($game,$server,$userinfo);
						if(!$role){
							$ajax['error']=1;
							$ajax['msg']='该帐号尚未创建角色,请确认后充值';
						}else{
							$gameplay->where($map)->save(Array('rolename'=>$role));
							$ajax['name']=$role;
						}
					}
				}else{
					$ajax['name']=$data['rolename'];
				}
                
            }else{
                $ajax['error']=1;
                $ajax['msg']='该帐号尚未创建角色,请确认后充值';
            }
        }
		 $this->ajax($ajax);
    }

    public function RecGames(){
        $obj=D('Game');
        $map['status']=array('eq',1);
        $data=$obj->where($map)->order('rand(),flags desc,id desc')->limit(8)->cache('RecGames',60)->select();
        $array=Array();
        foreach($data as $key=>$val){
            $_data=Array();
            $_data['name']=$val['name'];
            $_data['url']=D('Game')->getGameUrl($val['id']);
            $_obj_game_pic=json_decode($val['pic'],true);
            $_data['img']=get_cover($_obj_game_pic['pic_r']);
            $array[]=$_data;
        }
        $this->ajax($array);
    }


    public function getcollects(){
        $userinfo=session('user_auth');
        if($userinfo){
            $array=Array();
            $array['code']=0;
            $map['uid']=$userinfo['id'];
            $obj=D('GameCollect');
            $collects=$obj->where($map)->order('id desc')->select();
            $array['data']=Array();
            foreach($collects as $key=>$val){
                $data=Array();
                $_obj_game=M('Game')->where(Array('id'=>$val['gid']))->find();
                $_obj_game_pic=json_decode($_obj_game['pic'],true);
                $data['pic']=get_cover($_obj_game_pic['pic_icon_max']);
                $data['title']=$_obj_game['name'];
                $data['link']=D('Game')->getGameUrl($_obj_game['id']);
                $data['gid']=$val['gid'];
                $array['data'][]=$data;
            }
           // for($i=0;$i<=100;$i++){
          //      $array['data'][]=$array['data'][0];
          //  }
            $this->ajax($array);
        }
    }

    public function gameCollects(){
        $userinfo=session('user_auth');
        if(session('user_auth')){
            $obj=D('GameCollect');
			$gid=intval(I('gid'));
            $map['uid']=$userinfo['id'];
			if(I('uid') && empty($gid)){
				$array['code']=2;
				$array['data']='清空全部成功';
				$obj->where($map)->delete();
			}else{
				$map['gid']=$gid;
				$data=$obj->where($map)->find();
				if(empty($data)){
					$map['ctime']=time();
					$array['code']=0;
					$array['data']='收藏成功';
					$obj->add($map);
				}else{
					$array['code']=1;
					$array['data']='取消收藏成功';
					$obj->where($map)->delete();
				}
			}
            $this->ajax($array);
        }
    }





    public function gameRecommend(){
        //$data=M("Game t1")->join('(SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `'.C('DB_PREFIX').'Game`)-(SELECT MIN(id) FROM `'.C('DB_PREFIX').'Game`))+(SELECT MIN(id) FROM `'.C('DB_PREFIX').'Game`)) AS id) as t2')->where("t1.id >= t2.id")->order('t1.id')->limit(34)->select();
        $obj=D('Game');
        $map['status']=array('eq',1);
        $data=$obj->where($map)->order('rand(),id desc')->limit(35)->cache('gameRecommend',60)->select();
        $num=count($data);
        $array=Array();
        if($num<4){
            foreach($data as $key=>$val){
                $_data=array();
                $_obj_game_pic=json_decode($val['pic'],true);
                $_data['pic']=get_cover($_obj_game_pic['pic_icon_max']);
                $_data['url']=D('Game')->getGameUrl($val['id']);
                $_data['title']=$val['name'];
                $array['gameplay'][]=$_data;
            }
            $array['collects']=Array();
        }else{
            $xh=$num/2;
            $i=0;
            foreach($data as $key=>$val){
                $_data=array();
                $_obj_game_pic=json_decode($val['pic'],true);
                $_data['pic']=get_cover($_obj_game_pic['pic_icon_max']);
                $_data['url']=D('Game')->getGameUrl($val['id']);
                $_data['title']=$val['name'];
                unset($data[$key]);
                $array['gameplay'][]=$_data;
                $i++;
                if($i==$xh || $i==21){
                    break;
                }
            }
            $i=0;
            foreach($data as $key=>$val){
                $_data=array();
                $_obj_game_pic=json_decode($val['pic'],true);
                $_data['pic']=get_cover($_obj_game_pic['pic_icon_max']);
                $_data['url']=D('Game')->getGameUrl($val['id']);
                $_data['title']=$val['name'];
                $array['collects'][]=$_data;
                $i++;
                if($i==14){
                    break;
                }
            }
        }
        $this->ajax($array);
    }



    public function ajaxServerlist(){
        if(I('type')=='jjkf'){
            $map['ktime']  = array('egt',time());
			$order="FROM_UNIXTIME(`ktime`,'%Y-%m-%d') ASC,id desc";
        }else{
            $map['ktime']  = array('elt',time());
			$order="FROM_UNIXTIME(`ktime`,'%Y-%m-%d') DESC,id desc";
        }
        $map['status'] = array('eq', 1);
        $data=D('Gameserver')->where($map)->limit(50)->order($order)->cache('ajaxServerlist_'.I('type'),60)->select();
        $data_list=array();
        foreach($data as $key=>$val){
            $data_list[$key]['d']=retime($val['ktime']);
            $data_list[$key]['t']=date("H:i",$val['ktime']);
            $game_map['id']=$val['game'];
            $game=D('Game')->where($game_map)->find();
            $data_list[$key]['n']=$game['name'];
            $data_list[$key]['f']=$val['name'];
            $data_list[$key]['g']=D('Game')->getGameUrl($game['id']);
            $pic=json_decode($game['pic']);
            $data_list[$key]['i']= get_cover($pic->pic_l);
            $data_list[$key]['x']=U('Gateway/Game/Play',array('gid'=>$val['game'],'sid'=>$val['id']));
            $data_list[$key]['ne']=false;
            $data_list[$key]['r']=false;
            $data_list[$key]['hot']=false;
            if(!empty($val['flags'])){
                $flags=flags($val['flags']);
                if(!empty($flags)){
                    if($flags['x']){
                        $data_list[$key]['ne']=true;
                    }
                    if($flags['r']){
                        $data_list[$key]['hot']=true;
                    }
                    if($flags['j']){
                        $data_list[$key]['r']=true;
                    }
                }
            }else{
                if(!empty($game['flags'])){
                    $flags=flags($game['flags']);
                    if(!empty($flags)){
                        if($flags['x']){
                            $data_list[$key]['ne']=true;
                        }
                        if($flags['r']){
                            $data_list[$key]['hot']=true;
                        }
                        if($flags['j']){
                            $data_list[$key]['r']=true;
                        }
                    }
                }
            }
        }
        $this->ajax($data_list);
    }




    public function ajaxGameServerBygid(){
        $gid=I('gid');
        if(!empty($gid)){
            $map['game']=$gid;
            $this->ajaxReturn(D('Gameserver')->where($map)->field('id,game,name,gid,sid,line,flags,ktime,status')->select());
        }

    }

    //导航热门游戏
    public function whole(){
        $map['status'] = array('eq', 1);
        $data=D('Game')->where($map)->select();
        foreach($data as $key=>$val){
            if(!empty($val['flags'])){
                $flags=flags($val['flags']);
                if(!empty($flags)){
                    $data[$key]['biaozhu']=1;
                }else{
                    $data[$key]['biaozhu']="";
                }
            }
            $data[$key]['redirect_url']=D('Game')->getGameUrl($val['id']);
            $data[$key]['create_time']=strtotime($val['ctime']);
            $data[$key]['update_time']=strtotime($val['utime']);
            $data[$key]['hot']=0;
            $data[$key]['new']=0;
        }

        $array=Array('msg'=>'1','list'=>$data);
        $this->ajax($array);
    }

    //获取某游戏所有服务器
    public function getLastestServers(){
        $gid=I('gid');
        if(empty($gid)){
            $this->ajax(Array('msg'=>-1));
        }
        //$map['status'] = array('eq', 1);
        $map['game']=I('gid');
		//$map['ktime']=array('lt',time());
        $data=D('Gameserver')->where($map)->order('id desc')->select();
        $array=Array();
        $sort=count($data);
        foreach($data as $val){
            $_temp['id']=$gid;
            $_temp['url']=U('Gateway/Game/Play',array('gid'=>$gid,'sid'=>$val['id']));
            $_temp['name']=$val['name'];
            $_temp['sid']=$val['id'];
            $_temp['pages']=0;
			$_temp['status']=$val['status'];
			$_temp['kstatus']=(($val['ktime']-time()) >= 1)? '0' : '1';
            $_temp['sort']=$sort--;
            $array[]=$_temp;
        }
        $this->ajax($array);
    }

    public function getLastestPlayed(){
        $gid=I('gid');
        $userinfo = session('user_auth');
        if(empty($gid) || empty($userinfo)){
            $this->ajax(Array('msg'=>-1));
        }
        $map['uid']=$userinfo['id'];
        $map['gid']=$gid;
        $data=D('Gameplay')->where($map)->order('id desc')->select();
        $array=Array();
        foreach($data as $val){
            $_temp['url']=U('Gateway/Game/Play',array('gid'=>$val['gid'],'sid'=>$val['sid']));
            $name=D('Gameserver')->getColumnByfield('name',Array('game'=>$val['gid'],'id'=>$val['sid']));
            $_temp['name']=$name;
            $array[]=$_temp;
        }
        $this->ajax($array);
    }
	public function getGameserverUrl(){
		$gid=I('gid');
		$sid=I('sid');
		if($gid && $sid){
			$map['game']=$gid;
			$map['sid']=$sid;
			$data=D('Gameserver')->where($map)->find();
			if($data){
				$this->ajax(Array('url'=>U('Gateway/Game/Play',array('gid'=>$gid,'sid'=>$data['id']))));
			}
			
		}
		
		
		
		
		
		
	}




}