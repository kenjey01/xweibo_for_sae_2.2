<?php
/**************************************************
*  Created:  2010-06-08
*
*  得到过滤相关缓存
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/
/**
 * 内容类型：１微博ID　２评论ID　３昵称　４内容
 *
 */
function get_filter_cache($type) {
	$allow_type = array(
					'weibo' => 1,
					'comment' => 2,
					'nick' => 3,
					'content' => 4,
					'user_verify' => 5
				);
	if (!isset($allow_type[$type])) {
		return false;
	}
	if ($type == 'user_verify') {
		$rst = DR('mgr/userCom.getVerify', 0);
	} else {
		$rst = DR('xweibo/disableItem.getDisabledItems', 'g1/0', $allow_type[$type]);
	}
	return $rst['rst'];
}
