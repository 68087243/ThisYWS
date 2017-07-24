<?php
namespace Api\Controller;
use Think\Controller;

class CarddetailController extends ApiController {



    public function ajaxCarddetailBygid(){
        $gid=I('gid');
        if(!empty($gid)){
            $map['gid']=$gid;
            $this->ajaxReturn(D('CardDetail')->where($map)->field('id,gid,name,level,description,method,status')->select());
        }
    }
}