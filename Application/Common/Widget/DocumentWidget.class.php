<?php

namespace Common\Widget;
use Think\Controller;
class DocumentWidget extends Controller {

    public function getListByCid($num,$cid=false,$cache='getListByCid'){
        $cache=md5($cache.'_'.$num.$cid);
        $obj=D('Document');
        $map['status']=array('eq',1);
        if($cid){
            $map['cid']=$cid;
        }
        $data=$obj->where($map)->order('sort desc,id desc')->limit($num)->cache($cache,2000)->select();
        return $data;
    }
	
	public function getNewsListByGid($gid,$cid,$num,$cache="getNewsListByGid"){
		$cache=md5($cache.'_'.$num.$cid.$gid);
		if($cid){
			$map['cid']=$cid;
		}else{
			$_arr=D('Category')->where(Array('post_auth'=>1))->select();
			if(is_array($_arr)){
					foreach($_arr as $v){
						$_cid[]=$v['id'];
					}
					if(!empty($_cid)){
						$map['cid']=array("in",implode(",",$_cid));
					}
			}
		}
		$map['typegame']=$gid;
		return D('Document')->join('ct_document_extend_article ON ct_document_extend_article.id = ct_document.id')->limit(5)->order('ct_document.id desc')->where($map)->limit($num)->cache($cache,2000)->select();
	}



}






?>