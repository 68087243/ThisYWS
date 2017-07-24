<?php

namespace Common\Widget;
use Think\Controller;

class PublicWidget extends Controller {
    public function script(){
		$APP_SUB_DOMAIN_RULES=APP_SUB_DOMAIN_RULES();
		$script=<<<EOF
var DOMAIN_RULES={ $APP_SUB_DOMAIN_RULES }
function U(url,vars){arr=url.split('/');var url="";for(val in DOMAIN_RULES){if(DOMAIN_RULES[val]==arr[0]){url="http://"+val+"."+document.domain.split(".").slice(-2).join(".")+"/";if(arr[1]!=null){url+="index.php?c="+arr[1]}if(arr[2]!=null){url+="&a="+arr[2]}}}if(url==""){url="/";if(arr[0]!=null){url+="index.php?m="+arr[0]}if(arr[1]!=null){url+="&c="+arr[1]}if(arr[2]!=null){url+="&a="+arr[2]}}if(vars!=null){url+="&"+vars}return url;}document.domain=document.domain.split(".").slice(-2).join(".");var T3T2={};T3T2.ad_switch=1;T3T2.ad_index=1;T3T2.ad_show=1;T3T2.ad_pic="http://static.t3t2.com/Public/theme/ad/197401.jpg";T3T2.ad_url="http://mysj.t3t2.com";
EOF;
       return $script;
    }
	public function link(){
		$map['status'] = array('egt', '0');
		$data=D('Link')->where($map)->order('sort desc,id desc')->select();
		if(!empty($data)){
			foreach($data as $val){
				echo "<a href='{$val['url']}'>{$val['name']}</a>";
			}
		}

	}
}






?>