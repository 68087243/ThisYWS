<?php

namespace Admin\Controller;
use Think\Controller;
use Common\Util\QueryList\QueryList;
use phpQuery;
/**
 * 采集任务控制器
 * @author C0de <47156503@qq.com>
 */
class GatherTaskController extends AdminController{
    /**
     * 采集任务列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
		$this->meta_title = "执行采集";
		$rule=M('GatherRule')->select();
		$game=M('Game')->select();
		$category=M('Category')->select();
		$this->assign("rule",$rule);
		$this->assign("game",$game);
		$this->assign("category",$category);
        $this->display();
    }
	
	private $result=array();
	private $title=array();
	private $keyword=array();
	private $title_dom;
	private $title_delete;
	private $content_dom;
	private $content_delete;
	private $body;
	private $list_url;
	

	public function task(){
		set_time_limit(0);
		G('begin');
		$ajax['status']=1;
		if(I('wyc')==1){
			if(file_exists(RUNTIME_PATH.'keyword.php')){
				require(RUNTIME_PATH.'keyword.php');
				$this->keyword=$keyword_arr;
			}else{
				$ajax['status']=0;
				$ajax['info']='伪原创词库不存在，请静态生成!';
			}
		}
		if($ajax['status'] == 1){
			$GatherRule=M('GatherRule')->cache(120)->find(I('rule'));
			$this->list_url=$list_url=str_replace("*",I('cid'),I('url'));
			//采集该页面文章列表中所有[文章]的超链接
			$url = QueryList::Query($list_url,array('link' => array($GatherRule['list_dom'],'href',$GatherRule['list_body'])))->data;
			$urls=Array();
			$url_arr=parse_url($list_url);
			foreach($url as $val){
				 if(!preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$val['link'])){
					$urls[]='http://'.$url_arr['host'].'/'.$val['link'];
				}else{
					$urls[]=$val['link'];
				}
			}
			if(!empty($urls)){
				$this->title_dom=$GatherRule['title_dom'];
				$this->title_delete=$GatherRule['title_delete'];
				$this->content_dom=$GatherRule['content_dom'];
				$this->content_delete=$GatherRule['content_delete'];
				$this->body=$GatherRule['body'];
				//多线程扩展
				QueryList::run(
					'Multi',[
						'list' => $urls,
						'curl' => [
							'opt' => array(
								CURLOPT_SSL_VERIFYPEER => false,
								CURLOPT_SSL_VERIFYHOST => false,
								CURLOPT_FOLLOWLOCATION => true,
								CURLOPT_AUTOREFERER => true,
							),
						//设置线程数
						'maxThread' => I('maxthread'),
						//设置最大尝试数
						'maxTry' => I('maxtry')
					],
					'success' => function($a){
						if($a['info']['http_code']==200){
						//采集规则
						$reg = array(
							'title' => array($this->title_dom,'text',$this->title_delete),
							'content' => array($this->content_dom,'html',$this->content_delete,function($content){
								if(I("saveimg")=="1"){
									$doc = phpQuery::newDocumentHTML($content);
									$imgs = pq($doc)->find('img');
									foreach ($imgs as $img) {
										$src = pq($img)->attr('src');
										$_temp=explode(".",$src);
										$dir='./Uploads/gather/'.I('game').'/';
										if(!is_dir($dir)){
											mkdir($dir,0777);
										}
										$localSrc = './Uploads/gather/'.I('game').'/'.md5($src).'.'.end($_temp);
										$img_url = 'http://static'.DOMAIN.'/Uploads/gather/'.I('game').'/'.md5($src).'.'.end($_temp);
										if(!file_exists($localSrc)){
											if(I('sy')=='1'){
												$image = new \Think\Image(); 
												$image->open($src)->text(C('WEB_SITE_TITLE'),CORE_PATH.'/Image/Font/msyh.ttf',30,'#00bb12',\Think\Image::IMAGE_WATER_SOUTHEAST)->text('® www'.DOMAIN,CORE_PATH.'/Image/Font/BeauRivageOne.TTF',20,'#c149ff',\Think\Image::IMAGE_WATER_NORTH)->save($localSrc); 
											}else{
												$stream = $this->http_get_data($src,$this->list_url);
												file_put_contents($localSrc,$stream);
											}
											
											
										}
										explode(".",$localSrc);
										pq($img)->attr('src',$img_url);
									}
									return $doc->htmlOuter();
								}else{
									return $content;
								}
								
							})
						);
						$ql = QueryList::Query($a['content'],$reg,$this->body);
						$data = $ql->getData();
						$_doc=M('GatherDoc')->where(Array('url'=>$a['info']['url']))->find();
						if(!empty($data[0]) && !empty($data[0]['title']) && empty($_doc)){
							$data[0]['game']=I('game');
							$data[0]['cid']=I('lid');
							$data[0]['url']=$a['info']['url'];
							$data[0]['ctime']=time();
							$data[0]['utime']=time();
							$data[0]['sort']=0;
							$data[0]['status']=1;
							if(I('wyc')=='1'){
								$data[0]['content']=strtr($data[0]['content'],$this->keyword);
								$data[0]['title']=strtr($data[0]['title'],$this->keyword);
							}
							$this->result[]=$data[0];
							$this->title[]=$data[0]['title'];
						}
						}
					}
					]
				);
			}
			D('GatherDoc')->addAll($this->result);
		}
		G('end');
		
		$ajax['url']=$list_url;
		$ajax['time']=G('begin','end').'s';
		$ajax['count']=count($this->result);
		//$ajax['list']=$this->title;
		$this->ajax($ajax);
	}
	
	private function http_get_data($url,$ref) {  
        $ch = curl_init ();  
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);  
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $ref);
		curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)");
		curl_setopt($ch, CURLOPT_TIMEOUT,10);
        ob_start();
        curl_exec ($ch);  
        $return_content = ob_get_contents ();  
        ob_end_clean ();  
        //$return_code = curl_getinfo ($ch,CURLINFO_HTTP_CODE);  
        return $return_content;  
    }  
	
}
