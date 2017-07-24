<?php
/**
 * 全局配置文件
 */
 
return array(
    //CoreThink当前版本
    'CORETHINK_VERSION' => '1.0Beta',

    //数据库配置
    'DB_TYPE'   =>  'mysql', // 数据库类型
    'DB_HOST'   =>  '127.0.0.1', // 服务器地址
    'DB_NAME'   =>  'yiwanshu', // 数据库名
    'DB_USER'   =>  'root', // 用户名
    'DB_PWD'    =>  'root', // 密码
    'DB_PORT'   =>  '3306', // 端口
    'DB_PREFIX' =>  'ct_', // 数据库表前缀

    //URL模式
    'URL_MODEL' => '2',
    'MODULE_ALLOW_LIST' => array(
        'Admin',
        'Api',
        'Common',
        'Forum',
        'Game',
        'Gateway',
        'Gift',
        'Home',
        'Mix',
        'News',
        'Pay',
        'Service',
        'Shop',
        'Spread',
        'UrlWorker',
        'User',
    ),


    //全局过滤配置
    'DEFAULT_FILTER' => '', //默认为htmlspecialchars

    //预先加载的标签库
    'TAGLIB_PRE_LOAD' => 'Home\\TagLib\\Corethink',

    //URL配置
    'URL_CASE_INSENSITIVE' => true, //不区分大小写
	
	//货币开关
	'TOGGLE_CURRENCY' => 1,

    //应用配置
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common'),
    'AUTOLOAD_NAMESPACE' => array('Addons' => THINK_ADDON_PATH), //扩展模块列表

    'APP_SUB_DOMAIN_DEPLOY'=>1,// 开启子域名配置

    'APP_SUB_DOMAIN_RULES'=>array(
        'www'=>array('Home'),//首页模块
		'ww'=>array('Home'),//首页模块
		'wwww'=>array('Home'),//首页模块
        'adminloginhangpoqwqwwdsffasdwv'=>array('Admin'),//后台模块
        'my'=>array('User'),//会员模块
        'api'=>array('Api'),//API模块
        'gateway'=>array('Gateway'),//网关模块
        'game'=>array('Game'),//游戏模块
        'bbs'=>array('Forum'),//论坛模块
        'gift'=>array('Gift'),//礼包模块 新手卡
        'shop'=>array('Shop'),//商城模块
        'service'=>array('Service'),//客服模块
        'pay'=>array('Pay'),//充值模块
        'news'=>array('News'),
		'tg'=>array('Spread'),
		'mix'=>array('Mix'),
		'url'=>array('UrlWorker'),
		'url.739wan.cn'=>array('UrlWorker'),
        '*'   =>    array('Game','c=*'),
    ),


    //表单类型
    'FORM_ITEM_TYPE' => array(
        'hidden'     => '隐藏',
        'num'        => '数字',
        'text'       => '字符串',
        'textarea'   => '文本',
        'array'      => '数组',
        'password'   => '密码',
        'radio'      => '单选按钮',
        'checkbox'   => '复选框',
        'select'     => '下拉框',
        'icon'       => '图标',
        'date  '     => '日期',
        'datetime'   => '时间',
        'picture'    => '图片',
        'kindeditor' => '编辑器',
        'tags'       => '标签',
        'board  '    => '拖动排序',
    ),

    //栏目分类前台用户投稿权限
    'CATEGORY_POST_AUTH' => array(
        '1'  => '是',
        '0'  => '否',
    ),

    //注册方式列表
    'REG_TYPE_LIST' => array(
        '0'  => '用户名',
        '1'  => '邮箱',
        '2'  => '手机号',
        '3'  => '第三方',
    ),

    //前台用户类型
    'USER_TYPE_LIST' => array(
        '0'  => '个人',
        '1'  => '推广',
    ),

    //前台用户VIP等级
    'USER_VIP_LEVEL' => array(
        '0'  => '普通用户',
        '1'  => '普通VIP',
        '2'  => '高级VIP',
    ),

    //前台用户性别
    'USER_SEX_LIST' => array(
        '1'  => '男',
        '-1' => '女',
        '0'  => '保密',
    ),

    //插件类型
    'ADDON_TYPE_LIST' => array(
        '0'  => '系统插件',
        '1'  => '微＋插件',
    ),

    //游戏类型
    'GAME_TYPE' => array(
        '0'  => '网页游戏',
        '1'  => 'PC游戏',
        '2'  => '手机游戏',
    ),

    //游戏类型
    'GAME_TYPE_LIST' => array(
        '1'  => '角色扮演',
        '2'  => '动漫RPG',
        '3'  => '休闲游戏',
        '4'  => '国战策略',
    ),

    //首字母
    'GAME_INITIALS_LIST' => array(
        '0'  => 'ABCDE',
        '1'  => 'FGHIJK',
        '2'  => 'LMNOP',
        '3'  => 'QRSTU',
        '4'  => 'VWXYZ',
    ),

    //链接打开方式
    'TARGET_LIST' => array(
        '0'  => '_blank',
        '1'  => '_new',
        '2'  => '_parent',
        '3'  => '_self',
        '4'  => '_top',
    ),


    'ATTRIBUTE_LIST' => array(
        'z'  => '置顶',
        't'  => '推荐',
        'r'  => '热门',
        'x'  => '新游',
        'j'  => '加粗',
    ),

    'LINE_LIST' => array(
        '0'  => '双线',
        '1'  => '多线',
        '2'  => '电信',
        '3'  => '网通',
        '4'  => '移动',
    ),

    'PAY_LIST' => array(
        '0'  => '平台',
        '1'  => '游戏',
    ),

    'SOURCE_LIST' => array(
        '0'  => '平台',
        '1'  => '微端',
    ),
	
	'PAY_STATUS' => array(
        '1'  => '待支付',
        '2'  => '支付成功',
		'3'  => '支付失败',
    ),
	
	'SCORE_TYPE' => array(
        '1'  => 'T币',
        '2'  => '积分',
		'3'  => '成长值',
    ),

    'LEVEL_LIST' => array(
        '1'  => Array('title'=>'初来乍到','scope'=>'0,100'),
        '2'  => Array('title'=>'初入游戏','scope'=>'100,200'),
        '3'  => Array('title'=>'游戏新秀','scope'=>'200,500'),
        '4'  => Array('title'=>'游戏少侠','scope'=>'500,1000'),
        '5'  => Array('title'=>'游戏大侠','scope'=>'1000,2000'),
        '6'  => Array('title'=>'游戏豪侠','scope'=>'2000,5000'),
        '7'  => Array('title'=>'一派掌门','scope'=>'5000,10000'),
        '8'  => Array('title'=>'一代宗师','scope'=>'10000,15000'),
        '9'  => Array('title'=>'游戏盟主','scope'=>'15000,30000'),
        '10'  => Array('title'=>'独孤求败','scope'=>'30000,100000'),
    ),
    'VIP_LEVEL_LIST' => array(
        '0'  => Array('title'=>'普通用户','scope'=>'0,400'),
        '1'  => Array('title'=>'VIP1','scope'=>'400,550'),
        '2'  => Array('title'=>'VIP2','scope'=>'550,1000'),
        '3'  => Array('title'=>'VIP3','scope'=>'1000,1600'),
        '4'  => Array('title'=>'VIP4','scope'=>'1600,6300'),
        '5'  => Array('title'=>'VIP5','scope'=>'6300,12000'),
        '6'  => Array('title'=>'VIP6','scope'=>'12000,58000'),
        '7'  => Array('title'=>'VIP7','scope'=>'58000,68000'),
        '8'  => Array('title'=>'VIP8','scope'=>'68000,999999'),
    ),
	
	'PAYMENT_CHANNELS' => array(
		'1'=>'支付宝',
		'2'=>'财付通',
		'3'=>'中国工商银行',
		'4'=>'中国建设银行',
		'5'=>'中国银行',
		'6'=>'中国农业银行',
		'7'=>'中国招商银行',
		'8'=>'中国邮政',
		'9'=>'中国交通银行',
		'10'=>'其他',
	),
	'MIX_LEVEL' => array(
		'1'=>'青铜代理',
		'2'=>'白银代理',
		'3'=>'黄金代理',
		'4'=>'白金代理',
		'5'=>'钻石代理',
	),

    'SESSION_OPTIONS'=>array('domain'=>DOMAIN),
    'COOKIE_EXPIRE'         =>  36000,    // Cookie有效期
    'COOKIE_DOMAIN'         =>  DOMAIN,      // Cookie有效域名
    'COOKIE_PATH'           =>  '/',     // Cookie路径
    'COOKIE_HTTPONLY'       =>  true,

    //文件上传相关配置
    'UPLOAD_CONFIG' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制，默认为2M，后台配置会覆盖此值)
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ),
);
