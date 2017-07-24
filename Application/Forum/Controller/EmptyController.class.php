<?php
namespace Forum\Controller;
use Think\Controller;
class EmptyController extends ForumController {
    public function index(){
		$map['mark'] = addslashes(CONTROLLER_NAME);
		$game_obj=D('Game');
		$game_info=$game_obj->where($map)->find();
		if(empty($game_info)){
			$this->redirect('Game/index/index');
		}
		$game_info['pic']=json_decode($game_info['pic'],true);
		
		
		
		
		$bbsmap['gid']=$game_info['id'];
		$type=intval(I('type'));
		if(!empty($type)){
			$bbsmap['type']=$type;
		}
		$data_list = D('ForumPost')->page(!empty($_GET["p"])?$_GET["p"]:1, 20)->where($bbsmap)->order('sort desc,id desc')->select();
		$count=D('ForumPost')->where($bbsmap)->count();
        $page = new \Common\Util\Page($count, 20);
		
		foreach($data_list as &$val){
			$user_info=D('User')->find($val['uid']);
			$val['username']=$user_info['username'];
			$reply_info=D('ForumReply')->where(Array('pid'=>$val['id']))->order('id desc')->find();
			
			$val['reply_count']=D('ForumReply')->where(Array('pid'=>$val['id']))->count();
			if(empty($reply_info)){
				$val['reply_username']=$val['username'];
				$val['reply_time']=date("H:i",$val['utime']);
			}else{
				$reply_user_info=D('User')->find($reply_info['uid']);
				$val['reply_username']=$reply_user_info['username'];
				$val['reply_time']=date("H:i",$reply_info['ctime']);
			}
		}
		$forumtype=M('ForumType')->select();
		$this->assign('forumtype', $forumtype);
        $this->assign('data_list', $data_list);
        $this->assign('page', $page->show());
		$this->assign('count', number_format($count));
		
		$this->assign('game_info',$game_info);
        $this->display('index/index');
    }
	
	public function post(){
		$userinfo=session('user_auth');
		if(empty($userinfo)){
			$this->redirect('User/Public/login');
		}
		$map['mark'] = addslashes(CONTROLLER_NAME);
		$game_obj=D('Game');
		$game_info=$game_obj->where($map)->find();
		if(empty($game_info)){
			$this->redirect('Game/index/index');
		}
		if(IS_POST){
			$save['title']=I('title');
			$save['type']=intval(I('cate_id'));
			$save['content']=I('content');
			if(empty($save['title']) || empty($save['type']) || empty($save['content']) ){
				exit;
			}
			$save['gid']=$game_info['id'];
			$save['uid']=$userinfo['id'];
			$save['sort']=1;
			$save['ctime']=time();
			$save['utime']=time();
			$id=M('ForumPost')->add($save);
			$this->redirect('Forum/'.$map['mark'].'/view',Array('id'=>$id));
		}else{
			$game_info['pic']=json_decode($game_info['pic'],true);
			$count=D('ForumPost')->where($bbsmap)->count();
			$this->assign('count', number_format($count));
			$forumtype=M('ForumType')->select();
			$this->assign('forumtype', $forumtype);
			$this->assign('game_info',$game_info);
			$this->display('index/post');
		}
		
	}
	
	public function view(){
		$map['mark'] = addslashes(CONTROLLER_NAME);
		$id=intval(I('id'));
		$game_obj=D('Game');
		$game_info=$game_obj->where($map)->find();
		if(empty($game_info) || empty($id)){
			$this->redirect('Game/index/index');
		}
		$data=M('ForumPost')->find($id);
		if(empty($data)){
			$this->redirect('Game/index/index');
		}
		M('ForumPost')->where(Array('id'=>$id))->setInc('views',1);
		$reply=D('ForumReply')->where(Array('pid'=>$id))->order('id asc')->select();
		$game_info['pic']=json_decode($game_info['pic'],true);
		$userinfo=M('User')->find($data['uid']);
		$count=D('ForumPost')->where($bbsmap)->count();
		$this->assign('count', number_format($count));
		$forumtype=M('ForumType')->select();
		$this->assign('forumtype', $forumtype);
		$this->assign('reply',$reply);
		$this->assign('data',$data);
		$this->assign('userinfo',$userinfo);
		$this->assign('game_info',$game_info);
        $this->display('index/view');
    }
	
	public function addreply(){
		$userinfo = session('user_auth');
		$pid=intval(I('pid'));
		$content=I('content');
		$ajax['status']=0;
		if(!empty($pid) && !empty($content) && !empty($userinfo)){
			if(strlen($content)>5){
				$data_=M('ForumPost')->find($pid);
				if(!empty($data_)){
					$ajax['status']=1;
					$data['pid']=$pid;
					$data['content']=$content;
					$data['uid']=$userinfo['id'];
					$data['ctime']=time();
					$data['utime']=time();
					$data['sort']=1;
					D('ForumReply')->add($data);
					$ajax['msg']='Success';
				}
			}else{
				$ajax['msg']='回复长度不小于五个字符!';
			}
		}
		$this->ajax($ajax);
	}
	
	
	public function addreplyinner(){
		$userinfo = session('user_auth');
		$rid=intval(I('rid'));
		$content=I('content');
		$ajax['status']=0;
		if(!empty($rid) && !empty($content) && !empty($userinfo)){
			if(strlen($content)>5){
				$data_=M('ForumReply')->find($rid);
				if(!empty($data_)){
					$ajax['status']=1;
					$data['rid']=$rid;
					$data['content']=$content;
					$data['uid']=$userinfo['id'];
					$data['ctime']=time();
					$data['utime']=time();
					$data['sort']=1;
					$data['uid_y']=intval(I('uid'));
					D('ForumReplyInner')->add($data);
					$ajax['msg']='Success';
				}
			}else{
				$ajax['msg']='回复长度不小于五个字符!';
			}
		}
		$this->ajax($ajax);
	}
}