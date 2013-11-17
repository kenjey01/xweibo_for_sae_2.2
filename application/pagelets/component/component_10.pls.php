<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 今日话题模块
 * @author yaoying
 * @version $Id: component_10.pls.php 16828 2011-06-07 00:57:23Z jianzhou $
 *
 */
class component_10_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		parent::run($mod);
		
		//取缓存
		$isLogin   = USER::isUserLogin();
		$cacheKey  = $isLogin ? FALSE : "component10#".md5( serialize($mod) ) ;
		$wbListKey = "$cacheKey#wbList";
		if(ENABLE_CACHE && $cacheKey && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content;
		    return array('cls'=>'wblist', 'list'=>CACHE::get($wbListKey) );
		}
		
		
		$kw 		= $mod['param']['topic'];
		$source 	= $mod['param']['source'];
		$show_num 	= $mod['param']['show_num'];
		if ( USER::isUserLogin() ) {
			$list = DR('xweibo/xwb.searchStatuse', null, array('base_app' => $source, 'q' => $kw, 'rpp' => $show_num, 'page' => 1));
		} else {
			$list = DR('xweibo/xwb.searchStatuse', null, array('base_app' => $source, 'q' => $kw, 'rpp' => $show_num, 'page' => 1), false);
		}
		
		//结果集处理:　只要show_num条内容
		if ($list['errno'] == 0) {
			if ( count($list['rst']) > $show_num ) {
				$list['rst'] = array_slice($list['rst'], 0, $show_num);
			}

			$errno = 0;
			$err = '';
		} else {
			$errno = $list['errno'];
			$err = $list['err'];
		}

		$today = array(
			'errno' => $errno,
			'err' => $err,
			'keyword' => $mod['param']['topic'],
			'data' => $list
		);
		
		$followedList = $this->_generateFollowedList($today['data']['rst']);
		
		
		// 设置缓存
		$wbList  = F('format_weibo', $today['data']['rst']);
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod, 'today'=>$today, 'followedList'=>$followedList), false);
		if (ENABLE_CACHE && $cacheKey && $content) 
		{
			$cacheTime = V('-:tpl/cache_time/pagelet_component10');
			CACHE::set($cacheKey, $content,  $cacheTime);
			CACHE::set($wbListKey, $wbList, $cacheTime);
		}
		
		echo $content;
		return array('cls'=>'wblist', 'list'=>$wbList);
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
			$flRet = DR ( 'xweibo/xwb.getFriendIds', 'p1', $uid, null, null, null, 5000 );
			$flw = ($flRet ['errno'] == 0) ? (array)$flRet['rst'] : array();
		}
		if(empty($flw)){
			return $followedList;
		}
		
		foreach($rst as $tp){
			if(in_array($tp['user']['id'], $flw['ids'])){
				$followedList[(string)$tp['user']['id']] = 1;
			}
		}
		
		return $followedList;
		
	}
	
	
}
