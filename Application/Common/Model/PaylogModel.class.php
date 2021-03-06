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
 * 游戏模型
 * @author C0de <47156503@qq.com>
 */
class PaylogModel extends Model{




    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('ctime', NOW_TIME, self::MODEL_INSERT),
        array('utime', NOW_TIME, self::MODEL_BOTH),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
        array('ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
        array('order', 'build_order_no', self::MODEL_INSERT, 'function', 1),
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
	
	public function callback_($data,$map,$paylog){
		if($data['paystatus'] == 2){
			$this->where($map)->save($data);
			$user=D('User');
			$user->addScore($paylog['uid'],$paylog['payamount'],false,'充值');
			$user->addScore($paylog['uid'],$paylog['payamount'],true,'充值');
			D('Spread')->AddSpreadPay($paylog['uid'],$map['order'],$paylog['payamount']);
		}
	}

}
