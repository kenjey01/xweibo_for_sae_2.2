<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 话题微博模块
 * @author yaoying
 * @version $Id: component_12.pls.php 16828 2011-06-07 00:57:23Z jianzhou $
 *
 */
class component_12_pls extends component_abstract_pls
{
	
	function run($mod)
	{
		$mod['param']['page_type'] 	= isset($mod['param']['page_type']) && ($mod['param']['page_type'] != 0) ? 1 : 0;
		$mod['param']['page'] 		= ($mod['param']['page_type'] == 1) ? (int)V('g:page', 1) : 1;
		$mod['param']['source']	  	= isset($mod['param']['source']) 	? $mod['param']['source'] : 0;
		$mod['param']['show_num'] 	= isset($mod['param']['show_num']) 	? (int)$mod['param']['show_num'] : 15;
		
		parent::run($mod);
		
		//取缓存
		$cacheKey  = "component12#".md5( serialize($mod) );
		$wbListKey = "$cacheKey#wbList";
		$cacheTime = V('-:tpl/cache_time/pagelet_component12');
		if(ENABLE_CACHE && ($content=CACHE::get($cacheKey)) ) 
		{
		    echo $content;
		    return array('cls'=>'wblist', 'list'=>CACHE::get($wbListKey) );
		}
		
		
		$rs = DR('components/todayTopic.getTopicWB', '', $mod['param']);
		if ($rs['errno']) {
			$this->_error(L('pls__component12__todayTopic__apiError'), $rs['err'], $rs['errno']);
			//$this->_error('components/todayTopic.getTopicWB 返回API错误：'. $rs['err']. '('. $rs['errno']. ')');
			return;
	 	}elseif(!is_array($rs['rst']) || empty($rs['rst'])){
			$this->_error(L('pls_component12__todayTopic__dbError'));
			return;
	 	}
		
		
		// 设置缓存
		$content = TPL::module('component/component_'.$mod['component_id'], array('mod'=>$mod, 'rs'=>$rs), false);
		$wbList  = F('format_weibo', $rs['rst']);
		if (ENABLE_CACHE && $content) 
		{
			CACHE::set($cacheKey, $content, $cacheTime);
			CACHE::set($wbListKey, $wbList, $cacheTime);
		}
		
		echo $content;
		return array('cls'=>'wblist', 'list'=>$wbList );
	}
	
	
}
