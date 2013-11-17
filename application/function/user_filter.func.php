<?php
/**************************************************
*  Created:  2010-06-13
*
*  用户过滤
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/
require_once  APP::functionFile('get_filter_cache');

/**
 * 用户过滤
 * @param $data Array 用户数据
 * @param $alone boolean 是否为单条数据
 * @param $chk_publish 是否检查最后发布的微博是否能通过
 * @return string
 */
function user_filter($data, $alone = false, $chk_publish = false){

	$f = APP::O('filter');
	if ($alone) {
		return $f->user($data);
	}
	return $f->users($data);
	/*
	return $data;
	$user_verify = get_filter_cache('user_verify');
	$filter_data = array(
				'disabled_weibo' => get_filter_cache('weibo'),
				'kw_content' => get_filter_cache('content')
				);
	$config = array(
				'debug' => true,
				'alone' => false,
				'check' => true
				);
	// 处理单条微博
    if ($config['alone']) {
		$r = user_filter_check($data, $config, $filter_data);
		if ($r !== true) {
			if ($config['debug']) {
				return $r;
			} else {
				return array();
			}
		}

		$data['site_v'] = isset($user_verify[(string)$data['id']]) ? 1 : 0;
		return $data;
	}
	$data_after_filter = array();
	$errors = array();
    foreach ($data as $key => $row) {
		$r = user_filter_check($row, $config, $filter_data);
		if ($r !== true && $config['debug']) {
			$errors[] = $r;
		}
		$row['site_v'] = isset($user_verify[(string)$row['id']]) ? 1 : 0;
		$data_after_filter[] = $row;
	}
	if ($config['debug']) {
		return array(
					'error' => $errors,
					'data' => $data_after_filte
					);
	}
	return $data_after_filter;
	*/
}

/**
 * 检查单条记录
 * @param $data array 记录项
 * @param $config array 过滤配置项
 * @return array
 */
function user_filter_check($data, $config, $filter_data) {
	if (!user_field_exists($data)) {
		return array('error'=> L('function__userFilter__missParams'), 'data'=>$data);
	}
	if ($config['check']) {
		$r = chk_user_content($data, $config, $filter_data);
		if ($r !== true) {
			return $r;
		}
	}
	return true;
}
/**
 * 检查数据是否完整
 * @param $data array 要被检查的数据项
 * @return boolean
 */
function user_field_exists($data) {
	if (isset($data['id']) && isset($data['screen_name']) && isset($data['description'])) {
			if (isset($data['status'])) {
				if (isset($data['status']['id']) && isset($data['status']['text']) ) {
					return true;
				}
				return false;
			}
		return true;
	}
	return false;
}

/**
 * 过滤用户
 */
function chk_user_content($data, $chk_publish) {
	$disabled_weibo = get_filter_cache('weibo');
	// 检查用户最后发布的微博是否被屏蔽
	if ($chk_publish && isset($data['status']) && isset($disabled_weibo[$data['status']['id']])) return false;
	// 昵称和内容的关键字过滤
	$kw_content = get_filter_cache('content');
	// 如果用户被屏蔽
	$kw_nick = get_filter_cache('nick');
	if (isset($kw_nick[(string)$data['id']])) {
		return false;
	}
	// 内容关键字过滤
	if (isset($data['status'])) {
		$text = $data['status']['text'];
		do {
			if (strpos($text, key($kw_content)) > -1) {
				return false;
			}
		} while(next($kw_content));
	}
	
	return true;
}
