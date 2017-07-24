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
 * 数据统计控制器
 * @author C0de <47156503@qq.com>
 */
class DataController extends AdminController{
    /**
     * 人数统计
     * @author C0de <47156503@qq.com>
     */
    public function index(){
		$today = strtotime(date('Y-m-d', time())); //今天
        $start_date = I('get.date_start') ? strtotime(I('get.date_start')) : $today-10*86400;
        $end_date   = I('get.date_end') ? strtotime(I('get.date_end')) : $today+86400;
        $count_day  = ($end_date-$start_date)/86400; //查询最近n天
        $user_object = D('User');
		$paylog_object = D('Paylog');
        for($i = 0; $i < $count_day; $i++){
            $day = $start_date + $i*86400; //第n天日期
            $day_after = $start_date + ($i+1)*86400; //第n+1天日期
			$map=Array();
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
            $_date[] = date('m月d日', $day);
            $user_reg_count[] = (int)$user_object->cache(true,60)->where($map)->count();
			$paylog_pay_count[]=(int)$paylog_object->cache(true,60)->where($map)->count();
			$map['paystatus']=2;
			$paylog_pay_2_count[]=(int)$paylog_object->cache(true,60)->where($map)->count();
        }

      

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\EchartsBuilder();
        $builder->title('人数统计')  //设置页面标题
            ->setUrl(U('index')) //设置表单提交地址
                ->addItem('date', 'timetotime', '时间')
				->addTitle("总注册人数:".array_sum($user_reg_count).' 总充值人数:'.array_sum($paylog_pay_count).' 总充值成功人数:'.array_sum($paylog_pay_2_count))
				->addCategory($_date)
				->addField("注册人数",$user_reg_count)
				->addField("充值人数",$paylog_pay_count)
				->addField("充值成功人数",$paylog_pay_2_count)
                ->display();
    }
	
	public function today_people (){
		$today = strtotime(date('Y-m-d')); //今天
        $start_date = I('get.date_start') ? strtotime(I('get.date_start')) : $today;
        $end_date   = I('get.date_end') ? strtotime(I('get.date_end')) : strtotime(date('Y-m-d H:i:s'));
        $count_day  = floor(($end_date-$start_date)/3600);; //查询几小时
        $user_object = D('User');
		$paylog_object = D('Paylog');
        for($i = 0; $i < $count_day; $i++){
            $day = $start_date + $i*3600; //第n天日期
            $day_after = $start_date + ($i+1)*3600; //第n+1天日期
			$map=Array();
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
            $_date[] = date('H:i', $day);
            $user_reg_count[] = (int)$user_object->cache(true,60)->where($map)->count();
			$paylog_pay_count[]=(int)$paylog_object->cache(true,60)->where($map)->count();
			$map['paystatus']=2;
			$paylog_pay_2_count[]=(int)$paylog_object->cache(true,60)->where($map)->count();
        }

      

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\EchartsBuilder();
        $builder->title('今天人数统计')  //设置页面标题
            ->setUrl(U('today_people')) //设置表单提交地址
                ->addItem('date', 'timetotime', '时间')
				->addTitle("总注册人数:".array_sum($user_reg_count).' 总充值人数:'.array_sum($paylog_pay_count).' 总充值成功人数:'.array_sum($paylog_pay_2_count))
				->addCategory($_date)
				->addField("注册人数",$user_reg_count)
				->addField("充值人数",$paylog_pay_count)
				->addField("充值成功人数",$paylog_pay_2_count)
                ->display();
    }
	
	/**
     * 充值统计
     * @author C0de <47156503@qq.com>
     */
    public function pay(){
		$today = strtotime(date('Y-m-d', time())); //今天
        $start_date = I('get.date_start') ? strtotime(I('get.date_start')) : $today-10*86400;
        $end_date   = I('get.date_end') ? strtotime(I('get.date_end')) : $today+86400;
        $count_day  = ($end_date-$start_date)/86400; //查询最近n天
		$paylog_object = D('Paylog');
        for($i = 0; $i < $count_day; $i++){
            $day = $start_date + $i*86400; //第n天日期
            $day_after = $start_date + ($i+1)*86400; //第n+1天日期
			$map=Array();
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
            $_date[] = date('m月d日', $day);
			if(I('paytoname')){
				$map['paytoname']=I('paytoname');
			}
			$paylog_pay_count[]=(int)$paylog_object->cache(true,60)->where($map)->count();
			$map['paystatus']=2;
			$paylog_pay_2 = $paylog_object->cache(true,60)->where($map)->select();
			$paylog_pay_2_count[]=count($paylog_pay_2);
			$_temp_payamount=0;
			if(is_array($paylog_pay_2)){
				foreach($paylog_pay_2 as $val){
					$_temp_payamount=$_temp_payamount+$val['payamount'];
				}
			}
			$paylog_pay_2_payamount[]=$_temp_payamount;
        }
		
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\EchartsBuilder();
        $builder->title('充值统计')  //设置页面标题
            ->setUrl(U('pay')) //设置表单提交地址
				->addItem('paytoname', 'text', '用户名')
                ->addItem('date', 'timetotime', '时间')
				->addTitle("总收入(元):".array_sum($paylog_pay_2_payamount).' 总充值人数:'.array_sum($paylog_pay_count).' 总充值成功人数:'.array_sum($paylog_pay_2_count))
				->addCategory($_date)
				->addField("收入金额",$paylog_pay_2_payamount)
				->addField("充值人数",$paylog_pay_count)
				->addField("充值成功人数",$paylog_pay_2_count)
				->setFormData($_GET)
                ->display();
    }
	
