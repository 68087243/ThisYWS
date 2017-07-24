<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------

require_once(APP_PATH . '/Common/Common/text.php');
require_once(APP_PATH . '/Common/Common/time.php');
require_once(APP_PATH . '/Common/Common/addon.php');

/**
 * 根据配置类型解析配置
 * @param  string $type  配置类型
 * @param  string  $value 配置值
 * @author jry <598821125@qq.com>
 */
function parse_attr($value, $type){
    switch ($type) {
        default: //解析"1:1\r\n2:3"格式字符串为数组
            $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
            if(strpos($value,':')){
                $value  = array();
                foreach ($array as $val) {
                    list($k, $v) = explode(':', $val);
                    $value[$k]   = $v;
                }
            }else{
                $value = $array;
            }
            break;
    }
    return $value;
}

/**
 * 游戏接口操作
 * @param  string $api  API接口ID
 * @param  string  $info 数据数组
 * @author C0de <47156503@qq.com>
 */
function GetApi($api){
    static $_api  = array();
    $data=M('Gameapi')->find($api);
    $class      =   '\\Game\\Api\\'.$data['tag'].'Api';
    if (!isset($_api[$api])){
		$file='.'.DIRECTORY_SEPARATOR.'Game'.DIRECTORY_SEPARATOR.'Api'.DIRECTORY_SEPARATOR.$data['tag'].EXT;
		if(file_exists($file)){
			include($file);
			$_api[$api] = new $class($data);
		}else{
			return false;
		}
	}
    return $_api[$api];
}

/**
 * 支付接口操作
 * @param  string $api  API接口ID
 * @param  string  $info 数据数组
 * @author C0de <47156503@qq.com>
 */
function PayApi($api){
	static $_api  = array();
	$data=M('Payapi')->find($api);
	$class      =   '\\Common\\Util\\Pay';
	if (!isset($_api[$api])){
		$file='.'.DIRECTORY_SEPARATOR.'Application'.DIRECTORY_SEPARATOR.'Common'.DIRECTORY_SEPARATOR.'Util'.DIRECTORY_SEPARATOR.'Pay'.DIRECTORY_SEPARATOR.'Driver'.DIRECTORY_SEPARATOR.$data['class'].EXT;
		if(file_exists($file)){
			include($file);
			$_api[$api] = new $class($data['class'],$data);
		}else{
			return false;
		}
	}
    return $_api[$api];
}

//获取订单号
function getOrder(){
	$order_list='P_OrderId,out_trade_no';
	$arr=explode(",",$order_list);
	foreach($arr as $val){
		$order=$_GET[$val];
		if(!empty($order)){
			return $order;
		}
	}
	
	return false;
}

/**
 * 支付表单快速生成
 * @param  Array  $params  表单数据
 * @param  string  $gateway 提交地址
 * @param  string  $method 提交方式
 * @param  string  $charset 编码
 * @author C0de <47156503@qq.com>
 */
function _buildForm($params, $gateway, $method = 'post', $charset = 'utf-8') {
        header("Content-type:text/html;charset={$charset}");
        $sHtml = "<form id='paysubmit' name='paysubmit' action='{$gateway}' method='{$method}'>";
        foreach ($params as $k => $v) {
            $sHtml.= "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\" />\n";
        }
        $sHtml = $sHtml . "</form>Loading......";
        $sHtml = $sHtml . "<script>document.forms['paysubmit'].submit();</script>";
        return $sHtml;
}
	
/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author jry <598821125@qq.com>
 */
function is_login(){
    return D('User')->isLogin();
}

/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string
 * @author jry <598821125@qq.com>
 */
function user_md5($str, $key = 'CoreThink'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 根据用户ID获取用户信息
 * @param  integer $id 用户ID
 * @param  string $field
 * @return array  用户信息
 * @author jry <598821125@qq.com>
 */
function get_user_info($id, $field){
    $userinfo = D('User')->find($id);
    if($field){
      return $userinfo[$field];
    }
    return $userinfo;
}

/**
 * 获取上传文件路径
 * @param  int $id 文件ID
 * @return string
 * @author jry <598821125@qq.com>
 */
function get_cover($id, $type){
        switch($type){
            case 'avatar' : //用户头像
                if($id >= 20){
                    $url = D('Upload')->getPath($id);
                }else{
                    $url = __ROOT__.'/Public/theme/user/avatar/'.$id.'.jpg';
                }
                break;
            default:
				$url = D('Upload')->getPath($id);
				if(!strstr($url,"http://")){
					$url='http://static.'.DOMAIN().$url;
				}
                
                break;
        }
    return $url;
}

/**
 * 系统邮件发送函数
 * @param string $receiver 收件人
 * @param string $subject 邮件主题
 * @param string $body 邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 * @author jry <598821125@qq.com>
 */
function send_mail($receiver, $subject, $body, $attachment){
    return R('Addons://Email/Email/sendMail', array($receiver, $subject, $body, $attachment));
}

/**
 * 短信发送函数
 * @param string $receiver 接收短信手机号码
 * @param string $body 短信内容
 * @return boolean
 * @author jry <598821125@qq.com>
 */
function send_mobile_message($receiver, $body){
    return R('Addons://Sms/Sms/sendSms', array($receiver, $body));
}


/**
 * 订单号生成函数
 * @return string
 * @author c0de <47156503@qq.com>
 */
function build_order_no(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(md5(uniqid().time()), 7, 13), 1))), 0, 8);
}


