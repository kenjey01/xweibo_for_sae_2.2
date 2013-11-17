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
 * 微博过滤
 * @param $data 数据
 * @param $alone 是否为单条记录
 * @return array
 */

function weibo_filter($data, $alone = false) {
	$f = APP::O('filter');
	if ($alone) {
		return $f->weibo($data);
	}
	return $f->weibos($data);
	/*
	return $data;
	$user_verify = get_filter_cache('user_verify');
    if ($alone) {
		if (chk_weibo($data) && chk_content($data)) {
			$row = $data;

			$row['user']['site_v'] = isset($user_verify[$row['user']['id']]) ? 1 : 0;
			if (isset($row['retweeted_status'])) {
				$row['retweeted_status']['user']['site_v'] = isset($user_verify[$row['retweeted_status']['user']['id']]) ? 1 : 0 ;
			}
			if (isset($row['status'])) {
				$row['status']['user']['site_v'] = isset($user_verify[$row['status']['user']['id']]) ? 1 : 0;
			}
			return $row;
		} else {
			return array();
		}
	}
	$data_after_filter = array();
	if (is_array($data)) {
		foreach ($data as $key => $row) {
			if (chk_weibo($row) && chk_content($row)) {
				$row['user']['site_v'] = isset($user_verify[$row['user']['id']]) ? 1 : 0;
				if (isset($row['retweeted_status'])) {
					$row['retweeted_status']['user']['site_v'] = isset($user_verify[$row['retweeted_status']['user']['id']]) ? 1 : 0 ;
				}
				if (isset($row['status'])) {
					$row['status']['user']['site_v'] = isset($user_verify[$row['status']['user']['id']]) ? 1 : 0;
				}
				$data_after_filter[] = $row;
			}
		}
		return $data_after_filter;
	}else{
		return array();
	}
	*/
}

function chk_weibo(&$data) {
	if (!field_exists($data)) return false;
	if (isset($data['retweeted_status'])) {
		if (!field_exists($data['retweeted_status'])) return false;
	}
	if (isset($data['status'])) {
		if (!field_exists($data['status'])) return false;
	}
	return true;
}

function field_exists($data) {
	if ( isset($data['id']) && isset($data['text']) ) {
		if (isset($data['user'])) {
				if (isset($data['user']['screen_name']) && isset($data['user']['description'])) {
					return true;
				}
				return false;
		}
		return true;
	}
	return false;
}

/**
 * 过滤微博或回复
 */
function chk_content($data) {
	$disabled_weibo = get_filter_cache('weibo');
	$disabled_comment = get_filter_cache('comment');

	if (isset($disabled_weibo[(string)$data['id']]) || isset($data['status']) && isset($disabled_comment[(string)$data['id']])) {
		return false;
	} 	
	// 昵称和内容的关键字过滤
	$kw_content = get_filter_cache('content');
	$kw_nick = get_filter_cache('nick');
	$size_content = 1 + sizeof($kw_content);
	$size_nick = 1 + sizeof($kw_nick);
	// 用户名关键字过滤,如查回复或转发的微博的用户被屏蔽
	if (isset($data['status']) && isset($kw_nick[$data['status']['user']['id']]) ||
			isset($data['retweeted_status']) && isset($kw_nick[$data['retweeted_status']['user']['id']])
				) {
		return false;
	}
	$content = $data['text'] . $data['user']['screen_name'] . $data['user']['description'] ;
	$content .= isset($data['from_user']) ? $data['from_user'] : '';
	if (isset($data['status']) ) {
		$content .= $data['status']['user']['screen_name'] .$data['status']['user']['description'] . $data['status']['text'];
	}
	if (isset($data['retweeted_status'])) {
		$content .= $data['retweeted_status']['user']['screen_name'] . $data['retweeted_status']['user']['description'] . $data['retweeted_status']['text'];
	}
	// 内容关键字过滤,如果回复的微博或回复的作者名包含有关键字
	do {
		if (strpos($content, key($kw_content)) > -1) {
			return false;
		}
	} while(next($kw_content));
	return true;
}
