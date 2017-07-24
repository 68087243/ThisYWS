<?php

namespace Common\Widget;
use Think\Controller;
class HornWidget extends Controller {

    public function getHorn($num,$cache='getHorn'){
        $cache=md5($cache.'_'.$num);
        $obj=D('Horn');
        $map['status']=array('eq',1);
        $data=$obj->where($map)->order('id desc')->limit($num)->cache($cache,2000)->select();
        return $data;
    }



}






?>