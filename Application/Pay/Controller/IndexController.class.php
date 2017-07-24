<?php
namespace Pay\Controller;
use Think\Controller;
use Common\Util;

class IndexController extends PayController {
    public function index($gid=0){
        $map['status']=array('eq',1);
        $paylist=D('Paytype')->where($map)->order('sort asc,id desc')->select();
        $gamelist=D('Game')->where($map)->order('sort desc,id desc')->select();
        foreach($gamelist as &$vol){
            $vol['pic']=json_decode($vol['pic'],true);
        }

        $array=Array();
        foreach($paylist as $val){
            if(empty($val['fee'])){
                $val['fee']=1;
            }
            if(empty($val['money'])){
                $fixSelect=false;
            }else{
                $fixSelect=true;
                $val['money']=explode("\r\n",$val['money']);
            }

            if(empty($val['bank'])){
                $bank=false;
            }else{
                $bank=true;
            }

            $array[$val['tag']]=Array(
                'cn'=>$val['name'],
                'bank'=>$bank,
                'rate'=>$val['fee'],
                'fixSelect'=>$fixSelect,
				'card'=>$val['iscard'],
                'internalRate'=>1,
                'list'=>$val['money']
            );
        }
        $this->assign('json_pay',json_encode($array));
        $this->assign('paylist',$paylist);
        $this->assign('gamelist',$gamelist);
        $this->assign('gid',$gid);
        $this->assign('meta_title','充值中心');
        $this->display('index');
    }

	
	public function test(){
		
		PayApi(1);
		
		
		
	}
    public function _empty($name){
        $this->index(intval($name));
    }


}