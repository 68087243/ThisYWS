<?php
namespace News\Controller;
use Think\Controller;
class IndexController extends NewsController {

    public function index($cid=0){

        if(!empty($cid)){
            $map['cid'] = $cid;
            $category = D('Category')->find($cid);
            $this->meta_title = $category['title'];
        }else{
            $this->meta_title = '最新资讯';
        }
        $map['status'] = array('eq', 1);
        $document_list = D('Document')->page(!empty($_GET["p"])?$_GET["p"]:1, 16)
            ->order('sort desc,id desc')->where($map)->select();
        //分页
        $page = new \Common\Util\Page(D('Document')->where($map)->count(), 16);

        $this->assign('volist', $document_list);
        $this->assign('page', $page->show());
        $this->assign('cid', $cid);
        $this->display('Index');
    }


    public function _empty($name){
        $this->index(intval($name));
    }

}