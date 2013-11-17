<?php
/**
* 评论本地备份管理：管理评论本地（comment_copy）表
*
* @version $1.2: 2011/1/11 $
* @package xweibo
* @copyright (C) 2009 - 2011 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

class CommentCopy
{
	/*
	 * @define 数据库对象
	 */
	var $db;
	
	/*
	 * @define 数据表
	 */
	var $table;
	
	/**
	 * 返回统计所有微博数
	 * @return int
	 */
	function counts($type = '') {
		$sql = 'SELECT COUNT(*)AS count FROM ' . $this->db->getTable(T_COMMENT_COPY);
		if ($type === 'today') {
			$sql .= ' WHERE FROM_UNIXTIME(`dateline`,"%Y%m%d")="'. date('Ymd') . '"';
		}
		$count = $this->db->getOne($sql);
		return RST($count);
	}

	/**
	 * Brief construct
	 */
	function CommentCopy()
	{
		$this->db 	 = APP::ADP('db');
		$this->table = $this->db->getTable(T_COMMENT_COPY);
	}
	
	
	
	/**
	 * 增加评论备份
	 * 
	 * @param array $data
	 */
	function addCopy($apiData)
	{
		$data		 		= array();
		$data['cid'] 		= isset($apiData['id']) 						 ? $apiData['id'] 							: NULL;
		$data['sina_uid'] 	= isset($apiData['user']['id']) 				 ? $apiData['user']['id'] 					: NULL;
		$data['mid'] 		= isset($apiData['status']['id'])				 ? $apiData['status']['id']					: NULL;
		$data['m_uid'] 		= isset($apiData['status']['user']['id'])		 ? $apiData['status']['user']['id']			: NULL;
		$data['reply_cid'] 	= isset($apiData['reply_comment']['id'])		 ? $apiData['reply_comment']['id']			: 0;
		$data['reply_uid'] 	= isset($apiData['reply_comment']['user']['id']) ? $apiData['reply_comment']['user']['id'] 	: 0;
		$data['content'] 	= isset($apiData['text'])						 ? $apiData['text']							: NULL;
		$data['source'] 	= isset($apiData['source'])						 ? $apiData['source']						: NULL;
		$data['sina_nick'] 	= isset($apiData['user']['name'])				 ? $apiData['user']['name']					: NULL;
		$data['post_ip'] 	= $_SERVER["REMOTE_ADDR"];
		$data['dateline'] 	= APP_LOCAL_TIMESTAMP;
		
		return $this->db->boolSave($data, FALSE, T_COMMENT_COPY);
	}
	
	
	/**
	 * 删除评论备份
	 * 
	 * @param string|array $ids
	 */
	function delCopy($ids)
	{
		$ids	= is_array($ids) ? implode(',', $ids) : $ids;
		$ids	= $this->db->escape($ids);
		
		if ($ids) 
		{
			$sql = "Delete From {$this->table} Where cid in ($ids)";
			return $this->db->execute($sql);
		}
		return TRUE;
	}
	
	
	
	/**
	 * 获取所有列表
	 * @param array $params, 查询参数
	 * @param int $offset
	 * @param int $limit
	 */
	function getList($params=array(), $offset=0, $limit=10)
	{
		// Escape Var
		$offset	 = $this->db->escape($offset);
		$limit	 = $this->db->escape($limit);

		$where = $this->_buildWhere($params);
		$sql   = "Select * From {$this->table} $where Order By cid Desc Limit $offset, $limit ";
		return $this->db->query($sql);
	}
	
	
	
	/**
	 * 获取总数
	 * @param array $params 其它参数
	 */
	function getCount($params=array())
	{
		$where = $this->_buildWhere($params);
		$sql   = "Select count(*) From {$this->table} $where ";
		return $this->db->getOne($sql);
	}
	
	
	
	/**
	 * 构建where 语句
	 * @param array $params
	 */
	function _buildWhere($params)
	{
		$where = ' Where disabled=0 ';
		
		// Start Time
		if ( isset($params['startTime']) && ($startTime=$this->db->escape($params['startTime'])) )
		{
			$where .= " And dateline>='$startTime' ";
		}
		
		// End Time
		if ( isset($params['endTime']) && ($endTime=$this->db->escape($params['endTime'])) )
		{
			$where .= " And dateline<='$endTime' ";
		}
		
		// Keyword
		if ( isset($params['keyword']) && ($keyword=$this->db->escape($params['keyword'])) )
		{
			$where .= " And content Like '%$keyword%' ";
		}
		
		// ids
		if ( isset($params['ids']) && ($ids=$this->db->escape($params['ids'])))
		{
			$where .= " And cid In ($ids)";
		}
		
		return $where;
	}
	
	
	/**
	 * 屏蔽评论，设置标识为1
	 * @param $ids
	 * @param $state
	 */
	function disabled($ids, $state) 
	{
		$ids = (array)$ids;
		if ($state != 1) 
		{
			$state = 0;
		}
		
		$sql = 'UPDATE ' . $this->table . ' SET `disabled`='.$state . ' WHERE cid IN('. implode(',', $ids). ')';
		return $this->db->execute($sql);
	}
}
	
