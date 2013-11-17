<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 活动列表模块
 * @author yaoying
 * @version $Id: component_17.pls.php 10863 2011-02-28 07:11:07Z yaoying $
 *
 */
class component_18_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		parent::run($mod);
		
		//取缓存
		$cacheKey = "component18#".md5( serialize($mod) );
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content; return;
		}
		
		
		$type	 = $mod['param']['event_list_type'];
		$showNum = $mod['param']['show_num'];
		if($type==1){
			$events = DS('events.eventSearch', '', '', 8, '', false, 0, $showNum);
		}
		elseif($type==2){
			$events = DS('events.eventSearch', '', '', 1, '', false, 0, $showNum);
		}
		
		
		// 设置缓存
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod,'events'=>$events), false);
		if (ENABLE_CACHE && $content) {
			CACHE::set($cacheKey, $content, V('-:tpl/cache_time/pagelet_component18') );
		}
		
		echo $content; return;
	}
}