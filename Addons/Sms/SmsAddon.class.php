<?php


namespace Addons\Sms;
use Common\Controller\Addon;
/**
 * 短信插件
 * @author jry <47156503@qq.com>
 */
class SmsAddon extends Addon{
    public $info = array(
        'name' => 'Sms',
        'title' => '短信插件',
        'description' => '实现系统发短信功能',
        'status' => 1,
        'author' => 'C0de',
        'version' => '1.0'
    );

    public function install(){
        $prefix = C("DB_PREFIX");
        $model = D();
        $model->execute("DROP TABLE IF EXISTS {$prefix}sms;");
        return true;
    }

    public function uninstall(){
        $prefix = C("DB_PREFIX");
        $model->execute("DROP TABLE IF EXISTS {$prefix}sms;");
        return true;
    }
}
