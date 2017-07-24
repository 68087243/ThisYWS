<?php

namespace Mix\Controller;
use Think\Controller;
use Common\Util;

class MainController extends MixController{

	protected function _initialize(){
        parent::_initialize();
        if(ACTION_NAME != 'login'){
			$mixadmin=session('mixadmin');
			if(empty($mixadmin)){
				$this->redirect('Mix/Main/login');
			}else{
				$this->assign('mixinfo',M('MixUser')->find(session('mixmid')));
			}
		}
    }
	
	
    public function index(){
		$this->display();
    }
	
	public function operate_index(){
		$mixmid=session('mixmid');
		$map['identification']=$mixmid;
		$map['paystatus']=2;
		
		$paylog=M('Paylog');
		$payinfo['recharge']=$paylog->where($map)->sum('payamount')?:0;//总充值
		$payinfo['money']=$paylog->where($map)->sum('identification_money')?:0;//总收益
		
		$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
		$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
		$map['utime'] = array(
                array('egt', $beginToday),
                array('lt', $endToday)
        );
		
		$payinfo['today_recharge']=$paylog->where($map)->sum('payamount')?:0;//今日充值
		$payinfo['today_money']=$paylog->where($map)->sum('identification_money')?:0;//今日收益
		
		$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
		$endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
		$map['utime'] = array(
                array('egt', $beginLastweek),
                array('lt', $endLastweek)
        );
		$payinfo['Lastweek_recharge']=$paylog->where($map)->sum('payamount')?:0;//本周充值
		$payinfo['Lastweek_money']=$paylog->where($map)->sum('identification_money')?:0;//本周收益
		
		$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
		$map['utime'] = array(
                array('egt', $beginThismonth),
                array('lt', $endThismonth)
        );
		$payinfo['Thismonth_recharge']=$paylog->where($map)->sum('payamount')?:0;//本周充值
		$payinfo['Thismonth_money']=$paylog->where($map)->sum('identification_money')?:0;//本周收益
		
		$mixnews=M('MixNews');
		$where['gid']  = array('EQ',0);
		$pt_list=$mixnews->where($where)->limit(10)->order('id desc')->select();
		$where['gid']  = array('NEQ',0);
		$game_list=$mixnews->where($where)->limit(10)->order('id desc')->select();
		
		$this->assign('payinfo',$payinfo);
		$this->assign('pt_list',$pt_list);
		$this->assign('game_list',$game_list);
		$this->assign('data',M('Mix')->find(1));
		$this->display();
	}
	
	public function operate_ask(){
		if(IS_POST){
			$_POST['mid']=session('mixmid');
			$_POST['clstatus']='未回复';
			$object = D('MixAsk');
            $data = $object->create();
            if($data){
                $id = $object->add();
                $ajax['success']=true;
            }else{
                $this->error($object->getError());
            }
			$this->ajax($ajax);
		}else{
			
			$this->display();
		}
		
		
		
		
	}
	
	public function operate_lncharge(){
		if(IS_POST){
			$_POST['mid']=session('mixmid');
			$_POST['clstatus']='未处理';
			$object = D('MixLncharge');
            $data = $object->create();
            if($data){
                $id = $object->add();
                $ajax['success']=true;
            }else{
                $this->error($object->getError());
            }
			$this->ajax($ajax);
		}else{
			
			$this->display();
		}
	}
	
	public function operate_settlement(){
		if(IS_POST){
			$ajax['success']=true;
			$mixinfo=session('mixinfo');
			$_POST['mid']=session('mixmid');
			$_POST['clstatus']='未处理';
			if($_POST['money'] < 500){
				$ajax['success']=false;
				$ajax['msg']='最低提现额度500!';
			}
			if($_POST['money'] > $mixinfo['money']){
				 $ajax['success']=false;
				 $ajax['msg']='抱歉，您的余额不足!';
			}
			if(empty($_POST['money'])){
				$ajax['success']=false;
				$ajax['msg']='请填写提现金额!';
			}
			
			$_POST['ctime']=time();
			
			$object = D('MixSettlement');
			$data_=$object->where(Array('clstatus'=>'未处理','mid'=>$_POST['mid']))->find();
			if(!empty($data_)){
				 $ajax['success']=false;
				 $ajax['msg']='抱歉，您已有提现正在申请中，暂不能继续申请!';
			}
            $data = $object->create();
            if($data && $ajax['success']){
                $id = $object->add();
            }
			$this->ajax($ajax);
		}else{
			
			$this->display();
		}
	}
	
