<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Common\Model;
use Think\Model;
/**
 * 游戏模型
 * @author C0de <47156503@qq.com>
 */
class CardDetailModel extends Model{


    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        //验证注册类型
        array('name', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('gid', 'require', 'gid不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('level', 'require', '领取等级不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),

    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('ctime', NOW_TIME, self::MODEL_INSERT),
        array('utime', NOW_TIME, self::MODEL_BOTH),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );



    /**
     * 获取所有所有用户指定字段值
     * @param string $field 字段
     * @return array
     * @author jry <598821125@qq.com>
     */
    public function getColumnByfield($field = 'email', $map){
        return $this->where($map)->getField($field,true);
    }

    public function getFieldBymap($field,$map){
        $data=$this->where($map)->find();
        return $data[$field];
    }


    public function getAllgiftByGame(){
        $map['status']=array('eq',1);
        $data_card=$this->distinct(true)->where($map)->field('gid')->order('id desc')->select();
		$data_mix=D('Mixgift')->distinct(true)->where($map)->field('game as gid')->order('id desc')->select();
		$data=array_merge($data_card,$data_mix);
		foreach ($data as $v){
			$v=join(',',$v);  //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
			$temp[]=$v;
		}
		$temp=array_unique($temp);
		foreach ($temp as $k => $v){
			$temp[$k]=explode(',',$v);
		}

        foreach($temp as &$val){
            $val=D('Game')->where(Array('id'=>$val[0]))->find();
            $val['pic']=json_decode($val['pic'],true);
        }
		
        return $temp;
    }

}
