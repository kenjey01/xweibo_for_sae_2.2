<?php
/**
* 在线访谈微博提问管理：管理在线访谈微博的提问（interview_wb_atme）表
*
* @version $1.2: 2011/1/11 $
* @package xweibo
* @copyright (C) 2009 - 2011 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

class InterviewWbAtme
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
	function InterviewWbAtme()
	{
		$this->db 	 = APP::ADP('db');
		$this->table = $this->db->getTable( T_INTERVIEW_WB_ATME );
	}
	
	
	
	/**
	 * 获取所有列表
	 * @param int $interviewId, 访谈ID
	 * @param array $askIdList, 问题ID 列表 
	 */
	function getAnswerList($interviewId, $askIdList)
	{
		// Check Array
		if ( !is_array($askIdList) )
		{
			return FALSE;
		}
		
		// Escape Var
		$askIdStr	 = implode(',', $askIdList);
		$interviewId = $this->db->escape($interviewId);
		
		if ( $askIdStr && $interviewId )
		{
			$sql   = "Select * From {$this->table} Where interview_id=$interviewId And ask_id In ($askIdStr)";
			return $this->db->query($sql);
		}
		
		return FALSE;
	}
	
	
	
	/**
	 * 获取嘉宾未回答问题列表
	 * @param int $interviewId, 访谈ID
	 * @param bigint $uid 嘉宾UID
	 */
	function getUserAskList($interviewId, $uid, $offset=0, $limit=40, $params=array())
	{
		$interviewId = $this->db->escape($interviewId);
		$uid 		 = $this->db->escape($uid);
		$result		 = array();
		
		if ( $interviewId && $uid )
		{
			$wbTable = $this->db->getTable(T_INTERVIEW_WB);
			$askSql	 = " Select ask_id From $wbTable Where interview_id=$interviewId And state='A' ";
			$sinceId = isset($params['since_id']) ? " And ask_id>{$params['since_id']} " : '';
			$sql     = "Select * From {$this->table} Where interview_id=$interviewId And at_uid=$uid $sinceId And answer_wb=0 And ask_id In ( $askSql ) Order by ask_id Desc Limit $offset, $limit ";
			$result  = $this->db->query($sql);
		}
		
		return $result;
	}
	
	
	/**
	 * 获取嘉宾未回答问题总数
	 * @param int $interviewId, 在线访谈ID
	 * @param bigint $uid 嘉宾UID
	 */
	function getUserAskCount( $interviewId, $uid, $params=array())
	{
		$interviewId = $this->db->escape($interviewId);
		$uid 		 = $this->db->escape($uid);
		
		if ( $interviewId && $uid )
		{
			$sinceId 	= isset($params['since_id']) ? " And ask_id>{$params['since_id']} " : '';
			$sql   		= "Select count(*) From {$this->table} Where interview_id=$interviewId $sinceId And at_uid=$uid And answer_wb=0 ";
			return $this->db->getOne($sql);
		}
		return 0;
	}
	
	
	
	/**
	 * 新增访谈微博
	 * @param array $data
	 */
	function saveWb( $data )
	{
		if ( !empty($data) ) 
		{
			$id = isset($data['ask_id']) ? $data['ask_id'] : FALSE;
			$this->db->save($data, FALSE, T_INTERVIEW_WB_ATME);
			return $this->db->getAffectedRows();
		}
		
		return FALSE;
	}
	
	
	/**
	 * 更新嘉宾回答ID
	 * @param int $interviewId
	 * @param bigint $askId
	 * @param bigint $atUid
	 * @param bigint $answerId
	 */
	function updateAnswer($interviewId, $askId, $atUid, $answerId, $weibo='')
	{
		$interviewId = $this->db->escape($interviewId);
		$askId 		 = $this->db->escape($askId);
		$atUid 		 = $this->db->escape($atUid);
		$answerId 	 = $this->db->escape($answerId);
		$weibo 	 	 = $this->db->escape($weibo);
		
		if ($interviewId && $askId && $atUid && $answerId )
		{
			$sql = "Update {$this->table} Set answer_wb=$answerId, weibo='$weibo' Where interview_id=$interviewId And at_uid=$atUid And ask_id=$askId ";
			return $this->db->execute($sql);
		}
		return FALSE;
	}
	
	
	/**
	 * 删除 嘉宾回答
	 * @param int $interviewId
	 * @param bigint $askId
	 * @param bigint $atUid
	 * @param bigint $answerId
	 */
	function delAnswer($interviewId, $atUid, $answerId)
	{
		$interviewId = $this->db->escape($interviewId);
		$atUid 		 = $this->db->escape($atUid);
		$answerId 	 = $this->db->escape($answerId);
		
		if ($interviewId && $atUid && $answerId )
		{
			$sql = "Delete From {$this->table} Where interview_id=$interviewId And at_uid=$atUid And answer_wb=$answerId ";
			return $this->db->execute($sql);
		}
		return FALSE;
	}
	
	
	
	/**
	 * 根据id获取微博内容
	 * @param $ids
	 */
	function getWeiboByIds($ids)
	{
		$ids 	= is_array($ids) ? implode(',', $ids) : $ids;
		$sql 	= "Select weibo From $this->table Where answer_wb In ($ids)";
		$result = $this->db->query($sql);
		$weibo	= array();
		
		if ( is_array($result) )
		{
			foreach ($result as $aWeibo)
			{
				// weibo
				$tmp = json_decode($aWeibo['weibo'], true);	
				if ( !empty($tmp) ) {
					$weibo[] = $tmp;
				}
			}
		}
		return $weibo;
	}
}
	