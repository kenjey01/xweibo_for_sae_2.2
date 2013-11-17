<?php
/**
* 在线访谈微博管理：管理在线访谈微博（interview_wb）表
*
* @version $1.2: 2011/1/11 $
* @package xweibo
* @copyright (C) 2009 - 2011 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

class InterviewWb
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
	function InterviewWb()
	{
		$this->db 	 = APP::ADP('db');
		$this->table = $this->db->getTable( T_INTERVIEW_WB );
	}
	
	
	
	/**
	 * 获取所有列表
	 * @param int $interviewId, 访谈ID
	 * @param array $params, 其它查询参数
	 * @param int $offset
	 * @param int $limit
	 * @param string $orderBy 排列类型, ASC:升序 Desc:降序
	 */
	function getList($interviewId, $params=array(), $offset=0, $limit=10, $orderBy='ask_id Desc')
	{
		// Escape Var
		$orderBy = $this->db->escape($orderBy);
		$offset	 = $this->db->escape($offset);
		$limit	 = $this->db->escape($limit);

		$where = $this->_buildWhere($interviewId, $params);
		$sql   = "Select * From {$this->table} $where Order By $orderBy Limit $offset, $limit ";
		return $this->db->query($sql);
	}
	
	
	
	/**
	 * 获取总数
	 * @param int $interviewId, 在线访谈ID
	 * @param array $params 其它参数
	 */
	function getCount( $interviewId, $params=array() )
	{
		$where = $this->_buildWhere($interviewId, $params);
		$sql   = "Select count(*) From {$this->table} $where ";
		return $this->db->getOne($sql);
	}
	
	
	/**
	 * 构建where 语句
	 * @param int $interviewId
	 * @param array $params
	 */
	function _buildWhere($interviewId, $params)
	{
		$interviewId	= $this->db->escape($interviewId);
		$where			= " Where interview_id=$interviewId ";
		
		// Sate
		if ( isset($params['state']) && ($state=$this->db->escape($params['state'])) )
		{
			$where .= " And state='$state' ";
		}
		
		// Type
		if ( isset($params['type']) && ($type=$this->_getTypeWhere($params['type'])) )
		{
			$where .= " $type ";
		}
		
		// Since Id
		if ( isset($params['since_id']) )
		{
			$where .= " And ask_id>'{$params['since_id']}' ";
		}
		
		// Max Id
		if ( isset($params['max_id']) )
		{
			$where .= " And ask_id<'{$params['max_id']}' ";
		}
		
		return $where;
	}
	
	
	
	/**
	 * 获取类型查询条件语句
	 * @param string $type ask:没有回答的，answer:已回答的, 默认所有
	 */
	function _getTypeWhere( $type )
	{
		// 类型条件
		if ( 'ask'==$type ) {
			return " And answer_wb=0 ";
		}
		
		if ( 'answer'==$type ){
			return ' And answer_wb <>0 ';
		}
		
		if ( 'allAsk'==$type ) {
			return ' And answer_wb != ask_id '; 
		}
		
		if ( 'reply'==$type ){
			return ' And answer_wb<>0 And answer_wb!=ask_id ';
		}
		
		return '';
	}
	
	
	
	/**
	 * 新增访谈微博
	 * @param array $data
	 * @param bigint $id
	 */
	function saveWb( $data, $id )
	{
		if ( !empty($data) ) 
		{
			$this->db->save($data, $id, T_INTERVIEW_WB, 'ask_id');
			return $this->db->getAffectedRows();
		}
		
		return FALSE;
	}
	
	
	
	/**
	 * 设置微博的状态,P:待审，A:审核通过
	 * 
	 * @param bigint $id
	 * @param char $state
	 */
	function setState($id, $state)
	{
		if ( $id && $state ) 
		{
			$data = array('state'=>$state);
			if ( $this->db->save($data, $id, T_INTERVIEW_WB, 'ask_id') )
			{
//				$this->_delCache();
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	
	/**
	 * 更新嘉宾回答ID
	 * @param int $interviewId
	 * @param bigint $askId
	 * @param bigint $uid
	 * @param bigint $answerId
	 */
	function updateAnswer($interviewId, $askId, $uid, $answerId, $answerWb='')
	{
		$interviewId = $this->db->escape($interviewId);
		$askId 		 = $this->db->escape($askId);
		$uid 		 = $this->db->escape($uid);
		$answerId 	 = $this->db->escape($answerId);
		$answerWb 	 = $this->db->escape($answerWb);
		
		if ($interviewId && $askId && $uid && $answerId )
		{
			$sql = "Update {$this->table} Set answer_wb=$answerId, answer_uid=$uid, answer_weibo='$answerWb', state='A' Where interview_id=$interviewId And ask_id=$askId And answer_wb=0";
			return $this->db->execute($sql);
		}
		return FALSE;
	}
		
	
	
	/**
	 * 删除 在线访谈
	 * @param int $id
	 */
	function delWb($id)
	{
		if ( $id=$this->db->escape($id) ) 
		{
			$this->db->execute("Delete From {$this->table} Where ask_id=$id Or answer_wb=$id");
			return TRUE;
		}
		return FALSE;
	}
	
	
	
	/**
	 * 删除本类的以get开头的方法的缓存
	 */
	function _delCache()
	{
		$className  = get_class($this);
		$methodList = get_class_methods($className);
		
		if ( is_array($methodList) )
		{
			foreach ( $methodList as $method )
			{
				if ( 0===strpos($method, 'get') ) {
					DD("$className.$method");
				}
			}
		}
	}
	
	
	/**
	 * 根据id获取微博内容
	 * @param $ids
	 */
	function getWeiboByIds($ids)
	{
		$ids 	= is_array($ids) ? implode(',', $ids) : $ids;
		$sql 	= "Select weibo, answer_weibo From $this->table Where ask_id In ($ids) Or answer_wb In ($ids)";
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
				
				// answered Weibo
				$tmp = json_decode($aWeibo['answer_weibo'], true);	
				if ( !empty($tmp) ) {
					$weibo[] = $tmp;
				}
			}
		}
		return $weibo;
	}
	
	
	
	/**
	 * 获取嘉宾已回答的微博
	 * @param $interviewId
	 * @param $uid
	 */
	function getGuestAnswered($interviewId, $uid, $offset=0, $limit=10)
	{
		if ( $interviewId && $uid )
		{
			$sql = $this->_buildGestAnswerdSql($interviewId, $uid);
			return $this->db->query("Select * From ($sql) As tmp Order By answer_wb Desc Limit $offset, $limit");
		}
		return array();
	}
	
	
	function _buildGestAnswerdSql($interviewId, $uid)
	{
		$interviewId 	= $this->db->escape($interviewId);
		$uid 			= $this->db->escape($uid);
		
		$atMe		= $this->db->getTable( T_INTERVIEW_WB_ATME );
		$wbTable 	= " Select ask_id, answer_wb From $this->table Where interview_id=$interviewId And state='A' And answer_wb <>0 And (answer_uid=$uid Or ask_uid=$uid) ";
		$atmeTable 	= " Select ask_id, answer_wb From $atMe Where interview_id=$interviewId And at_uid=$uid And answer_wb <>0 ";
		
		return "$wbTable Union $atmeTable";
	}
	
	
	/**
	 * 获取嘉宾已回答微博总数
	 * @param $interviewId
	 * @param $uid
	 */
	function getGuestAnsweredCnt($interviewId, $uid)
	{
		if ( $interviewId && $uid )
		{
			$sql = $this->_buildGestAnswerdSql($interviewId, $uid);
			return $this->db->getOne("Select count(*) From ($sql) As tmp");
		}
		return 0;
	}
}
	