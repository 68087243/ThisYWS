<?php

namespace Common\Model;
use Think\Model;
/**
 * 工单配置模型
 * @author C0de <47156503@qq.com>
 */
class IssueConfigModel extends Model{

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

}