	public function operate_agent(){
		$mid=session("mixmid");
		if(IS_POST){
			$_POST['mid']=$mid;
			$object = D('MixUserGame');
			
			
			$data_=$object->where(Array('gid'=>$_POST['gid'],'mid'=>$_POST['mid']))->find();
			
            $data = $object->create();
            if($data){
				if(empty($data_)){
					$id = $object->add();
					if($id){
						$this->success('代理成功');
					}else{
						$this->error('代理失败');
					}
				}else{
					$id=$object->where(Array('id'=>$data_['id']))->save($_POST);
					if($id){
						$this->success('保存成功');
					}else{
						$this->error('保存失败');
					}
					
					
				}
               
            }else{
                $this->error($object->getError());
            }
			
			
			
		}else{
			$gid=intval(I('gid'));
			$game=M('Game')->find($gid);
			$map['mid']=$mid;
			$map['gid']=$gid;
			$mixusergame=M('MixUserGame')->where($map)->find();
			$this->assign("mixusergame",$mixusergame);
			$this->assign("game",$game);
			$this->display();
		}
	}
	
	public function operate_game_json(){
		$mid=session('mixmid');
		$map['status']=1;
		if(I('name')){
			$_map['name']=array('like','%'.I('name').'%');
			$_game=M('Game')->where($_map)->select();
			if(!empty($_game)){
				$mix_game_tmp=Array();
				foreach($_game as $_val){
					$mix_game_tmp[]=$_val['id'];
				}
				$in=implode(',',$mix_game_tmp);
				$map['gid'] = array('in',$in);
			}
		}
		$p=!empty($_GET["pageIndex"])?$_GET["pageIndex"]+1:1;
		$data=M('MixGame')->page($p, 30)->where($map)->order('id desc')->select();
		$count=M('MixGame')->where($map)->order('id desc')->count();
		$paylog_obj=M('Paylog');
		foreach($data as &$val){
			$game=M('Game')->find($val['gid']);
			$val['name']=$game['name'];
			$val['server_count']=M('Gameserver')->where(Array('game'=>$val['gid']))->count();
			
			$paylog_map=Array('paystatus'=>2,'gid'=>$val['gid'],'identification'=>$mid);
			
			$val['pay_count']=$paylog_obj->where($paylog_map)->count();//充值笔数
			$val['pay_row_count']=M('Paylog')->distinct(true)->field('uid')->where($paylog_map)->count();//充值人数
			$val['payamount_count']=$paylog_obj->where($paylog_map)->sum('payamount')?:0;//充值金额
			$val['identification_money_count']=M('Paylog')->where($paylog_map)->sum('identification_money')?1:0;//收益
			$val['reg_count']=M('Paylog')->where(Array('paystatus'=>2,'gid'=>$val['gid'],'identification'=>$mid))->count();
			if(M('MixUserGame')->where(Array('gid'=>$val['gid'],'mid'=>$mid))->count()==0){
				$val['isdl']='未代理';
			}else{
				$val['isdl']='<font style="color:#1D00FF;">已代理</font>';
			}
		}
		$ajax['rows']=$data;
		$ajax['results']=$count;
		$this->ajax($ajax);
		
		
		
		
	}
	
