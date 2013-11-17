<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 人气关注榜模块
 * @author yaoying
 * @version $Id: component_4.pls.php 16917 2011-06-08 07:39:22Z jianzhou $
 *
 */
class component_4_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		parent::run($mod);
		
		//取缓存
		$cacheKey = "component4#".md5( serialize($mod) );
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content; return;
		}
		
		
		$rs = DS('components/concern.get', 300);
		if (empty($rs) || !is_array($rs)) {
			$this->_error(L('pls__component4__concern__getError'));
			return;
	 	}
	 	
	 	
	 	// 设置缓存
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod, 'rs'=>$rs), false);
		if (ENABLE_CACHE && $content) {
			CACHE::set($cacheKey, $content, V('-:tpl/cache_time/pagelet_component4') );
		}
		
		echo $content; return;
	}
	
}
