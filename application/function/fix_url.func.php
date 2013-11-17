<?php
/**
* 根据一个地址，自动　fixed
* 如果一个地址是本地路径，则自动加上本地前缀，如果是一个网络地址则不做任何处理,如果为空，则返回默认值
* 使用实例：
* 		echo F('fix_url','','default_test');
		echo F('fix_url','img/logo/aaa.gif');
		echo F('fix_url','http://demo.com/img/logo/aaa.gif');
* @param mixed $url 目标地址
* @param mixed $def 如果目标地址为空，则自动返回　$def
* @param mixed $preifx 地址前缀，如果为FALSE　则使用全局路径常量 W_BASE_URL_PATH 做前缀　，否则由用户指定
* @return 返回一个　可访问的地址
* 
*/
function fix_url($url, $def=false, $prefix=false) {
	$url = trim($url);
	if (empty($url)){
		return $def;
	}
	
	if ( count(explode('://',$url))>1 ){
		return $url;
	}else{
		return $prefix===false ? W_BASE_URL_PATH.$url : $prefix.$url;
	}
}