/**
 * 设置主题
 * @return bool
 * @author c0de <47156503@qq.com>
 */
function set_theme(){
    //读取数据库中的配置
    $config = S('DB_CONFIG_DATA');
    if(!$config){
        $config = D('SystemConfig')->lists();
        S('DB_CONFIG_DATA',$config);
    }
    define('TMPL_PATH','./Theme/'.$config['DEFAULT_THEME'].'/');
    unset($config['DEFAULT_THEME']);
    //模板相关配置
    $Theme=str_replace('./Theme/','/Theme/',TMPL_PATH);
    //模板相关配置
    $config['TMPL_PARSE_STRING']['__PUBLIC__'] = __ROOT__.'/Public';
    $config['TMPL_PARSE_STRING']['__IMG__'] = __ROOT__.$Theme.MODULE_NAME.'/Public/img';
    $config['TMPL_PARSE_STRING']['__CSS__'] = __ROOT__.$Theme.MODULE_NAME.'/Public/css';
    $config['TMPL_PARSE_STRING']['__JS__']  = __ROOT__.$Theme.MODULE_NAME.'/Public/js';
    $config['HOME_PAGE'] = 'http://'.$_SERVER['HTTP_HOST'].__ROOT__;

    C($config); //添加配置
}

/**
 * 获取用户USER_AGENT
 * @return string
 * @author c0de <47156503@qq.com>
 */
function get_useragent(){
    return addslashes($_SERVER['HTTP_USER_AGENT']);
}

/**
 * 解析属性
 * @param string $str 属性
 * @return array
 * @author c0de <47156503@qq.com>
 */
function flags($str){
    $arr=array_filter(explode(',',$str));
    $array=array();
    foreach ($arr as $val) {
        $array[$val]=1;
    }
    return $array;
}


/**
 * 取根域名
 * @param string $domain 域名
 * @return string
 * @author c0de <47156503@qq.com>
 */
function domain($domain='')
{
    if(empty($domain)){
        $domain=DOMAIN;
    }
    $_temp=parse_url($domain);
    if(!$_temp['host']){
        $arr = array_filter(explode('.', $domain));
    }else{
        $arr = array_filter(explode('.', $_temp['host']));
    }
    if (count($arr) === 2 || empty($arr[3]))  {
        return $arr[1] . '.' . $arr[2];
    } else{
        return $arr[1] . '.' . $arr[2] . '.' . $arr['3'];
    }
}




/**
 * 判断时间是今天还是明天 昨天还是多少号
 * @param string $time 时间戳
 * @return string
 * @author c0de <47156503@qq.com>
 */
function retime($a){
    $b=date("Y-m-d",$a);$c=date("Y-m-d");$d=date("Y-m-d",strtotime("-1 day"));$e=date("Y-m-d",strtotime("-2 day"));$f=date("Y-m-d",strtotime("+1 day"));$g=date("Y-m-d",strtotime("+2 day"));if($b==$c){return '今天';}if($b==$d){return '昨天';}if($b==$e){return '前天';}if($b==$f){return '明天';}if($b==$g){return '后天';}return date("m-d",$a);
}

/**
 * 将二级域名输出为JS数组
 * @return string
 * @author c0de <47156503@qq.com>
 */
function APP_SUB_DOMAIN_RULES(){
    $data=C('APP_SUB_DOMAIN_RULES');
    unset($data['*']);
    $str='test:"tEST"';
    foreach($data as $key=>$val){
		if($val[0]=="Admin" || strstr($key,'.')){
			continue;
		}
        $str.=','.$key .':"'.$val[0] .'"';
    }
    return $str;
}

/**
 * 多维数组键值排序
 * @param string $direction 排序方式
 * @param string $field 排序字段
 * @param string $array 排序数组
 * @return string
 * @author c0de <47156503@qq.com>
 */
function sort_field($direction,$field,$array){
    $sort = array(
        'direction' => $direction, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
        'field'     => $field,       //排序字段
    );
    $arrSort = array();
    foreach($array AS $uniqid => $row){
        foreach($row AS $key=>$value){
            $arrSort[$key][$uniqid] = $value;
        }
    }
    if($sort['direction']){
        array_multisort($arrSort[$sort['field']], constant($sort['direction']), $array);
    }
    return $array;
}

