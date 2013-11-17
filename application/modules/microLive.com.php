<?php
/**************************************************
*  Created:  2011-04-06
*
*  在线直播相关数据操作模型
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author heli1 <heli1@staff.sina.com.cn>
*
***************************************************/

class microLive 
{
	var $db;
	var $count_sql;
	
	/**
	 * @var 删除状态
	 */
	var $delState = 'X';

	var $cache = 'g0/21600';

	function microLive()
	{
		$this->db = APP::ADP('db');
	}
	
	/**
	 * 获取所有在线直播列表
	 * @param int $offset
	 * @param int $limit
	 *
	 * @return array
	 */
	function getList($offset, $limit)
	{
		$offset	= $this->db->escape($offset);
		$limit	= $this->db->escape($limit);
		$sql 	= 'Select * From ' . $this->db->getTable(T_MICRO_LIVE) . ' Where state!= "' . $this->delState . '" Order By id Desc Limit '. $offset . ',' . $limit;
		$result	= $this->db->query($sql);
		
		if ( is_array($result) )
		{
			foreach ($result as $key=>$aRecord)
			{
				$result[$key]['status'] = $this->_getStatus($aRecord['start_time'], $aRecord['end_time']);
			}
		}
		$this->count_sql = 'SELECT COUNT(*) FROM ' . $this->db->getTable(T_MICRO_LIVE). ' WHERE state != "X"';
		return $result;
	}

	/**
	 * 获取在线直播的总数
	 */
	function getLiveCount()
	{
		$sql = 'Select count(*) From ' . $this->db->getTable(T_MICRO_LIVE) . ' Where state!= "' . $this->delState . '"';
		return $this->db->getOne($sql);
	}

	/**
	 * 获取在线直播列表
	 *
	 * @params array
	 */
	function getLiveList($page, $limit = 20, $where = false)
	{		
		if ($where) {
			$where = ' WHERE state != "' . $this->delState . '" AND ' . $where;
		} else {
			$where = ' WHERE state != "' . $this->delState . '"';
		}
		$offset = ($page - 1) * $limit;
		$sql = 'SELECT * FROM ' . $this->db->getTable(T_MICRO_LIVE). ' ' . $where .' ORDER BY start_time DESC LIMIT ' . $offset . ', '. $limit;
		$data = $this->db->query($sql);
		for ($i=0, $count=count($data); $i<$count; $i++) {
			//$data[$i]['state_num'] = $this->getState($data[$i]);
			$data[$i]['state'] = $this->_getStatus($data[$i]['start_time'], $data[$i]['end_time']);
		}
		$this->count_sql = 'SELECT COUNT(*) FROM ' . $this->db->getTable(T_MICRO_LIVE). ' WHERE state != "X"';
		return RST($data);
	}

	/**
	 * 
	 * 添加或更新在线直播
	 * @param array $data
	 * @param 在线直播id $id
	 */
	function save($data, $id = '', $id_name = 'id')
	{
		$save_result = $this->db->save($data, $id, T_MICRO_LIVE, $id_name);
		if ($save_result) {
			$this->_cleanCache(); //保存成功后清除缓存
		}
		
		return RST($save_result);
	}

	/**
	 * 设置在线访谈的微博策略，P:先审后发，A:直接发布
	 * @param int $id
	 * @param char $wbState
	 */
	function setWbState($id, $wbState)
	{
		$data = array( 'wb_state'=> $wbState );
		$save_result = $this->db->save($data, $id, T_MICRO_LIVE);
		if ($save_result) {
			$this->_cleanCache(); //保存成功后清除缓存
		}
		
		return RST($save_result);
	}

	/**
	 * 删除指定的在线直播
	 *
	 * @params int $id 在线直播id
	 * @return bool
	 */
	function deleteLive($id, $id_name = 'id') {
		$data = array();
		$data['state'] = $this->delState;
		$save_result = $this->db->save($data, $id, T_MICRO_LIVE, $id_name);
		if ($save_result) {
			$this->_cleanCache(); //保存成功后清除缓存
		}
		
		return RST($save_result);
	}

	/**
	 * 删除指定在线直播的微博
	 *
	 * @params int $id 在线直播id
	 * @params int|string $wb_id 微博id
	 *
	 * @return bool
	 */
	function deleteLiveWb($id, $wb_id) {
		$sql = 'DELETE FROM ' . $this->db->getTable(T_MICRO_LIVE_WB) . ' WHERE live_id = ' . $id . ' AND wb_id = "' . $wb_id .'"';
		$ret = $this->db->execute($sql);
		if ($ret) {
			$this->_cleanCache(); //保存成功后清除缓存
		}
		return RST($ret);
	}

	/**
	 * 审核指定在线直播的指定微博
	 *
	 * @param int $id
	 * @param int|string $wb_id
	 * @param int $state
	 *
	 * @return array
	 */
	function approveWb($id, $wb_id, $state = 1) {
		$sql = 'UPDATE ' . $this->db->getTable(T_MICRO_LIVE_WB) . ' SET state = ' . $state . ' WHERE live_id = ' . $id . ' AND wb_id = "' . $wb_id .'"';
		$ret = $this->db->execute($sql);
		if ($ret) {
			$this->_cleanCache(); //保存成功后清除缓存
		}
		return RST($ret);
	}
	
	/**
	 * 更新指定在线直播状态
	 *
	 * @params int $id
	 * @params string $type
	 * @params int $state
	 * @params string $id_name
	 *
	 * @return array
	 */
	function updateLive($id, $wb_state, $id_name = 'id')
	{
		$data = array();
		$data['wb_state'] = $wb_state;
		$save_result = $this->db->save($data, $id, T_MICRO_LIVE, $id_name);
		if ($save_result) {
			$this->_cleanCache(); //保存成功后清除缓存
		}
		
		return RST($save_result);
	}
	
