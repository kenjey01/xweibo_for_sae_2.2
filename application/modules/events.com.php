<?php
/**************************************************
*  Created:  2010-12-23
*
*  活动相关数据操作模型
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author heli1 <heli1@staff.sina.com.cn>
*
***************************************************/

class events
{
	var $db;
	var $table;
	var $count_sql;
	
	function events()
	{
		$this->db = APP::ADP('db');
		$this->table = $this->db->getTable(T_EVENTS);
	}
	
	/**
	 * 搜索活动
	 *
	 * @param string $keyword  关键字，模糊匹配活动标题与发起人昵称
	 * @param int $state  状态ID，0为所有状态
	 * @param int $offset
	 * @param int $limit
	 * @return unknown
	 */
	function eventSearch($keyword = '', $state = 0, $sina_uid = 0, $join = false, $offset = 0, $limit = 50)
	{
		$where = array();
		if ($keyword !== '') {
			$where[] = "(title LIKE '%" . $this->db->escape($keyword) . "%' OR nickname LIKE '%" . $this->db->escape($keyword) . "%')";
		}
		$time = APP_LOCAL_TIMESTAMP;
		switch ($state) {
			case 4:$where[] = '`state`=2';break;// 关闭
			case 5:$where[] = '`state`=3';break;// 封禁
			case 6:$where[] = $time . ' > `end_time` AND `state` IN(1,4)'; break;// 已完成
			case 1:$where[] = '`state`=4 AND `end_time` > ' .$time; break; // 推荐
			case 2:$where[] = '`end_time` > ' . $time .' AND `start_time` < ' . $time . ' AND `state` IN(1,4)'; break;//进行进
			case 3:$where[] = '`end_time` >' .$time . ' AND `state` IN (1,4)'; break;// 正常
			case 7:$where[] = '`start_time` >' .$time . ' AND `state` IN (1,4)'; break; // 未进行
			case 8:$where[] = '`state` NOT IN(2,3)';break; //最新活动
		}

		if ($sina_uid > 0) {
			$where[] = "sina_uid = '". $this->db->escape($sina_uid) . "'";
		}

		if ($join) {
			$order_str = " ORDER BY join_num DESC";
		} else {
			$order_str = " ORDER BY add_time DESC";
		}
		
		$where_sql = !empty($where) ? (' AND ' . implode(' AND ', $where)) : '';
		
		$sql = "SELECT * FROM " . $this->table . " WHERE 1=1" . $where_sql . $order_str;
		if ($limit) {
			$sql .= (' LIMIT ' . $offset . ',' . $limit);
		}
		$data = $this->db->query($sql);
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$data[$i]['state_num'] = $this->getState($data[$i]);
		}
		$this->count_sql = "SELECT COUNT(*)AS count FROM " . $this->table . " WHERE 1=1" . $where_sql;
		return RST($data);
	}

	/**
	 * 获取热门活动，我发起的活动列表
	 *
	 * @param int $state
	 * @param int $sina_uid
	 *
	 * @return array
	 */
	function getEventCount($state = 0, $sina_uid = false) {
		$where = array();
		$time = APP_LOCAL_TIMESTAMP;
		switch ($state) {
			case 4:$where[] = '`state`=2';break;// 关闭
			case 5:$where[] = '`state`=3';break;// 封禁
			case 6:$where[] = $time . ' > `end_time` AND `state` IN(1,4)'; break;// 已完成
			case 1:$where[] = '`state`=4 AND `end_time` > ' .$time; break; // 推荐
			case 2:$where[] = '`end_time` > ' . $time .' AND `start_time` < ' . $time . ' AND `state` IN(1,4)'; break;//进行进
			case 3:$where[] = '`end_time` >' .$time . ' AND `state` IN (1,4)'; // 正常
		}

		if ($sina_uid > 0) {
			$where[] = "sina_uid = '". $this->db->escape($sina_uid) . "'";
		}

		
		$where_sql = !empty($where) ? (' AND ' . implode(' AND ', $where)) : '';
		
		$sql = "SELECT count(*) FROM " . $this->table . " WHERE 1=1" . $where_sql;
		return RST($this->db->getOne($sql));
	}
	
	/**
	 * 我参加的活动
	 *
	 * @param int $page
	 * @param int $limit
	 * @return array 
	 */
	function getMineAttendEvents($uid, $page = 1, $limit = 50) {
		$offset = ($page - 1) * $limit;
		$limit_str = ' LIMIT ' . $offset . ' , ' . $limit;
		$sql = 'SELECT e.id, e.title, e.addr, e.desc, e.cost, e.sina_uid, e.nickname, e.realname, e.phone, e.start_time, e.end_time, e.pic, e.wb_id, e.join_num, e.state, e.other FROM ' . $this->db->getTable(T_EVENT_JOIN) . ' AS j LEFT JOIN ' . $this->table . ' AS e ON j.event_id = e.id WHERE j.sina_uid = "' . $uid . '" ORDER BY e.add_time DESC' . $limit_str;

		$data = $this->db->query($sql);
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$data[$i]['state_num'] = $this->getState($data[$i]);
		}
		$this->count_sql = 'SELECT COUNT(*) FROM ' . $this->db->getTable(T_EVENT_JOIN) . ' AS j LEFT JOIN ' . $this->table . ' AS e ON j.event_id = e.id WHERE j.sina_uid = "' . $uid . '"';
		return RST($data);
	}

	/**
	 * 获取我参加活动的总数
	 *
	 * @param int $uid
	 *
	 * @return array
	 */
	function getMineAttendEventsCount($uid) {
		$sql = 'SELECT COUNT(*) FROM ' . $this->db->getTable(T_EVENT_JOIN) . ' AS j LEFT JOIN ' . $this->table . ' AS e ON j.event_id = e.id WHERE j.sina_uid = "' . $uid . '"';
		return RST($this->db->getOne($sql));
	}

	/**
	 * 删除活动
	 *
	 * @params int $eid 活动id
	 * @return bool
	 */
	function deleteEvent($eid) {
		$sql = 'DELETE FROM ' . $this->table . ' WHERE id = ' . $eid;
		$ret = $this->db->execute($sql);

		if ($ret) {
			/// 删除参加该活动的数据
			$sql = 'DELETE FROM ' . $this->db->getTable(T_EVENT_JOIN) . ' WHERE event_id = "' . $eid . '"';
			$this->db->execute($sql);

			/// 清除缓存
			$this->_cleanCache();
		}
		return RST($ret);
	}

	/**
	 * 删除指定活动的指定评论
	 *
	 * @params int $eid 活动id
	 * @params int|string $wb_id 评论的微博id
	 * @return bool
	 */
	function deleteEventComment($eid, $wb_id) {
		$sql = 'DELETE FROM ' . $this->db->getTable(T_EVENT_COMMENT) . ' WHERE event_id = ' . $eid . ' AND wb_id = "' . $wb_id .'"';
		$ret = $this->db->execute($sql);

		//清除缓存
		if ($ret) {
			$this->_cleanCache();
		}
		return RST($ret);
	}

	/**
	 * 得到活动状态
	 * @param $row array 活动记录
	 * @return int 1:推荐，2进行中,3:正常,4:用户关闭,5:管理员封禁,6:已完成
	 */
	function getState($row) {
		$check_fields = array(
			'start_time', 'end_time', 'state'
		);
		foreach ($check_fields as $field) {
			if (!isset($row[$field])) {
				return false;
			}
		}
		$time = APP_LOCAL_TIMESTAMP;
		switch (true) {
			case $row['state'] == 2: return 4;// 关闭
			case $row['state'] == 3: return 5;// 封禁
			case $time > $row['end_time']: return 6;// 已完成
			case $row['state'] == 4 && $row['end_time'] > $time: return 1; // 推荐
			case $row['end_time'] > $time && $row['start_time'] < $time : return 2; //进行进
			case $row['start_time'] > $time : return 7; //未开启状态
			default: return 3; // 正常
		}
	}
	
	/**
	 * 
	 * 添加或更新活动
	 * @param array $data
	 * @param 活动id $id
	 */
	function save($data, $id = '', $id_name = 'id')
	{
		$save_result = $this->db->save($data, $id, T_EVENTS, $id_name);

		//保存成功后清除缓存
		if ($save_result) {
			$this->_cleanCache();
		}
		
		return RST($save_result);
	}

	/**
	 * 更新活动状态或推荐活动
	 *
	 * @params int $id
	 * @params string $type
	 * @params int $state
	 * @params string $id_name
	 *
	 * @return array
	 */
	function updateEvents($id, $state, $id_name = 'id')
	{
		$data = array();
		$data['state'] = $state;
		$save_result = $this->db->save($data, $id, T_EVENTS, $id_name);

		//保存成功后清除缓存
		if ($save_result) {
			$this->_cleanCache(); 
		}
		
		return RST($save_result);
	}
	
	function batchUpdateEvents($sina_uid, $state, $id_name='sina_uid'){
		$data = array();
		$data['state'] = $state;
		$save_result = $this->db->save($data, $sina_uid, T_EVENTS, $id_name);
		//保存成功后清除缓存
		if ($save_result) {
			$this->_cleanCache(); 
		}		
		return RST($save_result);		
	}

	/**
	 * 更新参加人数或评论数
	 * @params 修改的属性(join_num/comment_num) $key
	 * @params 活动id $eid
	 * 
	 * @params array
	 */
	function updateNum($key,$eid){
		$sql = 'UPDATE '.$this->table. ' SET `'.$key.'`=`'.$key.'`+1 '
				. ' WHERE id=\''.$this->db->escape($eid).'\' AND (state=1 OR state = 4)';
				
		$update_result = $this->db->execute($sql);

		//更新成功后清除缓存
		if ($update_result) {
			$this->_cleanCache();
		}
		
		return RST($update_result);
	}
	
	/**
	 * 获取活动详情
	 * @params 活动id $id
	 *
	 * @params array
	 */
	function getEventById($id)
	{		
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id = "'.$this->db->escape($id).'"';
		$data = $this->db->getRow($sql);
		$data['state_num'] = $this->getState($data);
		return RST($data);
	}
	
	/**
	 * 参加活动
	 *
	 * @params int $id 活动id
	 * @params int|string $sina_uid 参加者id
	 * @params string $contact 联系方式
	 * @params string $notes 备注
	 *
	 * @params array
	 */
	function joinEvent($id, $sina_uid, $contact = '', $notes = '')
	{
		$data = array();
		$data['sina_uid'] = $sina_uid;
		$data['event_id'] = $id;
		$data['join_time'] = APP_LOCAL_TIMESTAMP; 
		if ($contact) {
			$data['contact'] = $contact;
		}
		if ($notes) {
			$data['notes'] = $notes;
		}

		$result = $this->db->save($data, '', T_EVENT_JOIN);
		if ($this->db->getAffectedRows()) {
			/// 更新参加人数
			$this->updateNum('join_num', $id);
			
			//保存成功后清除缓存
			$this->_cleanCache();
		}
		
		return RST($result);
	}

	/**
	 * 是否已经参加了某活动
	 *
	 * @params int $event_id
	 * @params int|string $sina_uid
	 *
	 * @return array
	 */
	function isJoinEvent($event_id, $sina_uid)
	{
		if (is_array($event_id)) {
			$ids = implode(',', $event_id);
			$where = ' event_id in (' . $ids . ')';
		} else {
			$where = 'event_id = ' . $event_id;
		}

		$sql = 'SELECT event_id, sina_uid FROM ' . $this->db->getTable(T_EVENT_JOIN) . ' WHERE ' . $where . '  AND sina_uid = "' . $sina_uid . '"';
		$data = $this->db->query($sql);
		return RST($data);
	}

	/**
	 * 评论活动
	 *
	 * @params int $id 活动id
	 * @params string $content 评论的内容
	 *
	 * @params array
	 */
	function commentEvent($id, $wid, $weibo)
	{

		$data = array();
		$data['event_id'] = $id;
		$data['wb_id'] = $wid;
		$data['weibo'] = is_array($weibo) ? json_encode($weibo) : $weibo;
		$data['comment_time'] = APP_LOCAL_TIMESTAMP;

		$result = $this->db->save($data, '', T_EVENT_COMMENT);
		if ($this->db->getAffectedRows()) {
			/// 更新评论人数
			$this->updateNum('comment_num', $id);
		}
		return RST($result);
	}
	
	/**
	 * 
	 * 获取指定活动ids的活动
	 * @param 活动id $eids array
	 * @param 分页 $page
	 * @param 每页记录数 $limit
	 */
	function getListByIds($eids=array(),$limit=20)
	{
		if(empty($eids)){
			return RST(array());
		}
		
		if(is_array($eids)){
			$eidList = "'" . implode("','",$eids) . "'";			
		}else{
			$eidList = $this->db->escape($eids);
		}
		
		$time = time();
		//e_stats: 1-活动正常；2-活动未开始；3-活动已结束
		$sql = 'SELECT *,(CASE WHEN start_time>'.$time.' THEN 2 WHEN end_time<'.$time.' THEN 3 ELSE 1 END) AS e_stats FROM '.$this->table
				.' WHERE id in ('.$eidList.')'
				.' LIMIT '.$limit;
		return RST($this->db->query($sql));
		
	}
	

	/**
	 * 得到参加活动成员
	 * @param $event_id int 活动ID
	 * @param $rows int 返回的记录数
	 * @param $offset int 记录起始数
	 * @return array
	 */
	function getMembers($event_id, $rows, $offset = 0) {
		$sql = 'SELECT * FROM ' . $this->db->getTable(T_EVENT_JOIN) . ' WHERE `event_id`=' . $event_id . ' LIMIT ' . $offset . ',' . $rows;
		$members = $this->db->query($sql);
		$this->count_sql = 'SELECT count(*) FROM ' . $this->db->getTable(T_EVENT_JOIN) . ' WHERE `event_id`= "' . $event_id . '"';
		return RST($members);
	}

	/**
	 * 获取指定活动的成员总数
	 *
	 * @params int $event_id
	 * 
	 * @return array
	 */
	function getMembersCount($event_id) {
		$sql = 'SELECT count(*) FROM ' . $this->db->getTable(T_EVENT_JOIN) . ' WHERE `event_id`= "' . $event_id . '"';
		return RST($this->db->getOne($sql));
	}

	/**
	 * 获取指定活动的评论微博id列表
	 *
	 * @params int $eid
	 *
	 * @return array
	 */
	function getEventComments($eid, $page = 1, $limit = 20) {
		$offset = ($page - 1) * $limit;
		$sql = 'SELECT c.wb_id, c.weibo FROM ' . $this->db->getTable(T_EVENT_COMMENT) . ' AS c LEFT JOIN ' . $this->table . ' as e ON c.event_id = e.id WHERE c.event_id = ' . $eid . ' LIMIT ' . $offset . ', ' . $limit;
		$this->count_sql =  'SELECT count(*) FROM ' . $this->db->getTable(T_EVENT_COMMENT) . ' AS c LEFT JOIN ' . $this->table . ' as e ON c.event_id = e.id WHERE c.event_id = "' . $eid . '"';
		return RST($this->db->query($sql));
	}

	/**
	 * 复到最后一次查询的统计
	 * @return int
	 */
	function getCount($id = null) {
		if (empty($this->count_sql)) {
			return 0;
		}
		return RST($this->db->getOne($this->count_sql));
	}
	
	/**
	 * 清除缓存
	 *
	 */
	function _cleanCache()
	{
//		DD('events.eventSearch');
//		DD('events.getEventById');
		DD('events.getEventComments');
		DD('events.getListByIds');
		DD('events.getMembers');
//		DD('events.getMineAttendEvents');
		DD('events.getMembersCount');
		DD('events.getEventCount');
		DD('events.getMineAttendEventsCount');
	}

	function updateEventComment2($wb_id, $weibo)
	{
		$data = array();
		$data['weibo'] = is_array($weibo) ? json_encode($weibo) : $weibo;

		$save_result = $this->db->save($data, $wb_id, T_EVENT_COMMENT, 'wb_id');
		if ($save_result) {
			$this->_cleanCache(); //保存成功后清除缓存
		}

		return RST($save_result);
	}

	function getEventComments2($eid) {
		$sql = 'SELECT c.wb_id, c.weibo FROM ' . $this->db->getTable(T_EVENT_COMMENT) . ' AS c LEFT JOIN ' . $this->table . ' as e ON c.event_id = e.id WHERE c.event_id = ' . $eid . ' AND (c.weibo = "" || ISNULL(c.weibo))';
		return RST($this->db->query($sql));
	}
}
