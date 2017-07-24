<?php
namespace Api\Controller;
use Think\Controller;

class ForumController extends ApiController {


    public function GetHot(){
		$map['status']=1;
		$data=M('ForumPost')->where($map)->order('ishot desc,views desc,id desc')->limit(3)->select();
		$ajax=Array();
		foreach($data as $val){
			$mark=D('Game')->getFieldBymap('mark',Array('id'=>$val['gid']));
			$ajax[]=Array('info'=>$val['title'],'url'=>U('Forum/'.$mark.'/view',array('id'=>$val['id'])));
		}
		$this->ajax($ajax);
    }

}