	/**
	 * 获取指定在线直播的详情
	 * @params 在线直播id $id
	 *
	 * @params array
	 */
	function getLiveById($id)
	{		
		$sql = 'SELECT * FROM ' . $this->db->getTable(T_MICRO_LIVE). ' WHERE id = "'.$this->db->escape($id).'"';
		$data = $this->db->getRow($sql);
		if (!isset($data['start_time']) || !isset($data['end_time'])) {
			return RST(false);
		}
		$data['state'] = $this->_getStatus($data['start_time'], $data['end_time']);
		return RST($data);
	}

	/**
	 * 发布在线直播微博
	 *
	 * @params int $live_id 在线直播id
	 * @params string $wb_id 微博id 
	 *
	 * @params array
	 */
	function updateMicroLive($live_id, $wb_id, $type, $state, $weibo)
	{
		$data = array();
		$data['live_id'] = $live_id;
		$data['wb_id'] = $wb_id;
		$data['weibo'] = is_array($weibo) ? json_encode($weibo) : $weibo;
		$data['type'] = $type;
		$data['state'] = $state;
		$data['add_time'] = APP_LOCAL_TIMESTAMP;

		$save_result = $this->db->save($data, '', T_MICRO_LIVE_WB);
		if ($save_result) {
			$this->_cleanCache(); //保存成功后清除缓存
		}

		return RST($save_result);
	}

	/**
	 * 获取指定在线直播的微博id列表
	 *
	 * @param int $id
	 * @param int $state 状态
	 *
	 * @return array
	 */
	function getMicroLiveWbs($id, $state = null, $page = 1, $limit = 20, $last_wb_id = false, $params=array()) {
		$where = ' WHERE live_id = ' .$id;
		if ($state) {
			$where .= ' AND state = ' . $state;
		}
		if ($last_wb_id) {
			$where .= ' AND wb_id > "' . $last_wb_id . '"';
		}
		
		if ( isset($params['gMtype']) ) {
			$where .= " And type In (2, 3) ";
		}
		
		$offset = ($page - 1) * $limit;
		$sql = 'SELECT wb_id, weibo, type, state FROM ' . $this->db->getTable(T_MICRO_LIVE_WB) . $where . ' ORDER BY add_time DESC LIMIT ' . $offset . ', ' . $limit;
		$this->count_sql = 'SELECT COUNT(*) FROM ' . $this->db->getTable(T_MICRO_LIVE_WB) . $where . ' ORDER BY add_time DESC';
		return RST($this->db->query($sql));
	}

	/**
	 * 获取指定在线直播的微博总数
	 * @param int $id, 在线直播ID
	 * @param int $state 微博的状态
	 *
	 * @return array
	 */
	function getWbCount($id, $state, $params) 
	{
		$where 	= ' WHERE live_id = ' . $this->db->escape($id) .' AND state = ' . $state;	
		if ( isset($params['gMtype']) ) {
			$where .= " And type In (2, 3) ";
		}
		
		$sql 	= 'SELECT COUNT(*) FROM ' . $this->db->getTable(T_MICRO_LIVE_WB) . $where; 
		return RST($this->db->getOne($sql));
	}

	/**
	 * 复到最后一次查询的统计
	 *
	 * @return array 
	 */
	function getCount($id = null) {
		if (empty($this->count_sql)) {
			return 0;
		}
		return RST($this->db->getOne($this->count_sql));
	}

	/**
	 * 批量获取主持人，嘉宾信息
	 *
	 *
	 */
	function getLiveUsersBatchShow($ids) {
		return F('get_user_show', $ids, $this->cache);
	}
	
	/**
	 * 获取记录的状态, P:未开始, I:进行中, E:已结束
	 * @param int $startTime
	 * @param int $endTime
	 *
	 * @return string
	 */
	function _getStatus($startTime, $endTime)
	{
		// 未开始
		if ( $startTime>APP_LOCAL_TIMESTAMP ) {
			return 'P';
		}
		
		// 已结束
		if ( $endTime<APP_LOCAL_TIMESTAMP ) {
			return 'E';
		}
		
		// 进行中
		return 'I';
	}

	/**
	 * 清除缓存
	 */
	function _cleanCache()
	{
		DD('microLive.getList');
		DD('microLive.getLiveList');
		DD('microLive.getLiveById');
		DD('microLive.getMicroLiveWbs');
		DD('microLive.getCount');
		DD('microLive.getLiveCount');
		DD('microLive.getWbCount');
	}

	function updateMicroLive2($wb_id, $weibo)
	{
		$data = array();
		$data['weibo'] = is_array($weibo) ? json_encode($weibo) : $weibo;

		$save_result = $this->db->save($data, $wb_id, T_MICRO_LIVE_WB, 'wb_id');
		if ($save_result) {
			$this->_cleanCache(); //保存成功后清除缓存
		}

		return RST($save_result);
	}

	function getMicroLiveWbs2($id, $state = null) {
		$where = ' WHERE live_id = ' .$id;
		if ($state) {
			$where .= ' AND state = ' . $state;
		}

		$where .= " AND (weibo = '' || ISNULL(weibo))";
		
		$sql = 'SELECT wb_id, weibo, type, state FROM ' . $this->db->getTable(T_MICRO_LIVE_WB) . $where . ' ORDER BY add_time DESC';
		return RST($this->db->query($sql));
	}
}
