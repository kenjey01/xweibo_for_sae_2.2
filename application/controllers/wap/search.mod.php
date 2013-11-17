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

class search_mod extends action {
	
	function search_mod() {


		//session_start();
		
	}
	
	function default_action() {

		$k = V('r:k', false);
		
		if ($k) {
			$p = V('g:page', 1);
			
			if ($k !== false && !empty($k)) {
				if(V('r:search_sina',false)){
						$base_app = '0';		
				}
				elseif(V('r:search_app',false)){
						$base_app = '1';
				}
				else{
						$base_app = V('r:base_app', '0');		
				}
				
				
				if ($base_app !== '1') {
					$base_app = '0';
				}

				// 搜索微博
				$each_page = 10;
				$q = array(
					'q' => $k,
					'base_app' => $base_app,
					'page' => $p,
					'count' => $each_page,
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
				$each_page = 4;
				$q = array(
					'q' => $k,
					'snick' => 1,
					'sintro' => 1,
					'sort' => 2,
					'base_app' => $base_app,
					'count' => $each_page,
					'page' => 1
				);
				$rs = DR('xweibo/xwb.searchUser', '', $q);
				$rs = $rs['rst'];

				// 过滤用户
				$rs = APP::F('user_filter', $rs);
				$uid = USER::uid();
				TPL::assign('sina_uid', $uid);
				$rst = DR('xweibo/xwb.getFriendIds', '', $uid, null, null, -1, 5000);
				$rst = $rst['rst'];
				$ids = $rst['ids'];

				//$ids = $wb->getFriendIds($uid, null, null, -1, 5000);
				$rs = array_slice($rs, 0, $each_page);
				foreach ($rs as $key => $row) {
					
					if (in_array($row['id'], $ids)) {
						$rs[$key]['following'] = true;
					}
				}
				TPL::assign('users', $rs);
			}
			APP::setData('page', 'search', 'WBDATA');
		}
		$base_app=isset($base_app)?$base_app:'0';
		TPL::assign('base_app',$base_app);		
		

		//$this->_setBackURL();
		$this->_setBackURL(URL('search','base_app='.$base_app.'&k='.$k.'&page='. V('g:page', 1)));
		$this->_display('searchResult');
		
	}
	/**
	 * search for message
	 *
	 */
	
	function weibo() {

		$k = V('r:k', false);
		
		if ($k !== false && !empty($k)) {
			$base_app = V('r:base_app', '0');
			
			if ($base_app != 1) {
				$base_app = 0;
			}
			$filter_pic = (int)V('r:filter_pic', 0);
			
			if ($filter_pic > 2 || $filter_pic < 0) {
				$filter_pic = 0;
			}
			$each_page = 10;
			$p = V('g:page', 1);
			$q = array(
				'needcount' => 'true',
				'q' => $k,
				'base_app' => $base_app,
				'page' => $p,
				'count' => $each_page,
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
			TPL::assign('list', $result);
			TPL::assign('extends', array(
				'k' => $k,
				'base_app' => $base_app
			));
		}
		APP::setData('page', 'search.weibo', 'WBDATA');
		TPL::assign('base_app',isset($base_app)?$base_app:'0');		
		$this->_display('searchResult');
		$this->_setBackURL();
	}
	/**
	 * search for user
	 *
	 */
	
	function user() {

		$k = V('r:k', false);
		$page = V('r:page', 1);
		
		if ($k !== false && !empty($k) && trim($k)) {
			$base_app = V('r:base_app', '0');
			
			if ($base_app !== '1') {
				$base_app = '0';
			}
			$each_page = 10;
			$k = urldecode($k);

			//$wb = APP::N('weibo');
			$s = V('r:s', 2);
			$q = array(
				'q' => $k,
				'snick' => 1,
				'sintro' => 1,
				'base_app' => $base_app,
				'sort' => $s,
				'count' => $each_page,
				'page' => $page
			);
			$rs = DR('xweibo/xwb.searchUser', '', $q);

			//$rs = $rs['rst'];
			
			//$rs = $wb->searchUser($q);

			$rs = APP::F('user_filter', $rs['rst']);

			//$pager = APP::N('pager');
			
			//$html = $pager->pagehtml(array(),sizeof($rs));

			
			//TPL :: assign('pager', $html);

			
			//实例化存储

			
			//$storage = APP::N('clientUser');

			
			//$uid = $storage->getInfo('sina_uid');

			$uid = USER::uid();
			TPL::assign('sina_uid', $uid);
			$ids = DS('xweibo/xwb.getFriendIds', '', $uid, null, null, -1, 5000);
			$ids = $ids['ids'];

			//$ids = $wb->getFriendIds($uid, null, null, -1, 5000);
			$rs = array_slice($rs, 0, $each_page);
			foreach ($rs as $key => $row) {
				
				if (in_array($row['id'], $ids)) {
					$rs[$key]['following'] = true;
				}
			}
			TPL::assign('extends', array(
				'k' => $k,
				'base_app' => $base_app
			));
			TPL::assign('each_page', $each_page);
			TPL::assign('users', $rs);
		}
		APP::setData('page', 'search.user', 'WBDATA');
		TPL::assign('base_app',isset($base_app)?$base_app:'0');		
		$this->_display('searchResult');
		$this->_setBackURL();
	}
	
	function recommend() {

		
		if ($uid = USER::uid()) {
			$rst = DS('xweibo/xwb.getUserSuggestions', '', 1, 12);
			$ids = DS('xweibo/xwb.getFriendIds', '', $uid, null, null, -1, 5000);
			$ids = $ids['ids'];
			for ($i = 0, $count = count($rst);$i < $count;$i++) {
				$rst[$i]['user']['following'] = in_array($rst[$i]['user']['id'], $ids) ? true : false;
			}
			TPL::assign('suggestions', $rst);
		}
		$modules = DS('PageModule.getPageModules', /*'g1/300'*/

		'', 1, 1);
		TPL::assign('side_modules', isset($modules[2]) ? $modules[2] : array());
		APP::setData('page', 'search.recommend', 'WBDATA');
		TPL::display('search/user_recommend');
	}
}
