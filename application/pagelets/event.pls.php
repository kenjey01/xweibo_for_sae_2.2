<?php
class event_pls {

	/**
	 * 活动列表
	 */
	function eventList($params = array()) {
		$page = V('g:page', 1);
		$limit = 20;
		$offset = ($page -1) * $limit;
		$joinList = array();
		$join_list = array();
		if ('hot' == $params['type']) {
			$list = DS('events.eventSearch', '', '', 1, '', false, $offset, $limit);
			/// 获取活动总记录数
			$count = DS('events.getEventCount', 'g0/1800', 1);
			if (empty($list)) {
				/// 没有推荐活动，获取参加人数多的正常活动列表
				$list = DS('events.eventSearch', '', '', 3, '', true, $offset, $limit);
				$count = DS('events.getEventCount', 'g0/1800', 3);
			}

			if (!empty($list)) {
				foreach ($list as $var) {
					$ids[] = $var['id'];
				}
				$joinList = DS('events.isJoinEvent', '', $ids, USER::uid());

				if ($joinList) {
					foreach ($joinList as $var) {
						$join_list[$var['event_id']] = $var['sina_uid'];
					}
				}
			}
		} elseif ('attend' == $params['type']) {
			/// 我参加的活动
			$list = DS('events.getMineAttendEvents', '', USER::uid(), $page, $limit);
			/// 获取活动总记录数
			$count = DS('events.getMineAttendEventsCount', 'g0/1800', USER::uid());
		} else if ( 'all'==$params['type'] ) {
			$list = DS('events.eventSearch', '', '', '', '', false, $offset, $limit);
			/// 获取活动总记录数
			$count = DS('events.getEventCount', 'g0/1800');
		} elseif ('more' == $params['type']) {
			$list = DS('events.eventSearch', '', '', 8, '', false, $offset, $limit);
			$count = DS('events.getEventCount', 'g0/1800');
		} else {
			$list = DS('events.eventSearch', '', '', '', USER::uid(), false, $offset, $limit);
			/// 获取活动总记录数
			$count = DS('events.getEventCount', 'g0/1800', '', USER::uid());
		}

		/// 获取活动总记录数
		//$count = DS('events.getCount');
		TPL::module('eventlist', array('list' => $list, 'join_list' => $join_list, 'count' => $count, 'limit' => $limit, 'type' => $params['type']));
		if ('hot' == $params['type']) {
			return array('cls'=>'event.eventinfo');
		}
	}

	/**
	 * 侧栏热门活动
	 */
	function sideHotEvents() {
		$events = DS('events.eventSearch', '','', 1, '', false, 0, 5);
		TPL::module('side_hot_events', array('events' => $events));
	}

	/**
	 * 侧栏最新活动
	 */
	function sideNewsEvents() {
		$events = DS('events.eventSearch', '', '', 8, '', false, 0, 5);
		TPL::module('side_news_events', array('events' => $events));
	}


	/**
	 * 活动成员列表
	 * @param $eid int 活动ID
	 */
	function eventMembers($event_info) {
		$page = V('r:page', 1);
		$limit = 20;
		$offset = $page - 1 < 0 ? 0: ($page -1) * $limit;
		$members = DS('events.getMembers', 'g0/1800', $event_info['id'], $limit, $offset);
		$total_count = DS('events.getMembersCount', 'g0/1800', $event_info['id']);
		//$total_count = DS('events.getCount');

		$users_info = array();
		$list_fans = array();
		if (!empty($members)) {
			$ids = array();
			for ($i=0, $count=count($members); $i< $count; $i++) {
				$ids[] = $members[$i]['sina_uid'];
			}
			$batch_info = F('get_user_show', implode(',', $ids));
			$batch_info = $batch_info['rst'];
			for ($i=0, $count=count($batch_info); $i<$count; $i++) {
				$users_info[$batch_info[$i]['id']] = $batch_info[$i];
			}

			/// 与参加活动人的关注关系
			$list_fans = DR('xweibo/xwb.getFriendIds', null, USER::uid(), null, null, -1, 5000);
			$listFans = array();
			if (empty($list_fans['errno'])) {
				$listFans = $list_fans['rst']['ids'];
			}
			/*
			$list_fans = DR('xweibo/xwb.getFriendshipsBatchExists', '', implode(',', $ids));
			$listFans = array();
			if (empty($list_fans['errno'])) {
				$list_fans = $list_fans['rst'];
				foreach ($list_fans as $var) {
					$listFans[$var['id']] = $var['result'];
				}
			}
			 */
		} 
		TPL::module('eventMembers', array('members'=> $members, 'users_info'=>$users_info,'event_info'=>$event_info, 'listFans'=>$listFans, 'limit' => $limit, 'count' => $total_count));
	}

