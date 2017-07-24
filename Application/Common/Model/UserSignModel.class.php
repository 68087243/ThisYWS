<?php

namespace Common\Model;
use Think\Model;
/**
 * 签到模型
 * @author C0de <47156503@qq.com>
 */
class UserSignModel extends Model{


    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('ctime', NOW_TIME, self::MODEL_INSERT),
    );



    /**
     * 获取所有所有用户指定字段值
     * @param string $field 字段
     * @return array
     * @author jry <598821125@qq.com>
     */
    public function getColumnByfield($field = 'email', $map){
        return $this->where($map)->getField($field,true);
    }

    public function getUidcount($uid){
        $map['uid']=$uid;
        return $this->where($map)->count();
    }

}
