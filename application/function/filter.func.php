<?php
/**************************************************
*  Created:  2010-06-13
*
*  微博过滤
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/

require_once  APP::functionFile('get_filter_cache');
/**
 * 测试内容是否可以通过
 *
 * @return string
 */
function filter($str, $type) {
	if ( !in_array($type, array('content', 'weibo', 'nick', 'verify','comment'))) {
		return false;
	}
	if (empty($str)) {
		return true;
	}
	if ($type == 'verify') {
		$type = 'user_verify';
	}
	$cache = get_filter_cache($type);
	if (empty($cache)) {
		return true;
	}
	switch ($type) {
		case 'nick':
		case 'content':
				
				do {
					if (strpos($str, (string)key($cache)) > -1) {
						return key($cache);
					}
				} while(next($cache));
				break;
		case 'comment':
		case 'weibo':
				if (isset($cache[$str])) {
					return false;
				}
				break;
		
		case 'user_verify':
				if (isset($cache[$str])) {
					return true;
				} else {
					return false;
				}
				break;
	}
	return true;

}
