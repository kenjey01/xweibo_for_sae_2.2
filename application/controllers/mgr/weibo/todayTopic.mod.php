<?php
include(P_ADMIN_MODULES . '/action.abs.php');
class todayTopic_mod extends action {

	function todayTopic_mod() {
		parent :: action();
	}
	
	function add() {
		if ($this->_isPost()) {
			$topic = V('p:topic');
			$list_id = V('p:topic_id');
			$date = V('p:start_date');
			$time = V('p:start_time');
			if (!$topic) {
				$this->_error('请填写话题内容', array('add'));
			}
			if ($date && $time) {
					$date = explode('-', $date);
					$time = explode(':', $time);
					$start_time = @mktime($time[0], $time[1], 0, $date[1], $date[2], $date[0]);
					if (!$start_time) {
						$start_time = APP_LOCAL_TIMESTAMP;
					}
			} else {
				$start_time = APP_LOCAL_TIMESTAMP;
			}
			$data = array(
						'topic' => $topic,
						'list_id' => $list_id,
						'date_time' => $start_time,
						'sort_num' => $sort_num
					);
			DR('xweibo/topics.saveTopic', '', $data);

			//清除缓存
			DS('PageModule.clearTopicCache', '', $list_id);

			$this->_succ('已成功保存', array('topicList'));
		}
		$this->_display('today_topic/today_topic_add');
	}

	/**
	 * 添加话题类别
	 */
	function addCategory() {
		if ($this->_isPost()) {
			$topic_name = V('p:topic_name', false);
			is_string($topic_name) || $this->_error('缺少参数');
			$id = V('p:topic_id', null);
			$data = array(
						'topic_name' => $topic_name
						);
			if ($id == null) {
				$data['native'] = 0;
			}
			$rst = DR('xweibo/topics.saveCategory','', $data, $id);
			$this->_succ('已成功保存', array('category'));
		}

		$id = V('g:id', false);
		if ($id) {
			$rst = DR('xweibo/topics.getCategory', '', $id);
			TPL::assign('info', $rst['rst']);
		}
		$this->_display('today_topic/add_category');
	}

	/**
	 * 得到类别信息
	 */
	function getCategoryInfo() {
		$id = V('g:id', false);
		if ($id) {
			$rst = DR('xweibo/topics.getCategory');
			APP::ajaxRst($rst['rst']);
		}
	}
						
	function saveOrder(){
		$orders = V('r:ids');
		$cty = V('r:lid');
		$rst = DS('xweibo/topics.saveSort', '', $cty, $orders);
		
		//清除缓存
		DS('PageModule.clearTopicCache', '', $cty);

		APP::ajaxRst($rst);
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
		} else {
			$this->_error('最少保留一个话题', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
		}
		

		//强制清除缓存
		DS('PageModule.clearTopicCache', '', $topic_id);
		
		$this->_succ('已经成功删除', URL('mgr/weibo/todayTopic.topicList', 'category=' . $topic_id, 'admin.php'));
		//$this->_redirect('topicList');
	}

}