	public function today_pay(){
		$today = strtotime(date('Y-m-d', time())); //今天
        $start_date = I('get.date_start') ? strtotime(I('get.date_start')) : $today;
        $end_date   = I('get.date_end') ? strtotime(I('get.date_end')) : strtotime(date('Y-m-d H:i:s'));
        $count_day  = floor(($end_date-$start_date)/3600);; //查询几小时
		$paylog_object = D('Paylog');
        for($i = 0; $i < $count_day; $i++){
            $day = $start_date + $i*3600; //第n天日期
            $day_after = $start_date + ($i+1)*3600; //第n+1天日期
			$map=Array();
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
            $_date[] = date('H:i', $day);
			if(I('paytoname')){
				$map['paytoname']=I('paytoname');
			}
			$paylog_pay_count[]=(int)$paylog_object->cache(true,60)->where($map)->count();
			$map['paystatus']=2;
			$paylog_pay_2 = $paylog_object->cache(true,60)->where($map)->select();
			$paylog_pay_2_count[]=count($paylog_pay_2);
			$_temp_payamount=0;
			if(is_array($paylog_pay_2)){
				foreach($paylog_pay_2 as $val){
					$_temp_payamount=$_temp_payamount+$val['payamount'];
				}
			}
			$paylog_pay_2_payamount[]=$_temp_payamount;
        }
		
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\EchartsBuilder();
        $builder->title('今天充值统计')  //设置页面标题
            ->setUrl(U('today_pay')) //设置表单提交地址
				->addItem('paytoname', 'text', '用户名')
                ->addItem('date', 'timetotime', '时间')
				->addTitle("总收入(元):".array_sum($paylog_pay_2_payamount).' 总充值人数:'.array_sum($paylog_pay_count).' 总充值成功人数:'.array_sum($paylog_pay_2_count))
				->addCategory($_date)
				->addField("收入金额",$paylog_pay_2_payamount)
				->addField("充值人数",$paylog_pay_count)
				->addField("充值成功人数",$paylog_pay_2_count)
				->setFormData($_GET)
                ->display();
    }
	
	public function game(){
		$today = strtotime(date('Y-m-d', time())); //今天
        $start_date = I('get.date_start') ? strtotime(I('get.date_start')) : $today-10*86400;
        $end_date   = I('get.date_end') ? strtotime(I('get.date_end')) : $today+86400;
        $count_day  = ($end_date-$start_date)/86400; //查询最近n天
		$gamelog_object = D('Gamelog');
        for($i = 0; $i < $count_day; $i++){
            $day = $start_date + $i*86400; //第n天日期
            $day_after = $start_date + ($i+1)*86400; //第n+1天日期
			$map=Array();
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
            $_date[] = date('m月d日', $day);
            $game_count[] = (int)$gamelog_object->cache(true,60)->where($map)->count();
        }
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\EchartsBuilder();
        $builder->title('进游戏人数统计')  //设置页面标题
            ->setUrl(U('index')) //设置表单提交地址
                ->addItem('date', 'timetotime', '时间')
				->addTitle("总进游戏人数:".array_sum($game_count))
				->addCategory($_date)
				->addField("进游戏人数",$game_count)
				->display();
    }
	
	public function today_game(){
		$today = strtotime(date('Y-m-d', time())); //今天
		$start_date = I('get.date_start') ? strtotime(I('get.date_start')) : $today;
        $end_date   = I('get.date_end') ? strtotime(I('get.date_end')) : strtotime(date('Y-m-d H:i:s'));
        $count_day  = floor(($end_date-$start_date)/3600);; //查询几小时
		$gamelog_object = D('Gamelog');
        for($i = 0; $i < $count_day; $i++){
            $day = $start_date + $i*3600; //第n天日期
            $day_after = $start_date + ($i+1)*3600; //第n+1天日期
			$map=Array();
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
            $_date[] = date('H:i', $day);
            $game_count[] = (int)$gamelog_object->cache(true,60)->where($map)->count();
        }
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\EchartsBuilder();
        $builder->title('今日进游戏人数统计')  //设置页面标题
            ->setUrl(U('index')) //设置表单提交地址
                ->addItem('date', 'timetotime', '时间')
				->addTitle("总进游戏人数:".array_sum($game_count))
				->addCategory($_date)
				->addField("进游戏人数",$game_count)
                ->display();
    }

}
