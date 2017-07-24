<?php

namespace Addons\Changyan\Controller;
use Home\Controller\AddonController;
use Think\Controller;
/**
 * 畅言控制器
 * @author C0de <47156503@qq.com>
 */
class ChangyanController extends AddonController{
    /**
     * 获取用户信息
     * @return array
     * @author C0de <47156503@qq.com>
     */
    public function getuser(){
		$userinfo=session('user_auth');
		$addon_config = \Common\Controller\Addon::getConfig('Changyan');
		$array=Array();
		if($userinfo){
			$array['is_login']=1;
			$array['user']['user_id']=$userinfo['id'];
			$array['user']['nickname']=$userinfo['username'];
			$array['user']['img_url']=get_cover($userinfo['avatar'],'avatar');
			$array['user']['profile_url']=U('User/index/index');
			$array['user']['sign']=$this->sign($addon_config['APP_KEY'],$array['user']['img_url'],$array['user']['nickname'],$array['user']['profile_url'],$array['user']['user_id']);
		}else{
			$array['is_login']=0;
		}
		$this->ajax($array);
    }
	
	/**
     * 退出
     * @return bool
     * @author C0de <47156503@qq.com>
     */
	public function logout(){
		$userinfo = session('user_auth');
        cookie(null);
        session(null);
        cookie('remname', $userinfo['username']);
		$this->ajax(Array('code'=>1,'reload_page'=>1,'js_src'=>''));
	}
	
	
	public static function sign($key, $imgUrl, $nickname, $profileUrl, $isvUserId){
            $toSign = "img_url=".$imgUrl."&nickname=".$nickname."&profile_url=".$profileUrl."&user_id=".$isvUserId;
            $signature = base64_encode(hash_hmac("sha1", $toSign, $key, true));
            return $signature;
    }
}