	public function operate_server_json(){
		$mid=session('mixmid');
		$gid=intval(I('gid'));
		$map['game']=$gid;
		$map['status']=1;
		if(I('name')){
			$map['name']=array('like','%'.I('name').'%');
		}
		$p=!empty($_GET["pageIndex"])?$_GET["pageIndex"]+1:1;
		$server_list=M('Gameserver')->page($p, 30)->where($map)->order("FROM_UNIXTIME(`ktime`,'%Y-%m-%d') desc,sort desc,id desc")->select();
		$count=M('Gameserver')->where($map)->order("FROM_UNIXTIME(`ktime`,'%Y-%m-%d') desc,sort desc,id desc")->count();
		$game=M('Game')->find($gid);
		
		if(M('MixUserGame')->where(Array('gid'=>$gid,'mid'=>$mid))->count()==0){
			$isdl='未代理';
		}else{
			$isdl='已代理';
		}
		foreach($server_list as  &$val){
			$val['gamename']=$game['name'];
			$val['kftime']=date('Y-m-d H:i:s',$val['ktime']);
			$val['isdl']=$isdl;
		}
		
		$ajax['rows']=$server_list;
		$ajax['results']=$count;
		$this->ajax($ajax);
	}
	
	
	public function operate_api_json(){
		$mid=session('mixmid');
		$map['mid']=$mid;
		if(I('name')){
			$_map['name']=array('like','%'.I('name').'%');
			$_game=M('Game')->where($_map)->select();
			if(!empty($_game)){
				$mix_game_tmp=Array();
				foreach($_game as $_val){
					$mix_game_tmp[]=$_val['id'];
				}
				$in=implode(',',$mix_game_tmp);
				$map['gid'] = array('in',$in);
			}
		}
		$MixUserGame=M('MixUserGame')->page($p, 30)->where($map)->order("sort desc,id desc")->fetchSql(false)->select();
		$count=M('MixUserGame')->where($map)->order("sort desc,id desc")->fetchSql(false)->count();
		
		$login_key=MixSignKey($mid,"LOGIN");
		$pay_key=MixSignKey($mid,"PAY");
		foreach($MixUserGame as &$val){
			$game=M('Game')->find($val['gid']);
			$val['name']=$game['name'];
			$val['login_key']=$login_key;
			$val['pay_key']=$pay_key;
			$val['status']=$val['status']==1?'正常':'禁用';
			$val['dl_time']=date("Y-m-d H:i:s",$val['ctime']);
		}
		$ajax['rows']=$MixUserGame;
		$ajax['results']=$count;
		$this->ajax($ajax);
		
		
		
	}
	
	public function operate_kfpq_json(){
		$mid=session('mixmid');
		
		$map['status']=1;

		$mix_game=D('MixGame')->field('gid')->select();
		$mix_game_tmp=Array();
		foreach($mix_game as $_val){
			$mix_game_tmp[]=$_val['gid'];
		}
		$in=implode(',',$mix_game_tmp);
		$map['game'] = array('in',$in);
		if(I('name')){
			$map['name']=array('like','%'.I('name').'%');
		}
		$p=!empty($_GET["pageIndex"])?$_GET["pageIndex"]+1:1;
		$server_list=M('Gameserver')->page($p, 100)->where($map)->order("FROM_UNIXTIME(`ktime`,'%Y-%m-%d') desc,sort desc,id desc")->fetchSql(false)->select();
		$count=M('Gameserver')->where($map)->order("FROM_UNIXTIME(`ktime`,'%Y-%m-%d') desc,sort desc,id desc")->fetchSql(false)->count();
		foreach($server_list as  &$val){
			$game=M('Game')->find($val['game']);
			$val['gamename']=$game['name'];
			$val['kftime']=date('Y-m-d H:i:s',$val['ktime']);
			if(M('MixUserGame')->where(Array('gid'=>$val['game'],'mid'=>$mid))->count()==0){
				$val['isdl']='未代理';
			}else{
				$val['isdl']='已代理';
			}
		}
	
		
		$ajax['rows']=$server_list;
		$ajax['results']=$count;
		$this->ajax($ajax);
	}
	