	/**
	 * 活动评论框
	 */
	function eventInput($params = array()) {
		TPL::module('eventcomment', array('info' => $params['info']));
	}

	/**
	 * 活动评论微博列表
	 */
	function eventComment($infos =array()) {
		$eid = V('g:eid', '');
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = 20;

		///获取评论活动的微博列表
		$list_comment = DS('events.getEventComments', '', $eid, $page, $limit);
		$count = DS('events.getCount');
		$list = array();
		if ($list_comment) {
			$wb_ids = array();
			foreach ($list_comment as $var) {
				$item = json_decode($var['weibo'], true);
				$list[] = $item;
			}
		}

		$list		   = array_values($list);
		$param['list'] = $list;
		$param['limit'] = $limit;
		$param['author']=1;
		$param['show_filter_type'] = false;
		$param['show_list_title'] = false;
		$param['show_unread_tip'] = false;
		$param['empty_msg'] = L('pls__eventComment__emptyCommentTip');
		$param['total_count'] = $count;
		$param['page_type'] = 'event';
		TPL::module('eventweibos', array('param' => $param, 'info' => $infos['info']));

		return array('cls'=>'wblist', 'list' => F('format_weibo',$list));
	}

	/**
	 * 活动详细信息
	 */
	function eventinfo($params = array()) {
		$eid = V('g:eid', '');

		$join_list = array();
		$joinList = DS('events.isJoinEvent', '', $eid, USER::uid());
		if ($joinList) {
			foreach ($joinList as $var) {
				$join_list[$var['event_id']] = $var['sina_uid'];
			}
		}
		///获取参加活动的人数，显示5个
		$members = DS('events.getMembers', 'g0/1800', $eid, 5);

		$list_member = array();
		$list_fans = array();
		$listFans = array();
		if ($members) {
			foreach ($members as $var) {
				$ids[] = $var['sina_uid'];
			}

			/// 获取参加活动的成员个人信息
			$list_member = F('get_user_show', implode(',', $ids), '1800');
			if (empty($list_member['errno'])) {
				$list_member = $list_member['rst'];
			}

			/// 与参加活动人的关注关系
			$list_fans = DR('xweibo/xwb.getFriendIds', null, USER::uid(), null, null, -1, 5000);
			$listFans = array();
			if (empty($list_fans['errno'])) {
				$listFans = $list_fans['rst']['ids'];
			}
			/*
			$list_fans = DR('xweibo/xwb.getFriendshipsBatchExists', '', implode(',', $ids));
			if (empty($list_fans['errno'])) {
				$list_fans = $list_fans['rst'];
				foreach ($list_fans as $var) {
					$listFans[$var['id']] = $var['result'];
				}
			}
			 */

		}

		TPL::module('eventinfo', array('info' => $params['info'], 'join_list' => $join_list, 'list_member' => $list_member, 'listFans' => $listFans));
	}

	/**
	 * 发起或修改活动的表单
	 */
	function eventForm() {
		$eid = V('g:eid');

		$event = array();
		if ($eid) {
			///获取活动的详细信息
			$event = DS('events.getEventById', '', $eid);
		}
		TPL::module('eventform', array('event' => $event));
	}
}
