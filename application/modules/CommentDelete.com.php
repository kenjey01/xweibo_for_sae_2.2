<?php
/**
* 先审后发时，删除评论管理：管理删除的评论（comment_delete）表
*
* @version $1.2: 2011/1/11 $
* @package xweibo
* @copyright (C) 2009 - 2011 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

class CommentDelete
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
	 * Brief construct
	 */
	function CommentDelete()
	{
		$this->db 	 = APP::ADP('db');
		$this->table = $this->db->getTable( T_COMMENT_DELETE );
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
		$sql   = "Select * From {$this->table} $where Order By id Desc Limit $offset, $limit ";
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
		$where = ' Where 1=1 ';
		
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
		
		return $where;
	}
	
	
	
	/**
	 * 新增待审评论
	 * @param array $data
	 */
	function addComment( $data )
	{
		if ( !empty($data) ) 
		{
			$this->db->save($data, FALSE, T_COMMENT_VERIFY);
			return $this->db->getAffectedRows();
		}
		
		return FALSE;
	}
}
	