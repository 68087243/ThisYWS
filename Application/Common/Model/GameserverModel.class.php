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
class GameserverModel extends Model{


    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        //
        array('name', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('sid', 'require', 'SID不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('line', 'require', '线路不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('game', 'require', '游戏不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),

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
	
	public function getNewServerBygid($gid){
        $map['status']=array('eq',1);
        $map['game']=$gid;
		$map['ktime']=array('lt',time());
        return $this->where($map)->order('id desc')->find();
    }

    public function getNewServerUrlBygid($gid){
        $map['status']=array('eq',1);
        $map['game']=$gid;
		$map['ktime']=array('lt',time());
        $data= $this->where($map)->order('id desc')->find();
        return U('Gateway/Game/Play',array('gid'=>$data['game'],'sid'=>$data['id']));
    }
	
	public function getGameServerIdByGidSid($game,$id){
		$map['game']=$game;
		$data= $this->where($map)->cache('getGameServerIdByGidSid'.$game,60)->select();
		$sid=0;
		foreach($data as $key=>$val){
			 if($val['id'] == $id ){ 
				$sid=$key+1;
				break;
			 }
		}
		return $sid;
	}






}
