<?php
namespace News\Controller;
use Think\Controller;
class ReadController extends NewsController {
  //  public function index(){

      //  $this->display();

   // }

    public function _empty($name){
        $id=intval($name);
        if(empty($id)){
            $this->redirect('Home/Index/Index');
        }
        $info = D('Document')->detail($id);
        if(empty($info)){
            $this->redirect('Home/Index/Index');
        }
        $result = D('Document')->where(array('id' => $id))->SetInc('view');//阅读量加1
        $this->assign('__info__',$info);
        $this->meta_title = $info['title'];
        if(!empty($info['typegame'])){
            $game=D('Game')->where(Array('id'=>$info['typegame']))->find();
				$url=D('Game')->getGameUrl($game['id']);
				$parse_url=parse_url($url);
				if($parse_url['host'] == 'game.'.DOMAIN()){
					$url=str_replace('.html','/news_read/id/'.$id.'.html',$url);
				}else{
					$url=$url.'/index.php/'.$game['mark'].'/news_read/id/'.$id.'.html';
				}
				redirect($url);
			
        }
		
		
		$this->display('Read/Index');
        

    }
}