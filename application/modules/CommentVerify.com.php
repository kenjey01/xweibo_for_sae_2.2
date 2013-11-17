<?php
/**
* 先审后发时，待审评论管理：管理待审评论（comment_verify）表
*
* @version $1.2: 2011/1/11 $
* @package xweibo
* @copyright (C) 2009 - 2011 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

class CommentVerify
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
	function CommentVerify()
	{
		$this->db 	 = APP::ADP('db');
		$this->table = $this->db->getTable( T_COMMENT_VERIFY );
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
		
		// Ids
		if ( isset($params['id']) && ($id=$this->db->escape($params['id'])) )
		{
			$where .= " And id In ($id) ";
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
	
	
	
	/**
	 * 删除 待审评论
	 * @param bigint $id
	 * @param boolean $backup, 是否进入删除表
	 */
	function delComment($id, $backup=FALSE)
	{
		$id = is_array($id) ? implode(',', $id) : $id;
		$id = $this->db->escape($id);
		
		if ( $id ) 
		{
			// 备份到删除表
			if ($backup)
			{
				$curTime	= APP_LOCAL_TIMESTAMP;
				$delTable	= $this->db->getTable( T_COMMENT_DELETE );
				$sql = "Insert Into $delTable(id, sina_uid, sina_nick, mid, reply_cid, content, post_ip, dateline, add_time) 
						Select id, sina_uid, sina_nick, mid, reply_cid, content, post_ip, dateline, $curTime From {$this->table} Where id In($id) ";
				$this->db->execute($sql);
			}
			
			// 待审表删除
			$this->db->execute("Delete From {$this->table} Where id=$id");
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * 根据用户ID删除评论
	 *
	 */
	function delCommentByUid($uid) {
		return $this->db->delete($uid, T_COMMENT_VERIFY, 'sina_uid');
	}
}
	
