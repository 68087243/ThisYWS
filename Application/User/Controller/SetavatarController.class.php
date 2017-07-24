<?php

namespace User\Controller;
use Think\Controller;

class SetavatarController extends UserController{


    public function index(){
		$this->assign('meta_title', "修改头像");
        $this->display();
    }


    public function saveAvatar()
    {
        $img = I('img');
        $userinfo = session('user_auth');
        if ($img) {
            $w = I('w');
            $h = I('h');
            $x = I('x');
            $y = I('y');
            if ($w || $h || $x || $y) {
                $path = get_cover($img);
                $image = new \Think\Image();
                $image->open('.' . $path);
                $image->crop($w, $h, $x, $y)->save('.' . $path);
                $data['img'] = $path;
            } else {
                $path = get_cover($img, 'avatar');
                $data['img'] = $path;
            }
            $User = M("User");
            $data['id'] = $userinfo['id'];
            $data['avatar'] = $img;
            $User->save($data);
            $data['code'] = 0;
            $this->ajax($data);
        }
    }

    public function preAvatar()
    {
        if ($_FILES) {
            $_POST['dir'] = 'image';
            $data = json_decode(D('Upload')->upload(), true);
            $image = new \Think\Image();
            $image->open('.' . $data['url']);
// 生成一个固定大小为150*150的缩略图并保存为thumb.jpg
            $image->thumb(311, 311, \Think\Image::IMAGE_THUMB_FIXED)->save('.' . $data['url']);
            $js = "<script>document.domain='" . domain() . "';parent.upload_avatar('" . $data['url'] . "',311,311);parent.Avatarid='" . $data['id'] . "';</script>";
            echo $js;
        }
    }



}
