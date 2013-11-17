<?php
/**
 * @file			format_weibo.func.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			zhenquan <zhenquan@staff.sina.com.cn>
 * @Create Date:	2011-02-15
 */

/**
 * 格式化微博列表为简化格式
 * @param $list array 微博API返回的微博列表数据
 * @param $filte boolean 是否忽略被屏蔽的数据
 * @return array 格式化后的数据
 */
function format_weibo($list, $filte=true) {
	$data = array();
	/*
	foreach($list as $wb){
		if ($filte && (isset($wb['filter_state']) && !empty($wb['filter_state'])) || (isset($wb['user']['filter_state']) && !empty($wb['user']['filter_state']))) {
			continue;	
		}
		$data[(string)$wb['id']] = fw_getItem($wb);
	}
	*/
	for ($i=0, $count=count($list); $i< $count; $i++) {
		$wb = $list[$i];
		if ($filte && (isset($wb['filter_state']) && !empty($wb['filter_state'])) || (isset($wb['user']['filter_state']) && !empty($wb['user']['filter_state']))) {
			continue;	
		}
		/// 未通过审核微博
		if (isset($wb['xwb_weibo_verify']) && $wb['xwb_weibo_verify']) {
			if (isset($wb['retweeted_status']) && $wb['retweeted_status']) {
				$wb = $wb['retweeted_status'];
			} else {
				continue;
			}
		}
		$data[(string)$wb['id']] = fw_getItem($wb);
	}

	return $data;
}

/**
* 处理单条微博
* @param $wb array 单条微博数据
* @return array 格式化后的数据
*/
function fw_getItem($wb) {
	extract($wb, EXTR_SKIP);
	$json_element = array(
		'cr' => $created_at, //create time
		//'f' => isset($favorited) ? 1: 0, //is favorited
		's' => $source, //来源
		'tx' => $text //文本内容
	);
	if (isset($thumbnail_pic)) {
		$json_element['tp'] = $thumbnail_pic;
		$json_element['mp'] = $bmiddle_pic;
		$json_element['op'] = $original_pic;
	}

	$json_element['u'] = array(
		'id' => (string)$user['id'], //用户ID
		'sn' => $user['screen_name'], //显示的名称
		'p' => $user['profile_image_url'],
		'v' => $user['verified'] ? 1: 0
	);
	if (isset($retweeted_status) && empty($retweeted_status['filter_state'])) {
		$rt = &$retweeted_status;
		//原创用户信息
		$rtUser = &$rt['user'];

		//转发消息JSON部分
		$json_element['rt'] = array(
			'cr' => $rt['created_at'],
			//'f' => $rt['favorited'],
			'id' => (string)$rt['id'],
			's' => $rt['source'],
			'tx' => $rt['text'],
			//'fl' => $rtUser['following'] ? 1: 0,
			'sn' => $rtUser['screen_name'],
			'u' => array(
				'id' => (string)$rtUser['id'],
				'sn' => $rtUser['screen_name'],
				'v' => $rtUser['verified']? 1: 0,
				'p' => $rtUser['profile_image_url']
			)
		);

		if (isset($rt['thumbnail_pic'])) {
			$json_element['rt']['tp'] = $rt['thumbnail_pic'];
			$json_element['rt']['mp'] = $rt['bmiddle_pic'];
			$json_element['rt']['op'] = $rt['original_pic'];
		}
	}
	return $json_element;
}
?>
