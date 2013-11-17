<?php
include(P_ADMIN_MODULES . '/action.abs.php');
class weiboCopy_mod extends action {

	function weibo_mod() {
		parent :: action();
	}

	function weiboList() {
		$start_date = V('r:start');
		$end_date = V('r:end');
		$page = (int)V('r:page', 1);
		$keyword = V('r:keyword');
		$rows = V('r:rows', 20);

		$start = strtotime($start_date.' 00:00:00');
		$end = strtotime($end_date . ' 23:59:59');

		$query = array(
			'keyword' => $keyword,
			'start' => $start,
			'end' => $end,
			);
		if (V('r:disabled')!='all') {
			$query['disabled'] = V('r:disabled');
		}
		if ($page < 1) {
			$page = 1;
		}
		$offset = ($page-1) * $rows;
		$data = DR('xweibo/weiboCopy.getList', '', $query, $rows, $offset, true);
		$pager = APP :: N('pager');
		$count = DS('xweibo/weiboCopy.getCount', '');
		$page_param = array('currentPage'=> $page, 'pageSize' => $rows, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		$pager->setVarExtends(array('keyword' => $keyword, 'start' => $start_date, 'end' => $end_date));
		TPL :: assign('pager', $pager->makePage());
		TPL::assign('list', $data);
		$this->_display('weibo/weibo_copy_list');
	}
						
	function disabled () {
		$id = (float)V('r:id');
		$v = (int)V('r:value');
		if ($v != 0) {
			$v = 1;
		}
		DS('xweibo/weiboCopy.disabled', '', $id, $v);
		if ($v == 1) {
			// 取得微博信息
			$rst = DR('xweibo/xwb.getStatuseShow','', $id);
			if (isset($rst['errno']) && $rst['errno']) {
				$this->_error('没有被屏蔽的微博', $_SERVER['HTTP_REFERER'] );
			}
			$data = $rst['rst'];
			if (isset($data['error_code']) && $data['error_code']) {
				$this->_error('Error: ' . $data['error'] . ', Code:' .  $data['error_code']);
			}
			$values = array(
					'type' => 1,
					'item' => $data['id'],
					'comment' => $data['text'],
					'user' => $data['user']['screen_name'],
					'publish_time' => date('Y-m-d H:i:s', strtotime($data['created_at'])),
					'add_time' =>APP_LOCAL_TIMESTAMP,
					'admin_name' => $this->_getUserInfo('screen_name'),
					'admin_id' => $this->_getUid()
					);
			$rst = DR('xweibo/disableItem.save', '', $values);
		} else {
			$rst = DR('xweibo/disableItem.resumeByItem', '', $id, 1);
		}
		// 添加成功则更新缓存
		if ($rst['rst'] > 0) {
			DD('xweibo/disableItem.getDisabledItems', 'g1/0', 1);
		}	
		$this->_succ('已成功'.($v=='0'?'恢复':'屏蔽'), $_SERVER['HTTP_REFERER']);
	}

	function delCategory() {
		$id = (int)V('g:id', false);
		if (!$id) {
			$this->_error('没有指定要删除话题类别');
		}
		$rst = DR('xweibo/topics.delCategory', '', $id);
		$this->_succ('已成功删除', array('category'));
	}

	/**
	 * 话题类别列表
	 */
	function category() {
		$data = DR('xweibo/topics.getCategoryByType');
		$data = $data['rst'];
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$data[$i]['apps'] = array();
			$names = DS('PageModule.getComponents', '', explode(',', $data[$i]['app_with']));
			for ($j=0,$j_count=count($names); $j < $j_count; $j++) {
				$data[$i]['apps'][] = $names[$j]['name'];
			}
		}
		TPL::assign('data', $data);
		$this->_display('today_topic/category');
	}

	function topicList() {
		$page = V('g:page', 1);
		$each = V('g:each', 20);
		$keyword = V('g:keyword', '');
		$offset = ($page -1) * $each;
		$category = V('g:category', false);

		$rst = DR('xweibo/topics.getCategory', '', $category);
		TPL::assign('category', $rst['rst']);

		$offset = ($page -1) >= 0 ?($page -1) * $each :0;
		$rst = DR('xweibo/topics.getTopicByCty', '', $category, $each, $offset);
		TPL :: assign('list', $rst['rst']);
		TPL::assign('offset', $offset);

		$count = DR('xweibo/topics.getCount');
		$count = $count['rst'];

		if ($category == 2) {
			$pager = APP :: N('pager');
			$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
			$pager->setParam($page_param);
			$pager->setVarExtends(array('keyword' => $keyword));
			TPL :: assign('pager', $pager->makePage());
		}
		$this->_display('today_topic/today_topic_list');
	}

