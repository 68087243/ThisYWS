<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 后台帖子控制器
 * @author C0de <47156503@qq.com>
 */
class ForumController extends AdminController{
    /**
     * 帖子列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title|gid|uid'] = array($condition, $condition, $condition, $condition,'_multi'=>true);

        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('ForumPost')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        $page = new \Common\Util\Page(D('ForumPost')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as &$val){
            $val['gid']=D('Game')->getFieldBymap('name',Array('id'=>$val['gid']));
			$val['uid']=D('User')->getFieldBymap('username',Array('id'=>$val['uid']));
			$val['type']=D('ForumType')->getFieldBymap('name',Array('id'=>$val['type']));
        }

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('帖子列表')  //设置页面标题
        ->addResumeButton("ForumPost") //添加启用按钮
        ->addForbidButton("ForumPost") //添加禁用按钮
        ->addDeleteButton("ForumPost") //添加删除按钮
        ->setSearch('请输入ID/标题/GID/UID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('title', '标题', 'text')
            ->addField('gid', '游戏', 'text')
            ->addField('type', '分类', 'text')
            ->addField('uid', '用户名', 'text')
            ->addField('type', '类型', 'text')
            ->addField('ctime', '发表时间', 'time')
            ->addField('status', '状态', 'status')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('edit')   //添加编辑按钮
            ->addRightButton('forbid',"ForumPost") //添加禁用/启用按钮
            ->addRightButton('delete',"ForumPost") //添加删除按钮
            ->setPage($page->show())
            ->display();
    }

    /**
     * 新增游戏
     * @author C0de <47156503@qq.com>
     */
    public function add(){
        if(IS_POST){
            $pic=Array();
            foreach($_POST as $key=>$val){
                if(strstr($key,'pic_')){
                    $pic[$key]=$val;
                }
            }
            $_POST['flags']=implode(',',$_POST['flags']);
            $_POST['pic']=json_encode($pic);
            $object = D('Game');
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
            $Gamesite=Array();
            foreach(D('Gamesite')->select() as $val){
                $Gamesite[$val['id']]=$val['name'];
            }
            $Gameapi=Array();
            foreach(D('Gameapi')->select() as $val){
                $Gameapi[$val['id']]=$val['name'];
            }
            $data=Array();
            $data['user_num']=rand(500,5000);
            $isdomain=array('0'=>'不启用','1'=>'启用');
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('新增游戏')  //设置页面标题
            ->setUrl(U('add')) //设置表单提交地址
                ->addItem('name', 'text', '名称', '游戏名称')
                ->addItem('mark', 'text', '标识', '标识[用于二级域名等]')
                ->addItem('theme', 'select', '主题', '*可留空', $Gamesite)
                ->addItem('isdomain', 'radio', '启用二级域名', '需要域名泛解析', $isdomain)
                ->addItem('tag', 'tags', '标签', false)
                ->addItem('api', 'select', '接口', '*选择接口', $Gameapi)
                ->addItem('api_id', 'text', '接口ID', false)
                ->addItem('unit', 'text', '单位', '如金币、元宝等')
                ->addItem('rate', 'text', '比率', '如1元=100金币')
                ->addItem('user_num', 'num', '玩家数量', false)
                ->addItem('type', 'select', '游戏类型', false, C('GAME_TYPE_LIST'))
                ->addItem('Initials', 'select', '首字母', false, C('GAME_INITIALS_LIST'))
                ->addItem('target', 'select', '打开方式', false, C('TARGET_LIST'))
                ->addItem('flags', 'checkbox', '属性', false, C('ATTRIBUTE_LIST'))
                ->addItem('pic_t', 'picture', '推荐图', '312*277')
                ->addItem('pic_j', 'picture', '精品图', '201*216')
                ->addItem('pic_r', 'picture', '热门图', '203*123')
                ->addItem('pic_l', 'picture', '列表图', '91*55')
                ->addItem('pic_t_max', 'picture', '大图', '428*311')
                ->addItem('pic_icon', 'picture', '小图标', '16*16')
                ->addItem('pic_icon_max', 'picture', '大图标', '16*16')
				->addItem('pic_bbs', 'picture', '版块图标', '226*98')
				->addItem('pic_bbs_bg', 'picture', '论坛背景', '1906*354')
                ->addItem('clienturl', 'text', '微端地址', '为空则盒子地址')
                ->addItem('summary', 'textarea', '摘要', '简短的摘要')
                ->addItem('description', 'kindeditor', '游戏介绍', false)
				->addItem('spread', 'text', '推广X,Y', '例:X,Y')
                ->setFormData($data)
                ->display();
        }
    }

    /**
     * 编辑帖子
     * @author C0de <47156503@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $object = D('ForumPost');
			$_POST['utime']=time();
            if($object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=D('ForumPost')->find($id);
            //使用FormBuilder快速建立表单页面。
			$_type=Array();
			foreach(M('ForumType')->select() as $val){
				$_type[$val['id']]=$val['name'];
			}
			$_game=Array();
			foreach(M('Game')->select() as $val){
				$_game[$val['id']]=$val['name'];
			}
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑帖子')  //设置页面标题
            ->setUrl(U('edit')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('title', 'text', '帖子标题')
				->addItem('type', 'select', '分类', false, $_type)
				->addItem('gid', 'select', '游戏', false, $_game)
                ->addItem('content', 'textarea', '内容')
                ->setFormData($data)
                ->display();
        }
    }
}
