<?php

namespace Common\Model;
use Think\Model;
/**
 * 游戏模型
 * @author C0de <47156503@qq.com>
 */
class GameModel extends Model{


    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        //验证注册类型
        array('name', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('mark', 'require', '标识不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('mark', '', '标识被占用', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),

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


    public function uplog($game,$server,$user,$pt=0){
        $map['uid']=$user['id'];
        $map['gid']=$game['id'];
        $map['sid']=$server['id'];
		if($user['identification']){
			$map['identification']=$user['identification'];
			$map['identification_uid']=$user['identification_uid'];
		}
        $gameplay=D('Gameplay');

        $play=$gameplay->where($map)->find();
        if(empty($play)){
            $map['ctime']=time();
            $map['ztime']=time();
            $map['utime']=time();
            $gameplay->add($map);
        }else{
            $data['ztime']=time();
            $gameplay->where(Array('id'=>$play['id']))->save($data);
        }
        unset($map['ztime']);
        $map['ctime']=time();
        $map['utime']=time();
        $map['ip']=get_client_ip();
        $map['useragent']=get_useragent();
        $map['source']=$pt;
        D('Gamelog')->add($map);
    }

    public function getGameUrl($gid,$act=null){
        $map['id']=$gid;
        $data=$this->where($map)->find();
        if(empty($data['isdomain'])){
			$act=($act!=null)?:'index';
            return U('Game/'.$data['mark'].'/'.$act);
        }else{
			$act=($act!=null)?$data['mark'].'/'.$act.'.html':'';
            return 'http://'.$data['mark'].DOMAIN.'/'.$act;
        }
    }
	
	public function randGame(){
		$_data=$this->order('rand()')->find();
		return $this->getGameUrl($_data['id']);
	}

    //首页游戏列表渲染&&算法
    public function getIndexdata(){
        //tjyx  数量 6  规则 置顶、推荐
        //jpyx  数量8   规则 推荐
        //rmyx  数量12  规则 热门
        $Game=Array();
        $map['status']=array('eq',1);
        $data=$this->where($map)->order('sort desc,flags desc')->limit(26)->select();//取所有游戏
        foreach($data as $key=>$val){
            $data[$key]['pic']=json_decode($val['pic'],true);
            $data[$key]['flags']=flags($val['flags']);
            $data[$key]['flagsnum']=count($data[$key]['flags']);
        }
        $Game['all']=$data;
        //$data=sort_field('SORT_DESC','flagsnum',$data);
        foreach($data as $key=>$val){
            if(count($Game['tjyx']) < 3 && !empty($data)){
                    if($val['flags']['z'] && $val['flags']['t'] && $val['flags']['r']){
                        $Game['tjyx'][]=$data[$key];
                        unset($data[$key]);
                        continue;
                    }else if($val['flags']['t'] && $val['flags']['r']){
                        $Game['tjyx'][]=$data[$key];
                        unset($data[$key]);
                        continue;
                    }else if($val['flags']['t']){
                        $Game['tjyx'][]=$data[$key];
                        unset($data[$key]);
                        continue;
                    }else if($val['flags']['r']){
                        $Game['tjyx'][]=$data[$key];
                        unset($data[$key]);
                        continue;
                    }else{
                        $Game['tjyx'][]=$data[$key];
                        unset($data[$key]);
                        continue;
                    }
            }else{
                break;
            }
        }
        foreach($data as $key=>$val){
            if(count($Game['jpyx']) < 8 && !empty($data)){
                if($val['flags']['t'] && $val['flags']['r']){
                    $Game['jpyx'][]=$data[$key];
                    unset($data[$key]);
                    continue;
                }else if($val['flags']['t']){
                    $Game['jpyx'][]=$data[$key];
                    unset($data[$key]);
                    continue;
                }else if($val['flags']['r']){
                    $Game['jpyx'][]=$data[$key];
                    unset($data[$key]);
                    continue;
                }else{
                    $Game['jpyx'][]=$data[$key];
                    unset($data[$key]);
                    continue;
                }
            }else{
                break;
            }
        }
        foreach($data as $key=>$val){
            if(count($Game['rmyx']) < 12 && !empty($data)){
                if($val['flags']['t']){
                    $Game['rmyx'][]=$data[$key];
                    unset($data[$key]);
                    continue;
                }else if($val['flags']['r']){
                    $Game['rmyx'][]=$data[$key];
                    unset($data[$key]);
                    continue;
                }else{
                    $Game['rmyx'][]=$data[$key];
                    unset($data[$key]);
                    continue;
                }
            }else{
                break;
            }
        }
        return $Game;
    }

    public function getList(){
        $map['status']=array('neq',0);
        $data=$this->where($map)->order('id desc')->select();
        foreach($data as $key=>$val){
            $data[$key]['pic']=json_decode($val['pic'],true);
            if(!empty($val['tag'])){
                $_temp=explode(',',$val['tag']);
                $data[$key]['tag']=$_temp[0];
            }
        }
        return $data;
    }

    public function getGameArray(){
        $map['status']=array('eq',1);
        $data=$this->field('id,name')->where($map)->order('id desc')->select();
        $array=Array();
        foreach($data as $key=>$val){
            $array[$val['id']]=$val['name'];
        }
        $array[0]='无';
        return $array;
    }

    //游戏中心游戏推荐
    public function getGamedata(){
        //tjyx  数量 5  规则 置顶、推荐
        $Game = Array();
        $map['status'] = array('eq', 1);
        $data = $this->where($map)->order('flags desc,id desc')->select();//取所有游戏
        foreach ($data as $key => $val) {
            $data[$key]['pic'] = json_decode($val['pic'], true);
            $data[$key]['flags'] = flags($val['flags']);
            $data[$key]['flagsnum'] = count($data[$key]['flags']);
        }
        $data = sort_field('SORT_DESC', 'flagsnum', $data);
        $Game=Array();
        foreach ($data as $key => $val) {
            if (count($Game) < 5 && !empty($data)) {
                if ($val['flags']['z'] && $val['flags']['t'] && $val['flags']['r'] && $val['flags']['x']) {
                    $Game[] = $data[$key];
                    unset($data[$key]);
                    continue;
                } else if ($val['flags']['t'] && $val['flags']['x']) {
                    $Game[] = $data[$key];
                    unset($data[$key]);
                    continue;
                } else if ($val['flags']['t']) {
                    $Game[] = $data[$key];
                    unset($data[$key]);
                    continue;
                } else if ($val['flags']['x']) {
                    $Game[] = $data[$key];
                    unset($data[$key]);
                    continue;
                } else {
                    $Game[] = $data[$key];
                    unset($data[$key]);
                    continue;
                }
            } else {
                break;
            }
        }
        return $Game;
    }

}
