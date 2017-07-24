<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 伪原创词库控制器
 * @author C0de <47156503@qq.com>
 */
class GatherKeywordsController extends AdminController{
    /**
     * 采集规则列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){


        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|keyword|replace'] = array($condition, $condition,$condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('GatherKeywords')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('GatherKeywords')->where($map)->count(), C('ADMIN_PAGE_ROWS'));


        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('伪原创词库')  //设置页面标题
		->AddNewButton()    //添加新增按钮
        ->addResumeButton() //添加启用按钮
        ->addForbidButton() //添加禁用按钮
        ->addDeleteButton() //添加删除按钮
		->addButton("静态生成 ",Array("class"=>"btn","href"=>U('set')))
        ->setSearch('请输入ID/关键字/替换词', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('keyword', '关键字', 'text')
			->addField('replace', '替换词', 'text')
            ->addField('ctime', '添加时间', 'time')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('edit')   //添加编辑按钮
            ->addRightButton('forbid') //添加禁用/启用按钮
            ->addRightButton('delete') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }
	
	/**
     * 伪原创词库添加
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $object = D('GatherKeywords');
            $data = $object->create();
            if($data){
                $id = $object->add();
                if($id){
                    $this->success('新增成功', U('index'));
                }else{
                    $this->error('新增失败');
                }
            }else{
                $this->error($object->getError());
            }
        }else{
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('伪原创词库添加')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('keyword', 'text', '关键字')
				->addItem('replace', 'text', '替换词')
                ->display();
        }
    }
	
	public function set(){
		$str="<?php\r\n";
		$str.="\$keyword_arr = array (\r\n";
		
		$data=M('GatherKeywords')->select();
		foreach($data as $row){
			$str.="	'$row[keyword]' => '$row[replace]',";
		}
		$str.=");\r\n";
		$str.="?>\r\n";
		$filename=RUNTIME_PATH.'keyword.php';
		$handle=fopen($filename,"w");
		if(!is_writable($filename)){
			die ("文件：".$filename."不可写，请检查其属性后重试!");
		}
		if(!fwrite($handle,$str)){
			die ("生成文件".$filename."失败!");
		}
		fclose ($handle); //关闭指针
		
		$this->success('生成成功', U('index'));
	}
	



    /**
     * 伪原创词库编辑
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('GatherKeywords');
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('GatherKeywords')->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('伪原创词库编辑')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('keyword', 'text', '关键字')
				->addItem('replace', 'text', '替换词')
                ->setFormData($data)
                ->display();
        }
    }
}