/**
 * 汉字转换拼音
 * @param string $str 转换的汉字
 * @param  bool $type 只转换首字
 * @return string
 * @author c0de <47156503@qq.com>
 */
function pinyin($str,$type=false){
	$str=str_replace(Array('3D'),'',$str);
    $PingYing = new Common\Util\GetPingYing();
    if($type){
        $s=$PingYing->getFirstChar($str);
    }else{
        $s=$PingYing->getPinyin($str);
    }
    return $s;
}

/**
 * 获取积分等级/VIP等级
 * @param string $num 积分/成长值
 * @param bool $vip VIP
 * @return array
 * @author c0de <47156503@qq.com>
 */
function getlevel($num,$vip=false){
    if(empty($num)){
        $num=0;
    }
    if($vip){
        $level=C('VIP_LEVEL_LIST');
    }else{
        $level=C('LEVEL_LIST');
    }
    foreach($level as $key=>$val){
        $n=explode(',',$val['scope']);
        if($n[0] == $num || $n[0] < $num  && $n[1] > $num){
            $level[$key]['s']=$n[0];
            $level[$key]['e']=$n[1];
            $level[$key]['level']=$key;
            $level[$key]['x']=$key+1;
            $bfb=$n[1]-$n[0];
            $num=$num-$n[0];
            $level[$key]['bfb']=round( $num/$bfb * 100 , 2);
            return $level[$key];
        }
    }
}


/**
 * 验证身份证
 * @param string $vStr 身份证
 * @return bool
 * @author c0de <47156503@qq.com>
 */
function isCreditNo($vStr){
    $vCity = array(
        '11','12','13','14','15','21','22',
        '23','31','32','33','34','35','36',
        '37','41','42','43','44','45','46',
        '50','51','52','53','54','61','62',
        '63','64','65','71','81','82','91'
    );
    if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;
    if (!in_array(substr($vStr, 0, 2), $vCity)) return false;
    $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
    $vLength = strlen($vStr);
    if ($vLength == 18)
    {
        $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
    } else {
        $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
    }
    if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
    if ($vLength == 18)
    {
        $vSum = 0;
        for ($i = 17 ; $i >= 0 ; $i--)
        {
            $vSubStr = substr($vStr, 17 - $i, 1);
            $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
        }
        if($vSum % 11 != 1) return false;
    }
    return true;
}

/**
 * 根据身份证号提取年龄以及生日
 * @param string $id 身份证
 * @return array
 * @author c0de <47156503@qq.com>
 */
function getAgeByID($id){
    if(empty($id)) return '';
    $birthday=substr($id,6,8);
    $date=strtotime($birthday);
    $today=strtotime('today');
    $diff=floor(($today-$date)/86400/365);
    $age=strtotime(substr($id,6,8).' +'.$diff.'years')>$today?($diff+1):$diff;
    $array=Array();
    $array['birthday']=$birthday;
    $array['age']=$age;
    return $array;
}

/**
 * 将用户等级/VIP等级配置的数字范围转换为K为单位
 * @param string $str 数字范围
 * @return string
 * @author c0de <47156503@qq.com>
 */
function numTok($str){
    $arr=explode(',',$str);
    if(strlen($arr[0]) >= 4){
        $arr[0]=($arr[0]/1000).'K';
    }
    if(strlen($arr[1]) >= 4){
        $arr[1]=($arr[1]/1000).'K';
    }
    return $arr[0].'-'.$arr[1];
}

/**
 * 计算中文字符长度
 * @param string $string 字符串
 * @return string
 * @author c0de <47156503@qq.com>
 */
function utf8_strlen($string) {
    preg_match_all("/./us", $string, $match);
    return count($match[0]);
}

/**
 * 将中间内容用星号替代
 * @param string $str 字符串
 * @return string
 * @author c0de <47156503@qq.com>
 */
function half_replace($str,$num){
    if(!empty($num)){
       return  mb_substr($str,0,1,'utf-8').'*';
    }
    $len = strlen($str)/2;
    return substr_replace($str,str_repeat('*',$len),ceil(($len)/2),$len);
}

/**
 * 将内容分割并获取指定位置字符
 * @param string $str 字符串
 * @return string
 * @author c0de <47156503@qq.com>
 */
function getexplode($str,$num,$f=','){
    $data=explode($f,$str);
    return $data[$num];
}

/**
 * callback回调
 * @param string $attr 字符串
 * @return string
 * @author c0de <47156503@qq.com>
 */
function callbackByeval($attr){
    if(preg_match("/^{:(.*?)}$/i",$attr,$_temp)){
        $_php='$_return='.$_temp[1].';';
        eval($_php);
        return $_return;
    }else{
        return false;
    }
}

/**
 * 混服KEY生成
 * @param string $mid 商户ID
 * @param string $type 类型
 * @return string
 * @author c0de <47156503@qq.com>
 */
 function MixSignKey($mid,$type){
	 return md5($mid."T3T2@2016@".$type."@RH");
 }