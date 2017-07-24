<?php

namespace Common\Model;
use Think\Model;
/**
 * 积分记录模型
 * @author C0de <47156503@qq.com>
 */
class ScoreLogModel extends Model{




    /**
     * 自动完成规则
     * @author C0de <47156503@qq.com>
     */
    protected $_auto = array(
        array('ctime', NOW_TIME, self::MODEL_INSERT),
    );
	
	public function addLog($uid,$num,$score_type,$type,$remark){
		$data['uid']=$uid;
		$data['num']=$num;
		$data['score_type']=$score_type;
		$data['type']=$type;
		$data['remark']=$remark;
		$data['ctime']=time();
		if($this->add($data)){
			return true;
		}else{
			return false;
		}
	}
	
	

}
