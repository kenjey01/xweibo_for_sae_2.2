<?php
/**
* 更新一个或者多个配置项 
* 可更新的配置项的名字与　值都必须用　'　做字符串定界
* 
* @param mixed $s	配置文件的内容
* @param mixed $k	配置项　或者　项=>值　关联数组
* @param mixed $v	如果 $k　为配置项　此值则为　新的配置值
* @return mixed	返回新的配置内容
* 
*/

function set_define_value($s,$k,$v=''){
	if (is_array($k)){
		foreach($k as $kk=>$vv){
			$p = "#define\s*\(\s*'".preg_quote($kk)."'\s*,(\s*)'.*?'\s*\)\s*;#sm";
			$s = preg_replace($p, "define('".$kk."',\\1'".$vv."');",$s);
		}
		return $s;
	}else{
		$p = "#define\s*\(\s*'".preg_quote($k)."'\s*,(\s*)'.*?'\s*\)\s*;#sm";
		return preg_replace($p, "define('".$k."',\\1'".$v."');",$s);
	}
}