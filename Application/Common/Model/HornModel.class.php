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
 * 小喇叭模型
 * @author C0de <47156503@qq.com>
 */
class HornModel extends Model{


    /**
     * 自动验证规则
     * @author C0de <47156503@qq.com>
     */
    protected $_validate = array(
        //验证注册类型
        array('name', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('url', 'require', '网址不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );


    /**
     * 自动完成规则
     * @author C0de <47156503@qq.com>
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
