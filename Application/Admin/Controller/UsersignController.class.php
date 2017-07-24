<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台签到控制器
 * @author C0de <47156503@qq.com>
 */
class UsersignController extends AdminController{


    /**
     * 签到列表
     * @author C0de <47156503@qq.com>
     */
    public function index(){
        //搜索
        $keyword = (string)I('keyword');
        $condition = array('like','%'.$keyword.'%');
        $map['id|uid|platform|qtime'] = array($condition, $condition, $condition, $condition,'_multi'=>true);


        $data_list = D('UserSign')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('UserSign')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
        foreach($data_list as $key=>$val){
            $data_list[$key]['uid']=get_user_info($val['uid'],'username');

            $platform=C('SOURCE_LIST');
            $data_list[$key]['platform']=$platform[$val['platform']];
        }
        //使用Builder快速建立列表页面。
        $switch=Array('0'=>'关','1'=>'开');
        $builder = new \Common\Builder\ListBuilder();
        $builder->title('签到列表')  //设置页面标题
        ->addDeleteButton() //添加删除按钮
        ->setSearch('请输入ID/新手卡/GID/CID', U('index'))
            ->addField('id', 'ID', 'text')
            ->addField('uid', '用户名', 'text')
			->addField('score', '奖励积分', 'text')
			->addField('vip_score', 'VIP额外奖励积分', 'text')
			->addField('continuous', '连续签到奖励积分', 'text')
			->addField('continuous_num', '连续签到天数', 'text')
            ->addField('platform', '签到平台', 'select')
            ->addField('qtime', '签到时间', 'text')
            ->addField('right_button', '操作', 'btn')
            ->dataList($data_list)    //数据列表
            ->addRightButton('delete','UserSign') //添加删除按钮
            ->setPage($page->show())
            ->display();
    }




    /**
     * 编辑配置
     * @author C0de <47156503@qq.com>
     */
    public function config(){
        if(IS_POST){
            $object = M('UserSignConfig');
			
            if($object->save($_POST)){
                $this->success('更新成功', U('config'));
            }else{
                $this->error('更新失败', $object->getError());
            }
        }else{
            $data=M('UserSignConfig')->find(array('id'=>1));
            $switch=Array('0'=>'关','1'=>'开');
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->title('编辑签到配置')  //设置页面标题
            ->setUrl(U('config')) //设置表单提交地址
            ->addItem('id', 'hidden', 'ID', 'ID')
                ->addItem('switch', 'select', '开关', false, $switch)
                ->addItem('reward_score', 'text', '奖励积分', '0或空则不奖励')
                ->addItem('extra_vip_score', 'text', 'VIP额外奖励积分', '0或空则不奖励，额外奖励积分*VIP等级')
				->addItem('continuous', 'textarea', '连续签到奖励', '天数:奖励积分')
                ->setFormData($data)
                ->display();
        }
    }
}
