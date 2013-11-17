<?php
/**
 * @file			http_get_contents.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	xionghui/2010-11-15
 * @Brief			通过URL获取内容的函数 文件
 */


/**
* 通过URL获取内容
* 
* @param mixed $url
* @return 从URL中获取的内容
*/
function http_get_contents($url){
	$http = APP::ADP('http');
	$http->setUrl($url);
	return $http->request();
}

