<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Common\Model;
use Think\Model;
/**
 * VIP任务模型
 * @author C0de <47156503@qq.com>
 */
class TaskLogModel extends Model{




    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('ctime', NOW_TIME, self::MODEL_INSERT),
        array('utime', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_INSERT),
    );
	
	public function isTask($uid,$tid){
		$_date=date('Y-m-d');
		$__temp=$this->getTaskByuid($uid,$tid);
		if(!empty($__temp)){
			$__date=date('Y-m-d',$__temp['ctime']);
			if($__date == $_date){
				$task=true;
			}else{
				$task=false;
			}
		}else{
			$task=false;
		}
		return $task;
	}



   public function getTaskByuid($uid,$tid){
       $map['uid']=$uid;
       $map['tid']=$tid;
       return $this->where($map)->order('id desc')->find();
   }

   public function getTask($uid){
       $map['uid']=$uid;
       $data=$this->where($map)->select();
       $array=Array();
       foreach($data as $val){
           $array[$val['tid']]=$val['uid'];
       }
       return $array;
   }

}
