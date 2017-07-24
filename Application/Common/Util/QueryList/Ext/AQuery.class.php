<?php
/**
 * @Author: Jaeger <hj.q@qq.com>
 * @Date:   2015-11-11 17:52:40
 * @Last Modified by:   Jaeger
 * @Last Modified time: 2015-12-24 18:07:24
 * @version         1.0.1
 * 扩展基类
 */
namespace Common\Util\QueryList\Ext;

use Common\Util\QueryList,ReflectionMethod;

abstract class AQuery
{
     abstract function run(array $args);

    public function getInstance($className = 'QL\QueryList')
    {
        $args = func_get_args();
        $getInstance = new ReflectionMethod('Common\Util\QueryList\QueryList::getInstance');
        return $getInstance->invokeArgs(null,$args);
    }

}
