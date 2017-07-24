<?php

namespace Common\Util;

class Sign{
    
	public static function signBuild($arr,$explode=null){
		$str='';
		$end=end($arr);
		foreach($arr as $val){
			$explode=($val==$end)?null:$explode;
			$str.=$val.$explode;
		}
		return $str;
	}
}
