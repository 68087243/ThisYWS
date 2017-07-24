<?php

namespace Common\Model;
use Think\Model;
/**
 * 工单模型
 * @author C0de <47156503@qq.com>
 */
class IssueModel extends Model{




    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('ctime', NOW_TIME, self::MODEL_INSERT),
        array('utime', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_INSERT),
    );



    /**
     * 获取所有所有用户指定字段值
     * @param string $field 字段
     * @return array
     * @author c0de <47156503@qq.com>
     */
    public function getColumnByfield($field = 'email', $map){
        return $this->where($map)->getField($field,true);
    }

    public function getFieldBymap($field,$map){
        $data=$this->where($map)->find();
        return $data[$field];
    }

    public function getUidcount($uid){
        $map['uid']=$uid;
        return $this->where($map)->count();
    }

}
