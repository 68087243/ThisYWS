<?php

namespace Common\Model;
use Think\Model;
/**
 * 混服新闻模型
 * @author C0de <47156503@qq.com>
 */
class MixNewsModel extends Model{


 


    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('ctime', NOW_TIME, self::MODEL_INSERT),
        array('utime', NOW_TIME, self::MODEL_BOTH),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );


}
