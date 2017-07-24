<?php

namespace Spread\Controller;
use Think\Controller;
use Common\Util;

class MainController extends SpreadController{

	protected function _initialize(){
        parent::_initialize();
        if(ACTION_NAME != 'login'){
			$cpsadmin=session('cpsadmin');
			if(empty($cpsadmin)){
				$this->redirect('Spread/Main/login');
				
			}
		}
    }
	

	public function jsonReg(){
		$mid=session('cpsmid');
		$map['mid']=$mid;
		$username=I('username');
		if(!empty($username)){
			$__userinfo=M('User')->where(Array('username'=>$username))->find();
			if(!empty($__userinfo)){
				$map['uid']=$__userinfo['id'];
			}
		}
		$gid=I('gid');
		if(!empty($gid)){
			$map['gid']=$gid;
		}
		$aid=I('aid');
		if(!empty($aid)){
			if($aid == '-1'){
				$map['aid']=0;
			}else{
				$map['aid']=$aid;
			}
		}
		$startDate=I('startDate');
		if(!empty($startDate)){
			$map['ctime ']=array('exp','> '.strtotime($startDate));
		}
		$endDate=I('endDate');
		if(!empty($endDate)){
			$map[' ctime']=array('exp','< '.strtotime($endDate));
		}
		$data=M('SpreadUser')->where($map)->order('id desc')->select();
		foreach($data as &$val){
			$userinfo=M('User')->find($val['uid']);
			$val['uid']=$userinfo['username'];
			$gameinfo=M('Game')->find($val['gid']);
			$val['gid']=$gameinfo['name'];
			if(empty($val['sid'])){
				$val['sid']='最新服';
			}else{
				$serverinfo=M('Gameserver')->find($val['sid']);
				$val['sid']=$serverinfo['name'];
			}
			if(empty($val['aid'])){
				$val['aid']='主账号';
			}else{
				$aidinfo=M('SpreadLower')->find($val['aid']);
				$val['aid']=$aidinfo['name'];
			}
			$val['ctime']=date('Y-m-d H:i:s',$val['ctime']);
		}
		$ajax['rows']=$data;
		$this->ajax($ajax);
	}
	
	public function jsonPay(){
		$mid=session('cpsmid');
		$map['mid']=$mid;
		$username=I('username');
		if(!empty($username)){
			$__userinfo=M('User')->where(Array('username'=>$username))->find();
			if(!empty($__userinfo)){
				$map['uid']=$__userinfo['id'];
			}
		}
		$order=I('order');
		if(!empty($order)){
			$map['order']=$order;
		}
		$aid=I('aid');
		if(!empty($aid)){
			if($aid == '-1'){
				$map['aid']=0;
			}else{
				$map['aid']=$aid;
			}
		}
		$startDate=I('startDate');
		if(!empty($startDate)){
			$map['ctime ']=array('exp','> '.strtotime($startDate));
		}
		$endDate=I('endDate');
		if(!empty($endDate)){
			$map[' ctime']=array('exp','< '.strtotime($endDate));
		}
		$data=M('SpreadPay')->where($map)->order('id desc')->select();
		foreach($data as &$val){
			$userinfo=M('User')->find($val['uid']);
			$val['uid']=$userinfo['username'];
			if(empty($val['sid'])){
				$val['sid']='最新服';
			}else{
				$serverinfo=M('Gameserver')->find($val['sid']);
				$val['sid']=$serverinfo['name'];
			}
			if(empty($val['aid'])){
				$val['aid']='主账号';
			}else{
				$aidinfo=M('Spread')->find($val['aid']);
				$val['aid']=$aidinfo['name'];
			}
			$val['ctime']=date('Y-m-d H:i:s',$val['ctime']);
		}
		$ajax['rows']=$data;
		$this->ajax($ajax);
	}
	public function jsonUser(){
		$mid=session('cpsmid');
		$map['mid']=$mid;
		
		$name=I('name');
		if(!empty($name)){
			$map['name']=$name;
		}
		
		$data=M('SpreadLower')->where($map)->order('id desc')->select();
		foreach($data as &$val){
			$map['aid']=$val['id'];
			$usercount=M('SpreadUser')->where($map)->count();
			$val['user']=$usercount;
			$paycount=M('SpreadPay')->where($map)->count();
			$val['pay']=$paycount;
		}
		$new['id']=0;
		$new['name']='主账号';
		unset($map['aid']);
		$map['ISNULL(aid)']=array('exp','');
		$new['user']=M('SpreadUser')->where($map)->count();
		$new['pay']=M('SpreadPay')->where($map)->count();
		$data[]=$new;
		$ajax['rows']=$data;
		$this->ajax($ajax);
	}
	
	public function jsonSettle(){
		$mid=session('cpsmid');
		$map['mid']=$mid;
		
		$money=I('money');
		if(!empty($money)){
			$map['money']=$money;
		}
		
		$txstatus=I('txstatus');
		if(!empty($txstatus)){
			$map['txstatus']=intval($txstatus);
		}
		$startDate=I('startDate');
		if(!empty($startDate)){
			$map['ctime ']=array('exp','> '.strtotime($startDate));
		}
		$endDate=I('endDate');
		if(!empty($endDate)){
			$map[' ctime']=array('exp','< '.strtotime($endDate));
		}
		$data=M('SpreadTx')->where($map)->order('id desc')->select();
		foreach($data as &$val){
			
			if(empty($val['txstatus'])){
				$val['txstatus']='待支付';
			}else{
				$val['txstatus']='已支付';
			}
			$val['ctime']=date('Y-m-d H:i:s',$val['ctime']);
			$val['utime']=date('Y-m-d H:i:s',$val['utime']);
		}
		$ajax['rows']=$data;
		$this->ajax($ajax);
	}
	
	public function settlesq(){
		$mid=session('cpsmid');
		$txobj=M('SpreadTx');
		$data=$txobj->where(Array('mid'=>$mid,'txstatus'=>0))->find();
		if(!empty($data)){
			die('您正在提现中!暂时不能提现!');
		}
		$cpsinfo=M('Spread')->where(Array('mid'=>$mid))->find();
		if(IS_POST){
			$money=intval(I('money'));
			if($cpsinfo['money'] < $money){
				die('error');
			}
			$save['mid']=$mid;
			$save['txstatus']=0;
			$save['ctime']=time();
			$save['money']=$money;
			$txobj->add($save);
			die('提现申请已提交!');
		}else{
			$this->assign('cpsinfo',$cpsinfo);
			$this->display();
		}
	}
	
	public function useradd(){
		$mid=session('cpsmid');
		if(IS_POST){
			$obj=M('SpreadLower');
			$save['name']=I('name');
			$save['mid']=$mid;
			$save['ctime']=time();
			$obj->add($save);
			die('添加成功!');
		}else{
			$this->display();
		}
	}
	
    public function index(){
		$this->display();
    }
	public function out(){
		session('cpsadmin',NULL);
		session('cpsmid',NULL);
		$this->redirect('Spread/Main/login');
	}
	public function login(){
		$pass=true;
		if(IS_POST){
			$data['name']=I('username');
			$data['pass']=I('password');
			$info=M('Spread')->where($data)->find();
			if(empty($info)){
				$pass=false;
			}else{
				session('cpsmid',$info['mid']);
				session('cpsadmin',$data['name']);
				$this->redirect('Spread/Main/index');
			}
		}
		$this->assign('ispass',$pass);
		$this->display();
	}
	
	




}
