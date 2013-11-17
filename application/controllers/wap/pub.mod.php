<?php

/**************************************************
 *  Created:  2010-06-08
 *
 *  微博广场
 *
 *  @Xweibo (C)1996-2099 SINA Inc.
 *  @Author zhenquan <zhenquan@staff.sina.com.cn>
 *
 ***************************************************/
require_once ('action.basic.php');

class pub_mod extends action {
	
	function pub_mod() {
		parent::action();
	}
	
	function default_action() {
		//TPL :: display('wap/pub');
		$this->hotForward();
	}
	/**
	 * 话题排行榜
	 *
	 */
	
	function topics() {

		$base_app = (int)V('g:base_app', 0) == 0 ? 0 : 1;
		$type = (int)V('g:type', 0);
		$page = (int)V('g:page', 1);
		$limit = 10;
		$uid = USER::uid();
		
		if (!$uid) {
			
			if (!defined('WB_USER_OAUTH_TOKEN') || !WB_USER_OAUTH_TOKEN) {
				APP::redirect(URL('index.account') , 4);
			} else {
				DR('xweibo/xwb.setToken', '', 2);
			}
		}
		
		switch ($type) {
			case 2:

				//日
				$data = DR('xweibo/xwb.getTrendsDaily', 'g2/600', false, $base_app);
			break;
			case 3:

				//周
				$data = DR('xweibo/xwb.getTrendsWeekly', 'g2/3600', false, $base_app);
			break;
			case 1:
			default:

				//小时
				$data = DR('xweibo/xwb.getTrendsHourly', 'g2/300', false, $base_app);
			break;
		}
		
		if ($data['errno'] != 0) {
			$data['rst']['trends'] = array();
		}
		$datas = array_values($data['rst']['trends']);
		$datas = $datas[0];
		$num = count($datas);
		$pages = ceil($num / $limit);
		$data = array_slice($datas, $limit * ($page - 1) , $limit);
		DR('xweibo/xwb.setToken', '', 1);
		TPL::assign('base_app', $base_app);
		TPL::assign('pages', $pages);
		TPL::assign('page', $page);
		TPL::assign('data', $data);
		TPL::assign('limit', $limit);
		$this->_display('topics');
	}
	
	function hotComments() {


		//热门评论
		$status = DR('components/hotWB.getComment', 'g/300', array(
			'show_num' => 20,
			'source' => 0
		));
		$this->common($status);
	}
	
	function hotForward() {


		//热门转发
		$status = DR('components/hotWB.getRepost', 'g/300', array(
			'show_num' => 20,
			'source' => 0
		));
		$this->common($status);
	}
	
	function common($status) {

		$data = DR('wap/pub.getFirstLineTitle', 'g/600', '');
		
		if (isset($data['rst'][0])) {
			TPL::assign('default_rem_title', $data['rst'][0]['title']);
			$param = json_decode($data['rst'][0]['param'], TRUE);
			$users = DS('components/star.get', 'g/300', $param);
			TPL::assign('users', $users);
		}
		$page = (int)V('g:page', 1);
		$limit = 10;
		
		if (isset($status['rst'])) {
			TPL::assign('status', array_slice($status['rst'], $page - 1, $limit));
			$hasNext = ($page >= 2 ? FALSE : TRUE);
			$hasUp = ($page >= 2 ? TRUE : FALSE);
			TPL::assign('pageStatus', array(
				$hasNext,
				$hasUp
			));
		}

		//热门话题就简表
		$topics = DR('xweibo/xwb.getTrendsDaily', 'g2/600', false, 0);
		//var_dump($topics);
		if(isset($topics['rst']['trends']))
		TPL::assign('topics', array_values($topics['rst']['trends']));
		$this->_display('pub');
		$this->_setBackURL();
	}
}
