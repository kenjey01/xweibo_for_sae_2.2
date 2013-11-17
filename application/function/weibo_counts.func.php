<?php
/**************************************************
*  Created:  2010-06-08
*
*  批量获取指定微博的转发数和评论数
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/


/**
 * weibo counts
 *
 * @param array $ids
 * @param string $retype
 * @return array|string
 */
function weibo_counts($ids, $retype = 'array')
{
	if (!is_array($ids)) {
		return false;
	}
	//批量获取指定微博的转发数和评论数
	$ids = implode(',', $ids);
	$batch_counts = DR('xweibo/xwb.getCounts', '', $ids);
	$batch_counts = $batch_counts['rst'];

	if (empty($batch_counts['errno'])) {
		$counts = array();
		foreach ($batch_counts as $key => $var) {
			$counts[(string)$var['id']]['comments'] = $var['comments'];
			$counts[(string)$var['id']]['rt'] = $var['rt'];
		}
		return $counts;
	}
	return $batch_counts;
}
