<?php
/**************************************************
*  Created:  2010-06-08
*
*  xcache缓存
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class xcache_cache
{

	function xcache_cache() {

	}

	function adp_init($config=array()) {

	}

	function get($key) {
		return xcache_get($key);
	}

	function set($key, $value, $ttl = 0) {
		$rst = xcache_set($key, $value, $ttl);
		if (!$rst) {
			LOGSTR('cache', '[set]set cache error,size of data is:'. sizeof($value));
		}
	}

	function delete($key) {
		return xcache_unset($key);
	}

}
?>