	public function operate_role_json(){
		$mid=session('mixmid');
		
		$map['identification']=$mid;
		
		if(I('gid')){
			$map['gid']=intval(I('gid'));
		}
		
		if(I('sid')){
			$map['sid']=intval(I('sid'));
		}
		
		if(I('identification_uid')){
			$map['identification_uid']=intval(I('identification_uid'));
		}
		
	
		
		if(I('start_time') && I('end_time')){
			$start_time=strtotime(I('start_time'));
			$end_time=strtotime(I('end_time'));
			$map['ctime'] = array(
                array('egt', $start_time),
                array('lt', $end_time)
            );
		}
		
		
		$p=!empty($_GET["pageIndex"])?$_GET["pageIndex"]+1:1;
		$GamePlay=M('Gameplay')->page($p, 30)->where($map)->order("id desc")->fetchSql(false)->select();
		$count=M('Gameplay')->where($map)->order("id desc")->fetchSql(false)->count();
		$gameobj=M('Game');
		$serverobj=M('Gameserver');
		$gamelog=M('Gamelog');
		foreach($GamePlay as  &$val){
			$game=$gameobj->find($val['gid']);
			$val['gamename']=$game['name'];
			$server=$serverobj->find($val['sid']);
			$val['servername']=$server['name'];
			$val['reg_time']=date("Y-m-d H:i:s",$val['ctime']);
			
			$val['login_count']=$gamelog->where(Array('gid'=>$val['gid'],'sid'=>$val['sid'],'uid'=>$val['uid']))->count();
			$val['kftime']=date('Y-m-d H:i:s',$val['ktime']);
			if(M('MixUserGame')->where(Array('gid'=>$val['game'],'mid'=>$mid))->count()==0){
				$val['isdl']='未代理';
			}else{
				$val['isdl']='已代理';
			}
		}
		
		$ajax['rows']=$GamePlay;
		$ajax['results']=$count;
		$this->ajax($ajax);
	}
	
	public function operate_pay_json(){
		$mid=session('mixmid');
		$map['identification']=$mid;
		$map['paystatus']=2;
		if(I('gid')){
			$map['gid']=intval(I('gid'));
		}
		
		if(I('sid')){
			$map['sid']=intval(I('sid'));
		}
		
		if(I('identification_uid')){
			$map['identification_uid']=intval(I('identification_uid'));
		}
		
		if(I('identification_order')){
			$map['identification_order']=I('identification_order');
		}
		
		if(I('start_time') && I('end_time')){
			$start_time=strtotime(I('start_time'));
			$end_time=strtotime(I('end_time'));
			$map['utime'] = array(
                array('egt', $start_time),
                array('lt', $end_time)
            );
		}
		
		
		$p=!empty($_GET["pageIndex"])?$_GET["pageIndex"]+1:1;
		$Paylog=M('Paylog')->page($p, 30)->where($map)->order("id desc")->fetchSql(false)->select();
		$count=M('Paylog')->where($map)->order("id desc")->fetchSql(false)->count();
		foreach($Paylog as &$val){
			$game=$gameobj->find($val['gid']);
			$val['gamename']=$game['name'];
			$server=$serverobj->find($val['sid']);
			$val['servername']=$server['name'];
			$val['time']=date('Y-m-d H:i:s',$val['utime']);
		}
		$ajax['rows']=$Paylog;
		$ajax['results']=$count;
		$this->ajax($ajax);
	}
	
	public function operate_news_json(){
		
		if(I('gid')){
			$map['gid']=intval(I('gid'));
		}
		
		if(I('title')){
			$map['title']=intval(I('title'));
		}
		
		if(I('start_time') && I('end_time')){
			$start_time=strtotime(I('start_time'));
			$end_time=strtotime(I('end_time'));
			$map['ctime'] = array(
                array('egt', $start_time),
                array('lt', $end_time)
            );
		}
		
		
		$p=!empty($_GET["pageIndex"])?$_GET["pageIndex"]+1:1;
		$MixNews=M('MixNews')->page($p, 30)->where($map)->order("id desc")->fetchSql(false)->select();
		$count=M('MixNews')->where($map)->order("id desc")->fetchSql(false)->count();
		$gameobj=M('Game');
		foreach($MixNews as &$val){
			$game=$gameobj->find($val['gid']);
			$val['gamename']=$game['name']?:'平台';
			$val['time']=date('Y-m-d H:i:s',$val['ctime']);
		}
		$ajax['rows']=$MixNews;
		$ajax['results']=$count;
		$this->ajax($ajax);
	}
	
	
	public function operate_ask_json(){
		$mid=session('mixmid');
		$map['mid']=$mid;
		if(I('gid')){
			$map['gid']=intval(I('gid'));
		}
		
		if(I('sid')){
			$map['sid']=intval(I('sid'));
		}
		
		if(I('clstatus')){
			$map['clstatus']=I('clstatus');
		}
		
		if(I('start_time') && I('end_time')){
			$start_time=strtotime(I('start_time'));
			$end_time=strtotime(I('end_time'));
			$map['ctime'] = array(
                array('egt', $start_time),
                array('lt', $end_time)
            );
		}
		
		
		$p=!empty($_GET["pageIndex"])?$_GET["pageIndex"]+1:1;
		$list=M('MixAsk')->page($p, 30)->where($map)->order("id desc")->fetchSql(false)->select();
		$count=M('MixAsk')->where($map)->order("id desc")->fetchSql(false)->count();
		$gameobj=M('Game');
		foreach($list as &$val){
			$game=$gameobj->find($val['gid']);
			$val['gamename']=$game['name'];
			$val['ctime']=date('Y-m-d H:i:s',$val['ctime']);
			$val['utime']=date('Y-m-d H:i:s',$val['utime']);
		}
		$ajax['rows']=$list;
		$ajax['results']=$count;
		$this->ajax($ajax);
		
	}
	
