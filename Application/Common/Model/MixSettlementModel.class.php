<?php

namespace Common\Model;
use Think\Model;
/**
 * 混服结算模型
 * @author C0de <47156503@qq.com>
 */
class MixSettlementModel extends Model{


    protected $_auto = array(
        array('ctime', NOW_TIME, self::MODEL_INSERT),
        array('utime', NOW_TIME, self::MODEL_BOTH),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );


}
