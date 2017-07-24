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
 * 游戏玩家模型
 * @author C0de <47156503@qq.com>
 */
class GameplayModel extends Model{





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

    /**
     * 获取指定用户游戏记录
     * @param string $num 获取几条
     * @return array
     * @author jry <598821125@qq.com>
     */
    public function getGameplay($num,$gid=false){
        $uid=is_login();
        if($uid){
			if($gid){
				$map['gid']=$gid;
			}
            $map['uid']=$uid;
            $Gameplay=$this->where($map)->limit($num)->order('id desc')->select();
            if(empty($Gameplay)){
                return false;
            }
            foreach($Gameplay as $key=>$val){
                $game_map['id']=$val['gid'];
                $game=D('Game')->where($game_map)->find();
                $pic=json_decode($game['pic']);
                $Gameplay[$key]['game_name']=$game['name'];
                $Gameplay[$key]['icon']=$pic->pic_icon;

                $gameserver_map['id']=$val['sid'];
                $gameserver=D('Gameserver')->getColumnByfield('name', $gameserver_map);
                $Gameplay[$key]['server_name']=$gameserver[0];
            }
            return $Gameplay;
        }
        return false;
    }


    public function getCountGameplay($uid){
        $map['uid']=$uid;
        return $this->where($map)->count();
    }


}
