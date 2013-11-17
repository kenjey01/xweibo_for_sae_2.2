<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 用户推荐模块
 * @author yaoying
 * @version $Id: component_3.pls.php 16917 2011-06-08 07:39:22Z jianzhou $
 *
 */
class component_3_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		parent::run($mod);
		
		//取缓存
		$isLogin   = USER::isUserLogin();
		$cacheTime = V('-:tpl/cache_time/pagelet_component3');
		$dataTime  = $isLogin ? "g/$cacheTime" : FALSE;
		$cacheKey  = $isLogin ? FALSE : "component3#".md5( serialize($mod) );
		if(ENABLE_CACHE && $cacheKey && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content; return;
		}
		
		
		$ret = DR('components/recommendUser.get', $dataTime, $mod['param']);
		
		if ($ret['errno']) {
			//$this->_error('components/recommendUser.get 返回API错误：'. $ret['err']. '('. $ret['errno']. ')');
			return;
	 	}elseif(!is_array($ret['rst'])){
			$this->_error(L('pls__component3__recommentUser__getError'));
			return;
	 	}elseif(empty($ret['rst'])){
			//$this->_error('components/recommendUser.get 无数据。');
			return;
	 	}
	 	
		$followedList = $this->_generateFollowedList($ret['rst']);
		foreach($ret['rst'] as $row){
			$row['id']=$row['uid'];
			$rs[]=$row;
		}		
		$rs = APP::F('user_filter', $rs);
		
		
		// 设置缓存
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod, 'rs'=>$rs, 'followedList'=>$followedList), false);
		if (ENABLE_CACHE && $cacheKey && $content) {
			CACHE::set($cacheKey, $content, $cacheTime);
		}
		
		echo $content; return;
	}
	
	/**
	 * 生成本组件内的用户rst数组资源内已经关注的用户数组，类型为：
	 * <pre>
	 * array((string)已关注用户id1 => 1, (string)已关注用户id2 => 1, ......);
	 * </pre>
	 * 模板内可通过以下方法判断用户是否已经关注了某用户：
	 * <pre>
	 * isset($followedList[(string)$user['id']]);
	 * array_key_exists((string)$user['id'], $followedList);
	 * </pre>
	 * @param array $rst 本组件内生成的用户rst数组资源
	 * @return array
	 */
	function _generateFollowedList($rst){
		$uid = USER::uid();
		$flw = $followedList = array();
		if ($uid) {
			$flRet = DR('xweibo/xwb.getFriendIds', 'p1', $uid, null, null, null, 2000);
			$flw = ($flRet ['errno'] == 0) ? (array)$flRet['rst'] : array();
		}
		if(empty($flw)){
			return $followedList;
		}
		
		foreach ($rst as $user) {
			if(in_array($user['uid'], $flw['ids'])){
				$followedList[(string)$user['uid']] = 1;
			}
		}
		
		return $followedList;
		
	}
	
	
}