	/**
	 * 添加/编辑话题
	 */
	function edit() {
		if ($this->_isPost()) {
			$id = V('p:id');
			$topic = V('p:topic', '');
			$topic_id = V('p:topic_id');
			$sort_num = V('p:sort_num');
			$ext1 = V('p:ext1', '');
			$max_rec = 20;
			if ('' === trim($topic)) {
				$this->_error('话题不能为空', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
			}
			if (!$id && $topic_id != 2 && DS('xweibo/topics.countTopic','', $topic_id) >= $max_rec) {
				$this->_error('最多添加'. $max_rec . '条记录', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
			}
			/*
			$date = V('p:start_date');
			$time = V('p:start_time');

			if ($date && $time) {
					$date = explode('-', $date);
					$time = explode(':', $time);
					$start_time = mktime($time[0], $time[1], 0, $date[1], $date[2], $date[0]);
					if (!$start_time) {
						$start_time = APP_LOCAL_TIMESTAMP;
					}
			*/
			if ($ext1) {
				$ext1 = explode(' ', $ext1);
				if (count($ext1) < 2) {
					$this->_error('时间格式不正确，应为:yyyy/mm/dd hh:mm', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
				}
				$date = explode('/', $ext1[0]);
				if (count($date) < 3) {
					$this->_error('时间格式不正确，应为:yyyy/mm/dd hh:mm', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
				}
				$time = explode(':', $ext1[1]);
				if (count($time) < 2) {
					$this->_error('时间格式不正确，应为:yyyy/mm/dd hh:mm', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
				}
				$start_time = mktime($time[0], $time[1], 0, $date[1], $date[2], $date[0]);
				if (!$start_time) {
					$start_time = APP_LOCAL_TIMESTAMP;
				}
			} else {
				$start_time = APP_LOCAL_TIMESTAMP;
			}
			$data = array(
						'topic' => $topic,
						'topic_id' => $topic_id,
						'ext1' => $start_time,
						'date_time' => APP_LOCAL_TIMESTAMP,
						'sort_num' => $sort_num,
						'topic_id' => $topic_id
					);
			DR('xweibo/topics.saveTopic', '', $data, $id);
			
			//清除缓存
			DS('PageModule.clearTopicCache', '', $topic_id);

			$this->_succ('已成功保存', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
		}
		$id = V('g:id', false);
		if ($id) {
			$rst = DR('xweibo/topics.getTopic', '', $id);
			TPL :: assign('info', $rst['rst']);
		}
		$this->_display('today_topic/today_topic_edit');
	}

	function delete() {
		$ids = V('r:id');

		switch (true) {
			case is_string($ids): $ids = explode(',', $ids); break;
			case is_int($ids): $ids = (array)$ids; break;
			default: $ids = (array)$ids;
		}


		// 取得要删除主题的类别，并测试该类别下,如果删除指定的记录后是否存在有最少一条记录
/*
		foreach ($ids as $id) {
			$row = DS('xweibo/topics.getTopic', '', $id);

			//清除缓存
			DS('PageModule.clearTopicCache', '', $row['topic_id']);
		}
*/
		$rst = DR('xweibo/topics.getTopic', '', $ids[0]);
		if (!$rst || empty($rst['rst'])) {
			$this->_error('没有可以删除的数据', URL('mgr/weibo/todayTopic.category', 'admin.php'));
		}
		$topic_id = $rst['rst']['topic_id'];
		$rst = DR('xweibo/topics.hasTopics', '', $topic_id);

		if ($topic_id != 2 || $rst['rst'] && $rst['rst'] > count($ids)) {
			$rst = DR('xweibo/topics.deleteTopic', '', $ids);
			//清除缓存
			DS('PageModule.clearTopicCache', '', $topic_id);
		} else {
			$this->_error('最少保留一个话题', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
		}
		$this->_succ('已经成功删除', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
		//$this->_redirect('topicList');
	}

}
