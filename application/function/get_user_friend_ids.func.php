<?php
/**************************************************
*  Created:  2011-05-26
*
*  根据id用户关注ID 
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liujz <jianzhou@staff.sina.com.cn>
*
***************************************************/

/**
 * get_user_friend_ids 
 *
 * @param string $ids 用户id，多个用逗号隔开
 * @param string $cache 缓存时间，单位是秒
 *
 * @return bool|array 
 */
function get_user_friend_ids($id=false, $cache=false) 
{
	$id = $id ? $id : USER::uid();
	if ( empty($id) ) { return array(); }
	
	// Friend List
	$cacheStr 		= $cache ? 'g/'.$cache : FALSE;
	$friendListTmp 	= DR('xweibo/xwb.getFriendIds', $cacheStr, $id, null, null, -1, 5000);
	$friendList 	= array();
	if ( isset($friendListTmp['rst']['ids']) && is_array($friendListTmp['rst']['ids']) ) 
	{
		foreach ($friendListTmp['rst']['ids'] as $aId)
		{
			$friendList[$aId] = $aId;
		}
	}
	return $friendList;
}
?>
