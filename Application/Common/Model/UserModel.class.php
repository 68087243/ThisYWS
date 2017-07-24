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
 * 用户模型
 * @author jry <598821125@qq.com>
 */
class UserModel extends Model{
    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        //验证注册类型
        array('reg_type', 'require', '注册类型不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),

        //验证邮箱
        array('email', 'email', '邮箱格式不正确', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('email', '1,32', '邮箱长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
        array('email', '', '邮箱被占用', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),

        //验证手机号码
        array('mobile', '/^1\d{10}$/', '手机号码格式不正确', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('mobile', '', '手机号被占用', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),

        //验证密码
        array('password', 'require', '密码不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
        array('password', '6,30', '密码长度为6-30位', self::MUST_VALIDATE, 'length', self::MODEL_INSERT),
        array('repassword', 'password', '两次输入的密码不一致', self::EXISTS_VALIDATE, 'confirm', self::MODEL_INSERT),

        //验证用户名
        array('username', 'require', '用户名不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('username', '4,32', '用户名为4-32位', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
        array('username', '', '用户名被占用', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
        array('username', 'checkIP', '注册太频繁请稍后再试', self::MUST_VALIDATE, 'callback', self::MODEL_INSERT), //IP限制
        array('username', '/^(?!.*?_$)[\w\一-\龥]+$/', '用户名只可含有汉字、数字、字母、下划线且不以下划线开头结尾，不以数字开头！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),

        array('sex', 'number', '请选择性别', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('avatar', 'number', '请上传头像', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),

        //重置密码时自动验证规则
        array('email', 'email', '邮箱格式不正确', self::EXISTS_VALIDATE, 'regex', 5),
        array('email', '1,32', '邮箱长度为1-32个字符', self::EXISTS_VALIDATE, 'length', 5),
        array('mobile', '/^1\d{10}$/', '手机号码格式不正确', self::EXISTS_VALIDATE, 'regex', 5),
        array('password', 'require', '密码不能为空', self::EXISTS_VALIDATE, 'regex', 5),
        array('password', '6,30', '密码长度为6-30位', self::EXISTS_VALIDATE, 'length', 5),
        array('password', '/(?!^(\d+|[a-zA-Z]+|[~!@#$%^&*()_+{}:"<>?\-=[\];\',.\/]+)$)^[\w~!@#$%^&*()_+{}:"<>?\-=[\];\',.\/]+$/', '密码至少由数字、字符、特殊字符三种中的两种组成', self::EXISTS_VALIDATE, 'regex', 5),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('password', 'user_md5', self::MODEL_INSERT, 'function'),
        array('group', '0', self::MODEL_INSERT),
        array('score', '0', self::MODEL_INSERT),
        array('money', '0', self::MODEL_INSERT),
        array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function'),
        array('ctime', NOW_TIME, self::MODEL_INSERT),
        array('utime', NOW_TIME, self::MODEL_BOTH),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
        array('reg_type', '', self::MODEL_UPDATE, 'ignore'),
        array('email', '', self::MODEL_UPDATE, 'ignore'),
        array('mobile', '', self::MODEL_UPDATE, 'ignore'),
        array('password', '', self::MODEL_UPDATE, 'ignore'),
        array('group', '', self::MODEL_UPDATE, 'ignore'),
        array('score', '', self::MODEL_UPDATE, 'ignore'),
        array('money', '', self::MODEL_UPDATE, 'ignore'),
        array('realname', '', self::MODEL_BOTH, 'ignore'),
        array('idcard_no', '', self::MODEL_BOTH, 'ignore'),
        array('avatar', '1',self::MODEL_INSERT),
        //重置密码时自动完成规则
        array('password', 'user_md5', 5, 'function'),
    );


    /**
     * 更新用户信息（前台用户使用，后台管理员更改用户信息不使用create及此方法）
     * @param  array $data 用户信息
     * @return bool
     * @author jry <598821125@qq.com>
     */
    public function update($data){
        //不修改密码时销毁变量防止create报错
        if($data['password'] == ''){
            unset($data['password']);
        }
        //不允许更改超级管理员用户组
        if($data['id'] == 1){
            unset($data['group']);
        }
        if($data['extend']){
            $data['extend'] = json_encode($data['extend']);
        }
        $data = $this->create($data);
        if($data){
            $result = $this->save($data);
            return $result;
        }
        return false;
    }

    /**
     * 用户登录
     * @author jry <598821125@qq.com>
     */
    public function login($username, $password, $map){
        if(preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $username)){
            $map['email'] = array('eq', $username); //邮箱登陆
        }elseif(preg_match("/^1\d{10}$/", $username)){
            $map['mobile'] = array('eq', $username); //手机号登陆
        }else{
            $map['username'] = array('eq', $username); //用户名登陆
        }
        $map['status']   = array('eq', 1);
        $user = $this->where($map)->find(); //查找用户
        if(!$user){
            $this->error = '用户不存在或被禁用！';
        }else{
            if(user_md5($password) !== $user['password']){
                $this->error = '密码错误！';
            }else{
                //更新登录信息
                $data = array(
                    'id'              => $user['id'],
                    'login'           => array('exp', '`login`+1'),
                    'last_login_time' => NOW_TIME,
                    'last_login_ip'   => get_client_ip(),
                );
                $this->save($data);
                $this->autoLogin($user);
                return $user['id'];
            }
        }
        return false;
    }

    public function getFieldBymap($field,$map){
        $data=$this->where($map)->find();
        return $data[$field];
    }

    /**
     * 设置登录状态
     * @author jry <598821125@qq.com>
     */
    public function autoLogin($user){
        //记录登录SESSION和COOKIES
        $user['uid']=$user['id'];
        session('user_auth', $user);
        session('user_auth_sign', $this->dataAuthSign($user));
    }

    /**
     * 检测同一IP注册是否频繁
     * @return boolean ture 正常，false 频繁注册
     * @author jry <598821125@qq.com>
     */
    protected function checkIP(){
        $limit_time = C('LIMIT_TIME_BY_IP');
        $map['ctime'] = array('GT', time()-(int)$limit_time);
        $reg_ip = $this->where($map)->getField('reg_ip', true);
        $key = array_search(get_client_ip(1), $reg_ip);
        if($reg_ip && $key !== false){
            return false;
        }
        return true;
    }

    /**
     * 数据签名认证
     * @param  array  $data 被认证的数据
     * @return string       签名
     * @author jry <598821125@qq.com>
     */
    public function dataAuthSign($data) {
        //数据类型检测
        if(!is_array($data)){
            $data = (array)$data;
        }
        ksort($data); //排序
        $code = http_build_query($data); //url编码并生成query字符串
        $sign = sha1($code); //生成签名
        return $sign;
    }

    /**
     * 检测用户是否登录
     * @return integer 0-未登录，大于0-当前登录用户ID
     * @author jry <598821125@qq.com>
     */
    public function isLogin()
    {
        $user = session('user_auth');
        if (empty($user)) {
            return 0;
        } else {
            return session('user_auth_sign') == $this->dataAuthSign($user) ? $user['uid'] : 0;
        }

    }
	
	public function numEdit($map,$field,$num,$type){
		switch($type){
			case "+":
				$this->where($map)->setInc($field,$num);
			break;
			case "-":
				$this->where($map)->setDec($field,$num);
			break;
		}
	}

    /**
     * 添加积分/成长值
     * @param  string  $uid 用户id
     * @param  string  $score 积分/成长值
     * @param  string  $vip 是否VIP
     * @return bool
     * @author C0de <47156503@qq.com>
     */
    public function addScore($uid,$score,$vip=false,$remark=false){
        $map['id']=$uid;
        $data=$this->where($map)->find();
        if($vip){
            $save['upgrade'] =$data['upgrade']+$score;
            $this->where($map)->save($save);
            $this->levelup($uid,$save['upgrade'],true);
			D('ScoreLog')->addLog($uid,$score,"3","+",$remark);
            return $save['upgrade'];
        }
        $save['score'] =$data['score']+$score;
        $save['total_score'] =$data['total_score']+$score;
        $this->where($map)->save($save);
        $this->levelup($uid,$save['total_score']);
		D('ScoreLog')->addLog($uid,$score,"2","+",$remark);
        return $save['total_score'];
    }

    /**
     * 判断用户等级/并升级
     * @param  string  $uid 用户id
     * @param  string  $score 积分/成长值
     * @param  string  $vip 是否VIP
     * @return bool
     * @author C0de <47156503@qq.com>
     */
    public function levelup($uid,$score,$vip=false){
        $map['id']=$uid;
        $data=$this->where($map)->find();
        if($vip){
            $level=getlevel($score,true);
            if($level['level'] != $data['level']){
                $save['vip'] =$level['level'];
                $this->where($map)->save($save);
            }
            return true;
        }
        $level=getlevel($score);
        if($level['level'] != $data['level']){
            $save['level'] =$level['level'];
            $this->where($map)->save($save);
        }
        return true;
    }
	
	public function isFcm($info){
		if(empty($info['realname']) || empty($info['idcard_no'])){
			return false;
		}
		return true;
	}



    /**
     * 检测用户资料完善度
     * @return integer 0-未登录，大于0-当前登录用户ID
     * @author jry <598821125@qq.com>
     */
    public function getPerfect($info){
        $count=0;
            //检测是否填写QQ
            if(!empty($info['qq'])){
                $count++;
            }
            //检测是否填写邮箱
            if(!empty($info['email'])){
                $count++;
            }
            //检测是否填写手机
            if(!empty($info['mobile'])){
                $count++;
            }
            //检测是否填写性别
            if(!empty($info['sex'])){
                $count++;
            }
            //检测是否填写年龄
            if(!empty($info['age'])){
                $count++;
            }
            //检测是否填写生日
            if(!empty($info['birthday'])){
                $count++;
            }
            //检测是否填写行业
            if(!empty($info['occupation'])){
                $count++;
            }
            //检测是否填写姓名
            if(!empty($info['realname'])){
                $count++;
            }
            //检测是否填写身份证号
            if(!empty($info['idcard_no'])){
                $count++;
            }
            //检测是否填写所在地
            if(!empty($info['extend'])){
                $count++;
            }
            return $count*10;
    }
}
