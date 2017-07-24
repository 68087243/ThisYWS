<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: ijry <ijry@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Common\Util\Pay\Driver;

class Pay_ extends \Common\Util\Pay {
	public function __construct( $config = array()) {
      echo $this->_buildForm($config[0],$config[1],$config[2]);
    }
}
