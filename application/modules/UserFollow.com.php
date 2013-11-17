<?php
/**
* 用户关系管理：管理用户关系（user_follow）表
*
* @version $1.2: 2011/1/11 $
* @package xweibo
* @copyright (C) 2009 - 2011 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

class UserFollow
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
	function UserFollow()
	{
		$this->db 	 = APP::ADP('db');
		$this->table = $this->db->getTable( $this->_getDefineTable() );
		$this->localtable = $this->db->getTable( T_USER_FOLLOW_COPY );
	}
	
	
	/**
	 * 获取用户关系本地备份的Define 表
	 */
	function _getDefineTable()
	{
		return XWB_PARENT_RELATIONSHIP ? T_USER_FOLLOW : T_USER_FOLLOW_COPY;
	}
	
	
	/**
	 * 获取用户的所有关注列表
	 * 
	 * @param bigint $sinaUid
	 * @param int $offset
	 * @param int $limit
	 */
	function getFriendList($sinaUid, $offset, $limit)
	{
		$uid	= $this->db->escape($sinaUid);
		$offset	= $this->db->escape($offset);
		$limit	= $this->db->escape($limit);
		
		$sql 	= "Select friend_uid From {$this->table} Where fans_uid=$uid Order By datetime Desc Limit $offset, $limit";
		$tmpAry = $this->db->query($sql);
		$uList	= array();
		
		if ( is_array($tmpAry) )
		{
			foreach ( $tmpAry as $aRow )
			{
				array_push($uList, $aRow['friend_uid']);
			}
		}
		return $uList;
	}
	
	
	/**
	 * 获取用户关注数
	 * 
	 * @param bigint $sinaUid
	 */
	function getFriendCount($sinaUid)
	{
		$uid	= $this->db->escape($sinaUid);
		$sql 	= "Select count(*) From {$this->table} Where fans_uid=$uid";
		return $this->db->getOne($sql);
	}
		
	
	/**
	 * 获取用户的粉丝列表
	 * 
	 * @param bigint $sinaUid
	 * @param int $offset
	 * @param int $limit
	 */
	function getFollowList($sinaUid, $offset, $limit)
	{
		$uid	= $this->db->escape($sinaUid);
		$offset	= $this->db->escape($offset);
		$limit	= $this->db->escape($limit);
		
		$sql 	= "Select fans_uid From {$this->table} Where friend_uid=$uid Order By datetime Desc Limit $offset, $limit";
		$tmpAry = $this->db->query($sql);
		$fList	= array();
		
		if ( is_array($tmpAry) )
		{
			foreach ( $tmpAry as $aRow )
			{
				array_push($fList, $aRow['fans_uid']);
			}
		}
		return $fList;
	}
	
	
	/**
	 * 获取用户粉丝数
	 * 
	 * @param bigint $sinaUid
	 */
	function getFollowCount($sinaUid)
	{
		$uid	= $this->db->escape($sinaUid);
		$sql 	= "Select count(*) From {$this->table} Where friend_uid=$uid";
		return $this->db->getOne($sql);
	}

	
	
	/**
	 * 增加用户关注关系
	 * 
	 * @param bigint $sinaUid
	 * @param bigint $followUid
	 */
	function addFollow($sinaUid, $followUid)
	{
		if ( $sinaUid && $followUid )
		{
			$data = array('friend_uid'=>$sinaUid, 'fans_uid'=>$followUid, 'datetime'=>APP_LOCAL_TIMESTAMP);
			$this->db->boolSave($data, FALSE, $this->_getDefineTable() );
			
			if ( $this->db->getAffectedRows() ) 
			{
				$this->_delCache();
				return TRUE;
			}
		}
		return FALSE;		
	}
	
	
	/**
	 * 批量增加用户关注关系
	 * 
	 * @param bigint $sinaUid
	 * @param array $fanUidList
	 */
	function addFollowBatch($sinaUid, $fanUidList)
	{
		if ( $sinaUid && is_array($fanUidList) && !empty($fanUidList) )
		{
			$dateTime 	= APP_LOCAL_TIMESTAMP;
			$values		= array();
			$fields		= '(friend_uid, fans_uid, datetime)';
			
			foreach ($fanUidList as $aFanUid) {
				$values[] = "($aFanUid, $sinaUid, '$dateTime')";
			}
			
			
			if ( $valueStr=implode(',', $values) ) 
			{
				$this->db->execute("Insert Into {$this->table} $fields values $valueStr");
				
				if ( $this->db->getAffectedRows() ) 
				{
					$this->_delCache();
					return TRUE;
				}
			}
		}
		return FALSE;		
	}
	
	
	/**
	 * 删除用户关注关系
	 * 
	 * @param bigint $sinaUid
	 * @param bigint $followUid
	 */
	function delFollow($sinaUid, $followUid)
	{
		$uid	= $this->db->escape($sinaUid);
		$fid	= $this->db->escape($followUid);
		
		if ($uid && $fid) 
		{
			$sql = "Delete From {$this->table} Where friend_uid=$uid && fans_uid=$fid";
			if ( $this->db->execute($sql) ) 
			{
				// 删除成功后清缓存
				$this->_delCache();
				return TRUE;
			}
		}
		return TRUE;
	}
	
	
	/**
	 * 某用户的所有关注
	 * 
	 * @param bigint $fansUid
	 */
	function delAllFriend($fansUid)
	{
		if ( $fansId = $this->db->escape($fansUid) ) 
		{
			$sql = "Delete From {$this->table} Where fans_uid=$fansId";
			if ( $this->db->execute($sql) ) 
			{
				// 删除成功后清缓存
				$this->_delCache();
				return TRUE;
			}
		}
		return TRUE;
	}
	
	
	/**
	 * 判断sinaUid 是否followerId的关注用户
	 * 
	 * @param bigint $sinaUid
	 * @param bigint $fansUid
	 */
	function isFriendShip($sinaUid, $fansUid)
	{
		$uid	= $this->db->escape($sinaUid);
		$fid	= $this->db->escape($fansUid);
		
		return (bool)$this->db->getOne("Select count(*) From {$this->table} Where friend_uid=$uid And fans_uid=$fid");
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
	  *  获取本地关注榜 
	  */
	function getLocalFollowTop($showNum){
		$showNum=$this->db->escape($showNum);
		$usersTable=$this->db->getTable( T_USERS );
		$userActionTable=$this->db->getTable( T_USER_ACTION );
		return RST($this->db->query(sprintf("select friend_uid,count(fans_uid) as count  from %s join (select U.sina_uid from %s U where U.sina_uid not in (select sina_uid from %s where action_type=3 or action_type=2 union select 0) ) W on friend_uid=sina_uid group by friend_uid order by count desc limit 0,%s;",$this->table,$usersTable,$userActionTable,$showNum)));
	}
	
	
	
	
}
	