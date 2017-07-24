<?php

namespace Game\Controller;
use Think\Controller;

class EmptyController extends GameController{
	
	private $_game=Array();
	public function __construct(){
		parent::__construct();
		$Name = addslashes(CONTROLLER_NAME);//当前控制器
        $map['mark']=$Name;
        $map['status']=array('eq',1);
        $game=D('Game')->where($map)->find();
        if(empty($game)){
            $this->redirect('Home/Index/Index');
			die();
        }
		$game['pic']=json_decode($game['pic'],true);
        $game['flags'] = flags($game['flags']);
		$game['gameurl']=D('Game')->getGameUrl($game['id']);
		$this->_game=$game;
		$this->assign('gameurl',$this->_game['gameurl']);
        $this->assign('gamedata',$this->_game);
	}
	
	public function _empty($name){
		switch($name){
			case "news_list":$this->_news_list();break;
			case "news_read":$this->_news_read();break;
			case "server":$this->_server();break;
			default:$obj=GetApi($this->_game['api']);if(method_exists($obj,'extend')){$obj->extend($name,$this->_game);}else{$this->index();}
		}
	}

    public function index(){
        $this->assign('meta_title', $this->_game['name']);
		$site=M('Gamesite')->find($this->_game['theme']);
		if($site['tag']){
			if($site['path']){
				$theme=$site['path'].'/'.$site['tag'];
			}else{
				C('VIEW_PATH','./Game/Theme/');
				$theme=$site['tag'].'/index';
			}
			$this->display($theme);
			
		}else{
			$this->display('Default/index');
		}
    }

	public function _server(){
		$this->assign('meta_title', '区服列表-'.$this->_game['name']);
		$site=M('Gamesite')->find($this->_game['theme']);
		if($site['tag']){
			
			if($site['path']){
				$theme=$site['path'].'/'.$site['tag'];
			}else{
				C('VIEW_PATH','./Game/Theme/');
				$theme=$site['tag'].'/server';
			}
			$this->display($theme);
			
		}else{
			$this->display('Default/server');
		}
	}
	
	public function _news_read(){
		$id=intval(I('id'));
        if(empty($id)){
            $this->redirect('Home/Index/Index');
        }
        $info = D('Document')->detail($id);
        if(empty($info)){
            $this->redirect('Home/Index/Index');
        }
        $result = D('Document')->where(array('id' => $id))->SetInc('view');//阅读量加1
        $this->assign('__info__',$info);
		$category = D('Category')->find($info['cid']);
		$this->assign('title',$category['title']);
		$this->assign('meta_title', $info['title'].'-'.$this->_game['name']);
		$site=M('Gamesite')->find($this->_game['theme']);
		if($site['tag']){
			if($site['path']){
				$theme=$site['path'].'/'.$site['tag'];
			}else{
				C('VIEW_PATH','./Game/Theme/');
				$theme=$site['tag'].'/news_read';
			}
			$this->display($theme);
			
		}else{
			$this->display('Default/news_read');
		}
		
		
	}
	public function _news_list(){
		$cid=intval(I('cid'));
		if(!empty($cid)){
            $map['cid'] = $cid;
            $category = D('Category')->find($cid);
            $title = $category['title'];
        }else{
			$_arr=D('Category')->where(Array('post_auth'=>1))->select();
			if(is_array($_arr)){
				foreach($_arr as $v){
					$_cid[]=$v['id'];
				}
				$map['cid']=array("in",implode(",",$_cid));			
			}
            $title = '最新资讯';
        }
		
		
		$map['status'] = array('eq', 1);
		$map['typegame']=$this->_game['id'];
        $document_list = D('Document')->join('ct_document_extend_article ON ct_document_extend_article.id = ct_document.id')->page(!empty($_GET["p"])?$_GET["p"]:1, 16)->order('ct_document.id desc')->fetchSql(false)->where($map)->select();
        //分页
        $page = new \Common\Util\Page(D('Document')->join('ct_document_extend_article ON ct_document_extend_article.id = ct_document.id')->where($map)->count(), 16);
		
		
		$this->assign('volist', $document_list);
        $this->assign('page', $page->show());
		$this->assign('title',$title);
        $this->assign('meta_title', $this->_game['name'].$title);
		$site=M('Gamesite')->find($this->_game['theme']);
		if($site['tag']){
			if($site['path']){
				$theme=$site['path'].'/'.$site['tag'];
			}else{
				C('VIEW_PATH','./Game/Theme/');
				$theme=$site['tag'].'/news_list';
			}
			$this->display($theme);
			
		}else{
			$this->display('Default/news_list');
		}
		
		
	}
	
	
	
	




}
