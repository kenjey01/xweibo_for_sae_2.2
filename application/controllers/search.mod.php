<?php
/**************************************************
*  Created:  2010-06-08
*
*  搜索
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/

class search_mod
{
	function search_mod() {
		//session_start();
	}
	function default_action() {
		$k = V('r:k', false);
		$p = V('g:page', 1);
		///在搜索的第一步对给关键字进行过滤
		$k_filter=F('filter',$k,'content')===TRUE;
		if ($k !== false && !empty($k) &&$k_filter) {
			// 搜索微博
			$each_page = 5;
			$q = array(
					'q' => $k,
					'base_app' => (V('r:wb_base_app') === '1' ? '1' : '0'),
					'page' => $p,
					'count' => $each_page * 2,
					'needcount' => 'true'
					);
			$rss = DR('xweibo/xwb.searchStatuse', '', $q);
			$rs = $rss['rst'];
			if ($rss['errno']) {
				$rs['results'] = array();
				$rs['total_count_maybe'] = 0;
			}
			$result = F('weibo_filter', $rs['results']);
			$result = array_slice($result, 0, $each_page);
			TPL::assign('total_count_maybe', $rs['total_count_maybe']);
			TPL::assign('list', $result);

			// 搜索用户
			$each_page = 6;
			$q = array(
				'q' => $k,
				'snick' => 1,
				'sintro' => 1,
				'sort' => 2,
				'base_app' => (V('r:us_base_app') === '1' ? '1' : '0'),
				'count' => $each_page * 2,
				'page' => 1
			);
			$rs = DR('xweibo/xwb.searchUser', '', $q);
			if ($rs['errno']) {
				$rs = array();
			} else {
				$rs = $rs['rst'];
				// 过滤用户
				$rs = APP::F('user_filter', $rs);
			}
			$uid = USER::uid();
			TPL :: assign('sina_uid', $uid);

			$rst = DR('xweibo/xwb.getFriendIds', '', $uid, null, null, -1, 5000);
			$rst = $rst['rst'];
			$ids = $rst['ids'];
			//$ids = $wb->getFriendIds($uid, null, null, -1, 5000);

			$rs = array_slice($rs, 0, 4);
			foreach($rs as $key => $row) {
				if (in_array($row['id'], $ids)) {
					$rs[$key]['following'] = true;
				}
			}
			TPL :: assign('users', $rs);
		}
		// 侧栏
		$modules = DS('PageModule.getPageModules', /*'g1/300'*/'', 1, 1);
		TPL :: assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		APP::setData('page', 'search', 'WBDATA');
		TPL :: display('search/search');
	}

	/**
	 * search for message
	 *
	 */
	function weibo() {
		$k = V('r:k', false);
		///在搜索的第一步对给关键字进行过滤
		$k_filter=F('filter',$k,'content')===TRUE;
		if ($k !== false && !empty($k) && $k_filter) {
			$base_app = V('r:base_app', '0');
			if ($base_app != 1) {
				$base_app = 0;
			}
			$filter_pic = (int)V('r:filter_pic', 0);
			if ($filter_pic > 2 || $filter_pic < 0) {
				$filter_pic = 0;
			}
			$each_page = 20;
			$p = V('g:page', 1);
			$q = array(
					'needcount' => 'true',
					'q' => $k,
					'base_app' => $base_app,
					'page' => $p,
					'count' => $each_page * 2,
					'filter_pic' => $filter_pic,
					'needcount' => 'true'
					);
			$results = DR('xweibo/xwb.searchStatuse', '', $q);
			$result = $results['rst'];
			if ($results['errno']) {
				$result['results'] = array();
				$result['total_count_maybe'] = 0;
			}
				TPL::assign('total_count_maybe', $result['total_count_maybe']);
				$result = $result['results'];
				$result = F('weibo_filter', $result);
				TPL::assign('each_page', $each_page);
				$rs = array_slice($result, 0, $each_page);
				TPL :: assign('list', $result);
				TPL::assign('extends', array('k'=>$k, 'base_app' => $base_app));
		}
		// 侧栏
		$modules = DS('PageModule.getPageModules', /*'g1/300'*/'', 1, 1);
		TPL :: assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		APP::setData('page', 'search.weibo', 'WBDATA');
		TPL :: display('search/search_mblog');
	}

	/**
	 * search for user
	 *
	 */
	function user() {
		
		$k = strval(V('r:k', false));
		///在搜索的第一步对给关键字进行过滤
		$k_filter=F('filter',$k,'content')===TRUE;
		$page = intval(V('r:page', 1));
		if (!empty($k) && trim($k) && $k_filter) {
			$base_app = intval(V('r:base_app', 0));
			if ($base_app != 1) {
				$base_app = 0;
			}
			$each_page = 20;
			$k = urldecode($k);
			//$wb = APP::N('weibo');
			$s = V('r:s', 2);
			$q = array(
					'q' => $k,
					'snick' => (V('r:ut', 'nick') === 'nick' ? '1' : '0'),
					'sintro' => (V('r:ut') === 'sintro' ? '1' : '0'),
					'base_app' => $base_app,
					'stag' => (V('r:ut') === 'tags' ? '1' : '0'),
					'sort' => $s,
					'count' => $each_page * 2,
					'page' => $page
					);
			
			$rs = DS('xweibo/xwb.searchUser', '', $q);
			//$rs = $rs['rst'];
			//$rs = $wb->searchUser($q);
			$rs = APP::F('user_filter', $rs);
			//$pager = APP::N('pager');
			//$html = $pager->pagehtml(array(),sizeof($rs));
			//TPL :: assign('pager', $html);
			//实例化存储
			//$storage = APP::N('clientUser');
			//$uid = $storage->getInfo('sina_uid');
			$uid = USER::uid();
			TPL :: assign('sina_uid', $uid);
			$ids = DS('xweibo/xwb.getFriendIds', '', $uid, null, null, -1, 5000);
			$ids = $ids['ids'];
			//$ids = $wb->getFriendIds($uid, null, null, -1, 5000);
			$rs = array_slice($rs, 0, $each_page);
			foreach($rs as $key => $row) {
				if (in_array($row['id'], $ids)) {
					$rs[$key]['following'] = true;
				}
			}
			TPL::assign('extends', array('k'=>$k, 'base_app' => $base_app));
			TPL::assign('each_page', $each_page);
			TPL :: assign('data', $rs);
		}
		// 侧栏
		$modules = DS('PageModule.getPageModules', /*'g1/300'*/'', 1, 1);
		TPL :: assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		APP::setData('page', 'search.user', 'WBDATA');
		TPL::display('search/search_user');
	}

	function recommend() {
		if ($uid = USER::uid()) {
			$rst = DS('xweibo/xwb.getUserSuggestions', '', 1, 12);
			$ids = DS('xweibo/xwb.getFriendIds', '', $uid, null, null, -1, 5000);
			$ids = $ids['ids'];
			for ($i=0, $count = count($rst);$i < $count; $i++) {
				$rst[$i]['user']['following'] = in_array($rst[$i]['user']['id'], $ids) ? true : false;
			}
			TPL::assign('suggestions', $rst);
		}

		$modules = DS('PageModule.getPageModules', /*'g1/300'*/'', 1, 1);
		TPL :: assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		APP::setData('page', 'search.recommend', 'WBDATA');
		TPL::display('search/user_recommend');
	}
}
