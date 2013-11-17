<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 当前站点最新微博模块
 * @author yaoying
 * @version $Id: component_14.pls.php 17002 2011-06-10 00:40:41Z heli $
 *
 */
class component_14_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		parent::run($mod);
		
		//取缓存
		$cacheKey  = "component14#".md5( serialize($mod) );
		$wbListKey = "$cacheKey#wbList";
		$cacheTime = V('-:tpl/cache_time/pagelet_component14');
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content;
		    return array('cls'=>'wblist', 'list'=>CACHE::get($wbListKey) );
		}
		
		
		$ret = DR('components/pubTimelineBaseApp.get', '', $mod['param']);
		
		if ($ret['errno']) {
			$this->_error(L('pls__component14__pubTimeline__apiError', $ret['err'], $ret['errno']));
			//$this->_error('components/pubTimelineBaseApp.get返回API错误：'. $ret['err']. '('. $ret['errno']. ')');
			return;
		//如果数据为空，则不输出
	 	}/*elseif(empty($ret['rst'])){
	 		$this->_error('components/pubTimelineBaseApp.get没有数据');
	 		return;
	 	}elseif(!is_array($ret['rst'])){
	 		$this->_error('components/pubTimelineBaseApp.get返回错误的非数组数据类型或者没有数据');
	 		return;
	 	}*/
		
	 	$show_num	= isset($mod['param']['show_num']) ? (int)$mod['param']['show_num'] : 20;
	 	
	 	$wbList = array();
	 	if (is_array($ret['rst'])) {
			foreach ($ret['rst'] as $k => $wb) {
				if (isset($wb['text'])) {
					$wbList[] = $wb;
				}
			}
	 	}
	 	
	 	if(count($wbList) > $show_num){
	 		$wbList = array_slice($wbList, 0, $show_num);
	 	}
	 	
		
		// 设置缓存
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod, 'list'=>$wbList), false);
		$wbList  = F('format_weibo', $wbList);
		if (ENABLE_CACHE && $content) 
		{
			CACHE::set($cacheKey, $content, $cacheTime);
			CACHE::set($wbListKey, $wbList, $cacheTime);
		}
		
		echo $content;
		return array('cls'=>'wblist', 'list'=>$wbList );
	}	
}
