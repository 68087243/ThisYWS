<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 采集文章控制器
 * @author C0de <47156503@qq.com>
 */
class GatherDocController extends AdminController{
    /**
     * 采集文章列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title|content'] = array($condition, $condition,$condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('GatherDoc')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('GatherDoc')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		$game_obj=M('Game');
		$category_obj=M('Category');
		foreach($data_list as &$val){
			$game_data=$game_obj->find($val['game']);
			$val['game_name']=$game_data['name'];
			$category_data=$category_obj->find($val['cid']);
			$val['category_name']=$category_data['title'];
		}


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('采集文章管理')  //设置页面标题
		->addButton("发布 ",Array("class"=>"btn ajax-post confirm","href"=>U('send'),'target-form'=>'ids'))
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
		->addButton("清空 ",Array("class"=>"btn","href"=>U('clear')))
        ->setSearch('请输入ID/关键字/替换词', U('index'))
            ->addField('id', 'ID', 'text')
			->addField('category_name', '游戏', 'text')
			->addField('game_name', '游戏', 'text')
            ->addField('title', '标题', 'text')
			->addField('url', '采集URL', 'text')
            ->addField('ctime', '采集时间', 'time')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('edit')   //添加编辑按钮
            ->addRightButton('forbid') //添加禁用/启用按钮
            ->addRightButton('delete') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }
	
	public function clear(){
		$sql="DROP TABLE IF EXISTS `ct_gather_doc`;
CREATE TABLE `ct_gather_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `game` int(11) DEFAULT NULL,
  `url` text,
  `title` text,
  `content` text,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  `sort` tinyint(4) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
		D('GatherDoc')->execute($sql);
		$this->success('清空成功', U('index'));
	}
	

	public function send(){
		$arr=I('ids');
		$GatherDoc_obj=M('GatherDoc');
		$result=true;
		foreach($arr as $val){
			$GatherDoc_data=$GatherDoc_obj->find($val);
			$_POST['title']=$GatherDoc_data['title'];
			$_POST['abstract']=mb_substr($GatherDoc_data['content'], 0, 30, 'utf-8');
			$_POST['typegame']=$GatherDoc_data['game'];
			$_POST['cid']=$GatherDoc_data['cid'];
			$_POST['content']=$GatherDoc_data['content'];
			$document_object = D('Document');
			$result = $document_object->update();
			if(!$result){
				$result=false;
			}else{
				$GatherDoc_obj->delete($val);
				$result=true;
			}
		}
		if($result){
			$this->ajax(Array('info'=>"发布成功",'status'=>1,'url'=>''));
			
		}else{
			$this->ajax(Array('info'=>"发布失败",'status'=>0,'url'=>''));
		}
		//$this->ajax(Array('info'=>"发布失败",'status'=>0,'url'=>));
	}



    /**
     * 文章编辑
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('GatherDoc');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
			$category=Array();
			foreach(M('Category')->select() as $val){
				$category[$val['id']]=$val['title'];
			}
			$game=Array();
			foreach(M('Game')->select() as $val){
				$game[$val['id']]=$val['name'];
			}
            $data=D('GatherDoc')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('文章编辑')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
				->addItem('cid','select','栏目',false,$category)
				->addItem('game','select','游戏',false,$game)
                ->addItem('title', 'text', '标题')
				->addItem('content', 'kindeditor', '内容')
                ->setFormData($data)
                ->display();
        }
    }
}
