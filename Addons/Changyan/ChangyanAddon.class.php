<?php


namespace Addons\Changyan;
use Common\Controller\Addon;
/**
 * 畅言插件
 * @author C0de <47156503@qq.com>
 */
class ChangyanAddon extends Addon{
    public $info = array(
        'name' => 'Changyan',
        'title' => '畅言插件',
        'description' => '实现社会化评论',
        'status' => 1,
        'author' => 'C0de',
        'version' => '1.0'
    );

    public function install(){
        return true;
    }

    public function uninstall(){
        return true;
    }
	
	/**
     * 评论代码钩子
     * @param $param
     */
    public function ChangyanCode(){
        $options = $this->getConfig();
        echo $options['changyancode'];
    }
}
