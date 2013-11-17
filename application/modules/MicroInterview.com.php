<?php
/**
* 在线访谈管理：管理在线访谈（micro_interview）表
*
* @version $1.2: 2011/1/11 $
* @package xweibo
* @copyright (C) 2009 - 2011 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

class MicroInterview
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
	 * @var 删除状态
	 */
	var $delState = 'X';
	
	/**
	 * @var 主持人/嘉宾 的缓存组
	 */
	var $UserInfo_CacheKey = 'Interview_Master_Guest';
	
	/**
	 * @var 已缓存的主持人/嘉宾的用户信息
	 */
	var $cacheUserList = array();
	
	
	/**
	 * @var 没有缓存的uid
	 */
	var $unCacheUidList = array();
	
	
	
	/**
	 * Brief construct
	 */
	function MicroInterview()
	{
		$this->db 	 = APP::ADP('db');
		$this->table = $this->db->getTable( T_MICRO_INTERVIEW );
	}
	
	
	
	/**
	 * 获取所有列表
	 * @param int $offset
	 * @param int $limit
	 */
	function getList($offset, $limit)
	{
		$offset	= $this->db->escape($offset);
		$limit	= $this->db->escape($limit);
		$sql 	= "Select * From {$this->table} Where state!='{$this->delState}' Order By start_time Desc Limit $offset, $limit";
		$result	= $this->db->query($sql);
		$master	= array();
		$guest	= array();
		
		if ( is_array($result) )
		{
			foreach ($result as $key=>$aRecord)
			{
				$id								= $aRecord['id'];
				$master[$id]	  				= $this->_filterUser($id, json_decode($aRecord['master'], TRUE), 'master');
				$guest[$id]	  					= $this->_filterUser($id, json_decode($aRecord['guest'], TRUE), 'guest');
				$result[$key]['status'] 		= $this->_getStatus($aRecord['start_time'], $aRecord['end_time']);
				$result[$key]['dateFormat'] 	= $this->_getTimeFormat($aRecord['start_time'], $aRecord['end_time']);
				$result[$key]['notice']			= (APP_LOCAL_TIMESTAMP+$aRecord['notice_time'] < $aRecord['start_time']) ? ($aRecord['start_time']-$aRecord['notice_time']) : NULL;
			}
			// Api UserInfo
			$apiUserList = $this->_getUserBatchShow( $this->unCacheUidList );
			
			// Get The Master And Guest UserInfo
			foreach ($result as $key=>$aRecord)
			{
				$id						= $aRecord['id'];
				$result[$key]['master']	= $this->_getUserInfo($id, $master[$id], $apiUserList, 'master');
				$result[$key]['guest']	= $this->_getUserInfo($id, $guest[$id], $apiUserList, 'guest');
			}
		}
		return $result;
	}
	
	
	
	/**
	 * 获取总数
	 */
	function getCount()
	{
		$sql = "Select count(*) From {$this->table} Where state!='{$this->delState}'";
		return $this->db->getOne($sql);
	}
	
	
	
	/**
	 * 根据ID获取
	 * @param int $id
	 */
	function getById($id)
	{
		$result = array();
		if ( $id )
		{
			$result = $this->db->get($id, T_MICRO_INTERVIEW);
			if ( !empty($result) )
			{
				$masterUidList	  	= $this->_filterUser($id, json_decode($result['master'], TRUE), 'master');
				$guestUidList	  	= $this->_filterUser($id, json_decode($result['guest'], TRUE), 'guest');
				$apiUserList		= $this->_getUserBatchShow( $this->unCacheUidList );
				
				$result['master'] 		= $this->_getUserInfo($id, $masterUidList, $apiUserList, 'master');
				$result['guest']  		= $this->_getUserInfo($id, $guestUidList, $apiUserList, 'guest');
				$result['status'] 		= $this->_getStatus($result['start_time'], $result['end_time']);
				$result['dateFormat'] 	= $this->_getTimeFormat($result['start_time'], $result['end_time']);
				$result['notice'] 		= (APP_LOCAL_TIMESTAMP+$result['notice_time'] < $result['start_time']) ? ($result['start_time']-$result['notice_time'])  : NULL;
			}
		}
		return $result;
	}
	
	
	/**
	 * 获取在线访谈的主持人或嘉宾的用户信息
	 * @param int $interviewId
	 * @param array $idList
	 * @param string $group
	 */
	function _getUserInfo($interviewId, $idList, $apiUser, $group)
	{
		// Check Params
		if ( empty($interviewId) || !is_array($idList) )
		{
			return array();
		}
		
		
		// Get From Api And Cache The Result
		$result = isset($this->cacheUserList[$interviewId][$group]) ? $this->cacheUserList[$interviewId][$group] : array();
		
		// Build userinfo And Cache
		if ( is_array($apiUser) )
		{
			foreach ($apiUser as $aUser)
			{
				$id								= $aUser['id'];
				$dataTmp['id'] 					= $id;
				$dataTmp['screen_name'] 		= $aUser['screen_name'];
				$dataTmp['profile_image_url'] 	= $aUser['profile_image_url'];
				$dataTmp['description']			= $aUser['description'];
				$dataTmp['verified']			= $aUser['verified'];
				
				// 缓存6个小时
				CACHE::gSet($this->UserInfo_CacheKey, $id, $dataTmp, 6*3600);
				
				if ( isset($idList[$id]) )
				{
					$result[$id] = $dataTmp;
				}
			}
		}
		return $result;
	}
	
	
	/**
	 * 批量获取用户信息
	 */
	function _getUserBatchShow($idList)
	{
		$count 	= count($idList);
		$result	= array();
		
		if ( $count>0 ) 
		{
			//批量获取, 目前最多支持20个人,超过20个人, 分组调用批量接口
			if ( !USER::isUserLogin() ){ DS('xweibo/xwb.setToken', '', 2); }
			if ( $count>20) 
			{
				$pageCnt = ceil($count/20);
		
				for ($p=1; $p <=$pageCnt; $p++) 
				{
					$offset 	= ($p-1) * 20;
					$tmpList 	= array_slice($idList, $offset, 20);
					$rspTmp 	= DR('xweibo/xwb.getUsersBatchShow', FALSE, implode(',', $tmpList) );
					if ( $rspTmp['errno'] ) {
						continue;
					}
					$result = array_merge($result, $rspTmp['rst']);
				}
			} 
			else 
			{
				$rspTmp = DR('xweibo/xwb.getUsersBatchShow', FALSE, implode(',', $idList) );
				$result = $rspTmp['rst'];
			}
		} 

		return $result;
	}
		
	
	
	/**
	 * 过滤用户为：已缓存的、未缓存的
	 * @param int $interviewId
	 * @param array $idList
	 * @param string $group
	 */
	function _filterUser($interviewId, $idList, $group)
	{
		// 保存没有缓存的uid数组
		$unCacheUidList = array();
		
		if ( $interviewId && is_array($idList) )
		{
			foreach ($idList as $id)
			{
				// 获取缓存的用户信息
				if ( $data=CACHE::gGet($this->UserInfo_CacheKey, $id) )
				{
					$this->cacheUserList[$interviewId][$group][$id] = $data;
				}
				else 	// 没有找到缓存的uid
				{
					$this->unCacheUidList[$id]  = $id;
					$unCacheUidList[$id]		= $id;
				}
			}
		}
		
		return $unCacheUidList;
	}
	
	
	
	/**
	 * 获取记录的状态, P:未开始, I:进行中, E:已结束
	 * @param bigint $startTime
	 * @param bigint $endTime
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
	 * 获取时间显示格式，同年格式为‘m月d日 H:i’，跨年格式为‘Y年m月d日 H:i’
	 * @param bigint $startTime
	 * @param bigint $endTime
	 */
	function _getTimeFormat($startTime, $endTime)
	{
		if ( date('Y', $startTime) == date('Y', $endTime) ) 
		{
			return 'm月d日 H:i';
		}
		
		return 'Y年m月d日 H:i';
	}
	
	
	/**
	 * 删除 在线访谈，设置state为‘X’
	 * @param int $id
	 */
	function delInterview($id)
	{
		if ( $id && ($this->db->save(array('state'=>$this->delState), $id, T_MICRO_INTERVIEW)) ) 
		{
			$this->_delCache();
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 
	 * 添加或更新在线访谈
	 * @param array $data
	 * @param 在线直播id $id
	 */
	function save($data, $id='', $id_name='id')
	{
		$save_result = $this->db->save($data, $id, T_MICRO_INTERVIEW, $id_name);
		if ($save_result) {
			$this->_delCache(); //保存成功后清除缓存
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
		if ( $id && $wbState ) 
		{
			$data = array( 'wb_state'=>$wbState );
			if ( $this->db->save($data, $id, T_MICRO_INTERVIEW) )
			{
				$this->_delCache();
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	
	
	/**
	 * 返回微博策略是否先审后发
	 * 
	 * @param int $id
	 */
	function getWbState($id)
	{
		if ($id && ($aRecord=$this->db->get($id, T_MICRO_INTERVIEW)) )
		{
			return $aRecord['wb_state'];
		}
		
		return 'P';
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
	
}
	