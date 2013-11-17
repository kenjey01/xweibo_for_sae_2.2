<?php
/**************************************************
*  Created:  2010-08-30
*
*  缓存weibo类数据，如果数据不正常则尝试返回缓存
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/

/**
 * 
 * @param $1 weibo weibo类对象
 * @param $2 string weibo类方法名
 * @param $more mixed weibo类中方法要使用的参数
 */
function weibo_cache() {
	$p = func_get_args();
	$wb = array_shift($p);
	$fn = array_shift($p);

	if (!method_exists($wb, $fn)) {
		return false;
	}
	// 允许使用缓存的方法
	$allows = array('searchstatuse','getpublictimeline');
	$key = $fn . http_build_query($p);
	
	$result = call_user_func_array(array($wb, $fn), $p);

	// 如果不是允许的方法，则直接返回内容
	if (!in_array(strtolower($fn), $allows)) {
		return $result;
	}

	// 如果出错或超时，则尝试返回cache
	if (is_array($result) && isset($result['error_code'])) {
		$r = CACHE::get($key);
		return empty($r)? $result : $r;
	}

	$r = is_string($result)? json_decode($result, true): $result;
	if (isset($r['error'])) {
		$r = CACHE::get($key);
		return empty($r)? $result: $r;
	}

	CACHE::set($key, $result);
	return $result;
}