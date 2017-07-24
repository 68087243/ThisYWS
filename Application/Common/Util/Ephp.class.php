<?php
namespace Common\Util;

class Ephp {
	
	private $key_rand="6BA8015B0495B494805A4951FC71A5D86269E9DB58E1896B51F9";
	protected function rc4($pwd, $data) {
		$key[] = "";
		$box[] = "";
		$pwd_length = strlen($pwd);
		$data_length = strlen($data);
		for ($i = 0; $i < 256; $i++) {
			$key[$i] = ord($pwd[$i % $pwd_length]);
			$box[$i] = $i;
		}
		for ($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $key[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		for ($a = $j = $i = 0; $i < $data_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$k = $box[(($box[$a] + $box[$j]) % 256) ];
			@$cipher.= chr(ord($data[$i]) ^ $k);
		}
		return $cipher;
	}
	
	protected function hexToStr($hex) {
		$string = "";
		for ($i = 0; $i < strlen($hex) - 1; $i+= 2) $string.= chr(hexdec($hex[$i] . $hex[$i + 1]));
		return $string;
	}
	
	protected function strToHex($string) {
		return substr(chunk_split(bin2hex($string)) , 0, -2);
	}
	
	public function rc4a($string) {
		return str_replace("\r\n","",$this->strToHex($this->rc4($this->key_rand, $string)));
	}
	
	public function rc4b($string) {
		return @$this->rc4($this->key_rand, pack('H*', $string));
	}
		
}
