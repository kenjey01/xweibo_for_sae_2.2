<?php
/**************************************************
*  Created:  2010-06-08
*
*  根据id批量获取用户信息 
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

/**
 * get_user_show 
 *
 * @param string $ids 用户id，多个用逗号隔开
 * @param string $cache 缓存时间，单位是秒
 *
 * @return bool|array 
 */
function get_user_show($ids=false, $cache=false, $isName=FALSE) 
{
	if (empty($ids)) {
		return false;
	}
	
	$ids_array = array();
	$ids_array = explode(',', $ids);
	$countId   = count($ids_array);
	
	/// 缓存时间
	$cache = empty($cache) ? '' : 'g0/'.$cache;
	$resultTmp	= array();
	$result		= array();
	
	if ($countId > 0) {
		//批量获取, 目前最多支持20个人,超过20个人, 分组调用批量接口
		if ($countId > 20) {
			$pageCnt = ceil($countId/20);
	
			for ($p=1; $p <=$pageCnt; $p++) {
				$offset = ($p-1) * 20;
				$idsTmp = array_slice($ids_array, $offset, 20);
				$rspTmp = $isName ? DR('xweibo/xwb.getUsersBatchShow', false, false, implode(',', $idsTmp)) : DR('xweibo/xwb.getUsersBatchShow', '', implode(',', $idsTmp));
				if (!empty($rspTmp['errno'])) {
					continue;
				}
				$resultTmp = array_merge($resultTmp, $rspTmp['rst']);
			}
			$result['rst'] = $resultTmp;
		} else {
			$result = $isName ? DR('xweibo/xwb.getUsersBatchShow', $cache, false, $ids) : DR('xweibo/xwb.getUsersBatchShow', $cache, $ids);
		}
	}
	return $result;
}
?>