	public function operate_lncharge_json(){
		$mid=session('mixmid');
		$map['mid']=$mid;
		if(I('gid')){
			$map['gid']=intval(I('gid'));
		}
		
		if(I('sid')){
			$map['sid']=intval(I('sid'));
		}
		
		if(I('clstatus')){
			$map['clstatus']=I('clstatus');
		}
		
		if(I('start_time') && I('end_time')){
			$start_time=strtotime(I('start_time'));
			$end_time=strtotime(I('end_time'));
			$map['ctime'] = array(
                array('egt', $start_time),
                array('lt', $end_time)
            );
		}
		
		
		$p=!empty($_GET["pageIndex"])?$_GET["pageIndex"]+1:1;
		$list=M('MixLncharge')->page($p, 30)->where($map)->order("id desc")->fetchSql(false)->select();
		$count=M('MixLncharge')->where($map)->order("id desc")->fetchSql(false)->count();
		$gameobj=M('Game');
		$serverobj=M('Gameserver');
		foreach($list as &$val){
			$val['_userlist']='点击查看';
			$game=$gameobj->find($val['gid']);
			$val['gamename']=$game['name'];
			$server=$serverobj->find($val['sid']);
			$val['servername']=$server['name'];
			$val['ctime']=date('Y-m-d H:i:s',$val['ctime']);
			$val['utime']=date('Y-m-d H:i:s',$val['utime']);
		}
		$ajax['rows']=$list;
		$ajax['results']=$count;
		$this->ajax($ajax);
		
		
	}
	
	public function operate_settlement_json(){
		$mid=session('mixmid');
		$map['mid']=$mid;
		
		if(I('clstatus')){
			$map['clstatus']=I('clstatus');
		}
		
		if(I('start_time') && I('end_time')){
			$start_time=strtotime(I('start_time'));
			$end_time=strtotime(I('end_time'));
			$map['ctime'] = array(
                array('egt', $start_time),
                array('lt', $end_time)
            );
		}
		
		
		$p=!empty($_GET["pageIndex"])?$_GET["pageIndex"]+1:1;
		$list=M('MixSettlement')->page($p, 30)->where($map)->order("id desc")->fetchSql(false)->select();
		$count=M('MixSettlement')->where($map)->order("id desc")->fetchSql(false)->count();
		foreach($list as &$val){
			$val['ctime']=date('Y-m-d H:i:s',$val['ctime']);
			$val['utime']=date('Y-m-d H:i:s',$val['utime']);
		}
		$ajax['rows']=$list;
		$ajax['results']=$count;
		$this->ajax($ajax);
		
		
	}
	
	public function out(){
		session('mixadmin',NULL);
		session('mixmid',NULL);
		$this->redirect('Mix/Main/login');
	}
	public function login(){
		$pass=true;
		if(IS_POST){
			$data['name']=I('username');
			$data['pass']=I('password');
			$info=M('MixUser')->where($data)->find();
			if(empty($info)){
				$pass=false;
			}else{
				M('MixUser')->where($data)->save(Array('last_login_time'=>time()));
				session('mixinfo',$info);
				session('mixmid',$info['id']);
				session('mixadmin',$data['name']);
				$this->redirect('Mix/Main/index');
			}
		}
		$this->assign('ispass',$pass);
		$this->display();
	}
	
	
	
	




}
