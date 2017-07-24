<?php

namespace User\Controller;
use Think\Controller;

class VipController extends UserController{


    public function index(){
        $userinfo = session('user_auth');
        $map['uid']=$userinfo['id'];
		$map['paystatus']=2;
        $sc_task=D('Paylog')->where($map)->find();
        if(!empty($sc_task)){
            $this->assign('sc_task', 1);
        }
		$this->assign('meta_title', "VIP中心");
        $this->display();
    }



    public function task(){
        $tid=intval(I('tid'));
        $userinfo = session('user_auth');
        $task_log=D('TaskLog');
        $temp=$task_log->getTaskByuid($userinfo['id'],$tid);
        //判断是否领取过
        if(empty($temp) && !empty($tid)){
            //读取任务表配置
            $map['id']=$tid;
            $task=M('task')->where($map)->find();
            if(!empty($task)) {
                //进行成长值添加
                $num = D('User')->addScore($userinfo['id'], $task['config'], true,'任务');

                //写进任务记录表
                $save['uid'] = $userinfo['id'];
                $save['tid'] = $tid;
                $save['ctime'] = time();
                $save['utime'] = time();
                $save['status'] = 1;
                $task_log->add($save);

                //JSON输出
                $_level = getlevel($num,true);
                $data['code'] = 1;
                $data['scoreInfo'] = Array();
                $data['scoreInfo']['score'] = $num;
                $data['scoreInfo']['level'] = $_level['level'];
                $data['scoreInfo']['max'] = $_level['e'];
                $data['scoreInfo']['min'] = $_level['s'];
                $data['scoreInfo']['levelName'] = $_level['title'];
            }
        }else{
            $data['code']=0;
        }
        $this->ajax($data);
    }




}
