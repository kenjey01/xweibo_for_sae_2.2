<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 本地关注排行榜
 * @author yaoying
 * @version $Id: component_17.pls.php 10863 2011-02-28 07:11:07Z yaoying $
 *
 */
class component_19_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		parent::run($mod);
		
		//取缓存
		$isLocal 	= defined('XWB_PARENT_RELATIONSHIP') && XWB_PARENT_RELATIONSHIP;
		$cacheKey	= "component19#$isLocal#".md5(serialize($mod));
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content; return;
		}
		
		
		//如果未登录，使用内置的token访问
		if (!USER::uid()) {
			DS('xweibo/xwb.setToken', '', 2);
		}
		
		$showNum	= $mod['param']['show_num'];
		$list		= $isLocal ? $this->_getLocalFollowTop($showNum) : $this->_getSinaFollowTop($showNum);
		
		// 设置缓存
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod,'list'=>$list), false);
		if (ENABLE_CACHE && $content) {
			CACHE::set($cacheKey, $content, V('-:tpl/cache_time/pagelet_component19') );
		}
		
		echo $content; return;
	}
	
	
	/**
	 * 后去新浪关系本地排行榜
	 * @param $showNum
	 * @param $isLocal
	 */
	function _getSinaFollowTop($showNum)
	{
		// Users Info
		$idsTmp = DR('mgr/userCom.getSinaFollowerTop', FALSE, $showNum*2);
		$ids	= array();
		if ( is_array($idsTmp) )
		{
			foreach($idsTmp as $id)
			{
				$filter	 = F('user_filter', array('id'=>$id), TRUE);
				if ( !(isset($filter['filter_state']) && in_array(2, $filter['filter_state'])) )
				{
					$ids[] = $id;
				}
			}
		}
		
		
		$batch_info = F('get_user_show', implode(',', $ids) );
		$list		= array();
		
		if( isset($batch_info['rst']) && is_array($batch_info['rst']) )
		{
			foreach($batch_info['rst'] as $row)
			{
				$id								= $row['id'];
				$list[$id]['screen_name']		= $row['screen_name'];
				$list[$id]['followers_count']	= $row['followers_count'];
				$list[$id]['sina_uid']			= $row['id'];
				
				// 更新数据库粉丝数
				DR('mgr/userCom.insertUser', FALSE, array('followers_count'=>$row['followers_count']), $id);
			}
		}
		
		$list = array_sort($list, 'followers_count', SORT_DESC);
		return array_slice($list, 0, $showNum);
	}
	
	
	/**
	 * 获取本地关系排行榜
	 * @param $showNum
	 * @param $isLocal
	 */
	function _getLocalFollowTop($showNum)
	{
		$listTmp 	= DR('UserFollow.getLocalFollowTop', FALSE, $showNum*2);
		$ids  		= array();
		$list		= array();
		
		if (isset($listTmp['rst']) && is_array($listTmp['rst']) )
		{
			$userNum = 0;
			foreach($listTmp['rst'] as $row)
			{
				$id		 = $row['friend_uid'];
				$filter	 = F('user_filter', array('id'=>$id), TRUE);
				if ( !(isset($filter['filter_state']) && in_array(2, $filter['filter_state'])) )
				{
					$ids[]							= $id;
					$list[$id]['followers_count']	= $row['count'];
					$userNum					   += 1;
					if ( $userNum>=$showNum ) { break; }
				}
			}
		}
		
		
		// Users Info
		$batch_info = F('get_user_show', implode(',', $ids) );
		if( isset($batch_info['rst']) && is_array($batch_info['rst']) )
		{
			foreach($batch_info['rst'] as $row)
			{
				$id								= $row['id'];
				$list[$id]['screen_name']		= $row['screen_name'];
				$list[$id]['sina_uid']			= $row['id'];
			}
		}
		
		return $list;
	}
	
}
